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
use App\territorios;
use App\Events\ActualizacionBitacora;
use Validator;

class TerritoriosController extends Controller
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
        return view ("admin.territorios.index");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("admin.territorios.create");
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
        $territorio = territorios::create($data);
        $territorio->save();
       
        event(new ActualizacionBitacora($territorio->id, Auth::user()->id,'Creación','', $territorio,'territorios'));
        return redirect()->route('territorios.index')->withFlash('El territorio ha sido creado exitosamente!');
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
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function activar(territorios $territorios, Request $request)
     {
        $territorios->estado = 1;
        $territorios->save();
        event(new ActualizacionBitacora($territorios->id, Auth::user()->id,'Activación','','','territorios'));

        return Response::json(['success' => 'Éxito']);       
     }
      
     public function getJson(Request $params)
     {
         $api_Result['data'] = territorios::all(); 
         return Response::json( $api_Result );
     }
}
