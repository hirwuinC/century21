$(document).ready(function(){
	$("#perfilEdit").validate({
			onfocusout: false,
			rules: {
				pass:{
					required:true,
					minlength: 6
				},
				repeatPass:{
					required:true,
					equalTo:"#pass"
				},
				dateBirth:{
					required:true
				},
				addressUser:{
					required:true,
					minlength: 15
				}
			},
		messages: {
			pass:{
				required:"Debe indicar una contraseña de acceso",
				minlength: "La contraseña debe tener un minimo de 6 caracteres"
			},
			repeatPass:{
				required:"Repita la contraseña",
				equalTo:"Las contraseñas deben coincidir"
			},
			dateBirth:{
				required:"Debe indicar la fecha de nacimiento del asesor"
			},
			addressUser:{
				required:"Es necesario que indiques tu dirección",
				minlength:"La direccion debe contener un minimo de 15 caracteres"
			}
		},
		submitHandler: function(form) {
      var formulario = new FormData(document.getElementById('perfilEdit'));
			url="/admin/actualizarPerfil";
      $.ajax({
          url: url,
          type: "post",
          dataType: "html",
          data: formulario,
          cache: false,
          contentType: false,
          processData: false
      })
      .done(function(res){
				if (res==1) {
          swal(
            'Listo!!',
            'Tu usuario ha sido actualizado, los cambios seran aplicados una vez inicies sesión nuevamente',
            'success'
          );
        }
      });
    }
	});
	$('.file-input').change(function(){
    var curElement = $(this).parent().parent().parent().find('.image');
    var reader = new FileReader();

    reader.onload = function (e) {
        curElement.attr('src', e.target.result);
    };
    reader.readAsDataURL(this.files[0]);
	});

	$('body').on('click','#buttonReset',function(){
		$('#pass').val('');
		$('#repeatPass').val('');
		$('#dateBirth').val('');
		$('#addressUser').val('');
	});
});
