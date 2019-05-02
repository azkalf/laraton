<!DOCTYPE html>
<html>
<?php
    $setting = App\Setting::first();
    $user = Auth::User();
    $photo = !empty($user->photo) ? 'fit_'.$user->photo : ($user->gender == 'm' ? 'ikhwan.png' : 'akhwat.png');
    $poster = !empty($user->poster) ? 'fit_'.$user->poster : 'fit_'.$setting->poster;
    $menus = App\Menu::getRoledMenus();
    $skin = !empty($user->skin) ? $user->skin : $setting->skin;
    $theme = 'theme-'.$skin;
?>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>@yield('title') - {{ $setting->appname }}</title>
    <!-- Favicon-->
    <link id="favicon" rel="icon" href="{{ asset('uploads/images/fav_'.$setting->logo) }}" type="image/x-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
    <!-- <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css"> -->

    <!-- Fontawesome 5 Css -->
    <link href="{{ asset('ext/fontawesome5/css/fontawesome-all.css') }}" rel="stylesheet" />

    <!-- Meterial Icons Font Css -->
    <link href="{{ asset('ext/materialicon/material-icons.css') }}" rel="stylesheet" />

    <!-- Socicon Css -->
    <link href="{{ asset('ext/socicon/style.css') }}" rel="stylesheet" />

    <!-- Bootstrap Core Css -->
    <link href="{{ asset('template/adminbsb/plugins/bootstrap/css/bootstrap.css') }}" rel="stylesheet" />

    <!-- Waves Effect Css -->
    <link href="{{ asset('template/adminbsb/plugins/node-waves/waves.css') }}" rel="stylesheet" />

    <!-- Animation Css -->
    <link href="{{ asset('template/adminbsb/plugins/animate-css/animate.css') }}" rel="stylesheet" />

    <!-- Morris Chart Css-->
    <link href="{{ asset('template/adminbsb/plugins/morrisjs/morris.css') }}" rel="stylesheet" />

    <!-- Sweetalert Css -->
    <link href="{{ asset('template/adminbsb/plugins/sweetalert/sweetalert.css') }}" rel="stylesheet" />

    <!-- Custom Css -->
    <link href="{{ asset('template/adminbsb/css/style.css') }}" rel="stylesheet" />

    <!-- AdminBSB Themes. You can choose a theme from css/themes instead of get all themes -->
    <link href="{{ asset('template/adminbsb/css/themes/all-themes.css') }}" rel="stylesheet" />

    <!-- Animation Css -->
    <link href="{{ asset('template/adminbsb/plugins/animate-css/animate.css') }}" rel="stylesheet" />

    <!-- Style from page -->
    @stack('style')
