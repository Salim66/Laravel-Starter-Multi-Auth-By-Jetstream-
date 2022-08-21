<?php

namespace App\Http\Controllers\Backend;

use App\Models\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    /**
     * @access private
     * @routes /admin/profile
     * @method GET
     */
    public function adminProfile(){
        $id = Auth::guard('admin')->user()->id;
        $admin = Admin::find($id);
        return view('admin.profile.view_profile', compact('admin'));
    }

    /**
     * @access private
     * @routes /admin/profile/edit
     * @method GET
     */
    public function adminProfileEdit(){
        $id = Auth::guard('admin')->user()->id;
        $admin = Admin::find($id);
        return view('admin.profile.edit_profile', compact('admin'));
    }

    /**
     * @access private
     * @routes /admin/profile/update
     * @method POST
     */
    public function adminProfileUpdate(Request $request){
        if($request->isMethod('post')){
            $data = Admin::find(Auth::guard('admin')->user()->id);
            $data->name = $request->name;
            $data->email = $request->email;

            $fileName = '';
            if($request->file('profile_photo_path')){
                $file = $request->file('profile_photo_path');
                $fileName = date('YmdHi').'.'.$file->getClientOriginalExtension();
                $file->move(public_path('upload/admin_images/'), $fileName);
                if(file_exists($data->profile_photo_path) && !empty($data->profile_photo_path)){
                    unlink('upload/admin_images/'.$data->profile_photo_path);
                }
            }else {
                $fileName = $data->profile_photo_path;
            }

            $data->profile_photo_path = $fileName;
            $data->save();

            $notification = [
                'message' => "Your profile updated successfully",
                'alert-type' => 'success'
            ];

            return redirect()->route('admin.profile')->with($notification);
        }
    }

    /**
     * @access private
     * @routes /admin/change/password
     * @method GET
     */
    public function adminChangePassword(){
        return view('admin.password.edit_password');
    }

    /**
     * @access private
     * @routes /admin/update/password
     * @method POST
     */
    public function adminUpdatePassword(Request $request){
        if($request->isMethod('post')){
            $data = $request->all();
            $this->validate($request, [
                'current_password' => 'required',
                'password' => 'required|confirmed'
            ],[
                'current_password.required' => 'Current Password is required'
            ]);

            $password = Auth::guard('admin')->user()->password;
            if(Hash::check($data['current_password'], $password)){

                $admin = Admin::find(Auth::guard('admin')->user()->id);
                $admin->password = Hash::make($data['password']);
                $admin->save();
                Auth::logout();
                return redirect('admin/login');

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
