<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function index()
    {
        return view('admin.contacts.index', ['contacts' => Contact::all()]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'phone' => 'required',
            'email' => 'required|email',
            'message' => 'required',
        ]);

        $contact = Contact::create($validated);

        Mail::send('email', [
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'phone' => $request->get('phone'),
            'content' => $request->get('message')],
            function ($message) {
                $message->from('info@mmsestate.online');
                $message->to('info@mmsestate.online', 'mmsestate.online')
                    ->subject('Contact Form');
            });

        session()->flash('success', __('admin.contact_received'));

        return redirect()->back();
    }

    public function destroy(Contact $contact)
    {
        $contact->delete();

        return redirect()->route('contacts.index');
    }
}
