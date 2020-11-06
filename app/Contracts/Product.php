<?php

namespace App\Contracts;

interface Product
{
    public function getMyProduct($lst);
    public function getProductSoldout($lst);
    public function getProductUnlisted($lst);
    public function ShowHideProduct($userId, $id);
}
