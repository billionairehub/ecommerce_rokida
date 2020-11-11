<?php

namespace App\Contracts\Seller;

interface Classify
{
  public function addClassify($productId, $keys, $lst);
  public function getAllClassify($product);
  public function singleDelete($id);
  public function delete($product);
  public function update ($id, $lst);
}
