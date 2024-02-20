<?php

namespace App\Http\Controllers\transaction;

use App\Http\Controllers\Controller;
// use Illuminate\Http\Request;

class InputDebit extends Controller
{
  public function index()
  {
    return view('content.form.form-input-pemasukan');
  }

}
// class InputDebit extends Controller
// {
//   public function index()
//   {
//     return view('content.form.form-input-pemasukan');
//   }
// }
