<?php

namespace App\Http\Controllers\Customer;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Customer\CustomerService;

class FeedbackController extends Controller
{
    private $customerService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(CustomerService $customerServ)
    {
        $this->customerService = $customerServ;
    }

    /**
     * Show Feedback Form
     *
     */
    public function showFeedbackForm(){
        return view('customer.feedback');
    }

    /**
     * Save Feedback
     *
     */
    public function store(Request $request){

        $request->validate([
            'value' => 'required'
        ]);

        $response = $this->customerService->storeFeedback($request);
        /* Return response */
        if ($response == 'success') {
            return redirect()->back()->with('status', 'Thank you for your valueable feedback.');
        } else {
            return redirect()->back()->withErrors($response);
        }
    }

}
