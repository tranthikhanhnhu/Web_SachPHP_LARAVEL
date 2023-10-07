<?php

namespace App\Http\Controllers\Admin;

use App\Filters\Products\ByCategory;
use App\Filters\Products\ByKeyword;
use App\Filters\Products\ByOrigins;
use App\Filters\Products\ByPublishers;
use App\Filters\Products\ByStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Category;
use App\Models\Origin;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductInCategory;
use App\Models\Publisher;
use App\Models\RentPrice;
use App\Models\Review;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Pipeline;
use Illuminate\Support\Str;
use Gumlet\ImageResize;

class ProductsController extends Controller
{
    public function index()
    {
        $orderBy = [];

        if (!is_null(request()->sort_by)) {
            switch (request()->sort_by) {
                case 0:
                    $orderBy = ['created_at', 'desc'];
                    break;
                case 1:
                    $orderBy = ['created_at', 'asc'];
                    break;
            }
        }

        $pipelines = [
            ByKeyword::class,
            ByStatus::class,
            ByOrigins::class,
            ByCategory::class,
            ByPublishers::class,
        ];

        $pipeline = Pipeline::send(Product::query())
            ->through($pipelines)
            ->thenReturn();

        if ($orderBy) {
            $products = $pipeline->orderBy($orderBy[0], $orderBy[1])->paginate(10);
        } else {
            $products = $pipeline->paginate(10);
        }

        $categories = Category::where('status', 1)->get();
        $publishers = Publisher::where('status', 1)->get();
        $origins = Origin::where('status', 1)->get();

        return view('admin.pages.products.index', [
            'products' => $products,
            'categories' => $categories,
            'publishers' => $publishers,
            'origins' => $origins
        ]);
    }
    public function store(StoreProductRequest $request)
    {

        // create new product
        $product = Product::create($this->getProductArray($request, 0));

        // handle upload images
        $this->handleInputImage($request->front_cover, $product->id, 1);
        $this->handleInputImage($request->back_cover, $product->id, 2);
        if ($request->hasFile('image_urls')) {
            foreach ($request->image_urls as $image) {
                $this->handleInputImage($image, $product->id);
            }
        }

        // handle add categories
        foreach ($request->categories_id as $category_id) {
            $product->categories()->attach($category_id);
        }

        // handle add rent prices
        $this->handleCreateUpdateRentPrice($product->id, $request, 0);

        // end
        $msg = '<div class="alert alert-success alert-dismissible">Product created successfully</div>';

        return redirect()->route('admin.products.index')->with('message', $msg);
    }
    public function create()
    {
        $origins = Origin::where('status', 1)->get();
        $publishers = Publisher::where('status', 1)->get();
        $categories = Category::where('status', 1)->get();
        return view('admin.pages.products.create', [
            'categories' => $categories,
            'origins' => $origins,
            'publishers' => $publishers,
        ]);
    }
    public function show(Product $product)
    {

        $reviews = Review::where('product_id', $product->id)->paginate(10);

        return view('admin.pages.products.show', [
            'product' => $product,
            'reviews' => $reviews,
        ]);
    }
    public function update(UpdateProductRequest $request, Product $product)
    {

        $check = $product->update($this->getProductArray($request, 1));

        // handle update categories
        ProductInCategory::where('product_id', $product->id)->delete();
        foreach ($request->categories_id as $category_id) {
            $product->categories()->attach($category_id);
        }

        // handle update images
        if ($request->hasFile('front_cover')) {
            unlink(public_path('images/products/') . $product->productImages->firstWhere('type', 1)->image_url);
            $this->handleInputImage($request->front_cover, $product->id, 1, true);
        }
        if ($request->hasFile('back_cover')) {
            unlink(public_path('images/products/') . $product->productImages->firstWhere('type', 2)->image_url);
            $this->handleInputImage($request->back_cover, $product->id, 2, true);
        }
        if ($request->hasFile('image_urls')) {
            foreach ($product->productImages->where('type', 0) as $image) {
                unlink(public_path('images/products/') . $image->image_url);
            }
            foreach ($request->image_urls as $image) {
                $this->handleInputImage($image, $product->id, 0, true);
            }
        }

        // handle update rent prices
        $this->handleCreateUpdateRentPrice($product->id, $request, 1);

        if ($check) {
            $msg = '<div class="alert alert-success alert-dismissible">Product updated successfully</div>';
        } else {
            $msg = '<div class="alert alert-danger alert-dismissible">Product updated failed</div>';
        }

        return redirect()->route('admin.products.index')->with('message', $msg);
    }
    public function destroy(Product $product)
    {

        foreach ($product->productImages as $image) {
            unlink(public_path('images/products/') . $image->image_url);
        }

        $check = $product->delete();

        if ($check) {
            $msg = '<div class="alert alert-success alert-dismissible">Product deleted successfully</div>';
        } else {
            $msg = '<div class="alert alert-danger alert-dismissible">Product deleted failed</div>';
        }

        return redirect()->route('admin.products.index')->with('message', $msg);
    }
    public function edit(Product $product)
    {
        $origins = Origin::where('status', 1)->get();
        $publishers = Publisher::where('status', 1)->get();
        $categories = Category::all();

        return view('admin.pages.products.edit', [
            'product' => $product,
            'categories' => $categories,
            'origins' => $origins,
            'publishers' => $publishers,
        ]);
    }

