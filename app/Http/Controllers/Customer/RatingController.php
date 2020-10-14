<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Rate;
use Carbon\Carbon;
use Image;
use Illuminate\Support\Facades\Storage;  
use App\Product;

class RatingController extends Controller
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
    public function AddRateProduct(Request $req, $id)
    {
        $rate = new Rate;
       
        $pro = Product::where('id', $id)->first();
        $user_id = auth('api')->user()->id;
        $rate->shop_id = $pro->id;
        $rate->user_id = $user_id;
        $rate->product_id = $pro->id;
        $rate->content = $req->content;
        $rate->vote = $req->vote;
        $lst = $req->all();
        if(array_key_exists('content_image', $lst) ||  $req->file('content_image') != null)
        {
            $string = '';
            $count_img = count($req->file('content_image'));
            for($i = 0 ; $i < $count_img ; $i++ )
            {
                $generateName = $this->generateRandomString();
                $now = Carbon::now();
                $photo_name = Carbon::parse($now)->format('YmdHis').$i.$generateName.'.jpg';
                $path = $req->file('content_image')[$i]->storeAs('./img_reviews/',$photo_name);
                $img_url = asset('/storage/img_reviews/'.$photo_name);
                $string = $string.$img_url;
                if ($i < ($count_img - 1)) {
                    $string = $string . ',';
                }
            }
            $rate->content_image = $string;
        }
        else
        {
            $rate->content_image = null;
        }
        $rate->save();
        if($rate)
        {
            $result = [

                'status' => true,
    
                'code' => 200,
    
                'message'=> trans('message.add_rate_sucess'),
    
                'data' => $rate
    
            ];
        }
        else
        {
            $result = [

                'status' => true,
    
                'code' => 200,
    
                'message'=> trans('message.add_rate_unsucess'),
    
                'data' => null
    
            ];
        }

        return response()->json($result);
    }

    public function UpdateRateProduct(Request $req, $id)
    {
        $rate = Rate::find($id);
        $rate->content = $req->content;
        $rate->vote = $req->vote;
        if($req->content_image == null)
        {
            $rate->content_image = null;
        }
        else
        {
            $rate->content_image = $req->content_image;
        }
        $rate->save();
        if($rate)
        {
            $result = [

                'status' => true,
    
                'code' => 200,
    
                'message'=> trans('message.update_rate_sucess'),
    
                'data' => $rate
    
            ];
        }
        else
        {
            $result = [

                'status' => true,
    
                'code' => 200,
    
                'message'=> trans('message.update_rate_unsucess'),
    
                'data' => null
    
            ];
        }

        return response()->json($result);
    }

    public function DeleteRate($id)
    {
        $delRate = Rate::find($id);
        if($delRate == null)
        {
            $result = [

                'status' => true,
    
                'code' => 200,
    
                'message'=> trans('message.not_found_rate')
    
            ];
        }
        else
        {
            $delRate->delete();
            $result = [
    
                'status' => true,
    
                'code' => 200,
    
                'message'=> trans('message.delete_rate_sucess')
    
            ];
        }
        return response()->json($result);
    }

    public function GetRateProduct($slug)
    {
        $lst = $_GET;
        $id_product = Product::where('slug', $slug)->first();
        if($id_product != null)
        {
            $reviews = Rate::join('rokida_users','rokida_users.id', '=', 'rokida_rates.user_id')
            ->where('product_id', $id_product->id)->orderBy('vote', 'DESC')
            ->get(['user_id', 'product_id', 'content', 'content_image', 'vote', 'first_name', 'last_name','avatar', 'rokida_rates.created_at as time_created_reviews', 'rokida_rates.updated_at as time_update_reviews', 'rokida_rates.deleted_at as time_delete_reviews']);
            
            $rate = Rate::groupBy('product_id')->count('vote');
            $rate5 = Rate::where('vote', 5)->groupBy('product_id')->count('vote');
            $rate4 = Rate::where('vote', 4)->groupBy('product_id')->count('vote');
            $rate3 = Rate::where('vote', 3)->groupBy('product_id')->count('vote');
            $rate2 = Rate::where('vote', 2)->groupBy('product_id')->count('vote');
            $rate1 = Rate::where('vote', 1)->groupBy('product_id')->count('vote');
            $sumrate = Rate::groupBy('product_id')->sum('vote');

            if(array_key_exists('type', $lst) && $lst['type'] != null )
            {
                $reviews = Rate::join('rokida_users','rokida_users.id', '=', 'rokida_rates.user_id')
                ->where('product_id', $id_product->id)->orderBy('vote', 'DESC')
                ->where('vote', $lst['type'])
                ->get(['user_id', 'product_id', 'content', 'content_image', 'vote', 'first_name', 'last_name','avatar', 'rokida_rates.created_at as time_created_reviews', 'rokida_rates.updated_at as time_update_reviews', 'rokida_rates.deleted_at as time_delete_reviews']);
            }
            if(count($reviews) > 0)
            {
                $result = [

                    'status' => true,
        
                    'code' => 200,
        
                    'message' => trans('message.get_reviews_sucess'),
        
                    'data' => $reviews,

                    'general_assessment' => round($sumrate/$rate, 1),

                    'Five-star' => $rate5,

                    'Four-star' => $rate4,

                    'Three-star' => $rate3,

                    'Two-star' => $rate2,

                    'One-star' => $rate1,
        
                ];
            }
            else
            {
                $result = [

                    'status' => true,
        
                    'code' => 200,
        
                    'message' => trans('message.not_reviews'),
        
                    'data' => null
        
                ];
            }
        }
        else
        {
            $result = [

                'status' => true,
        
                'code' => 200,
        
                'message' => trans('message.not_reviews'),
        
                'data' => null
        
            ];
        }
        return response()->json($result);
    }

    public function GetRateType($vote)
    {

    }
}
