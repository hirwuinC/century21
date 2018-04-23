<!DOCTYPE html>
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<head>
    <meta charset="utf-8">
    <title>Century 21 Venezuela</title>
    <meta name="description" content="century21">
    <meta name="author" content="rjps.designer@gmail.com">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}" />

    <link href="{{ asset('css/admin/bootstrap.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/easy-autocomplete.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/easy-autocomplete.themes.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/font-face.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/admin/main.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/admin/custome.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/custome.css') }}"" rel="stylesheet" type="text/css">

</head>
<body>
<!-- HEADER -->
<header>
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <div class="row">
                    <div class="col-xs-12 logoHeader">
                        <img src="{{ asset('images/logo-footer.png')}}" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

<!-- GO GENERAL WRAPPER -->
<div class="wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xs-3 affix-sidebar">
                @include('admin/common/sidebar')
            </div>
            <div class="col-xs-9 affix-content">
                @yield('content')
            </div>
        </div>
    </div>
    <div class="load" id="load">
        <hr/><hr/><hr/><hr/>
    </div>
</div>
<!-- END GENERAL WRAPPER -->

<!--JAVASCRIPTS / JQUERY-->
<script type="text/javascript" src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/jquery-validation@1.17.0/dist/jquery.validate.js"></script>
<script type="text/javascript" src="{{ asset('js/bootstrap.min.js') }}"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script type="text/javascript" src="{{ asset('js/easy-autocomplete.min.js') }}"></script>
<script src="https://unpkg.com/scrollreveal/dist/scrollreveal.min.js"></script>
<script>
    var base_url = "{{ route('admin_lista_inmuebles') }}"
</script>
<script type="text/javascript" src="{{ asset('js/admin/general.js') }}"></script>

@yield('js')



</body>
</html>
