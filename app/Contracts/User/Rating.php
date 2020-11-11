<?php

namespace App\Contracts\User;

interface Rating
{
    public function AddRateProduct($req, $id);
    public function UpdateRateProduct($req, $id);
    public function DeleteRate($id);
    public function GetRateProduct($slug, $lst);
}
