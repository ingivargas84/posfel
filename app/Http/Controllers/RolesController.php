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
use App\Rol;
use App\Events\ActualizacionBitacora;
use Validator;

class RolesController extends Controller
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
        return view ("admin.roles.index");
    }

    public function getJson(Request $params)
     {
         $api_Result['data'] = Rol::select(
             'rol.id',
             'rol.codigo',
             'rol.estado_id',
             'rol.descripcion as rol',
             'estados.descripcion',
             'rol.created_at'
         )->join(
             'estados',
             'rol.estado_id',
             '=',
             'estados.id'
         )->where(
             'rol.estado_id',
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
        return view('admin.roles.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $rol = Rol::create($data);
        $rol->user_id = Auth::user()->id;
        $rol->estado_id = 1;
        $rol->save();

        event(new ActualizacionBitacora($rol->id, Auth::user()->id, 'Creación', '', $rol, 'rol'));

        return redirect()->route('roles.index')->withFlash('El rol se ha registrado exitosamente.');
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
    public function edit(Rol $rol)
    {
        return view('admin.roles.edit', compact('rol'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Rol $rol)
    {
        $nuevos_datos = array(
            'codigo' => $request->codigo,
            'descripcion' => $request->descripcion,
        );

        $json = json_encode($nuevos_datos);

        event(new ActualizacionBitacora($rol->id, Auth::user()->id, 'Edición', $rol, $json, 'roles'));

        $rol->update($request->all());

        return redirect()->route('roles.index', $rol)->withFlash('El Rol se ha actualizado exitosamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Rol $rol, Request $request)
    {
        $rol->estado_id = 3;
        $rol->save();

        event(new ActualizacionBitacora($rol->id, Auth::user()->id, 'Eliminación', '', '', 'roles'));

        return Response::json(['success' => 'Éxito']);
    }


    public function desactivar(Rol $rol, Request $request)
    {
        $rol->estado_id = 2;
        $rol->save();

        event(new ActualizacionBitacora($rol->id, Auth::user()->id, 'Desactivación', '', '', 'roles'));

        return Response::json(['success' => 'Éxito']);
    }


    public function activar(Rol $rol, Request $request)
    {
        $rol->estado_id = 1;
        $rol->save();

        event(new ActualizacionBitacora($rol->id, Auth::user()->id, 'Activación', '', '', 'roles'));

        return Response::json(['success' => 'Éxito']);
    }
}
