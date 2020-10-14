<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Product;
use App\Custommer;
use App\TypeShipping;
use App\Order;
use App\OrderDetail;
use DB;
use Cookie;
use Redirect;

class OrderController extends Controller
{
    public function OderProducts(Request $req)
    {
        $lst = $req->all();
        $order = new Order;
        $user = auth('api')->user()->id;
        $order->user_id = $user;
        $order->shop_id = cookie('shop_id', $req->shop_id, 30);
        $order->amount = $req->amount;
        $order->total_bill = $req->total_bill;
        $order->order_code = $req->order_code;
        $order->type_ship_id = $req->type_ship_id;
        if (array_key_exists('status_ship', $lst)) {
            $order->status_ship = $lst['status_ship'];
        }
        $order->fees_ship = $req->fees_ship;
        if (array_key_exists('status_order', $lst)) {
            $order->status_order = $lst['status_order'];
        }
        $order->voucher = $req->voucher;
        $order->ship_address = $req->ship_address;
        $order->phone = $req->phone;
        $order->email = $req->email;
        $order->fees_ship = $req->fees_ship;
        if (array_key_exists('deleted_by', $lst)) {
            $order->deleted_by = $lst['deleted_by'];
        }
        $confirm_order = $order->save();        
        $orderDetail = new OrderDetail();
        
        $orderDetail->order_id = $order->id;
        $orderDetail->product_id = $req->product_id;
        $orderDetail->product_classify = $req->product_classify;
        $orderDetail->quantity = $req->quantity;
        $orderDetail->deleted_by = $req->deleted_by;
        $confirm_orderDetail = $orderDetail->save();
       
        if($confirm_orderDetail == 1 && $confirm_order == 1)
        {
            $result = [

                'status' => true,
    
                'code' => 200,
    
                'message'=> trans('message.oder_confirm_sucess')
    
            ];
        }
        else
        {
            $result = [

                'status' => true,
    
                'code' => 200,
    
                'message'=> trans('message.oder_confirm_unsucess')
    
            ];
        }
        return response()->json($result);

    }

    public function SameProductOfShop($id)
    {
        $productOrder = Product::find($id);
        $shopID = $productOrder->shop_id;
        $sameProducts = Product::where('shop_id', $shopID)
                                ->get();
        if(count($sameProducts) == 0)
        {
            $result = [

                'status' => true,
    
                'code' => 200,
    
                'message'=> trans('message.not_same_products'),

                'data' => null
    
            ];
        }
        else
        {
            $result = [

                'status' => true,
    
                'code' => 200,
    
                'message'=> trans('message.the_same_products'),

                'data' => $sameProducts
    
            ];
        }
        return response()->json($result);
    }

    public function SameProducts($id)
    {
        $productOrder = Product::find($id);
        $namePro = $productOrder->name;
        $sameProducts = Product::where('name', 'LIKE', '%'.$namePro.'%')->get();
        if(count($sameProducts) == 0)
        {
            $result = [

                'status' => true,
    
                'code' => 200,
    
                'message'=> trans('message.not_same_products'),

                'data' => null
    
            ];
        }
        else
        {
            $result = [

                'status' => true,
    
                'code' => 200,
    
                'message'=> trans('message.the_same_products'),

                'data' => $sameProducts
    
            ];
        }
        return response()->json($result);
    }

    public function ProductsJustForYou()
    {
        //Random products just for you 
        $salePro = Product::inRandomOrder()->limit(24)->get();
        $result = [

            'status' => true,

            'code' => 200,

            'message'=> trans('message.get_product_sucess'),

            'data' => $salePro

        ];
        return response()->json($result);
    }

    public function SaleProducts()
    {
        $sumquantity = OrderDetail::selectRaw('SUM(quantity) as sum_quanity, product_id')
        ->groupBy('product_id')->limit(10)->get();
        $arrProduct = [];
        for ($i = 0; $i < count($sumquantity); $i++) {
            $products = Product::where('id',$sumquantity[$i]->product_id)->get();
            array_push($arrProduct, $products);
        }
        if($arrProduct == null)
        {
            $result = [

                'status' => true,
    
                'code' => 200,
    
                'message'=> trans('message.get_product_unsucess'),
    
                'data' => $arrProduct
    
            ];
        }
        else
        {
            $result = [

                'status' => true,
    
                'code' => 200,
    
                'message'=> trans('message.get_product_sucess'),
    
                'data' => $arrProduct
    
            ];
        }
        return response()->json($result);
    }

}
