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
use App\Articulo;
use App\Proveedor;
use App\Bodega;
use App\Events\ActualizacionBitacora;
use Validator;

class ArticulosController extends Controller
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
       return view ("admin.articulos.index");
    }


    public function getJson(Request $params)
    {
        $api_Result['data'] = Articulo::select(
            'articulos.id',
            'articulos.codigo_articulo',
            'articulos.codigo_alterno',
            'articulos.existencia',
            'articulos.precio_quetzales',
            'articulos.descripcion as articulo',
            'articulos.estado_id',
            'estados.descripcion as estado',
            'articulos.created_at'
        )->join(
            'estados',
            'articulos.estado_id',
            '=',
            'estados.id'
         )->where(
            'articulos.estado_id',
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
        $proveedores = Proveedor::WHERE("estado_id","<", 3)->get();
        $bodegas = Bodega::WHERE("estado_id","<", 3)->get();
        
        return view('admin.articulos.create', compact('proveedores', 'bodegas'));
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
        $roles = Perfil_Rol::where("perfil_id","=",$user_perfil[0]->perfil_id)->where("rol_id","=",11)->get();

        $contador = count($roles);

        if ($contador > 0)
        {

        $user_perfil = User_Perfil::where("user_id","=",Auth::user()->id)->get();

        $data = $request->all();
        $articulos = Articulo::create($data);
        $articulos->user_id = Auth::user()->id;
        $articulos->empresa_id = $user_perfil[0]->empresa_id;
        $articulos->estado_id = 1;
        $articulos->save();

        event(new ActualizacionBitacora($articulos->id, Auth::user()->id, 'Creación', '', $articulos, 'articulos'));

        return redirect()->route('articulos.index')->withFlash('El Artículo se ha registrado exitosamente.');

    }
    else
    {
       return redirect()->route('articulos.index')->withFlash('El articulo no se ha podido crear, no tiene permisos para ésta acción');
    }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Articulo $articulo)
    {
        $user_perfil = User_Perfil::where("user_id","=",Auth::user()->id)->get();
        $roles = Perfil_Rol::where("perfil_id","=",$user_perfil[0]->perfil_id)->where("rol_id","=",13)->get();


        $contador = count($roles);

        if ($contador > 0)
        {


        $art = Articulo::select(
            'articulos.id',
            'articulos.codigo_articulo',
            'articulos.codigo_alterno',
            'articulos.descripcion as articulo',
            'proveedores.nombre_comercial as proveedor',
            'articulos.costo_fob',
            'articulos.costo_dolares',
            'articulos.costo_quetzales',
            'articulos.costo_promedio_quetzales',
            'articulos.ultimo_costo',
            'articulos.primer_costo',
            'articulos.precio_quetzales',
            'articulos.precio_dolares',
            'articulos.ultimo_precio',
            'articulos.existencia',
            'articulos.cantidad_pedida',
            'articulos.cantidad_minima',
            'articulos.cantidad_maxima',
            'articulos.fecha_ultima_compra',
            'articulos.fecha_ultima_venta',
            'articulos.localizacion',
            'bodegas.descripcion as bodega',
            'articulos.almacenadora',
            'articulos.observaciones',
            'articulos.created_at',
            'users.name'
        )->join(
            'proveedores',
            'articulos.proveedor_id',
            '=',
            'proveedores.id'
        )->join(
            'bodegas',
            'articulos.bodega_id',
            '=',
            'bodegas.id'
        )->join(
            'users',
            'articulos.user_id',
            '=',
            'users.id'
        )->where(
            'articulos.id',
            '=',
            $articulo->id
        )->get();


        return view('admin.articulos.show', compact('art'));

    }
    else
    {
      return redirect()->route('articulos.index')->withFlash('No tiene permisos para observar toda la información del articulo');
    }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Articulo $articulo)
    {
        $proveedores = Proveedor::WHERE("estado_id","=", 1)->get();
        $bodegas = Bodega::WHERE("estado_id","=", 1)->get();
        
        return view('admin.articulos.edit', compact('articulo', 'proveedores', 'bodegas'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Articulo $articulo)
    {

        $user_perfil = User_Perfil::where("user_id","=",Auth::user()->id)->get();
        $roles = Perfil_Rol::where("perfil_id","=",$user_perfil[0]->perfil_id)->where("rol_id","=",12)->get();

        $contador = count($roles);

        if ($contador > 0)
        {

        $nuevos_datos = array(
            'codigo_articulo' => $request->codigo_articulo,
            'codigo_arterno' => $request->codigo_alterno,
            'descripcion' => $request->descripcion,
            'user_id' => Auth::user()->id
            );
        $json = json_encode($nuevos_datos);

 
        event(new ActualizacionBitacora($articulo->id, Auth::user()->id, 'Edición', $articulo, $json,'articulos'));

        $articulo->update($request->all());
      
        return redirect()->route('articulos.index', $articulo)->with('flash','El articulo ha sido actualizado!');

    }
    else
    {
        return redirect()->route('articulos.index', $articulo)->with('flash','El articulo no se ha podido actualizar, no tiene permisos para ésta acción');  
    }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Articulo $articulo, Request $request)
    {
        $user_perfil = User_Perfil::where("user_id","=",Auth::user()->id)->get();
        $roles = Perfil_Rol::where("perfil_id","=",$user_perfil[0]->perfil_id)->where("rol_id","=",15)->get();

        $contador = count($roles);

        if ($contador > 0)
        {

        $articulo->estado_id = 3;
        $articulo->save();

        event(new ActualizacionBitacora($articulo->id, Auth::user()->id, 'Eliminación', '', '', 'articulos'));

        return Response::json(['success' => 'Éxito']);

    }
    else
    {
      return redirect()->route('articulos.index', $articulo)->with('flash','No tiene permisos para borrar el artículo');    
    }
    }


    public function desactivar(Articulo $articulo, Request $request)
    {

        $user_perfil = User_Perfil::where("user_id","=",Auth::user()->id)->get();
        $roles = Perfil_Rol::where("perfil_id","=",$user_perfil[0]->perfil_id)->where("rol_id","=",14)->get();

        $contador = count($roles);

        if ($contador > 0)
        {

        $articulo->estado_id = 2;
        $articulo->save();

        event(new ActualizacionBitacora($articulo->id, Auth::user()->id, 'Desactivación', '', '', 'articulos'));

        return Response::json(['success' => 'Éxito']);

    }
    else
    {
      return redirect()->route('articulos.index', $articulo)->with('flash','No tiene permisos para desactivar el artículo');    
    }
    }


    public function activar(Articulo $articulo, Request $request)
    {
        $user_perfil = User_Perfil::where("user_id","=",Auth::user()->id)->get();
        $roles = Perfil_Rol::where("perfil_id","=",$user_perfil[0]->perfil_id)->where("rol_id","=",14)->get();

        $contador = count($roles);

        if ($contador > 0)
        { 

        $articulo->estado_id = 1;
        $articulo->save();

        event(new ActualizacionBitacora($articulo->id, Auth::user()->id, 'Activación', '', '', 'articulos'));

        return Response::json(['success' => 'Éxito']);

    }
    else
    {
      return redirect()->route('articulos.index', $articulo)->with('flash','No tiene permisos para activar el artículo');    
    }
    }
}
