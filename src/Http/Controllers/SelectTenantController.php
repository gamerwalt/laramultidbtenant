<?php

namespace gamerwalt\LaraMultiDbTenant\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class SelectTenantController extends Controller
{
    public function __construct()
    {
        $this->middleware(['web','auth']);
    }

    public function index()
    {
        $user = Auth::user();
        $tenantUsers = $user->tenantUser()->get();

        return view('tenants::select', compact('tenantUsers'));
    }

    public function store(Request $request)
    {
        session()->put('selected-tenant', $request->input('selectedTenant'));

        return redirect()->route('dashboard');
    }
}