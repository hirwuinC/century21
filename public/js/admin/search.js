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
        getValue: 'fullName',/*function(element) {
            
            var textSearch = $('#exampleInputSearch').val();
            var patt = new RegExp(textSearch);
            if (patt.test(element.fullName)) {
                return element.fullName;
            }
            else if(patt.test(element.cedula)){
                return element.cedula;
            }
            else{
                return element.ref_id;
            }
            console.log(patt.test(element.fullName));
            console.log(patt.test(element.cedula));
            console.log(patt.test(element.ref_id));
            console.log(textSearch);
            

            //if (element.fullName ) {}
            return 'fullName';
        },*/
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
                swal("Hello world!");
            },

        },
    }
    $("#exampleInputSearch").easyAutocomplete(options);
    
});