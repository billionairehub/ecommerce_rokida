<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Advisories;
use App\Repositories\User\CustomerSupportEloquentRepository as SupportRepo;

class SupportController extends Controller
{
    public function addAdvisory(Request $req)
    {
        try {
            $userID = auth('api')->user()->id;
            $support = new SupportRepo();
            $supports = $support->addAdvisory($userID, $req);
            return $supports;
        } catch(\Exception $e) {
            return response(['error' => 'The department you want to edit can\'t be found in the database!' ], 400);
        }
    }

    public function updateAdvisory(Request $req, $id)
    {
        try {
            $lst = $req->all();
            $userID = auth('api')->user()->id;
            $support = new SupportRepo();
            $supports = $support->updateAdvisory($userID, $id, $lst);
            return $supports;
        } catch(\Exception $e) {
            return response(['error' => 'The department you want to edit can\'t be found in the database!' ], 400);
        }
    }

    public function deleteAdvisory(Request $req, $id)
    {
        try {
            $userID = auth('api')->user()->id;
            $support = new SupportRepo();
            $supports = $support->deleteAdvisory($userID, $id);
            return $supports;
        } catch(\Exception $e) {
            return response(['error' => 'The department you want to edit can\'t be found in the database!' ], 400);
        }
    }

    public function getallAdvisory()
    {
        try {
            $lst_get = $_GET;
            $support = new SupportRepo();
            $supports = $support->getallAdvisory($lst_get);
            return $supports;
        } catch(\Exception $e) {
            return response(['error' => 'The department you want to edit can\'t be found in the database!' ], 400);
        }
    }

    public function searchAdvisory()
    {
        try {
            $lst_get = $_GET;
            $support = new SupportRepo();
            $supports = $support->searchAdvisory($lst_get);
            return $supports;
        } catch(\Exception $e) {
            return response(['error' => 'The department you want to edit can\'t be found in the database!' ], 400);
        }
    }

}
