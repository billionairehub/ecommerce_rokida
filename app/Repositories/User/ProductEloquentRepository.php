<?php
namespace App\Repositories\User;

use App\Contracts\User\Product as ContractsProduct; // set để sử dụng 
use App\Models\TopSearch;
use App\Models\TypeShipping;
use App\Models\Category;
use App\Repositories\EloquentRepository;

class ProductEloquentRepository extends EloquentRepository implements ContractsProduct
{

    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return \App\Models\Product::class;
    }   

    public function getSaleProduct()
    {
        $salePro = $this->_model::where('promotional_price', '<>', NULL)->get();   
        if($salePro)
        {
            return response()->json([

                'success' => true,
    
                'code' => 200,
    
                'message' => trans('message.get_product_sale_sucess'),
    
                'data' => $salePro
    
            ], 200);
        }
        else
        {
            return response()->json([

                'success' => true,
    
                'code' => 200,
    
                'message' => trans('message.product_sale_not_exits'),
    
                'data' => $null
    
            ], 200);
        }
    }

    public function searchProduct($keyword)
    {
        $key = $keyword;
        $searchPro = $this->_model::where('name', 'LIKE', '%'.$key['keyword'].'%')->get();
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
            $proTop = $this->_model::where('name','LIKE', '%'.$keytop[$i]->key_search.'%')->get();
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