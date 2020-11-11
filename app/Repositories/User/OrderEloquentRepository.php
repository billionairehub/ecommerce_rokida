<?php
namespace App\Repositories\User;

use App\Repositories\EloquentRepository;
use App\Contracts\User\Order as ContractsOrder; // set để sử dụng 

use Constants;
use App\Models\Product;
use App\Models\Custommer;
use App\Models\TypeShipping;
use App\Models\OrderDetail;
use App\Models\Order_status;
use App\Models\ShoppingCart;
use App\Models\Shop;
use App\Models\Order;
use App\Models\Voucher;
use App\Notifications\TestNotification;
use DB;
use Cookie;
use Carbon\Carbon;
use Redirect;
use Pusher\Pusher;
use Notification;
use Mail;

class OrderEloquentRepository extends EloquentRepository implements ContractsOrder
{

    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return \App\Models\Order::class;
    }

    public function ShoppingCart($id)
    {
        $result = $data = ShoppingCart::where('user_id', $id)->where('status_product', 0)->get();
        if($result){
            return response()->json([

                'status' => true,

                'code' => 200,

                'message' => trans('message.get_success'),

                'data' => $result

            ], 200);
        }
        else {
            return  response()->json([

                'status' => false,
    
                'code' => 200,
    
                'message' => trans('message.product_not_found')
    
            ], 200);
        }
        
    }

    public function updateCart($lst, $id_user)
    {
            $data = ShoppingCart::whereIn('id', $lst)->where('user_id', $id_user)->get();
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

    public function confirmCart($lst)
    {
        $data = ShoppingCart::whereIn('id', $lst)->where('status_product', 1)->get();
        if(count($data) > 0)
        {
            $total_bill = ShoppingCart::selectRaw('sum(total_price) as TONGTIEN, shop_id')->where('status_product', 1)->groupBy('shop_id')->get();
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
            $total_all_bill = ShoppingCart::where('status_product', 1)->sum('total_price');
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

            'message' => trans('message.get_success'),

            'data' => $array

        ], 200);
    }

    public function Voucherwallet($user_id, $type)
    {
        $now = Carbon::now();
        $user = $user_id; //$user_id
        $arr_user = [];
        $vouchers = [];
        $all_voucher = Voucher::where('time_end', '>', $now)->get();
        for($i = 0; $i < count($all_voucher); $i++)
        {
            $arr_user[] = explode(',',$all_voucher[$i]->id_used);
        }
        foreach($arr_user as $key => $value)
        {
            if(in_array($user, $value))
            {
                $voucher = $all_voucher->where('status_voucher', $type);
                //type = 0 : effective
                //type = 1 : used
                //type = 2 : ineffective
                $vouchers[] = $voucher;
            }
            else
            {
                $vouchers[] = null;
            }
        }
        return  response()->json([

            'success' => true,

            'code' => 200,

            'message' => trans('message.get_success'),

            'data' => $vouchers

        ], 200);
    }

    function generateRandomString($length = 10) {

        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';

        $charactersLength = strlen($characters);

        $randomString = '';

        for ($i = 0; $i < $length; $i++) {

            $randomString .= $characters[rand(0, $charactersLength - 1)];

        }

        return $randomString;

    }

    public function OrderPayment($user_id, $req)
    {
        $fee_ship = 25000;
        $lst = $req;
        $countID = Order::all();
        $code = count($countID)+1;
        $order = new Order;
        $user = auth('api')->user()->id;
        $order->user_id = $user;
        $cart = ShoppingCart::where('user_id', $user)->where('status_product', 1)->get();
        if(count($cart) == 0)
        {
            return response()->json([

                'success' => true,
    
                'code' => 200,
    
                'message' => trans('message.shopping_cart_not_exits'),
    
                'data' => null
    
            ], 200);
        }
        $order->amount = count($cart);
        $now = Carbon::now();
        if(array_key_exists('id_voucher', $lst) && $lst['id_voucher'] !=  null)
        {
            $voucher_time_expired = Voucher::where('type', 5)->where('time_end', '>', $now)->where('id',$lst['id_voucher'])->first();
            $stt_voucher = Voucher::find($lst['id_voucher']);
            $stt_voucher->id_used = $stt_voucher->id_used.','.$user;
            $stt_voucher->used += 1;
            $stt_voucher->status_voucher = 1;
            $stt_voucher->save();
            $total_bill = 0;
            if($voucher_time_expired)
            {
                $total_bill = $lst['total_bill'] + $fee_ship - $fee_ship*$voucher_time_expired->reduction;
            }
            else
            {
                $total_bill = $lst['total_bill'] + $fee_ship;
            }
        }
        else
        {
            $total_bill = $lst['total_bill'] + $fee_ship;
        }
        $order->total_bill = $total_bill;

        $order->order_code = $this->generateRandomString().$code;

        $order->type_ship_id = $lst['type_ship_id'];

        $order->status_ship = 0;
        
        $order->status_order = 0;
        
        $order->ship_address = $lst['ship_address'];

        $order->phone = $lst['phone'];

        $order->email = $lst['email'];

        $order->fees_ship = $fee_ship;

        $confirm_order = $order->save();
        $orders = Order::find($order->id);
        $user = Custommer::find($user);
        $data = $orders;
        $user->notify(new TestNotification($orders));
        $status_order = new Order_status;
        $status_order->order_id = $orders->id;
        $status_order->pending = 0;
        $status_order->save();
        for($i = 0; $i < count($cart); $i++)    
        {
            $orderDetail = new OrderDetail();
            $orderDetail->order_id = $orders->id;
            $orderDetail->product_id = $cart[$i]->product_id;
            $orderDetail->price	= $cart[$i]->price;
            $orderDetail->promotion_price = $cart[$i]->promotion_price;
            $orderDetail->shop_id = $cart[$i]->shop_id;
            if(array_key_exists('id_voucher', $lst) && $lst['id_voucher'] !=  null)
            {
                $orderDetail->voucher = $lst['id_voucher'];
            }
            else
            {
                $orderDetail->voucher = NULL;
            }
            $orderDetail->product_classify = $cart[$i]->categories;
            $orderDetail->quantity = $cart[$i]->quantity;
            $confirm_orderDetail = $orderDetail->save();
            $deleteCart = ShoppingCart::find($cart[$i]->id);
            $deleteCart->delete();
        }
        $data = Order::find($orders->id);
        $orderDetail_mail = OrderDetail::join('rokida_orders', 'rokida_orders.id', '=', 'rokida_order_details.order_id')
        ->join('rokida_shops', 'rokida_shops.id', '=', 'rokida_order_details.shop_id')
        ->join('rokida_products', 'rokida_products.id', '=','rokida_order_details.product_id' )
        ->where('order_id', $order->id)->get();
        $user_mail = Custommer::where('id', $data->user_id)->first();
        $email = array('emailto' => $data->email, 'order' => $data, 'order_detail' => $orderDetail_mail, 'users' => $user_mail);
        Mail::send(['html'=>'confirmorder'],$email, function($message) use ($email){
                $message->to(reset($email), '')->subject('Đơn hàng'.' '.$email['order']->order_code.''.' đã được xác nhận');
                $message->from('noreply.sharingroom@gmail.com', "noreply.sharingroom@gmail.com");
        });
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

    public function ReceivedOrder($id)
    {
        $data = Order::find($id);
        $orderDetail = OrderDetail::join('rokida_orders', 'rokida_orders.id', '=', 'rokida_order_details.order_id')
        ->join('rokida_shops', 'rokida_shops.id', '=', 'rokida_order_details.shop_id')
        ->join('rokida_products', 'rokida_products.id', '=','rokida_order_details.product_id' )
        ->where('order_id', $id)->get();
        $user = Custommer::where('id', $data->user_id)->first();
        if($data == null)
        {
            return response()->json([

                'success' => true,
    
                'code' => 200,
    
                'message' => trans('message.update_unsuccess'),
    
                'data' => null
    
            ], 200);
        }
        else
        {
            $data->status_order = 1;
            $receivedorder = $data->save();
            $email = array('emailto' => $data->email, 'order' => $data, 'order_detail' => $orderDetail, 'users' => $user);
            Mail::send(['html'=>'teamplatemail'],$email, function($message) use ($email){
                $message->to(reset($email), '')->subject('Đơn hàng'.' '.$email['order']->order_code.''.' đã giao thành công');
                $message->from('noreply.sharingroom@gmail.com', "noreply.sharingroom@gmail.com");
            });
            if(!$receivedorder)
            {
                return response()->json([

                    'success' => true,
        
                    'code' => 200,
        
                    'message' => trans('message.update_unsuccess'),
        
                    'data' => null
        
                ], 200);
            }
            else
            {
                return response()->json([

                    'success' => true,
        
                    'code' => 200,
        
                    'message' => trans('message.update_success'),
        
                    'data' => $data
        
                ], 200);
            }
        }
        
    }

    public function NotifyOrder($id)
    {
        $customer = Custommer::find($id);
        $arr = [];
        foreach($customer->unreadNotifications  as $notification) //unreadNotifications get unread notify, get notifications get notitfy
        {
            $arr[] = $notification->data;
        }
        return response()->json([

            'success' => true,

            'code' => 200,

            'message' => trans('message.get_success'),

            'data' => $arr

        ], 200);
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

    //sản phẩm bán chạy
    public function SellProducts()
    {
        $sumquantity = OrderDetail::selectRaw('SUM(quantity) as sum_quanity, product_id')
        ->groupBy('product_id')->limit(10)->get();
        //dd($sumquantity);
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