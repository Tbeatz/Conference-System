<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class SendReviewController extends Controller
{
    public function view(Request $request)
    {
        $categories = Category::all();
        return view('admin.reviewer.sendpaper', compact('categories'));
    }
}
