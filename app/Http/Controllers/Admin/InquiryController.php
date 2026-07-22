<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Inquiry;
use Illuminate\View\View;

class InquiryController extends Controller
{
    public function index(): View
    {
        return view('admin.inquiries.index', [
            'inquiries' => Inquiry::query()->latest()->paginate(10),
        ]);
    }
}
