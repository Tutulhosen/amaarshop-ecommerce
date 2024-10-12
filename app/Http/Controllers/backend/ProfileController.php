<?php

namespace App\Http\Controllers\backend;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    //profile page
    public function page(){
        return view('admin.profile.profile');
    }

    //change password page
    public function update_profile_page(){
        // dd('hi');
        return view('admin.profile.update');
    }

    //password change
    public function update_profile(Request $request){
        $name = $request->input('name');
        $email = $request->input('email');
        $phone = $request->input('phone');
        $address = $request->input('address');
        $company_name = $request->input('company_name');
        $company_email = $request->input('company_email');
        $company_phone = $request->input('company_phone');
        $whatsapp = $request->input('whatsapp');
        $company_address = $request->input('company_address');
        $previousImageName = Auth::user()->image;
        if ($request->hasFile('profile_image')) {
                
            $Image = $request->file('profile_image');
            $imageName = md5(time().'_'.rand()).'.'.$Image->getClientOriginalExtension();
            
            $Image->move(public_path('admin/assets/img/profile'), $imageName);
            if (!empty($previousImageName)) {
                $previousImagePath = public_path('admin/assets/img/profile') . '/' . $previousImageName;
                if (file_exists($previousImagePath)) {
                    unlink($previousImagePath);
                }
            }
            
        }else {
            $imageName=$previousImageName;
        }

        DB::table('users')->where('id', Auth::user()->id)->update([
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'address' => $address,
            'company_name' => $company_name,
            'company_email' => $company_email,
            'company_phone' => $company_phone,
            'whatsapp' => $whatsapp,
            'company_address' => $company_address,
            'image' => $imageName,
            
        ]);

        return response()->json([
            'status' => true,
            'success' => 'successfully Update Profile',
        ]);
    }

    //change password page
    public function change_password_page(){
        return view('admin.profile.change_password');
    }

    //password change
    public function change_password(Request $request){
        $c_password = $request->c_password;
        $new_password = $request->new_password;
        $confirm_password = $request->confirm_password;

        if (!Hash::check($c_password, Auth::user()->password)) {
            return response([
                'status' => false,
                'error' => 'Invalid current password',
            ]);
        }
        if ($new_password != $confirm_password) {
            return response([
                'status' => false,
                'error' => 'Confirm Password Not Match',
            ]);
        }

        $update=DB::table('users')->where('id', Auth::user()->id)->update([
            'password' =>Hash::make($new_password)
        ]);
        return response([
            'status' => true,
            'success' => 'Successfully Update Password',
        ]);
    }

}
