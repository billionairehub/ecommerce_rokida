<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Product;
use App\TopSearch;
use App\TypeShipping;
use App\Category;

class SearchProductController extends Controller
{
    public function searchProduct()
    {
        $key = $_GET;
        $searchPro = Product::where('name', 'LIKE', '%'.$key['keyword'].'%')->get();
        if(count($searchPro) == 0)
        {
            $result = [

                'status' => true,
    
                'code' => 200,
    
                'message'=> trans('message.search_not_found'),
    
                'data' => null
    
            ];
        }
        else
        {
            $findkey = TopSearch::where('key_search', $key['keyword'])->get();
            if(count($findkey) > 0){
                $countkey = TopSearch::find($findkey[0]->id);
                $countkey->quantity = $countkey->quantity + 1;
                $countkey->save();
            }
            else
            {
                $topSearch = new TopSearch;
                $topSearch->key_search = $key['keyword'];
                $topSearch->quantity = 1;
                $topSearch->save();
            }
            
            $result = [

                'status' => true,
    
                'code' => 200,
    
                'message'=> trans('message.search_sucess'),
    
                'data' => $searchPro
    
            ];
        }
        return response()->json($result);
    }

    public function TopProducts()
    {
        $keytop = TopSearch::orderBy('quantity', 'DESC')->take(5)->get();
        $arr = [];
        for($i = 0; $i < 5; $i++)
        {
            $proTop = Product::where('name','LIKE', '%'.$keytop[$i]->key_search.'%')->get();
            array_push($arr, $proTop);
        }
        $result = [

            'status' => true,

            'code' => 200,

            'message'=> trans('message.search_sucess'),

            'data' => $arr

        ];
        return response()->json($result);
    }

    public function TopKeySearch()
    {
        $keytop = TopSearch::orderBy('quantity', 'DESC')->take(5)->get(['key_search','quantity']);
        
        $result = [

            'status' => true,

            'code' => 200,

            'message'=> trans('message.search_sucess'),

            'data' => $keytop

        ];
        return response()->json($result);
    }

}
