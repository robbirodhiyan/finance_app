<?php

namespace App\Http\Controllers\transaction;

use App\Models\Debit;
use App\Models\DebitLog;
use App\Models\Source;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Aws\S3\S3Client;


class pemasukan extends Controller
{
  public function index()
  {
    // $debits = Debit::all();

    // debit = Debit join debitlog ambil data debitlog yang terbaru
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


    return view('content.transaction.pemasukan', [
      'debits' => $debits
    ]);
  }
  public function create()
  {
    // ELOQUENT
    $categories = Category::all();
    $sources = Source::all();
    return view('content.form.form-input-pemasukan', compact('categories', 'sources'));
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

    if (!$request->date) {
      $request->merge([
        'date' => Carbon::now()->format('Y-m-d')
      ]);
    }

    if ($request->hasFile('file')) {
      $request->file=Storage::disk('s3')->putFile('finance/transaction/debit', $request->file('file'));
    }else{
      $request->file=null;
    }





    $debit = new Debit;
    $debit->name = $request->name;
    $debit->file = $request->file;
    $debit->description = $request->description;
    $debit->total = $request->total;
    // $debit->category_id = $request->category;
    // $debit->source_id = $request->source;
    $debit->date = $request->date;
    $debit->save();

    $log = new DebitLog;
    $log->debit = $debit->id;
    $log->source = $request->source;
    $log->category = $request->category;
    $log->save();
    return redirect()->route('pemasukan');
  }
  public function edit(string $id)
  {
    // ELOQUENT
    $categories = Category::all();
    $sources = Source::all();
    $debit = Debit::find($id);
    $editUrl = route('editpemasukan', ['debit' => $id]);
    return view('content.form.form-edit-pemasukan', compact(
      'categories',
      'sources',
      'debit',
      'id'
    ));
  }

  public function update(Request $request, string $id)
  {
    // ELOQUENT
    $debit = Debit::find($id);
    // $debit->category_id = $request->category;
    // $debit->source_id = $request->source;
    $debit->save();

    $log = new DebitLog;
    $log->debit = $debit->id;
    $log->source = $request->source;
    $log->category = $request->category;
    $log->save();
    return redirect()->route('pemasukan');
  }

  public function debitLog($id)
  {
    $debitLog = DebitLog::select(
      'debitlog.*',
      'debits.name',
      'debits.total',
      'debits.date',
      // tambahkan kolom status_update,if created_at paling lama status_update=0 else status_update=1
      DB::raw('CASE
      WHEN debitlog.created_at = (
          SELECT MAX(created_at)
          FROM debitlog
          WHERE debitlog.debit = debits.id
      ) AND (
          SELECT COUNT(*)
          FROM debitlog
          WHERE debitlog.debit = debits.id
      ) > 1 THEN 1
      WHEN debitlog.created_at = (
          SELECT MIN(created_at)
          FROM debitlog
          WHERE debitlog.debit = debits.id
      ) THEN 0
      ELSE NULL
  END AS status_update'),
    )
      ->leftJoin('debits', 'debits.id', '=', 'debitlog.debit')
      ->where('debit', $id)
      ->get();

    return response()->json($debitLog);
  }


  public function listS3Files()
  {
    $files = Storage::disk('s3')->allFiles();

    dd($files);
  }
}
