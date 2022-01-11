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
use App\Empresa;
use App\Serie;
use App\Documento;
use App\Events\ActualizacionBitacora;
use Validator;

class SeriesController extends Controller
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
       return view ("admin.series.index");
    }

    public function getJson(Request $params)
    {
       $api_Result['data'] = Serie::select(
           'series.id',
           'series.serie',
           'series.correlativo',
           'series.fecha_vencimiento',
           'documentos.descripcion as documento',
           'series.estado_id',
           'estados.descripcion as estado',
           'series.created_at'
        )->join(
           'estados',
           'series.estado_id',
           '=',
           'estados.id'
        )->join(
            'documentos',
            'series.documento_id',
            '=',
            'documentos.id'
        )->where(
           'series.estado_id',
           '<',
           '3'
        )->where(
           'series.documento_id',
           '>',
           '0'
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
        $documentos = Documento::WHERE("estado_id","=",1)->WHERE("id",">",0)->get();
        
        return view('admin.series.create', compact('documentos'));
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
        $series = Serie::create($data);
        $series->user_id = Auth::user()->id;
        $series->fecha_vencimiento = Carbon::parse($request->fecha_vence)->format('Y-m-d');
        $series->correlativo = 1;
        $series->empresa_id = $user_perfil[0]->empresa_id;
        $series->estado_id = 1;
        $series->save();

        event(new ActualizacionBitacora($series->id, Auth::user()->id, 'Creación', '', $series, 'series'));

        return redirect()->route('series.index')->withFlash('La Serie se ha registrado exitosamente.');
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
    public function edit(Serie $serie)
    {
        $documentos = Documento::WHERE("estado_id","=",1)->get();
        
        return view('admin.series.edit', compact('documentos','serie'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Serie $serie)
    {
        $nuevos_datos = array(
            'serie' => $request->serie,
            'fecha_vencimiento' => $request->fecha_vence,
            'documento_id' => $request->documento_id,
            'user_id' => Auth::user()->id
            );
        $json = json_encode($nuevos_datos);
 
        event(new ActualizacionBitacora($serie->id, Auth::user()->id,'Edición',$serie, $json,'series'));

        $serie->fecha_vencimiento = Carbon::parse($request->fecha_vence)->format('Y-m-d');
        $serie->update($request->all());
      
        return redirect()->route('series.index', $serie)->with('flash','La serie ha sido actualizada!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Serie $serie, Request $request)
    {
        $serie->estado_id = 3;
        $serie->save();

        event(new ActualizacionBitacora($serie->id, Auth::user()->id, 'Eliminación', '', '', 'series'));

        return Response::json(['success' => 'Éxito']);
    }


    public function desactivar(Serie $serie, Request $request)
    {
        $serie->estado_id = 2;
        $serie->save();

        event(new ActualizacionBitacora($serie->id, Auth::user()->id, 'Desactivación', '', '', 'series'));

        return Response::json(['success' => 'Éxito']);
    }


    public function activar(Serie $serie, Request $request)
    {
        $serie->estado_id = 1;
        $serie->save();

        event(new ActualizacionBitacora($serie->id, Auth::user()->id, 'Activación', '', '', 'series'));

        return Response::json(['success' => 'Éxito']);
    }
}
