<?php

namespace App\Http\Controllers\backend;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

class AdminDashboardController extends Controller
{
    
    //show dashboard page
    public function dashboard(){
        $data['all_order']=DB::table('customer_order')->distinct('order_code')->count('order_code');
        $data['pending_order']=DB::table('customer_order')->where('order_status', 0)->distinct('order_code')->count('order_code');
        $data['complete_order']=DB::table('customer_order')->where('order_status', 4)->distinct('order_code')->count('order_code');

        $data['total_price'] = DB::table('customer_order')
        ->where('order_status', 4) 
        ->select(DB::raw('MAX(total_price) as total_price')) 
        ->groupBy('order_code') 
        ->pluck('total_price') 
        ->sum();
        date_default_timezone_set('Asia/Dhaka');

        $data['today_order'] = DB::table('customer_order')->whereDate('order_date', Carbon::today())->distinct('order_code')->count('order_code');
        $data['today_pending_order'] = DB::table('customer_order')->where('order_status', 0)->whereDate('order_date', Carbon::today())->distinct('order_code')->count('order_code');
        $data['today_complete_order'] = DB::table('customer_order')->where('order_status', 4)->whereDate('delivery_date', Carbon::today())->distinct('order_code')->count('order_code');

    
        
        $data['today_total_price'] = DB::table('customer_order')
        ->where('order_status', 4) 
        ->whereDate('delivery_date', Carbon::today())
        ->select(DB::raw('MAX(total_price) as total_price')) 
        ->groupBy('order_code') 
        ->pluck('total_price') 
        ->sum();
        
        // Monthly sales for the current year
        $monthlySales = DB::table('customer_order')
        ->select(DB::raw('MONTH(delivery_date) as month, SUM(total_price) as total_sales'))
        ->whereYear('delivery_date', Carbon::now()->year)
        ->where('order_status', 4) // Only completed orders
        ->groupBy(DB::raw('MONTH(delivery_date)'))
        ->pluck('total_sales', 'month')->toArray();

        // Initialize an array for all 12 months with default value 0
        $allMonths = [];
        for ($month = 1; $month <= 12; $month++) {
            $allMonths[$month] = $monthlySales[$month] ?? 200; // If sales exist, use it, otherwise use 0
        }

        // Pass the $allMonths array to the view
        $data['monthly_sales'] = $allMonths;

        // Daily performance for the current month
        $daysInMonth = Carbon::now()->daysInMonth;
        $dailySales = DB::table('customer_order')
            ->select(DB::raw('DAY(order_date) as day, SUM(total_price) as total_sales'))
            ->whereYear('order_date', Carbon::now()->year)
            ->whereMonth('order_date', Carbon::now()->month)
            ->where('order_status', 4) // Completed orders
            ->groupBy(DB::raw('DAY(order_date)'))
            ->pluck('total_sales', 'day')->toArray();

        // Initialize an array for all days in the current month
        $allDays = [];
        for ($day = 1; $day <= $daysInMonth; $day++) {
            $allDays[$day] = $dailySales[$day] ?? 0; // Default to 0 if no sales
        }

        $data['daily_sales'] = $allDays;
        // dd($data);
    
        return view('admin.index')->with($data);
    }

    // category list 
    public function categoryPage(){
        return view("admin.category.create");
    }

    //show category page
    public function categoryList(){
        $data['category_list']=DB::table('category')->paginate(10);
        // return $data['category_list'];exit;
        return view('admin.category.list')->with($data);
    }

    // store category
    public function categoryStore(Request $request){
        
        $name = $request->name;

       $insert= DB::table('category')->insert([
            'name' =>$name,
            'slug' =>Str::slug($name),
        ]);
        if ($insert) {
           return response()->json([
                'status' => true,
                'success' => 'Category created successfully!',
           ]);

        }
       
        

        


    }

    // category update page
    public function categoryupdatePage($id){
        $data['category_info']=DB::table('category')->where('id', $id)->first();
        return view('admin.category.edit')->with($data);
    }

    // update category
    public function categoryUpdate(Request $request){
        
        $name = $request->name;
    
        $update = DB::table('category')->where('id', $request->id)->update([
            'name' => $name,
            'slug' => Str::slug($name),
        ]);
    
        if ($update) {
            return response()->json([
                'status' => true,
                'success' => 'Category updated successfully!',
            ]);
        } else {
            return response()->json([
                'status' => false,
                'error' => 'Nothing Change.',
            ]);
        }
    }


