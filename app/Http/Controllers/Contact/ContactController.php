<?php

namespace App\Http\Controllers\Contact;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ContactController extends Controller
{
    
    /**
     * Show the application contact us form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showContactUsForm()
    {
        return view('contact');
    }
}
