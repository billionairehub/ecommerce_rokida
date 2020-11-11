<?php

namespace App\Contracts\User;

interface Categories
{
    public function getProductCategories();
    public function getDetailCategory($slug);
}
