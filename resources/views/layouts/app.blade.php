@php
    $controller = \App\Helpers\PanelHelper::controller();
    $action = \App\Helpers\PanelHelper::action();
    $pageKey = $controller . '_' . $action;

    // Fetch system and page assets
    $systemAssets = config('panel.system');
    $pageAssets = config('panel.page.' . $pageKey);
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Bunker Plate') }} - {{ $page_title ?? '' }}</title>
    <!-- System CSS -->
    @if (!empty($systemAssets['css']))
        @foreach ($systemAssets['css'] as $css)
            <link rel="stylesheet" href="{{ asset($css) }}">
        @endforeach
    @endif

    <!-- Page-Specific CSS -->
    @if (!empty($pageAssets['css']))
        @foreach ($pageAssets['css'] as $css)
            <link rel="stylesheet" href="{{ asset($css) }}">
        @endforeach
    @endif
</head>

<body>
    <div id="app" class="container-fluid">
        <!-- Navbar -->
        @auth
            @include('layouts._adminnavbar')
        @else
            @include('layouts._guestnavbar')
        @endauth

        <!-- Session message -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Dynmaic block -->
        @yield('content')
        @include('layouts._footer')
    </div>

    <!-- System JS -->
    @if (!empty($systemAssets['js']))
        @foreach ($systemAssets['js'] as $js)
            <script src="{{ asset($js) }}"></script>
        @endforeach
    @endif

    <!-- Page-Specific JS -->
    @if (!empty($pageAssets['js']))
        @foreach ($pageAssets['js'] as $js)
            <script src="{{ asset($js) }}"></script>
        @endforeach
    @endif
</body>

</html>
