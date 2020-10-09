<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Product;

class SaleProductController extends Controller
{
    public static function getSaleProduct()
    {
        $salePro = Product::where('promotional_price', '<>', NULL)->get();   
        if(count($salePro) == 0 )
        {
            $result = [

                'success' => true,
    
                'code' => 200,
    
                'message'=> trans('message.product_sale_not_exits'),
    
                'data' => null
    
            ];
        }
        else
        {
            $result = [

                'success' => true,
    
                'code' => 200,
    
                'message'=> trans('message.get_product_sale_sucess'),
    
                'data' => $salePro
    
            ];
        }
        
        return response()->json($result);
    }
}
