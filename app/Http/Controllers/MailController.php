<?php

namespace App\Http\Controllers;

use App\Mail\CallbackRequest;
use Illuminate\Http\Request;
use Mail;

class MailController extends Controller
{
    public function sendCallbackRequest(Request $request)
    {
        $details = [
            'name' => $request->nameContact,
            'email' => $request->mailContact,
            'message' => $request->textarea,
        ];

        Mail::to('deshevshe.ukraine@gmail.com')->send(new CallbackRequest($details));

        return back()->with('success', 'Ваш запит на зворотній дзвінок відправлено!');
    }
}
