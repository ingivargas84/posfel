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
use App\Perfil;
use App\Rol;
use App\Perfil_Rol;
use App\Events\ActualizacionBitacora;
use Validator;

class PerfilesController extends Controller
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
        return view ("admin.perfiles.index");
    }


    public function getJson(Request $params)
     {
         $api_Result['data'] = Perfil::select(
             'perfiles.id',
             'perfiles.codigo',
             'perfiles.estado_id',
             'perfiles.descripcion as perfil',
             'estados.descripcion',
             'perfiles.created_at'
         )->join(
             'estados',
             'perfiles.estado_id',
             '=',
             'estados.id'
         )->where(
             'perfiles.estado_id',
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
        return view('admin.perfiles.create');
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
        $perfil = Perfil::create($data);
        $perfil->user_id = Auth::user()->id;
        $perfil->estado_id = 1;
        $perfil->save();

        event(new ActualizacionBitacora($perfil->id, Auth::user()->id, 'Creación', '', $perfil, 'perfil'));

        return redirect()->route('perfiles.index')->withFlash('El perfil se ha registrado exitosamente.');
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
    public function edit(Perfil $perfil)
    {
        return view('admin.perfiles.edit', compact('perfil'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Perfil $perfil)
    {
        $nuevos_datos = array(
            'codigo' => $request->codigo,
            'descripcion' => $request->descripcion,
        );

        $json = json_encode($nuevos_datos);

        event(new ActualizacionBitacora($perfil->id, Auth::user()->id, 'Edición', $perfil, $json, 'perfiles'));

        $perfil->update($request->all());

        return redirect()->route('perfiles.index', $perfil)->withFlash('El Perfil se ha actualizado exitosamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Perfil $perfil, Request $request)
    {
        $perfil->estado_id = 3;
        $perfil->save();

        event(new ActualizacionBitacora($perfil->id, Auth::user()->id, 'Eliminación', '', '', 'perfiles'));

        return Response::json(['success' => 'Éxito']);
    }


    public function desactivar(Perfil $perfil, Request $request)
    {
        $perfil->estado_id = 2;
        $perfil->save();

        event(new ActualizacionBitacora($perfil->id, Auth::user()->id, 'Desactivación', '', '', 'perfiles'));

        return Response::json(['success' => 'Éxito']);
    }


    public function activar(Perfil $perfil, Request $request)
    {
        $perfil->estado_id = 1;
        $perfil->save();

        event(new ActualizacionBitacora($perfil->id, Auth::user()->id, 'Activación', '', '', 'perfiles'));

        return Response::json(['success' => 'Éxito']);
    }


    public function asignarol(Perfil $perfil)
	{

        $query = Perfil_Rol::Where("perfil_id","=",$perfil->id)->get();

        if (!empty($query)) {

            $queryroles = "SELECT rol.id, rol.descripcion 
            FROM (SELECT * 
            FROM perfil_roles pr 
            WHERE perfil_id = " . $perfil->id . "  ) pr 
            RIGHT JOIN rol rol ON pr.rol_id=rol.id
            WHERE pr.rol_id IS NULL AND rol.estado_id = 1  ";

            $roles = DB::select($queryroles); 

        }else{

            $roles = Rol::Where("estado_id","=",1)->get();
            
        }

        $query = "SELECT pr.id, pr.created_at, rol.descripcion as rol, rol.codigo, pr.rol_id 
        FROM perfil_roles pr INNER JOIN perfiles per ON per.id=pr.perfil_id 
        INNER JOIN rol rol ON rol.id=pr.rol_id WHERE pr.perfil_id = " . $perfil->id;
        
        $api_Result = DB::select($query);
        

        return view('admin.perfiles.asignaperfil', compact('perfil', 'roles', 'api_Result'));
    }


    public function guardarol(Request $request)
	{
        $data = $request->all();
        $perfil_rol = Perfil_Rol::create($data);
        $perfil_rol->estado_id = 1;
        $perfil_rol->user_asigna_id = Auth::user()->id;
        $perfil_rol->save();

        event(new ActualizacionBitacora($perfil_rol->id, Auth::user()->id, 'Creación', '', $perfil_rol, 'perfil rol'));

        return redirect()->route('perfiles.index')->withFlash('La asignación de rol se ha registrado exitosamente.');
    }


    public function destroyRol(Perfil_Rol $perfil_rol)
    {
        $perfil_rol->delete();

        event(new ActualizacionBitacora($perfil_rol->id, Auth::user()->id, 'Eliminación', '', $perfil_rol, 'Perfil y Rol'));

        return Response::json(['success' => 'éxito'], 200);
    }
}
