<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Product;
use App\Custommer;
use App\TypeShipping;
use Cookie;


class DetailProController extends Controller
{
    public function getdetailPro()
    {
        $lst = $_GET;
        $detail_pro = Product::join('rokida_users','rokida_products.author','=','rokida_users.id')
        ->join('rokida_categories','rokida_products.categories','=','rokida_categories.id')
        ->where('rokida_products.slug',$lst['slug'])
        ->where('rokida_products.infringe',0)
        ->where('rokida_products.hidden',0)
        ->get(['rokida_products.id', 'sku', 'rokida_products.name', 'first_name', 'last_name','product_code', 'price', 'long_desc', 'thumb', 'image', 'location', 'trademark', 'made', 'model', 'user_manual', 'img_user_manual', 'status', 'book', 'rokida_products.slug', 'rokida_categories.name as categories_name' ]);
        if (count($detail_pro) == 0) {
            return $result = [
                'success' => false,
                'code' => 404,
                'message' => trans('error.not_found_item'),
                'data' => null
            ];
        }
        $classify_pro = Product::join('rokida_classify', 'rokida_products.id', '=', 'rokida_classify.product_id')
        ->where('rokida_products.slug',$lst['slug'])
        ->where('rokida_products.infringe',0)
        ->where('rokida_products.hidden',0)
        ->get([ 'classify_key', 'classify_value']);
        $ship_name = TypeShipping::join('rokida_shipping_channels','rokida_type_shipping.shipping_channels','=','rokida_shipping_channels.id')
        ->join('rokida_products','rokida_products.id','=','rokida_type_shipping.product_id')
        ->where('rokida_products.id', $detail_pro[0]->id)
        ->get(['rokida_shipping_channels.name as name_shipping_channel']);
        if(count($ship_name) == 0){
            $ship_name = null;
        }
        else 
        {
            $ship_name = $ship_name;
        }
        $promotion_pro = Product::join('rokida_promotions', 'rokida_products.id', '=', 'rokida_promotions.product_id')
        ->where('rokida_products.slug',$lst['slug'])
        ->where('rokida_products.infringe',0)
        ->where('rokida_products.hidden',0)
        ->get([ 'pro_from', 'pro_to', 'pro_price']);
        if(count($promotion_pro) == 0){
            $promotion_pro = null;
        }
        else 
        {
            $promotion_pro = $promotion_pro;
        }
        if (count($detail_pro) == 0) {
            $result = [
                'success' => false,
                'code' => 404,
                'message' => trans('error.not_found_item'),
                'data' => null
            ];
        }
        else 
        {
            $arr = [];
            if($lst['slug'] != null)
            {
                array_push($arr, $lst['slug']);
            }
            if(!isset($_COOKIE['name']))
            {
                $response = new Response('<b>Hello</b>');
                $response->withCookie(cookie('name', implode(',',$arr), 105120000));
            }
            else
            {
                $string = Cookie::get('name');
                $arr = explode(',',$string);
                if(!in_array($lst['slug'], $arr))
                {
                    $arr[] = $lst['slug'];
                }
                $response = new Response('<b>Hello cookies</b>');
                setcookie('name', implode(',',$arr), 105120000);
            }
            $result = [
                    'success' => true,
                    'code' => 200,
                    'message' => trans('message.get_detail_pro_success'),
                    'data' => $detail_pro,
                    'classify' => $classify_pro,
                    'typeShip' => $ship_name,
                    'promotion_pro' => $promotion_pro
            ];
            return response()->json($result)->cookie('name', implode(',',$arr), 105120000);
        }
    }

    public function getCookie(Request $request)
    { 
        $cookies = Cookie::get('name');
        $arr = explode(',',$cookies);
        $arr_pro = [];
        for($i = 0 ; $i < count($arr); $i++)
        {
            $products = Product::where('slug', $arr[$i])->first();
            array_push($arr_pro, $products);
        }
        dd($arr_pro);
    }
}
