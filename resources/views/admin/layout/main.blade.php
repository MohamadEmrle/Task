<!DOCTYPE html>
<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="{{ asset('images/logo.png') }}" data-template="vertical-menu-template-free">
@include('admin.layout.style')
@yield('style')
<body>
    <div class="wrapper">
        <div class="main-sidebar sidebar-dark-primary elevation-4">
            @include('admin.layout.sidebar')
        </div>
        <div class="main-header navbar navbar-expand navbar-white navbar-light">
            @include('admin.layout.navbar')
        </div>
        <div class="content-wrapper">
            @yield('content')
        </div>
        <div class="main-footer">
            @include('admin.layout.footer')
        </div>
    </div>
    @include('admin.layout.script')
    @yield('scripts')
</body>
