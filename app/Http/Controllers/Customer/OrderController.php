<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
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
        $string = Cookie::get('order');
        $string = stripslashes($string);  
        $string = json_decode($string, true);
        $order = new Order;
        $user = auth('api')->user()->id;
        $order->user_id = $user;
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
        $order->ship_address = $req->ship_address;
        $order->phone = $req->phone;
        $order->email = $req->email;
        $order->fees_ship = $req->fees_ship;
        if (array_key_exists('deleted_by', $lst)) {
            $order->deleted_by = $lst['deleted_by'];
        }
        $confirm_order = $order->save();
        
        foreach($string as $key => $value)    
        {
            $orderDetail = new OrderDetail();
            $orderDetail->order_id = $order->id;
            $orderDetail->product_id = $string[$key]['item_id'];
            $orderDetail->shop_id = $string[$key]['shop_id'];
            $orderDetail->voucher = $req->input('voucher');
            $orderDetail->product_classify = $string[$key]['Classify'];
            $orderDetail->quantity = $string[$key]['quantity'];
            $orderDetail->deleted_by = $req->deleted_by;
            $confirm_orderDetail = $orderDetail->save();
        }    
        setcookie('order',null, 50);
       
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

    public function SameProductOfShop($slug)
    {
        $productOrder = Product::where('slug', $slug)->first();
        if($productOrder)
        {
            $shopID = $productOrder->shop_id;
            $sameProducts = Product::where('shop_id', $shopID)->get();
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
        }
        else
        {
            $result = [

                'status' => true,
    
                'code' => 200,
    
                'message'=> trans('message.not_same_products'),

                'data' => null
    
            ];
        }
        
        return response()->json($result);
    }

    public function SameProducts($slug)
    {
        $productOrder = Product::where('slug', $slug)->first();
        if($productOrder)
        {
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
        }
        else
        {
            $result = [

                'status' => true,
    
                'code' => 200,
    
                'message'=> trans('message.not_same_products'),

                'data' => null
    
            ];
        }
        
        return response()->json($result);
    }

    public function ProductsJustForYou()
    {
        //Random products just for you 
        $salePro = Product::inRandomOrder()->limit(12)->get();
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
    
                'data' => null
    
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

    public function ViewCart()
    {
        return  view('cart');
    }

    public function SetCookiesOrder(Request $req)
    {
        $lst = $req->all();
        if(isset($_COOKIE['order']))
        {
            $cookies_data = Cookie::get('order');
            $cookies_data = stripslashes($cookies_data);
            $cart_data = json_decode($cookies_data, true);
        }
        else
        {
            $cart_data = array();
        }
        if($cart_data == null)
        {
            $item_arr = array('Product_name' => $req->input('pro_name'),'price' => $req->input('price'),'Promotional_price' => $req->input('promotional_price'),'shop_id' => $req->input('shop_id'), 'item_id' => $req->input('id'),'Classify' => $req->input('classify'),'quantity' => (int)$req->input('quantity'));
            $cart_data[] = $item_arr;
        }
        else
        {
            $item_list = array_column($cart_data, 'item_id');
            $item_classfily = array_column($cart_data, 'Classify');
            $shop_id = array_column($cart_data, 'shop_id');
            if(in_array($req->input('id'), $item_list) && in_array($req->input('classify'), $item_classfily) && in_array($req->input('shop_id'), $shop_id))
            {
                foreach($cart_data as $key => $value)
                {
                    if($cart_data[$key]['item_id'] == $req->input('id'))
                    {
                        $cart_data[$key]['quantity'] = $cart_data[$key]['quantity'] + $req->input('quantity');
                    }
                }
            }
            else
            {
                $item_arr = array('Product_name' => $req->input('pro_name'),'price' => $req->input('price'),'Promotional_price' => $req->input('promotional_price'),'shop_id' => $req->input('shop_id'), 'item_id' => $req->input('id'),'Classify' => $req->input('classify'),'quantity' => (int)$req->input('quantity'));
                $cart_data[] = $item_arr;
            }
        }
        $item_data = json_encode($cart_data, JSON_UNESCAPED_UNICODE);
        $cart = json_decode($item_data);
        $response = new Response('<b> cookies else x2</b>');
        $response->withCookie(cookie('order',$item_data, 60));
        return $response;
    }

    
    
    public function getCookie(Request $request)
    { 
        $string = Cookie::get('order');
        $string = stripslashes($string);    // string is stored with escape double quotes 	
        $string = json_decode($string, true);
        dd($string);
        
    }

    public function deleteCookie()
    {
        $response = new Response('<b> cookies</b>');
        setcookie('order',null, 50);
        return $response;

    }
}
