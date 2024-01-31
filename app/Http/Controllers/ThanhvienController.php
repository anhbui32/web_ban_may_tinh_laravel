<?php

namespace App\Http\Controllers;

use Illuminate\Auth\Events\Registered;
use App\Http\Requests\dangKyValid;
use DB;
use Illuminate\Http\Request;

class ThanhvienController extends Controller
{
    public function __construct()
    {
        $loaisp = DB::table('loai')->where('anhien', '=', 1)->orderBy('thutu')->get();
        \View::share('loaisp', $loaisp);
    }

    public function index()
    {
        //
    }

    function dangnhap()
    {
        return view('dangnhap');
    }
    function dangnhap_(Request $request)
    {
        if (auth()->guard('web')
            ->attempt(['email' => $request['email'], 'password' => $request['matkhau']])
        ) {
            $user = auth()->guard('web')->user();
            return redirect()->intended('/download');
        } else return back()->with('thongbao', 'Email, Password không đúng');
    }
    function dangky()
    {
        return view('dangky');
    }
    function dangky_(dangKyValid $request)
    {
        $email = strtolower(trim(strip_tags($request['email'])));
        $ho = trim(strip_tags($request['ho']));
        $ten = trim(strip_tags($request['ten']));
        $mk1 = trim(strip_tags($request['mk1']));
        $mk2 = trim(strip_tags($request['mk2']));
        $dc = trim(strip_tags($request['diachi']));
        $dt = trim(strip_tags($request['dienthoai']));
        //lưu vào db
        $id_user = DB::table('users')->insertGetId([
            'email' => $email, 'ho' => $ho, 'ten' => $ten, 'diachi' => $dc, 'dienthoai' => $dt,
            'password' => \Hash::make($mk1)
        ]);

        if (auth()->guard('web')->attempt(['email' => $email, 'password' => $mk1])) {
            // gửi mail
            $user = auth()->guard('web')->user();
            event(new Registered($user));

            return redirect('/camon')->with('thongbao', "Đăng ký hoàn tất!");
        } else return back()->with('thongbao', 'Đăng ký không thành công');
    }

    function camon()
    {
        return view('camon');
    }
    function thoat()
    {
        auth()->guard('web')->logout();
        return redirect('/dangnhap')->with('thongbao', 'Bạn đã thoát thành công');
    }



    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(string $id)
    {
        //
    }
    public function edit(string $id)
    {
        //
    }
    public function update(Request $request, string $id)
    {
        //
    }
    public function destroy(string $id)
    {
        //
    }
}
