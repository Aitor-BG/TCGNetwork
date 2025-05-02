<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function AdminDashboard()
    {
        return view("admin.admin_dashboard");
    }

    public function AdminSegunda()
    {
        return view("admin.admin_notificaciones");
    }

    public function AdminTercera()
    {
        return view("admin.admin_logs");
    }
}
