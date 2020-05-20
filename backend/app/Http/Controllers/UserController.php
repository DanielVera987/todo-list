<?php

namespace App\Http\Controllers;

use App\Helpers\JwtAuth;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use App\User;

class UserController extends Controller
{  
    public function register(Request $request){
         $json = $request->input('json', null);
         $params = json_decode($json);
         $params_array = json_decode($json, true);
 
         if(!empty($params) && !empty($params_array)){
             //Limpiar datos
             $params_array = array_map('trim', $params_array);
 
             //Validar datos
             $validate = Validator::make($params_array, [
                 'name'      => 'required|alpha',
                 'username'  => 'required',
                 'email'     => 'required|email|unique:users',
                 'password'  => 'required'
             ]);
 
             if($validate->fails()){
                 $data = array(
                     'status' => 'error',
                     'code'   => 404,
                     'mensaje'=> 'El usuario no se ha creado correctamente',
                     'errors' => $validate->errors()
                 );
             }else{
                 //Cifrar la contraseña
                 $pwd = hash('sha256',$params->password);
                
                 //Crear el usuario
                 $user  = new User();
                 $user->name = $params_array['name'];
                 $user->username = $params_array['username'];
                 $user->email = $params_array['email'];
                 $user->password = $pwd;
 
                 //Guardar el usuario
                 $user->save();
 
                 $data = array(
                     'status' => 'success',
                     'code'   => 200,
                     'mensaje'=> 'El usuario se ha creado correctamente',
                     'user'   => $user
                 );
             }
         }else{
             $data = array(
                 'status' => 'error',
                 'code'   => 400,
                 'mensaje'=> 'Los datos enviados no son correctos'
             );
         }
 
         return response()->json($data, $data['code']);
    }

    public function login(Request $request){
        $jwtAuth = new JwtAuth();

        //Recibir datos por post
        $json = $request->input('json', null);
        $params = json_decode($json);
        $params_array = json_decode($json, true);

        //Validar esos datos
        $validate = Validator::make($params_array, [
            'email'     => 'required|email',
            'password'  => 'required'
        ]);

        if($validate->fails()){
            $signup = array(
                'status' => 'error',
                'code' => 400,
                'mensaje' => 'El usuario no se ha podido identificar',
                'error' => $validate->errors()
            );
        }else{
            //Cifrar la contraseña
            $pwd = hash('sha256',$params->password);

            //Devolver el token o datos
            $signup = $jwtAuth->signup($params->email, $pwd);

            if(!empty($params->gettoken)){
                $signup = $jwtAuth->signup($params->email,$pwd, true);
            }
        }

        if(is_array($signup)){
            return response()->json($signup, $signup['code']);
        }else{
            return response()->json($signup, 200);
        }

    }

    public function update(Request $request){
        //Verificar si el usuario esta identificado
        $token = $request->header('Authorization');
        $jwtAuth = new JwtAuth();
        $checkToken = $jwtAuth->checkToken($token);

        //Recored los datos
        $json = $request->input('json', null);
        $params = json_decode($json);
        $params_array = json_decode($json, true);

        //Verificar que este autentificado y que sea valido los parametros
        if($checkToken && !empty($params)){
            //obtenemos el usuario identificado
            $user = $jwtAuth->checkToken($token, true);

            //validamos los datos
            $validate = Validator::make($params_array,[
                'name' => 'required|alpha',
                'username' => 'required|alpha',
                'email' => 'required|email|unique:users,'.$user->sub
            ]);

            //Quitar los campos que no quiero actualizar
            unset($params_array['id']);
            unset($params_array['password']);
            unset($params_array['created_at']);
            unset($params_array['remember_token']);

            $user_update = User::where('id', $user->sub)->update($params_array);

            $data = array(
                'status' => 'success',
                'code' => 200,
                'user' => $user,
                'change' => $params_array
            );
        }else{
            $data = array(
                'status' => 'error',
                'code'   => 400,
                'mensaje'=> 'El usuario no esta identificado'
            );
        }

        return response()->json($data, $data['code']);

    }

}
