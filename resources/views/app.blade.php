<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <title>{{env('APP_NAME')}}</title>
    <link href="{{ mix('css/app.css') }}" type="text/css" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
</head>
<body>

{{--@if (Auth::check())--}}
{{--    @php--}}
{{--        $isLoggedIn = true;--}}
{{--    @endphp--}}
{{--@elseif (auth('sanctum')->user())--}}
{{--    @php--}}
{{--        $isLoggedIn = true;--}}
{{--    @endphp--}}
{{--@else--}}
{{--    @php--}}
{{--        $isLoggedIn = false;--}}
{{--    @endphp--}}
{{--@endif--}}

{{--<script>--}}
{{--    window.Laravel = {!! json_encode([--}}
{{--        'isLoggedin' => $isLoggedIn,--}}
{{--    ]) !!};--}}
{{--</script>--}}
<div id="app">
</div>
<script src="{{ mix('js/app.js') }}" type="text/javascript"></script>
</body>
</html>
