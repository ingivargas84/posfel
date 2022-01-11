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
use App\Vendedor;
use App\User_Perfil;
use App\Tipo_Persona;
use App\Events\ActualizacionBitacora;
use Validator;

class VendedoresController extends Controller
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
        return view ("admin.vendedores.index");
    }


    public function getJson(Request $params)
    {
         $api_Result['data'] = Vendedor::select(
             'vendedores.id',
             'vendedores.codigo',
             'vendedores.nombres',
             'vendedores.apellidos',
             'vendedores.puesto',
             'vendedores.dpi',
             'estados.descripcion',
             'vendedores.estado_id',
             'vendedores.direccion',
             'vendedores.fecha_ingreso',
             'vendedores.created_at'
         )->join(
             'estados',
             'vendedores.estado_id',
             '=',
             'estados.id'
         )->where(
             'vendedores.estado_id',
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
        $usquery = "SELECT Us.id, Us.name
        FROM users Us
        LEFT JOIN vendedores ven 
        ON Us.id=ven.user_asignado_id
        WHERE ven.user_asignado_id IS NULL AND Us.estado=1 AND Us.id>1";
        $users = DB::select($usquery);

        return view('admin.vendedores.create', compact('users'));
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

        $data = $request->all();
        $vendedores = Vendedor::create($data);
        $vendedores->fecha_ingreso = Carbon::parse($request->fecha_ing)->format('Y-m-d');
        $vendedores->user_id = Auth::user()->id;
        $vendedores->empresa_id = $user_perfil[0]->empresa_id;
        $vendedores->estado_id = 1;
        $vendedores->save();

        event(new ActualizacionBitacora($vendedores->id, Auth::user()->id, 'Creación', '', $vendedores, 'vendedores'));

        return redirect()->route('vendedores.index')->withFlash('El Vendedor se ha registrado exitosamente.');
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
    public function edit(Vendedor $vendedor)
    {

        $usquery = "SELECT Us.id, Us.name
        FROM users Us
        LEFT JOIN vendedores ven 
        ON Us.id=ven.user_asignado_id
        WHERE Us.estado=1 AND Us.id>1";
        $users = DB::select($usquery);

        return view('admin.vendedores.edit', compact('vendedor', 'users'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Vendedor $vendedor)
    {
        $nuevos_datos = array(
            'codigo' => $request->codigo,
            'nombres' => $request->nombres,
            'apellidos' => $request->apellidos,
            'user_id' => Auth::user()->id
            );
        $json = json_encode($nuevos_datos);
 
        event(new ActualizacionBitacora($vendedor->id, Auth::user()->id,'Edición',$vendedor, $json,'vendedores'));

        $vendedor->fecha_ingreso = Carbon::parse($request->fecha_ing)->format('Y-m-d');
        $vendedor->update($request->all());
      
        return redirect()->route('vendedores.index', $vendedor)->with('flash','El vendedor ha sido actualizada!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Vendedor $vendedor, Request $request)
    {
        $vendedor->estado_id = 3;
        $vendedor->save();

        event(new ActualizacionBitacora($vendedor->id, Auth::user()->id, 'Eliminación', '', '', 'vendedores'));

        return Response::json(['success' => 'Éxito']);
    }

    public function desactivar(Vendedor $vendedor, Request $request)
    {
        $vendedor->estado_id = 2;
        $vendedor->save();

        event(new ActualizacionBitacora($vendedor->id, Auth::user()->id, 'Desactivación', '', '', 'vendedores'));

        return Response::json(['success' => 'Éxito']);
    }


    public function activar(Vendedor $vendedor, Request $request)
    {
        $vendedor->estado_id = 1;
        $vendedor->save();

        event(new ActualizacionBitacora($vendedor->id, Auth::user()->id, 'Activación', '', '', 'vendedores'));

        return Response::json(['success' => 'Éxito']);
    }
}
