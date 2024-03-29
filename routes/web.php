<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SanPhamController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminLoaiController;
use App\Http\Controllers\AdminSPController;
use App\Http\Controllers\ThanhvienController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

Route::get('/', [SanPhamController::class, 'index']);
Route::get('/sp/{id}', [SanPhamController::class, 'chitiet']);
Route::get('/loai/{id}', [SanPhamController::class, 'sptrongloai']);
Route::get('/test/{a}/{b}', [SanPhamController::class, 'test']);

Route::get('/themvaogio/{idsp}/{soluong}', [SanPhamController::class, 'themvaogio']);
Route::get('/hiengiohang', [SanPhamController::class, 'hiengiohang']);
Route::get('/xoasptronggio/{idsp}', [SanPhamController::class, 'xoasptronggio']);
Route::get('/xoagiohang/', [SanPhamController::class, 'xoagiohang']);
Route::get('/thanhtoan', [SanPhamController::class, 'thanhtoan']);
Route::post('/luudonhang', [SanPhamController::class, 'luudonhang']);

Route::get('/thongbao', [SanPhamController::class, 'thongbao']);

Route::get('/chenuser', function () {
    DB::table('users')->insert([
        'ho' => 'Đỗ Đạt', 'ten' => 'Cao', 'password' => bcrypt('hehe'), 'diachi' => '',
        'email' => 'dodatcao@gmail.com', 'dienthoai' => '0918765238',
        'hinh' => '', 'vaitro' => 1, 'trangthai' => 0
    ]);
    DB::table('users')->insert([
        'ho' => 'Mai Anh', 'ten' => 'Tới', 'password' => bcrypt('hehe'), 'diachi' => '',
        'email' => 'maianhtoi@gmail.com', 'dienthoai' => '098532482',
        'hinh' => '', 'vaitro' => 0, 'trangthai' => 0
    ]);
    DB::table('users')->insert([
        'ho' => 'Đào Kho', 'ten' => 'Báu', 'password' => bcrypt('hehe'), 'diachi' => '',
        'email' => 'daokhobau@gmail.com', 'dienthoai' => '097397392',
        'hinh' => '', 'vaitro' => 1, 'trangthai' => 1
    ]);
});

Route::group(['prefix' => 'admin'], function () {
    Route::get('dangnhap', [AdminController::class, 'dangnhap']);
    Route::post('dangnhap', [AdminController::class, 'dangnhap_']);
    Route::get('thoat', [AdminController::class, 'thoat']);
});

Route::group(['prefix' => 'admin', 'middleware' => 'adminauth'], function () {
    Route::get('/', [AdminController::class, 'index']);
    Route::resource('loai', AdminLoaiController::class);
    Route::resource('sanpham', AdminSPController::class);
    // Route::resource('thanhvien', ThanhvienController::class);
    //routing quản lý bình luận
});

Route::get('/dangnhap', [App\Http\Controllers\ThanhvienController::class, 'dangnhap'])->name('login');
Route::post('/dangnhap', [App\Http\Controllers\ThanhvienController::class, 'dangnhap_']);
Route::get('/thoat', [App\Http\Controllers\ThanhvienController::class, 'thoat']);
Route::get('/download', [SanPhamController::class, 'download'])->middleware('auth');
Route::get('/dangky', [App\Http\Controllers\ThanhvienController::class, 'dangky']);
Route::post('/dangky', [App\Http\Controllers\ThanhvienController::class, 'dangky_']);
Route::get('/camon', [App\Http\Controllers\ThanhvienController::class, 'camon']);
Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect('/');
})->middleware(['auth', 'signed'])->name('verification.verify');
Route::get('/email/verify', function () {
    return view('verify-email');
})->middleware('auth')->name('verification.notice');
Route::get('/download', [SanPhamController::class, 'download'])->middleware('auth', 'verified');
