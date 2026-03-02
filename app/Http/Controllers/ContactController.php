<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ContactController extends Controller
{
    public function index(): Response
    {
        $contacts = Contact::latest()->get()->map(function ($contact) {
            return [
                'id' => $contact->id,
                'name' => $contact->name,
                'email' => $contact->email,
                'phone' => $contact->phone,
                'message' => $contact->message,
                'date' => $contact->created_at->format('d/m/Y'),
            ];
        });

        return Inertia::render('Admin/Contact/Index', [
            'contacts' => $contacts,
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

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:50',
            'phone' => 'required|numeric|digits:10|starts_with:0',
            'email' => 'required|email|max:50',
            'message' => 'required|string|max:500',
        ]);

        Contact::create($validated);

        return redirect()->back()->with('success', __('admin.contact_received'));
    }

    public function destroy(Contact $contact): RedirectResponse
    {
        $contact->delete();

        return redirect()->route('contacts.index')->with('success', __('admin.comment_deleted')); // Reusing for consistency
    }
}
