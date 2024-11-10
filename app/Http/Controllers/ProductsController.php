<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Products;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Products::Where('active','1')->orderBy('id', 'desc')->paginate('5');
        return view('products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all()->where('active','1');
        return view('products.create', compact('categories'));
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'name' => 'required| max:200',
            'description' => 'max:500',
            'price' =>'required | min:0 | numeric',
            'label' => 'max:500',
            'category' => 'required| numeric | min:0',
            'image' => 'image|required|mimes:jpg,jpeg,png|max:1000',
        ]);
        $product = new Products();
        $product->name = $request->get('name');
        $product->description = $request->get('description');
        $product->price = $request->get('price');
        $product->label = $request->get('label');
        $product->category_id = $request->get('category');
        

        if($request->hasFile('image')){
            $image = $request->file('image');
            $nameImage = "images/products/".uniqid().'.'.$image->guessExtension();
            $route = public_path("images/products/");
            $image->move($route, $nameImage);
            $product->image = $nameImage;
        }
        $product->save();
        return redirect()->route("products.index")->with(
            [
                "msg"=> "Producto Creado Correctamente"
            ]);
        
    }

    /**
     * Display the specified resource.
     */
    public function show(Products $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Products $product)
    {
        $categories = Category::all()->where('active','1');
        return view('products.edit', compact('categories','product'));   
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Products $product)
    {
        {
            $this->validate($request,[
                'name' => 'required| max:200',
                'icon' => 'required| max:500',
                'image' => 'image|mimes:jpg,svg,jpeg,png|max:1000|nullable',
            ]);
            $category->name = $request->get('name');
            $category->icon = $request->get('icon');
            
    
            if($request->hasFile('image')){
    
                $path = public_path().'/'.$category->image;
    
                if(file_exists($path) && $category->image !== null){
                    unlink($path);
                };
    
                $image = $request->file('image');
                $nameImage = "images/sliders/".uniqid().'.'.$image->guessExtension();
                $route = public_path("images/sliders/");
                $image->move($route, $nameImage);
                $category->image = $nameImage;
            }
    
            $category->update();
            return redirect()->route("categories.index")->with(
                [
                    "msg"=> "Categoria Creada Correctamente"
                ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Products $product)
    {
        //
    }
}
