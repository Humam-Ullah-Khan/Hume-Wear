<?php

namespace App\Http\Controllers;

use App\Mail\ContactMessageMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function show()
    {
        return view('public.contact');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|max:50',
            'message' => 'required|string',
        ]);

        Mail::to('humamullahkhan001@gmail.com')->send(new ContactMessageMail($validated));

        return redirect()->route('contact.show')->with('success', 'Thank you! Your message has been sent. We\'ll get back to you soon.');
    }
}
