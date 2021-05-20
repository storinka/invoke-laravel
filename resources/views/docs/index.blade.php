@extends('invoke::layouts.docs')

@section('body')
    <div class="container">
        <h1 class="py-5">Invoke Docs</h1>

        <section>
            <div class="h2">
                Functions
            </div>

            <div class="accordion pt-3" id="accordion-functions">
                @foreach(\Invoke\InvokeMachine::currentVersionFunctionsTree() as $functionName => $functionClass)
                    @php
                        $functionId = str_replace(".", "-", $functionName);

                        $functionDoc = \Invoke\Laravel\Docs\Types\ClassFunctionDocumentResult::create([
                            "name" => $functionName,
                            "class" => $functionClass,
                        ]);

                        if (is_string($functionDoc->result_type) && class_exists($functionDoc->result_type)) {
                            $resultDoc = \Invoke\Typesystem\Docs\ClassTypeDocumentResult::create([
                                "name" => $functionDoc->result,
                                "class" => $functionDoc->result_type,
                            ]);
                        } else {
                            $resultDoc = null;
                        }

                        $generateParamsTableHtml = function (array $params) {
                            $body = "";

                            foreach($params as $paramName => $paramType) {
                                $body .= '<tr>
                                    <td>' . $paramName . '</td>
                                    <td>' . $paramType . '</td>
                                </tr>';
                            }

                            return '<table class="table table-bordered">
                                        <thead>
                                        <tr>
                                            <th scope="col">Name</th>
                                            <th scope="col">Type</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        ' . $body . '
                                        </tbody>
                                    </table>';
                        };

                        $generateTypeDetails = function ($type) use ($resultDoc, $generateParamsTableHtml) {
                            if (is_string($type) && class_exists($type)) {
                                return $generateParamsTableHtml($resultDoc->params);
                            }

                            return "A type.";
                        };
                    @endphp
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading-function-{{ $functionId }}">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapse-function-{{ $functionId }}" aria-expanded="false"
                                    aria-controls="collapse-function-{{ $functionId }}">
                                {{ $functionName }}
                            </button>
                        </h2>
                        <div id="collapse-function-{{ $functionId }}" class="accordion-collapse collapse"
                             aria-labelledby="heading-function-{{ $functionId }}"
                             data-bs-parent="#accordion-functions">
                            <div class="accordion-body">
                                <div class="h6">
                                    Params
                                </div>
                                @if (sizeof($functionDoc->params) > 0)
                                    {!! $generateParamsTableHtml($functionDoc->params) !!}
                                @else
                                    <p class="text-muted">
                                        no params
                                    </p>
                                @endif

                                <div class="h6 pt-3">
                                    Result:
                                    <strong data-bs-toggle="popover"
                                            style="cursor: pointer;"
                                            title="{{ htmlentities($functionDoc->result) }}"
                                            data-bs-html="true"
                                            data-bs-content="// todo">
                                        {{ $functionDoc->result }}
                                    </strong>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
    </div>
@endsection
