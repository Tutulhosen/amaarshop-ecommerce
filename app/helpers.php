<?php

use Illuminate\Support\Facades\DB;

if (!function_exists('get_category_name')) {
    function get_category_name($id)
    {   return $id;
        $category_name=DB::table('category')->where('id', $id)->select('name')->first();
        return $category_name->name;
    }
}

if (!function_exists('get_sub_category_name')) {
    function get_sub_category_name($id)
    {
        $sub_category_name=DB::table('subcategory')->where('id', $id)->select('name')->first();
        return $sub_category_name->name;
    }
}

if (!function_exists('order_status')) {
    function order_status($order_status)
    {
       
        if ($order_status==0) {
            return "Pending";
        }elseif ($order_status==1) {
            return "Canceled";
        }elseif ($order_status==2) {
            return "Accepted";
        }elseif ($order_status==3) {
            return "On Delivery";
        }elseif ($order_status==4) {
            return "Delivery Done";
        }elseif ($order_status==5) {
            return "Return Back";
        }else{
            return "--";
        }
    }
}

if (!function_exists('formatDate')) {
    function formatDate($dateString) {
        // Create a DateTime object from the input string
        $date = new DateTime($dateString);
        
        // Format the date as 'd M, Y' (21 Sep, 2024)
        return $date->format('d M, Y');
    }
}

if (!function_exists('convert_div_id_to_name')) {
    function convert_div_id_to_name($id) {
        $div_name=DB::table('division')->where('id', $id)->select('division_name_en')->first();
        return $div_name->division_name_en;
    }
}

if (!function_exists('convert_dis_id_to_name')) {
    function convert_dis_id_to_name($id) {
        $dis_name=DB::table('district')->where('id', $id)->select('district_name_en')->first();
        return $dis_name->district_name_en;
    }
}

if (!function_exists('convert_upa_id_to_name')) {
    function convert_upa_id_to_name($id) {
        $upa_name=DB::table('upazila')->where('id', $id)->select('upazila_name_en')->first();
        return $upa_name->upazila_name_en;
    }
}

//delivery charge
if (!function_exists('delivery_charge')) {
    function delivery_charge($title) {
        if ($title=='inside') {
            return 70;
        }else {
            return 120;
        }
    }
}



?>