<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;

class FrontendController extends Controller
{
    //login page
    public function login_page(){
        session(['url.intended' => url()->previous()]);
        $data['category'] = DB::table('category')->where('status', 1)->get();
        $data['sub_title']='Log In';
        return view('frontend.login')->with($data);
    }
    //register page
    public function register_page(){
        $data['category'] = DB::table('category')->where('status', 1)->get();
        $data['sub_title']='register';
        return view('frontend.register')->with($data);
    }

    //customer reegistration process
    public function customer_registration(Request $request){
        DB::table('customers')->insert([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
        ]);
        return Redirect()->route('frontend.login')->with('success', 'Your registration is successfull');
    }

    //customer login process
    public function customer_login(Request $request)
    {
        $credentials = [
            'password' => $request->password
        ];

        if (filter_var($request->username, FILTER_VALIDATE_EMAIL)) {
            $credentials['email'] = $request->username;
        } else {
            $credentials['phone'] = $request->username;
        }

        if (Auth::guard('customer')->attempt($credentials)) {
            $previousUrl = session()->get('url.intended', route('home'));
            
            
            return redirect()->to($previousUrl)->with('success', 'Successfully logged in');
        }

        // Authentication failed
        return redirect()->back()->with('error', 'Invalid credentials');
    }


    public function customer_logout()
    {
        Auth::guard('customer')->logout();
        return redirect()->route('home')->with('success', 'Successfully logged out');
    }

    public function home(){
        $data['category'] = DB::table('category')->where('status', 1)->get();
        $data['sliders'] = DB::table('sliders')->where('status', 1)->latest()->get();
        $data['sub_title']='home';
        // session()->flush();
        // Hot deal products
        $hot_deal_product = DB::table('products')->whereNotNull('discount')->where('status', 1)->latest()->get();
        $hot_deal_arr = [];
        foreach ($hot_deal_product as $value) {
            $hot_deals = [];
            $hot_deals['id'] = $value->id;
            $hot_deals['price'] = $value->price;
            $hot_deals['discount'] = $value->discount;
            $hot_deals['discount_price'] = $value->discount ? $value->price - $value->discount : $value->price;
            $hot_deals['percent'] = (int)(($hot_deals['discount'] / $hot_deals['price']) * 100);
            $hot_deals['thumbnail'] = $value->thumbnail;
            
            array_push($hot_deal_arr, $hot_deals);
        }
        
        // Convert hot deal array to collection
        $data['hot_deal'] = collect($hot_deal_arr);
    
        $all_products = DB::table('products')->where('status', 1)->latest()->paginate(14); 

        $product_arr = [];
        foreach ($all_products as $value) {
            $product = [];
            $product['id'] = $value->id;
            $product['title'] = $value->title;
            $product['price'] = $value->price;
            $product['discount'] = $value->discount;
            $product['discount_price'] = $value->discount ? $value->price - $value->discount : $value->price;
            $product['thumbnail'] = $value->thumbnail;

            array_push($product_arr, $product);
        }

       
        $data['products'] = $product_arr;
        $data['pagination'] = $all_products;

        
        return view('frontend.index')->with($data);
    }
    

    //category page view
    public function category_page($id){
        // dd($id);
        if ($id!=1) {
            if ($id==4) {
                $all_products = DB::table('products')->whereNotNull('discount')->where('status', 1)->latest()->paginate(28);
                // dd($all_products);
            } else {
                $all_products = DB::table('products')->where('category_id', $id)->where('status', 1)->latest()->paginate(28);
                // dd($all_products);
            }
            
            

            $product_arr = [];
            foreach ($all_products as $value) {
                $product = [];
                $product['id'] = $value->id;
                $product['title'] = $value->title;
                $product['price'] = $value->price;
                $product['discount'] = $value->discount;
                $product['discount_price'] = $value->discount ? $value->price - $value->discount : $value->price;
                $product['thumbnail'] = $value->thumbnail;

                array_push($product_arr, $product);
            }
            // dd($product_arr);
            $data['products'] = $product_arr;
            $data['pagination'] = $all_products; 
            $data['category'] = DB::table('category')->where('status', 1)->get();
            $data['sub_title']='category';

            return view('frontend.pages.category-page')->with($data);

        } else {
            return redirect()->route('home');
        }
        
        
    }

    
    //shop page 
    public function shop_page(){
        $all_products = DB::table('products')->where('status', 1)->latest()->paginate(21);

            $product_arr = [];
            foreach ($all_products as $value) {
                $product = [];
                $product['id'] = $value->id;
                $product['title'] = $value->title;
                $product['price'] = $value->price;
                $product['discount'] = $value->discount;
                $product['discount_price'] = $value->discount ? $value->price - $value->discount : $value->price;
                $product['thumbnail'] = $value->thumbnail;

                array_push($product_arr, $product);
            }
            // dd($product_arr);
            $data['products'] = $product_arr;
            $data['pagination'] = $all_products; 
            $data['category'] = DB::table('category')->where('status', 1)->get();
            $data['sub_title']='Shop';
            return view('frontend.pages.shop-page')->with($data);
        
        
    }

