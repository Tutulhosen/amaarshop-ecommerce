<?php

namespace App\Http\Controllers\backend;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class DeliveryChargeController extends Controller
{
    // delivery_charge list 
    public function List(){
        $data['list']=DB::table('delivery_charge')->get();
        return view("admin.delivery_charge.list")->with($data);
    }

    //show delivery_charge create page
    public function create(){
        
     
        return view('admin.delivery_charge.create');
    }

    // store delivery_charge
    public function store(Request $request){
        
        $name_en = $request->name_en;
        $name_bn = $request->name_bn;
        $delivery_charge = $request->delivery_charge;
        
       
       $insert= DB::table('delivery_charge')->insert([
            'name_en' =>$name_en,
            'name_bn' =>$name_bn,
            'charge' =>$delivery_charge,
            
        ]);
        if ($insert) {
           return response()->json([
                'status' => true,
                'success' => 'delivery charge created successfully!',
           ]);

        }
       
        

        


    }

    //delivery_charge update page
    public function update_page($id){
        $data['delivery_charge_info']=DB::table('delivery_charge')->where('id', $id)->first();
        return view('admin.delivery_charge.edit')->with($data);
    }

    // update delivery_charge
    public function update(Request $request){
        
        $name_en = $request->name_en;
        $name_bn = $request->name_bn;
        $delivery_charge = $request->delivery_charge;
        // dd($link);
        $update = DB::table('delivery_charge')->where('id', $request->id)->update([
            'name_en' => $name_en,
            'name_bn' => $name_bn,
            'charge' => $delivery_charge,
           
        ]);
     
        if ($update) {
            return response()->json([
                'status' => true,
                'success' => 'Delivery charge updated successfully!',
            ]);
        } else {
            return response()->json([
                'status' => false,
                'error' => 'Nothing Change.',
            ]);
        }
    }


    //delete delivery_charge
    public function delete($id){
       
        $delete=DB::table('delivery_charge')->where('id', $id)->delete();
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

    //delivery_charge status update
    public function status($id){
        $delivery_charge_id=DB::table('delivery_charge')->where('id', $id)->first();
        if ($delivery_charge_id->status==1) {
           $update= DB::table('delivery_charge')->where('id', $id)->update([
                'status'    =>0,
           ]);
            
        }elseif ($delivery_charge_id->status==0) {
            $update= DB::table('delivery_charge')->where('id', $id)->update([
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
