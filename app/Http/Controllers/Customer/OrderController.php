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
use App\Order_status;
use App\ShoppingCart;
use App\Voucher;
use DB;
use Cookie;
use Carbon\Carbon;
use Redirect;

class OrderController extends Controller
{
    function generateRandomString($length = 10) {

        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';

        $charactersLength = strlen($characters);

        $randomString = '';

        for ($i = 0; $i < $length; $i++) {

            $randomString .= $characters[rand(0, $charactersLength - 1)];

        }

        return $randomString;

    }

    public function getShoppingCart()
    {
        $userID = auth('api')->user()->id;
        if(!$userID)
        {
            return  response()->json([

                'success' => false,

                'code' => 401,

                'message' => trans('message.unauthenticate')

          ], 401);
        }
        $data = ShoppingCart::where('user_id', $userID)->where('status_product', 0)->get();
        if(count($data) == 0)
            {
                return  response()->json([

                    'success' => false,
    
                    'code' => 200,
    
                    'message' => trans('message.product_not_found')
    
                ], 200);
            }
            else
            {
                return  response()->json([

                    'success' => true,
    
                    'code' => 200,
    
                    'message' => trans('message.product_not_found'),

                    'data' =>$data
    
                ], 200);
            }
    }

    public function updateCart(Request $req)
    {
        $arr = $req->input('id_product');
        $data = ShoppingCart::whereIn('id', $arr)->get();
        foreach($data as $key => $value)
        {
            $data[$key]->status_product = !$data[$key]->status_product;
            $data[$key]->save();
        }
        return  response()->json([

            'success' => true,

            'code' => 200,

            'message' => trans('message.update_success'),

            'data' => $data

        ], 200);
    }

    public function confirmProduct(Request $req)
    {
        $arr = $req->input('id_product');
        $data = ShoppingCart::whereIn('id', $arr)->where('status_product', 1)->get();
        if(count($data) > 0)
        {
            $total_bill = ShoppingCart::selectRaw('sum(total_price) as TONGTIEN, shop_id')->where('user_id', 1)->where('status_product', 1)->groupBy('shop_id')->get();
            $array = [];
            for ($i = 0; $i < count($data); $i++) {
                $arr = [];
                array_push($arr, $data[$i]);
                for ($j = $i + 1; $j  < count($data); $j++) {
                    if ($data[$i]->shop_id == $data[$j]->shop_id) {
                        array_push($arr, $data[$j]);
                    }
                }
                if (array_key_exists($data[$i]->shop_id, $array) == false) {
                    $array[$data[$i]->shop_id] = $arr;
                }
            }
            $keys = array_keys($array);
            foreach ($keys as $key) {
                $total = 0;
                for ($j = 0; $j  < count($array[$key]); $j++) {
                    $total = $total + $array[$key][$j]->total_price;
                }
                $obj = (object)[];
                $obj->total_bill = $total;
                array_push($array[$key], $obj);
            }
            $total_all_bill = ShoppingCart::where('user_id', 1)->where('status_product', 1)->sum('total_price');
            return  response()->json([

                'success' => true,

                'code' => 200,

                'message' => trans('message.confirm_success'),

                'data' => $array,

                'total_all_bill' => $total_all_bill

            ], 200);
        }
        else
        {
            return  response()->json([

                'success' => true,

                'code' => 200,

                'message' => trans('message.confirm_unsuccess'),

                'data' => null

            ], 200);
        }


    }

    public function getVoucher()
    {
        $now = Carbon::now();
        $array = [];
        $voucher_time_expired = Voucher::where('type', 5)->where('time_end', '>', $now)->first();
        $array['time_expired'] = $voucher_time_expired;
        $voucher = Voucher::where('type', 5)->where('time_end', '<', $now)->get();
        $array['time_unexpired'] = $voucher;
        return  response()->json([

            'success' => true,

            'code' => 200,

            'message' => trans('message.update_success'),

            'data' => $array

        ], 200);
    }