    public function single_product($id) {
        $single_product = DB::table('products')->where('status', 1)->where('id', $id)->first();
        if (!$single_product) {
            abort(404, 'Product not found');
        }
    
        $gallery_images = DB::table('gallery')->where('product_id', $single_product->id)->get();
        
        $product = [
            'id' => $single_product->id,
            'product_code' => $single_product->product_code,
            'title' => $single_product->title,
            'price' => $single_product->price,
            'discount' => $single_product->discount,
            'discount_price' => $single_product->discount ? $single_product->price - $single_product->discount : $single_product->price,
            'description' => $single_product->description,
            'thumbnail' => $single_product->thumbnail,
            'gallery' => $gallery_images->pluck('image_name')->toArray(),
        ];
        // dd($product);
        $related_products = DB::table('products')->where('id','!=', $single_product->id)->where('category_id', $single_product->category_id)->where('status', 1)->latest()->paginate(14); 

        $related_products_arr = [];
        foreach ($related_products as $value) {
            $productt = [];
            $productt['id'] = $value->id;
            $productt['title'] = $value->title;
            $productt['price'] = $value->price;
            $productt['discount'] = $value->discount;
            $productt['discount_price'] = $value->discount ? $value->price - $value->discount : $value->price;
            $productt['thumbnail'] = $value->thumbnail;

            array_push($related_products_arr, $productt);
        }
        // dd($related_products_arr);
        $company_info=DB::table('users')->where('role_id', 1)->first();
        $data = [
            'single_product_data' => $product,
            'related_product' =>$related_products_arr,
            'category' => DB::table('category')->where('status', 1)->get(),
            'sub_title'=>'Single Product',
            'company_info'=>$company_info,
        ];
        // dd($data);

    
        return view('frontend.pages.single-product', $data);
    }

    public function single_product_quick_view(Request $request) {
        
        $product_id = $request->input('product_id');
     
        $single_product = DB::table('products')->where('id', $product_id)->where('status', 1)->first();
       
       
        $gallery_images = DB::table('gallery')->where('product_id', $single_product->id)->get();
        
        $product = [
            'id' => $single_product->id,
            'product_code' => $single_product->product_code,
            'title' => $single_product->title,
            'price' => $single_product->price,
            'discount' => $single_product->discount,
            'discount_price' => $single_product->discount ? $single_product->price - $single_product->discount : $single_product->price,
            'description' => $single_product->description,
            'thumbnail' => $single_product->thumbnail,
            'gallery' => $gallery_images->pluck('image_name')->toArray(),
        ];
        $sub_title='register';
        // Return the view with just the product HTML
        return view('frontend.pages.quickView', compact('product','sub_title'));
    }
    

    public function shop_checkout()
    {
        
        // if (!Auth::guard('customer')->check()) {
        //    return redirect()->route('frontend.login');
        // }
        // dd();
        $cart = session()->get('cart', []);
        // dd($cart);
        $subtotal = 0;
        $discount = 0;
        $shipping = 0;
        $total = 0;

        foreach ($cart as $item) {
            $subtotal += $item['qty'] * $item['price'];
        }

        $total = $subtotal - $discount + $shipping;

        $data['category'] = DB::table('category')->where('status', 1)->get();
        $data['cart'] = $cart;
        $data['subtotal'] = $subtotal;
        $data['discount'] = $discount;
        $data['shipping'] = $shipping;
        $data['total'] = $total;
        $data['sub_title']='shop checkout';

        return view('frontend.pages.shop-checkout')->with($data);
    }
  

