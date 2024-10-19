<?php

namespace App\Http\Controllers\backend;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class PixelController extends Controller
{
     // top-header list 
     public function List(){
        $data['list']=DB::table('pixel')->get();
        return view("admin.pixel.list")->with($data);
    }

    //show top-header create page
    public function create(){
        
        // return $data['category_list'];exit;
        return view('admin.pixel.create');
    }

    // store category
    public function store(Request $request){
        
        $imageName=null;
        $name = $request->name;
        $image = $request->file('image');
        
        if (!empty($image)) {
            $imageName = md5(time().'_'.rand()).'.'.$image->getClientOriginalExtension();
            $image->move(public_path('images/fav_icon'), $imageName);
        } else {
            $imageName=null;
        }
       $insert= DB::table('pixel')->insert([
            'title' =>$name,
            'fav_icon' =>$imageName,
            
        ]);
        if ($insert) {
           return response()->json([
                'status' => true,
                'success' => 'Meta created successfully!',
           ]);

        }
       
        

        


    }

    // top-header update page
    public function update_page($id){
        $data['top_header_info']=DB::table('pixel')->where('id', $id)->first();
        return view('admin.pixel.edit')->with($data);
    }

    // update top-header
    public function update(Request $request){
        
        $name = $request->name;

        $meta = DB::table('pixel')->where('id', $request->id)->value('fav_icon');
   
        $imageName=null;
        $image = $request->file('image');
        
        if (!empty($image)) {
            
            $imageName = md5(time().'_'.rand()).'.'.$image->getClientOriginalExtension();
            
            
            
            if (!empty($meta)) {
                $previousImagePath = public_path('images/fav_icon') . '/' . $meta;
                if (file_exists($previousImagePath)) {
                    unlink($previousImagePath);
                }
            }
            $image->move(public_path('images/fav_icon'), $imageName);
             // Update the category record in the database
            $update = DB::table('pixel')->where('id', $request->id)->update([
                'fav_icon' =>$imageName,
                'title' => $name,
            ]);
        }else {
            // Update the category record in the database
            $update = DB::table('pixel')->where('id', $request->id)->update([
                'title' => $name,
            ]);
          
           
        }

    
        if ($update) {
            return response()->json([
                'status' => true,
                'success' => 'Meta updated successfully!',
            ]);
        } else {
            return response()->json([
                'status' => false,
                'error' => 'Nothing Change.',
            ]);
        }
    }


    //delete Meta
    public function delete($id){
       
        $delete=DB::table('pixel')->where('id', $id)->delete();
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

    //top-header status update
    public function status($id){
        $top_header_id=DB::table('pixel')->where('id', $id)->first();
        if ($top_header_id->status==1) {
            
           $update= DB::table('pixel')->where('id', $id)->update([
                'status'    =>0,
           ]);
            
        }elseif ($top_header_id->status==0) {
            $get_status=DB::table('pixel')->where('status',1)->get();
            if (!$get_status->isEmpty()) {
              
                return response([
                    'status' =>false,
                    'message' =>'Unable to activate this item because another one is already active.'
                   
                ]);
            } else {
                $update= DB::table('pixel')->where('id', $id)->update([
                    'status'    =>1,
               ]);
            }
            
            
            
        }
        if ($update) {
            return response([
                'status' =>true,
                'message' =>'successfully Update'
               
            ]);
        }else {
            return response([
                'status' =>false,
                'message' =>'Update Fail',
               
            ]);
        }

    }
}
