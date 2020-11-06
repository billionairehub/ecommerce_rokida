<?php
namespace App\Repositories;

use App\Contracts\Product as ContractsProduct;

use Constants;

use App\Models\Product;
use App\Models\Category;
use App\Models\User;
use App\Models\Shop;
use App\Http\Controllers\Functions\Seller\ResizeImage;

class ProductEloquentRepository extends EloquentRepository implements ContractsProduct
{

    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return \App\Models\Product::class;
    }

    public function getMyProduct($lst)
    {
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
      $product = Product::where('author', '=', $lst['user_id'])->where('name', 'like', '%' . $name . '%')->where('infringe', '=', 0)->where('sku', 'like', '%' . $sku . '%')->where('product_code', 'like', '%' . $product_code . '%')->where('trademark', 'like', '%' . $branch . '%')->where('amount', '>=', $stockMin)->where('amount', '<=', $stockMax)->where('consumed', '>=', $soldMin)->where('consumed', '<=', $soldMax)->where('categories', 'like', '%' . $category . '%')->limit($limit)->offset($offset)->get();
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

    public function getProductSoldout($lst) {
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
        $product = Product::where('author', '=', $lst['user_id'])->where('amount', '=', 0)->where('name', 'like', '%' . $name . '%')->where('sku', 'like', '%' . $sku . '%')->where('product_code', 'like', '%' . $product_code . '%')->where('trademark', 'like', '%' . $branch . '%')->where('consumed', '>=', $soldMin)->where('consumed', '<=', $soldMax)->where('categories', 'like', '%' . $category . '%')->limit($limit)->offset($offset)->get();
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

    public function getProductUnlisted($lst) {
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
        $product = Product::where('author', '=', $lst['user_id'])->where('hidden', '=', 1)->where('name', 'like', '%' . $name . '%')->where('infringe', '=', 0)->where('sku', 'like', '%' . $sku . '%')->where('product_code', 'like', '%' . $product_code . '%')->where('trademark', 'like', '%' . $branch . '%')->where('amount', '>=', $stockMin)->where('amount', '<=', $stockMax)->where('consumed', '>=', $soldMin)->where('consumed', '<=', $soldMax)->where('categories', 'like', '%' . $category . '%')->limit($limit)->offset($offset)->get();
        return $product;
    }

    public function showHideProduct($userId, $id) {
        $product = Product::where('author', '=', $userId)->where('id', '=', $id)->first();
        $product->hidden = !$product->hidden;
        $product->save();
        return $product;
    }
}