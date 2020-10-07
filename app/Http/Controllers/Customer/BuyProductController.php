<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Product;
use App\Order;
use App\OrderDetail;
use App\Custommer;

class BuyProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $order = new Order;
        $order->user_id = 1;
        $order->amount = $request->amount;
        $order->ship_name = $request->ship_name;
        $order->ship_address = $request->ship_address;
        $order->phone = $request->phone;
        $order->email = $request->email;
        $order->sku = $request->sku;
        $order->status = $request->status;

        $idorder = Order::all();
        $orderDetail = new OrderDetail;
        $orderDetail->order_id = count($idorder) + 1;
        $orderDetail->product_id = $request->product_id;
        $orderDetail->name = $request->name;
        $orderDetail->price = $request->price;
        $orderDetail->sku = $request->sku;
        $orderDetail->quantity = $request->quantity;
        $orderDetail->type_ship_id = $request->type_ship_id;
        $result = $orderDetail->save();
        $resultOrder = $order->save();
        dd($result, $resultOrder);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
