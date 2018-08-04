/**
 * Controlador para la gestion de respuestas
 * JULIAN ALVARAN 2018-08-03
 * TECHNO SOLUCIONES SAS EN ASOCIACION CON SITIS SA
 * 317 774 0609
 */
/**
 * Envia el archivo de carga de glosas masivas al servidor
 * @returns {undefined}
 */
$(document).ready(function() {
    $('#Cuentas').select2({
		  
                placeholder: 'Busque una CuentaRIPS o EPS',
                ajax: {
                  url: './buscadores/CuentaRIPS.querys.php',
                  dataType: 'json',
                  delay: 250,
                  processResults: function (data) {
                    return {
                      results: data
                    };
                  },
                  cache: true
                }
              });
});