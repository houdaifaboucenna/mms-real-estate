<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class FaqController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Admin/Faq/Index', [
            'faqs' => Faq::all(),
            'translations' => [
                'faq' => __('admin.faq'),
                'add_question' => __('admin.add_question'),
                'question' => __('admin.question'),
                'answer' => __('admin.answer'),
                'show_home' => __('admin.show_home'),
                'actions' => __('admin.actions'),
                'edit' => __('admin.edit'),
                'delete' => __('admin.delete'),
                'confirm_delete' => __('admin.confirm_delete'),
                'enabled' => __('admin.enabled'),
                'disabled' => __('admin.disabled'),
                'number' => __('admin.number'),
            ],
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Admin/Faq/Create', [
            'translations' => [
                'add_question' => __('admin.add_question'),
                'edit_question' => __('admin.edit_question'),
                'question' => __('admin.question'),
                'answer' => __('admin.answer'),
                'show_home' => __('admin.show_home'),
                'save' => __('admin.save'),
                'add' => __('admin.add'),
                'en' => __('admin.en'),
                'ar' => __('admin.ar'),
            ],
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'question' => 'required',
            'question_ar' => 'required',
            'answer' => 'required',
            'answer_ar' => 'required',
            'show_home' => 'required|boolean',
        ]);

        Faq::create($validated);

        return redirect()->route('faq.index')->with('success', __('admin.faq_created'));
    }

    public function edit(Faq $faq): Response
    {
        return Inertia::render('Admin/Faq/Create', [
            'faq' => $faq,
            'translations' => [
                'add_question' => __('admin.add_question'),
                'edit_question' => __('admin.edit_question'),
                'question' => __('admin.question'),
                'answer' => __('admin.answer'),
                'show_home' => __('admin.show_home'),
                'save' => __('admin.save'),
                'update' => __('admin.update'),
                'en' => __('admin.en'),
                'ar' => __('admin.ar'),
            ],
        ]);
    }

    public function update(Request $request, Faq $faq): RedirectResponse
    {
        $validated = $request->validate([
            'question' => 'required',
            'question_ar' => 'required',
            'answer' => 'required',
            'answer_ar' => 'required',
            'show_home' => 'required|boolean',
        ]);

        $faq->update($validated);

        return redirect()->route('faq.index')->with('success', __('admin.faq_updated'));
    }

    public function destroy(Faq $faq): RedirectResponse
    {
        $faq->delete();

        return redirect()->route('faq.index')->with('success', __('admin.comment_deleted')); // Reusing comment_deleted or adding dedicated one
    }
}
