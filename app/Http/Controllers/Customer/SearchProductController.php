<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Product;
use App\TopSearch;

class SearchProductController extends Controller
{
    public function searchProduct()
    {
        $key = $_GET;
        $searchPro = Product::where('name', 'LIKE', '%'.$key['keyword'].'%')->get();
        if(count($searchPro) == 0)
        {
            $result = [

                'success' => true,
    
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

                'success' => true,
    
                'code' => 200,
    
                'message'=> trans('message.search_sucess'),
    
                'data' => $searchPro
    
            ];
        }
        return response()->json($result);
    }

    public function TopProducts()
    {
        $keytop = TopSearch::orderBy('quantity', 'DESC')->take(3)->get();
        foreach($keytop as $key )
        {
            $proTop = Product::where('name','LIKE', '%'.$key.'%')->get();
            dd($proTop);
        }
        
        
    }
    
}
