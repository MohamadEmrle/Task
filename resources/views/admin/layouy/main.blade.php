<!DOCTYPE html>
<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="{{ asset('images/logo.png') }}" data-template="vertical-menu-template-free">
@include('admin.layouy.style')
@yield('style')
<body>
    <div class="wrapper">
        <div class="main-sidebar sidebar-dark-primary elevation-4">
            @include('admin.layouy.sidebar')
        </div>
        <div class="main-header navbar navbar-expand navbar-white navbar-light">
            @include('admin.layouy.navbar')
        </div>
        <div class="content-wrapper">
            @yield('content')
        </div>
        <div class="main-footer">
            @include('admin.layouy.footer')
        </div>
    </div>
    @include('admin.layouy.script')
    @yield('scripts')
</body>
