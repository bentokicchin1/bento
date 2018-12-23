<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use DB;
use App\Model\Feedback;
use App\Model\User;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    public function index()
    {
        $feedbacks = Feedback::with('users')->withTrashed()->get()->toArray();
        return view('admin.feedbacks.list', ['feedbacks' => $feedbacks]);
    }


}
