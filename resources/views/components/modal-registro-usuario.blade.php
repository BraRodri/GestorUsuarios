<!-- Modal -->
<div class="modal fade" id="registrar_usuario" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Nuevo Usuario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">

                <form id="registro_usuario" class="row g-3 needs-validation" method="POST" novalidate>
                    @csrf
                    <div class="col-md-6">
                        <label for="inputEmail4" class="form-label">Nombres</label>
                        <input type="text" class="form-control" id="nombres" name="nombres" required>
                    </div>
                    <div class="col-md-6">
                        <label for="inputEmail4" class="form-label">Cargo Administrativo</label>
                        <input type="text" class="form-control" id="cargo" name="cargo" required>
                    </div>
                    <div class="col-md-6">
                        <label for="inputEmail4" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="col-md-6">
                        <label for="inputPassword4" class="form-label">Contraseña</label>
                        <input type="password" class="form-control" id="password" name="passsword" required>
                    </div>
                    <div class="col-md-6">
                        <label for="inputState" class="form-label">Proyecto</label>
                        <select id="proyecto" class="form-select" name="proyecto" required>
                            <option value="" selected>- Seleccione -</option>
                            <option value="Gestor de Usuarios">Gestor de Usuarios</option>
                            <option value="Torre de Control">Torre de Control</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="inputState" class="form-label">Estado</label>
                        <select id="estado" class="form-select" name="estado" required>
                            <option value="" selected>- Seleccione -</option>
                            <option value="1">Activo</option>
                            <option value="0">Inactivo</option>
                        </select>
                    </div>

                    <div class="col-12 pt-3" style="text-align: right">
                        <button type="submit" class="btn btn-primary">Registrar Usuario</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
