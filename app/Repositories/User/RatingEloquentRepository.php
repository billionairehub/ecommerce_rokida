<?php
namespace App\Repositories\User;

use App\Contracts\User\Rating as ContractsRating; // set để sử dụng 
use App\Models\Rate;
use Carbon\Carbon;
use Image;
use Illuminate\Support\Facades\Storage;  
use App\Models\Product;
use App\Models\Custommer;
use App\Models\Shop;
use App\Repositories\EloquentRepository;

class RatingEloquentRepository extends EloquentRepository implements ContractsRating
{

    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return \App\Models\Rate::class;
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

    public function AddRateProduct($req, $id)
    {
        $lst = $req;
        $rate = new Rate;
        $pro = Product::where('id', $id)->first();
        $user_id = auth('api')->user()->id;
        $rate->shop_id = $pro->id;
        $shop = Shop::find($pro->id);
        $rate->user_id = $user_id;
        $user = Custommer::find($user_id);
        $rate->product_id = $pro->id;
        $products = Product::find($pro->id);
        $rate->content = $lst['content'];
        $rate->vote = $lst['vote'];
        if(array_key_exists('content_image', $lst) &&  $lst['content_image'] != null)
        {
            $string = '';
            $count_img = count($lst['content_image']);
            for($i = 0 ; $i < $count_img ; $i++ )
            {
                $generateName = $this->generateRandomString();
                $now = Carbon::now();
                $photo_name = Carbon::parse($now)->format('YmdHis').$i.$generateName.'.jpg';
                $path = $lst['content_image'][$i]->storeAs('./img_reviews/',$photo_name);
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
        $rate->shop_id = $shop;
        $rate->user_id = $user;
        $rate->product_id = $products;
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

    public function UpdateRateProduct($req, $id)
    {
        $rate = Rate::find($id);
        $lst = $req;
        $shop = Shop::find($rate->shop_id);
        $user = Custommer::find($rate->user_id);
        $products = Product::find($rate->product_id);
        $rate->content = $lst['content'];
        $rate->vote = $lst['vote'];
        if(array_key_exists('content_image', $lst) &&  $lst['content_image'] != null)
        {
            $string = '';
            $count_img = count($lst['content_image']);
            for($i = 0 ; $i < $count_img ; $i++ )
            {
                $generateName = $this->generateRandomString();
                $now = Carbon::now();
                $photo_name = Carbon::parse($now)->format('YmdHis').$i.$generateName.'.jpg';
                $path = $lst['content_image'][$i]->storeAs('./img_reviews/',$photo_name);
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
        $stt_rate = $rate->save();
        $rate->shop_id = $shop;
        $rate->user_id = $user;
        $rate->product_id = $products;
        if($stt_rate)
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

    public function GetRateProduct($slug, $lst_get)
    {
        $lst = $lst_get;
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
                ->get(['user_id', 'first_name', 'last_name', 'avatar', 'product_id', 'content', 'content_image', 'vote', 'first_name', 'last_name','avatar', 'rokida_rates.created_at as time_created_reviews', 'rokida_rates.updated_at as time_update_reviews', 'rokida_rates.deleted_at as time_delete_reviews']);
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
}