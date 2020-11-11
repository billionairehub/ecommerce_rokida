<?php
namespace App\Repositories\Seller;

use App\Contracts\Seller\Product as ContractsProduct;

use App\Repositories\Seller\PromotionEloquentRepository as PromotionRepo;
use App\Repositories\Seller\ClassifyEloquentRepository as ClassifyRepo;
use App\Repositories\Seller\TypeShippingsEloquentRepository as TypeShippingRepo;

use App\Models\Backend\Product;
use App\Models\Backend\Category;
use App\Models\Backend\User;
use App\Models\Backend\Shop;
use App\Models\Backend\Promotion;
use App\Models\Backend\Classify;
use App\Models\Backend\TypeShipping;

use Validators;

use Constants;

use App\Http\Controllers\Functions\Seller\ResizeImage;

class ProductEloquentRepository extends EloquentRepository implements ContractsProduct
{

    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return \App\Models\Backend\Product::class;
    }

    public function getMyProduct($lst){
        $userId = User::getUserId();
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

    public function getProductSoldout($lst) {
        $userId = User::getUserId();
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

    public function getProductUnlisted($lst) {
        $userId = User::getUserId();
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
        $product = Product::where('author', '=', $userId)->where('hidden', '=', 1)->where('name', 'like', '%' . $name . '%')->where('infringe', '=', 0)->where('sku', 'like', '%' . $sku . '%')->where('product_code', 'like', '%' . $product_code . '%')->where('trademark', 'like', '%' . $branch . '%')->where('amount', '>=', $stockMin)->where('amount', '<=', $stockMax)->where('consumed', '>=', $soldMin)->where('consumed', '<=', $soldMax)->where('categories', 'like', '%' . $category . '%')->limit($limit)->offset($offset)->get();
        return $product;
    }

    public function showHideProduct($id) {
        $userId = User::getUserId();
        $product = Product::where('author', '=', $userId)->where('id', '=', $id)->first();
        $product->hidden = !$product->hidden;
        $product->save();
        return $product;
    }

    public function addProduct($keys, $lst) {
        $userID = User::getUserId();
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
        $product->slug = str_replace(' ', '-', $product->name) . '.' . $product->id;
        $product->product_code = $product->id;
        $product->save();
        if (Validators::requiredFieldPromotion($lst) == 1)
            $promotion = new PromotionRepo();
            $product->promotion = $promotion->addPromotion($product->id, $keys, $lst);
        if (Validators::requiredFieldClassify($lst) == 1)
            $classify = new ClassifyRepo();
            $product->classify = $classify->addClassify($product->id, $keys, $lst);
            $TypeShipping = new TypeShippingRepo();
            $product->TypeShipping = $TypeShipping->addShippingChannels($product->id, $keys, $lst);
        return $product;
    }

    public function updateProduct($keys, $lst, $id) {
        $userID = User::getUserId();
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
        return $product;
    }

    public function deleteProduct($id) {
        $userID = User::getUserId();
        $productsExists = Product::where('id', '=', $id)->where('author', '=', $userID)->first();
        if (!$productsExists) {
            return null;
        }
        $productsExists->deleted_by = $userID;
        $productsExists->save();
        $promotion = new PromotionRepo();
        $productsExists->promotion = $promotion->deletePromotionFollowProduct($id);
        $typeShipping = new TypeShippingRepo();
        $productsExists->typeShipping = $typeShipping->deleteShippingChannelFollowProduct($id);
        $classify = new ClassifyRepo();
        $productsExists->classify = $classify->deleteClassifyFollowProduct($id);
        $productsExists->delete();
        return $productsExists;
    }
}