<div class="row">
    <div class="col-sm-6"><h3 class="mb-0">@yield('item-title')</h3></div>
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-end">
            @yield('item-path')
            <li class="breadcrumb-item active" aria-current="page">@yield('item-title')</li>
        </ol>
    </div>
</div>
