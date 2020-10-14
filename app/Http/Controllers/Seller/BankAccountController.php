<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Validators;

use App\Http\Controllers\Functions\Seller\BankAccounts;

class BankAccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $lst = $_GET;
        $userId = 1;
        $success = BankAccounts::getAllCards($userId, $lst);
        return $success;
    }

    public function changeDefault($id)
    {
        $lst = $_GET;
        $userId = 1;
        $success = BankAccounts::changeDefault($userId, $id);
        if ($success == false || $success == null) {
            return trans('error.account_bank_is_default');
        } else {
            return $success;
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $lst = $request->all();
        $keys = $request->keys();
        $userId = 1;
        $valid = Validators::requiredFieldBankAccount($lst, $keys);
        if ($valid == false) {
            return trans('error.not_complete_information');
        }
        $success = BankAccounts::addCard($userId, $keys, $lst);
        if ($success == false) {
            return trans('error.account_bank_exists');
        }
        return $success;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $userId = 1;
        $success = BankAccounts::getCard($userId, $id);
        return $success;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $userId = 1;
        $success = BankAccounts::destroyCard($userId, $id);
        if ($success == false) {
            return trans('error.can_not_delete');
        } else {
            return trans('message.delete_bank_succcess');
        }
    }
}
