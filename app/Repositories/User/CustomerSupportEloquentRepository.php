<?php
namespace App\Repositories\User;

use App\Contracts\User\CustomerSupport as ContractsSupport; // set để sử dụng 
use App\Repositories\EloquentRepository;

class CustomerSupportEloquentRepository extends EloquentRepository implements ContractsSupport
{

    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return \App\Models\Advisories::class;
    }   

    public function addAdvisory($userID, $req)
    {
        $lst = $req;
        $advisory = new $this->_model;
        $advisory->topic = $lst['topic'];
        $advisory->title = $lst['title'];
        $advisory->content = $lst['content'];
        $advisory->created_by = $userID;
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
    
    public function updateAdvisory($userID, $id, $req)
    {
        $advisory = $this->_model::find($id);
        $lst = $req;
        if(array_key_exists('topic', $lst) && $lst['topic'] != null)
        {
            $advisory->topic = $lst['topic'];
        }
        if(array_key_exists('title', $lst) && $lst['title'] != null)
        {
            $advisory->title = $lst['title'];
        }
        if(array_key_exists('content', $lst) && $lst['content'] != null)
        {
            $advisory->content = $lst['content'];
        }
        $advisory->updated_by = $userID;
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

    public function deleteAdvisory($userID, $id)
    {
        $advisory = $this->_model::find($id);
        $advisory->deleted_by = $userID;
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

    public function getallAdvisory($lst_get)
    {
        $lst = $lst_get;
        $data = $this->_model::all();
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

    public function searchAdvisory($lst_get)
    {
        $lst = $lst_get;
        $data = $this->_model::where('title', 'LIKE', '%'.$lst['key'].'%')->get();
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