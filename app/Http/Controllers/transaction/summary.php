<?php

namespace App\Http\Controllers\transaction;

use App\Models\Debit;
use App\Models\Credit;
use App\Http\Controllers\Controller;

class summary extends Controller
{
  public function index()
  {
    $debits = Debit::select(['debits.*', 'debitlog.source', 'debitlog.category'])
    ->selectSub(function ($query) {
      $query->selectRaw('COUNT(*) > 1')
        ->from('debitlog')
        ->whereRaw('debitlog.debit = debits.id');
    }, 'status_update')
    ->join('debitlog', function ($join) {
      $join->on('debitlog.debit', '=', 'debits.id')
        ->whereRaw('debitlog.id = (select max(id) from debitlog where debitlog.debit = debits.id)');
    })
    ->get();
    $credits = Credit::select(['credits.*', 'creditlog.source', 'creditlog.category'])
    ->selectSub(function ($query) {
      $query->selectRaw('COUNT(*) > 1')
        ->from('creditlog')
        ->whereRaw('creditlog.credit = credits.id');
    }, 'status_update')
    ->join('creditlog', function ($join) {
      $join->on('creditlog.credit', '=', 'credits.id')
        ->whereRaw('creditlog.id = (select max(id) from creditlog where creditlog.credit = credits.id)');
    })
    ->get();
    $transactions = $debits->concat($credits);


    return view('content.transaction.summary', [
      'debits' => $debits,
      'credits' => $credits,
      'transactions' => $transactions
    ]);
  }
}
