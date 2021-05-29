<?php

namespace Invoke\Laravel\Http\Controllers;

trait InvokeDocsControllerTrait
{
    public function index(): \Illuminate\Http\Response
    {
        return response()->view("invoke::docs.index");
    }
}
