<?php


// use App\Label;
use App\Models\Label;
use App\Models\Gyoumu;
use App\Models\Status;
use App\Models\NonDelivery;
// use App\Models\Return_reason;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\LabelsController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\StatusSearchController;
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
Route::get('/resend', [NondeliveryController::class, 'index_resend'])->name('resend.index_resend');
Route::get('/waste', [NondeliveryController::class, 'index_waste'])->name('waste.index_waste');
Route::get('/status_search', [StatusSearchController::class, 'index'])->name('status_search.index');
Route::get('/order', [OrderController::class, 'index'])->name('order.index');
Route::post('/status_search', [StatusSearchController::class, 'store'])->name('status_search.store');





Route::get('/non_delivery', [NondeliveryController::class, 'index'])->name('non_delivery.index');
Route::get('/label', [LabelsController::class, 'index'])->name('label.index');


// ピッキングリスト出力画面へ　カット
// Route::get('/picking', function () {
//     $status = Status::orderBy('id','asc')->get();
//     // dd($status);
//     return view('picking_list_output',['status'=> $status]);
// });

// ページ遷移
// Route::post('/label/create', [LabelsController::class, 'label_create'])->name('label.create');


//ラベル登録
Route::post('/label/register', [LabelsController::class, 'label_register'])->name('label.register');



// ----不着登録---------

Route::post('/non_delivery/temporary_store', [NondeliveryController::class, 'temporary_store'])->name('non_delivery.temporary_store');
Route::post('/non_delivery', [NondeliveryController::class, 'store'])->name('non_delivery.store');
Route::post('/non_delivery/session_delete', [NondeliveryController::class, 'session_delete'])->name('non_delivery.session_delete');

Route::post('/non_delivery_creation', [NondeliveryController::class, 'update'])->name('non_delivery_creation.update');

//指示データ作成
Route::post('/order_complete', [OrderController::class, 'order_complete'])->name('order.order_complete');


// 廃棄完了
Route::post('/waste_complete', [NondeliveryController::class, 'update_waste_complete'])->name('waste.update_waste_complete');

//再発送完了
Route::post('/resend_complete', [NondeliveryController::class, 'update_resend_complete'])->name('resend.update_resend_complete');

// Route::post('/non_delivery', function (Request $request) {
    
// });



// Auth::routes();
// Route::get('/home', 'LabelsController@index')->name('home');


