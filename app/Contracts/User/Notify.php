<?php

namespace App\Contracts\User;

interface Notify
{
    public function getNotify($userID);
    public function getNotifyofOrder($user, $list);
    //public function CreateNotify($req);
    public function completepacking($order_id);
    public function packagereceived($req, $order_id);
    public function SendDepot($req, $order_id);
    public function Transport($req, $order_id);
    public function ShipWay($req, $order_id);
    public function ChangeDepot($req, $order_id);
    public function CompleteShip($req, $order_id);
    public function historyPurchase($user, $req);
    public function DetailHistoryPurchase($order_id);
    public function CancelOrder($userID, $order_id);
}
