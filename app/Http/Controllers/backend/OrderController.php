<?php

namespace App\Http\Controllers\backend;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

class OrderController extends Controller
{
    public function orderList(){
        $data['order_list'] = DB::table('customer_order')
        ->select('order_code', DB::raw('MAX(id) as id'), DB::raw('MAX(total_price) as total_price'), DB::raw('MAX(full_name) as full_name'), DB::raw('MAX(order_status) as order_status'), DB::raw('MAX(order_date) as order_date'), DB::raw('MAX(phone_number) as phone_number'))
        ->groupBy('order_code')
        ->orderBy('id', 'DESC')
        ->paginate(10);

        // dd($data['order_list']);
        
        return view('admin.order.list')->with($data);
    }

    public function create(){
        
        
        return view('admin.order.create');
    }

    public function searchProduct(Request $request)
    {
        $searchTerm = $request->input('query');

        // Search for products by title
        $products = DB::table('products')->where('title', 'LIKE', '%' . $searchTerm . '%')
            ->select('id', 'title', 'price', 'thumbnail') // Select relevant fields
            ->get();

        return response()->json($products);
    }

    public function store(Request $request)
    {
        

        // Retrieve and parse the input data
        $product_ids = $request->input('product_ids');
        foreach ($product_ids as $key => $value) {
            $new_product_ids = explode(',', $value);
        }

        $quantities = $request->input('quantities');
        foreach ($quantities as $key => $value) {
            $new_quantities = explode(',', $value);
        }

        $subtotals = $request->input('subtotals');
        foreach ($subtotals as $key => $value) {
            $new_subtotals = explode(',', $value);
        }
        $total= array_sum($new_subtotals);
       
        $delivery_charge = (int)$request->input('shipping_method');
        // dd($delivery_charge);
        // Retrieve the last order_code
        $lastOrder = DB::table('customer_order')
            ->orderBy('id', 'desc')
            ->whereNotNull('order_code')
            ->first();

        $newOrderNumber = 1;

        if ($lastOrder) {
            $lastOrderCode = $lastOrder->order_code;
            $lastOrderNumber = (int)str_replace('GM-', '', $lastOrderCode);
            $newOrderNumber = $lastOrderNumber + 1;
        }

        // Format the new order code 
        $newOrderCode = 'GM-' . str_pad($newOrderNumber, 2, '0', STR_PAD_LEFT);

        $isInserted = false;

        // Loop through each product and insert the order
        foreach ($new_product_ids as $index => $product_id) {
            $quantity = $new_quantities[$index];
            $subtotal = $new_subtotals[$index];

            // Create a new order in the database
            $id = DB::table('customer_order')->insertGetId([
                'customer_id' => null, 
                'product_id' => $product_id,
                'products_qty' => $quantity,
                'total_price' => $total + $delivery_charge,
                'full_name' => $request->input('full_name'),
                'delivery_address' => $request->input('delivery_address'),
                'phone_number' => $request->input('phone_number'),
                'order_code' => $newOrderCode,
                'delivery_charge' => $delivery_charge,
            ]);

            if ($id) {
                $isInserted = true;
            }
        }

        if ($isInserted) {
            return redirect()->route('admin.order.list')->with('success', 'Order placed successfully.');
        } else {
            return redirect()->back()->with('error', 'Failed to place the order.');
        }
    }

    

    public function edit($order_code)
    {
        $single_order=DB::table('customer_order')->where('order_code', $order_code)->first();
        
        $order_invoice=DB::table('products')
        ->join('customer_order', 'customer_order.product_id', 'products.id')
        ->where('customer_order.order_code', $single_order->order_code)
        ->select('products.title as title','customer_order.products_qty as products_qty' ,'customer_order.product_id as product_id' ,'products.thumbnail as thumbnail', 'products.price as offer_cost', 'products.discount as discount')
        ->get();
        
        $data['single_order']=$single_order;
        $data['order_invoice']=$order_invoice;
        // dd($data);   
        
        return view('admin.order.edit')->with($data);
    }

   

