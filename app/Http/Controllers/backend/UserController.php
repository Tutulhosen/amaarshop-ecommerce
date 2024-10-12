<?php

namespace App\Http\Controllers\backend;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // User create
    public function uesrPage(){
        
        return view("backend.user.create");
    }

    //show User list
    public function userList(){
        $data['users']=DB::table('users')->get();
        // return $data['category_list'];exit;
        return view('backend.user.list')->with($data);
    }

    // store User
    public function userStore(Request $request){
        
        $imageName=null;
        $image = $request->file('image');
        $name = $request->name;
        $email = $request->email;
        $phone = $request->phone;
        $role_id = $request->role_id;
       
        $password = $request->password;
        if (!empty($image)) {
            $imageName = md5(time().'_'.rand()).'.'.$image->getClientOriginalExtension();
            $image->move(public_path('images/user'), $imageName);
        } else {
            $imageName=null;
        }

       $insert= DB::table('users')->insert([
            'name' =>$name,
            'email' =>$email,
            'phone' =>$phone,
            'role_id' =>$role_id,
            'password' =>Hash::make($password),
            'image' =>$imageName,
            
        ]);
        if ($insert) {
           return response()->json([
                'status' => true,
                'success' => 'User created successfully!',
           ]);

        }
       

    }

    // User update page
    public function userupdatePage($id){
        
        $data['user_info']=DB::table('users')->where('id', $id)->first();
        return view('backend.user.edit')->with($data);
    }

    // update User
    public function userUpdate(Request $request){
        
        $user = DB::table('users')->where('id', $request->id)->value('image');
   
        $imageName=null;
        $image = $request->file('image');
        $name = $request->name;
        $email = $request->email;
        $phone = $request->phone;
        $role_id = $request->role_id;
       
        
        if (!empty($image)) {
            
            $imageName = md5(time().'_'.rand()).'.'.$image->getClientOriginalExtension();
            
            $image->move(public_path('images/user'), $imageName);
            
            if (!empty($user)) {
                $previousImagePath = public_path('images/user') . '/' . $user;
                if (file_exists($previousImagePath)) {
                    unlink($previousImagePath);
                }
            }

             // Update the category record in the database
            $update = DB::table('users')->where('id', $request->id)->update([
                'name' =>$name,
                'email' =>$email,
                'phone' =>$phone,
                'role_id' =>$role_id,
                'image' =>$imageName,
            ]);
        }else {
            // Update the category record in the database
            
            $update = DB::table('users')->where('id', $request->id)->update([
                'name' =>$name,
                'email' =>$email,
                'phone' =>$phone,
                'role_id' =>$role_id,
               
            ]);
          
           
        }
    
       
    
        if ($update) {
            return response()->json([
                'status' => true,
                'success' => 'User updated successfully!',
            ]);
        } else {
            return response()->json([
                'status' => false,
                'error' => 'Nothing Change.',
            ]);
        }
    }


    //delete User
    public function userDelete($id){
        $previousImageName = DB::table('users')->where('id', $id)->value('image');
        $previousImagePath = public_path('images/user') . '/' . $previousImageName;
        if (file_exists($previousImagePath)) {
            unlink($previousImagePath);
        }
        $delete=DB::table('users')->where('id', $id)->delete();
        if ($delete) {
            return response([
                'status' =>true,
                'message'=>"Successfully Delete A User"
            ]);
        } else {
            return response([
                'status' =>false,
                'message'=>"User is not deleted"
            ]);
        }
        
    }

    //User status update
    public function userStatusUpdate($id){
        $user_id=DB::table('users')->where('id', $id)->first();
        if ($user_id->status==1) {
           $update= DB::table('users')->where('id', $id)->update([
                'status'    =>0,
           ]);
            
        }elseif ($user_id->status==0) {
            $update= DB::table('users')->where('id', $id)->update([
                'status'    =>1,
           ]);
            
        }
        if ($update) {
            return response([
                'status' =>true,
               
            ]);
        }else {
            return response([
                'status' =>false,
               
            ]);
        }

    }
}