</head>
<body class="{{ $theme }}">
    <!-- Page Loader -->
    <div class="page-loader-wrapper">
        <div class="loader">
            <div class="preloader">
                <div class="spinner-layer pl-green">
                    <div class="circle-clipper left">
                        <div class="circle"></div>
                    </div>
                    <div class="circle-clipper right">
                        <div class="circle"></div>
                    </div>
                </div>
            </div>
            <p>Antosan...</p>
        </div>
    </div>
    <!-- #END# Page Loader -->
    <!-- Overlay For Sidebars -->
    <div class="overlay"></div>
    <!-- #END# Overlay For Sidebars -->
    <!-- Search Bar -->
    <div class="search-bar">
        <div class="search-icon">
            <i class="material-icons">search</i>
        </div>
        <input type="text" placeholder="Pilari...">
        <div class="close-search">
            <i class="material-icons">close</i>
        </div>
    </div>
    <!-- #END# Search Bar -->
    <!-- Top Bar -->
    <nav class="navbar">
        <div class="container-fluid">
            <div class="navbar-header">
                <a href="javascript:void(0);" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false"></a>
                <a href="javascript:void(0);" class="bars"></a>
                <a class="navbar-brand" href="{{asset('/home')}}" style="padding-top: 5px;"><img id="logo" src="{{ asset('uploads/images/fit_'.$setting->logo) }}" align="left" style="height: 40px; margin-right: 5px;"><span id="appname" class="hidden-xs hidden-sm"> {{ $setting->appname }}<br><small>{!! $setting->subname !!}</small></span></a>
            </div>
            <div class="collapse navbar-collapse" id="navbar-collapse">
                <ul class="nav navbar-nav navbar-right">
                    <!-- Call Search -->
                    <li><a href="javascript:void(0);" class="js-search" data-close="true"><i class="material-icons">search</i></a></li>
                    <!-- #END# Call Search -->
                    <li class="pull-right"><a href="javascript:void(0);" class="js-right-sidebar" data-close="true"><i class="material-icons">more_vert</i></a></li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- #Top Bar -->
    <section>
        <!-- Left Sidebar -->
        <aside id="leftsidebar" class="sidebar">
            <!-- User Info -->
            <div class="user-info" id="fit_poster_image" style="background: url('{{ asset('uploads/images/posters/'.$poster) }}') no-repeat no-repeat; background-size: cover;">
                <div class="image">
                    <img src="{{ asset('uploads/images/users/'.$photo) }}" width="48" height="48" alt="User" id="fit_profile_photo" />
                </div>
                <div class="info-container">
                    <div class="name" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{ $user->fullname }}</div>
                    <div class="email">{{ $user->email }}</div>
                    <div class="btn-group user-helper-dropdown">
                        <i class="material-icons" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">keyboard_arrow_down</i>
                        <ul class="dropdown-menu pull-right">
                            <li><a href="{{ url('/profile') }}"><i class="material-icons">person</i>Profile</a></li>
                            <li role="seperator" class="divider"></li>
                            <li>
                                <a href="{{ route('logout') }}" onclick="event.preventDefault(); 
                                    document.getElementById('logout-form').submit();"><i class="material-icons">input</i>Sign Out
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- #User Info -->
            <!-- Menu -->
            <div class="menu">
                <ul class="list">
                    <li class="header">MAIN NAVIGATION</li>
                    <li<?= request()->is('home') ? ' class="active"' : ''; ?>>
                        <a href="{{ url('home') }}">
                            <i class="material-icons">home</i>
                            <span>Home</span>
                        </a>
                    </li>
                    @if($user->group_id == 1)
                    <li>
                        <a href="{{ url('template/adminbsb/index.html') }}" target="_blank">
                            <i class="material-icons">extension</i>
                            <span>Template</span>
                        </a>
                    </li>
                    @endif
                    <?php
                    foreach ($menus as $menu) {
                        $toggled = child_active($menu) ? ' toggled' : '';
                        $treeview = (isset($menu['items']) && count($menu['items'])) ? ' class="menu-toggle'.$toggled.'"' : '';
                        $url = (isset($menu['items']) && count($menu['items'])) ? '#' : $menu['url'];
                        $active = (request()->is($menu['url']) || request()->is($menu['url'].'/*')) ? ' class="active"' : '';
                        echo '<li'.$active.'><a href="'.$url.'"'.$treeview.'><i class="material-icons">'.$menu['icon'].'</i><span>'.$menu['title'].'</span></a>';
                        print_menu($menu);
                        echo '</li>';
                    }
                    ?>
                </ul>
            </div>
            <!-- #Menu -->
            <!-- Footer -->
            <div class="legal">
                <div class="copyright">
                    {!! $setting->copyright !!}
                </div>
                <div class="version">
                    {!! $setting->version !!}
                </div>
            </div>
            <!-- #Footer -->
        </aside>
        <!-- #END# Left Sidebar -->
        <!-- Right Sidebar -->
        <aside id="rightsidebar" class="right-sidebar">
            <ul class="nav nav-tabs tab-nav-right" role="tablist">
                <li role="presentation" class="active" style="width: 100% !important;"><a href="#skins" data-toggle="tab">SKINS</a></li>
                <!-- <li role="presentation"><a href="#settings" data-toggle="tab">SETTINGS</a></li> -->
            </ul>
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane fade in active in active" id="skins">
                    <ul class="demo-choose-skin">
                        <li data-theme="red">
                            <div class="red"></div>
                            <span>Red</span>
                        </li>
                        <li data-theme="pink">
                            <div class="pink"></div>
                            <span>Pink</span>
                        </li>
                        <li data-theme="purple">
                            <div class="purple"></div>
                            <span>Purple</span>
                        </li>
                        <li data-theme="deep-purple">
                            <div class="deep-purple"></div>
                            <span>Deep Purple</span>
                        </li>
                        <li data-theme="indigo">
                            <div class="indigo"></div>
                            <span>Indigo</span>
                        </li>
                        <li data-theme="blue">
                            <div class="blue"></div>
                            <span>Blue</span>
                        </li>
                        <li data-theme="light-blue">
                            <div class="light-blue"></div>
                            <span>Light Blue</span>
                        </li>
                        <li data-theme="cyan">
                            <div class="cyan"></div>
                            <span>Cyan</span>
                        </li>
                        <li data-theme="teal">
                            <div class="teal"></div>
                            <span>Teal</span>
                        </li>
                        <li data-theme="green">
                            <div class="green"></div>
                            <span>Green</span>
                        </li>
                        <li data-theme="light-green">
                            <div class="light-green"></div>
                            <span>Light Green</span>
                        </li>
                        <li data-theme="lime">
                            <div class="lime"></div>
                            <span>Lime</span>
                        </li>
                        <li data-theme="yellow">
                            <div class="yellow"></div>
                            <span>Yellow</span>
                        </li>
                        <li data-theme="amber">
                            <div class="amber"></div>
                            <span>Amber</span>
                        </li>
                        <li data-theme="orange">
                            <div class="orange"></div>
                            <span>Orange</span>
                        </li>
                        <li data-theme="deep-orange">
                            <div class="deep-orange"></div>
                            <span>Deep Orange</span>
                        </li>
                        <li data-theme="brown">
                            <div class="brown"></div>
                            <span>Brown</span>
                        </li>
                        <li data-theme="grey">
                            <div class="grey"></div>
                            <span>Grey</span>
                        </li>
                        <li data-theme="blue-grey">
                            <div class="blue-grey"></div>
                            <span>Blue Grey</span>
                        </li>
                        <li data-theme="black">
                            <div class="black"></div>
                            <span>Black</span>
                        </li>
                    </ul>
                </div>
                <div role="tabpanel" class="tab-pane fade" id="settings">
                    <div class="demo-settings">
                        <p>GENERAL SETTINGS</p>
                        <ul class="setting-list">
                            <li>
                                <span>Report Panel Usage</span>
                                <div class="switch">
                                    <label><input type="checkbox" checked><span class="lever"></span></label>
                                </div>
                            </li>
                            <li>
                                <span>Email Redirect</span>
                                <div class="switch">
                                    <label><input type="checkbox"><span class="lever"></span></label>
                                </div>
                            </li>
                        </ul>
                        <p>SYSTEM SETTINGS</p>
                        <ul class="setting-list">
                            <li>
                                <span>Notifications</span>
                                <div class="switch">
                                    <label><input type="checkbox" checked><span class="lever"></span></label>
                                </div>
                            </li>
                            <li>
                                <span>Auto Updates</span>
                                <div class="switch">
                                    <label><input type="checkbox" checked><span class="lever"></span></label>
                                </div>
                            </li>
                        </ul>
                        <p>ACCOUNT SETTINGS</p>
                        <ul class="setting-list">
                            <li>
                                <span>Offline</span>
                                <div class="switch">
                                    <label><input type="checkbox"><span class="lever"></span></label>
                                </div>
                            </li>
                            <li>
                                <span>Location Permission</span>
                                <div class="switch">
                                    <label><input type="checkbox" checked><span class="lever"></span></label>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </aside>
        <!-- #END# Right Sidebar -->
    </section>

    <section class="content">
        <!-- <div class="container-fluid"> -->
            <div class="block-header">
                <h2>@yield('title')</h2>
            </div>

            @yield('content')
        <!-- </div> -->
    </section>

    <!-- Jquery Core Js -->
    <script src="{{ asset('template/adminbsb/plugins/jquery/jquery.min.js') }}"></script>

    <!-- Bootstrap Core Js -->
    <script src="{{ asset('template/adminbsb/plugins/bootstrap/js/bootstrap.js') }}"></script>

    <!-- Select Plugin Js -->
    <script src="{{ asset('template/adminbsb/plugins/bootstrap-select/js/bootstrap-select.js') }}"></script>

    <!-- Slimscroll Plugin Js -->
    <script src="{{ asset('template/adminbsb/plugins/jquery-slimscroll/jquery.slimscroll.js') }}"></script>

    <!-- Waves Effect Plugin Js -->
    <script src="{{ asset('template/adminbsb/plugins/node-waves/waves.js') }}"></script>

    <!-- Jquery CountTo Plugin Js -->
    <script src="{{ asset('template/adminbsb/plugins/jquery-countto/jquery.countTo.js') }}"></script>

    <!-- Morris Plugin Js -->
    <script src="{{ asset('template/adminbsb/plugins/raphael/raphael.min.js') }}"></script>
    <script src="{{ asset('template/adminbsb/plugins/morrisjs/morris.js') }}"></script>

    <!-- ChartJs -->
    <script src="{{ asset('template/adminbsb/plugins/chartjs/Chart.bundle.js') }}"></script>

    <!-- Flot Charts Plugin Js -->
    <script src="{{ asset('template/adminbsb/plugins/flot-charts/jquery.flot.js') }}"></script>
    <script src="{{ asset('template/adminbsb/plugins/flot-charts/jquery.flot.resize.js') }}"></script>
    <script src="{{ asset('template/adminbsb/plugins/flot-charts/jquery.flot.pie.js') }}"></script>
    <script src="{{ asset('template/adminbsb/plugins/flot-charts/jquery.flot.categories.js') }}"></script>
    <script src="{{ asset('template/adminbsb/plugins/flot-charts/jquery.flot.time.js') }}"></script>

    <!-- Sparkline Chart Plugin Js -->
    <script src="{{ asset('template/adminbsb/plugins/jquery-sparkline/jquery.sparkline.js') }}"></script>

    <!-- Bootstrap Notify Plugin Js -->
    <script src="{{ asset('template/adminbsb/plugins/bootstrap-notify/bootstrap-notify.js') }}"></script>

    <!-- SweetAlert Plugin Js -->
    <script src="{{ asset('template/adminbsb/plugins/sweetalert/sweetalert.min.js') }}"></script>

    <!-- Custom Js -->
    <script src="{{ asset('template/adminbsb/js/admin.js') }}"></script>

    <!-- Demo Js -->
    <script src="{{ asset('template/adminbsb/js/demo.js') }}"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            $('.right-sidebar .demo-choose-skin').find('[data-theme="{{ $skin }}"]').addClass('active');
        })
        var changeSkin = function(skin) {
            $.ajax({
                type: "POST",
                data: {_token: '{{ csrf_token() }}', skin:skin},
                url: "{{ url('/change_skin') }}",
                success: function(data) {
                    showAlert(data, 'bg-green');
                },
                error: function(data) {
                    showAlert('Error: ' + data, 'bg-red');
                }
            })
        }
        var showAlert = function(text, color) {
            $.notify({
                message: text
            },
            {
                type: color,
                allow_dismiss: true,
                newest_on_top: true,
                timer: 1000,
                placement: {
                    from: 'top',
                    align: 'right'
                },
                animate: {
                    enter: 'animated lightSpeedIn',
                    exit: 'animated lightSpeedOut'
                },
                template: '<div data-notify="container" class="bootstrap-notify-container alert alert-dismissible {0} p-r-35 role="alert">' +
                '<button type="button" aria-hidden="true" class="close" data-notify="dismiss">×</button>' +
                '<span data-notify="icon"></span> ' +
                '<span data-notify="title">{1}</span> ' +
                '<span data-notify="message">{2}</span>' +
                '<div class="progress" data-notify="progressbar">' +
                '<div class="progress-bar progress-bar-{0}" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>' +
                '</div>' +
                '<a href="{3}" target="{4}" data-notify="url"></a>' +
                '</div>'
            });
        }
        function isEmail(email) {
            var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
            return regex.test(email);
        }
    </script>

    <!-- Script from page -->
    @stack('script')
</body>

</html>