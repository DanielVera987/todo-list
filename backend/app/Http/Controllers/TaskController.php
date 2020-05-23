<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use App\Helpers\JwtAuth;
use Firebase\JWT\JWT;

use App\Task;

class TaskController extends Controller
{
    public function __construct(){
        $this->middleware('api.auth', ['except' => ['show']]);
    }
    /**
     * Display a listing of the resource.
     *@param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = $this->getIdentityUser($request);

        $tasks = Task::where('user_id', $user->sub)->with('etiqueta')->get();

        return response()->json([
            'status' => 'success',
            'code' => 200,
            'tasks' => $tasks
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $json = $request->input('json', null);
        $params = json_decode($json);
        $params_array = json_decode($json, true);

        if(!empty($params_array)){
            $validate = Validator::make($params_array, [
                'description' => 'required',
                'etiqueta_id' => 'required'
            ]);

            if($validate->fails()){
                $data = array(
                    'status' => 'error',
                    'code' => 404,
                    'mensaje' => $validate->errors()
                );
            }else{
                $user = $this->getIdentityUser($request);

                $createNewTask = new Task();
                $createNewTask->user_id = $user->sub;
                $createNewTask->etiqueta_id = $params_array['etiqueta_id'];
                $createNewTask->description = $params_array['description'];
                $createNewTask->estado = '0';
                $createNewTask->save();

                $data = array(
                    'status' => 'success',
                    'code' => 200,
                    'mensaje' => 'Tarea creada',
                    'tarea' => $createNewTask
                );
            }
        }else{
            $data = array(
                'status' => 'error',
                'code' => 404,
                'mensaje' => 'Los datos no son validos'
            );
        }

        return response()->json($data, $data['code']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $json = $request->input('json', null);
        $params = json_decode($json);
        $params_array = json_decode($json, true);

        if($params && !empty($params)){
            $validate = Validator::make($params_array, [
                'description' => 'required',
                'etiqueta_id' => 'required'
            ]);

            if($validate->fails()){
                $data = array(
                    'status' => 'error',
                    'code' => 400,
                    'mensaje' => 'Error al actualizar una tarea'
                );
            }else{

                //Eliminamos todo lo que no queremos que actualice
                unset($params_array['id']);
                unset($params_array['estado']);
                unset($params_array['created_at']);
                unset($params_array['user_id']);

                $updateTask = Task::find($id);

                if(is_object($updateTask) && $updateTask){
                    $updateTask->update($params_array);

                    $data = array(
                        'status' => 'success',
                        'code' => 200,
                        'mensaje' => 'Tarea actualizada',
                        'task' => $updateTask
                    );
                }else{
                    $data = array(
                        'status' => 'error',
                        'code' => 400,
                        'mensaje' => 'Error al actualizar una tarea'
                    );
                }
            }
        }

        return response()->json($data, $data['code']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $getTask = Task::where('id',$id)->first();

        if(is_object($getTask) && !empty($getTask)){
            $getTask->delete();

            $data = array(
                'status' => 'success',
                'code' => 200,
                'mensaje' => 'Tarea Eliminada'
            );
        }else{
            $data = array(
                'status' => 'error',
                'code' => 404,
                'mensaje' => 'Error al eliminar una Tarea'
            );
        } 
        
        return response()->json($data, $data['code']);
    }

    private function getIdentityUser($request){
        $jwtAuth = new JwtAuth();
        $token = $request->header('Authorization', null);
        $user = $jwtAuth->checkToken($token, true);

        return $user;
    }
}
