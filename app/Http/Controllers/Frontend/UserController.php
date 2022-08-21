<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * @access private
     * @routes /user-logout
     * @method GET
     */
    public function logout(){
        Auth::logout();
        return redirect()->route('login');
    }

    /**
     * @access private
     * @routes /user/profile
     * @method GET
     */
    public function userProfile(){
        $id = Auth::user()->id;
        $user = User::find($id);
        return view('user.profile.view_profile', compact('user'));
    }

    /**
     * @access private
     * @routes /user/profile/edit
     * @method GET
     */
    public function userProfileEdit(){
        $id = Auth::user()->id;
        $user = User::find($id);
        return view('user.profile.edit_profile', compact('user'));
    }

    /**
     * @access private
     * @routes /user/profile/update
     * @method POST
     */
    public function userProfileUpdate(Request $request){
        if($request->isMethod('post')){
            $data = User::find(Auth::user()->id);
            $data->name = $request->name;
            $data->email = $request->email;

            $fileName = '';
            if($request->file('profile_photo_path')){
                $file = $request->file('profile_photo_path');
                $fileName = date('YmdHi').'.'.$file->getClientOriginalExtension();
                $file->move(public_path('upload/user_images/'), $fileName);
                if(file_exists($data->profile_photo_path) && !empty($data->profile_photo_path)){
                    unlink('upload/user_images/'.$data->profile_photo_path);
                }
            }else {
                $fileName = $data->profile_photo_path;
            }

            $data->profile_photo_path = $fileName;
            $data->save();

            $notification = [
                'message' => "User profile updated successfully",
                'alert-type' => 'success'
            ];

            return redirect()->route('user.profile')->with($notification);
        }
    }

    /**
     * @access private
     * @routes /user/change/password
     * @method GET
     */
    public function userChangePassword(){
        return view('user.password.edit_password');
    }

    /**
     * @access private
     * @routes /user/update/password
     * @method POST
     */
    public function userUpdatePassword(Request $request){
        if($request->isMethod('post')){
            $data = $request->all();
            $this->validate($request, [
                'current_password' => 'required',
                'password' => 'required|confirmed'
            ],[
                'current_password.required' => 'Current Password is required'
            ]);

            $password = Auth::user()->password;
            if(Hash::check($data['current_password'], $password)){

                $user = User::find(Auth::user()->id);
                $user->password = Hash::make($data['password']);
                $user->save();
                Auth::logout();
                return redirect()->route('login');

            }else {
                $notification = [
                    "message" => "Current Password Doesn't Match!",
                    "alert-type" => "error"
                ];
                return redirect()->back()->with($notification);
            }
        }
    }
}
