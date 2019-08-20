<!DOCTYPE html>
<html>
<?php
    $setting = App\Setting::first();
?>
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>LOGIN - {{ config('app.name') }}</title>
    <!-- Favicon-->
    <link id="favicon" rel="icon" href="{{ asset('uploads/images/fav_'.$setting->logo) }}" type="image/x-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
    <!-- <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css"> -->

    <!-- Meterial Icons Font Css -->
    <link href="{{ asset('ext/materialicon/material-icons.css') }}" rel="stylesheet" />

    <!-- Bootstrap Core Css -->
    <link href="{{ asset('template/adminbsb/plugins/bootstrap/css/bootstrap.css') }}" rel="stylesheet">

    <!-- Waves Effect Css -->
    <link href="{{ asset('template/adminbsb/plugins/node-waves/waves.css') }}" rel="stylesheet" />

    <!-- Animation Css -->
    <link href="{{ asset('template/adminbsb/plugins/animate-css/animate.css') }}" rel="stylesheet" />

    <!-- Custom Css -->
    <link href="{{ asset('template/adminbsb/css/style.css') }}" rel="stylesheet">
</head>

<body class="login-page">
    @yield('content')
    <!-- Jquery Core Js -->
    <script src="{{ asset('template/adminbsb/plugins/jquery/jquery.min.js') }}"></script>

    <!-- Bootstrap Core Js -->
    <script src="{{ asset('template/adminbsb/plugins/bootstrap/js/bootstrap.js') }}"></script>

    <!-- Waves Effect Plugin Js -->
    <script src="{{ asset('template/adminbsb/plugins/node-waves/waves.js') }}"></script>

    <!-- Validation Plugin Js -->
    <script src="{{ asset('template/adminbsb/plugins/jquery-validation/jquery.validate.js') }}"></script>

    <!-- Custom Js -->
    <script src="{{ asset('template/adminbsb/js/admin.js') }}"></script>
    <script src="{{ asset('template/adminbsb/js/pages/examples/sign-in.js') }}"></script>
</body>

</html>