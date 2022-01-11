@extends('admin.layoutadmin')

@section('header')
    <section class="content-header">
        <h1>
          Artículos
          <small>Crear Artículo</small>
        </h1>
        <ol class="breadcrumb">
          <li><a href="{{route('dashboard')}}"><i class="fa fa-tachometer-alt"></i> Inicio</a></li>
          <li><a href="{{route('articulos.index')}}"><i class="fa fa-list"></i> Artículos</a></li>
          <li class="active">Crear</li>
        </ol>
    </section>
@stop

@section('content')
    <form method="POST" id="ArticuloForm"  action="{{route('articulos.save')}}">
            {{csrf_field()}}
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-sm-4">
                                <label for="codigo_articulo">Código Artículo:</label>
                                <input type="text" class="form-control" placeholder="Código Artículo" name="codigo_articulo" >
                            </div>
                            <div class="col-sm-4">
                            </div>
                            <div class="col-sm-4">
                                <label for="codigo_alterno">Código Alterno/Orden:</label>
                                <input type="text" class="form-control" placeholder="Código Alterno/Orden" name="codigo_alterno" >
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-sm-12">
                                <label for="descripcion">Descripción del Artículo:</label>
                                <input type="text" class="form-control" placeholder="Descripcion del Artículo" name="descripcion" >
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-sm-12 text-center">
                                <h3><strong>COSTOS</strong></h3>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <label for="proveedor_id">Proveedor</label>
                                <select name="proveedor_id" class="form-control">
                                        <option value="0">Seleccione una opción</option>
                                    @foreach ($proveedores as $pr)
                                        <option value="{{$pr->id}}">{{$pr->nombre_comercial}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-3">
                                <label for="costo_fob">Costo FOB:</label>
                                <input type="text" class="form-control" placeholder="Costo FOB" name="costo_fob" value="0" >
                            </div>
                            <div class="col-sm-3">
                                <label for="costo_dolares">Costo Dolares $:</label>
                                <input type="text" class="form-control" placeholder="Costo Dolares $" name="costo_dolares" value="0" >
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-sm-3">
                                <label for="costo_quetzales">Costo Quetzales Q:</label>
                                <input type="text" class="form-control" placeholder="Costo Quetzales Q" name="costo_quetzales" value="0">
                            </div>
                            <div class="col-sm-3">
                                <label for="costo_promedio_quetzales">Costo Promedio Q:</label>
                                <input type="text" class="form-control" placeholder="Costo Promedio Q" name="costo_promedio_quetzales" value="0">
                            </div>
                            <div class="col-sm-3">
                                <label for="ultimo_costo">Último Costo:</label>
                                <input type="text" class="form-control" placeholder="Último Costo" name="ultimo_costo" value="0">
                            </div>
                            <div class="col-sm-3">
                                <label for="primer_costo">Primer Costo:</label>
                                <input type="text" class="form-control" placeholder="Primer Costo" name="primer_costo" value="0">
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-sm-12 text-center">
                                <h3><strong>PRECIOS</strong></h3>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">
                                <label for="precio_quetzales">Precio Quetzales Q:</label>
                                <input type="text" class="form-control" placeholder="Precio Quetzales Q" name="precio_quetzales" value="0" >
                            </div>
                            <div class="col-sm-4">
                                <label for="precio_dolares">Precio Dolares $:</label>
                                <input type="text" class="form-control" placeholder="Precio Dolares $" name="precio_dolares" value="0">
                            </div>
                            <div class="col-sm-4">
                                <label for="ultimo_precio">Ultimo Precio:</label>
                                <input type="text" class="form-control" placeholder="Ultimo Precio" name="ultimo_precio" value="0">
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-sm-4">
                                <label for="cantidad_pedida">Cantidad Pedida:</label>
                                <input type="text" class="form-control" placeholder="Cantidad Pedida" name="cantidad_pedida" value="0" >
                            </div>
                            <div class="col-sm-4">
                                <label for="cantidad_minima">Cantidad Mínima:</label>
                                <input type="text" class="form-control" placeholder="Cantidad Mínima" name="cantidad_minima" value="0">
                            </div>
                            <div class="col-sm-4">
                                <label for="cantidad_maxima">Cantidad Máxima:</label>
                                <input type="text" class="form-control" placeholder="Cantidad Máxima" name="cantidad_maxima" value="0">
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-sm-12 text-center">
                                <h3><strong>LOCALIZACIÓN</strong></h3>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">
                                <label for="localizacion">Localización:</label>
                                <input type="text" class="form-control" placeholder="Localización" name="localizacion" >
                            </div>
                            <div class="col-sm-4">
                                <label for="bodega_id">Bodega</label>
                                <select name="bodega_id" class="form-control">
                                        <option value="0">Seleccione una opción</option>
                                    @foreach ($bodegas as $bod)
                                        <option value="{{$bod->id}}">{{$bod->descripcion}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-4">
                                <label for="almacenadora">Almacenadora:</label>
                                <input type="text" class="form-control" placeholder="Almacenadora" name="almacenadora" >
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-sm-12">
                                <label for="observaciones">Observaciones:</label>
                                <input type="text" class="form-control" placeholder="Observaciones" name="observaciones" >
                            </div>
                        </div>
                        <br>
                        <div class="text-right m-t-15">
                            <a class='btn btn-primary form-button' href="{{ route('articulos.index') }}">Regresar</a>
                            <button id="ButtonDocumento" class="btn btn-success form-button">Guardar</button>
                        </div>

                    </div>
                </div>
            </div>
    </form>
    <div class="loader loader-bar"></div>

@stop

@push('styles')
@endpush

@push('scripts')

<script src="{{asset('js/documentos/create.js')}}"></script>
@endpush
