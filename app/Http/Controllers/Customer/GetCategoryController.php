<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Product;
use App\Promotion;
use App\Category;
use App\TypeShipping;
use App\Classify;
use App\Shop;

class GetCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $category = Category::where('cate_parent', NULL)->orderBy('created_at', 'DESC')->get();
        $allCategories = Category::pluck('name','id')->all();
        if($category == null){
            $result = [

                'status' => true,
    
                'code' => 200,
    
                'message'=> trans('message.categories_not_found'),
    
                'data' => null
    
            ];
        }
        $result = [

            'status' => true,

            'code' => 200,

            'message'=> trans('message.get_categories_sucess'),

            'data' => $category,

            'allCategories' => $allCategories

        ];
        return response()->json($result);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getDetailCategory($slug)
    {
        $category = Category::where('slug', 'LIKE', '%'.$slug.'%')->get();
        if(count($category) == 0){
            $result = [

                'status' => true,
    
                'code' => 200,
    
                'message'=> trans('message.categories_not_found'),
    
                'data' => null
    
            ];
        }
        else 
        {
            $shop = Shop::join('rokida_categories','rokida_categories.id','=','rokida_shops.categories_id')
            ->where('categories_id',$category[0]->id)
            ->get(['shop_name', 'shop_adress', 'shop_status', 'banner_id', 'avatar_shop', 'amount_follow']);

            $product = Product::join('rokida_categories','rokida_categories.id','=','rokida_products.categories')
            ->join('rokida_type_shipping', 'rokida_type_shipping.product_id','=', 'rokida_products.id')
            ->join('rokida_shipping_channels', 'rokida_shipping_channels.id','=', 'rokida_type_shipping.shipping_channels') 
            ->where('categories',$category[0]->id)
            ->get(['author', 'sku', 'rokida_products.name', 'rokida_products.status as Status','product_code', 'price', 'promotional_price', 'thumb', 'image', 'location', 'shipping_channels', 'rokida_shipping_channels.name as Name']);
            $lst = $_GET;
            if(count($product) > 0)
            {
                if(array_key_exists('location', $lst) && $lst['location'] != null )
                {
                    $value = explode(', ',$lst['location']);
                    $product = $product->whereIn('location', $value);
                }
                if(array_key_exists('typeship', $lst) && $lst['typeship'] != null )
                {
                    $typeship = explode(', ',$lst['typeship']);
                    $product = $product->whereIn('Name', $typeship);
                }
                if(array_key_exists('minPrice', $lst) && $lst['minPrice'] != null && array_key_exists('maxPrice', $lst) && $lst['maxPrice'] != null )
                {
                    $minPrice = $lst['minPrice'];
                    $maxPrice = $lst['maxPrice'];
                    $product = $product->whereBetween('price', [$minPrice, $maxPrice]);
                }
                if(array_key_exists('minPrice', $lst) && $lst['minPrice'] != null )
                {
                    $minPrice = $lst['minPrice'];
                    $maxPrice = $product->max('price');
                    $product = $product->whereBetween('price', [$minPrice, $maxPrice]);
                }
                if(array_key_exists('maxPrice', $lst) && $lst['maxPrice'] != null )
                {
                    $minPrice = $product->min('price');
                    $maxPrice = $lst['maxPrice'];
                    $product = $product->whereBetween('price', [$minPrice, $maxPrice]);
                }
                if(array_key_exists('status', $lst) && $lst['status'] != null )
                {
                    $product = $product->where('Status', $lst['status']);
                }
                
                $result = [

                    'status' => true,
        
                    'code' => 200,
        
                    'message'=> trans('message.get_categories_sucess'),
        
                    'data' => $category,
        
                    'shop' => $shop,
        
                    'products' => $product
        
                ];
            }
            
        }
        return response()->json($result);
    }

    public function getChillCategory()
    {
        $cate_paren = Category::where('cate_parent', NULL)->get(['id', 'name']);
        $arr = [];
        for($i = 0 ; $i < count($cate_paren); $i++)
        {
            $data = Category::where('cate_parent',  $cate_paren[$i]->id)->get();
            if(count($data) > 0)
            {
                $arr[] = array('name_paren' => $cate_paren[$i]->name, 'data' => $data);
            }
        }
        if(count($arr) == 0)
        {
            $result = [

                'status' => true,
        
                'code' => 200,
        
                'message'=> trans('message.not_find_category'),
        
                'data' => null
        
            ];
        }
        else
        {
            $result = [

                'status' => true,
        
                'code' => 200,
        
                'message'=> trans('message.get_categories_sucess'),
        
                'data' => $arr
        
            ];
        }

        return response()->json($result);
    }
}
