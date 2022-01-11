@extends('admin.layoutadmin')

@section('header')
    <section class="content-header">
        <h1>
          Artículos
          <small>Editar Artículo</small>
        </h1>
        <ol class="breadcrumb">
          <li><a href="{{route('dashboard')}}"><i class="fa fa-tachometer-alt"></i> Inicio</a></li>
          <li><a href="{{route('articulos.index')}}"><i class="fa fa-list"></i> Artículos</a></li>
          <li class="active">Actualizar</li>
        </ol>
    </section>
@stop

@section('content')
    <form method="POST" id="ArticuloEditForm"  action="{{route('articulos.update', $articulo)}}">
            {{csrf_field()}}
            {{ method_field('PUT') }}
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-sm-4">
                                <label for="codigo_articulo">Código Artículo:</label>
                                <input type="text" class="form-control" placeholder="Código Artículo" name="codigo_articulo" value="{{old('codigo_articulo', $articulo->codigo_articulo)}}" >
                            </div>
                            <div class="col-sm-4">
                            </div>
                            <div class="col-sm-4">
                                <label for="codigo_alterno">Código Alterno/Orden:</label>
                                <input type="text" class="form-control" placeholder="Código Alterno/Orden" name="codigo_alterno" value="{{old('codigo_alterno', $articulo->codigo_alterno)}}">
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-sm-12">
                                <label for="descripcion">Descripción del Artículo:</label>
                                <input type="text" class="form-control" placeholder="Descripcion del Artículo" name="descripcion" value="{{old('descripcion', $articulo->descripcion)}}">
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
                                @foreach ($proveedores as $pro)
                                        @if ($pro->id == $articulo->proveedor_id)
                                            <option value="{{$pro->id}}" selected >{{$pro->nombre_comercial}}</option>
                                        @else
                                            <option value="{{$pro->id}}">{{$pro->nombre_comercial}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-3">
                                <label for="costo_fob">Costo FOB:</label>
                                <input type="text" class="form-control" placeholder="Costo FOB" name="costo_fob" value="{{old('costo_fob', $articulo->costo_fob)}}">
                            </div>
                            <div class="col-sm-3">
                                <label for="costo_dolares">Costo Dolares $:</label>
                                <input type="text" class="form-control" placeholder="Costo Dolares $" name="costo_dolares" value="{{old('costo_dolares', $articulo->costo_dolares)}}">
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-sm-3">
                                <label for="costo_quetzales">Costo Quetzales Q:</label>
                                <input type="text" class="form-control" placeholder="Costo Quetzales Q" name="costo_quetzales" value="{{old('costo_quetzales', $articulo->costo_quetzales)}}">
                            </div>
                            <div class="col-sm-3">
                                <label for="costo_promedio_quetzales">Costo Promedio Q:</label>
                                <input type="text" class="form-control" placeholder="Costo Promedio Q" name="costo_promedio_quetzales" value="{{old('costo_promedio_quetzales', $articulo->costo_promedio_quetzales)}}">
                            </div>
                            <div class="col-sm-3">
                                <label for="ultimo_costo">Último Costo:</label>
                                <input type="text" class="form-control" placeholder="Último Costo" name="ultimo_costo" value="{{old('ultimo_costo', $articulo->ultimo_costo)}}">
                            </div>
                            <div class="col-sm-3">
                                <label for="primer_costo">Primer Costo:</label>
                                <input type="text" class="form-control" placeholder="Primer Costo" name="primer_costo" value="{{old('primer_costo', $articulo->primer_costo)}}">
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
                                <input type="text" class="form-control" placeholder="Precio Quetzales Q" name="precio_quetzales" value="{{old('precio_quetzales', $articulo->precio_quetzales)}}">
                            </div>
                            <div class="col-sm-4">
                                <label for="precio_dolares">Precio Dolares $:</label>
                                <input type="text" class="form-control" placeholder="Precio Dolares $" name="precio_dolares" value="{{old('precio_dolares', $articulo->precio_dolares)}}">
                            </div>
                            <div class="col-sm-4">
                                <label for="ultimo_precio">Ultimo Precio:</label>
                                <input type="text" class="form-control" placeholder="Ultimo Precio" name="ultimo_precio" value="{{old('ultimo_precio', $articulo->ultimo_precio)}}">
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-sm-4">
                                <label for="cantidad_pedida">Cantidad Pedida:</label>
                                <input type="text" class="form-control" placeholder="Cantidad Pedida" name="cantidad_pedida" value="{{old('cantidad_pedida', $articulo->cantidad_pedida)}}">
                            </div>
                            <div class="col-sm-4">
                                <label for="cantidad_minima">Cantidad Mínima:</label>
                                <input type="text" class="form-control" placeholder="Cantidad Mínima" name="cantidad_minima" value="{{old('cantidad_minima', $articulo->cantidad_minima)}}" >
                            </div>
                            <div class="col-sm-4">
                                <label for="cantidad_maxima">Cantidad Máxima:</label>
                                <input type="text" class="form-control" placeholder="Cantidad Máxima" name="cantidad_maxima" value="{{old('cantidad_maxima', $articulo->cantidad_maxima)}}">
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
                                <input type="text" class="form-control" placeholder="Localización" name="localizacion" value="{{old('localizacion', $articulo->localizacion)}}">
                            </div>
                            <div class="col-sm-4">
                                <label for="bodega_id">Bodega</label>
                                <select name="bodega_id" class="form-control">
                                 @foreach ($bodegas as $bod)
                                        @if ($bod->id == $articulo->bodega_id)
                                            <option value="{{$bod->id}}" selected >{{$bod->descripcion}}</option>
                                        @else
                                            <option value="{{$bod->id}}">{{$bod->descripcion}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-4">
                                <label for="almacenadora">Almacenadora:</label>
                                <input type="text" class="form-control" placeholder="Almacenadora" name="almacenadora" value="{{old('almacenadora', $articulo->almacenadora)}}" >
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-sm-12">
                                <label for="observaciones">Observaciones:</label>
                                <input type="text" class="form-control" placeholder="Observaciones" name="observaciones" value="{{old('observaciones', $articulo->observaciones)}}">
                            </div>
                        </div>
                        <br>
                        <div class="text-right m-t-15">
                            <a class='btn btn-primary form-button' href="{{ route('articulos.index') }}">Regresar</a>
                            <button class="btn btn-success form-button" id="ButtonArticuloUpdate">Actualizar</button>
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

<script src="{{asset('js/articulos/edit.js')}}"></script>
@endpush
