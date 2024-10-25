<?php

namespace App\Http\Controllers;

use App\Models\Slider;
use Illuminate\Http\Request;
class SliderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sliders = Slider::Where('active','1')->orderBy('id', 'desc')->paginate('5');
        // $sliders = collect();
        return view('sliders.index', compact('sliders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('sliders.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'title' => 'required| max:200',
            'description' => 'required| max:500',
            'link' => 'max:200',
            'text_link' => 'max:200',
            'image' => 'image|required|mimes:jpg,svg,jpeg,png|max:21000',
        ]);
        $slider = new Slider();
        $slider->title = $request->get('title');
        $slider->description = $request->get('description');
        $slider->link = $request->get('link');
        $slider->text_link = $request->get('text_link');

        if($request->hasFile('image')){
            $image = $request->file('image');
            $nameImage = "images/sliders/".uniqid().'.'.$image->guessExtension();
            $route = public_path("images/sliders/");
            $image->move($route, $nameImage);
            $slider->image = $nameImage;
        }
        $slider->save();
        return redirect()->route("slider.index")->with(
            [
                "msg"=> "Slider Creado Correctamente"
            ]);
        

    }

    /**
     * Display the specified resource.
     */
    public function show(Slider $slider)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Slider $slider)
    {
        return view('sliders/edit', compact('slider'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Slider $slider)
    {
        $this->validate($request,[
            'title' => 'required| max:200',
            'description' => 'required| max:500',
            'link' => 'max:200',
            'text_link' => 'max:200',
            'image' => 'image|mimes:jpg,jpeg,svg,png|max:4000|nullable',
        ]);
        // $slider = new Slider();
        $slider->title = $request->get('title');
        $slider->description = $request->get('description');
        $slider->link = $request->get('link');
        $slider->text_link = $request->get('text_link');

        if($request->hasFile('image')){

            $path = public_path().'/'.$slider->image;

            if(file_exists($path) && $slider->image !== null){
                unlink($path);
            };

            $image = $request->file('image');
            $nameImage = "images/sliders/".uniqid().'.'.$image->guessExtension();
            $route = public_path("images/sliders/");
            $image->move($route, $nameImage);
            $slider->image = $nameImage;
        }
        $slider->update();

        return redirect()->route("slider.index")->with(
            [
                "msg"=> "Slider modificado exitosamente"
            ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Slider $slider)
    {
        $slider->active = 0;
        $slider->update();
        return redirect()->route("slider.index")->with(
            [
                "msg"=> "Slider Eliminado exitosamente"
            ]);

    }
}