    public function changeStatus(Request $request, Product $product)
    {
        $check = $product->update([
            'status' => $request->status,
        ]);

        $status_word = $request->status == 0 ? 'hidden' : 'showed';
        if ($check) {
            $msg = '<div class="alert alert-success alert-dismissible">Product ' . $status_word . ' successfully</div>';
        } else {
            $msg = '<div class="alert alert-danger alert-dismissible">Product ' . $status_word . ' failed</div>';
        }

        return redirect()->back()->with('message', $msg);
    }

    public function getSlug(Request $request)
    {
        $slug = Str::slug($request->name);
        return $slug;
    }

    public function getRentPrices(Request $request)
    {
        $price = $request->price;
        $rent_prices = [
            '1' => number_format($price / 10, 0, '.', ''),
            '7' =>  number_format($price / 5, 0, '.', ''),
            '30' =>  number_format($price / 3, 0, '.', ''),
            '90' =>  number_format($price / 2, 0, '.', ''),
        ];
        return response()->json($rent_prices);
    }

    public function handleInputImage($image, $productId, $type = 0, $update = null)
    {

        // get image from request
        $originalName = $image->getClientOriginalName();
        $fileName = pathinfo($originalName, PATHINFO_FILENAME);
        $extension = $image->getClientOriginalExtension();
        $fileName = $fileName . '_' . time() . '.' . $extension;
        $image->move(public_path('images/products'), $fileName);

        // resize the image
        $image = imagecreatefromjpeg(public_path('images/products/') . $fileName);
        $width = imagesx($image);
        $height = imagesy($image);
        $new_width = max($width, $height);
        $new_height = max($width, $height);
        $new_image = imagecreatetruecolor($new_width, $new_height);
        $white = imagecolorallocate($new_image, 255, 255, 255);
        imagefill($new_image, 0, 0, $white);
        $dst_x = ($new_width - $width) / 2;
        $dst_y = ($new_height - $height) / 2;
        imagecopy($new_image, $image, $dst_x, $dst_y, 0, 0, $width, $height);
        imagejpeg($new_image, public_path('images/products/') . $fileName, 100);

        if (!is_null($update)) {
            ProductImage::where('type', $type)
            ->where('product_id', $productId)
            ->delete();
        }
        
        // create in database
        ProductImage::create([
            'product_id' => $productId,
            'image_url' => $fileName,
            'type' => $type,
            'created_at' => Carbon::now(),
        ]);
    }

    public function handleCreateUpdateRentPrice($productId, $request, $type) {
        //$type:  0 = create; 1 = update
        if ($type===0) {
            RentPrice::create([
                'product_id' => $productId,
                'number_of_days' => 1,
                'price' => $request->rent_price_1,
                'created_at' => Carbon::now(),
            ]);
            RentPrice::create([
                'product_id' => $productId,
                'number_of_days' => 7,
                'price' => $request->rent_price_7,
                'created_at' => Carbon::now(),
            ]);
            RentPrice::create([
                'product_id' => $productId,
                'number_of_days' => 30,
                'price' => $request->rent_price_30,
                'created_at' => Carbon::now(),
            ]);
            RentPrice::create([
                'product_id' => $productId,
                'number_of_days' => 90,
                'price' => $request->rent_price_90,
                'created_at' => Carbon::now(),
            ]);
        } else if ($type===1) {
            RentPrice::where('product_id', $productId)->where('number_of_days', 1)->first()->update([
                'price' => $request->rent_price_1,
                'updated_at' => Carbon::now(),
            ]);
            RentPrice::where('product_id', $productId)->where('number_of_days', 7)->first()->update([
                'price' => $request->rent_price_7,
                'updated_at' => Carbon::now(),
            ]);
            RentPrice::where('product_id', $productId)->where('number_of_days', 30)->first()->update([
                'price' => $request->rent_price_30,
                'updated_at' => Carbon::now(),
            ]);
            RentPrice::where('product_id', $productId)->where('number_of_days', 90)->first()->update([
                'price' => $request->rent_price_90,
                'updated_at' => Carbon::now(),
            ]);
        }
    }

    public function getProductArray($request, $type)
    {
        //$type: 0 = create; 1 = update
        $product_array = [
            'name' => $request->name,
            'slug' => $request->slug,
            'description' => $request->description,
            'short_description' => $request->short_description,
            'status' => $request->status,
            'price' => $request->price,
            'book_layout' => $request->book_layout,
            'author' => $request->author,
            'height' => $request->height,
            'width' => $request->width,
            'thickness' => $request->thickness,
            'number_of_pages' => $request->number_of_pages,
            'publish_year' => $request->publish_year,
            'publisher_id' => $request->publisher_id,
            'origin_id' => $request->origin_id,
            'weight' => $request->weight,
            'quantity' => $request->quantity,
            $type === 0 ? 'created_at' : 'updated_at' => Carbon::now(),
        ];

        return $product_array;
    }

    public function deleteReview(Review $review) {

        $check = $review->delete();

        if ($check) {
            $msg = '<div class="alert alert-success alert-dismissible">Review deleted successfully</div>';
        } else {
            $msg = '<div class="alert alert-danger alert-dismissible">Review deleted failed</div>';
        }

        return redirect()->back()->with('message', $msg);
    }
}
