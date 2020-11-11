<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\User\NotifyEloquentRepository as NotifyRepo;

class NotifyController extends Controller
{
    public function getNotify()
    {
        try {
            $userID = auth('api')->user()->id;
            $notify = new NotifyRepo();
            $notifies = $notify->getNotify($userID);
            return $notifies;
        } catch(\Exception $e) {
            return response(['error' => 'The department you want to edit can\'t be found in the database!' ], 400);
        } 
    }

    public function getNotifyofOrder()
    {
        try {
            $userID = auth('api')->user()->id;
            $lst = $_GET;
            $notify = new NotifyRepo();
            $notifies = $notify->getNotifyofOrder($userID, $lst);
            return $notifies;
        } catch(\Exception $e) {
            return response(['error' => 'The department you want to edit can\'t be found in the database!' ], 400);
        } 
    }

    // public function CreateNotify(Request $req)
    // {
    //     try {
    //         $lst = $req->all();
    //         $notify = new NotifyRepo();
    //         $notifies = $notify->CreateNotify($lst);
    //         return $notifies;
    //     } catch(\Exception $e) {
    //         return response(['error' => 'The department you want to edit can\'t be found in the database!' ], 400);
    //     } 
    // }

    public function completepacking($order_id)
    {
        try {
            $notify = new NotifyRepo();
            $notifies = $notify->completepacking($order_id);
            return $notifies;
        } catch(\Exception $e) {
            return response(['error' => 'The department you want to edit can\'t be found in the database!' ], 400);
        } 
    }


    public function packagereceived(Request $req, $order_id)
    {
        try {
            $req = $req->all();
            $notify = new NotifyRepo();
            $notifies = $notify->packagereceived($req, $order_id);
            return $notifies;
        } catch(\Exception $e) {
            return response(['error' => 'The department you want to edit can\'t be found in the database!' ], 400);
        } 
    }

    public function SendDepot(Request $req, $order_id)
    {
        try {
            $req = $req->all();
            $notify = new NotifyRepo();
            $notifies = $notify->SendDepot($req, $order_id);
            return $notifies;
        } catch(\Exception $e) {
            return response(['error' => 'The department you want to edit can\'t be found in the database!' ], 400);
        } 
    }

    public function Transport(Request $req, $order_id)
    {
        try {
            $req = $req->all();
            $notify = new NotifyRepo();
            $notifies = $notify->Transport($req, $order_id);
            return $notifies;
        } catch(\Exception $e) {
            return response(['error' => 'The department you want to edit can\'t be found in the database!' ], 400);
        } 
    }

    public function ShipWay(Request $req, $order_id)
    {
        try {
            $req = $req->all();
            $notify = new NotifyRepo();
            $notifies = $notify->ShipWay($req, $order_id);
            return $notifies;
        } catch(\Exception $e) {
            return response(['error' => 'The department you want to edit can\'t be found in the database!' ], 400);
        } 
    }

    public function ChangeDepot(Request $req, $order_id)
    {
        try {
            $req = $req->all();
            $notify = new NotifyRepo();
            $notifies = $notify->ChangeDepot($req, $order_id);
            return $notifies;
        } catch(\Exception $e) {
            return response(['error' => 'The department you want to edit can\'t be found in the database!' ], 400);
        } 
    }

    public function CompleteShip(Request $req, $order_id)
    {
        try {
            $req = $req->all();
            $notify = new NotifyRepo();
            $notifies = $notify->CompleteShip($req, $order_id);
            return $notifies;
        } catch(\Exception $e) {
            return response(['error' => 'The department you want to edit can\'t be found in the database!' ], 400);
        } 
    }

    

    public function historyPurchase(Request $req)
    {
        try {
            $userID = auth('api')->user()->id;
            $req = $req->all();
            $notify = new NotifyRepo();
            $notifies = $notify->historyPurchase($userID, $req);
            return $notifies;
        } catch(\Exception $e) {
            return response(['error' => 'The department you want to edit can\'t be found in the database!' ], 400);
        } 
    }

    public function DetailHistoryPurchase(Request $req, $order_id)
    {
        try {
            $notify = new NotifyRepo();
            $notifies = $notify->DetailHistoryPurchase($order_id);
            return $notifies;
        } catch(\Exception $e) {
            return response(['error' => 'The department you want to edit can\'t be found in the database!' ], 400);
        } 
    }

    public function CancelOrder($order_id)
    {
        try {
            $userID = auth('api')->user()->id;
            $notify = new NotifyRepo();
            $notifies = $notify->CancelOrder($userID, $order_id);
            return $notifies;
        } catch(\Exception $e) {
            return response(['error' => 'The department you want to edit can\'t be found in the database!' ], 400);
        } 
    }
}
