$(document).ready(function(){
   /*$('.inputs').on('keyup',function(){
        $('.register-list').css("visibility","hidden");
        var argumento =$('.inputs').val();
        if (argumento !="") {
            $.get("/admin/buscarasesor",{data:argumento},function (resultado){
                if (resultado !="") {
                    //alert(resultado);
                    $.each(resultado,function(index,contenido){
                        $('.register-list').html('<li>'+contenido.fullName+'</li>');
                        $('.register-list').css("visibility","visible");
                    });
                }
                else{
                    $('.register-list').html('<li>No existen coincidencias</li>');
                        $('.register-list').css("visibility","visible");
                }
            });
        }
        else if (argumento =="") {
            $('.register-list').css("visibility","hidden");
        }
    }); */

    var options = {

        url:function(){
            var textSearch = $('#exampleInputSearch').val();
            return "/admin/buscarasesor?data="+textSearch;
        },
        getValue: function (element) {
          $('#valor').val(element.id);
	        return element.fullName;
        },
        template:{
            type:"description",
            fields:{
                fullName:"fullName",
                description:"cedula"

            }
        },
        list: {
            match: { enabled: false },
            onChooseEvent: function() {
              var valor = $('#valor').val();
              window.location="/admin/agente?data="+valor;
            },

        },
    }
    $("#exampleInputSearch").easyAutocomplete(options);

});
