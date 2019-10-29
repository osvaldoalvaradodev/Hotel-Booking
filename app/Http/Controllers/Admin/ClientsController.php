<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\Admin\StoreCountriesRequest;
use App\Http\Requests\Admin\UpdateCountriesRequest;
use App\Clients;

class ClientsController extends Controller
{
    public function index()
    {
        if (!Gate::allows('client_access')) {
            return abort(401);
        }


        if (request('show_deleted') == 1) {
            if (!Gate::allows('client_deleted')) {
                return abort(401);
            }
            $clients = Clients::onlyTrashed()->get();
        } else {
            $clients = Clients::all();
        }

        return view('admin.clients.index', compact('clients'));
    }



    public function create()
    {
        if (!Gate::allows('client_access')) {
            return abort(401);
        }
        return view('admin.clients.create');
    }


    public function store(Request $request)
    {
        if (!Gate::allows('client_access')) {
            return abort(401);
        }
        $client = Clients::create($request->all());

        return redirect()->route('admin.clients.index');
    }
}
