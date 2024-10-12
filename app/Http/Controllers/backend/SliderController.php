<?php

namespace App\Http\Controllers\backend;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class SliderController extends Controller
{
    // slider create
    public function sliderPage(){
        return view("admin.slider.create");
    }

    //show slider list
    public function sliderList(){
      
        $data['slider_list']=DB::table('sliders')->paginate(10);
        // return $data['category_list'];exit;
        return view('admin.slider.list')->with($data);
    }

    // store slider
    public function sliderStore(Request $request){
        $imageName=null;
        $image = $request->file('image');
        
        if (!empty($image)) {
            $imageName = md5(time().'_'.rand()).'.'.$image->getClientOriginalExtension();
            $image->move(public_path('images/slider'), $imageName);
        } else {
            $imageName=null;
        }
        // dd($imageName);
       $insert= DB::table('sliders')->insert([
            
            'image_name' =>$imageName,
            
        ]);
        if ($insert) {
           return response()->json([
                'status' => true,
                'success' => 'Category created successfully!',
           ]);

        }
        return response()->json([
            'status' => true,
            'success' => ' successfully Create A New Slider !!',
       ]);

    }

    // slider update page
    public function sliderupdatePage($id){
        $data['slider_info']=DB::table('sliders')->where('id', $id)->first();
        return view('admin.slider.edit')->with($data);
    }

    // update slider
    public function sliderUpdate(Request $request){
        
        $slider = DB::table('sliders')->where('id', $request->id)->value('image_name');
   
        $imageName=null;
        $image = $request->file('image');
        
        if (!empty($image)) {
            
            $imageName = md5(time().'_'.rand()).'.'.$image->getClientOriginalExtension();
            
            $image->move(public_path('images/slider'), $imageName);
            
            if (!empty($slider)) {
                $previousImagePath = public_path('images/slider') . '/' . $slider;
                if (file_exists($previousImagePath)) {
                    unlink($previousImagePath);
                }
            }

             // Update the category record in the database
            $update = DB::table('sliders')->where('id', $request->id)->update([
                'image_name' =>$imageName,
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
                'success' => 'Slider updated successfully!',
            ]);
        } else {
            return response()->json([
                'status' => false,
                'error' => 'Nothing Change.',
            ]);
        }
    }


    //delete slider
    public function sliderDelete($id){
        $previousImageName = DB::table('sliders')->where('id', $id)->value('image_name');
        $previousImagePath = public_path('images/slider') . '/' . $previousImageName;
        if (file_exists($previousImagePath)) {
            unlink($previousImagePath);
        }
        $delete=DB::table('sliders')->where('id', $id)->delete();
        if ($delete) {
            return response([
                'status' =>true,
                'message'=>"Successfully Delete A Slider"
            ]);
        } else {
            return response([
                'status' =>false,
                'message'=>"Slider is not deleted"
            ]);
        }
        
    }

    //slider status update
    public function sliderStatusUpdate($id){
        $sliders_id=DB::table('sliders')->where('id', $id)->first();
        if ($sliders_id->status==1) {
           $update= DB::table('sliders')->where('id', $id)->update([
                'status'    =>0,
           ]);
            
        }elseif ($sliders_id->status==0) {
            $update= DB::table('sliders')->where('id', $id)->update([
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
