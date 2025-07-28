<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuditController extends Controller
{
    public function auditTable()
    {
        $user = auth()->user();
        $query = $user->auditRelation();

        $audits = $query->get();

        return view('auditlog', [
            'users' => $user,
            'audits' => $audits,
        ]);
    }
}
