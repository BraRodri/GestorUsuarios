<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    //
    public function verUsuario()
    {
        return view('pages.user.ver');
    }

    public function obtenerUsuarios()
    {

        $datos = array();

        $usuarios = User::all();
        if(count($usuarios) > 0){
            foreach ($usuarios as $key => $value) {

                $class_status = ($value->active == 1)? "success" : "danger";
                $text_status = ($value->active == 1)? "Activo" : "Inactivo";

                $datos[] = array(
                    $value->id,
                    $value->project,
                    $value->name,
                    $value->email,
                    "<span class='badge bg-" . $class_status . "'>" . $text_status . "</span>",
                    "<button class='btn btn-success' onclick='editarUsuario(".$value->id.");'>
                        Editar
                    </button>
                    <button type='button' class='btn btn-danger' onclick='eliminarUsuario(".$value->id.");'>
                        Eliminar
                    </button>"
                );

            }
        }

        echo json_encode([
            'data' => $datos,
        ]);

    }

    public function registrarUsuario(Request $request)
    {
        $error = false;
        $mensaje = '';

        $validar = User::where('email', $request->email)->get();
        if(count($validar) > 0){
            $error = true;
            $mensaje = 'Error! Ya existe un usuario con el correo electronico registrado, intente con otro.';
        } else {

            $registro = array(
                'name' => $request->nombres,
                'email' => $request->email,
                'password' => Hash::make($request->passsword),
                'administrative_charge' => $request->cargo,
                'project' => $request->proyecto,
                'active' => $request->estado
            );

            if(User::create($registro)){

                $error = false;

            } else {
                $error = true;
                $mensaje = 'Error! Se presento un problema al registrar al usuario, intenta de nuevo.';
            }

        }

        echo json_encode(array('error' => $error, 'mensaje' => $mensaje));
    }

    public function eliminarUsuario($id)
    {
        $error = false;
        $mensaje = '';

        if(User::findOrFail($id)->delete()){
            $error = false;
        } else {
            $error = true;
            $mensaje = 'Error! Se presento un problema al eliminar al usuario, intenta de nuevo.';
        }

        echo json_encode(array('error' => $error, 'mensaje' => $mensaje));
    }

    public function getUsuario($id)
    {
        $error = false;
        $mensaje = '';

        $data = User::findOrFail($id);
        if(!$data){
            $error = true;
            $mensaje = 'Error! No es posible traer la información del usuario!';
        }

        echo json_encode(array('error' => $error, 'mensaje' => $mensaje, 'data' => $data));
    }

    public function actualizarUsuario(Request $request)
    {
        $error = false;
        $mensaje = '';

        $validar = User::where('email', $request->editar_email)->where('id', '<>', $request->id_usuario)->get();
        if(count($validar) > 0){
            $error = true;
            $mensaje = 'Error! Ya existe un usuario con el correo electronico registrado, intente con otro.';
        } else {

            $registro = array(
                'name' => $request->editar_nombres,
                'email' => $request->editar_email,
                'administrative_charge' => $request->editar_cargo,
                'project' => $request->editar_proyecto,
                'active' => $request->editar_estado
            );

            if($request->editar_password){
                $data['password'] = bcrypt($request->editar_password);
            }

            if(User::findOrFail($request->id_usuario)->update($registro)){

                $error = false;

            } else {
                $error = true;
                $mensaje = 'Error! Se presento un problema al actualizar al usuario, intenta de nuevo.';
            }

        }

        echo json_encode(array('error' => $error, 'mensaje' => $mensaje));
    }

    public function busquedaRapida($parametro)
    {
        $error = false;
        $mensaje = '';

        $resultado = User::where('name', 'LIKE', '%' . $parametro . '%')
            ->orwhere('project', 'LIKE', '%' . $parametro . '%')
            ->get();

        if(!$resultado){
            $error = true;
            $mensaje = 'Error! Se presento un problema al buscar al usuario, intenta de nuevo.';
        }

        echo json_encode(array('error' => $error, 'mensaje' => $mensaje, 'resultado' => $resultado));
    }

}
