<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Product;
use App\Promotion;
use App\Category;
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
        $category = Category::orderBy('created_at', 'DESC')->get();
        if($category == null){
            $result = [

                'success' => true,
    
                'code' => 200,
    
                'message'=> trans('message.categories_not_found'),
    
                'data' => null
    
            ];
        }
        $result = [

            'success' => true,

            'code' => 200,

            'message'=> trans('message.get_categories_sucess'),

            'data' => $category

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
        $category = Category::where('slug',$slug)->get();
        if(count($category) == 0){
            $result = [

                'success' => true,
    
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
        ->where('categories',$category[0]->id)
        ->get(['author', 'sku', 'rokida_products.name', 'product_code', 'price', 'promotional_price', 'thumb', 'image', 'location']);

            $result = [

            'success' => true,

            'code' => 200,

            'message'=> trans('message.get_categories_sucess'),

            'data' => $category,

            'shop' => $shop,

            'products' => $product

            ];
        }
        return response()->json($result);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
