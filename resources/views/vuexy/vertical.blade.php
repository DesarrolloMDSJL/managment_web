<body class="vertical-layout vertical-menu-modern 2-columns semi-dark-layout menu-expanded content-right footer-static"
    data-menu="vertical-menu-modern" data-col="2-columns" data-layout="semi-dark-layout">
    @include('vuexy.sidebar')

    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>

        @include('vuexy.navbar')

        <div class="content-wrapper" id="main">
            @include('vuexy.breadcrumb')
            <div class="content-body">
                @yield('content')
            </div>
        </div>
    </div>


    <div class="sidenav-overlay"></div>
    <div class="drag-target"></div>

    @include('vuexy.footer')

    @include('vuexy.scripts')
</body>
</html>