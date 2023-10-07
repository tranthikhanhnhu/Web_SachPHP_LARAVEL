<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOriginRequest;
use App\Http\Requests\UpdateOriginRequest;
use App\Models\Origin;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Pipeline;
use App\Filters\Origins\ByKeyword;
use App\Filters\Origins\ByStatus;
use Illuminate\Support\Str;

class OriginsController extends Controller
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

        $pipeline = Pipeline::send(Origin::query())
        ->through($pipelines)
        ->thenReturn();


        if($orderBy) {
            $origins = $pipeline->orderBy($orderBy[0], $orderBy[1])->paginate(10);
        } else {
            $origins = $pipeline->paginate(10);
        }

        return view('admin.pages.origins.index', [
            'origins' => $origins,
        ]);
    }
    public function store(Request $request) {

        $request->validate([
            'name' => 'required|unique:origins,name',
            'slug' => 'required|unique:origins,slug'
        ]);

        $check = Origin::create([
            'name' => $request->name,
            'slug' => $request->slug,
            'status' => $request->status,
            'created_at' => Carbon::now(),
        ]);

        $msg = $check ? 'Origin created successfully' : 'Origin created failed';

        return redirect()->route('admin.origins.index')->with('message', $msg);
    }
    public function create() {
        return view('admin.pages.origins.create');
    }
    public function show(Origin $origin) {
        return view('admin.pages.origins.show', [
            'origin' => $origin
        ]);
    }
    public function update(Request $request, Origin $origin) {
        
        $request->validate([
            'name' => 'required|unique:origins,name,'.$origin->id,
            'slug' => 'required|unique:origins,slug,'.$origin->id,
        ]);
    
        $update_origin = $origin->update([
            'name' => $request->name,
            'slug' => $request->slug,
            'status' => $request->status,
            'updated_at' => Carbon::now(),
        ]);

        $msg = $update_origin ? 'Origin updated successfully' : 'Origin updated failed';

        return redirect()->route('admin.origins.index')->with('message', $msg);
    }
    public function destroy(Origin $origin) {

        $check = $origin->delete();

        $msg = $check ? 'Origin deleted successfully' : 'Origin deleted fail';

        return redirect()->route('admin.origins.index')->with('message', $msg);
        
    }
    public function edit(Origin $origin) {
        return view('admin.pages.origins.edit', ['origin' => $origin]);
    }

    public function changeStatus(Request $request, Origin $origin) {
        $check = $origin->update([
            'status' => $request->status,
        ]);

        if ($request->status == 0) {
            $msg = $check ? 'Origin hidden successfully' : 'Origin hidden fail';
        } elseif ($request->status == 1) {
            $msg = $check ? 'Origin showed successfully' : 'Origin showed fail';
        } else {
            $msg = 'Action failed';
        }
    
        return redirect()->route('admin.origins.index')->with('message', $msg);
    }

    public function getSlug(Request $request) {
        $slug = Str::slug($request->name);
        return $slug;
    }
}
