<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class NewsletterController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email|max:255',
        ]);

        // Send notification email to admin
        $to = 'humamullahkhan001@gmail.com';
        $subject = 'New Newsletter Subscription';
        $body = "A new user subscribed to the newsletter.\n\nEmail: {$request->email}\n\nTimestamp: " . now()->format('Y-m-d H:i:s');
        $headers = [
            'From' => config('app.name', 'Hume Wear'),
            'Reply-To' => $request->email,
            'Content-Type' => 'text/plain; charset=UTF-8',
        ];
        @mail($to, $subject, $body, $headers);

        return back()->with('newsletter_success', 'Thank you for subscribing! You\'ll be the first to know about new collections and exclusive offers.');
    }
}
