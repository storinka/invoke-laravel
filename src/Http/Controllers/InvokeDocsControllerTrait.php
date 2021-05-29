<?php

namespace Invoke\Laravel\Http\Controllers;

use Illuminate\Support\Facades\Response;

trait InvokeDocsControllerTrait
{
    public function index(): \Illuminate\Http\Response
    {
        return Response::view("invoke::docs.index");
    }
}
