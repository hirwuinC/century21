$(document).ready(function(){
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
                description:"codigo_id"

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
