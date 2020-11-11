<?php

namespace App\Contracts\User;

interface Product
{
    public function getSaleProduct();
    public function searchProduct($keyword);
    public function TopProducts();
    public function TopKeySearch();
}
