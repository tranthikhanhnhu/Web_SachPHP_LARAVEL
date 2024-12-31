<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Order;

class AdminController extends Controller
{
    //
    public function index() {
        
        $dataOrders = DB::table('products_in_orders')
        ->selectRaw('status, count(status) as number')
        ->groupBy('status')->get();
        $arrayDatas = [];
        $arrayDatas[] = ['Status', 'Number'];
        foreach($dataOrders as $data){
            $arrayDatas[] = [$data->status, $data->number];
        }

        return view('admin.pages.index.index', [
            'arrayDatas' => $arrayDatas,
        ]);
    }

    //
    public function vnIndex() {
        
        $dataOrders = DB::table('products_in_orders')
        ->selectRaw('status, count(status) as number')
        ->groupBy('status')->get();
        $arrayDatas = [];
        $arrayDatas[] = ['Status', 'Number'];
        foreach($dataOrders as $data){
            $arrayDatas[] = [$data->status, $data->number];
        }

        return view('admin.vn_pages.index.index', [
            'arrayDatas' => $arrayDatas,
        ]);
    }

    public function orderRevenue() {
        $orders = Order::all();
        $totalRevenue = $orders->sum('total');
    
        return view('admin.pages.index.index', [
            'totalRevenue' => $totalRevenue,
        ]);
    }
    
}
