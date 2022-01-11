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
use App\Proveedor;
use App\Tipo_Proveedor;
use App\Events\ActualizacionBitacora;
use Validator;

class ProveedoresController extends Controller
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
        return view ("admin.proveedores.index");
     }
 
     /**
      * Show the form for creating a new resource.
      *
      * @return \Illuminate\Http\Response
      */
     public function create()
     {
        $tipo_proveedor = Tipo_Proveedor::all();

        return view('admin.proveedores.create', compact('tipo_proveedor'));
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
        $roles = Perfil_Rol::where("perfil_id","=",$user_perfil[0]->perfil_id)->where("rol_id","=",21)->get();

        $contador = count($roles);

        if ($contador > 0)
        {
         $data = $request->all();
         $proveedor = Proveedor::create($data);
         $proveedor->estado_id = 1;
         $proveedor->empresa_id = $user_perfil[0]->empresa_id;
         $proveedor->user_id = Auth::user()->id;
         $proveedor->save();
        
         event(new ActualizacionBitacora($proveedor->id, Auth::user()->id,'Creación','', $proveedor,'proveedores'));
         return redirect()->route('proveedores.index')->withFlash('El proveedor ha sido creado exitosamente!');
         }
         else
         {
            return redirect()->route('proveedores.index')->withFlash('El proveedor no se ha podido crear, no tiene permisos para ésta acción');
         }

     }
 
     /**
      * Display the specified resource.
      *
      * @param  int  $id
      * @return \Illuminate\Http\Response
      */
      public function show(Proveedor $proveedor)
      {
        $user_perfil = User_Perfil::where("user_id","=",Auth::user()->id)->get();
        $roles = Perfil_Rol::where("perfil_id","=",$user_perfil[0]->perfil_id)->where("rol_id","=",23)->get();

        $contador = count($roles);

        if ($contador > 0)
        {
          $proveedor = Proveedor::select(
              'proveedores.id',
              'proveedores.codigo',
              'proveedores.tipo_proveedor_id',
              'tipo_proveedor.tipo_proveedor',
              'proveedores.nombre_comercial',
              'proveedores.razon_social',
              'proveedores.abreviatura',
              'proveedores.prop_replegal',
              'proveedores.nit',
              'proveedores.direccion_comercial',
              'proveedores.telefono',
              'proveedores.correo_electronico',
              'proveedores.dias_credito',
              'proveedores.cuenta_contable',
              'proveedores.contacto',
              'proveedores.telefono_contacto',
              'proveedores.isr',
              'proveedores.fecha_ultima_compra',
              'proveedores.observaciones',
              'proveedores.created_at',
              'users.name'
          )->join(
              'tipo_proveedor',
              'proveedores.tipo_proveedor_id',
              '=',
              'tipo_proveedor.id'
          )->join(
              'users',
              'proveedores.user_id',
              '=',
              'users.id'
          )->where(
              'proveedores.id',
              '=',
              $proveedor->id
          )->get();
  
          return view('admin.proveedores.show', compact('proveedor'));
          }
          else
          {
            return redirect()->route('proveedores.index')->withFlash('No tiene permisos para observar toda la información del proveedor');
          }
      }


     public function nitDisponible()
     {
         $dato = Input::get("nit");
         $query = Proveedor::where("nit","=",$dato)->get();
         $contador = count($query);
         if ($contador == 0)
         {
             return 'false';
         }
         else
         {
             return 'true';
         }
     }
     /**
      * Show the form for editing the specified resource.
      *
      * @param  int  $id
      * @return \Illuminate\Http\Response
      */
     public function edit(Proveedor $proveedor)
     {
        $tipo_proveedor = Tipo_Proveedor::all();

        return view('admin.proveedores.edit', compact('proveedor', 'tipo_proveedor'));
     }
 
     /**
      * Update the specified resource in storage.
      *
      * @param  \Illuminate\Http\Request  $request
      * @param  int  $id
      * @return \Illuminate\Http\Response
      */
     public function update(Proveedor $proveedor, Request $request)
     {
        $user_perfil = User_Perfil::where("user_id","=",Auth::user()->id)->get();
        $roles = Perfil_Rol::where("perfil_id","=",$user_perfil[0]->perfil_id)->where("rol_id","=",22)->get();

        $contador = count($roles);

        if ($contador > 0)
        {
            
        $this->validate($request,['nit' => 'required|unique:proveedores,nit,'.$proveedor->id
        ]);
        $nuevos_datos = array(
            'codigo' => $request->codigo,
            'tipo_proveedor_id' => $request->tipo_proveedor_id,
            'nombre_comercial' => $request->nombre_comercial,
            'razon_social' => $request->razon_social,
            'abreviatura' => $request->abreviatura,
            'prop_replegal' => $request->prop_replegal,
            'nit' => $request->nit,
            'direccion_comercial' => $request->direccion_comercial,
            'telefono' => $request->telefono,
            'dias_credito' => $request->dias_credito,
            'correo_electronico' => $request->correo_electronico,
            'cuenta_contable' => $request->cuenta_contable,
            'contacto' => $request->contacto,
            'telefono_contacto' => $request->telefono_contacto,
            'isr' => $request->isr,
            'observaciones' => $request->observaciones,
            'user_id' => Auth::user()->id
            );
        $json = json_encode($nuevos_datos);
 
        event(new ActualizacionBitacora($proveedor->id, Auth::user()->id,'Edición',$proveedor, $json,'proveedores'));

        $proveedor->update($request->all());
      
        return redirect()->route('proveedores.index', $proveedor)->with('flash','El proveedor ha sido actualizado!');
        }
        else
        {
            return redirect()->route('proveedores.index', $proveedor)->with('flash','El proveedor no se ha podido actualizar, no tiene permisos para ésta acción');  
        }
     }
  
     /**
      * Remove the specified resource from storage.
      *
      * @param  int  $id
      * @return \Illuminate\Http\Response
      */
      public function destroy(Proveedor $proveedor, Request $request)
      {
        $user_perfil = User_Perfil::where("user_id","=",Auth::user()->id)->get();
        $roles = Perfil_Rol::where("perfil_id","=",$user_perfil[0]->perfil_id)->where("rol_id","=",25)->get();

        $contador = count($roles);

        if ($contador > 0)
        {
          $proveedor->estado_id = 3;
          $proveedor->save();
  
          event(new ActualizacionBitacora($proveedor->id, Auth::user()->id, 'Eliminación', '', '', 'proveedores'));
  
          return Response::json(['success' => 'Éxito']);
          }
          else
          {
            return redirect()->route('proveedores.index', $proveedor)->with('flash','No tiene permisos para borrar al proveedor');    
          }
      }
  
  
      public function desactivar(Proveedor $proveedor, Request $request)
      {
        $user_perfil = User_Perfil::where("user_id","=",Auth::user()->id)->get();
        $roles = Perfil_Rol::where("perfil_id","=",$user_perfil[0]->perfil_id)->where("rol_id","=",24)->get();

        $contador = count($roles);

        if ($contador > 0)
        {
          $proveedor->estado_id = 2;
          $proveedor->save();
  
          event(new ActualizacionBitacora($proveedor->id, Auth::user()->id, 'Desactivación', '', '', 'proveedores'));
  
          return Response::json(['success' => 'Éxito']);
        }
        else
        {
          return redirect()->route('proveedores.index', $proveedor)->with('flash','No tiene permisos para desactivar al proveedor');    
        }
      }
  
  
      public function activar(Proveedor $proveedor, Request $request)
      {
        $user_perfil = User_Perfil::where("user_id","=",Auth::user()->id)->get();
        $roles = Perfil_Rol::where("perfil_id","=",$user_perfil[0]->perfil_id)->where("rol_id","=",24)->get();

        $contador = count($roles);

        if ($contador > 0)
        {
          $proveedor->estado_id = 1;
          $proveedor->save();
  
          event(new ActualizacionBitacora($proveedor->id, Auth::user()->id, 'Activación', '', '', 'proveedores'));
  
          return Response::json(['success' => 'Éxito']);
        }
        else
        {
          return redirect()->route('proveedores.index', $proveedor)->with('flash','No tiene permisos para activar al proveedor');    
        }
      }
      

     public function getJson(Request $params)
     {
         $api_Result['data'] = Proveedor::Where("estado_id", "<", 3)->get(); 
         return Response::json( $api_Result );
     }
}
