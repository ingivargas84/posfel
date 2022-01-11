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
use App\Empresa;
use App\Tipo_Persona;
use App\User_Perfil;
use App\Perfil_Rol;
use App\Events\ActualizacionBitacora;
use Validator;

class EmpresasController extends Controller
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
        return view ("admin.empresas.index");
    }


    public function getJson(Request $params)
     {
         $api_Result['data'] = Empresa::select(
             'empresas.id',
             'empresas.codigo',
             'empresas.nombre_comercial',
             'empresas.nit',
             'empresas.direccion_comercial',
             'estados.descripcion',
             'empresas.estado_id',
             'empresas.created_at'
         )->join(
             'estados',
             'empresas.estado_id',
             '=',
             'estados.id'
         )->where(
             'empresas.estado_id',
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
        $tipo_persona = Tipo_Persona::all();
        return view('admin.empresas.create', compact('tipo_persona'));
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
        $roles = Perfil_Rol::where("perfil_id","=",$user_perfil[0]->perfil_id)->where("rol_id","=",1)->get();

        $contador = count($roles);

        if ($contador > 0)
        {
        $data = $request->all();
        $empresa = Empresa::create($data);
        $empresa->user_id = Auth::user()->id;
        $empresa->estado_id = 1;
        $empresa->save();

        event(new ActualizacionBitacora($empresa->id, Auth::user()->id, 'Creación', '', $empresa, 'empresa'));

            return redirect()->route('empresas.index')->withFlash('La empresa se ha registrado exitosamente.');
        }
        else
        {
            return redirect()->route('empresas.index')->withFlash('La empresa no se ha podido crear, no tiene permisos para ésta acción');
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
    public function edit(Empresa $empresa)
    {
        $tipo_persona = Tipo_Persona::all();
        return view('admin.empresas.edit', compact('empresa', 'tipo_persona'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Empresa $empresa)
    {
        $user_perfil = User_Perfil::where("user_id","=",Auth::user()->id)->get();
        $roles = Perfil_Rol::where("perfil_id","=",$user_perfil[0]->perfil_id)->where("rol_id","=",2)->get();

        $contador = count($roles);

        if ($contador > 0)
        {
        $nuevos_datos = array(
            'codigo' => $request->codigo,
            'tipo_persona_id' => $request->tipo_persona_id,
            'nombre_comercial' => $request->nombre_comercial,
            'razon_social' => $request->razon_social,
            'abreviatura' => $request->abreviatura,
            'nit' => $request->nit,
            'num_patronal_igss' => $request->num_patronal_igss,
            'direccion_comercial' => $request->direccion_comercial,
            'direccion_fiscal' => $request->direccion_fiscal,
            'prop_replegal' => $request->prop_replegal,
            'nit_prop_replegal' => $request->nit_prop_replegal,
            'nombre_contador' => $request->nombre_contador,
            'nit_contador' => $request->nit_contador,
        );

        $json = json_encode($nuevos_datos);

        event(new ActualizacionBitacora($empresa->id, Auth::user()->id, 'Edición', $empresa, $json, 'empresas'));

        $empresa->update($request->all());

        return redirect()->route('empresas.index', $empresa)->withFlash('La empresa se ha actualizado exitosamente');
        }
        else
        {
            return redirect()->route('empresas.index', $empresa)->with('flash','La empresa no se ha podido actualizar, no tiene permisos para ésta acción');  
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Empresa $empresa, Request $request)
    {
        $user_perfil = User_Perfil::where("user_id","=",Auth::user()->id)->get();
        $roles = Perfil_Rol::where("perfil_id","=",$user_perfil[0]->perfil_id)->where("rol_id","=",5)->get();

        $contador = count($roles);

        if ($contador > 0)
        {
        $empresa->estado_id = 3;
        $empresa->save();

        event(new ActualizacionBitacora($empresa->id, Auth::user()->id, 'Eliminación', '', '', 'empresas'));

        return Response::json(['success' => 'Éxito']);
    }
    else
    {
      return redirect()->route('empresas.index', $empresa)->with('flash','No tiene permisos para borrar la empresa');    
    }
    }

    public function desactivar(Empresa $empresa, Request $request)
    {
        $user_perfil = User_Perfil::where("user_id","=",Auth::user()->id)->get();
        $roles = Perfil_Rol::where("perfil_id","=",$user_perfil[0]->perfil_id)->where("rol_id","=",4)->get();

        $contador = count($roles);

        if ($contador > 0)
        {
        $empresa->estado_id = 2;
        $empresa->save();

        event(new ActualizacionBitacora($empresa->id, Auth::user()->id, 'Desactivación', '', '', 'empresas'));

        return Response::json(['success' => 'Éxito']);
    }
    else
    {
      return redirect()->route('empresas.index', $empresa)->with('flash','No tiene permisos para desactivar la empresa');    
    }
    }


    public function activar(Empresa $empresa, Request $request)
    {
        $user_perfil = User_Perfil::where("user_id","=",Auth::user()->id)->get();
        $roles = Perfil_Rol::where("perfil_id","=",$user_perfil[0]->perfil_id)->where("rol_id","=",4)->get();

        $contador = count($roles);

        if ($contador > 0)
        {
        $empresa->estado_id = 1;
        $empresa->save();

        event(new ActualizacionBitacora($empresa->id, Auth::user()->id, 'Activación', '', '', 'empresas'));

        return Response::json(['success' => 'Éxito']);
    }
    else
    {
      return redirect()->route('empresas.index', $empresa)->with('flash','No tiene permisos para activar la empresa');    
    }
    }
}
