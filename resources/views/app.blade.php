<!doctype html>
<html lang="en">
<!--begin::Head-->
@include('partials.head')
<!--end::Head-->
<!--begin::Body-->
<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
@yield('modal')
<!--begin::App Wrapper-->
<div class="app-wrapper">
    <!--begin::Header-->
    @include('partials.header')
    <!--end::Header-->
    <!--begin::Sidebar-->
    @include('partials.sidebar')
    <!--end::Sidebar-->
    <!--begin::App Main-->
    @include('partials.content-body')
    <!--end::App Main-->
    <!--begin::Footer-->
    @include('partials.footer-credit')
    <!--end::Footer-->
</div>
<!--end::App Wrapper-->
<!--begin::Script-->
<!--begin::Third Party Plugin(OverlayScrollbars)-->
@include('partials.scripts')
<!--end::OverlayScrollbars Configure-->
<!--end::Script-->
@include('sweetalert2::index')
</body>
<!--end::Body-->
</html>
