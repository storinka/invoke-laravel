<?php

namespace Invoke\Laravel\Http\Controllers;

use Illuminate\Http\Request;
use Invoke\Docs\Docs;
use Invoke\InvokeMachine;

trait InvokeDocsControllerTrait
{
    public function index(Request $request)
    {
        $page = "index";

        $version = InvokeMachine::version();

        $functionsDocuments = Docs::getAllFunctionsDocuments($version);
        $functionDocument = null;

        if ($functionName = $request->get("function")) {
            $functionClass = InvokeMachine::getFunctionClass($functionName, $version);
            $functionDocument = Docs::getFunctionDocument($functionName, $functionClass);
        }

        return view(
            "invoke::docs.index",
            compact(
                "functionsDocuments",
                "functionDocument",
                "page"
            )
        );
    }

    public function getStarted(Request $request)
    {
        $page = "get-started";

        $version = InvokeMachine::version();

        $functionsDocuments = Docs::getAllFunctionsDocuments($version);
        $functionDocument = null;

        return view(
            "invoke::docs.index",
            compact(
                "functionsDocuments",
                "functionDocument",
                "page"
            )
        );
    }
}
