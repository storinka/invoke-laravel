@extends('invoke::layouts.docs')

@section('body')
    <div class="row gx-0" id="app">
        <div class="col-3">
            @include('invoke::docs.bars.functionsList')
        </div>

        @isset($functionDocument)
            <div class="col-9">
                <function-bar/>
            </div>
        @elseif($page === "get-started")
            <div class="col-9">
                @include('invoke::docs.bars.get-started')
            </div>
        @else
            <div class="col-9">
                <div class="w-100 h-100 d-flex justify-content-center align-items-center text-muted">
                    SELECT A FUNCTION
                </div>
            </div>
        @endif
    </div>
@endsection

@section('scripts')
    @include('invoke::docs.bars.function')

    <script>
        Vue.use(VTooltip)
        Vue.use(VueTippy);

        const app = new Vue({
            el: "#app",
            components: {
                FunctionBar,
            }
        });

        const $functionsList = document.getElementById("functionsList");

        $functionsList.onscroll = event => {
            localStorage.setItem("invoke-functionsList-scrollTop", event.target.scrollTop);
        }

        $functionsList.scrollTo(0, Number(localStorage.getItem("invoke-functionsList-scrollTop")));
    </script>

    <script>
        const $search = document.getElementById("search");
        const searchItems = document.querySelectorAll("[data-search-item]");

        $search.addEventListener("input", event => {
            const q = event.target.value.trim().toLowerCase();

            if (!q.length) {
                for (const $i of searchItems) {
                    $i.style.display = "block";
                }
            } else {
                for (const $i of searchItems) {
                    const s = $i.getAttribute("data-search-item").toLowerCase();

                    if (s.includes(q) || q.includes(s)) {
                        $i.style.display = "block";
                    } else {
                        $i.style.display = "none";
                    }
                }
            }
        });
    </script>
@endsection
