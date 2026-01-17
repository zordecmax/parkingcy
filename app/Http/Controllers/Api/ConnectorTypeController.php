<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ConnectorType;
use Illuminate\Http\Request;

class ConnectorTypeController extends Controller
{
    public function index()
    {
        $connectors = ConnectorType::all()->toArray();

        return wrap_response('200', 'OK', $connectors);
    }
}
