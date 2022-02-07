<div class="modal fade" id="editar_usuario" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Editar Usuario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">

                <form id="form_editar_usuario" class="row g-3 needs-validation" method="POST" novalidate>
                    @csrf
                    <div class="col-md-6">
                        <label for="inputEmail4" class="form-label">Nombres</label>
                        <input type="text" class="form-control" id="editar_nombres" name="editar_nombres" required>
                    </div>
                    <div class="col-md-6">
                        <label for="inputEmail4" class="form-label">Cargo Administrativo</label>
                        <input type="text" class="form-control" id="editar_cargo" name="editar_cargo" required>
                    </div>
                    <div class="col-md-6">
                        <label for="inputEmail4" class="form-label">Email</label>
                        <input type="email" class="form-control" id="editar_email" name="editar_email" required>
                    </div>
                    <div class="col-md-6">
                        <label for="inputPassword4" class="form-label">Contraseña</label>
                        <input type="password" class="form-control" id="editar_password" name="editar_password">
                    </div>
                    <div class="col-md-6">
                        <label for="inputState" class="form-label">Proyecto</label>
                        <select id="editar_proyecto" class="form-select" name="editar_proyecto" required>
                            <option value="" selected>- Seleccione -</option>
                            <option value="Gestor de Usuarios">Gestor de Usuarios</option>
                            <option value="Torre de Control">Torre de Control</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="inputState" class="form-label">Estado</label>
                        <select id="editar_estado" class="form-select" name="editar_estado" required>
                            <option value="" selected>- Seleccione -</option>
                            <option value="1">Activo</option>
                            <option value="0">Inactivo</option>
                        </select>
                    </div>
                    <input name="id_usuario" id="id_usuario" hidden>

                    <div class="col-12 pt-3" style="text-align: right">
                        <button type="submit" class="btn btn-primary">Actualizar datos</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
