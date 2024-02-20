<?php

namespace App\Http\Controllers\employee;

use App\Http\Controllers\Controller;
use App\Models\Position;
use Illuminate\Http\Request;

class PositionController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $data = Position::orderBy('id', 'desc')->get();
    return view("content.position.index", compact('data'));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    return view("content.position.create");
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    $request->validate([
      "name" => "required",
      "level" => "required",
    ]);
    $check = Position::where('name', $request->name)->where('level', $request->level)->first();
    if ($check) {
      return redirect()->route('positions.create')->with('status', 'Position Sudah Ada');
    }

    Position::create($request->all());
    return redirect()->route('positions.index')->with('status', 'Position Berhasil Ditambahkan');
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
    $data=Position::find($id);
    return view("content.position.edit",compact('data'));
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
      "name" => "required",
      "level" => "required",
    ]);
    $check = Position::where('name', $request->name)->where('level', $request->level)->first();
    if ($check) {
      return redirect()->route('positions.edit',$id)->with('status', 'Position Sudah Ada');
    }

    Position::find($id)->update($request->all());
    return redirect()->route('positions.index')->with('status', "Position $request->name Berhasil Diubah");
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    $position = Position::find($id);
    $name = $position->name;
    $position->delete();
    return redirect()->route('positions.index')->with('status', 'Position ' . $name . ' Berhasil Dihapus');
  }
}
