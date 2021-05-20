<?php

namespace Invoke\Laravel\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Response;

class InvokeDocsController extends Controller
{
    public function index(): \Illuminate\Http\Response
    {
        return Response::view("invoke::docs.index");
    }
}
