<?php

namespace App\Http\Controllers\Frontend;

use Mpdf\Mpdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    //dashboard
    public function profile(){
        $user=Auth::guard('customer')->user();
       
        $data['category'] = DB::table('category')->where('status', 1)->get();
        $data['recent_order'] = DB::table('customer_order')
            ->select('order_code', DB::raw('MAX(id) as max_id'), DB::raw('MAX(total_price) as total_price'), DB::raw('MAX(full_name) as full_name'), DB::raw('MAX(order_status) as order_status'), DB::raw('MAX(order_date) as order_date'))
            ->where('customer_id', $user->id)
            ->groupBy('order_code')
            ->orderBy('max_id', 'DESC')
            ->limit(3)
            ->get();
            $user = Auth::guard('customer')->user();

        $customer_address=DB::table('customer_address')->where('customer_id', $user->id)->first();
        if (!empty($customer_address)) {
            $data['customer_address']=$customer_address;
        } else {
           
            $data['customer_address']=null;
        }
        $data['sub_title']='profile';
        return view('frontend.pages.profile')->with($data);
    }

    //invoice
    public function invoice($id){
        $data['category'] = DB::table('category')->where('status', 1)->get();
        $single_order=DB::table('customer_order')->where('id', $id)->first();
        // dd($single_order);
        $order_invoice=DB::table('products')
        ->join('customer_order', 'customer_order.product_id', 'products.id')
        ->where('customer_order.order_code', $single_order->order_code)
        ->select('products.title as title','customer_order.products_qty' ,'customer_order.additional_information as delivery_charge', 'products.price as offer_cost', 'products.discount as discount')
        ->get();
        
        
        $data['single_order']=$single_order;
        $data['order_invoice']=$order_invoice;
        $data['sub_title']='invoice';
        
        return view('frontend.pages.invoice')->with($data);
    }

    //profile update page
    public function profile_update_page(){
        $data['category'] = DB::table('category')->where('status', 1)->get();
        $data['sub_title']='profile Update';
        return view('frontend.pages.profile_update')->with($data);
    }

    //profile update
    public function profile_update(Request $request){
        // Validation
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string|max:15',
        
        ]);

        // Fetch current user
        $user = Auth::guard('customer')->user();
        if ($request->filled('password')) {
            $password = Hash::make($request->password);
        }else{
            $password = $user->password;
        }
    
        DB::table('customers')->where('id', $user->id)->update([
            'name' =>$request->name,
            'email' =>$request->email,
            'phone' =>$request->phone,
            'password' =>$password,
            
        ]);


        return response()->json(['success' => true, 'message' => 'Profile updated successfully']);
    }

    //address update page
    public function address_update_page(){
        $data['category'] = DB::table('category')->where('status', 1)->get();
        $data['division']=DB::table('division')->get();
        $data['sub_title']='Address Update';
        $user = Auth::guard('customer')->user();

        $customer_address=DB::table('customer_address')->where('customer_id', $user->id)->first();
        if (!empty($customer_address)) {
            $data['customer_address']=$customer_address;
        } else {
            $data['customer_address']=null;
        }
        
      

        return view('frontend.pages.address_update')->with($data);
    }

    //address update
    public function address_update(Request $request){
    
       $user = Auth::guard('customer')->user();
        
       $id= DB::table('customer_address')->updateOrInsert(['customer_id' => $user->id], [
            'customer_id' => $user->id,
            'per_div' => $request->division,
            'per_dis' => $request->district,
            'per_upa' => $request->upazila,
            'per_details' => $request->address,
            'pre_div' => $request->p_division,
            'pre_dis' => $request->p_district,
            'pre_upa' => $request->p_upazila,
            'pre_details' => $request->p_address,
        ]);
        


        return response()->json(['success' => true, 'message' => 'Information updated successfully']);
    }

     // Get districts based on division ID
     public function get_district(Request $request)
     {
         $districts = DB::table('district')->where('division_id', $request->division_id)->get();
         return response()->json(['districts' => $districts]);
     }
 
     // Get upazilas based on district ID
     public function get_upazila(Request $request)
     {
         $upazilas = DB::table('upazila')->where('district_id', $request->district_id)->get();
         return response()->json(['upazilas' => $upazilas]);
     }


     //download invoice
     public function downloadInvoice($id)
     {
        $single_order=DB::table('customer_order')->where('order_code', $id)->first();
        // dd($single_order);
        $order_invoice=DB::table('products')
        ->join('customer_order', 'customer_order.product_id', 'products.id')
        ->where('customer_order.order_code', $single_order->order_code)
        ->select('products.title as title','customer_order.products_qty' ,'customer_order.additional_information as delivery_charge', 'products.price as offer_cost', 'products.discount as discount')
        ->get();
        
        
        $data['single_order']=$single_order;
        $data['order_invoice']=$order_invoice;
        $data['sub_title']='invoice';

        $html = view('frontend.pages.invoice-template', compact('single_order', 'order_invoice'))->render();
        // dd($html);
        // Create an instance of mpdf
        $mpdf = new Mpdf();

        // Write the HTML content to PDF
        $mpdf->WriteHTML($html);

        // Output the generated PDF (forces download)
        return $mpdf->Output('invoice_' . $single_order->order_code . '.pdf', 'D');
         
     }
     






}
