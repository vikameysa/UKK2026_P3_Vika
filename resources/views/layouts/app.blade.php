<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Vika Meysa</title>

    <link rel="icon" href="{{ asset('assets/images/favicon.png') }}">

    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
</head>

<body>

<div id="main-wrapper">

    {{-- HEADER --}}
    @include('layouts.header')

    {{-- SIDEBAR --}}
  @auth
    @include('menu.navbar_' . strtolower(Auth::user()->role))
@endauth
    {{-- CONTENT --}}
    <div class="content-body">
        <div class="container-fluid">
            @yield('content')
        </div>
    </div>

</div>

{{-- JS WAJIB --}}
<script src="{{ asset('assets/plugins/common/common.min.js') }}"></script>
<script src="{{ asset('assets/js/custom.min.js') }}"></script>
<script src="{{ asset('assets/js/settings.js') }}"></script>
<script src="{{ asset('assets/js/gleek.js') }}"></script>
<script src="{{ asset('assets/js/styleSwitcher.js') }}"></script>

</body>
</html>
