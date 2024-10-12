<?php

namespace App\Http\Controllers\backend;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class MemberShipController extends Controller
{
    //list
    public function List(){
       $members= DB::table('customers')->latest()->paginate('10');

       $members_array=[];
        foreach ($members as  $value) {
            
            $total_order=DB::table('customer_order')->where('customer_id', $value->id)->count();
            $pending_order=DB::table('customer_order')->where('customer_id', $value->id)->where('order_status',0)->count();
            $delivered_order=DB::table('customer_order')->where('customer_id', $value->id)->where('order_status',4)->count();
            $reject_order=DB::table('customer_order')->where('customer_id', $value->id)->where('order_status',5)->count();
            $data_each['name']=$value->name;
            $data_each['email']=$value->email;
            $data_each['phone']=$value->phone;
            $data_each['total_order']=$total_order;
            $data_each['pending_order']=$pending_order;
            $data_each['delivered_order']=$delivered_order;
            $data_each['reject_order']=$reject_order;

            array_push($members_array, $data_each);
        }
       $data['members']=$members_array;
       $data['paginate']= DB::table('customers')->latest()->paginate('10');
       return view('admin.member.list')->with($data);
    }

    //search
    public function searchList(Request $request)
    {
        $query = DB::table('customers');

        if ($request->name) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        if ($request->email) {
            $query->where('email', 'like', '%' . $request->email . '%');
        }
        if ($request->phone) {
            $query->where('phone', 'like', '%' . $request->phone . '%');
        }

        if ($request->date_from || $request->date_to) {
            $dateFrom = $request->date_from;
            $dateTo = $request->date_to;

            if (!empty($dateFrom) && !empty($dateTo)) {
                $query->whereBetween('created_at', [$dateFrom, $dateTo]);
            } elseif (!empty($dateFrom)) {
                $query->whereDate('created_at', '>=', $dateFrom);
            } elseif (!empty($dateTo)) {
                $query->whereDate('created_at', '<=', $dateTo);
            }
        }



        $member = $query->latest()->get();
           
        $members_array=[];
        foreach ($member as  $value) {
            
            $total_order=DB::table('customer_order')->where('customer_id', $value->id)->count();
            $pending_order=DB::table('customer_order')->where('customer_id', $value->id)->where('order_status',0)->count();
            $delivered_order=DB::table('customer_order')->where('customer_id', $value->id)->where('order_status',4)->count();
            $reject_order=DB::table('customer_order')->where('customer_id', $value->id)->where('order_status',5)->count();
            $data_each['name']=$value->name;
            $data_each['email']=$value->email;
            $data_each['phone']=$value->phone;
            $data_each['total_order']=$total_order;
            $data_each['pending_order']=$pending_order;
            $data_each['delivered_order']=$delivered_order;
            $data_each['reject_order']=$reject_order;

            array_push($members_array, $data_each);
        }
       
        return response()->json([
            'table_rows' => $members_array,
            
        ]);
    }






}
