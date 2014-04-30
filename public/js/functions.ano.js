jQuery(function($) {
    $("#montadora").change(function() {
        var montadora = $(this).val();
        alert(montadora);
        $.post(
            "/anos/listar-modelos",
            {montadora: montadora},
            function(data, status) {
                if (status == 'success' && $.trim(data) != 'naopassou') {
                    
                } else {

                }
            },
            'html'
        );

    });
});