    public function checkout(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'full_name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:15',
            'email_address' => 'required|email|max:255',
            'additional_address' => 'nullable|string|max:255',
            'delivery_address' => 'required|string|max:255',
            'payment_method' => 'required|string',
        ]);
        $additionalAddress = $request->input('additional_address');
       
        $product_ids = $request->input('product_ids');
        $quantities = $request->input('quantities');

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

        // Flag to track whether the order insertion was successful
        $isInserted = false;

        foreach ($product_ids as $index => $product_id) {
            $id = DB::table('customer_order')->insertGetId([
                'customer_id' => Auth::guard('customer')->user()->id ?? null,
                'product_id' => $product_id,
                'products_qty' => $quantities[$index],
                'total_price' => $request->input('total'),
                'full_name' => $request->input('full_name'),
                'delivery_address' => $request->input('delivery_address'),
                'phone_number' => $request->input('phone_number'),
                'email_address' => $request->input('email_address'),
                'additional_information' => $additionalAddress, 
                'payment_method' => $request->input('payment_method'),
                'order_code' => $newOrderCode
            ]);

            if ($id) {
                $isInserted = true; // Mark as inserted
            }
        }

        if ($isInserted) {
            $customer = Auth::guard('customer')->user();
            if ($customer) {
                // Remove all session data and log the user back in
                session()->flush();
                Auth::guard('customer')->login($customer);
                $isCustomerlogin = true;
            } else {
                // Remove all session data
                session()->flush();
                $isCustomerlogin = false;
                $isCustomerlogin = false;
            }

            return response()->json([
                'success' => true,
                'message' => 'Order placed successfully',
                'isCustomerlogin' => $isCustomerlogin,
                'id' => $id,
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Order failed'
            ]);
        }
    }



    public function shopping_card() {
        // session()->forget('cart');
        $cart = session()->get('cart', []);
        $count=count($cart);
        $subtotal = 0;
       
        foreach ($cart as $key => $item) {
            $subtotal += $item['qty'] * $item['price'];
            
            // Fetch the thumbnail from the products table
            $product_tmnl = DB::table('products')->where('id', $item['product_id'])->select('thumbnail', 'title')->where('status', 1)->first();
            
            // Add the thumbnail to the cart item
            $cart[$key]['thumbnail'] = $product_tmnl ? $product_tmnl->thumbnail : null;
            $cart[$key]['title'] = $product_tmnl ? $product_tmnl->title : null;
        }
        session()->put('cart', $cart);
        // Get the category information
        $category = DB::table('category')->where('status', 1)->get();
        $sub_title='Shopping Card';
        // dd($subtotal);
        // Pass updated cart with thumbnails to the view
        return view('frontend.pages.shopping_cart', [
            'cart' => $cart,
            'subtotal' => $subtotal,
            'discount' => 0, 
            'shipping' => 0, 
            'total' => $count, 
            'category' => $category,
            'sub_title' => $sub_title,
        ]);

    }


    

    public function cart_add(Request $request)
    {
        $productId = $request->product_id;
        $qty = $request->qty;
        $price = $request->price;
        // dd($qty);
        // Fetch cart from session
        $cart = session()->get('cart', []);
    
        // Check if the product is already in the cart
        if (isset($cart[$productId])) {
            return response()->json([
                'already_in_cart' => true
            ]);
        }
    
        // Otherwise, add product to cart
        $cart[$productId] = [
            "qty" => $qty,
            "price" => $price,
            "product_id" => $productId
        ];
        session()->put('cart', $cart);

        session()->put('cart_count', count($cart));

        $new=session()->get('cart', []);
        // Return the updated cart count
        $cartCount = count($new);
    
        return response()->json([
            'success' => true,
            'cart_count' => $cartCount
        ]);
    }

    public function update(Request $request, $id)
    {
        $cart = session()->get('cart', []);
        // dd(count($cart));
        if (isset($cart[$id])) {
            $cart[$id]['qty'] = $request->input('quantity');
        }
        
        $totalItems = 0;
        foreach ($cart as $item) {
            $totalItems += $item['qty'];
        }
        
        // dd(count($cart));
        session()->put('cart', $cart);
        session()->put('cart_count', count($cart));

        return redirect()->back()->with('success', 'Cart updated successfully.');
    }
 
    
    public function remove($id)
    {
        $cart = session()->get('cart', []);
        if (isset($cart[$id])) {
            unset($cart[$id]);
        }
        
        // dd($cart);
        // Recalculate total items in the cart
        $totalItems = 0;
        foreach ($cart as $item) {
            $totalItems += $item['qty'];
        }
        $count=count($cart);
        // Update session
        session()->put('cart', $cart);
        session()->put('cart_count', $count);

        return redirect()->back()->with('success', 'Product removed successfully.');
    }

    //search
    public function search(Request $request)
    {
        $query = $request->input('query');
        $category = $request->input('category');
        
        // Perform your search logic here
        $results = DB::table('products')->where('status', 1);

        if ($category) {
            if ($category!=1) {
                if ($category==4) {
                    $results->whereNotNull('discount');
                    // dd($all_products);
                } else {
                    $results->where('category_id', $category);
                    // dd($all_products);
                }
            } 
        }

        if ($query) {
            
            $results->where('title', 'like', '%' . $query . '%');
        }

        $products = $results->get();
        // dd($products);
        $category = DB::table('category')->where('status', 1)->get();
        $sub_title='search';
        return view('frontend.pages.search_results', compact('products', 'category', 'sub_title'));
    }

    






   
}
