<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Notify;
use App\Order;
use App\OrderDetail;
use App\Order_status;
use App\Custommer;
use Carbon\Carbon;

class NotifyController extends Controller
{
    public function getNotify()
    {
        $userID = auth('api')->user()->id;
        $notify = Notify::where('user_id', $userID)->get();
        if(count($notify) > 0)
        {
            return $result = [

                'status' => true,
    
                'code' => 200,
    
                'message' => trans('message.find_notify_sucess'),

                'data' => $notify
    
            ];
        }
        else 
        {
            return $result = [

                'status' => true,
    
                'code' => 200,
    
                'message' => trans('message.notify_not_found'),

                'data' => null
    
            ];
        }
    }

    public function getNotifyofOrder()
    {
        $lst = $_GET;
        $userID = auth('api')->user()->id;
        if (!$userID) {
            return  [
                'success' => false,
                'code' => 401,
                'message' => trans('message.unauthenticate')
          ];
        }
        $order = Order::where('order_code', 'LIKE', $lst['name'])->first();
        if(!$order) 
        {
            return $result = [

                'status' => true,
    
                'code' => 200,
    
                'message' => trans('message.get_product_unsucess'),

                'data' => null
    
            ];
        }
        else
        {
            $status_order = Order_status::join('rokida_orders', 'order_id', '=', 'rokida_orders.id')
                                        ->where('rokida_orders.user_id', $userID)->get();
            if(count($status_order) > 0)
            {
                return response()->json([

                    'status' => true,
        
                    'code' => 200,
        
                    'message' => trans('message.find_notify_sucess'),

                    'data' => $status_order
        
                ],200);
            }
            else 
            {
                return $result = [

                    'status' => true,
        
                    'code' => 200,
        
                    'message' => trans('message.notify_not_found'),

                    'data' => null
        
                ];
            }
        }
        
    }

    public function CreateNotify(Request $req)
    {
        $notify = new Notify;
        $lst = $req->all();
        if(array_key_exists('user_id', $lst) && $lst['user_id'] != null )
        {
            $user_id = $req->user_id;
        }
        if(array_key_exists('order_id', $lst) && $lst['order_id'] != null )
        {
            $user_id = $req->order_id;
        }
        if(array_key_exists('promotion_id', $lst) && $lst['promotion_id'] != null )
        {
            $user_id = $req->promotion_id;
        }

        $notify->title = $req->input('title');	
        $notify->img_notify = $req->file('img_notify');	 
        $notify->content = $req->iput('content');	

        $notify->save();
    }

    public function completepacking($id)
    {
        $order = Order_status::where('order_id', $id)->first();
        if($order)
        {
            $status_order = Order_status::find($order->id);
            $now = Carbon::now();
            $status_order->pending	= 1;
            $status_order->complete_packing = $now;
            $status_order->save();
            return response()->json([

                'status' => true,
    
                'code' => 200,
    
                'message' => trans('message.successful_confirmation'),

                'data' => $status_order
    
            ], 200); 
        }
        else 
        {
            return response()->json([

                'status' => true,
    
                'code' => 200,
    
                'message' => trans('message.unsuccessful_confirmation'),

                'data' => null
    
            ], 200); 
        }
    }


    public function packagereceived(Request $req, $id)
    {
        $order = Order_status::where('order_id', $id)->first();
        if($order)
        {
            $status_order = Order_status::find($order->id);
            $now = Carbon::now();
            $data = $req->input('name_unit').','.$now;
            $status_order->deliver_shipping_unit = $data;
            $status_order->package_received	 = $data;
            $status_order->save();
            return response()->json([

                'status' => true,
    
                'code' => 200,
    
                'message' => trans('message.successful_confirmation'),

                'data' => $status_order
    
            ], 200); 
        }
        else 
        {
            return response()->json([

                'status' => true,
    
                'code' => 200,
    
                'message' => trans('message.unsuccessful_confirmation'),

                'data' => null
    
            ], 200); 
        }
    }

    public function SendDepot(Request $req, $id)
    {
        $order = Order_status::where('order_id', $id)->first();
        if($order)
        {
            $status_order = Order_status::find($order->id);
            $now = Carbon::now();
            $data = $req->input('location').','.$now;
            $status_order->to_depot	= $data;
            $status_order->save();
            return response()->json([

                'status' => true,
    
                'code' => 200,
    
                'message' => trans('message.successful_confirmation'),

                'data' => $status_order
    
            ], 200); 
        }
        else 
        {
            return response()->json([

                'status' => true,
    
                'code' => 200,
    
                'message' => trans('message.unsuccessful_confirmation'),

                'data' => null
    
            ], 200); 
        }
    }

