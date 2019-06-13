<!DOCTYPE html>
<html lang="en">
<head>
    @include('back.partials._head')
</head>

<body class="nav-md">
<div class="container body">
    <div class="main_container">
        <!-- Side Bar -->
    @include('back.partials._side-nav')
    <!-- /Side Bar -->

        <!-- top navigation -->
    @include('back.partials._top-nav')
    <!-- /top navigation -->

        <!-- page content -->
        <div class="right_col" role="main">
            <div class="">
                @yield('page_title')
                <div class="clearfix"></div>

                <div class="row">
                    @component('back.components.message')@endcomponent
                    @yield('contain')
                </div>
            </div>
        </div>
        <!-- /page content -->

        <!-- footer content -->
        <footer>
            <div class="pull-right">
                Gentelella - Bootstrap Admin Template by <a href="https://colorlib.com">Colorlib</a>
            </div>
            <div class="clearfix"></div>
        </footer>
        <!-- /footer content -->
    </div>
</div>

@include('back.partials._script')
</body>
</html>
