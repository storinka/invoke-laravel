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
    </script>
@endsection
