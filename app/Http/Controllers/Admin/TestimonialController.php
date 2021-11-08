<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\actions\UtilitiesController;
use App\Http\Controllers\Controller;
use App\Testimonial;
use Illuminate\Http\Request;

class TestimonialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware(['auth']);
    }
    public function index()
    {
        // $newCat = new Testimonial();
        // $testimonials = $newCat->getTestimonials();
        // return view('admin.testimonials.index', compact('testimonials'));

        $testimonials = Testimonial::orderBy('created_at', 'desc')->where('disabled', false)->get();
        return view('admin.testimonials.index', compact('testimonials'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.testimonials.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            // 'portfolio' => 'required',
            'testimony' => 'required',
            'picture' => 'image|nullable|max:5999'
        ]);
        $name = $request->input('name');
        $testimonial = new Testimonial();
        $testimonial->name = $name;
        $testimonial->portfolio = $request->portfolio;
        $testimonial->testimony = $request->testimony;
        if ($request->hasFile('picture')) {
            $image = $request->file('picture');
            $call = new UtilitiesController();
            $fileNameToStore = $call->fileNameToStore($image);
            $testimonial->picture = $fileNameToStore;
        }
        $testimonial->save();

        return redirect()->route('admin.testimonials.index')->with('success', 'Testimonial created');
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
        $testimonial = Testimonial::find($id);
        return view('admin.testimonials.edit')->with('testimonial', $testimonial);
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
            'name' => 'required',
            // 'portfolio' => 'required',
            'testimony' => 'required',
            'picture' => 'image|nullable|max:5999'
        ]);
        $name = $request->input('name');
        $testimonial = Testimonial::find($id);
        $testimonial->name = $name;
        $testimonial->portfolio = $request->portfolio;
        $testimonial->testimony = $request->testimony;
        if ($request->hasFile('picture')) {
            $image = $request->file('picture');
            $call = new UtilitiesController();
            $fileNameToStore = $call->fileNameToStore($image);
            $testimonial->picture = $fileNameToStore;
        }
        $testimonial->save();

        return redirect()->route('admin.testimonials.index')->with('success', 'Testimonial edited');
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
        $testimonial = Testimonial::find($id);
        $testimonial->disabled = true;
        $testimonial->save();
        return redirect()->route('admin.testimonials.index')->with('success', 'Testimonial Disabled');
    }

    // Restore Disabled Testimonial
    public function restore($id)
    {
        $testimonial = Testimonial::find($id);
        $testimonial->disabled = false;
        $testimonial->save();
        return redirect()->route('categories.disabled')->with('success', 'Testimonial Restored');
    }

    // Display Disabled Categories
    public function disabled()
    {
        $new = new Testimonial();
        $d_testimonials = $new->getDisabledTestimonials();
        return view('admin.testimonials.disabled')->with('testimonials', $d_testimonials);
    }
}