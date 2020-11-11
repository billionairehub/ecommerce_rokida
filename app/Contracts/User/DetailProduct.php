<?php

namespace App\Contracts\User;

interface DetailProduct
{
    public function getdetailPro($lst);
    public function addShoppingCart($req, $slug);
}
