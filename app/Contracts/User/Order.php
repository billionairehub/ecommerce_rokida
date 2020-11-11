<?php

namespace App\Contracts\User;

interface Order
{
    public function ShoppingCart($id);
    public function updateCart($lst, $id_user);
    public function confirmCart($lst);
    public function getVoucher();
    public function Voucherwallet($user_id, $type);
    public function OrderPayment($user_id, $req);
    public function ReceivedOrder($order_id);
    public function NotifyOrder($id_user);
    public function SameProductOfShop($slug);
    public function SameProducts($slug);
    public function ProductsJustForYou();
    public function SellProducts();
}
