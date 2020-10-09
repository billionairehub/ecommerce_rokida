<?php
namespace App\Http\Controllers\Functions;
use Constants;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

use App\Category;

class Categories {
    public static function addCategory($req) 
    {
        $all_categories = Category::where('name',$req->name)->first();
        if($all_categories){
            return  dd($result = [

                'success' => false,

                'code' => 400,

                'message'=> trans('message.categories_exist'),

                'data' => null

            ]);
        }
        $lst = $req->all();
        if(array_key_exists('img', $lst) ||  $req->file('img') != null)
        {
            $now = Carbon::now();
            $photo_name = Carbon::parse($now)->format('YmdHis').'.jpg';
            $path = $req->file('img')->storeAs('./img_categories/',$photo_name);
            $img_url = asset('/storage/img_categories/'.$photo_name);
            $categories = new Category;
            $categories->name = $req->name;
            $categories->img = $img_url;
            if (array_key_exists('cate_parent', $lst)) {
                $categories->cate_parent = $lst['cate_parent'];
            }
            if (array_key_exists('delete_by', $lst)) {
                $categories->delete_by = $lst['delete_by'];
            }
            $categories->save();
            $categories->slug = str_replace(' ', '-', $lst['name']) . '.' . $categories->id;
            $categories->save();
            return  dd($result = [

                'success' => false,

                'code' => 400,

                'message'=> trans('message.add_categories_success'),

                'data' => $categories

            ]);
        }
        else if($req->file('img') == null)
        {
            dd($result = [

                'success' => false,

                'code' => 400,

                'message'=> trans('message.photo_cannot_be_empty'),

                'data' => null

          ]);
        }
    }

    public static function updateCategory($req, $id) 
    {
        $all_categories = Category::where('name',$req->name)->where('id','<>',$id)->first();
        if($all_categories){
            return  dd($result = [

                'success' => false,

                'code' => 400,

                'message'=> trans('message.categories_exist'),

                'data' => null

            ]);
        }
        $lst = $req->all();
        if(array_key_exists('img', $lst) ||  $req->file('img') != null)
        {
            $now = Carbon::now();
            $photo_name = Carbon::parse($now)->format('YmdHis').'.jpg';
            $path = $req->file('img')->storeAs('./img_categories/',$photo_name);
            $img_url = asset('/storage/img_categories/'.$photo_name);
            $categories = Category::find($id);
            $categories->name = $req->name;
            $categories->img = $img_url;
            if (array_key_exists('cate_parent', $lst)) {
                $categories->cate_parent = $lst['cate_parent'];
            }
            if (array_key_exists('slug', $lst)) {
                $categories->slug = $lst['slug'];
            }
            else
            {
                $categories->slug = $lst['name'];
            }
            if (array_key_exists('delete_by', $lst)) {
                $categories->delete_by = $lst['delete_by'];
            }
            $categories->save();
            return  dd($result = [

                'success' => false,

                'code' => 400,

                'message'=> trans('message.update_categories_success'),

                'data' => null

            ]);
        }
        else if($req->file('img') == null)
        {
            dd($result = [

                'success' => false,

                'code' => 400,

                'message'=> trans('message.photo_cannot_be_empty'),

                'data' => null

          ]);
        }
    }

    public static function deleteCategory($id)
    {
        $category = Category::find($id);
        if($category)
        {
            $category->delete();
            return dd($result = [
    
                'success' => true,
    
                'code' => 400,
    
                'message'=> trans('message.delete_categories_success'),
    
                'data' => $category
    
            ]);
        }
        else
        {
            return dd($result = [
    
                'success' => true,
    
                'code' => 400,
    
                'message'=> trans('message.categories_not_exist'),
    
                'data' => $category
    
            ]);
        }
        
    }
}