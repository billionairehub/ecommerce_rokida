<?php

namespace App\Contracts\Seller;

interface Product
{
    public function getMyProduct($lst);
    public function getProductSoldout($lst);
    public function getProductUnlisted($lst);
    public function ShowHideProduct($id);
    public function addProduct($keys, $lst);
    public function updateProduct($keys, $lst, $id);
    public function deleteProduct($id);
}
