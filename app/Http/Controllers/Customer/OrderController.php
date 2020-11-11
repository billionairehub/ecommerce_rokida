<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Repositories\User\OrderEloquentRepository as OrderRepo;

class OrderController extends Controller
{
    public function getShoppingCart()
    {
        try {
            $userID = auth('api')->user()->id;
            if(!$userID)
            {
                return  response()->json([

                    'success' => false,

                    'code' => 401,

                    'message' => trans('message.unauthenticate')

            ], 401);
            }
            else 
            {
                // $lst['user_id'] = $userID;
                $shoppingcart = new OrderRepo();
                $shoppingcarts = $shoppingcart->ShoppingCart($userID);
                return $shoppingcarts;
            }
        } catch(\Exception $e) {
            abort(400);
        } 

    }

    public function updateCart(Request $req)
    {
        try {
            $userID = auth('api')->user()->id;
            $arr = $req->input('id_product');
            $shoppingcart = new OrderRepo();
            $shoppingcarts = $shoppingcart->updateCart($arr, $userID);
            return $shoppingcarts;
        } catch(\Exception $e) {
            abort(400);
        } 
    }

    public function confirmProduct(Request $req)
    {
        try {
            $arr = $req->input('id_product');
            $shoppingcart = new OrderRepo();
            $shoppingcarts = $shoppingcart->confirmCart($arr);
            return $shoppingcarts;
        } catch(\Exception $e) {
            abort(400);
        } 
    }

    public function getVoucher()
    {
        try {
            $shoppingcart = new OrderRepo();
            $shoppingcarts = $shoppingcart->getVoucher();
            return $shoppingcarts;
        } catch(\Exception $e) {
            abort(400);
        } 
    }

    public function Voucherwallet()
    {
        try {
            $userID = auth('api')->user()->id;
            $lst = $_GET;
            $type = (int)$lst['type'];
            $shoppingcart = new OrderRepo();
            $shoppingcarts = $shoppingcart->Voucherwallet($userID, $type);
            return $shoppingcarts;
        } catch(\Exception $e) {
            return response(['error' => 'The department you want to edit can\'t be found in the database!' ], 400);
        } 
    }

    public function OderProducts(Request $req)
    {
        try {
            $userID = auth('api')->user()->id;
            $lst = $req->all();
            $shoppingcart = new OrderRepo();
            $shoppingcarts = $shoppingcart->OrderPayment($userID, $lst);
            return $shoppingcarts;
        } catch(\Exception $e) {
            return response(['error' => 'The department you want to edit can\'t be found in the database!' ], 400);
        }
    }

    public function Receivedorder($id)
    {
        try {
            $shoppingcart = new OrderRepo();
            $shoppingcarts = $shoppingcart->ReceivedOrder($id);
            return $shoppingcarts;
        } catch(\Exception $e) {
            return response(['error' => 'The department you want to edit can\'t be found in the database!' ], 400);
        }
    }

    public function GetNotifyOrder()
    {
        try {
            $userID = auth('api')->user()->id;
            $shoppingcart = new OrderRepo();
            $shoppingcarts = $shoppingcart->NotifyOrder($userID);
            return $shoppingcarts;
        } catch(\Exception $e) {
            return response(['error' => 'The department you want to edit can\'t be found in the database!' ], 400);
        }
    }

    public function SameProductOfShop($slug)
    {
        try {
            $shoppingcart = new OrderRepo();
            $shoppingcarts = $shoppingcart->SameProductOfShop($slug);
            return $shoppingcarts;
        } catch(\Exception $e) {
            return response(['error' => 'The department you want to edit can\'t be found in the database!' ], 400);
        }
    }

    public function SameProducts($slug)
    {
        try {
            $shoppingcart = new OrderRepo();
            $shoppingcarts = $shoppingcart->SameProducts($slug);
            return $shoppingcarts;
        } catch(\Exception $e) {
            return response(['error' => 'The department you want to edit can\'t be found in the database!' ], 400);
        }
    }

    public function ProductsJustForYou()
    {
        try {
            $shoppingcart = new OrderRepo();
            $shoppingcarts = $shoppingcart->ProductsJustForYou();
            return $shoppingcarts;
        } catch(\Exception $e) {
            return response(['error' => 'The department you want to edit can\'t be found in the database!' ], 400);
        }
    }

    public function SellingProducts()
    {
        try {
            $shoppingcart = new OrderRepo();
            $shoppingcarts = $shoppingcart->SellProducts();
            return $shoppingcarts;
        } catch(\Exception $e) {
            return response(['error' => 'The department you want to edit can\'t be found in the database!' ], 400);
        }
    }

}
