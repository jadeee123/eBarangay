<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class ContactMessageController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'subject' => ['required', 'string', 'max:255'],
            'message' => ['required', 'string', 'max:5000'],
        ]);

        // Save the resident's message in Supabase
        DB::table('contact_messages')->insert([
            'user_id' => auth()->id(),
            'name' => $validated['name'],
            'email' => $validated['email'],
            'subject' => $validated['subject'],
            'message' => $validated['message'],
            'is_read' => false,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Send the message to the barangay Gmail account
        try {
            Mail::raw(
                "Name: {$validated['name']}\n"
                . "Email: {$validated['email']}\n\n"
                . "Message:\n{$validated['message']}",
                function ($mail) use ($validated) {
                    $mail->to('brgy.cuambugan@gmail.com')
                        ->subject($validated['subject'])
                        ->replyTo(
                            $validated['email'],
                            $validated['name']
                        );
                }
            );
        } catch (\Throwable $e) {
            report($e);

            return back()->with(
                'mail_error',
                'Your message was saved, but the email could not be sent. Please try again later.'
            );
        }

        return back()->with(
            'success',
            'Your message has been sent to the barangay office!'
        );
    }


public function reply(Request $request, $id)
{
    // Only staff can reply to contact messages
    if (!auth()->check() || auth()->user()->role !== 'staff') {
        abort(403);
    }

    $validated = $request->validate([
        'reply_message' => ['required', 'string', 'max:5000'],
    ]);

    $contactMessage = DB::table('contact_messages')
        ->where('id', $id)
        ->first();

    if (!$contactMessage) {
        abort(404);
    }

    try {
        Mail::raw(
            $validated['reply_message'],
            function ($mail) use ($contactMessage) {
                $mail->to($contactMessage->email)
                    ->subject('Re: ' . $contactMessage->subject)
                    ->replyTo(
                        'brgy.cuambugan@gmail.com',
                        'Barangay Office'
                    );
            }
        );
    } catch (\Throwable $e) {
        report($e);

        return back()->with(
            'reply_error',
            'The reply could not be sent. Please try again.'
        );
    }

DB::table('contact_messages')
    ->where('id', $id)
    ->update([
        'is_read' => true,
        'updated_at' => now(),
    ]);

    if ($contactMessage->user_id) {
    DB::table('resident_notifications')->insert([
        'user_id' => $contactMessage->user_id,
        'request_id' => null,
        'title' => 'New Reply from Barangay',
        'message' => 'The barangay office has replied to your contact message: ' . $contactMessage->subject,
        'type' => 'contact_reply',
        'is_read' => false,
        'created_at' => now(),
        'updated_at' => now(),
    ]);
}


    return back()->with(
        'reply_success',
        'Your reply was successfully sent to the resident!'
    );
}

}
