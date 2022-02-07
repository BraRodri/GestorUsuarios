<x-app-layout>

    @section('pagina')
        Inicio
    @endsection

    <div class="container-fluid px-4 ">

        <h1 class="mt-4">Bienvenido</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Inicio</li>
        </ol>

        <div class="row">

            <div class="col-lg-12 col-12 mb-5">
                <a class="btn btn-dark" href="{{ route('user.ver') }}">
                    Ver Listado de Usuarios
                </a>
            </div>

            <div class="col-md-4">
                <div class="card card-counter bg-primary">
                    <i class="fa fa-users"></i>
                        <span class="count-numbers">{{ $user_registrados }}</span>
                        <span class="count-name">Usuarios Registrados</span>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card card-counter bg-success">
                    <i class="fa fa-users"></i>
                    <span class="count-numbers">{{ $user_activos }}</span>
                    <span class="count-name">Usuarios Activos</span>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card card-counter bg-danger">
                    <i class="fa fa-users"></i>
                    <span class="count-numbers">{{ $user_inactivos }}</span>
                    <span class="count-name">Usuarios Inactivos</span>
                </div>
            </div>

            <div class="col-lg-12 mt-5">
                <div class="card border-2 shadow">
                    <div class="card-header">
                        Busqueda rapida
                    </div>
                    <div class="card-body">
                        <p class="card-text">Busque un usuario por nombre, cargo o proyecto</p>
                        <form id="form_busqueda_rapida" class="row g-3 needs-validation" method="post" novalidate>
                            @csrf
                            <div class="col-md-12">
                                <label for="inputEmail4" class="form-label">Parametros</label>
                                <input type="text" class="form-control" id="parametros" name="parametro" required>
                            </div>
                        </form>

                        <div id="div_resultados" class=" p-5">
                            <p>Resultados busqueda:</p>
                            <ol class="list-group list-group-numbered" id="lista_resultados">
                                <li class="list-group-item d-flex justify-content-between align-items-start">
                                    <div class="ms-2 me-auto">
                                        <strong>Nombre usuario:</strong> ------- <br>
                                        <strong>Numero Documento:</strong> -----  /
                                        <strong>Proyecto:</strong> ------
                                    </div>
                                    <div>
                                        <button class="btn btn-success">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>
                                        <button class="btn btn-danger">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <x-modal-registro-usuario></x-modal-registro-usuario>
    <x-modal-editar-usuario></x-modal-editar-usuario>

    <x-slot name="js">
        <script>

            $('#div_resultados').hide();

            $("#parametros").keyup(function() {
                if($("#parametros").val() !== ''){

                    var imprimir = '';
                    var parametro = $("#parametros").val();

                    //ruta
                    var url = route('user.busquedaRapida', parametro);

                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        type: "GET",
                        encoding:"UTF-8",
                        url: url,
                        dataType:'json',
                    }).done(function(respuesta){
                        //console.log(respuesta);
                        if (!respuesta.error) {

                            $('#div_resultados').show();
                            $('#lista_resultados').html('');
                            respuesta.resultado.forEach(element => {

                                imprimir += `
                                <li class='list-group-item d-flex justify-content-between align-items-start' id="lista_usuario_${element.id}">
                                    <div class="ms-2 me-auto">
                                        <strong>Nombre usuario:</strong> ${element.name} <br>
                                        <strong>Cargo:</strong> ${element.administrative_charge}  /
                                        <strong>Proyecto:</strong> ${element.project}
                                    </div>
                                    <div>
                                        <button class="btn btn-success" onclick='editarUsuario(${element.id});'>
                                            <i class="bi bi-pencil-square"></i>
                                        </button>
                                        <button class="btn btn-danger" onclick='eliminarUsuario(${element.id});'>
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </li>
                                `;

                            });

                            $('#lista_resultados').append(imprimir);

                            //$("#tbodyProducto").html(respuesta.data);

                        } else {
                            $("#tbodyProducto").html('');
                            setTimeout(function(){
                                swal(respuesta.mensaje, {
                                    icon: "error",
                                    button: false,
                                    timer: 3000
                                });
                            },2000);
                        }
                    }).fail(function(resp){
                        console.log(resp);
                    });

                } else {
                    $('#div_resultados').hide();
                    $('#lista_resultados').html('');
                }
            });

            //eliminar usuario
            function eliminarUsuario(id){
                var url = route('user.eliminar', id);
                swal({
                    title: "Eliminar",
                    text: "¿Estas seguro de eliminar al usuario?",
                    icon: "warning",
                    buttons: ["Cancelar", "Si, eliminar"],
                    dangerMode: true,
                }).then((willDelete) => {
                    if (willDelete) {
                        $.ajax({
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            type: "GET",
                            encoding:"UTF-8",
                            url: url,
                            dataType:'json',
                            beforeSend:function(){
                                swal("Eliminando Usuario, espere porfavor...", {
                                    button: false,
                                    timer: 3000
                                });
                            }
                        }).done(function(respuesta){
                            //console.log(respuesta);
                            if (!respuesta.error) {

                                swal('Usuario Eliminado', {
                                    icon: "success",
                                    button: false,
                                    timer: 2000
                                });
                                $('#lista_resultados').html('');

                            } else {
                                setTimeout(function(){
                                    swal(respuesta.mensaje, {
                                        icon: "error",
                                        button: false,
                                        timer: 4000
                                    });
                                },2000);
                            }
                        }).fail(function(resp){
                            console.log(resp);
                        });
                    }
                });
            }

            //editar usuario
            function editarUsuario(id){
                var url_consulta = route('user.getUsuario', id);

                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    type: "GET",
                    encoding:"UTF-8",
                    url: url_consulta,
                    dataType:'json',
                    beforeSend:function(){
                        swal("Consultado información, espere porfavor...", {
                            button: false,
                            timer: 2000
                        });
                    }
                }).done(function(respuesta){
                    //console.log(respuesta);
                    if (!respuesta.error) {

                        $('#id_usuario').val(respuesta.data.id);
                        $('#editar_nombres').val(respuesta.data.name);
                        $('#editar_cargo').val(respuesta.data.administrative_charge);
                        $('#editar_email').val(respuesta.data.email);
                        $('#editar_proyecto').val(respuesta.data.project);
                        $('#editar_estado').val(respuesta.data.active);

                        setTimeout(function(){
                            $('#editar_usuario').modal('show');
                        }, 2000);

                    } else {
                        setTimeout(function(){
                            swal(respuesta.mensaje, {
                                icon: "error",
                                button: false,
                                timer: 4000
                            });
                        },2000);
                    }
                }).fail(function(resp){
                    console.log(resp);
                });

            };

            //proceso de edicion
            $('#form_editar_usuario').on('submit', function(e) {
                event.preventDefault();
                if ($('#form_editar_usuario')[0].checkValidity() === false) {
                    event.stopPropagation();
                } else {

                    // agregar data
                    var thisForm = $('#form_editar_usuario');
                    var formData = new FormData(this);

                    //ruta
                    var url = "{{ route('user.actualizar') }}";

                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        type: "POST",
                        encoding:"UTF-8",
                        url: url,
                        data: formData,
                        processData: false,
                        contentType: false,
                        dataType:'json',
                        beforeSend:function(){
                            swal("Validando datos, espere porfavor...", {
                                button: false,
                                timer: 3000
                            });
                        }
                    }).done(function(respuesta){
                        //console.log(respuesta);
                        if (!respuesta.error) {

                            swal('Actualización Exitosa', {
                                icon: "success",
                                button: false,
                                timer: 2000
                            });

                            $("#editar_usuario").modal('hide');
                            thisForm[0].reset();
                            $('#lista_resultados').html('');

                        } else {
                            setTimeout(function(){
                                swal(respuesta.mensaje, {
                                    icon: "error",
                                    button: false,
                                    timer: 4000
                                });
                            },2000);
                        }
                    }).fail(function(resp){
                        console.log(resp);
                    });

                }
                $('#form_editar_usuario').addClass('was-validated');

            });

        </script>
    </x-slot>

</x-app-layout>
