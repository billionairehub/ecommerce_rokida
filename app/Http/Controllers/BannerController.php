<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use App\Banner;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $listBanner = Banner::orderBy('created_at','desc')->limit(5)->get();//select top 5 banner
        dd($listBanner);
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
        $newBanner = new Banner();
        $now = Carbon::now();
        $photo_name = Carbon::parse($now)->format('YmdHis').'.jpg';
        $path = $request->file('url_img')->storeAs('./img_banner/',$photo_name);
        $img_url = asset('/storage/img_banner/'.$photo_name); 
        $newBanner->url_img = $img_url;
        $newBanner->active = 1;
        $newBanner->category_id = 1;
        $newBanner->save();
        if($newBanner)
        {
            dd('INSERT SUCCESS!');
        }
        else
        {
            dd('NOT INSERT SUCCESS!');
        }

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
        $newBanner = Banner::find($id);
        if(!$newBanner){
            dd('Thông tin không tồn tại!');
        }
        else
        {
            $img_del = $newBanner->url_img;
            $str = str_replace( 'http://localhost:8000/storage/img_banner/', '', $img_del );
            $del = Storage::disk('local')->delete('public/img_banner/'.$str);
            $now = Carbon::now();
            $photo_name = Carbon::parse($now)->format('YmdHis').'.jpg';
            $path = $request->file('url_img')->storeAs('./img_banner/',$photo_name);
            $img_url = asset('/storage/img_banner/'.$photo_name); 
            $newBanner->url_img = $img_url;
            $newBanner->active = 1;
            $newBanner->category_id = 1;
            $newBanner->save();
            if($newBanner)
            {
                dd('UPDATE SUCCESS!');
            }
            else
            {
                dd('NOT UPDATE SUCCESS!');
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $bananer = Banner::find($id);
        if(!$bananer){
            dd(trans('message.not_exits'));
        }
        else
        {
            $bananer->delete();
            dd(trans('message.success'));
        }
        
    }
}
