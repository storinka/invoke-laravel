<div class="d-flex flex-column align-items-stretch flex-shrink-0 bg-white border-end">
    <div class="d-flex align-items-center flex-shrink-0 p-3 link-dark text-decoration-none border-bottom">
        <span class="fs-5 fw-bold">
            {{ config("app.name") }}
            (v{{ \Invoke\InvokeMachine::version() }})
        </span>
    </div>
    <div class="list-group list-group-flush border-bottom scrollarea"
         style="max-height: calc(100vh - 63px); min-height: calc(100vh - 63px);"
         id="functionsList">
        <div class="list-group-item list-group-item-action lh-tight" style="padding: 0;">
            <input id="search" type="text" class="p-3 py-2" style="margin: 0; width: 100%; border: none;" placeholder="Search">
        </div>
        <a href="/invoke/docs/get-started"
           data-invoke-function-link="true"
           data-search-item="Getting started"
           class="list-group-item list-group-item-action py-2 lh-tight {{ $page === "get-started" ? "active" : "" }}">
            <div class="d-flex w-100 align-items-center justify-content-between">
                <strong>Getting started</strong>
            </div>
        </a>
        @foreach($functionsDocuments as $functionDocument)
            <a href="/invoke/docs?function={{ $functionDocument->name }}"
               data-invoke-function-link="true"
               data-search-item="{{ $functionDocument->name }}"
               class="list-group-item list-group-item-action py-3 lh-tight {{ request("function") === $functionDocument->name ? "active" : "" }}"
               aria-current="{{ request("function") === $functionDocument->name ? "true" : "false" }}">
                <div class="d-flex w-100 align-items-center justify-content-between">
                    <strong>{{ $functionDocument->name }}</strong>
                </div>
                @isset($functionDocument->summary)
                    <div class="col-10 small">
                        {!! $functionDocument->summary !!}
                    </div>
                @endisset
            </a>
        @endforeach
        <div class="d-flex align-items-center flex-shrink-0 link-dark text-decoration-none border-top" style="margin-top: auto;">
            <div class="p-2" style="font-size: 14px;">
                <span class="fw-bold">{{ sizeof($functionsDocuments) }}</span> {{ sizeof($functionsDocuments) === 1 ? "function" : "functions" }} defined.
                Powered by <a href="https://github.com/storinka/invoke" target="_blank">Invoke</a>.
            </div>
        </div>
    </div>
</div>
