<?php

namespace App\Contracts\Seller;

interface Infringes
{
    public function getListAll($lst);
    public function getListHistory($lst);
}
