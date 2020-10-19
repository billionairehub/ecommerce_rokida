<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Controllers\Functions\Seller\Settings;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userId = 1;
        $success = Settings::getSetting($userId);
        return $success;
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        //
    }

    public function enablePhoneCall () {
        // Cho phep nguoi mua goi
        $userId = 1;
        $success = Settings::enablePhoneCall($userId);
        return $success;
    }

    public function enableVacationMode () {
        // Bat che  do tam nghi
        $userId = 1;
        $success = Settings::enableVacationMode($userId);
        return $success;
    }

    public function transifyLang () {
        // Chuyen doi ngon ngu
        $lst = $_GET;
        $userId = 1;
        $success = Settings::transifyLang($userId, $lst);
        if ($success == false) {
            return trans('error.not_found_language');
        }
        return $success;
    }

    public function creditcardPaymentEnabled () {
        // Thanh toan bang credit card
        $userId = 1;
        $success = Settings::creditcardPaymentEnabled($userId);
        return $success;
    }

    public function changePaymentPassword (Request $request) {
        // Thay doi mat khau
        $userId = 1;
        $lst = $request->all();
        $success = Settings::changePaymentPassword($userId, $lst);
        if (gettype($success) == 'string') {
            return trans($success);
        }
        return $success;
    }

    public function feedPrivate () {
        // Hoat dong rieng tu
        $userId = 1;
        $success = Settings::feedPrivate($userId);
        return $success;
    }

    public function hideLike () {
        // An thich cua toi
        $userId = 1;
        $success = Settings::hideLike($userId);
        return $success;
    }

    public function blockLists () {
        // Danh sach bi chan
    }

    public function deleteUserBlockList () {
        // Xoa nguoi khoi danh sach chan
    }

    public function makeOfferStatus () {
        // Cho phep tra gia
        $userId = 1;
        $success = Settings::makeOfferStatus($userId);
        return $success;
    }

    public function chatStatus () {
        // Chat tu trang ho so ca nhan
        $userId = 1;
        $success = Settings::chatStatus($userId);
        return $success;
    }

    public function enableEmailNotifications () {
        // Thong bao email
        $userId = 1;
        $success = Settings::enableEmailNotifications($userId);
        return $success;
    }

    public function enableOrderUpdatesEmail () {
        // Cap nhat don hang
        $userId = 1;
        $success = Settings::enableOrderUpdatesEmail($userId);
        return $success;
    }

    public function enableNewsletter () {
        // Ban tin
        $userId = 1;
        $success = Settings::enableNewsletter($userId);
        return $success;
    }

    public function enableListingUpdates () {
        // Cap nhat san pham
        $userId = 1;
        $success = Settings::enableListingUpdates($userId);
        return $success;
    }

    public function enablePersonalisedContent () {
        // Noi dung ca nhan
        $userId = 1;
        $success = Settings::enablePersonalisedContent($userId);
        return $success;
    }

    public function enablePushNotifications () {
        // Bat thong bao
        $userId = 1;
        $success = Settings::enablePushNotifications($userId);
        return $success;
    }

    public function enableNotificationsByBatch () {
        // Thong bao theo nhom
        $userId = 1;
        $success = Settings::enableNotificationsByBatch($userId);
        return $success;
    }

    public function enableOrderUpdatesPush () {
        // Cap nhat don hang
        $userId = 1;
        $success = Settings::enableOrderUpdatesPush($userId);
        return $success;
    }

    public function enableChats () {
        // Chats
        $userId = 1;
        $success = Settings::enableChats($userId);
        return $success;
    }

    public function enableShopeePromotions () {
        // Khuyen mai shopee
        $userId = 1;
        $success = Settings::enableShopeePromotions($userId);
        return $success;
    }

    public function enableFollowsAndComments () {
        // Theo doi va binh luan
        $userId = 1;
        $success = Settings::enableFollowsAndComments($userId);
        return $success;
    }

    public function enableProductsSoldOut () {
        // San pham het hang
        $userId = 1;
        $success = Settings::enableProductsSoldOut($userId);
        return $success;
    }

    public function enableWalletUpdates () {
        // Cap nhat vi
        $userId = 1;
        $success = Settings::enableWalletUpdates($userId);
        return $success;
    }
}
