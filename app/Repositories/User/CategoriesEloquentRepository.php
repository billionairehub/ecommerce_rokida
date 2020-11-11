<?php
namespace App\Repositories\User;

use App\Contracts\User\Categories as ContractsCategories; // set để sử dụng 
use App\Models\Product;
use App\Models\Promotion;
use App\Models\Category;
use App\Models\TypeShipping;
use App\Models\Classify;
use App\Models\Shop;
use App\Repositories\EloquentRepository;


class CategoriesEloquentRepository extends EloquentRepository implements ContractsCategories
{

    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return \App\Models\Category::class;
    }   

    public function getProductCategories()
    {
        $arrParent = [];
        $parent = Category::where('cate_parent', NULL)->orderBy('created_at', 'DESC')->get();
        for ($i = 0; $i < count($parent); $i++) {
            array_push($arrParent, $parent[$i]->id);
        }
        $child = Category::where('cate_parent', '<>', NULL)->whereIn('cate_parent', $arrParent)->orderBy('created_at', 'DESC')->get();
        for ($i = 0; $i < count($parent); $i++) {
            $arrChildrent = [];
            for ($j = 0; $j < count($child); $j++) {
                if ($parent[$i]->id == $child[$j]->cate_parent) {
                    array_push($arrChildrent, $child[$j]);
                }
            }
            $parent[$i]->childrent = $arrChildrent;
        }
        
        $result = [

            'status' => true,

            'code' => 200,

            'message'=> trans('message.get_categories_sucess'),

            'data' => $parent

        ];
        return response()->json($result);
    }

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
}