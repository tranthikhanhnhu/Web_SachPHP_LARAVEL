<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Pipeline;
use App\Filters\Categories\ByKeyword;
use App\Filters\Categories\ByStatus;
use Illuminate\Support\Str;

class CategoriesController extends Controller
{
    //
    public function index() { 

        $orderBy = [];

        if(!is_null(request()->sort_by)) {
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
        ];

        $pipeline = Pipeline::send(Category::query())
        ->through($pipelines)
        ->thenReturn();


        if($orderBy) {
            $categories = $pipeline->orderBy($orderBy[0], $orderBy[1])->paginate(10);
        } else {
            $categories = $pipeline->paginate(10);
        }

        return view('admin.pages.categories.index', [
            'categories' => $categories,
        ]);
    }
    public function store(StoreCategoryRequest $request) {


        $check = Category::create([
            'name' => $request->name,
            'slug' => $request->slug,
            'status' => $request->status,
            'created_at' => Carbon::now(),
        ]);

        $msg = $check
        ? '<div class="alert alert-success alert-dismissible">Category created successfully</div>' 
        : '<div class="alert alert-danger alert-dismissible">Category created failed</div>';

        return redirect()->route('admin.categories.index')->with('message', $msg);
    }
    public function create() {
        return view('admin.pages.categories.create');
    }
    public function show(Category $category) {
        return view('admin.pages.categories.show', [
            'category' => $category
        ]);
    }
    public function update(UpdateCategoryRequest $request, Category $category) {
    
        $update_category = $category->update([
            'name' => $request->name,
            'slug' => $request->slug,
            'status' => $request->status,
            'updated_at' => Carbon::now(),
        ]);

        $msg = $update_category 
        ? '<div class="alert alert-success alert-dismissible">Category updated successfully</div>' 
        : '<div class="alert alert-danger alert-dismissible">Category updated failed</div>';

        return redirect()->route('admin.categories.index')->with('message', $msg);
    }
    public function destroy(Category $category) {

        $check = $category->delete();

        $msg = $check
        ? '<div class="alert alert-success alert-dismissible">Category deleted successfully</div>' 
        : '<div class="alert alert-danger alert-dismissible">Category delete failed</div>';

        return redirect()->route('admin.categories.index')->with('message', $msg);
        
    }
    public function edit(Category $category) {
        return view('admin.pages.categories.edit', ['category' => $category]);
    }

    public function changeStatus(Request $request, Category $category) {
        $check = $category->update([
            'status' => $request->status,
        ]);

        $status_word = $request->status == 0 ? 'hidden' : 'showed';
        if ($check) {
            $msg = '<div class="alert alert-success alert-dismissible">Category ' . $status_word . ' successfully</div>';
        } else {
            $msg = '<div class="alert alert-danger alert-dismissible">Category ' . $status_word . ' failed</div>';
        }
    
        return redirect()->back()->with('message', $msg);
    }

    public function getSlug(Request $request) {
        $slug = Str::slug($request->name);
        return $slug;
    }
}
