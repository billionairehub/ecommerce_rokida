<?php

namespace App\Contracts\User;

interface CustomerSupport
{
    public function addAdvisory($userID, $req);
    public function updateAdvisory($userID, $id, $req);
    public function deleteAdvisory($userID, $id);
    public function getallAdvisory($lst_get);
    public function searchAdvisory($lst_get);
}
