<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePublisherRequest;
use App\Http\Requests\UpdatePublisherRequest;
use App\Models\Publisher;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Pipeline;
use App\Filters\Publishers\ByKeyword;
use App\Filters\Publishers\ByStatus;
use Illuminate\Support\Str;

class PublishersController extends Controller
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

        $pipeline = Pipeline::send(Publisher::query())
        ->through($pipelines)
        ->thenReturn();


        if($orderBy) {
            $publishers = $pipeline->orderBy($orderBy[0], $orderBy[1])->paginate(10);
        } else {
            $publishers = $pipeline->paginate(10);
        }

        return view('admin.pages.publishers.index', [
            'publishers' => $publishers,
        ]);
    }
    public function store(Request $request) {


        $request->validate([
            'name' => 'required|unique:publishers,name',
            'slug' => 'required|unique:publishers,slug'
        ]);

        $check = Publisher::create([
            'name' => $request->name,
            'slug' => $request->slug,
            'status' => $request->status,
            'created_at' => Carbon::now(),
        ]);

        $msg = $check ? 'Publisher created successfully' : 'Publisher created failed';

        return redirect()->route('admin.publishers.index')->with('message', $msg);
    }
    public function create() {
        return view('admin.pages.publishers.create');
    }
    public function show(Publisher $publisher) {
        return view('admin.pages.publishers.show', [
            'publisher' => $publisher
        ]);
    }
    public function update(Request $request, Publisher $publisher) {

        $request->validate([
        'name' => 'required|unique:publishers,name,'.$publisher->id,
        'slug' => 'required|unique:publishers,slug,'.$publisher->id,
        ]);
    
        $update_publisher = $publisher->update([
            'name' => $request->name,
            'slug' => $request->slug,
            'status' => $request->status,
            'updated_at' => Carbon::now(),
        ]);

        $msg = $update_publisher ? 'Publisher updated successfully' : 'Publisher updated failed';

        return redirect()->route('admin.publishers.index')->with('message', $msg);
    }
    public function destroy(Publisher $publisher) {

        $check = $publisher->delete();

        $msg = $check ? 'Publisher deleted successfully' : 'Publisher deleted fail';

        return redirect()->route('admin.publishers.index')->with('message', $msg);
        
    }
    public function edit(Publisher $publisher) {
        return view('admin.pages.publishers.edit', ['publisher' => $publisher]);
    }

    public function changeStatus(Request $request, Publisher $publisher) {
        $check = $publisher->update([
            'status' => $request->status,
        ]);

        if ($request->status == 0) {
            $msg = $check ? 'Publisher hidden successfully' : 'Publisher hidden fail';
        } elseif ($request->status == 1) {
            $msg = $check ? 'Publisher showed successfully' : 'Publisher showed fail';
        } else {
            $msg = 'Action failed';
        }
    
        return redirect()->route('admin.publishers.index')->with('message', $msg);
    }

    public function getSlug(Request $request) {
        $slug = Str::slug($request->name);
        return $slug;
    }
}
