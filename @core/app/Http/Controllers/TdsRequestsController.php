<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Str;

class TdsRequestsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        $requests = DB::table('tds_request as a')
                    ->leftJoin('works as b', 'a.works_id', '=', 'b.id')
                    ->select('*', 'a.id as id', 'a.created_at as created_at')
                    ->get();
        return view('backend.pages.tds-request.index')->with(['requests' => $requests]);
    }
}
