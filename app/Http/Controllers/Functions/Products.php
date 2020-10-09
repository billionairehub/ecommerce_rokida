<?php
namespace App\Http\Controllers\Functions;
use Constants;

use App\Product;
use App\Category;
use App\User;
use App\Shop;
use App\Http\Controllers\Functions\ResizeImage;

class Products {
    public static function addProduct($userID, $keys, $lst) {
        $product = new Product;
        $product->author = $userID;
        foreach ($keys as $key) {
            if (in_array($key, Constants::REQUIRED_DATA_FIELD_PRODUCT) == true){
                if ($key == 'thumb') {
                    $uri = ResizeImage::resize($lst[$key]);
                    $product->$key = $uri;
                } else if ($key == 'image') {
                    $uri = ResizeImage::resize($lst[$key]);
                    $product->$key = $uri;
                } else {
                    $product->$key = $lst[$key];
                }
            }
        }
        foreach ($keys as $key) {
            if (in_array($key, Constants::NOT_REQUIRED_DATA_FIELD_PRODUCT) == true && $lst[$key] != null)
            if ($key == 'img_user_manual') {
                $uri = ResizeImage::resize($lst[$key]);
                    $product->$key = $uri;
            } else {
                $product->$key = $lst[$key];
            }
        }
        $successProduct = $product->save();
        return $product;
    }

    public static function updateProduct($userID, $keys, $lst, $id) {
        $product = Product::where('author', '=', $userID)->where('id', '=', $id)->first();
        if (!$product)
            return false;
        foreach ($keys as $key) {
            if ($key == 'image' || $key == 'thumb' || $key == 'img_user_manual') {
                $uri = ResizeImage::resize($lst[$key]);
                $product->$key = $uri;
            } else $product->$key = $lst[$key];
        }
        $product->save();
        return true;
    }

    public static function deleteProduct($author, $id) {
        $productsExists = Product::where('id', '=', $id)->where('author', '=', $author)->first();
        if (!$productsExists) {
            return 'error.not_found_item';
        }
        $productsExists->deleted_by = $author;
        $productsExists->save();
        $productsExists->delete();
        return true;
    }

    public static function getListAll($userId, $lst) {
        $offset = Constants::OFFSET;
        $limit = Constants::LIMIT;
        $name = '';
        $sku = '';
        $product_code = '';
        $branch = '';
        $category = '';
        $stockMin = Constants::STOCK_MIN;
        $stockMax = Constants::STOCK_MAX;
        $soldMin = Constants::SOLD_MIN;
        $soldMax = Constants::SOLD_MAX;
        if (array_key_exists('offset', $lst) && $lst['offset'] != null) {
            $offset = $lst['offset'];
        }
        if (array_key_exists('limit', $lst) && $lst['limit'] !=  null) {
            $limit = $lst['limit'];
        }
        if (array_key_exists('name', $lst) && $lst['name'] !=  null) {
            $name = $lst['name'];
        }
        if (array_key_exists('sku', $lst) && $lst['sku'] !=  null) {
            $sku = $lst['sku'];
        }
        if (array_key_exists('product_code', $lst) && $lst['product_code'] !=  null) {
            $product_code = $lst['product_code'];
        }
        if (array_key_exists('branch', $lst) && $lst['branch'] !=  null) {
            $branch = $lst['branch'];
        }
        if (array_key_exists('stockMin', $lst) && $lst['stockMin'] !=  null) {
            $stockMin = $lst['stockMin'];
        }
        if (array_key_exists('stockMax', $lst) && $lst['stockMax'] !=  null) {
            $stockMax = $lst['stockMax'];
        }
        if (array_key_exists('soldMin', $lst) && $lst['soldMin'] !=  null) {
            $soldMin = $lst['soldMin'];
        }
        if (array_key_exists('soldMax', $lst) && $lst['soldMax'] !=  null) {
            $soldMax = $lst['soldMax'];
        }
        if (array_key_exists('category', $lst) && $lst['category'] !=  null) {
            $cate = Category::where('name', '=', $lst['category'])->first('id');
            $category = $cate->id;
        }
        $product = Product::where('author', '=', $userId)->where('name', 'like', '%' . $name . '%')->where('infringe', '=', 0)->where('sku', 'like', '%' . $sku . '%')->where('product_code', 'like', '%' . $product_code . '%')->where('trademark', 'like', '%' . $branch . '%')->where('amount', '>=', $stockMin)->where('amount', '<=', $stockMax)->where('consumed', '>=', $soldMin)->where('consumed', '<=', $soldMax)->where('categories', 'like', '%' . $category . '%')->limit($limit)->offset($offset)->get();
        for ($i = 0; $i < count($product); $i++) {
            $product[$i]->thumb = str_replace(' ', '', $product[$i]->thumb);
            $product[$i]->thumb = explode(', ', $product[$i]->thumb);
            $product[$i]->image = str_replace(' ', '', $product[$i]->image);
            $product[$i]->image = explode(', ', $product[$i]->image);
            $product[$i]->img_user_manual = str_replace(' ', '', $product[$i]->img_user_manual);
            $product[$i]->img_user_manual = explode(', ', $product[$i]->img_user_manual);
            $author = User::where('id', '=', $product[$i]->author)->first();
            $product[$i]->author = $author;
            $shop = Shop::where('id', '=', $product[$i]->shop_id)->first();
            $product[$i]->shop_id = $shop;
            $categories = Category::where('id', '=', $product[$i]->categories)->first();
            $product[$i]->categories = $categories;
        }
        return $product;
    }