    public function Transport(Request $req, $id)
    {
        $order = Order_status::where('order_id', $id)->first();
        if($order)
        {
            $status_order = Order_status::find($order->id);
            $now = Carbon::now();
            $data = $req->input('location').','.$now;
            $status_order->being_transported = $data;
            $status_order->leave_depot	= $data;
            $status_order->save();
            return response()->json([

                'status' => true,
    
                'code' => 200,
    
                'message' => trans('message.successful_confirmation'),

                'data' => $status_order
    
            ], 200); 
        }
        else 
        {
            return response()->json([

                'status' => true,
    
                'code' => 200,
    
                'message' => trans('message.unsuccessful_confirmation'),

                'data' => null
    
            ], 200); 
        }
    }

    public function ShipWay(Request $req, $id)
    {
        $order = Order_status::where('order_id', $id)->first();
        if($order)
        {
            $status_order = Order_status::find($order->id);
            $now = Carbon::now();
            $data = $req->input('location').','.$now;
            $status_order->shipway = $data;
            $status_order->save();
            return response()->json([

                'status' => true,
    
                'code' => 200,
    
                'message' => trans('message.successful_confirmation'),

                'data' => $status_order
    
            ], 200); 
        }
        else 
        {
            return response()->json([

                'status' => true,
    
                'code' => 200,
    
                'message' => trans('message.unsuccessful_confirmation'),

                'data' => null
    
            ], 200); 
        }
    }

    public function ChangeDepot(Request $req, $id)
    {
        $order = Order_status::where('order_id', $id)->first();
        if($order)
        {
            $status_order = Order_status::find($order->id);
            $now = Carbon::now();
            $data = $req->input('location').','.$now;
            $status_order->to_new_depot	= $data;
            $status_order->save();
            return response()->json([

                'status' => true,
    
                'code' => 200,
    
                'message' => trans('message.successful_confirmation'),

                'data' => $status_order
    
            ], 200); 
        }
        else 
        {
            return response()->json([

                'status' => true,
    
                'code' => 200,
    
                'message' => trans('message.unsuccessful_confirmation'),

                'data' => null
    
            ], 200); 
        }
    }

    public function CompleteShip(Request $req, $id)
    {
        $order = Order_status::where('order_id', $id)->first();
        if($order)
        {
            $status_order = Order_status::find($order->id);
            $now = Carbon::now();
            $data = $req->input('location').','.$now;
            $status_order->complete_shipping = $data;
            $status_order->save();
            return response()->json([

                'status' => true,
    
                'code' => 200,
    
                'message' => trans('message.successful_confirmation'),

                'data' => $status_order
    
            ], 200); 
        }
        else 
        {
            return response()->json([

                'status' => true,
    
                'code' => 200,
    
                'message' => trans('message.unsuccessful_confirmation'),

                'data' => null
    
            ], 200); 
        }
    }

    function QueryOrder($id)
    {
        $data = OrderDetail::join('rokida_orders', 'rokida_orders.id', '=','rokida_order_details.order_id')
        ->join('rokida_status_orders', 'rokida_orders.id', '=', 'rokida_status_orders.order_id')
        ->join('rokida_products', 'rokida_products.id', '=','rokida_order_details.product_id')
        ->join('rokida_shops', 'rokida_shops.id', '=','rokida_order_details.shop_id')
        ->join('rokida_users', 'rokida_users.id', '=', 'rokida_orders.user_id')
        ->where('rokida_orders.id', $id)
        ->select('rokida_status_orders.*','rokida_users.*', 'rokida_orders.id as order_id','rokida_orders.order_code as order_code','rokida_orders.created_at as created_at_order', 'rokida_products.image as img_product', 'rokida_products.name as name_product', 'rokida_order_details.quantity', 'rokida_orders.status_ship as status_ship', 'ship_address' ,'rokida_orders.status_order as status_order')  
        ->get();
        return $data;
    }
    public function historyPurchase(Request $req)
    {
        $userID = auth('api')->user()->id;
        $data = $this->QueryOrder($userID);
        $lst = $req->all();
        if (array_key_exists('type', $lst)) {
            $data = $data->where('status_ship', $lst['type']);
        }
        if(count($data) == 0)
        {
            $array = null;
        } 
        else
        {
            $array = [];
            for ($i = 0; $i < count($data); $i++) {
                $arr = [];
                array_push($arr, $data[$i]);
                for ($j = $i + 1; $j  < count($data); $j++) {
                    if ($data[$i]->order_id == $data[$j]->order_id) {
                        array_push($arr, $data[$j]);
                    }
                }
                if (array_key_exists($data[$i]->order_id, $array) == false) {
                    $array[$data[$i]->order_id] = $arr;
                }
            }
        }
        return response()->json([

            'status' => true,
    
            'code' => 200,
    
            'message' => trans('message.successful_confirmation'),

            'data' => $array
    
        ], 200); 
    }

    public function DetailHistoryPurchase(Request $req, $id)
    {
        $lst = $_GET;
        $data = $this->QueryOrder($id);
        if(count($data) == 0)
        {
            $data = null;
        }
        else{
            $data = $data;
        }
        return response()->json([

            'status' => true,
    
            'code' => 200,
    
            'message' => trans('message.successful_confirmation'),

            'data' => $data
    
        ], 200); 
    }
}
