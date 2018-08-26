<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Ultimate Design - @yield('title') </title>

   
    <link rel="stylesheet" href="{!! asset('css/app.css') !!}" />
  
    
</head>
<body class="md-skin fixed-nav no-skin-config">

  <!-- Wrapper-->
    <div id="wrapper">

        <!-- Navigation -->
        @include('layouts.navigation')

        <!-- Page wraper -->
        <div id="page-wrapper" class="gray-bg">

            <!-- Page wrapper -->
            @include('layouts.topnavbar')

            <!-- Main view  -->
            <div id="app">

            @yield('content')
            
            </div>
            <!-- Footer -->
            @include('layouts.footer')

        </div>
        <!-- End page wrapper-->

    </div>
    <!-- End wrapper-->

    <script src="{!! asset('js/app.js') !!}" type="text/javascript"></script>

@yield('jss')
@section('scripts')
@show

</body>
</html>
