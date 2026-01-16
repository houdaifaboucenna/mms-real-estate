<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    public function index()
    {
      return view('admin.faq.index', ['faqs' => Faq::all()]);
    }

    public function create()
    {
      return view('admin.faq.create');
    }

    public function store(Request $request)
    {
      $validated = $request->validate([
        "question" => 'required',
        "question_ar" => 'required',
        "answer" => 'required',
        "answer_ar" => 'required',
        'show_home'=> 'required',
      ]);

      session()->flash('success', __("admin.faq_created"));

      $faqs = Faq::create($validated);

      return redirect()->route('faq.index');
    }

    public function edit(Faq $faq)
    {
      return view('admin.faq.create',['faq' => $faq]);
    }

    public function update(Request $request, Faq $faq)
    {
      $data = $request->validate([
        "question" => 'required',
        "question_ar" => 'required',
        "answer" => 'required',
        "answer_ar" => 'required',
        'show_home'=> 'required',
      ]);

      session()->flash('success', __("admin.faq_updated"));

      $faq->update($data);
      return redirect()->route('faq.index');
    }

    public function destroy(Faq $faq)
    {
        $faq->delete();

        return redirect()->route('faq.index');
    }
}
