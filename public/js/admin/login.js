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
      $.ajax({
        data:form,
        url:   url,
        type:  'post',
        success:  function (response) {
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
						swal(
						  'Error de autenticación',
						  'Revise el usuario o la contraseña',
						  'error'
						);
					}
        }
      });
		}
	});
});
