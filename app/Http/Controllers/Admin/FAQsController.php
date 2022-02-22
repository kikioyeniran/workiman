<?php

namespace App\Http\Controllers\admin;

use App\FAQs;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FAQsController extends Controller
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
        // $newBlog = new faq();
        $faqs = FAQs::orderBy('created_at', 'desc')->where('disabled', false)->get();
        // dd($projects);
        return view('admin.faqs.index', compact('faqs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.faqs.create');
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
            'question' => 'required|bail',
            'answer' => 'required|bail',
        ]);
        // dd('here');
        //Handle file up0loads

        $faq = new FAQs();
        $faq->question = $request->input('question');
        $faq->answer = $request->input('answer');
        $faq->save();
        return redirect()->route('admin.faqs.index')->with('success', 'FAQ Created');
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
        $faq = FAQs::find($id);
        return view('admin.faqs.edit')->with(['faq' => $faq]);
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
            'question' => 'required|bail',
            'answer' => 'required|bail',
        ]);
        //Handle file up0loads
        $faq = FAQs::find($id);
        $faq->question = $request->input('question');
        $faq->answer = $request->input('answer');
        $faq->save();
        return redirect()->route('admin.faqs.index')->with('success', 'faq Updated');
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
        $faq = FAQs::find($id);
        $faq->disabled = true;
        $faq->save();
        return redirect()->route('admin.faqs.index')->with('success', 'FAQ Removed');
    }

    // Restore Disabled category
    public function restore($id)
    {
        $faq = FAQs::find($id);
        $faq->disabled = false;
        $faq->save();
        return redirect()->route('admin.faqs.disabled')->with('success', 'FAQ Restored');
    }

    // Display Disabled Categories
    public function disabled()
    {
        $new = new FAQs();
        $d_faqs = $new->getDisabledfaqs();
        return view('admin.faqs.disabled')->with('faqs', $d_faqs);
    }
}
