<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\actions\UtilitiesController;
use App\Http\Controllers\Controller;
use App\Slider;
use Illuminate\Http\Request;

class SliderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        // $newBlog = new Slider();
        $sliders = Slider::orderBy('created_at', 'desc')->where('disabled', false)->get();
        // dd($projects);
        return view('admin.sliders.index', compact('sliders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.sliders.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $this->validate($request, [
            'large_text' => 'required|bail',
            'small_text' => 'required|bail',
            'picture' => 'image|nullable|max:5999'
        ]);
        // dd('here');
        //Handle file up0loads

        $slider = new Slider();
        $slider->large_text = $request->input('large_text');
        $slider->small_text = $request->input('small_text');
        if ($request->hasFile('picture')) {
            $image = $request->file('picture');
            $call = new UtilitiesController();
            $fileNameToStore = $call->fileNameToStore($image);
            $slider->picture = $fileNameToStore;
        }
        $slider->save();
        return redirect()->route('admin.sliders.index')->with('success', 'Slider Created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $slider = Slider::find($id);
        return view('admin.sliders.edit')->with(['slider' => $slider]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'large_text' => 'required|bail',
            'small_text' => 'required|bail',
            'picture' => 'image|nullable|max:5999'
        ]);
        //Handle file up0loads
        $slider = Slider::find($id);
        $slider->large_text = $request->input('large_text');
        $slider->small_text = $request->input('small_text');
        if ($request->hasFile('picture')) {
            $image = $request->file('picture');
            $call = new UtilitiesController();
            $fileNameToStore = $call->fileNameToStore($image);
            $slider->picture = $fileNameToStore;
        }
        $slider->save();
        return redirect()->route('admin.sliders.index')->with('success', 'Slider Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    public function disable($id)
    {
        $slider = Slider::find($id);
        $slider->disabled = true;
        $slider->save();
        return redirect()->route('admin.sliders.index')->with('success', 'Slider Removed');
    }

    // Restore Disabled category
    public function restore($id)
    {
        $slider = Slider::find($id);
        $slider->disabled = false;
        $slider->save();
        return redirect()->route('admin.sliders.disabled')->with('success', 'Slider Restored');
    }

    // Display Disabled Categories
    public function disabled()
    {
        $new = new Slider();
        $d_sliders = $new->getDisabledSliders();
        return view('admin.sliders.disabled')->with('sliders', $d_sliders);
    }
}