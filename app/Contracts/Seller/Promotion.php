<?php

namespace App\Contracts\Seller;

interface Promotion
{
    public function addPromotion($productId, $keys, $lst);
    public function getAllPromotion($lst);
    public function singleDelete($id);
}
