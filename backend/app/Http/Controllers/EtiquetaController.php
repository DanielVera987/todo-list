<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Helpers\JwtAuth;
use Firebase\JWT\JWT;

use App\Etiqueta;

class EtiquetaController extends Controller
{
    public function __construct(){
        $this->middleware('api.auth', ['except' => ['show']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $etiquetas = Etiqueta::all();

        return response()->json([
            'code' => 200,
            'status' => 'success',
            'etiquetas' => $etiquetas
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
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
            $validate = Validator::make($params_array,[
                'nombre' => 'required',
                'color' => 'required'
            ]);

            if($validate->fails()){
                $data = array(
                    'status' => 'error',
                    'code' => 404,
                    'mensaje' => 'Error al crear una etiqueta'
                );
            }else{

                $createNewEtiqueta = new Etiqueta();
                $createNewEtiqueta->nombre = $params_array['nombre'];
                $createNewEtiqueta->color = $params_array['color'];
                $createNewEtiqueta->save();

                $data = array(
                    'status' => 'success',
                    'code' => 200,
                    'mensaje' => 'Etiqueta creada',
                    'etiqueta' => $createNewEtiqueta
                );
            }
        }else{
            $data = array(
                'status' => 'error',
                'code' => 404,
                'mensaje' => 'Error al crear una etiqueta'
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

        if(!empty($params_array)){
            $validate = Validator::make($params_array,[
                'nombre' => 'required',
                'color' => 'required'
            ]);

            if($validate->fails()){
                $data = array(
                    'status' => 'error',
                    'code' => 404,
                    'mensaje' => 'Error al actualizar una etiqueta'
                );
            }else{

                $getEtiqueta = Etiqueta::where('id',$id)->first();

                if(is_object($getEtiqueta) && !empty($getEtiqueta)){
                    $getEtiqueta->update($params_array);

                    $data = array(
                        'status' => 'success',
                        'code' => 200,
                        'mensaje' => 'Etiqueta actualizada',
                        'etiqueta' => $params_array
                    );
                }else{
                    $data = array(
                        'status' => 'error',
                        'code' => 404,
                        'mensaje' => 'Error al actualizar una etiqueta'
                    );
                }                
            }
        }else{
            $data = array(
                'status' => 'error',
                'code' => 404,
                'mensaje' => 'Error al actualizar una etiqueta'
            );
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
        $getEtiqueta = Etiqueta::where('id',$id)->first();

        if(is_object($getEtiqueta) && !empty($getEtiqueta)){
            $getEtiqueta->delete();

            $data = array(
                'status' => 'success',
                'code' => 200,
                'mensaje' => 'Etiqueta Eliminada'
            );
        }else{
            $data = array(
                'status' => 'error',
                'code' => 404,
                'mensaje' => 'Error al eliminar una etiqueta'
            );
        } 
        
        return response()->json($data, $data['code']);
    }
}
