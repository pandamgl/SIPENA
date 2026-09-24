<?php

namespace App\Http\Controllers;

use App\Models\LogAksiAdmin;
use Illuminate\Http\Request;

class LogAksiAdminController extends Controller
{
    public function index()
    {
        $logs = LogAksiAdmin::with(['pengajuan', 'admin'])->latest()->get();
        return response()->json($logs);
    }
}