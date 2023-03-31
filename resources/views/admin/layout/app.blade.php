<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>
        Aladdin
    </title>
    @include('admin.layout.head')
    @stack('css')
   
</head>
<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        @include('admin.layout.header')
        @include('admin.layout.sidebar')
        <div class="content-wrapper">
            @yield('content')
        </div>
    </div>
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
    </aside>
    @include('admin.layout.script')
    @stack('scripts')
</body>
</html>