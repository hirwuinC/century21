$(document).ready(function(){
	$("#login-form").validate({
			onfocusout: true,
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
      alert(form);
			url="/admin/ingresar";
      $.ajax({
        data:form,
        url:   url,
        type:  'post',
        success:  function (response) {
          alert(response);
        }
      });
		}
	});
});
