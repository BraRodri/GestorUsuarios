<x-app-layout>

    @section('pagina')
        Inicio
    @endsection

    <div class="container-fluid px-4 ">

        <h2 class="mt-4 mb-4">Gestión de Usuarios</h2>

        <div class="card mb-4">
            <div class="card-body">
                <div class="d-flex">
                    <span class="flex-grow-1">Modulo de gestión de usuarios, visualización de todos los usuarios registrados.</span>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#registrar_usuario">
                        Agregar nuevo usuario
                    </button>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
                Listado de Usuarios
            </div>
            <div class="card-body">
                <table id="datatablesSimple">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Proyecto</th>
                            <th>Nombre</th>
                            <th>Correo</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>#</th>
                            <th>Proyecto</th>
                            <th>Nombre</th>
                            <th>Correo</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

    </div>

    <x-modal-registro-usuario></x-modal-registro-usuario>
    <x-modal-editar-usuario></x-modal-editar-usuario>

    <x-slot name="js">
        <script>

            var tabla_usuarios = $('#datatablesSimple').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.11.4/i18n/es_es.json"
                },
                "order": [[ 0, "acs" ]],
                "pageLength" : 25,
                "ajax": "{{ route('user.get') }}"
            });

            //proceso de registro
            $('#registro_usuario').on('submit', function(e) {
                event.preventDefault();
                if ($('#registro_usuario')[0].checkValidity() === false) {
                    event.stopPropagation();
                } else {

                    // agregar data
                    var thisForm = $('#registro_usuario');
                    var formData = new FormData(this);

                    //ruta
                    var url = "{{ route('user.registrar') }}";

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

                            swal('Registro Exitoso', {
                                icon: "success",
                                button: false,
                                timer: 2000
                            });

                            $("#registrar_usuario").modal('hide');
                            thisForm[0].reset();
                            tabla_usuarios.ajax.reload();

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
                $('#registro_usuario').addClass('was-validated');

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

                                tabla_usuarios.ajax.reload();

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
                            tabla_usuarios.ajax.reload();

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