    public function update_by(Request $request, $order_code)
    {
        // Retrieve and parse the input data
        $existingOrder = DB::table('customer_order')->where('order_code', $order_code)->get();
        foreach ($existingOrder as  $value) {
            DB::table('customer_order')->where('order_code', $order_code)->delete();
        }
        
        $product_ids = $request->input('product_ids');
        foreach ($product_ids as $key => $value) {
            $new_product_ids = explode(',', $value);
        }

        $quantities = $request->input('quantities');
        foreach ($quantities as $key => $value) {
            $new_quantities = explode(',', $value);
        }

        $subtotals = $request->input('subtotals');
        foreach ($subtotals as $key => $value) {
            $new_subtotals = explode(',', $value);
        }
        $total= array_sum($new_subtotals);
       
        $delivery_charge = (int)$request->input('shipping_method');
        // dd($delivery_charge);
        // Retrieve the last order_code
        $lastOrder = DB::table('customer_order')
            ->orderBy('id', 'desc')
            ->whereNotNull('order_code')
            ->first();

        $newOrderNumber = 1;

        if ($lastOrder) {
            $lastOrderCode = $lastOrder->order_code;
            $lastOrderNumber = (int)str_replace('GM-', '', $lastOrderCode);
            $newOrderNumber = $lastOrderNumber + 1;
        }

        // Format the new order code 
        $newOrderCode = 'GM-' . str_pad($newOrderNumber, 2, '0', STR_PAD_LEFT);

        $isInserted = false;

        // Loop through each product and insert the order
        foreach ($new_product_ids as $index => $product_id) {
            $quantity = $new_quantities[$index];
            $subtotal = $new_subtotals[$index];

            // Create a new order in the database
            $id = DB::table('customer_order')->insertGetId([
                'customer_id' => null, 
                'product_id' => $product_id,
                'products_qty' => $quantity,
                'total_price' => $total + $delivery_charge,
                'full_name' => $request->input('full_name'),
                'delivery_address' => $request->input('delivery_address'),
                'phone_number' => $request->input('phone_number'),
                'order_code' => $order_code,
                'delivery_charge' => $delivery_charge,
            ]);

            if ($id) {
                $isInserted = true;
            }
        }

        if ($isInserted) {
            return redirect()->route('admin.order.list')->with('success', 'Order Update successfully.');
        } else {
            return redirect()->back()->with('error', 'Failed to update the order.');
        }
    }




    protected function generateOrderCode()
    {
        $lastOrder = DB::table('customer_order')->orderBy('id', 'desc')->first();
        if ($lastOrder) {
            $lastCode = $lastOrder->order_code;
            $newCodeNumber = (int) filter_var($lastCode, FILTER_SANITIZE_NUMBER_INT) + 1;
            return 'GM-' . sprintf('%02d', $newCodeNumber);
        }

        return 'GM-01';
    }


    public function orderSearchList(Request $request)
    {
        $order_status=(int)$request->order_status;
        // dd($request->order_code);
        $query = DB::table('customer_order')
        ->select('order_code', DB::raw('MAX(id) as id'), DB::raw('MAX(total_price) as total_price'), DB::raw('MAX(full_name) as full_name'), DB::raw('MAX(order_status) as order_status'), DB::raw('MAX(order_date) as order_date'), DB::raw('MAX(phone_number) as phone_number'));

        if ($request->order_code) {
            $orderCode = trim($request->order_code); 
            $query->where(DB::raw('BINARY order_code'), 'like', '%' . $orderCode . '%');
        }

        if ($request->phone) {
            $query->where('phone_number', 'like', '%' . $request->phone . '%');
        }

        if ($request->has('order_status')) {
            $query->where('order_status', $order_status);
        }

        if ($request->date_from || $request->date_to) {
            $dateFrom = $request->date_from;
            $dateTo = $request->date_to;

            if (!empty($dateFrom) && !empty($dateTo)) {
                $query->whereBetween('order_date', [$dateFrom, $dateTo]);
            } elseif (!empty($dateFrom)) {
                $query->whereDate('order_date', '>=', $dateFrom);
            } elseif (!empty($dateTo)) {
                $query->whereDate('order_date', '<=', $dateTo);
            }
        }

        $orders = $query->groupBy('order_code')
        ->orderBy('id', 'DESC')->get();
        
        $order_arr=[];
        foreach ($orders as $key => $value) {
           $is_order_placed=DB::table('place_order')->where('order_code', $value->order_code)->first();
        
           $datas=[
            'is_order_placed' => $is_order_placed->id ?? null,
            'order_code' => $value->order_code,
            'id' => $value->id,
            'total_price' => $value->total_price,
            'full_name' => $value->full_name,
            'order_status' => $value->order_status,
            'order_date' => $value->order_date,
            'phone_number' => $value->phone_number,
           ];

           array_push($order_arr, $datas);
        }
       
        // dd($order_arr);
       
        return response()->json([
            'table_rows' => $order_arr,
            
        ]);
    }

