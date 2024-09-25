<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Product;

use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function create(){
        return view('product.create');
    }

    public function save(Request $req){
        // Handle backend logic
        
        // Store the file
        $path = $req->file('product_image')
            ->store('product_images', 'public');
            
        // Save the URL to the database
        $fileUrl = Storage::url($path);

        Product::create([
            'pro_name' => $req->input('product_name'),
            'pro_price' => $req->input('product_price'),
            'pro_image_url' => $fileUrl,
        ]);

        // Redirect to home after creating resource, 
        return redirect('/home'); 
    }

    public function index(){
        $products = Product::get();

        return view('product.index', ['products' => $products]);
    }

    public function edit(Product $item){
        return view('product.edit', ['product' => $item]);
    }

    public function view(){
        $products = Product::all();

        return view('product.view', ['products' => $products]);
    }

    public function update(Product $item, Request $request){
        // Handle the backend logic
        
        // Store the file (Only if a new one is uploaded)
        if($request->hasFile('product_image')){
            $path = $request->file('product_image')->store('product_images', 'public');
            // Update the URL to the database
            $fileUrl = Storage::url($path);
        } else {
            $fileUrl = $item->pro_image_url;
        }

        $item->update([
            'pro_name' => $request->input('product_name'),
            'pro_price' => $request->input('product_price'),
            'pro_image_url' => $fileUrl,
        ]);

        // Redirect to home after creating resource, 
        return redirect('/product/index'); 
    }

    public function delete(Request $request){
        Product::find($request->input('pro_id'))->delete();
        return redirect('product/index');
    }

}


