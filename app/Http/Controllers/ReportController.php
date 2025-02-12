<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ReportSchedule;

class ReportController extends Controller
{
    public function index()
    {
        $schedules = ReportSchedule::all();
        return view('reports.index', compact('schedules'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'frequency' => 'required|in:daily,weekly,monthly',
        ]);

        ReportSchedule::create($request->all());

        return redirect()->back()->with('success', 'Report schedule added.');
    }
}
