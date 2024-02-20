<?php

namespace App\Http\Controllers\payroll;

use App\Http\Controllers\Controller;
use App\Models\Compensation;
use Illuminate\Http\Request;

class CompensationController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(Request  $request)
  {
    $request->validate([
      'type' => 'required|in:allowance,deduction'
    ]);

    if ($request->type == 'allowance') {
      $data = \App\Models\Compensation::where('compensation_type', 'allowance')->get();
    } else {
      $data = \App\Models\Compensation::where('compensation_type', 'deduction')->get();
    }

    return view('content.payroll.compensations', compact('data'));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create(Request $request)
  {
    return view('content.payroll.compensation-create', [
      'type' => $request->type
    ]);
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    // dd($request->all());
    $request->validate([
      'compensation_type' => 'required|in:allowance,deduction',
      'code' => 'required',
      'name' => 'required|unique:compensation,name',
      'amount_type' => 'required|in:fixed,percentage',
      'amount' => 'required',
      'apply_date' => 'required|date',
    ]);

    if($request->amount_type == 'fixed'){
      $request->merge([
        'amount' => str_replace('.', '', $request->amount)
      ]);
    }

    Compensation::create($request->all());

    return redirect()->route('compensations.index', ['type' => $request->compensation_type])->with('status', "Data $request->compensation_type kompensasi berhasil ditambahkan");

  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function edit(Request $request,$id)
  {
    $data= Compensation::findOrFail($id);
    return view('content.payroll.edit', compact('data'));
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, $id)
  {
    $request->validate([
      'name' => 'required|unique:compensation,name,'.$id,
      'amount_type' => 'required|in:fixed,percentage',
      'amount' => 'required',
      'apply_date' => 'required|date',
    ]);

    if($request->amount_type == 'fixed'){
      $request->merge([
        'amount' => str_replace('.', '', $request->amount)
      ]);
    }

    $data=Compensation::findOrFail($id);
    $tmp=$data;
    $data->update($request->all());

    return redirect()->route('compensations.index', ['type' => $tmp->compensation_type])->with('status', "Data $tmp->compensation_type kompensasi berhasil diubah");
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    $data= Compensation::findOrFail($id);
    $name=$data->name;
    $data->delete();
    return redirect()->back()->with('status',"Data kompensasi $name berhasil dihapus");
  }
}
