<?php
namespace App\Repositories\Seller;

use App\Repositories\Seller\EloquentRepository;

use App\Contracts\Seller\Bank as ContractsBank;

use Constants;

use Carbon\Carbon;

use App\Models\Backend\User;

use App\Models\Backend\BankAccount;
// Product Banded
class BankEloquentRepository extends EloquentRepository implements ContractsBank
{

  /**
   * get model
   * @return string
   */
  public function getModel()
  {
      return \App\Models\Backend\BankAccount::class;
  }

  public function getAllCards($lst) {
    $userId = User::getUserId();
    $bank = BankAccount::where('user_id', '=', $userId)->get();
    return $bank;
  }

}