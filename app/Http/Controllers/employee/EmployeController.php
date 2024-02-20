<?php

namespace App\Http\Controllers\employee;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Http\Request;
use App\Models\Position;
use App\Models\EmployeStatus;
use Carbon\Carbon;

class EmployeController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $data = Employee::orderBy('employees.id', 'desc')
    ->leftJoin('positions', 'employees.position_id', '=', 'positions.id')
    ->leftJoin('employe_statuses', 'employees.employe_status_id', '=', 'employe_statuses.id')
    ->get(['employees.*', 'positions.name as position_name','positions.level',
    'employe_statuses.start_date',
    'employe_statuses.end_date',
    'employe_statuses.name as employe_status_name']);
    return view("content.employee.index", compact("data"));
  }

  public function archived(){

    $data = Employee::onlyTrashed()->orderBy('employees.id', 'desc')
    ->leftJoin('positions', 'employees.position_id', '=', 'positions.id')
    ->leftJoin('employe_statuses', 'employees.employe_status_id', '=', 'employe_statuses.id')
    ->get(['employees.*', 'positions.name as position_name','positions.level',
    'employe_statuses.start_date',
    'employe_statuses.end_date',
    'employe_statuses.name as employe_status_name']);

    return view("content.employee.archived", compact("data"));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    $positions = Position::all();
    // $employeStatuses = EmployeStatus::all();


    $employeStatuses = json_decode(file_get_contents(base_path('resources/views/json/list-status-employe.json')), true);


    $latestEmployee = Employee::select('nip')->orderBy('nip', 'desc')->first();

    if (!$latestEmployee) {
      $latestNipNumber = 0;
    } else {
      $latestNipNumber = (int)substr($latestEmployee->nip, 2);
    }

    $newNipNumber = $latestNipNumber + 1;
    $nip = "WZ" . str_pad($newNipNumber, 3, "0", STR_PAD_LEFT);

    return view("content.employee.create", compact("positions", "employeStatuses", "nip"));
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    $request->merge([
      'salary' => str_replace('.', '', $request->salary),
    ]);


    $request->validate([
      'nip' => 'required|unique:employees',
      'nik' => 'required|numeric|unique:employees',
      'no_bpjstk' => 'numeric|unique:employees',
      'no_npwp' => 'numeric|unique:employees',
      'name' => 'required',
      'email' => 'required|email|unique:employees',
      'whatsapp_number' => 'required|numeric|starts_with:62|unique:employees|digits_between:11,13 ',
      'address' => 'required',
      'position' => 'required',
      'employe_status' => 'required',
      'salary' => 'required|numeric',
      'bank_account' => 'required|numeric',
      'bank_code' => 'required|numeric',
      'start_date' => 'required|date',
      'end_date' => 'required|date',
    ]);

    $request->merge([
      'duration' => Carbon::parse($request->end_date)->diffInDays(Carbon::parse($request->start_date)),
    ]);

    // dd($request->all());

    $employeStatus = EmployeStatus::create([
      "name" => $request->employe_status,
      "start_date" => $request->start_date,
      "end_date" => $request->end_date,
      "duration" => $request->duration,
    ]);



    Employee::create([
      "nip" => $request->nip,
      "nik" => $request->nik,
      "no_bpjstk" => $request->no_bpjstk,
      "no_npwp" => $request->no_npwp,
      "name" => $request->name,
      "email" => $request->email,
      "whatsapp_number" => $request->whatsapp_number,
      "address" => $request->address,
      "position_id" => $request->position,
      "employe_status_id" => $employeStatus->id,
      "salary" => $request->salary,
      "bank_account" => $request->bank_account,
      "bank_code" => $request->bank_code,

    ]);

    return redirect()->route('employee.index')->with('status', "Data karyawan $request->name berhasil ditambahkan");
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
  public function edit($id)
  {
    //
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
    //
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    $data=Employee::where('nip', $id);
    $name=$data->first()->name;
    $data->delete();
    return redirect()->route('employee.index')->with('status', "Data karyawan $name berhasil dihapus");
  }
  public function unarchived($id){
    $data=Employee::onlyTrashed()->where('nip', $id);
    $name=$data->first()->name;
    $data->restore();
    return redirect()->route('employee.archived')->with('status', "Data karyawan $name berhasil dikembalikan");
  }
}
