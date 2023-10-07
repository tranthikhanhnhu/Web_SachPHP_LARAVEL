@extends('admin.layout.master')

@section('content')
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Edit Product</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            {{Breadcrumbs::render('admin.products.edit', $product)}}
                        </ol>
                    </div>

                </div>
            </div>
        </div>
        <!-- end page title -->


        <div class="row">
            <div class="col-xxl-12">
                <div class="card">
                    <div class="card-header align-items-center d-flex">
                        <h4 class="card-title mb-0 flex-grow-1">Product Informations</h4>
                    </div><!-- end card header -->
                    <div class="card-body">
                        <div class="live-preview">
                            <form action="{{ route('admin.products.update', ['product' => $product->id]) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="row mb-3">
                                    <div class="col-lg-3">
                                        <label for="name-input" class="form-label">Name</label>
                                    </div>
                                    <div class="col-lg-9">
                                        <input type="text" name="name" class="form-control" id="name-input"
                                            placeholder="Enter product name" 
                                            value="{{ old('name') ?? $product->name }}">
                                        @error('name')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-lg-3">
                                        <label for="slug-input" class="form-label">Slug</label>
                                    </div>
                                    <div class="col-lg-9">
                                        <input type="text" name="slug" class="form-control" id="slug-input"
                                            placeholder="Enter product slug" value="{{ old('slug') ?? $product->slug }}">
                                        @error('slug')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-lg-3">
                                        <label for="categoriesInput" class="form-label">Categories</label>
                                    </div>
                                    <div class="col-lg-9">
                                        <div class="row">
                                            @foreach($categories as $key => $category)
                                                <div class="col-3">
                                                    <input 
                                                        class="form-check-input" 
                                                        type="checkbox" 
                                                        name="categories_id[]" 
                                                        id="formCheck{{$key}}" 
                                                        value="{{$category->id}}"
                                                        @if((old('categories_id') && in_array($category->id, old('categories_id'))) 
                                                        || in_array($category->id, array_column($product->categories->all(), 'id')))
                                                         checked 
                                                        @endif>
                                                    <label 
                                                    class="form-check-label" 
                                                    for="formCheck{{$key}}" >
                                                        {{$category->name}}
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>
                                        @error('categories')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-lg-3">
                                        <label for="short_description" class="form-label">Short Description</label>
                                    </div>
                                    <div class="col-lg-9">
                                        <textarea name="short_description" class="form-control" id="short_description"placeholder="Enter short description">{{
                                            old('short_description') ?? $product->short_description 
                                        }}</textarea>
                                        @error('short_description')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-lg-3">
                                        <label for="description" class="form-label">Description</label>
                                    </div>
                                    <div class="col-lg-9">
                                        <textarea name="description" name="description" id="editor">{!! old('description') ?? $product->description !!}</textarea>
                                        @error('description')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-lg-3">
                                        <label for="price-input" class="form-label">Price</label>
                                    </div>
                                    <div class="col-lg-9">
                                        <input type="number" name="price" class="form-control" id="price-input"
                                            placeholder="Enter product price" value="{{ old('price') ?? $product->price }}">
                                        @error('price')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-lg-3">
                                        <label for="rentPriceInput1" class="form-label">1 Day Rent Price</label>
                                    </div>
                                    <div class="col-lg-9">
                                        <input type="number" step="0.01" name="rent_price_1" class="form-control" id="rentPriceInput1"
                                            placeholder="Enter 1 day rent price" 
                                            value="{{ old('rent_price_1') ?? ($product->rentPrice->where('number_of_days', 1)->first()->price ?? '') }}">
                                        @error('rent_price_1')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-lg-3">
                                        <label for="rentPriceInput7" class="form-label">7 Day Rent Price</label>
                                    </div>
                                    <div class="col-lg-9">
                                        <input type="number" step="0.01" name="rent_price_7" class="form-control" id="rentPriceInput7"
                                            placeholder="Enter 7 day rent price" 
                                            value="{{ old('rent_price_7') ?? ($product->rentPrice->where('number_of_days', 7)->first()->price ?? '') }}">
                                        @error('rent_price_7')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-lg-3">
                                        <label for="rentPriceInput30" class="form-label">30 Day Rent Price</label>
                                    </div>
                                    <div class="col-lg-9">
                                        <input type="number" step="0.01" name="rent_price_30" class="form-control" id="rentPriceInput30"
                                            placeholder="Enter 30 day rent price" 
                                            value="{{ old('rent_price_30') ?? ($product->rentPrice->where('number_of_days', 30)->first()->price ?? '') }}">
                                        @error('rent_price_30')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-lg-3">
                                        <label for="rentPriceInput90" class="form-label">90 Day Rent Price</label>
                                    </div>
                                    <div class="col-lg-9">
                                        <input type="number" step="0.01" name="rent_price_90" class="form-control" id="rentPriceInput90"
                                            placeholder="Enter 90 day rent price" 
                                            value="{{ old('rent_price_90') ?? ($product->rentPrice->where('number_of_days', 90)->first()->price ?? '') }}">
                                        @error('rent_price_90')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-lg-3">
                                        <label for="dateInput" class="form-label">Book Layout</label>
                                    </div>
                                    <div class="col-lg-9 d-flex">
                                        <div class="col-lg-6 form-radio-primary" >
                                            <input 
                                            class="form-check-input" 
                                            type="radio" name="book_layout" value="0"
                                            id="book_layout1"
                                            @if(is_null(old('book_layout')))
                                            {{$product->book_layout === 0 ? 'checked' : ''}}
                                            @else
                                            {{(int)old('book_layout') === 0 ? 'checked' : ''}}
                                            @endif
                                            >
                                            <label class="form-check-label" for="book_layout1">
                                                Paperback
                                            </label>
                                        </div>
                                        <div class="col-lg-6 form-radio-primary">
                                            <input class="form-check-input" type="radio" name="book_layout"
                                                value="1" id="book_layout2"
                                                @if(is_null(old('book_layout')))
                                                {{$product->book_layout === 1 ? 'checked' : ''}}
                                                @else
                                                {{(int)old('book_layout') === 1 ? 'checked' : ''}}
                                                @endif>
                                            <label class="form-check-label" for="book_layout2">
                                                Hardcover
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-lg-3">
                                        <label for="authorInput" class="form-label">Author</label>
                                    </div>
                                    <div class="col-lg-9">
                                        <input type="text" name="author" class="form-control" id="author-input"
                                            placeholder="Enter product author" 
                                            value="{{ old('author') ?? $product->author }}">
                                        @error('author')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-lg-3">
                                        <label for="quantityInput" class="form-label">Quantity</label>
                                    </div>
                                    <div class="col-lg-9">
                                        <input type="number" name="quantity" class="form-control" id="quantity-input"
                                            placeholder="Enter product quantity" value="{{ old('quantity') ?? $product->quantity }}">
                                        @error('quantity')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-lg-3">
                                        <label for="publisherInput" class="form-label">Publisher</label>
                                    </div>
                                    <div class="col-lg-9">
                                        <select class="form-control" name="publisher_id" id="publisherInput">
                                            <option value="">---Select Publisher---</option>
                                            @foreach ($publishers as $publisher)
                                                <option value="{{$publisher->id}}"
                                                @if(is_null(old('publisher_id')))
                                                {{$product->publisher_id === $publisher->id ? 'selected' : ''}}
                                                @else
                                                {{(int)old('publisher_id') === $publisher->id ? 'selected' : ''}}
                                                @endif
                                                >{{$publisher->name}}</option>
                                            @endforeach
                                        </select>
                                        @error('publisher_id')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-lg-3">
                                        <label for="originInput" class="form-label">Origin</label>
                                    </div>
                                    <div class="col-lg-9">
                                        <select class="form-control" name="origin_id" id="originInput">
                                            <option value="">---Select Origin---</option>
                                            @foreach ($origins as $origin)
                                                <option value="{{$origin->id}}" 
                                                @if(is_null(old('origin_id')))
                                                {{$product->origin_id === $origin->id ? 'selected' : ''}}
                                                @else
                                                {{(int)old('origin_id') === $origin->id ? 'selected' : ''}}
                                                @endif
                                                >{{$origin->name}}</option>
                                            @endforeach
                                        </select>
                                        @error('origin_id')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-lg-3">
                                        <label for="dimensionsInput" class="form-label">Product Dimensions</label>
                                    </div>
                                    <div class="col-lg-2">
                                        <input type="number" name="height" step="0.01" class="form-control" id="height-input"
                                            placeholder="Enter product height(cm)" 
                                            value="{{ old('height') ?? $product->height }}">
                                        @error('height')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="col-lg-2">
                                        <input type="number" name="width" step="0.01" class="form-control" id="width-input"
                                            placeholder="Enter product width(cm)" 
                                            value="{{ old('width') ?? $product->width }}">
                                        @error('width')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="col-lg-3">
                                        <input type="number" name="weight" step="0.01" class="form-control" id="weight-input"
                                            placeholder="Enter product weight(mg)" value="{{ old('weight') ?? $product->weight }}">
                                        @error('width')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="col-lg-2">
                                        <input type="number" name="thickness" step="0.01" class="form-control" id="thickness-input"
                                            placeholder="Enter product thickness(cm)" 
                                            value="{{ old('thickness') ?? $product->thickness }}">
                                        @error('thickness')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-lg-3">
                                        <label for="numberOfPageInput" class="form-label">Number Of Pages</label>
                                    </div>
                                    <div class="col-lg-9">
                                        <input type="number" name="number_of_pages" class="form-control" id="numberOfPageinput"
                                            placeholder="Enter product's number of pages" 
                                            value="{{ old('number_of_pages') ?? $product->number_of_pages }}">
                                        @error('number_of_pages')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-lg-3">
                                        <label for="publishYearInput" class="form-label">Publish Year</label>
                                    </div>
                                    <div class="col-lg-9">
                                        <input type="number" name="publish_year" class="form-control" id="publishYearInput"
                                            placeholder="Enter product's publish year" 
                                            value="{{ old('publish_year') ?? $product->publish_year }}">
                                        @error('publish_year')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-lg-3">
                                        <label for="dateInput" class="form-label">Status</label>
                                    </div>
                                    <div class="col-lg-9 d-flex">
                                        <div class="col-lg-6 form-radio-success">
                                            <input class="form-check-input" type="radio" name="status" value="1"
                                                id="status1"
                                                @if(!is_null(old('status')) && (int)old('status') === 1)
                                                checked
                                                @elseif(is_null(old('status')) && $product->status === 1) 
                                                checked 
                                                @endif>
                                            <label class="form-check-label" for="status1">
                                                Active
                                            </label>
                                        </div>
                                        <div class="col-lg-6 form-radio-danger">
                                            <input class="form-check-input danger" type="radio" name="status"
                                            value="0" id="status2"
                                            @if(!is_null(old('status')) && (int)old('status') === 0)
                                            checked
                                            @elseif(is_null(old('status')) && $product->status === 0) 
                                            checked 
                                            @endif>
                                            <label class="form-check-label" for="status2">
                                                Blocked
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-lg-3">
                                        <label for="dateInput" class="form-label">Front Cover Picture</label>
                                    </div>
                                    <div class="col-lg-9">
                                        <input class="form-control" id="formSizeDefault" name="front_cover"
                                            type="file">
                                            @error('front_cover')
                                                <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-lg-3">
                                        <label for="dateInput" class="form-label">Back Cover Picture</label>
                                    </div>
                                    <div class="col-lg-9">
                                        <input class="form-control" id="formSizeDefault" name="back_cover"
                                            type="file">
                                            @error('back_cover')
                                                <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-lg-3">
                                        <label for="dateInput" class="form-label">Product Pictures</label>
                                    </div>
                                    <div class="col-lg-9">
                                        <input class="form-control" id="formSizeDefault" name="image_urls[]"
                                            type="file" multiple>
                                    </div>
                                </div>
                                <div class="text-end">
                                    <button type="submit" class="btn btn-primary">Update</button>
                                </div>
                            </form>
                        </div>
                        <div class="d-none code-view">
                        </div>
                    </div>
                </div>
            </div>
            <!--end row-->

        </div>
    @endsection


@section('custom-js')


<script type="text/javascript">

$(document).ready(function() {
        $('#name-input').on('change keyup', function() {
            let name = $(this).val();
            $.ajax({
                method: 'POST',
                url: "{{route('admin.products.getSlug')}}",
                data: {
                    name: name,
                    _token: "{{csrf_token()}}"
                },
                success: function(res) {
                    $('#slug-input').val(res);
                },
                error: function(res) {

                }
            })
        });
        $('#price-input').on('keyup', function() {
            let price = $(this).val();
            $.ajax({
                method: 'POST',
                url: "{{route('admin.products.getRentPrices')}}",
                data: {
                    price: price,
                    _token: "{{csrf_token()}}"
                },
                success: function(res) {
                    $('#rentPriceInput1').val(res['1']);
                    $('#rentPriceInput7').val(res['7']);
                    $('#rentPriceInput30').val(res['30']);
                    $('#rentPriceInput90').val(res['90']);
                },
                error: function(res) {

                }
            })
        });
    });

    ClassicEditor
    .create( document.querySelector( '#editor' ) )
    .catch( error => {
        console.error( error );
    } );

</script>
@endsection