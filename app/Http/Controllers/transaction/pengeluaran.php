<?php

namespace App\Http\Controllers\transaction;

use App\Models\Credit;
use App\Models\Source;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\CreditLog;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class pengeluaran extends Controller
{
  public function index()
  {
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


    return view('content.transaction.pengeluaran', [
      'credits' => $credits
    ]);
  }
  public function create()
  {
    // ELOQUENT
    $categories = Category::all();
    $sources = Source::all();
    return view('content.form.form-input-pengeluaran', compact('categories', 'sources'));
  }
  public function store(Request $request)
  {
    $request->merge([
      'total' => str_replace('.', '', $request->total)
    ]);
    $request->validate([
      'name' => 'required',
      'description' => 'required',
      'total' => 'required|integer',
      'category' => 'required',
      'source' => 'required',
      'file' => 'file|mimes:pdf|max:2048'
    ]);
    if(!$request->date){
      $request->merge([
        'date' => Carbon::now()->format('Y-m-d')
      ]);
      $request->validate([
        'date' => 'required|date'
      ]);
    }

    if ($request->hasFile('file')) {
      $request->file=Storage::disk('s3')->putFile('finance/transaction/credit', $request->file('file'));
    }else{
      $request->file=null;
    }

    // ELOQUENT
    $credit = new Credit;
    $credit->name = $request->name;
    $credit->description = $request->description;
    $credit->total = $request->total;
    $credit->file = $request->file;
    // $credit->category_id = $request->category;
    // $credit->source_id = $request->source;
    $credit->date = $request->date;
    $credit->save();

    $log = new CreditLog;
    $log->credit = $credit->id;
    $log->category = $request->category;
    $log->source = $request->source;
    $log->save();
    return redirect()->route('pengeluaran');
  }
  public function edit(string $id)
  {
    // ELOQUENT
    $categories = Category::all();
    $sources = Source::all();
    $credit = Credit::find($id);
    $editUrl = route('editpengeluaran', ['credit' => $id]);
    return view('content.form.form-edit-pengeluaran', compact(
      'categories',
      'sources',
      'credit',
      'id'
    ));
  }

  public function update(Request $request, string $id)
  {
    // ELOQUENT
    $credit = Credit::find($id);
    // $credit->category_id = $request->category;
    // $credit->source_id = $request->source;
    $credit->save();

    $log = new CreditLog;
    $log->credit = $credit->id;
    $log->category = $request->category;
    $log->source = $request->source;
    $log->save();
    return redirect()->route('pengeluaran');
  }

  public function creditLog($id){
    $creditLog = CreditLog::select(
      'creditlog.*',
      'credits.name',
      'credits.total',
      'credits.date',
      // tambahkan kolom status_update,if created_at paling lama status_update=0 else status_update=1
      DB::raw('CASE
      WHEN creditlog.created_at = (
          SELECT MAX(created_at)
          FROM creditlog
          WHERE creditlog.credit = credits.id
      ) AND (
          SELECT COUNT(*)
          FROM creditlog
          WHERE creditlog.credit = credits.id
      ) > 1 THEN 1
      WHEN creditlog.created_at = (
          SELECT MIN(created_at)
          FROM creditlog
          WHERE creditlog.credit = credits.id
      ) THEN 0
      ELSE NULL
  END AS status_update'),
    )
      ->leftJoin('credits', 'credits.id', '=', 'creditlog.credit')
      ->where('credit', $id)
      ->get();

    return response()->json($creditLog);
  }
}
