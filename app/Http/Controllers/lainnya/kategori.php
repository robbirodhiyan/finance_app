<?php

namespace App\Http\Controllers\lainnya;

use App\Models\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


class kategori extends Controller
{
  public function index()
  {
    $categories = Category::all();
    return view('content.lainnya.kategori', [
      'categories' => $categories
    ]);
  }
public function create()
  {
    // ELOQUENT
    return view('content.form.form-input-kategori');
  }
  public function store(Request $request)
  {
    // ELOQUENT
    $category = new Category;
    $category->name = $request->name;
    $category->save();
    return redirect()->route('kategori');
  }
}
