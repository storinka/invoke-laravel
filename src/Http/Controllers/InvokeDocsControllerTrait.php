<?php

namespace Invoke\Laravel\Http\Controllers;

trait InvokeDocsControllerTrait
{
    public function index()
    {
        return view("invoke::docs.index");
    }
}
