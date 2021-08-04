@if ($functionDocument)
    <div class="modal fade" id="tsModal" tabindex="-1" aria-labelledby="tsModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <pre style="margin: 0;">{{ \Invoke\Laravel\Utils\Typescript::renderFunctionTypes($functionDocument) }}</pre>
                </div>
            </div>
        </div>
    </div>
@endif

<script>
    const BasicParamsTable = {
        name: "basic-params-table",
        template: `
            <table class="table table-borderless m-0">
                <thead>
                <tr class="border-bottom">
                    <th class="border-end" scope="col">Name</th>
                    <th scope="col">Type</th>
                </tr>
                </thead>
                <tbody>
                    <tr :class="{ 'border-bottom': i !== params.length - 1 }" :key="param.name" v-for="(param, i) in params">
                        <td class="border-end" v-text="param.name"></td>
                        <tippy theme="light" interactive arrow v-if="param.type.params">
                            <template v-slot:trigger>
                                <td v-text="param.type.as_string"></td>
                            </template>

                            <basic-params-table :params="param.type.params"/>
                        </tippy>
                        <td v-else v-text="param.type.as_string"></td>
                    </tr>
                </tbody>
            </table>

        `,
        props: {
            params: Array,
        },
        beforeCreate: function () {
            this.$options.components.TreeFolderContents = BasicParamsTable
        }
    }

    const ParamsTable = {
        template: `
            <table class="table table-borderless m-0">
                <thead>
                <tr class="border-bottom">
                    <th class="border-end" scope="col">Name</th>
                    <th :class="{ 'border-end': edit }" scope="col">Type</th>
                    <th scope="col" v-if="edit">Value</th>
                </tr>
                </thead>
                <tbody>
                    <tr class="border-bottom" :key="param.name" v-for="param in params">
                        <td class="border-end" v-text="param.name"></td>
                        <tippy theme="light" interactive arrow v-if="param.type.params">
                            <template v-slot:trigger>
                                <td :class="{ 'border-end': edit }" v-text="param.type.as_string"></td>
                            </template>

                            <basic-params-table :params="param.type.params"/>
                        </tippy>
                        <td v-else :class="{ 'border-end': edit }" v-text="param.type.as_string"></td>
                        <td v-if="edit">
                            <input type="text" v-model="values[param.name]">
                        </td>
                    </tr>
                </tbody>
            </table>
            `,
        components: {
            BasicParamsTable
        },
        props: {
            params: Array,
            values: Object,
            edit: Boolean,
        },
    };

    const functionDocument = {!! json_encode($functionDocument, JSON_UNESCAPED_UNICODE) !!};

    const defaultValues = () => {
        let paramsFromStorage = localStorage.getItem(`___invoke___docs___params_${functionDocument.name}`);
        if (paramsFromStorage) {
            paramsFromStorage = JSON.parse(paramsFromStorage);
        } else {
            paramsFromStorage = {};
        }

        const paramsClone = {};

        for (const {name} of functionDocument.params) {
            if (paramsFromStorage[name]) {
                paramsClone[name] = paramsFromStorage[name];
            } else {
                paramsClone[name] = "";
            }
        }

        return paramsClone;
    };

    class JsonParseError {
        constructor(response, text) {
            this.response = response;
            this.text = text;
        }
    }

    const FunctionBar = {
        components: {
            ParamsTable,
            VueJsonPretty: VueJsonPretty.default
        },
        template: `
        <div class="row gx-0">
            <div class="col-7 border-end">
                <div class="d-flex flex-column align-items-stretch flex-shrink-0 bg-white border-end">
                    <div class="d-flex align-items-center flex-shrink-0 link-dark text-decoration-none border-bottom">
                        <span class="fs-5 fw-semibold p-3" v-text="functionDocument.name"></span>

                        <button class="border-0 fs-5 fw-semibold p-3 px-4 bg-white"
                                @click="edit = false"
                                style="margin-left: auto;"
                                v-if="edit">
                            cancel
                        </button>

                        <button class="border-0 fs-5 fw-semibold p-3 px-4"
                                @click="tsModal.toggle()"
                                style="margin-left: auto;"
                                v-if="!edit">
                            📋
                        </button>

                        <button class="border-0 fs-5 fw-semibold p-3 px-4 bg-primary text-white"
                                @click="onClickInvoke"
                                v-text="invoking ? 'Invoking...' : 'Invoke'"
                                :disabled="invoking"
                                :class="{ 'bg-dark': edit, 'text-light': edit }">
                            Invoke
                        </button>
                    </div>
                </div>

                <div class="scrollarea" style="max-height: calc(100vh - 63px); min-height: calc(100vh - 63px);">
                    <div v-if="functionDocument.description" class="d-flex align-items-center flex-shrink-0 p-2 px-2 link-dark text-decoration-none border-bottom border-start">
                        <span class="fw-semibold" v-text="functionDocument.description"></span>
                    </div>

                    <div class="d-flex align-items-center flex-shrink-0 p-2 px-2 link-dark text-decoration-none border-bottom">
                        <span class="fw-semibold">Params</span>
                    </div>
                    <params-table :params="functionDocument.params" :edit="edit" :values="values"/>

                    <div class="d-flex align-items-center flex-shrink-0 p-2 px-2 link-dark text-decoration-none border-bottom">
                        <span class="fw-semibold">
                            Result:
                            <span class="fw-bold" v-text="functionDocument.result.name"></span>
                        </span>
                    </div>
                    <params-table v-if="functionDocument.result.params" :params="functionDocument.result.params"/>

                    <div v-if="edit"
                         class="d-flex align-items-center flex-shrink-0 link-dark text-decoration-none border-bottom">
                        <input id="accessToken" type="text"
                               style="width: 100%; margin-top: auto; color: coral"
                               class="p-2 border-0"
                               v-model="accessToken"
                               placeholder="Authorization token">
                    </div>
                </div>
            </div>
            <div class="col-5 scrollarea" style="max-height: calc(100vh); min-height: calc(100vh);">
                <div v-if="error" class="p-2">
                    <template v-if="isErrorHtml">
                        <div v-html="error.text"></div>
                    </template>
                    <template v-else>
                        <div class="text-danger" v-text="error.message != null ? error.message : error"></div>
                        <label for="showFullError">
                            <input id="showFullError" type="checkbox" v-model="showFullError">
                            Show response
                        </label>
                    </template>
                    <vue-json-pretty v-if="showFullError" :data="error"></vue-json-pretty>
                </div>
                <div v-else-if="edit && result !== undefined && !invoking"
                     class="w-100 h-100 d-flex text-muted p-2"
                     style="max-height: calc(100vh); min-height: calc(100vh);">
                    <vue-json-pretty :data="result"></vue-json-pretty>
                </div>
                <div v-else class="w-100 h-100 d-flex justify-content-center align-items-center text-muted"
                     v-text="invoking ? 'INVOKING...' : 'TRY TO INVOKE'">
                </div>
            </div>
        </div>
`,
        data() {
            return {
                functionDocument,

                showTypescript: false,

                edit: false,
                invoking: false,

                result: undefined,
                error: null,
                showFullError: false,

                values: defaultValues(),
                accessToken: localStorage.getItem("___invoke___docs___access_token"),

                tsModal: new bootstrap.Modal(document.getElementById("tsModal"))
            };
        },
        computed: {
            isErrorHtml() {
                return this.error instanceof JsonParseError;
            },
        },
        methods: {
            onClickInvoke() {
                if (!this.edit) {
                    this.edit = true;
                } else {
                    if (this.invoking) {
                        return;
                    }
                    this.error = null;
                    this.invoking = true;

                    const headers = {
                        "Content-Type": "application/json",
                        "Accept": "application/json",
                    };

                    if (this.accessToken) {
                        headers.Authorization = "Bearer " + this.accessToken;
                    }

                    const parseJson = async response => {
                        const clone = response.clone();

                        try {
                            return await response.json();
                        } catch (e) {
                            throw new JsonParseError(clone, await clone.text());
                        }
                    }

                    const parsedValues = {};

                    for (const key of Object.keys(this.values)) {
                        const value = this.values[key];

                        if (value && ((value.startsWith("{") && value.endsWith("}")) || (value.startsWith("[") && value.endsWith("]")))) {
                            parsedValues[key] = JSON.parse(value);
                        } else {
                            parsedValues[key] = value;
                        }
                    }

                    fetch(`{{rtrim(config("invoke.url", env("APP_URL") . "/api"), "/")}}/invoke/${this.functionDocument.name}`, {
                        method: "post",
                        headers,
                        body: JSON.stringify(parsedValues),
                    })
                        .then(async response => {
                            if (!response.ok) {
                                throw await parseJson(response);
                            }

                            return await parseJson(response);
                        })
                        .then(data => data.result)
                        .then(result => {
                            this.result = result;
                        })
                        .catch(error => {
                            this.error = error;
                        })
                        .finally(() => {
                            this.invoking = false;
                        })
                }
            }
        },
        watch: {
            accessToken(token) {
                localStorage.setItem("___invoke___docs___access_token", token)
            },
            values: {
                deep: true,
                handler() {
                    localStorage.setItem(`___invoke___docs___params_${this.functionDocument.name}`, JSON.stringify(this.values));
                }
            }
        }
    }
</script>
