<!DOCTYPE html>
<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="{{ asset('images/logo.png') }}" data-template="vertical-menu-template-free">
    @include('site.layout.style')
    @yield('style')
    <div class="navbar navbar-fixed-top">
        @include('site.layout.navbar')
    </div>
    <div id="owl-demo" class="owl-carousel owl-theme">
        @yield('site_content')
    </div>
    <div class="main-content">
        <div class="container">
            <br><br><br><br>
            @yield('site')
        </div>
    </div>

    @include('site.layout.script')
    @yield('scripts')
</body>
</html>
