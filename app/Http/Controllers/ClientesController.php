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
use App\Cliente;
use App\Vendedor;
use App\User_Perfil;
use App\Tipo_Persona;
use App\Events\ActualizacionBitacora;
use Validator;

class ClientesController extends Controller
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
        return view ("admin.clientes.index");
    }


    public function getJson(Request $params)
    {
         $api_Result['data'] = Cliente::select(
             'clientes.id',
             'clientes.codigo',
             'clientes.nombre_comercial',
             'clientes.direccion_comercial as direccion',
             'clientes.telefono',
             'clientes.correo_electronico',
             'estados.descripcion',
             'clientes.estado_id',
             'vendedores.nombres',
             'vendedores.apellidos',
             'clientes.nit',
             'clientes.created_at'
         )->join(
             'estados',
             'clientes.estado_id',
             '=',
             'estados.id'
        )->join(
             'vendedores',
             'clientes.vendedor_id',
             '=',
             'vendedores.id'
         )->where(
             'clientes.estado_id',
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
        $vendedores = Vendedor::WHERE("estado_id","=",1)->get();
        return view('admin.clientes.create', compact('tipo_persona', 'vendedores'));
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
        $clientes = Cliente::create($data);
        $clientes->fecha_ultima_venta = Carbon::parse($request->fecha_uv)->format('Y-m-d');
        $clientes->user_id = Auth::user()->id;
        $clientes->empresa_id = $user_perfil[0]->empresa_id;
        $clientes->estado_id = 1;
        $clientes->save();

        event(new ActualizacionBitacora($clientes->id, Auth::user()->id, 'Creación', '', $clientes, 'cliente'));

        return redirect()->route('clientes.index')->withFlash('El cliente se ha registrado exitosamente.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Cliente $cliente)
    {
        $cliente = Cliente::select(
            'clientes.id',
            'clientes.codigo',
            'clientes.tipo_persona_id',
            'tipo_persona.descripcion as tipo_persona',
            'clientes.nombre_comercial',
            'clientes.razon_social',
            'clientes.abreviatura',
            'clientes.nit',
            'clientes.prop_replegal',
            'clientes.direccion_comercial',
            'clientes.telefono',
            'clientes.nombre_contacto',
            'clientes.telefono_contacto',
            'clientes.correo_electronico',
            'clientes.lugar_entrega',
            'clientes.vendedor_id',
            'vendedores.nombres',
            'vendedores.apellidos',
            'clientes.limite_credito',
            'clientes.descuento_autorizado',
            'clientes.dias_credito',
            'clientes.saldo_actual',
            'clientes.cuenta_contable',
            'clientes.fecha_ultima_venta',
            'clientes.retenedor_iva',
            'clientes.observaciones',
            'clientes.created_at',
            'users.name'
        )->join(
            'tipo_persona',
            'clientes.tipo_persona_id',
            '=',
            'tipo_persona.id'
        )->join(
            'vendedores',
            'clientes.vendedor_id',
            '=',
            'vendedores.id'
        )->join(
            'users',
            'clientes.user_id',
            '=',
            'users.id'
        )->where(
            'clientes.id',
            '=',
            $cliente->id
        )->get();

        return view('admin.clientes.show', compact('cliente'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Cliente $cliente)
    {
        $tipo_persona = Tipo_Persona::all();
        $vendedores = Vendedor::WHERE("estado_id","=",1)->get();

        return view('admin.clientes.edit', compact('tipo_persona', 'vendedores', 'cliente'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cliente $cliente)
    {
        $nuevos_datos = array(
            'nombre_comercial' => $request->nombre_comercial,
            'nit' => $request->nit,
            'telefono' => $request->telefono,
            'user_id' => Auth::user()->id
            );
        $json = json_encode($nuevos_datos);
 
        event(new ActualizacionBitacora($cliente->id, Auth::user()->id,'Edición',$cliente, $json,'clientes'));

        $cliente->fecha_ultima_venta = Carbon::parse($request->fecha_uv)->format('Y-m-d');
        $cliente->update($request->all());
      
        return redirect()->route('clientes.index', $cliente)->with('flash','El cliente ha sido actualizada!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cliente $cliente, Request $request)
    {
        $cliente->estado_id = 3;
        $cliente->save();

        event(new ActualizacionBitacora($cliente->id, Auth::user()->id, 'Eliminación', '', '', 'clientes'));

        return Response::json(['success' => 'Éxito']);
    }


    public function desactivar(Cliente $cliente, Request $request)
    {
        $cliente->estado_id = 2;
        $cliente->save();

        event(new ActualizacionBitacora($cliente->id, Auth::user()->id, 'Desactivación', '', '', 'clientes'));

        return Response::json(['success' => 'Éxito']);
    }


    public function activar(Cliente $cliente, Request $request)
    {
        $cliente->estado_id = 1;
        $cliente->save();

        event(new ActualizacionBitacora($cliente->id, Auth::user()->id, 'Activación', '', '', 'clientes'));

        return Response::json(['success' => 'Éxito']);
    }
}