    public function OderProducts(Request $req)
    {
        $fee_ship = 25000;
        $lst = $req->all(); 
        $countID = Order::all();
        $code = count($countID)+1;
        $order = new Order;
        $user = 1; //auth('api')->user()->id;
        $order->user_id = $user;

        $cart = ShoppingCart::where('user_id', $user)->where('status_product', 1)->get();
        $order->amount = count($cart);

        $now = Carbon::now();
        if($req->id_voucher)
        {
            $voucher_time_expired = Voucher::where('type', 5)->where('time_end', '>', $now)->where('id',$req->id_voucher)->first();
            $total_bill = 0;
            if($voucher_time_expired)
            {
                $total_bill = $req->total_bill + $fee_ship - $fee_ship*$voucher_time_expired->reduction;
            }
            else
            {
                $total_bill = $req->total_bill + $fee_ship;
            }
        }
        else
        {
            $total_bill = $req->total_bill + $fee_ship;
        }
        
        
        $order->total_bill = $total_bill;

        $order->order_code = $this->generateRandomString().$code;

        $order->type_ship_id = $req->type_ship_id;

        $order->status_ship = 0;
        
        $order->status_order = 0;
        
        $order->ship_address = $req->ship_address;

        $order->phone = $req->phone;

        $order->email = $req->email;

        $order->fees_ship = $fee_ship;

        if (array_key_exists('deleted_by', $lst)) {
            $order->deleted_by = $lst['deleted_by'];
        }
        $confirm_order = $order->save();
        $status_order = new Order_status;
        $status_order->order_id = $order->id;
        $status_order->pending = 0;
        $status_order->save();
        
        for($i = 0; $i < count($cart); $i++)    
        {
            
            $orderDetail = new OrderDetail();
            $orderDetail->order_id = $order->id;
            $orderDetail->product_id = $cart[$i]->product_id;
            $orderDetail->price	= $cart[$i]->price;
            $orderDetail->promotion_price = $cart[$i]->promotion_price;
            $orderDetail->shop_id = $cart[$i]->shop_id;
            $orderDetail->voucher = $req->input('id_voucher');
            $orderDetail->product_classify = $cart[$i]->categories;
            $orderDetail->quantity = $cart[$i]->quantity;
            //$orderDetail->deleted_by = $req->deleted_by;
            $confirm_orderDetail = $orderDetail->save();
            $deleteCart = ShoppingCart::find($cart[$i]->id);
            $deleteCart->delete();
        }    
        
       
        if($confirm_orderDetail == 1 && $confirm_order == 1)
        {
            $result = [

                'success' => true,
    
                'code' => 200,
    
                'message'=> trans('message.oder_confirm_sucess')
    
            ];
        }
        else
        {
            $result = [

                'success' => true,
    
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

                    'success' => true,
        
                    'code' => 200,
        
                    'message'=> trans('message.not_same_products'),

                    'data' => null
        
                ];
            }
            else
            {
                $result = [

                    'success' => true,
        
                    'code' => 200,
        
                    'message'=> trans('message.the_same_products'),

                    'data' => $sameProducts
        
                ];
            }
        }
        else
        {
            $result = [

                'success' => true,
    
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

                    'success' => true,
        
                    'code' => 200,
        
                    'message'=> trans('message.not_same_products'),

                    'data' => null
        
                ];
            }
            else
            {
                $result = [

                    'success' => true,
        
                    'code' => 200,
        
                    'message'=> trans('message.the_same_products'),

                    'data' => $sameProducts
        
                ];
            }
        }
        else
        {
            $result = [

                'success' => true,
    
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

            'success' => true,

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

                'success' => true,
    
                'code' => 200,
    
                'message'=> trans('message.get_product_unsucess'),
    
                'data' => null
    
            ];
        }
        else
        {
            $result = [

                'success' => true,
    
                'code' => 200,
    
                'message'=> trans('message.get_product_sucess'),
    
                'data' => $arrProduct
    
            ];
        }
        return response()->json($result);
    }

}
