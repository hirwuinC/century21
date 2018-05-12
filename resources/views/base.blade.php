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

		<!-- CSS -->
		<link href="{{ asset('css/bootstrap.css') }}" rel="stylesheet" type="text/css">
		<link href="{{ asset('css/animations.css') }}" rel="stylesheet" type="text/css">
		<link href="{{ asset('css/font-face.css') }}" rel="stylesheet" type="text/css">
		<link href="{{ asset('css/responsive.css') }}" rel="stylesheet" type="text/css">
		<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.4/css/select2.min.css" rel="stylesheet" />
		<link href="{{ asset('css/custome.css') }}" rel="stylesheet" type="text/css">
		<link href="{{ asset('css/main.css') }}" rel="stylesheet" type="text/css">


	</head>
	<body>
		<header>
			<div class="container">
				<div class="row">
					<div class="col-xs-12">
						<div class="row">
							<div class="col-xs-12 col-sm-2 logoHeader">
								<img src="{{ asset('images/logo-header.png')}}" alt="">
							</div>
							<div class="col-xs-12 col-sm-10">
								<div class="infoContact">
									<div class="row">
										<div class="col-xs-12 col-sm-3">
											<p><a href="mailto:info@century21caracas.com"><span><i class="fa fa-envelope" aria-hidden="true"></i></span> info@century21caracas.com</a></p>
										</div>
										<div class="col-xs-12 col-sm-3">
											<ul>
												<li><a href="https://www.facebook.com/c21inmueblescaracas/" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
												<li><a href="https://twitter.com/inmccsc21" target="_blank"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
												<li><a href="https://www.instagram.com/c21inmueblescaracas/" target="_blank"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
											</ul>
										</div>
										<div class="col-xs-12 col-sm-4">
											<p><span><i class="fa fa-phone" aria-hidden="true"></i></span>  0212-9853222 / 0424-2717436 </p>
										</div>
										<div class="col-xs-12 col-sm-2">
											<p class="accesslogin"><a href="{{route('login')}}"><i class="fa fa-user-circle-o" aria-hidden="true"></i></a></p>
										</div>
									</div>
								</div>
								<div class="col-sm-12" id="nav">
									<div class="row">
										<div class="navbar-header">
											<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#nav-collapse" aria-expanded="false">
												<span class="sr-only">Toggle navigation</span>
												<span class="icon-bar"></span>
												<span class="icon-bar"></span>
												<span class="icon-bar"></span>
											</button>
										</div>
										<div class="navbar-collapse collapse" id="nav-collapse" aria-expanded="false">
											<ul>
												<li><a href="{{ route('home') }}/" data-id="1">inicio</a></li>
												<li><a href="{{ route('nuestra_historia') }}" data-id="2">nuestra historia</a></li>
												<li><a href="{{ route('proyectos') }}" data-id="3">proyectos</a></li>
												<li><a href="">blog</a></li>
												<li><a href="{{ route('contacto') }}" data-id="4">contacto</a></li>
											</ul>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</header>
		<div id="slider">
			<div class="content-fluid">
				<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
					<!-- Indicators -->
					<ol class="carousel-indicators">
						<li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
						<li data-target="#carousel-example-generic" data-slide-to="1"></li>
						<li data-target="#carousel-example-generic" data-slide-to="2"></li>
					</ol>

					<!-- Wrapper for slides -->
					<div class="carousel-inner" role="listbox">
						<div class="item active">
							<img src="{{ asset('images/slide1.jpg')}}" alt="...">
						</div>
						<div class="item">
							<img src="{{ asset('images/slide2.png')}}" alt="...">
						</div>
						<div class="item">
							<img src="{{ asset('images/slide1.jpg')}}" alt="...">
						</div>
					</div>

					<!-- Controls -->
					<a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
						<span class="fa fa-angle-left" aria-hidden="true"></span>
					</a>
					<a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
						<span class="fa fa-angle-right" aria-hidden="true"></span>
					</a>
				</div>
			</div>
		</div>

		<!-- GO GENERAL WRAPPER -->
		<div class="wrapper">
            @yield('content')
		</div>
		<!-- END GENERAL WRAPPER -->
		<div class="load" id="load">
        <hr/><hr/><hr/><hr/>
    </div>
		<!-- FOOTER -->
		<footer>
			<div id="footer">
				<div class="container">
					<div class="row">
						<div class="col-xs-12 col-sm-4 logoFooter">
								<img src="{{ asset('images/logo-footer.png')}}" alt="">
							</div>
						<div class="col-xs-12 col-sm-4 contactFooter">
								<h6 class="titleSectionFooter">Contáctanos</h6>
								<p><span><i class="fa fa-phone" aria-hidden="true"></i></span>  0212-9853222 / 0424-2717436 </p>
								<p><a href="mailto:info@century21caracas.com"><span><i class="fa fa-envelope" aria-hidden="true"></i></span> info@century21caracas.com</a></p>
							</div>
						<div class="col-xs-12 col-sm-4 socialFooter">
								<h6 class="titleSectionFooter">Síguenos</h6>
								<ul>
									<li><a href="https://www.facebook.com/c21inmueblescaracas/" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
									<li><a href="https://twitter.com/inmccsc21" target="_blank"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
									<li><a href="https://www.instagram.com/c21inmueblescaracas/" target="_blank"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
								</ul>
							</div>
					</div>
				</div>
			</div>
			<div class="copyright">
				<div class="container">
					<div class="row">
						<div class="col-sm-12 col-md-5">
							<p>CENTURY 21 © 2017 Todos los derechos reservados</p>
						</div>
						<div class="hidden-xs hidden-sm col-md-7">
							<ul>
								<li><a href="{{ route('home') }}" class="active">inicio</a></li>
								<li><a href="{{ route('nuestra_historia') }}">nuestra historia</a></li>
								<li><a href="{{ route('proyectos') }}">proyectos</a></li>
								<li><a href="">blog</a></li>
								<li><a href="{{ route('contacto') }}">contacto</a></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</footer>
		<!--JAVASCRIPTS / JQUERY-->

		<script type="text/javascript" src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>
		<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/jquery-validation@1.17.0/dist/jquery.validate.js"></script>
		<script type="text/javascript" src="{{ asset('js/bootstrap.min.js') }}"></script>
		<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
		<script type="text/javascript" src="{{ asset('js/waterwheelCarousel.js') }}"></script>
		<script type="text/javascript" src="{{ asset('js/search.js') }}"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.4/js/select2.min.js"></script>
		<script src="https://unpkg.com/scrollreveal/dist/scrollreveal.min.js"></script>
		<script type="text/javascript">
			var baseUrl = "{{ route('home') }}"
		</script>
		<script type="text/javascript" src="{{ asset('js/custome.js') }}"></script>

		@yield('js')
	</body>
</html>
