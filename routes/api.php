<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\authentications\LoginBasic;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('/auth', [LoginBasic::class, 'login'])->name('api.login');




Route::get('/list-bank', function (Request $request) {
  $request->validate([
    'code_bank' => 'numeric',
    'limit' => 'numeric',
    'bank' => 'string'
  ]);

  $json = file_get_contents(base_path('resources/views/json/list-bank.json'));

  $data = json_decode($json, true);
  if ($request->code_bank) {
    $data = array_filter($data, function ($item) use ($request) {
        return $item['code'] == $request->code_bank;
    });

    $data = array_values($data);

    if (count($data) == 0) {
        return response()->json([
            'status' => false,
            'message' => 'Data not found'
        ]);
    }

    // return response()->json([
    //     'status' => true,
    //     'data' => $data
    // ]);
}

  if ($request->bank) {
    $data = array_filter($data, function ($item) use ($request) {
        return strpos(strtolower($item['name']), strtolower($request->bank)) !== false;
    });

    $data = array_values($data);

    if (count($data) == 0) {
        return response()->json([
            'status' => false,
            'message' => 'Data not found'
        ]);
    }

    // return response()->json([
    //     'status' => true,
    //     'data' => $data
    // ]);
}

  if ($request->limit) {
    $data = array_slice($data, 0, $request->limit);
  }

  return response([
    'status' => true,
    'data' => $data
  ]);
})->name('api.list.bank');

// Route::get('/user', [LoginBasic::class,'user'])->name('api.user');