    public static function getListSoldout($userId, $lst) {
        $offset = Constants::OFFSET;
        $limit = Constants::LIMIT;
        $name = '';
        $sku = '';
        $product_code = '';
        $branch = '';
        $category = '';
        $soldMin = Constants::SOLD_MIN;
        $soldMax = Constants::SOLD_MAX;
        if (array_key_exists('offset', $lst) && $lst['offset'] != null) {
            $offset = $lst['offset'];
        }
        if (array_key_exists('limit', $lst) && $lst['limit'] !=  null) {
            $limit = $lst['limit'];
        }
        if (array_key_exists('name', $lst) && $lst['name'] !=  null) {
            $name = $lst['name'];
        }
        if (array_key_exists('sku', $lst) && $lst['sku'] !=  null) {
            $sku = $lst['sku'];
        }
        if (array_key_exists('product_code', $lst) && $lst['product_code'] !=  null) {
            $product_code = $lst['product_code'];
        }
        if (array_key_exists('branch', $lst) && $lst['branch'] !=  null) {
            $branch = $lst['branch'];
        }
        if (array_key_exists('soldMin', $lst) && $lst['soldMin'] !=  null) {
            $soldMin = $lst['soldMin'];
        }
        if (array_key_exists('soldMax', $lst) && $lst['soldMax'] !=  null) {
            $soldMax = $lst['soldMax'];
        }
        if (array_key_exists('category', $lst) && $lst['category'] !=  null) {
            $cate = Category::where('name', '=', $lst['category'])->first('id');
            $category = $cate->id;
        }
        $product = Product::where('author', '=', $userId)->where('amount', '=', 0)->where('name', 'like', '%' . $name . '%')->where('sku', 'like', '%' . $sku . '%')->where('product_code', 'like', '%' . $product_code . '%')->where('trademark', 'like', '%' . $branch . '%')->where('consumed', '>=', $soldMin)->where('consumed', '<=', $soldMax)->where('categories', 'like', '%' . $category . '%')->limit($limit)->offset($offset)->get();
        for ($i = 0; $i < count($product); $i++) {
            $product[$i]->thumb = str_replace(' ', '', $product[$i]->thumb);
            $product[$i]->thumb = explode(', ', $product[$i]->thumb);
            $product[$i]->image = str_replace(' ', '', $product[$i]->image);
            $product[$i]->image = explode(', ', $product[$i]->image);
            $product[$i]->img_user_manual = str_replace(' ', '', $product[$i]->img_user_manual);
            $product[$i]->img_user_manual = explode(', ', $product[$i]->img_user_manual);
            $author = User::where('id', '=', $product[$i]->author)->first();
            $product[$i]->author = $author;
            $shop = Shop::where('id', '=', $product[$i]->shop_id)->first();
            $product[$i]->shop_id = $shop;
            $categories = Category::where('id', '=', $product[$i]->categories)->first();
            $product[$i]->categories = $categories;
        }
        return $product;
    }
}