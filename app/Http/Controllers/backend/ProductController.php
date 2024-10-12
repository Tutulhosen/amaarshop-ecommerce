<?php

namespace App\Http\Controllers\backend;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    //product list
    public function productList(){

        $product_list=DB::table('products')->latest()->paginate(10);
        
        $product_array=[];
        foreach ($product_list as  $value) {
            
            $gallery=DB::table('gallery')->where('product_id', $value->id)->select('image_name')->get();
            $gallery_array=[];
            foreach ($gallery as  $values) {
                array_push($gallery_array, $values);
            }

            $data_each['id']=$value->id;
            $data_each['title']=$value->title;
            $data_each['gallery_array']=$gallery_array;
            $data_each['status']=$value->status;
            $data_each['product_code']=$value->product_code;
            $data_each['category_id']=$value->category_id;
            $data_each['sub_category']=$value->sub_category;
            $data_each['price']=$value->price;
            $data_each['discount']=$value->discount;
            $data_each['size']=json_decode($value->size);
            $data_each['quantity']=$value->quantity;
            $data_each['thumbnail']=$value->thumbnail;
            array_push($product_array, $data_each);
        }

        $data['product_array']=$product_array;
        $data['paginate']=DB::table('products')->latest()->paginate(10);
        $data['category']=DB::table('category')->whereNotIn('id', [1,4])->where('status', 1)->get();
        // dd($data);
        return view('admin.product.list')->with($data);
    }

    public function productSearchList(Request $request)
    {
        $query =DB::table('products')->latest();

        if ($request->product_code) {
            $query->where('product_code', 'like', '%' . $request->product_code . '%');
        }

        if ($request->title) {
            $query->where('title', 'like', '%' . $request->title . '%');
        }

        if ($request->category) {
            $query->where('category_id', $request->category );
        }

        

        $products = $query->paginate(10);
        // dd($products);
        
       
        return response()->json([
            'table_rows' => $products->items(),
            
        ]);
    }

    //product create page
    public function productCreate(){
        $data['category']=DB::table('category')->whereNotIn('id', [1,4])->where('status', 1)->get();
        return view('admin.product.create')->with($data);
    }

    //product store
    public function productStore(Request $request){
        $title = $request->input('title');
        $productCode = $request->input('product_code');
        $category_id = $request->input('category_id');
        $description = $request->input('description');
        $price = $request->input('price');
        $discount = $request->input('discount');
        $quantity = $request->input('quantity');
        
       
        // dd($request->all());
        // For single file uploads
        if ($request->hasFile('thumbnail_image')) {
            $thumbnailImage = $request->file('thumbnail_image');
            $imageName = md5(time().'_'.rand()).'.'.$thumbnailImage->getClientOriginalExtension();
            
            $thumbnailImage->move(public_path('images/galleries'), $imageName);
            
        }else {
            $imageName=null;
        }
        try {
            DB::beginTransaction();
            $product_id= DB::table('products')->insertGetId([
                'product_code' =>$productCode,
                'title' =>$title,
                'category_id' =>$category_id,
                'quantity' =>$quantity,
                'price' =>$price,
                'discount' =>$discount,
                'description' =>$description,
                'thumbnail' =>$imageName,
            ]);

            if ($product_id) {
                // For multiple file uploads
                if ($request->hasFile('gallery_images')) {
                    $galleryImages = $request->file('gallery_images');
                    
                    foreach ($galleryImages as $galleryImage) {
                        $galleryImageName = md5(time().'_'.rand()).'.'.$galleryImage->getClientOriginalExtension();
                        DB::table('gallery')->insert([
                            'image_name' =>$galleryImageName,
                            'image_title' =>$galleryImageName,
                            'product_id' => $product_id
                        ]);
                       
                        
                        $galleryImage->move(public_path('images/galleries'), $galleryImageName);
                        
                    }
                }
            }
            // dd($product_id);
            DB::commit();
            return response()->json([
                'status' => true,
                'success' => 'successfully Add A New Product',
            ]);

            
        } catch (\Throwable $th) {
            DB::rollBack();
       
        }
        
    }

    // Product update page
    public function productupdatePage($id, $type){
        $data['type']=$type;
        $data['subcategory']=DB::table('subcategory')->get();
        // dd($id);
        $data['category']=DB::table('category')->get();
        $data['product_list']=DB::table('products')->where('id', $id)->first();
        $data['gallery']=DB::table('gallery')->where('product_id', $data['product_list']->id)->select('image_name')->get();
        
        
       
        return view('admin.product.edit')->with($data);
    }

    //product update
    public function productUpdate(Request $request){
        $product_id = $request->input('product_id');
        $type = $request->input('type');
        $title = $request->input('title');
        $productCode = $request->input('product_code');
        $category_id = $request->input('category_id');
        $description = $request->input('description');
        $price = $request->input('price');
        $discount = $request->input('discount');
        $quantity = $request->input('quantity');

        if ($type=='update') {
            $previousImageName = DB::table('products')->where('id', $product_id)->value('thumbnail');
    
            // For single file uploads
            if ($request->hasFile('thumbnail_image')) {
                
                $thumbnailImage = $request->file('thumbnail_image');
                $imageName = md5(time().'_'.rand()).'.'.$thumbnailImage->getClientOriginalExtension();
                
                $thumbnailImage->move(public_path('images/galleries'), $imageName);
                if (!empty($previousImageName)) {
                    $previousImagePath = public_path('images/gallery') . '/' . $previousImageName;
                    if (file_exists($previousImagePath)) {
                        unlink($previousImagePath);
                    }
                }
                
            }else {
                $imageName=$previousImageName;
            }
            try {
                DB::beginTransaction();
                $product_update= DB::table('products')->where('id', $product_id)->update([
                    'product_code' =>$productCode,
                    'title' =>$title,
                    'category_id' =>$category_id,
                    'quantity' =>$quantity,
                    'price' =>$price,
                    'discount' =>$discount,
                    'description' =>$description,
                    'thumbnail'  =>$imageName
                ]);
                

                
                
                // For multiple file uploads
                if ($request->hasFile('gallery_images')) {
                    $galleryImages = $request->file('gallery_images');
                    $previousgalleryImages = DB::table('gallery')->where('product_id', $product_id)->get();
                    
                    // Unlink previous gallery images
                    foreach ($previousgalleryImages as $previousImage) {
                        $previousImagePath = public_path('images/galleries') . '/' . $previousImage->image_name;
                        if (file_exists($previousImagePath)) {
                            unlink($previousImagePath);
                        }
                        $previousgalleryImages = DB::table('gallery')->where('product_id', $product_id)->delete();
                    }
                    foreach ($galleryImages as $galleryImage) {
                        $galleryImageName = md5(time().'_'.rand()).'.'.$galleryImage->getClientOriginalExtension();
                        DB::table('gallery')->insert([
                            'image_name' =>$galleryImageName,
                            'image_title' =>$galleryImageName,
                            'product_id' => $product_id
                        ]);
                    
                        
                        $galleryImage->move(public_path('images/galleries'), $galleryImageName);
                        
                    }
                }
                
                // dd($product_update);
                DB::commit();
                

                
            } catch (\Throwable $th) {
                DB::rollBack();
        
            }

            return response()->json([
                'status' => true,
                'success' => 'successfully Update the Product',
            ]);
        }elseif ($type=='copy') {
            if ($request->hasFile('thumbnail_image')) {
                $thumbnailImage = $request->file('thumbnail_image');
                $imageName = md5(time().'_'.rand()).'.'.$thumbnailImage->getClientOriginalExtension();
                
                $thumbnailImage->move(public_path('images/galleries'), $imageName);
                
            }else {
                $imageName=null;
            }
            try {
                DB::beginTransaction();
                $product_id= DB::table('products')->insertGetId([
                    'product_code' =>$productCode,
                    'title' =>$title,
                    'category_id' =>$category_id,
                    'quantity' =>$quantity,
                    'price' =>$price,
                    'discount' =>$discount,
                    'description' =>$description,
                    'thumbnail' =>$imageName,
                ]);
    
                if ($product_id) {
                    // For multiple file uploads
                    if ($request->hasFile('gallery_images')) {
                        $galleryImages = $request->file('gallery_images');
                        
                        foreach ($galleryImages as $galleryImage) {
                            $galleryImageName = md5(time().'_'.rand()).'.'.$galleryImage->getClientOriginalExtension();
                            DB::table('gallery')->insert([
                                'image_name' =>$galleryImageName,
                                'image_title' =>$galleryImageName,
                                'product_id' => $product_id
                            ]);
                           
                            
                            $galleryImage->move(public_path('images/galleries'), $galleryImageName);
                            
                        }
                    }
                }
                // dd($product_id);
                DB::commit();
                return response()->json([
                    'status' => true,
                    'success' => 'successfully Copy the Product',
                ]);
    
                
            } catch (\Throwable $th) {
                DB::rollBack();
           
            }
        }else {
            return response()->json([
                'status' => false,
                'success' => 'something wrong',
            ]);
        }
       
       

        
    }

    //delete product
    public function productDelete($id){
        
        $this_product= DB::table('products')->where('id', $id)->first();
        if ($this_product->status == 1) {
            return response([
                'status' => false,
                'message' => "This product is currently active and cannot be deleted. Please deactivate it before proceeding."
            ]);
        } else {
            $previousgalleryImages = DB::table('gallery')->where('product_id', $id)->get();
                
            // Unlink previous gallery images
            foreach ($previousgalleryImages as $previousImage) {
                $previousImagePath = public_path('images/galleries') . '/' . $previousImage->image_name;
                if (file_exists($previousImagePath)) {
                    unlink($previousImagePath);
                }
                $previousgalleryImages = DB::table('gallery')->where('product_id', $id)->delete();
            }


            $previousImageName = DB::table('products')->where('id', $id)->value('thumbnail');
        
            
            if (!empty($previousImageName)) {
                $previousImagePath = public_path('images/gallery') . '/' . $previousImageName;
                if (file_exists($previousImagePath)) {
                    unlink($previousImagePath);
                }
            }

            $delete= DB::table('products')->where('id', $id)->delete();


            if ($delete) {
                return response([
                    'status' =>true,
                    'message'=>"Successfully Delete A Product"
                ]);
            } else {
                return response([
                    'status' =>false,
                    'message'=>"Product is not deleted"
                ]);
            }
        }
        
        
        
    }

    //product status update
    public function productStatusUpdate($id){
        $product_id=DB::table('products')->where('id', $id)->first();
        if ($product_id->status==1) {
           $update= DB::table('products')->where('id', $id)->update([
                'status'    =>0,
           ]);
            
        }elseif ($product_id->status==0) {
            $update= DB::table('products')->where('id', $id)->update([
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
