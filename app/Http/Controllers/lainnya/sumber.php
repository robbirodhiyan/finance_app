<?php

namespace App\Http\Controllers\lainnya;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Debit;
use App\Models\Source;

class sumber extends Controller
{
  public function index()
  {
    $sources = Source::all();
    return view('content.lainnya.sumber', [
      'sources' => $sources
    ]);
  }
public function create()
  {
    // ELOQUENT
    return view('content.form.form-input-sumber');
  }
  public function store(Request $request)
  {
    // ELOQUENT
    $category = new Source;
    $category->name = $request->name;
    $category->save();
    return redirect()->route('sumber');
  }
}
