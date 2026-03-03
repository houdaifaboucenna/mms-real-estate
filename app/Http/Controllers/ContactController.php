<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactStoreRequest;
use App\Models\Contact;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class ContactController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Admin/Contact/Index', [
            'contacts' => Contact::latest()->paginate(10),
            'translations' => [
                'contacts' => __('admin.contacts'),
                'all_contacts' => __('admin.all_contacts'),
                'contact' => __('admin.contact'),
                'number' => __('admin.number'),
                'name' => __('admin.name'),
                'email' => __('admin.email'),
                'phone' => __('admin.phone'),
                'date' => __('admin.date'),
                'message' => __('admin.message'),
                'actions' => __('admin.actions'),
                'delete' => __('admin.delete'),
                'preview' => __('admin.preview'),
                'confirm_delete' => __('admin.confirm_delete'),
            ],
        ]);
    }

    public function store(ContactStoreRequest $request): RedirectResponse
    {
        Contact::create($request->validated());

        return redirect()->back()->with('success', __('admin.contact_received'));
    }

    public function destroy(Contact $contact): RedirectResponse
    {
        $contact->delete();

        return redirect()->route('contacts.index')->with('success', __('admin.contact_deleted'));
    }
}
