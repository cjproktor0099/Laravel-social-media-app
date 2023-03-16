<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class AdminController extends Controller
{
  Public function AdminPage() {
    if(Gate::allows('visitAdminPages')){
        return 'admin page';
    }

  }

}
