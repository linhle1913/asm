<?php

namespace App\Http\Controllers\FrontController;

use App\Http\Controllers\Controller;
use App\Mail\MyMail;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register()
    {
        return view('client.register');
    }

    public function processRegister(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:5',
            'password_confirmation' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->route('account.register')->withInput()->withErrors($validator);
        }

        $user = new User();
        $user->create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('account.login')->with('success', 'Bạn đã đăng kí thành công!');
    }

    public function login()
    {
        return view('client.login');
    }

    public function authenticate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect()->route('account.login')->withInput()->withErrors($validator);
        }

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password, 'role' => 0])) {
            return redirect()->route('account.profile');
        } else {
            return redirect()->route('account.login')->with('error', 'Email hoặc mật khẩu của bạn không đúng!');
        }
    }

    public function profile()
    {
        if(Auth::user()->role == 1){
            Auth::logout();
            return redirect()->route('account.login');
        }else{
            $posts = Post::with(['Tags', 'author'])->where('user_id',Auth::user()->id)->get();
            $user = User::find(Auth::user()->id);
        }

        return view('client.profile', [
            'user' => $user,
            'posts' => $posts
        ]);
    }

    public function editProfile(){
        if(Auth::user()->role == 1){
            Auth::logout();
            return redirect()->route('account.login');
        }else{
            $user = User::find(Auth::user()->id);
        }
        return view('client.author.profile_edit',compact('user'));
    }

    public function processEditProfile(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3',
        ]);

        if ($validator->fails()) {
            return redirect()->route('account.editProfile')->withInput()->withErrors($validator);
        }

        $user = User::find(Auth::user()->id);
        $user->name = $request->name;
        $user->short_des = $request->short_des;
        $user->save();

        if (!empty($request->image)) {
            $image = $request->image;
            $ext = $image->getClientOriginalExtension();
            $imageName = time() . '.' . $ext;
            $image->move(public_path('uploads/avatar'), $imageName);
            $user->image = $imageName;
            $user->save();
        }

        return back()->with('success', 'Thay đổi thông tin cá nhân thành công');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('account.login');
    }

    public function forgot(){
        return view('client.forgot');
    }

    public function processForgot(Request $request){

        $validator = Validator::make($request->all(), [
            'email' => 'required|email'
        ]);

        $email = $request->email;

        $user = User::where('email',$email)->first();

        if(!$user){
            return redirect()->route('account.forgot')->with('error', 'Email của bạn không tồn tại!');
        }

        if ($validator->fails()) {
            return redirect()->route('account.forgot')->withInput()->withErrors($validator);
        }

        $token = \Str::random(60);

        $user->remember_token = $token;
        $user->save();

        $resetLink = route('account.resetPassword',$token);

        Mail::to($email)->send(new MyMail($user, $resetLink));

        return redirect()->route('account.login')->with('success','Bạn đã gửi mail thay đổi mật khẩu thành công! Vui lòng kiểm tra hòm thư cá nhân');
    }

    public function resetPassword($token){
        $token = User::where('remember_token',$token)->first();
        return view('client.resetPassword',compact('token'));
    }

    public function processResetPassword(Request $request){
        $validator = Validator::make($request->all(), [
            'password' => 'required|confirmed|min:5',
            'password_confirmation' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->route('account.resetPassword',$request->token)->withInput()->withErrors($validator);
        }

        $user = User::where('remember_token',$request->token)->first();
        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->route('account.login')->with('success','Bạn đã thay đổi mật khẩu thành công!');
    }
}
