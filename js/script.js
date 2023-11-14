$(document).ready(function() {
     $(document).on("submit", "#votacionForm", function(event) {
      event.preventDefault();

      var formData = $(this).serialize();
      var nombreValue = $(this).find("#nombre").val();
      var regionValue = $(this).find("#region").val();
      var comunaValue = $(this).find("#comuna").val();
      var enteroOptions = $(this).find('input[name="entero[]"]:checked');

      if (nombreValue !== "") {
        if (regionValue != 0) {
          if (comunaValue != 0) {
            if (enteroOptions.length >= 2) {
              $.ajax({
                type: "POST",
                url: "procesar_voto.php",
                dataType: "json",
                data: formData,
                beforeSend: function() {
                  $("#spinner").show();
                },
                success: function(response) {
                  $("#spinner").hide();
                  $("#resultado").html(response);

                  if(response["success"] != false){
                      Swal.fire({
                        icon: 'success',
                        title: 'Genial',
                        text: response["message"]
                      })

                    $("#nombre").val('');
                    $("#alias").val('');
                    $("#rut").val('');
                    $("#correo").val('');
                    $("#region").val('0');
                    $("#comuna").val('0');
                    $("#candidato").val('0');
                    $('input[name="entero[]"]').prop('checked', false);

                  } else {
                    Swal.fire({
                      icon: 'error',
                      title: 'Lo siento',
                      text: response["message"]
                    })
                  }
                
                }
              });
            } else {
              Swal.fire({
                icon: 'error',
                title: 'Lo siento',
                text: 'Debe seleccionar al menos dos opciones de "¿Cómo se enteró de nosotros?"'
              })
            }
          } else {
            Swal.fire({
              icon: 'error',
              title: 'Lo siento',
              text: 'El campo Comuna es Obligatorio!'
            })
          }
        } else {
          Swal.fire({
            icon: 'error',
            title: 'Lo siento',
            text: 'El campo Region es Obligatorio!'
          })
        }
      } else {
        Swal.fire({
          icon: 'error',
          title: 'Lo siento',
          text: 'El campo Nombre y Apellido es Obligatorio!'
        })
      }
    });

     $('#rut').inputmask({
        mask: '9{1,2}.9{3}.9{0,3}-(9|k|K)',
        showMaskOnHover: false
      });
     $('#candidato').chosen();


      $(document).on("change", "#region", function(){
        let region = $(this).val();

          $.ajax({
              type: "POST",
              url: "obtener_comunas_por_region.php",
              dataType: "json",
              data: {
                  region: region
              },
              success: function(data){
                  $("#comuna").empty();
                  $("#comuna").append("<option value='0'>Seleccionar</option>");
                  $.each(data, function(index, comuna){
                      $("#comuna").append('<option value="' + comuna.id_comuna + '">' + comuna.nombre_comuna + '</option>');
                  });
              }
          });
      });

  });