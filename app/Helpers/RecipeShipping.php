<?php
namespace App\Helpers;

class RecipeShipping
{
  public static function giaoHangNhanh ($weight, $length, $width, $height) {
    return (ceil($weight + $length + $width + $height));
  }
}