<?php

namespace App\Http\Controllers;

use App\Product;
use App\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $products = Product::all();
        return view('products.index')->with('products',$products);
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        return view('products.create')->with('categories',$categories);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $file = $request->file('image');
        $fileName = $file->getClientOriginalName();
        
        $request->file('image')->move("front_assets/upload/",$fileName);
        if($fileName){
            Product::create([
                'title' => $request->title,
                'slug' => str_slug($request->title),
                'category_id' => $request->category_id,
                'image' => $fileName,
                'description' => $request->description,
                'type' => $request->type,
                'price' => $request->price,
                'quantity' => $request->quantity,
                'status' => $request->status,
            ]);
            Session::put('message', 'Product saved  Successfully !');
            return redirect()->route('products.create');
        }else{
            return "Image is not selected";
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
       
        return view('products.show')->with('product',$product);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */


    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('products.edit')->with([
            'categories'=> $categories,
            'product' => $product
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $product->title = $request->title;
        $product->slug = $product->slug == str_slug($request->title) ? $product->slug: str_slug($request->title);
        $product->category_id = $request->category_id;
        $product->description = $request->description;
        $product->type = $request->type;
        $product->price = $request->price;
        $product->quantity = $request->quantity;
        $product->status = $request->status;

        
        
        if($request->has('image')){
            $file = $request->file('image');
            $fileName = $file->getClientOriginalName();
            $request->file('image')->move("front_assets/upload/",$fileName);
            $product->image = $fileName;
        }

        $product->save();

        Session::put('message', 'Product udpated Successfully !');
        return redirect()->route('products.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.edit');
    }





}
