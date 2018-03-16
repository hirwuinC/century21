$(document).ready(function(){
	$("#login-form").validate({
			onfocusout: false,
			rules: {
				usuario: {
					required:true
				},
				password:{
					required:true
	      }
			},
		messages: {
			usuario:{
				required:"Debe indicar un nombre de usuario"
			},
			password:{
				required:"Debe indicar una contraseña de acceso"
			}
		},
		submitHandler: function(forma) {
			var form=$("#login-form").serialize();
			url="/admin/ingresar";
      $.post(url,form)
      .done(function(response) {
					console.log(response);
					if (response[0]==1) {
						swal({
							title:'Bienvenido',
						  text:response[1],
							icon:'success',
							timer: 1500,
							button:false,
						});
						setTimeout(function(){location.href = "/admin";},2200); // 3000ms = 3
        	}
					else {
						swal({
							title:'Error de Credenciales',
						  text:'Las credenciales son incorrectas',
							icon:'warning',
							//timer: 1500,
							button:true,
						});
					}
      });
		}
	});
});
