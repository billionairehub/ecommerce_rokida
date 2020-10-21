<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Notify;
use App\Order;
use App\Custommer;

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
        $product = Order::where('order_code', 'LIKE', $lst['name'])->first();
        if(!$product) 
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
            $notify = Notify::join('rokida_orders', 'order_id', '=', 'rokida_orders.id')
                        ->where('user_id', $userID)->groupBy('rokida_orders.order_code')->get();
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
}