    public function search(Request $request)
    {
        $searchTerm = $request->input('query');

        // Search for products by title
        $products = DB::table('products')->where('title', 'LIKE', '%' . $searchTerm . '%')
            ->select('id', 'title', 'price', 'thumbnail') // Select relevant fields
            ->get();

        return response()->json($products);
    }



    public function orderStatusUpdate(Request $request){
        $id = $request->input('id');
        $type = $request->input('type');
        $all_order=DB::table('customer_order')->where('order_code', $id)->get();
        
        foreach ($all_order as $key => $value) {
            if ($type=='accept') {
                DB::table('customer_order')->where('id', $value->id)->update([
                    'order_status' => 2
                ]);
            }
            if ($type=='cancel') {
                DB::table('customer_order')->where('id', $value->id)->update([
                    'order_status' => 1
                ]);
            }
            if ($type=='on_delivery') {
                DB::table('customer_order')->where('id', $value->id)->update([
                    'order_status' => 3
                ]);
            }
            if ($type=='delivery_done') {
                DB::table('customer_order')->where('id', $value->id)->update([
                    'order_status' => 4,
                    'delivery_date' => Carbon::now(),
                ]);
            }
            if ($type=='return_back') {
                DB::table('customer_order')->where('id', $value->id)->update([
                    'order_status' => 5
                ]);
            }
    
        }
     
       
        return response([
            'status' =>true
        ]);

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
        
        return view('frontend.pages.invoice_new')->with($data);
    }

    //place order at stead fast
    public function placeOrder(Request $request)
    {
       
        $orderId = $request->data_id; 
       
        $order = DB::table('customer_order')->where('id', $orderId)->first();
        // dd($order->order_code);
       $id= DB::table('place_order')->insertGetId([
            'order_code' => $order->order_code,
            'app_name' => 'steadfast',
        ]);
        $invoice_number=$order->order_code . '-' .date('d') . '-' .date('m') . '-' . date('y') .'-' . $id;
        // dd($invoice_number);


       

        // Send the API request to place the order
        $response = Http::withHeaders([
            'Api-Key' => 'vgpjvzm14yypua4nk731nqcpebcjdawg',
            'Secret-Key' => 'ijze8hdsmkqjeoiwcq9txdct',
            'Content-Type' => 'application/json',
        ])->post('https://portal.packzy.com/api/v1/create_order', [
            'invoice' => $invoice_number,
            'recipient_name' => $order->full_name,
            'recipient_phone' => $order->phone_number,
            'recipient_address' => $order->delivery_address,
            'cod_amount' => $order->total_price,
        ]);
        // Check the response status
        if ($response->successful()) {
            $responseData = $response->json();
            // dd( $responseData);
            $consignment = $responseData['consignment'];
            $consignment_id = $consignment['consignment_id'];
            $invoice = $consignment['invoice'];
            $tracking_code = $consignment['tracking_code'];
            $status = $consignment['status'];
            
            DB::table('place_order')->where('id', $id)->update([
                'consignment_id' =>$consignment_id,
                'invoice' =>$invoice,
                'tracking_code' =>$tracking_code,
                'status' =>$status,
            ]);
            $all_order=DB::table('customer_order')->where('order_code', $order->order_code)->get();
            foreach ($all_order as $key => $value) {
                DB::table('customer_order')->where('id', $value->id)->update([
                    'order_status' =>3
                ]);
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Order placed successfully',
                'data' => $response->json()
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to place order',
                'error' => $response->json(),
            ], $response->status());
        }
    }

    //order status stead fast
    public function OrderStatus(Request $request){
        $consignment_id=DB::table('place_order')->where('id', $request->data_id)->first();

        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://portal.packzy.com/api/v1/status_by_cid/' . $consignment_id->consignment_id,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
            'Api-Key: vgpjvzm14yypua4nk731nqcpebcjdawg',
            'Secret-Key: ijze8hdsmkqjeoiwcq9txdct',
            'Content-Type: application/json'
        ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);
        $res=json_decode($response);
        $message= 'This order status is '. $res->delivery_status ;
       
        return response()->json([
            'status' => 'success',
            'message' => $message,
            
        ]);

    }
}
