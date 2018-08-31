<!DOCTYPE html>
<html>
<?php
    $setting = App\Setting::first();
?>
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>403 | SKELETON - ADMINBSB</title>
    <!-- Favicon-->
    <link rel="icon" href="{{ asset('template/adminbsb/favicon.ico') }}" type="image/x-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">

    <!-- Bootstrap Core Css -->
    <link href="{{ asset('template/adminbsb/plugins/bootstrap/css/bootstrap.css') }}" rel="stylesheet">

    <!-- Waves Effect Css -->
    <link href="{{ asset('template/adminbsb/plugins/node-waves/waves.css') }}" rel="stylesheet" />

    <!-- Custom Css -->
    <link href="{{ asset('template/adminbsb/css/style.css') }}" rel="stylesheet">
</head>

<body class="four-zero-four" style="background-image: url('{{ asset('uploads/images/'.$setting->bg) }}'); background-repeat: no-repeat; background-size: cover;">
    <div style="position: absolute; top: 0; width: 100%; height: 100vh; opacity: 0.3; background-color: black;">
    </div>
    <div class="four-zero-four-container" style="position: relative;">
        <div class="error-code col-white">403</div>
        <div class="error-message col-orange">Kamu dilarang kesini!!</div>
        <div class="button-place">
            <a href="{{ url('/home') }}" class="btn btn-danger btn-lg waves-effect">PULANG!!</a>
        </div>
    </div>

    <!-- Jquery Core Js -->
    <script src="{{ asset('template/adminbsb/plugins/jquery/jquery.min.js') }}"></script>

    <!-- Bootstrap Core Js -->
    <script src="{{ asset('template/adminbsb/plugins/bootstrap/js/bootstrap.js') }}"></script>

    <!-- Waves Effect Plugin Js -->
    <script src="{{ asset('template/adminbsb/plugins/node-waves/waves.js') }}"></script>
</body>

</html>