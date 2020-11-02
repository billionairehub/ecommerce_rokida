<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Advisories;

class SupportController extends Controller
{
    public function addAdvisory(Request $req)
    {
        $advisory = new Advisories;
        $advisory->topic = $req->input('topic');
        $advisory->title = $req->input('title');
        $advisory->content = $req->input('content');
        $advisory->created_by = $req->created_by;
        // $advisory->updated_by = $req->updated_by;
        // $advisory->deleted_by = $req->deleted_by;
        $data = $advisory->save();
        if($data)
            {
                return  response()->json([

                    'status' => true,
    
                    'code' => 200,
    
                    'message' => trans('message.add_success'),
                    
                    'data' => $advisory
    
                ], 200);
            }
            else
            {
                return  response()->json([

                    'status' => false,
    
                    'code' => 200,
    
                    'message' => trans('message.add_unsuccess')
    
                ], 200);
            }
    }

    public function updateAdvisory(Request $req, $id)
    {
        $advisory = Advisories::find($id);
        $lst = $req->all();
        if(array_key_exists('topic', $lst) && $lst['topic'] != null)
        {
            $advisory->topic = $lst['topic'];
        }
        if(array_key_exists('title', $lst) && $lst['title'] != null)
        {
            $advisory->title = $req->input('title');
        }
        if(array_key_exists('content', $lst) && $lst['content'] != null)
        {
            $advisory->content = $req->input('content');
        }
        $advisory->updated_by = $req->updated_by;
        // $advisory->deleted_by = $req->deleted_by;
        $data = $advisory->save();
        if($data)
            {
                return  response()->json([

                    'status' => true,
    
                    'code' => 200,
    
                    'message' => trans('message.update_success'),
                    
                    'data' => $advisory
    
                ], 200);
            }
            else
            {
                return  response()->json([

                    'status' => false,
    
                    'code' => 400,
    
                    'message' => trans('message.update_unsuccess')
    
                ], 400);
            }
    }

    public function deleteAdvisory(Request $req, $id)
    {
        $advisory = Advisories::find($id);
        $advisory->deleted_by = $req->deleted_by;
        $data = $advisory->delete();
        if($data)
            {
                return  response()->json([

                    'status' => true,
    
                    'code' => 200,
    
                    'message' => trans('message.delete_success'),
                    
                    'data' => $advisory
    
                ], 200);
            }
            else
            {
                return  response()->json([

                    'status' => false,
    
                    'code' => 400,
    
                    'message' => trans('message.delete_unsuccess')
    
                ], 400);
            }
    }

    public function getallAdvisory()
    {
        $lst = $_GET;
        $data = Advisories::all();
        if(array_key_exists('topic', $lst) && $lst['topic'] != null)
        {
            $data = $data->where('topic', 'LIKE', $lst['topic']);
        }
        if(count($data) > 0)
        {
            $data = $data;
        }
        else 
        {
            $data = null;
        }
        if($data)
        {
            return  response()->json([

                'status' => true,
    
                'code' => 200,
    
                'message' => trans('message.get_success'),
                    
                'data' => $data
    
            ], 200);
        }
        else
        {
            return  response()->json([

                'status' => false,
    
                'code' => 400,
    
                'message' => trans('message.get_unsuccess'),

                'data' => $data
    
            ], 400);
        }
        
    }

    public function searchAdvisory()
    {
        $lst = $_GET;
        $data = Advisories::where('title', 'LIKE', '%'.$lst['key'].'%')->get();
        if(count($data) > 0)
        {
            $data = $data;
        }
        else 
        {
            $data = null;
        }
        if($data)
        {
            return  response()->json([

                'status' => true,
    
                'code' => 200,
    
                'message' => trans('message.get_success'),
                    
                'data' => $data
    
            ], 200);
        }
        else
        {
            return  response()->json([

                'status' => false,
    
                'code' => 400,
    
                'message' => trans('message.get_unsuccess'),

                'data' => $data
    
            ], 400);
        }
    }
}
