<?php


// use App\Label;
use App\Models\Label;
use App\Models\Gyoumu;
use App\Models\Status;
use App\Models\NonDelivery;
// use App\Models\Return_reason;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\LabelsController;
use App\Http\Controllers\NondeliveryController;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


// ページの読み込み集ーーーーー
Route::get('/', function () {
    return view('main');
});

Route::get('/', function () {
    return view('main');
});

Route::get('/waste_management', function () {
    return view('waste_management');
});

Route::get('/syougou_creation', function () {
    return view('syougou_creation');
});

Route::get('/non_delivery_data_creation', [NondeliveryController::class, 'index_creation'])->name('non_delivery_data_creation.index_creation');


Route::get('/picking', function () {
    $status = Status::orderBy('id','asc')->get();
    // dd($status);
    return view('picking_list_output',['status'=> $status]);
});


Route::get('/non_delivery', [NondeliveryController::class, 'index'])->name('non_delivery.index');


Route::get('/label', function () {
    $gyoumu = Gyoumu::orderBy('id','asc')->get();
    
    return view('label',['gyoumu' => $gyoumu]);
});

// ページ遷移
// Route::post('/label/create', [LabelsController::class, 'label_create'])->name('label.create');


//ラベル登録
Route::post('/label/register', [LabelsController::class, 'label_register'])->name('label.register');



// ----不着登録---------

Route::post('/non_delivery/temporary_store', [NondeliveryController::class, 'temporary_store'])->name('non_delivery.temporary_store');
Route::post('/non_delivery', [NondeliveryController::class, 'store'])->name('non_delivery.store');

Route::post('/non_delivery_creation', [NondeliveryController::class, 'update'])->name('non_delivery_creation.update');


// Route::post('/non_delivery', function (Request $request) {
    
// });



// Auth::routes();
// Route::get('/home', 'LabelsController@index')->name('home');


