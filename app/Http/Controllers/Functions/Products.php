<?php
namespace App\Http\Controllers\Functions;
use Constants;

use App\Product;

class Products {
    public static function addProduct($userID, $keys, $lst) {
        $product = new Product;
        $product->author = $userID;
        foreach ($keys as $key) {
            if (in_array($key, Constants::REQUIRED_DATA_FIELD_PRODUCT) == true)
                $product->$key = $lst[$key];
        }
        foreach ($keys as $key) {
            if (in_array($key, Constants::NOT_REQUIRED_DATA_FIELD_PRODUCT) == true && $lst[$key] != null)
                $product->$key = $lst[$key];
        }
        $successProduct = $product->save();
        return $successProduct;
    }

    public static function deleteProduct($author, $id) {
        $productsExists = Product::where('id', '=', $id)->where('author', '=', $author)->first();
        if (!$productsExists) {
            return 'error.not_found_item';
        }
        $productsExists->delete();
        return true;
    }
}