    //delete category
    public function categoryDelete($id){
       
        $delete=DB::table('category')->where('id', $id)->delete();
        if ($delete) {
            return response([
                'status' =>true,
                'message'=>"Successfully Delete A Category"
            ]);
        } else {
            return response([
                'status' =>false,
                'message'=>"Category is not deleted"
            ]);
        }
        
    }

    //category status update
    public function categoryStatusUpdate($id){
        $category_id=DB::table('category')->where('id', $id)->first();
        if ($category_id->status==1) {
           $update= DB::table('category')->where('id', $id)->update([
                'status'    =>0,
           ]);
            
        }elseif ($category_id->status==0) {
            $update= DB::table('category')->where('id', $id)->update([
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

    //show sub category list
    public function subcategoryList(){
        $data['category_list']=DB::table('category')->get();
        $data['sub_category_list']=DB::table('subcategory')->get();
        // return $data['category_list'];exit;
        return view('backend.sub_category.list')->with($data);
    }

    //sub category create form 
    public function subCatCreate(){
        $data['category_list']=DB::table('category')->get();
        return view("backend.sub_category.create")->with($data);
    }

    // store category
    public function subcategoryStore(Request $request){
        $imageName=null;
        $image = $request->file('image');
        $name = $request->name;
        $category_id = $request->category_id;
        if (!empty($image)) {
            $imageName = md5(time().'_'.rand()).'.'.$image->getClientOriginalExtension();
            $image->move(public_path('images/subcategories'), $imageName);
        } else {
            $imageName=null;
        }

       $insert= DB::table('subcategory')->insert([
            'name' =>$name,
            'category_id' =>$category_id,
            'image' =>$imageName,
            'slug' =>Str::slug($name),
        ]);
        if ($insert) {
           return response()->json([
                'status' => true,
                'success' => 'Sub Category created successfully!',
           ]);

        }
       
        

        


    }

    // category update page
    public function subcategoryupdatePage($id){
        $data['sub_category_info']=DB::table('subcategory')->where('id', $id)->first();
        $data['category_list']=DB::table('category')->get();
        
        return view('backend.sub_category.edit')->with($data);
    }

    // update sub category
    public function subcategoryUpdate(Request $request){
            
        $previousImageName = DB::table('subcategory')->where('id', $request->id)->value('image');

        $imageName = null;
        $image = $request->file('image');
        $name = $request->name;
        $category_id = $request->category_id;

        if (!empty($image)) {
            
            $imageName = md5(time().'_'.rand()).'.'.$image->getClientOriginalExtension();
            
            $image->move(public_path('images/subcategories'), $imageName);
            
            if (!empty($previousImageName)) {
                $previousImagePath = public_path('images/subcategories') . '/' . $previousImageName;
                if (file_exists($previousImagePath)) {
                    unlink($previousImagePath);
                }
            }

            // Update the category record in the database
            $update = DB::table('subcategory')->where('id', $request->id)->update([
                'name' => $name,
                'category_id' => $category_id,
                'image' => $imageName,
                'slug' => Str::slug($name),
            ]);
        }else {
            // Update the category record in the database
            $update = DB::table('subcategory')->where('id', $request->id)->update([
                'name' => $name,
                'category_id' => $category_id,
                'slug' => Str::slug($name),
            ]);
        }

    

        if ($update) {
            return response()->json([
                'status' => true,
                'success' => 'Sub Category updated successfully!',
            ]);
        } else {
            return response()->json([
                'status' => false,
                'error' => 'Nothing Change.',
            ]);
        }
    }

     //delete sub category
     public function subcategoryDelete($id){
        $previousImageName = DB::table('subcategory')->where('id', $id)->value('image');
        $previousImagePath = public_path('images/subcategories') . '/' . $previousImageName;
        if (file_exists($previousImagePath)) {
            unlink($previousImagePath);
        }
        $delete=DB::table('subcategory')->where('id', $id)->delete();
        if ($delete) {
            return response([
                'status' =>true,
                'message'=>"Successfully Delete A Sub Category"
            ]);
        } else {
            return response([
                'status' =>false,
                'message'=>"Sub Category is not deleted"
            ]);
        }
        
    }


     //sub category status update
     public function subcategoryStatusUpdate($id){
        $subcategory_id=DB::table('subcategory')->where('id', $id)->first();
        if ($subcategory_id->status==1) {
           $update= DB::table('subcategory')->where('id', $id)->update([
                'status'    =>0,
           ]);
            
        }elseif ($subcategory_id->status==0) {
            $update= DB::table('subcategory')->where('id', $id)->update([
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


