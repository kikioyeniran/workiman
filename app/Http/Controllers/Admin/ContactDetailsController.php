<?php

namespace App\Http\Controllers\admin;

use App\ContactDetails;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ContactDetailsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $contact_details = ContactDetails::get()->first();
        return view('admin.contact_details.index')->with(['contact_details' => $contact_details]);
    }


    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'fb_link' => 'required|bail',
            'tw_link' => 'required|bail',
            'ig_link' => 'required|bail',
            // 'address' => 'required|bail',
            'email' => 'required|bail',
            'phone' => 'required|bail',
        ]);

        $contact_details = ContactDetails::find($id);
        $contact_details->fb_link = $request->input('fb_link');
        $contact_details->tw_link = $request->input('tw_link');
        $contact_details->ig_link = $request->input('ig_link');
        $contact_details->li_link = $request->input('li_link');
        $contact_details->address = $request->input('address');
        $contact_details->email = $request->input('email');
        $contact_details->phone = $request->input('phone');
        $contact_details->save();
        return redirect()->route('admin.contact-details.index')->with('success', 'Contact Details Updated');
    }
}