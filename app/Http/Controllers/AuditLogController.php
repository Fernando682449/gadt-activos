<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;

class AuditLogController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $logs = AuditLog::with('user')
            ->orderByDesc('fecha')
            ->paginate(15);

        return view('audit_logs.index', compact('logs'));
    }
}
