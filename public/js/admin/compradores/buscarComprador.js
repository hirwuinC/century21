$(document).ready(function(){
    var options = {

        url:function(){
            var textSearch = $('#exampleInputSearch').val();
            return "/admin/buscarcomprador?data="+textSearch;
        },
        getValue: function (element) {
          $('#valor').val(element.id);
	        return element.fullNameComprador;
        },
        template:{
            type:"description",
            fields:{
                fullName:"fullNameComprador",
                description:"cedula"

            }
        },
        list: {
            match: { enabled: false },
            onChooseEvent: function() {
              var valor = $('#valor').val();
              window.location="/admin/compradores?data="+valor;
            },

        },
    }
    $("#exampleInputSearch").easyAutocomplete(options);

});
