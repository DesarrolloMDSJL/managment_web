<body class="vertical-layout vertical-menu-modern blank-page navbar-floating footer-static   menu-collapsed" data-open="click" data-menu="vertical-menu-modern" data-col="blank-page">  

    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>     

        <div class="content-wrapper" id="main">
            <div class="content-header row">
            </div>
            <div class="content-body">
                @yield('content')
            </div>
        </div>
    </div>  
    @include('vuexy.scripts')
</body>
</html>