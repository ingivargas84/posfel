<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Carbon\Carbon;
use App\User;
use App\User_Perfil;
use App\Perfil_Rol;
use App\Empresa;
use App\Documento;
use App\Tipo_Documento;
use App\Events\ActualizacionBitacora;
use Validator;

class DocumentosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
       $this->middleware('auth');
    }
   

    public function index()
    {
       return view ("admin.documentos.index");
    }

    public function getJson(Request $params)
   {
       $api_Result['data'] = Documento::select(
           'documentos.id',
           'documentos.codigo',
           'documentos.descripcion as documento',
           'tipo_documento.tipo_documento',
           'documentos.estado_id',
           'estados.descripcion as estado',
           'documentos.costea',
           'documentos.imprime',
           'documentos.created_at'
       )->join(
           'estados',
           'documentos.estado_id',
           '=',
           'estados.id'
       )->join(
           'tipo_documento',
           'documentos.tipo_documento_id',
           '=',
           'tipo_documento.id'
        )->where(
            'documentos.id',
            '>',
            '0'
        )->where(
           'documentos.estado_id',
           '<',
           '3'
       )->get(); 

       return Response::json( $api_Result );
   }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tipo_documento = Tipo_Documento::all();
        
        return view('admin.documentos.create', compact('tipo_documento'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user_perfil = User_Perfil::where("user_id","=",Auth::user()->id)->get();
        $roles = Perfil_Rol::where("perfil_id","=",$user_perfil[0]->perfil_id)->where("rol_id","=",16)->get();

        $contador = count($roles);

        if ($contador > 0)
        {


        $data = $request->all();
        $documentos = Documento::create($data);
        $documentos->user_id = Auth::user()->id;

        if ($request->tipo_documento_id == 1)
        {
            $documentos->aplicacion = "Proveedor";
        }
        elseif ($request->tipo_documento_id == 2)
        {
            $documentos->aplicacion = "Cliente";
        }
        else{
            $documentos->aplicacion = "No Aplica";
        }

        $documentos->empresa_id = $user_perfil[0]->empresa_id;
        $documentos->estado_id = 1;
        $documentos->save();

        event(new ActualizacionBitacora($documentos->id, Auth::user()->id, 'Creación', '', $documentos, 'documentos'));

        return redirect()->route('documentos.index')->withFlash('El Documento se ha registrado exitosamente.');
        }
        else
        {
        return redirect()->route('documentos.index')->withFlash('El documento no se ha podido crear, no tiene permisos para ésta acción');
    }
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
    public function edit(Documento $documento)
    {
        $tipo_documento = Tipo_Documento::all();

        return view('admin.documentos.edit', compact('documento', 'tipo_documento'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Documento $documento)
    {
        $user_perfil = User_Perfil::where("user_id","=",Auth::user()->id)->get();
        $roles = Perfil_Rol::where("perfil_id","=",$user_perfil[0]->perfil_id)->where("rol_id","=",17)->get();

        $contador = count($roles);

        if ($contador > 0)
        {

        if ($request->tipo_documento_id == 1)
        {
        $aplicacion = "Proveedor";
        }
        elseif ($request->tipo_documento_id == 2)
        {
        $aplicacion = "Cliente";
        }
        else
        {
        $aplicacion = "No Aplica";
        }


        $nuevos_datos = array(
            'codigo' => $request->codigo,
            'descripcion' => $request->descripcion,
            'tipo_documento_id' => $request->tipo_documento_id,
            'aplicacion' => $aplicacion,
            'costea' => $request->costea,
            'imprime' => $request->imprime,
            'user_id' => Auth::user()->id
            );
        $json = json_encode($nuevos_datos);

 
        event(new ActualizacionBitacora($documento->id, Auth::user()->id, 'Edición',$documento, $json,'documentos'));

        $documento->update($nuevos_datos);
      
        return redirect()->route('documentos.index', $documento)->with('flash','El documento ha sido actualizado!');

    }
    else
    {
        return redirect()->route('documentos.index', $documento)->with('flash','El documento no se ha podido actualizar, no tiene permisos para ésta acción');  
    }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    
     
    public function destroy(Documento $documento, Request $request)
    {
        $user_perfil = User_Perfil::where("user_id","=",Auth::user()->id)->get();
        $roles = Perfil_Rol::where("perfil_id","=",$user_perfil[0]->perfil_id)->where("rol_id","=",20)->get();

        $contador = count($roles);

        if ($contador > 0)
        {

        $documento->estado_id = 3;
        $documento->save();

        event(new ActualizacionBitacora($documento->id, Auth::user()->id, 'Eliminación', '', '', 'documentos'));

        return Response::json(['success' => 'Éxito']);
    }
    else
    {
      return redirect()->route('documentos.index', $documento)->with('flash','No tiene permisos para borrar el documento');    
    }
    }


    public function desactivar(Documento $documento, Request $request)
    {

        $user_perfil = User_Perfil::where("user_id","=",Auth::user()->id)->get();
        $roles = Perfil_Rol::where("perfil_id","=",$user_perfil[0]->perfil_id)->where("rol_id","=",19)->get();

        $contador = count($roles);

        if ($contador > 0)
        {

        $documento->estado_id = 2;
        $documento->save();

        event(new ActualizacionBitacora($documento->id, Auth::user()->id, 'Desactivación', '', '', 'documentos'));

        return Response::json(['success' => 'Éxito']);

    }
    else
    {
      return redirect()->route('documentos.index', $documento)->with('flash','No tiene permisos para desactivar el documento');    
    }
    }


    public function activar(Documento $documento, Request $request)
    {

        $user_perfil = User_Perfil::where("user_id","=",Auth::user()->id)->get();
        $roles = Perfil_Rol::where("perfil_id","=",$user_perfil[0]->perfil_id)->where("rol_id","=",19)->get();

        $contador = count($roles);

        if ($contador > 0)
        {

        $documento->estado_id = 1;
        $documento->save();

        event(new ActualizacionBitacora($documento->id, Auth::user()->id, 'Activación', '', '', 'documentos'));

        return Response::json(['success' => 'Éxito']);
    }
    else
    {
      return redirect()->route('documentos.index', $documento)->with('flash','No tiene permisos para activar el documento');    
    }
    }

}
