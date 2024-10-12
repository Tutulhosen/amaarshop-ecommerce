<?php

namespace App\Http\Controllers\backend;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class SocialLinkController extends Controller
{
    // social_link list 
    public function List(){
        $data['list']=DB::table('social_link')->get();
        return view("admin.social_link.list")->with($data);
    }

    //show social_link create page
    public function create(){
        
     
        return view('admin.social_link.create');
    }

    // store social_link
    public function store(Request $request){
        
        $name = $request->name;
        $link = $request->link;
       
       $insert= DB::table('social_link')->insert([
            'title' =>$name,
            'link' =>$link,
            
        ]);
        if ($insert) {
           return response()->json([
                'status' => true,
                'success' => 'social_link created successfully!',
           ]);

        }
       
        

        


    }

    //social_link update page
    public function update_page($id){
        $data['social_link_info']=DB::table('social_link')->where('id', $id)->first();
        return view('admin.social_link.edit')->with($data);
    }

    // update social_link
    public function update(Request $request){
        
        $name = $request->name;
        $link = $request->link;
        // dd($link);
        $update = DB::table('social_link')->where('id', $request->id)->update([
            'title' => $name,
            'link' => $link,
           
        ]);
     
        if ($update) {
            return response()->json([
                'status' => true,
                'success' => 'social_link updated successfully!',
            ]);
        } else {
            return response()->json([
                'status' => false,
                'error' => 'Nothing Change.',
            ]);
        }
    }


    //delete social_link
    public function delete($id){
       
        $delete=DB::table('social_link')->where('id', $id)->delete();
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

    //social_link status update
    public function status($id){
        $social_link_id=DB::table('social_link')->where('id', $id)->first();
        if ($social_link_id->status==1) {
           $update= DB::table('social_link')->where('id', $id)->update([
                'status'    =>0,
           ]);
            
        }elseif ($social_link_id->status==0) {
            $update= DB::table('social_link')->where('id', $id)->update([
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
