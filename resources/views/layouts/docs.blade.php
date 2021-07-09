<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Invoke Docs</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/vue-json-pretty@1.8.0/lib/styles.min.css">

    <style>
        .scrollarea {
            overflow-y: auto;
        }
    </style>
</head>
<body>
@yield('body')

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/vue@2/dist/vue.js"></script>
<script src="https://cdn.jsdelivr.net/npm/vue-json-pretty@1.8.0/lib/vue-json-pretty.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/v-tooltip@2.1.3/dist/v-tooltip.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/vue-tippy@4/dist/vue-tippy.min.js"></script>
<link
    rel="stylesheet"
    href="https://unpkg.com/tippy.js@4/themes/light.css"
/>

<script>
    let popoverList = [];

    function refreshPopovers() {
        popoverList.forEach(popover => {
            popover.disable();
            popover.dispose();
        });

        const popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));

        popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
            return new bootstrap.Popover(popoverTriggerEl)
        });
    }
</script>

@yield('scripts')
</body>
</html>
