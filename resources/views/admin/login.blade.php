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
		<link href="{{ asset('css/font-face.css') }}" rel="stylesheet" type="text/css">
		<link href="{{ asset('css/admin/main.css') }}" rel="stylesheet" type="text/css">

	</head>
	<body class="login">
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
			<div id="login">
				<h3>iniciar sesión</h3>
				<div class="container">
					<div class="row">
						<div class="col-xs-6 col-xs-offset-3">
							<form id="login-form" method="post">
								{{ csrf_field() }}
								<div class="form-group">
									<div class="iconInput">
										<i class="fa fa-user-circle-o" aria-hidden="true"></i>
									</div>
									<input type="text" class="inputs form-control" name="usuario" id="usuario" placeholder="Email">
								</div>
								<div class="form-group">
									<div class="iconInput">
										<i class="fa fa-lock" aria-hidden="true"></i>
									</div>
									<input type="password" class="inputs form-control" name="password" placeholder="Password">
								</div>
								<button type="submit" id="submitLogin" class="btnYellow">Submit</button>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- END GENERAL WRAPPER -->

		<!--JAVASCRIPTS / JQUERY-->

		<script type="text/javascript" src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>
		<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/jquery-validation@1.17.0/dist/jquery.validate.js"></script>
		<script type="text/javascript" src="{{ asset('js/bootstrap.min.js') }}"></script>
		<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script type="text/javascript" src="{{ asset('js/admin/login.js') }}"></script>

	</body>
</html>
