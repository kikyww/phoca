<?php

namespace App\Http\Controllers;

use App\Models\Status;
use Illuminate\Http\Request;

class TimelineController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $posts = Status::latest()->paginate(10);
        return view("timeline", compact("posts"));
    }
}
