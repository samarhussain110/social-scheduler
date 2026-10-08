<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ActivityLogController extends Controller
{
    public function index(Request $request)
    {
        $query = Auth::user()
            ->activityLogs()
            ->orderBy('created_at', 'desc');

        // Filter by action if provided
        if ($request->has('action')) {
            $query->where('action', $request->action);
        }

        // Filter by date range if provided
        if ($request->has('from_date')) {
            $query->where('created_at', '>=', $request->from_date);
        }

        if ($request->has('to_date')) {
            $query->where('created_at', '<=', $request->to_date);
        }

        $activityLogs = $query->paginate(50);

        $actions = ActivityLog::where('user_id', Auth::id())
            ->select('action')
            ->distinct()
            ->pluck('action');

        return view('activity-logs.index', compact('activityLogs', 'actions'));
    }

    public function show(ActivityLog $activityLog)
    {
        return view('activity-logs.show', compact('activityLog'));
    }

    public function destroy(ActivityLog $activityLog)
    {
        $activityLog->delete();

        return back()->with('success', 'Activity log deleted');
    }
}