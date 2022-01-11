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
use App\Bodega;
use App\Events\ActualizacionBitacora;
use Validator;

class BodegasController extends Controller
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
       return view ("admin.bodegas.index");
   }

   public function getJson(Request $params)
   {
       $api_Result['data'] = Bodega::select(
           'bodegas.id',
           'bodegas.codigo',
           'bodegas.estado_id',
           'bodegas.descripcion as bodega',
           'estados.descripcion as estado',
           'bodegas.created_at'
       )->join(
           'estados',
           'bodegas.estado_id',
           '=',
           'estados.id'
       )->where(
           'bodegas.estado_id',
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
        return view('admin.bodegas.create');
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
        $roles = Perfil_Rol::where("perfil_id","=",$user_perfil[0]->perfil_id)->where("rol_id","=",6)->get();

        $contador = count($roles);

        if ($contador > 0)
        {


        $data = $request->all();
        $bodega = Bodega::create($data);
        $bodega->user_id = Auth::user()->id;
        $bodega->empresa_id = $user_perfil[0]->empresa_id;
        $bodega->estado_id = 1;
        $bodega->save();

        event(new ActualizacionBitacora($bodega->id, Auth::user()->id, 'Creación', '', $bodega, 'perfil'));

        return redirect()->route('bodegas.index')->withFlash('La Bodega se ha registrado exitosamente.');

    }
    else
    {
       return redirect()->route('bodegas.index')->withFlash('La bodega no se ha podido crear, no tiene permisos para ésta acción');
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
    public function edit(Bodega $bodega)
    {
        return view('admin.bodegas.edit', compact('bodega'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Bodega $bodega)
    {

        $user_perfil = User_Perfil::where("user_id","=",Auth::user()->id)->get();
        $roles = Perfil_Rol::where("perfil_id","=",$user_perfil[0]->perfil_id)->where("rol_id","=",7)->get();

        $contador = count($roles);

        if ($contador > 0)
        {

        $nuevos_datos = array(
            'codigo' => $request->codigo,
            'descripcion' => $request->descripcion,
        );

        $json = json_encode($nuevos_datos);

        event(new ActualizacionBitacora($bodega->id, Auth::user()->id, 'Edición', $bodega, $json, 'bodegas'));

        $bodega->update($request->all());

        return redirect()->route('bodegas.index', $bodega)->withFlash('La bodega se ha actualizado exitosamente');

    }
    else
    {
        return redirect()->route('bodegas.index', $bodega)->with('flash','La bodega no se ha podido actualizar, no tiene permisos para ésta acción');  
    }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Bodega $bodega, Request $request)
    {
        $user_perfil = User_Perfil::where("user_id","=",Auth::user()->id)->get();
        $roles = Perfil_Rol::where("perfil_id","=",$user_perfil[0]->perfil_id)->where("rol_id","=",10)->get();

        $contador = count($roles);

        if ($contador > 0)
        {

        $bodega->estado_id = 3;
        $bodega->save();

        event(new ActualizacionBitacora($bodega->id, Auth::user()->id, 'Eliminación', '', '', 'bodegas'));

        return Response::json(['success' => 'Éxito']);

    }
    else
    {
      return redirect()->route('bodegas.index', $bodega)->with('flash','No tiene permisos para borrar la bodega');    
    }
    }


    public function desactivar(Bodega $bodega, Request $request)
    {

        $user_perfil = User_Perfil::where("user_id","=",Auth::user()->id)->get();
        $roles = Perfil_Rol::where("perfil_id","=",$user_perfil[0]->perfil_id)->where("rol_id","=",9)->get();

        $contador = count($roles);

        if ($contador > 0)
        {

        $bodega->estado_id = 2;
        $bodega->save();

        event(new ActualizacionBitacora($bodega->id, Auth::user()->id, 'Desactivación', '', '', 'bodegas'));

        return Response::json(['success' => 'Éxito']);

    }
    else
    {
      return redirect()->route('bodegas.index', $bodega)->with('flash','No tiene permisos para desactivar la bodega');    
    }
    }


    public function activar(Bodega $bodega, Request $request)
    {
        $user_perfil = User_Perfil::where("user_id","=",Auth::user()->id)->get();
        $roles = Perfil_Rol::where("perfil_id","=",$user_perfil[0]->perfil_id)->where("rol_id","=",9)->get();

        $contador = count($roles);

        if ($contador > 0)
        {

        $bodega->estado_id = 1;
        $bodega->save();

        event(new ActualizacionBitacora($bodega->id, Auth::user()->id, 'Activación', '', '', 'bodegas'));

        return Response::json(['success' => 'Éxito']);

    }
    else
    {
      return redirect()->route('bodegas.index', $bodega)->with('flash','No tiene permisos para activar la bodega');    
    }
    }
}
