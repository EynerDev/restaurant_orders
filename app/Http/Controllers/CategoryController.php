<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::Where('active','1')->orderBy('id', 'desc')->paginate('5');
        // $categorys = collect();
        return view('categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'name' => 'required| max:200',
            'icon' => 'required| max:500',
            'image' => 'image|required|mimes:jpg,svg,jpeg,png|max:1000',
        ]);
        $category = new category();
        $category->name = $request->get('name');
        $category->icon = $request->get('icon');
        

        if($request->hasFile('image')){
            $image = $request->file('image');
            $nameImage = "images/categories/".uniqid().'.'.$image->guessExtension();
            $route = public_path("images/categories/");
            $image->move($route, $nameImage);
            $category->image = $nameImage;
        }
        $category->save();
        return redirect()->route("categories.index")->with(
            [
                "msg"=> "Categoria Creada Correctamente"
            ]);
        
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        return view('categories/edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->active = 0;
        $category->update();
        return redirect()->route("categories.index")->with(
            [
                "msg"=> "Categoria Eliminado exitosamente"
            ]);
    }
}
