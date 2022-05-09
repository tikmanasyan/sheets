<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function (\App\Services\GoogleSheet $googleSheet) {
   $data = $googleSheet->readGoogleSheet();
   $id = 4;
   $row = [];
    for($i = 1; $i < count($data);$i++) {
        if($data[$i][0] == $id) {
            $row = $data[$i];
            break;
        }
    }

    print_r($row);

});

Route::prefix("/users")->group(function() {
    Route::get("/", [UserController::class, "index"])->name("users");
    Route::get("/create", [UserController::class, "create"])->name("create-user");
    Route::post("/create", [UserController::class, "store"])->name("store-user");
    Route::get("/{id}/edit", [UserController::class, "edit"])->name("edit-user");
    Route::post("/update", [UserController::class, "update"])->name("update-user");
});

Route::get("/sheets", [UserController::class, "sheet"]);
