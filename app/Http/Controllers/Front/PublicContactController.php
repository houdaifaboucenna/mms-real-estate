<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContactStoreRequest;
use App\Models\Contact;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;

class PublicContactController extends Controller
{
    public function contact()
    {
        return Inertia::render('Contactus', [
            'translations' => [
                'address' => __('home.address'),
                'adrs' => __('home.adrs'),
                'contact_form' => __('home.contact_form'),
            ],
        ]);
    }

    public function store(ContactStoreRequest $request): RedirectResponse
    {
        Contact::create($request->validated());

        return redirect()->back()->with('success', __('admin.contact_received'));
    }
}
