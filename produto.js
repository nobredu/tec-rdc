$(document).ready(function() {
    function verificarCampos() {
        var checagem = true;

        $('.formulario__field').each(function() {
            var id = $(this).attr('id');
            var valor = $(this).val();
            
            if (id !== 'cod_fabrica' && id !== 'cod_ext' && id !== 'cod_int') { 
                console.log('Valor do campo:', $(this).attr('name'), 1, valor);
                if (!valor || valor.trim() === '') { 
                    checagem = false; 
                    return false;
                }else{
                    checagem = true;
                }
            }
        });

        if (checagem) {
            var checkboxValor = $("#formulario__checkbox").val();
            if (!checkboxValor || checkboxValor.trim() === '') {
                checagem = true;
            }else{
                checagem = false;
            }
        }

        if (checagem) {
            $("#submit").show();
        } else {
            $("#submit").hide();
        }
    }

    verificarCampos();

    $('.formulario__field').on('change keyup input', function() {
        verificarCampos();
    });
    $('#formulario__checkbox').on('change', function() {
        verificarCampos();
    });
});
