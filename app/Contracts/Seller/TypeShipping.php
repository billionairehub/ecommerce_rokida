<?php

namespace App\Contracts\Seller;

interface TypeShipping
{
  public function addShippingChannels($productId, $keys, $lst);
  public function deleteShipping($lst);
  public function showAll($lst);
}
