<div class="d-flex flex-column align-items-stretch flex-shrink-0 bg-white border-end">
    <div class="d-flex align-items-center flex-shrink-0 p-3 link-dark text-decoration-none border-bottom">
        <span class="fs-5 fw-semibold">Functions</span>
    </div>
    <div class="list-group list-group-flush border-bottom scrollarea"
         style="max-height: calc(100vh - 63px); min-height: calc(100vh - 63px);">
        @foreach($functionsDocuments as $functionDocument)
            <a href="/invoke/docs?function={{ $functionDocument->name }}"
               data-invoke-function-link="true"
               class="list-group-item list-group-item-action py-3 lh-tight {{ request("function") === $functionDocument->name ? "active" : "" }}"
               aria-current="{{ request("function") === $functionDocument->name ? "true" : "false" }}">
                <div class="d-flex w-100 align-items-center justify-content-between">
                    <strong class="mb-1">{{ $functionDocument->name }}</strong>
                </div>
                @isset($functionDocument->summary)
                    <div class="col-10 mb-1 small">
                        {!! $functionDocument->summary !!}
                    </div>
                @endisset
            </a>
        @endforeach
    </div>
</div>
