<?php

namespace App\Http\Controllers\backend;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class LogoController extends Controller
{
    // logo list 
    public function List(){
        $data['list']=DB::table('logo')->get();
        return view("admin.logo.list")->with($data);
    }

    //show logo create page
    public function create(){
        
       
        return view('admin.logo.create');
    }

    // store logo
    public function store(Request $request){
        
        $imageName=null;
        $image = $request->file('image');
        
        if (!empty($image)) {
            $imageName = md5(time().'_'.rand()).'.'.$image->getClientOriginalExtension();
            $image->move(public_path('images/logo'), $imageName);
        } else {
            $imageName=null;
        }
        // dd($imageName);
       $insert= DB::table('logo')->insertGetId([
            
            'image' =>$imageName,
            
        ]);
        // dd($insert);
        if ($insert) {
           return response()->json([
                'status' => true,
                'success' => 'Logo created successfully!',
           ]);

        }
       

    }

    // logo update page
    public function update_page($id){
        $data['logo_info']=DB::table('logo')->where('id', $id)->first();
        return view('admin.logo.edit')->with($data);
    }

    // update logo
    public function update(Request $request){
        
        $logo = DB::table('logo')->where('id', $request->id)->value('image');
   
        $imageName=null;
        $image = $request->file('image');
        
        if (!empty($image)) {
            
            $imageName = md5(time().'_'.rand()).'.'.$image->getClientOriginalExtension();
            
            $image->move(public_path('images/logo'), $imageName);
            
            if (!empty($slider)) {
                $previousImagePath = public_path('images/logo') . '/' . $logo;
                if (file_exists($previousImagePath)) {
                    unlink($previousImagePath);
                }
            }

             // Update the category record in the database
            $update = DB::table('logo')->where('id', $request->id)->update([
                'image' =>$imageName,
            ]);
        }else {
            // Update the category record in the database
            
            return response()->json([
                'status' => false,
                'error' => 'Nothing Change.',
            ]);
          
           
        }
    
       
    
        if ($update) {
            return response()->json([
                'status' => true,
                'success' => 'Logo updated successfully!',
            ]);
        } else {
            return response()->json([
                'status' => false,
                'error' => 'Nothing Change.',
            ]);
        }
    }


    //delete logo
    public function delete($id){
       
        $delete=DB::table('logo')->where('id', $id)->delete();
        if ($delete) {
            return response([
                'status' =>true,
                'message'=>"Successfully Delete"
            ]);
        } else {
            return response([
                'status' =>false,
                'message'=>"Not deleted"
            ]);
        }
        
    }

    //logo status update
    public function status($id){
        $logo_id=DB::table('logo')->where('id', $id)->first();
        if ($logo_id->status==1) {
           $update= DB::table('logo')->where('id', $id)->update([
                'status'    =>0,
           ]);
            
        }elseif ($logo_id->status==0) {
            $get_status=DB::table('logo')->where('status',1)->get();
            if (!$get_status->isEmpty()) {
              
                return response([
                    'status' =>false,
                    'message' =>'Unable to activate this item because another one is already active.'
                   
                ]);
            } else {
                $update= DB::table('logo')->where('id', $id)->update([
                    'status'    =>1,
               ]);
            }
            
            
        }
        if ($update) {
            return response([
                'status' =>true,
               
            ]);
        }else {
            return response([
                'status' =>false,
                'message' =>'Unable to activate this item because another one is already active.'
               
            ]);
        }

    }
}
