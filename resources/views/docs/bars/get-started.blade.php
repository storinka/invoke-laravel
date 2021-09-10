<div class="d-flex flex-column align-items-stretch flex-shrink-0 bg-white">
    <div class="d-flex align-items-center flex-shrink-0 link-dark text-decoration-none border-bottom">
        <span class="fs-5 fw-semibold p-3">Getting started</span>
    </div>
</div>

<div class="scrollarea" style="max-height: calc(100vh - 63px); min-height: calc(100vh - 63px);">
    <div class="p-3">
        <h5>Configuration</h5>
        <p>
            <b>Invoke URL</b>: <code>{{ config("invoke.url", config("app.url") . "/api/invoke") }}</code>
            <br>
            <b>Invoke Version</b>: <code>{{ \Invoke\InvokeMachine::version() }}</code>
        </p>

        <h5>Details</h5>
        <p>
            To invoke a function you have to make a <code>POST</code> request to <b>Invoke URL</b> with parameters as
            <code>JSON</code> in body.
            In response you will get a <code>JSON</code> with a result.
        </p>
        <h5>CURL example</h5>
        <b>Request:</b>
        <pre>curl -X POST {{ config("invoke.url", config("app.url") . "/api/invoke") . "/" . \Invoke\InvokeMachine::version() . "/dec2hex" }} \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \{!! config("invoke.auth.enable", true) ? "<br>    -H \"Authorization: Bearer YOUR_TOKEN_HERE\"" : "" !!}
    --data '{ "dec": 4095 }'</pre>
        <b>Response:</b>
        <pre>{ "result": "fff" }</pre>

{{--        <h5>JavaScript</h5>--}}
{{--        <p>--}}
{{--            <code xml:lang="application/javascript">--}}
{{--                function invoke(name, params) {--}}

{{--                }--}}
{{--            </code>--}}
{{--        </p>--}}
    </div>
</div>
