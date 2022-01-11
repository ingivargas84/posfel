@extends('admin.layoutadmin')

@section('header')
<section class="content-header">
    <h1>
        IMPORTACIONES
        <small>Registrar una Importación</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{route('dashboard')}}"><i class="fa fa-tachometer-alt"></i> Inicio</a></li>
        <li><a href="{{route('importaciones.index')}}"><i class="fa fa-list"></i> Importaciones</a></li>
        <li class="active">Crear</li>
    </ol>
</section>
@stop

@section('content')
<form method="POST" id="ImportacionForm" action="{{route('importaciones.save')}}" autocomplete="off">
    {{csrf_field()}}
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row">
                    <div class="col-md-4 col-sm-4">
                        <label for="no_hoja">No Hoja:</label>
                        <input type="text" class="form-control" name="no_hoja" placeholder="No Hoja" id="no_hoja" value="{{{$series[0]->correlativo}}}" tabindex="1">
                    </div>
                    <div class="col-md-4 col-sm-4">
                        <label for="no_pedido">No Pedido:</label>
                        <input type="text" class="form-control" name="no_pedido" placeholder="No Pedido" id="no_pedido" tabindex="2">
                    </div>
                    <div class="col-md-4 col-sm-4">
                        <label for="orden_compra_id">Orden de Compra:</label>
                        <input type="text" class="form-control" name="orden_compra_id" placeholder="Orden de Compra" id="orden_compra_id" tabindex="3">
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-4 col-sm-4">
                            <label for="fecha">Fecha de Ingreso:</label>
                            <div class="input-group date" id="fecha">
                            <input class="form-control" name="fecha" id="fecha" placeholder="Fecha" tabindex="4">
                            <div class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></div>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-4">
                        <label for="proveedor_id">Proveedor:</label>
                        <select name="proveedor_id" class="selectpicker form-control" data-live-search="true" id="proveedor_id" tabindex="5">
                            <option value="default">Seleccione un Proveedor</option>
                            @foreach ($proveedores as $pr)
                            <option value="{{$pr->id}}">{{$pr->codigo}} - {{$pr->nombre_comercial}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4 col-sm-4">
                        <label for="poliza">No Poliza:</label>
                        <input type="text" class="form-control" name="poliza" placeholder="Poliza" id="poliza" tabindex="6">
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-4 col-sm-4">
                        <label for="no_factura">No Factura:</label>
                        <input type="text" class="form-control" name="no_factura" placeholder="No Factura" id="no_factura" tabindex="7">
                    </div>
                    <div class="col-md-4 col-sm-4">
                        <label for="tipo_mercaderia">Tipo Mercaderia:</label>
                        <input type="text" class="form-control" name="tipo_mercaderia" placeholder="Tipo Mercaderia" id="tipo_mercaderia" tabindex="8">
                    </div>
                    <div class="col-md-4 col-sm-4">
                        <label for="tipo_transporte_id">Tipo Transporte:</label>
                        <select name="tipo_transporte_id" class="form-control" id="tipo_transporte_id" tabindex="9">
                            <option value="default">Seleccione Tipo de Transporte</option>
                            @foreach ($tipo_transporte as $tt)
                            <option value="{{$tt->id}}">{{$tt->tipo_transporte}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-sm-12 text-center">
                        <h3><strong>Descripción de los Gastos CIF</strong></h3>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3 col-sm-3">
                        <label for="valor_fob">Valor FOB:</label>
                        <div class="input-group">
                            <span class="input-group-addon">$</span>
                            <input type="text" value="0" class="form-control" name="valor_fob" placeholder="Valor FOB" id="valor_fob" tabindex="10">
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-3">
                        <label for="costo_transporte">Costo Inland/Ocean Freight:</label>
                        <div class="input-group">
                            <span class="input-group-addon">$</span>
                            <input type="text" value="0" class="form-control" name="costo_transporte" placeholder="Inland/Ocean Freight" id="costo_transporte" tabindex="11">
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-3">
                        <label for="consular_fees">Consular FEES:</label>
                        <div class="input-group">
                            <span class="input-group-addon">$</span>
                            <input type="text" value="0" class="form-control" name="consular_fees" placeholder="Consular FEES" id="consular_fees" tabindex="12">
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-3">
                        <label for="bl_pc">BL/PC:</label>
                        <div class="input-group">
                            <span class="input-group-addon">$</span>
                            <input type="text" value="0" class="form-control" name="bl_pc" placeholder="BL/PC" id="bl_pc" tabindex="13">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3 col-sm-3">
                    <label for="insurance">Insurance:</label>
                        <div class="input-group">
                            <span class="input-group-addon">$</span>
                            <input type="text" value="0" class="form-control" name="insurance" placeholder="Insurance" id="insurance" tabindex="14">
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-3">
                        <label for="others">Others:</label>
                        <div class="input-group">
                            <span class="input-group-addon">$</span>
                            <input type="text" value="0" class="form-control" name="others" placeholder="Others" id="others" tabindex="15">
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-3">
                        <label for="handling_and_po">Handling And PO:</label>
                        <div class="input-group">
                            <span class="input-group-addon">$</span>
                            <input type="text" value="0" class="form-control" name="handling_and_po" placeholder="Handling And PO" id="handling_and_po" tabindex="16">
                        </div>        
                    </div>
                    <div class="col-md-3 col-sm-3">
                        <label for="total_cif">Total CIF:</label>
                        <div class="input-group">
                            <span class="input-group-addon">$</span>
                            <input type="text" class="form-control" name="total_cif" placeholder="Total CIF" id="total_cif" tabindex="17">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 col-sm-4">
                        <label for="tasa_cambio">Tasa de Cambio:</label>
                        <div class="input-group">
                            <span class="input-group-addon">Q</span>
                            <input type="text" class="form-control" name="tasa_cambio" placeholder="Tasa de Cambio" id="tasa_cambio" tabindex="18">
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-4">
                    </div>
                    <div class="col-md-4 col-sm-4">
                        <label for="quetzalizacion">Quetzalización:</label>
                        <div class="input-group">
                            <span class="input-group-addon">Q</span>
                            <input type="text" class="form-control" name="quetzalizacion" placeholder="Quetzalización" id="quetzalizacion" tabindex="19">
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-3 col-sm-3">
                        <label for="d_arancelarios_imp">Derechos Arancelarios Impuesto:</label>
                        <div class="input-group">
                            <span class="input-group-addon">Q</span>
                            <input type="text" value="0" class="form-control" name="d_arancelarios_imp" placeholder="D Arancelarios Imp" id="d_arancelarios_imp" tabindex="20">
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-3">
                        <label for="multas">Multas:</label>
                        <div class="input-group">
                            <span class="input-group-addon">Q</span>
                            <input type="text" value="0" class="form-control" name="multas" placeholder="Multas" id="multas" tabindex="21">
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-3">
                        <label for="almacenaje_algesa">Almacenaje ALGESA:</label>
                        <div class="input-group">
                            <span class="input-group-addon">Q</span>
                            <input type="text" value="0" class="form-control" name="almacenaje_algesa" placeholder="Almacenaje ALGESA" id="almacenaje_algesa" tabindex="22">
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-3">
                        <label for="marchamo">Marchamo:</label>
                        <div class="input-group">
                            <span class="input-group-addon">Q</span>
                            <input type="text" value="0" class="form-control" name="marchamo" placeholder="Marchamo" id="marchamo" tabindex="23">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-3 col-sm-3">
                        <label for="muellaje">Muellaje:</label>
                        <div class="input-group">
                            <span class="input-group-addon">Q</span>
                            <input type="text" value="0" class="form-control" name="muellaje" placeholder="Muellaje" id="muellaje" tabindex="24">
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-3">
                        <label for="fumigacion">Fumigación:</label>
                        <div class="input-group">
                            <span class="input-group-addon">Q</span>
                            <input type="text" value="0" class="form-control" name="fumigacion" placeholder="Fumigación" id="fumigacion" tabindex="25">
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-3">
                        <label for="m_documentacion">Manejo Documentación:</label>
                        <div class="input-group">
                            <span class="input-group-addon">Q</span>
                            <input type="text" value="0" class="form-control" name="m_documentacion" placeholder="M Documentación" id="m_documentacion" tabindex="26">
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-3">
                        <label for="tram_al">Tramites Almacenadora:</label>
                        <div class="input-group">
                            <span class="input-group-addon">Q</span>
                            <input type="text" value="0" class="form-control" name="tram_al" placeholder="Tram Al" id="tram_al" tabindex="27">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-3 col-sm-3">
                        <label for="hono_aa">Honorarios Agente Aduana:</label>
                        <div class="input-group">
                            <span class="input-group-addon">Q</span>
                            <input type="text" value="0" class="form-control" name="hono_aa" placeholder="Hono AA" id="hono_aa" tabindex="28">
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-3">
                        <label for="formulario">Formulario:</label>
                        <div class="input-group">
                            <span class="input-group-addon">Q</span>
                            <input type="text" value="0" class="form-control" name="formulario" placeholder="Formulario" id="formulario" tabindex="29">
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-3">
                        <label for="fl_i_c_v">FLete Interno C/V:</label>
                        <div class="input-group">
                            <span class="input-group-addon">Q</span>
                            <input type="text" value="0" class="form-control" name="fl_i_c_v" placeholder="FL I C/V" id="fl_i_c_v" tabindex="30">
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-3">
                        <label for="fl_i_a_v">FLete Interno A/V:</label>
                        <div class="input-group">
                            <span class="input-group-addon">Q</span>
                            <input type="text" value="0" class="form-control" name="fl_i_a_v" placeholder="FL I A/V" id="fl_i_a_v" tabindex="31">
                        </div>
                    </div> 
                </div>
                <div class="row">
                    <div class="col-md-3 col-sm-3">
                        <label for="fl_ch_bv">Flete C Hidalgo/BV:</label>
                        <div class="input-group">
                            <span class="input-group-addon">Q</span>
                            <input type="text" value="0" class="form-control" name="fl_ch_bv" placeholder="FL CH/BV" id="fl_ch_bv" tabindex="32">
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-3">
                        <label for="d_monta">Descarga Montacargas:</label>
                        <div class="input-group">
                            <span class="input-group-addon">Q</span>
                            <input type="text" value="0" class="form-control" name="d_monta" placeholder="D Monta" id="d_monta" tabindex="33">
                        </div>   
                    </div>   
                    <div class="col-md-3 col-sm-3">
                        <label for="viaticos">Viaticos:</label>
                        <div class="input-group">
                            <span class="input-group-addon">Q</span>
                            <input type="text" value="0" class="form-control" name="viaticos" placeholder="Viaticos" id="viaticos" tabindex="34">
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-3">
                        <label for="otros">Otros:</label>
                        <div class="input-group">
                            <span class="input-group-addon">Q</span>
                            <input type="text" value="0" class="form-control" name="otros" placeholder="Otros" id="otros" tabindex="35">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 col-sm-4">
                        <label for="costo_pbod">Costo Total Puesto en Bodegas:</label>
                        <div class="input-group">
                            <span class="input-group-addon">Q</span>
                            <input type="text" class="form-control" name="costo_pbod" placeholder="Costo Total Puesto en Bodegas" id="costo_pbod" tabindex="36">
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-4">
                    </div>
                    <div class="col-md-4 col-sm-4">
                        <label for="fac_costeo">Factor de Costeo:</label>
                        <div class="input-group">
                            <span class="input-group-addon">Q</span>
                            <input type="text" class="form-control" name="fac_costeo" placeholder="Factor de Costeo" id="fac_costeo" tabindex="37">
                        </div>
                    </div>
                </div>

                <hr>
                <div class="row">
                    <div class="col-md-4 col-sm-4">
                        <label for="articulo_id">Artículo:</label>
                        <select name="articulo_id" class="selectpicker form-control" data-live-search="true" id="articulo_id" tabindex="38">
                            <option value="default">Seleccione un Artículo</option>
                            @foreach ($articulos as $art)
                            <option value="{{$art->id}}">{{$art->codigo_articulo}} - {{$art->descripcion}}</option>
                            @endforeach
                        </select>
                        <input type="hidden" class="form-control" name="desc_art" id="desc_art" tabindex="39">
                    </div>
                    <div class="col-md-2 col-sm-2">
                        <label for="cantidad">Cantidad:</label>
                        <input type="text" class="form-control" placeholder="Cantidad" name="cantidad" id="cantidad" tabindex="40">
                    </div>
                    <div class="col-md-3 col-sm-3">
                        <label for="fob">FOB:</label>
                        <input type="number" class="form-control" placeholder="FOB" name="fob" id="fob" tabindex="41">
                    </div>
                    <div class="col-md-3 col-sm-3">
                        <label for="subtotal">Subtotal:</label>
                        <input type="number" class="form-control" placeholder="Subtotal" name="subtotal" id="subtotal" disabled tabindex="42">
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="text-left m-t-15">
                            <h3>Detalle</h3>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="text-right m-t-15" style="margin-top: 15px; margin-bottom: 10px">
                            <button id="agregar-detalle" class="btn btn-success form-button">Agregar al detalle</button>
                        </div>
                    </div>
                </div>
                <br>
                <table id="detalle-table" class="table table-striped table-bordered no-margin-bottom dt-responsive nowrap" width="100%">
                </table>
                <br>
                <div class="row">
                    <div class="col-sm-4">
                        <label for="total">Total:</label>
                        <div class="input-group">
                            <span class="input-group-addon">$</span>
                            <input type="text" class="form-control customreadonly" placeholder="Total Importación" name="total" id="total" tabindex="43">
                        </div>
                    </div>
                </div>

                <div class="text-right m-t-15">
                    <a class='btn btn-primary form-button' href="{{ route('importaciones.index') }}">Regresar</a>
                    <button id="ButtonImportacion" class="btn btn-success form-button">Guardar</button>
                </div>
                <br>

            </div>
        </div>
    </div>
</form>
<div class="loader loader-bar"></div>
@stop


@push('styles')

<style>
    div.col-md-6 {
        margin-bottom: 15px;
    }

    .customreadonly {
        background-color: #eee;
        cursor: not-allowed;
        pointer-events: none;
    }

    .switch-field {
        display: flex;
        margin-bottom: 20px;
        overflow: hidden;
    }

    .switch-field input {
        position: absolute !important;
        clip: rect(0, 0, 0, 0);
        height: 1px;
        width: 1px;
        border: 0;
        overflow: hidden;
    }

    .switch-field label {
        background-color: #e4e4e4;
        color: rgba(0, 0, 0, 0.6);
        font-size: 14px;
        line-height: 1;
        text-align: center;
        padding: 8px 16px;
        margin-right: -1px;
        border: 1px solid rgba(0, 0, 0, 0.2);
        box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.3), 0 1px rgba(255, 255, 255, 0.1);
        transition: all 0.1s ease-in-out;
        width: 50%
    }

    .switch-field label:hover {
        cursor: pointer;
    }

    .switch-field input:checked+label {
        background-color: #55bd8c;
        box-shadow: none;
    }

    .switch-field label:first-of-type {
        border-radius: 4px 0 0 4px;
    }

    .switch-field label:last-of-type {
        border-radius: 0 4px 4px 0;
    }

</style>

@endpush

@push('scripts')

<script>
    //datepicker settings
    $('#fecha').datepicker({
        language: "es",
        todayHighlight: true,
        clearBtn: true,
        format: 'dd-mm-yyyy',
        autoclose: true,
    }).datepicker("setDate", new Date());


    $("#articulo_id").change(function () {
	var articulo_id = $("#articulo_id").val();
	var url = "/movimientos/getArticulo/" + articulo_id ;
	if (articulo_id != "") {
		$.getJSON( url , function ( result ) {
			$("input[name='desc_art'] ").val(result[0].descripcion);
		});
	}
    });


    $(document).on('focusout', '#tasa_cambio', function() {
        var total_cif = parseFloat($('#total_cif').val());
        var tasa_cambio = parseFloat($('#tasa_cambio').val());

        var Quet = total_cif * tasa_cambio;

        $('#quetzalizacion').val(Quet);
    });

    $(document).on('focusout', '#valor_fob', function() {
        var vfob = parseFloat($('#valor_fob').val());
        var ct = parseFloat($('#costo_transporte').val());
        var cf = parseFloat($('#consular_fees').val());
        var blpc = parseFloat($('#bl_pc').val());
        var ins = parseFloat($('#insurance').val());
        var oth = parseFloat($('#others').val());
        var hap = parseFloat($('#handling_and_po').val());

        var total_cif = ct + cf + blpc + ins + oth + hap + vfob;

        $('#total_cif').val(total_cif);
    });


    $(document).on('focusout', '#costo_transporte', function() {
        var vfob = parseFloat($('#valor_fob').val());
        var ct = parseFloat($('#costo_transporte').val());
        var cf = parseFloat($('#consular_fees').val());
        var blpc = parseFloat($('#bl_pc').val());
        var ins = parseFloat($('#insurance').val());
        var oth = parseFloat($('#others').val());
        var hap = parseFloat($('#handling_and_po').val());

        var total_cif = ct + cf + blpc + ins + oth + hap + vfob;

        $('#total_cif').val(total_cif);
    });

    $(document).on('focusout', '#consular_fees', function() {
        var vfob = parseFloat($('#valor_fob').val());
        var ct = parseFloat($('#costo_transporte').val());
        var cf = parseFloat($('#consular_fees').val());
        var blpc = parseFloat($('#bl_pc').val());
        var ins = parseFloat($('#insurance').val());
        var oth = parseFloat($('#others').val());
        var hap = parseFloat($('#handling_and_po').val());

        var total_cif = ct + cf + blpc + ins + oth + hap + vfob;

        $('#total_cif').val(total_cif);
    });

    $(document).on('focusout', '#bl_pc', function() {
        var vfob = parseFloat($('#valor_fob').val());
        var ct = parseFloat($('#costo_transporte').val());
        var cf = parseFloat($('#consular_fees').val());
        var blpc = parseFloat($('#bl_pc').val());
        var ins = parseFloat($('#insurance').val());
        var oth = parseFloat($('#others').val());
        var hap = parseFloat($('#handling_and_po').val());

        var total_cif = ct + cf + blpc + ins + oth + hap + vfob;

        $('#total_cif').val(total_cif);
    });

    $(document).on('focusout', '#insurance', function() {
        var vfob = parseFloat($('#valor_fob').val());
        var ct = parseFloat($('#costo_transporte').val());
        var cf = parseFloat($('#consular_fees').val());
        var blpc = parseFloat($('#bl_pc').val());
        var ins = parseFloat($('#insurance').val());
        var oth = parseFloat($('#others').val());
        var hap = parseFloat($('#handling_and_po').val());

        var total_cif = ct + cf + blpc + ins + oth + hap + vfob;

        $('#total_cif').val(total_cif);
    });

    $(document).on('focusout', '#others', function() {
        var vfob = parseFloat($('#valor_fob').val());
        var ct = parseFloat($('#costo_transporte').val());
        var cf = parseFloat($('#consular_fees').val());
        var blpc = parseFloat($('#bl_pc').val());
        var ins = parseFloat($('#insurance').val());
        var oth = parseFloat($('#others').val());
        var hap = parseFloat($('#handling_and_po').val());

        var total_cif = ct + cf + blpc + ins + oth + hap + vfob;

        $('#total_cif').val(total_cif);
    });

    $(document).on('focusout', '#handling_and_po', function() {
        var vfob = parseFloat($('#valor_fob').val());
        var ct = parseFloat($('#costo_transporte').val());
        var cf = parseFloat($('#consular_fees').val());
        var blpc = parseFloat($('#bl_pc').val());
        var ins = parseFloat($('#insurance').val());
        var oth = parseFloat($('#others').val());
        var hap = parseFloat($('#handling_and_po').val());

        var total_cif = ct + cf + blpc + ins + oth + hap + vfob;

        $('#total_cif').val(total_cif);
    });

    $(document).on('focusout', '#d_arancelarios_imp', function() {
        var que = parseFloat($('#quetzalizacion').val());
        var dai = parseFloat($('#d_arancelarios_imp').val());
        var mul = parseFloat($('#multas').val());
        var alm = parseFloat($('#almacenaje_algesa').val());
        var mar = parseFloat($('#marchamo').val());
        var mue = parseFloat($('#muellaje').val());
        var fum = parseFloat($('#fumigacion').val());
        var mdo = parseFloat($('#m_documentacion').val());
        var tra = parseFloat($('#tram_al').val());
        var hon = parseFloat($('#hono_aa').val());
        var frm = parseFloat($('#formulario').val());
        var fla = parseFloat($('#fl_i_a_v').val());
        var flc = parseFloat($('#fl_i_c_v').val());
        var flh = parseFloat($('#fl_ch_bv').val());
        var dmo = parseFloat($('#d_monta').val());
        var via = parseFloat($('#viaticos').val());
        var otr = parseFloat($('#otros').val());

        var tasa_cambio = parseFloat($('#tasa_cambio').val());
        var vfob = parseFloat($('#valor_fob').val());

        var costo_totbod = que+dai+mul+alm+mar+mue+fum+mdo+tra+hon+frm+fla+flc+flh+dmo+via+otr;
        var fac_costeo =  (costo_totbod + (vfob * tasa_cambio)) / vfob;
 
        $('#costo_pbod').val(costo_totbod);
        $('#fac_costeo').val(fac_costeo);
    });

    $(document).on('focusout', '#multas', function() {
        var que = parseFloat($('#quetzalizacion').val());
        var dai = parseFloat($('#d_arancelarios_imp').val());
        var mul = parseFloat($('#multas').val());
        var alm = parseFloat($('#almacenaje_algesa').val());
        var mar = parseFloat($('#marchamo').val());
        var mue = parseFloat($('#muellaje').val());
        var fum = parseFloat($('#fumigacion').val());
        var mdo = parseFloat($('#m_documentacion').val());
        var tra = parseFloat($('#tram_al').val());
        var hon = parseFloat($('#hono_aa').val());
        var frm = parseFloat($('#formulario').val());
        var fla = parseFloat($('#fl_i_a_v').val());
        var flc = parseFloat($('#fl_i_c_v').val());
        var flh = parseFloat($('#fl_ch_bv').val());
        var dmo = parseFloat($('#d_monta').val());
        var via = parseFloat($('#viaticos').val());
        var otr = parseFloat($('#otros').val());

        var tasa_cambio = parseFloat($('#tasa_cambio').val());
        var vfob = parseFloat($('#valor_fob').val());

        var costo_totbod = que+dai+mul+alm+mar+mue+fum+mdo+tra+hon+frm+fla+flc+flh+dmo+via+otr;
        var fac_costeo =  (costo_totbod + (vfob * tasa_cambio)) / vfob;
 
        $('#costo_pbod').val(costo_totbod);
        $('#fac_costeo').val(fac_costeo);
    });

    $(document).on('focusout', '#almacenaje_algesa', function() {
        var que = parseFloat($('#quetzalizacion').val());
        var dai = parseFloat($('#d_arancelarios_imp').val());
        var mul = parseFloat($('#multas').val());
        var alm = parseFloat($('#almacenaje_algesa').val());
        var mar = parseFloat($('#marchamo').val());
        var mue = parseFloat($('#muellaje').val());
        var fum = parseFloat($('#fumigacion').val());
        var mdo = parseFloat($('#m_documentacion').val());
        var tra = parseFloat($('#tram_al').val());
        var hon = parseFloat($('#hono_aa').val());
        var frm = parseFloat($('#formulario').val());
        var fla = parseFloat($('#fl_i_a_v').val());
        var flc = parseFloat($('#fl_i_c_v').val());
        var flh = parseFloat($('#fl_ch_bv').val());
        var dmo = parseFloat($('#d_monta').val());
        var via = parseFloat($('#viaticos').val());
        var otr = parseFloat($('#otros').val());

        var tasa_cambio = parseFloat($('#tasa_cambio').val());
        var vfob = parseFloat($('#valor_fob').val());

        var costo_totbod = que+dai+mul+alm+mar+mue+fum+mdo+tra+hon+frm+fla+flc+flh+dmo+via+otr;
        var fac_costeo =  (costo_totbod + (vfob * tasa_cambio)) / vfob;
 
        $('#costo_pbod').val(costo_totbod);
        $('#fac_costeo').val(fac_costeo);
    });

    $(document).on('focusout', '#marchamo', function() {
        var que = parseFloat($('#quetzalizacion').val());
        var dai = parseFloat($('#d_arancelarios_imp').val());
        var mul = parseFloat($('#multas').val());
        var alm = parseFloat($('#almacenaje_algesa').val());
        var mar = parseFloat($('#marchamo').val());
        var mue = parseFloat($('#muellaje').val());
        var fum = parseFloat($('#fumigacion').val());
        var mdo = parseFloat($('#m_documentacion').val());
        var tra = parseFloat($('#tram_al').val());
        var hon = parseFloat($('#hono_aa').val());
        var frm = parseFloat($('#formulario').val());
        var fla = parseFloat($('#fl_i_a_v').val());
        var flc = parseFloat($('#fl_i_c_v').val());
        var flh = parseFloat($('#fl_ch_bv').val());
        var dmo = parseFloat($('#d_monta').val());
        var via = parseFloat($('#viaticos').val());
        var otr = parseFloat($('#otros').val());

        var tasa_cambio = parseFloat($('#tasa_cambio').val());
        var vfob = parseFloat($('#valor_fob').val());

        var costo_totbod = que+dai+mul+alm+mar+mue+fum+mdo+tra+hon+frm+fla+flc+flh+dmo+via+otr;
        var fac_costeo =  (costo_totbod + (vfob * tasa_cambio)) / vfob;
 
        $('#costo_pbod').val(costo_totbod);
        $('#fac_costeo').val(fac_costeo);
    });

    $(document).on('focusout', '#muellaje', function() {
        var que = parseFloat($('#quetzalizacion').val());
        var dai = parseFloat($('#d_arancelarios_imp').val());
        var mul = parseFloat($('#multas').val());
        var alm = parseFloat($('#almacenaje_algesa').val());
        var mar = parseFloat($('#marchamo').val());
        var mue = parseFloat($('#muellaje').val());
        var fum = parseFloat($('#fumigacion').val());
        var mdo = parseFloat($('#m_documentacion').val());
        var tra = parseFloat($('#tram_al').val());
        var hon = parseFloat($('#hono_aa').val());
        var frm = parseFloat($('#formulario').val());
        var fla = parseFloat($('#fl_i_a_v').val());
        var flc = parseFloat($('#fl_i_c_v').val());
        var flh = parseFloat($('#fl_ch_bv').val());
        var dmo = parseFloat($('#d_monta').val());
        var via = parseFloat($('#viaticos').val());
        var otr = parseFloat($('#otros').val());

        var tasa_cambio = parseFloat($('#tasa_cambio').val());
        var vfob = parseFloat($('#valor_fob').val());

        var costo_totbod = que+dai+mul+alm+mar+mue+fum+mdo+tra+hon+frm+fla+flc+flh+dmo+via+otr;
        var fac_costeo =  (costo_totbod + (vfob * tasa_cambio)) / vfob;
 
        $('#costo_pbod').val(costo_totbod);
        $('#fac_costeo').val(fac_costeo);
    });

    $(document).on('focusout', '#fumigacion', function() {
        var que = parseFloat($('#quetzalizacion').val());
        var dai = parseFloat($('#d_arancelarios_imp').val());
        var mul = parseFloat($('#multas').val());
        var alm = parseFloat($('#almacenaje_algesa').val());
        var mar = parseFloat($('#marchamo').val());
        var mue = parseFloat($('#muellaje').val());
        var fum = parseFloat($('#fumigacion').val());
        var mdo = parseFloat($('#m_documentacion').val());
        var tra = parseFloat($('#tram_al').val());
        var hon = parseFloat($('#hono_aa').val());
        var frm = parseFloat($('#formulario').val());
        var fla = parseFloat($('#fl_i_a_v').val());
        var flc = parseFloat($('#fl_i_c_v').val());
        var flh = parseFloat($('#fl_ch_bv').val());
        var dmo = parseFloat($('#d_monta').val());
        var via = parseFloat($('#viaticos').val());
        var otr = parseFloat($('#otros').val());

        var tasa_cambio = parseFloat($('#tasa_cambio').val());
        var vfob = parseFloat($('#valor_fob').val());

        var costo_totbod = que+dai+mul+alm+mar+mue+fum+mdo+tra+hon+frm+fla+flc+flh+dmo+via+otr;
        var fac_costeo =  (costo_totbod + (vfob * tasa_cambio)) / vfob;
 
        $('#costo_pbod').val(costo_totbod);
        $('#fac_costeo').val(fac_costeo);
    });

    $(document).on('focusout', '#m_documentacion', function() {
        var que = parseFloat($('#quetzalizacion').val());
        var dai = parseFloat($('#d_arancelarios_imp').val());
        var mul = parseFloat($('#multas').val());
        var alm = parseFloat($('#almacenaje_algesa').val());
        var mar = parseFloat($('#marchamo').val());
        var mue = parseFloat($('#muellaje').val());
        var fum = parseFloat($('#fumigacion').val());
        var mdo = parseFloat($('#m_documentacion').val());
        var tra = parseFloat($('#tram_al').val());
        var hon = parseFloat($('#hono_aa').val());
        var frm = parseFloat($('#formulario').val());
        var fla = parseFloat($('#fl_i_a_v').val());
        var flc = parseFloat($('#fl_i_c_v').val());
        var flh = parseFloat($('#fl_ch_bv').val());
        var dmo = parseFloat($('#d_monta').val());
        var via = parseFloat($('#viaticos').val());
        var otr = parseFloat($('#otros').val());

        var tasa_cambio = parseFloat($('#tasa_cambio').val());
        var vfob = parseFloat($('#valor_fob').val());

        var costo_totbod = que+dai+mul+alm+mar+mue+fum+mdo+tra+hon+frm+fla+flc+flh+dmo+via+otr;
        var fac_costeo =  (costo_totbod + (vfob * tasa_cambio)) / vfob;
 
        $('#costo_pbod').val(costo_totbod);
        $('#fac_costeo').val(fac_costeo);
    });

    $(document).on('focusout', '#tram_al', function() {
        var que = parseFloat($('#quetzalizacion').val());
        var dai = parseFloat($('#d_arancelarios_imp').val());
        var mul = parseFloat($('#multas').val());
        var alm = parseFloat($('#almacenaje_algesa').val());
        var mar = parseFloat($('#marchamo').val());
        var mue = parseFloat($('#muellaje').val());
        var fum = parseFloat($('#fumigacion').val());
        var mdo = parseFloat($('#m_documentacion').val());
        var tra = parseFloat($('#tram_al').val());
        var hon = parseFloat($('#hono_aa').val());
        var frm = parseFloat($('#formulario').val());
        var fla = parseFloat($('#fl_i_a_v').val());
        var flc = parseFloat($('#fl_i_c_v').val());
        var flh = parseFloat($('#fl_ch_bv').val());
        var dmo = parseFloat($('#d_monta').val());
        var via = parseFloat($('#viaticos').val());
        var otr = parseFloat($('#otros').val());

        var tasa_cambio = parseFloat($('#tasa_cambio').val());
        var vfob = parseFloat($('#valor_fob').val());

        var costo_totbod = que+dai+mul+alm+mar+mue+fum+mdo+tra+hon+frm+fla+flc+flh+dmo+via+otr;
        var fac_costeo =  (costo_totbod + (vfob * tasa_cambio)) / vfob;
 
        $('#costo_pbod').val(costo_totbod);
        $('#fac_costeo').val(fac_costeo);
    });

    $(document).on('focusout', '#hono_aa', function() {
        var que = parseFloat($('#quetzalizacion').val());
        var dai = parseFloat($('#d_arancelarios_imp').val());
        var mul = parseFloat($('#multas').val());
        var alm = parseFloat($('#almacenaje_algesa').val());
        var mar = parseFloat($('#marchamo').val());
        var mue = parseFloat($('#muellaje').val());
        var fum = parseFloat($('#fumigacion').val());
        var mdo = parseFloat($('#m_documentacion').val());
        var tra = parseFloat($('#tram_al').val());
        var hon = parseFloat($('#hono_aa').val());
        var frm = parseFloat($('#formulario').val());
        var fla = parseFloat($('#fl_i_a_v').val());
        var flc = parseFloat($('#fl_i_c_v').val());
        var flh = parseFloat($('#fl_ch_bv').val());
        var dmo = parseFloat($('#d_monta').val());
        var via = parseFloat($('#viaticos').val());
        var otr = parseFloat($('#otros').val());

        var tasa_cambio = parseFloat($('#tasa_cambio').val());
        var vfob = parseFloat($('#valor_fob').val());

        var costo_totbod = que+dai+mul+alm+mar+mue+fum+mdo+tra+hon+frm+fla+flc+flh+dmo+via+otr;
        var fac_costeo =  (costo_totbod + (vfob * tasa_cambio)) / vfob;
 
        $('#costo_pbod').val(costo_totbod);
        $('#fac_costeo').val(fac_costeo);
    });

    $(document).on('focusout', '#formulario', function() {
        var que = parseFloat($('#quetzalizacion').val());
        var dai = parseFloat($('#d_arancelarios_imp').val());
        var mul = parseFloat($('#multas').val());
        var alm = parseFloat($('#almacenaje_algesa').val());
        var mar = parseFloat($('#marchamo').val());
        var mue = parseFloat($('#muellaje').val());
        var fum = parseFloat($('#fumigacion').val());
        var mdo = parseFloat($('#m_documentacion').val());
        var tra = parseFloat($('#tram_al').val());
        var hon = parseFloat($('#hono_aa').val());
        var frm = parseFloat($('#formulario').val());
        var fla = parseFloat($('#fl_i_a_v').val());
        var flc = parseFloat($('#fl_i_c_v').val());
        var flh = parseFloat($('#fl_ch_bv').val());
        var dmo = parseFloat($('#d_monta').val());
        var via = parseFloat($('#viaticos').val());
        var otr = parseFloat($('#otros').val());

        var tasa_cambio = parseFloat($('#tasa_cambio').val());
        var vfob = parseFloat($('#valor_fob').val());

        var costo_totbod = que+dai+mul+alm+mar+mue+fum+mdo+tra+hon+frm+fla+flc+flh+dmo+via+otr;
        var fac_costeo =  (costo_totbod + (vfob * tasa_cambio)) / vfob;
 
        $('#costo_pbod').val(costo_totbod);
        $('#fac_costeo').val(fac_costeo);
    });

    $(document).on('focusout', '#fl_i_c_v', function() {
        var que = parseFloat($('#quetzalizacion').val());
        var dai = parseFloat($('#d_arancelarios_imp').val());
        var mul = parseFloat($('#multas').val());
        var alm = parseFloat($('#almacenaje_algesa').val());
        var mar = parseFloat($('#marchamo').val());
        var mue = parseFloat($('#muellaje').val());
        var fum = parseFloat($('#fumigacion').val());
        var mdo = parseFloat($('#m_documentacion').val());
        var tra = parseFloat($('#tram_al').val());
        var hon = parseFloat($('#hono_aa').val());
        var frm = parseFloat($('#formulario').val());
        var fla = parseFloat($('#fl_i_a_v').val());
        var flc = parseFloat($('#fl_i_c_v').val());
        var flh = parseFloat($('#fl_ch_bv').val());
        var dmo = parseFloat($('#d_monta').val());
        var via = parseFloat($('#viaticos').val());
        var otr = parseFloat($('#otros').val());

        var tasa_cambio = parseFloat($('#tasa_cambio').val());
        var vfob = parseFloat($('#valor_fob').val());

        var costo_totbod = que+dai+mul+alm+mar+mue+fum+mdo+tra+hon+frm+fla+flc+flh+dmo+via+otr;
        var fac_costeo =  (costo_totbod + (vfob * tasa_cambio)) / vfob;
 
        $('#costo_pbod').val(costo_totbod);
        $('#fac_costeo').val(fac_costeo);
    });

    $(document).on('focusout', '#fl_i_a_v', function() {
        var que = parseFloat($('#quetzalizacion').val());
        var dai = parseFloat($('#d_arancelarios_imp').val());
        var mul = parseFloat($('#multas').val());
        var alm = parseFloat($('#almacenaje_algesa').val());
        var mar = parseFloat($('#marchamo').val());
        var mue = parseFloat($('#muellaje').val());
        var fum = parseFloat($('#fumigacion').val());
        var mdo = parseFloat($('#m_documentacion').val());
        var tra = parseFloat($('#tram_al').val());
        var hon = parseFloat($('#hono_aa').val());
        var frm = parseFloat($('#formulario').val());
        var fla = parseFloat($('#fl_i_a_v').val());
        var flc = parseFloat($('#fl_i_c_v').val());
        var flh = parseFloat($('#fl_ch_bv').val());
        var dmo = parseFloat($('#d_monta').val());
        var via = parseFloat($('#viaticos').val());
        var otr = parseFloat($('#otros').val());

        var tasa_cambio = parseFloat($('#tasa_cambio').val());
        var vfob = parseFloat($('#valor_fob').val());

        var costo_totbod = que+dai+mul+alm+mar+mue+fum+mdo+tra+hon+frm+fla+flc+flh+dmo+via+otr;
        var fac_costeo =  (costo_totbod + (vfob * tasa_cambio)) / vfob;
 
        $('#costo_pbod').val(costo_totbod);
        $('#fac_costeo').val(fac_costeo);
    });

    $(document).on('focusout', '#fl_ch_bv', function() {
        var que = parseFloat($('#quetzalizacion').val());
        var dai = parseFloat($('#d_arancelarios_imp').val());
        var mul = parseFloat($('#multas').val());
        var alm = parseFloat($('#almacenaje_algesa').val());
        var mar = parseFloat($('#marchamo').val());
        var mue = parseFloat($('#muellaje').val());
        var fum = parseFloat($('#fumigacion').val());
        var mdo = parseFloat($('#m_documentacion').val());
        var tra = parseFloat($('#tram_al').val());
        var hon = parseFloat($('#hono_aa').val());
        var frm = parseFloat($('#formulario').val());
        var fla = parseFloat($('#fl_i_a_v').val());
        var flc = parseFloat($('#fl_i_c_v').val());
        var flh = parseFloat($('#fl_ch_bv').val());
        var dmo = parseFloat($('#d_monta').val());
        var via = parseFloat($('#viaticos').val());
        var otr = parseFloat($('#otros').val());

        var tasa_cambio = parseFloat($('#tasa_cambio').val());
        var vfob = parseFloat($('#valor_fob').val());

        var costo_totbod = que+dai+mul+alm+mar+mue+fum+mdo+tra+hon+frm+fla+flc+flh+dmo+via+otr;
        var fac_costeo =  (costo_totbod + (vfob * tasa_cambio)) / vfob;
 
        $('#costo_pbod').val(costo_totbod);
        $('#fac_costeo').val(fac_costeo);
    });

    $(document).on('focusout', '#d_monta', function() {
        var que = parseFloat($('#quetzalizacion').val());
        var dai = parseFloat($('#d_arancelarios_imp').val());
        var mul = parseFloat($('#multas').val());
        var alm = parseFloat($('#almacenaje_algesa').val());
        var mar = parseFloat($('#marchamo').val());
        var mue = parseFloat($('#muellaje').val());
        var fum = parseFloat($('#fumigacion').val());
        var mdo = parseFloat($('#m_documentacion').val());
        var tra = parseFloat($('#tram_al').val());
        var hon = parseFloat($('#hono_aa').val());
        var frm = parseFloat($('#formulario').val());
        var fla = parseFloat($('#fl_i_a_v').val());
        var flc = parseFloat($('#fl_i_c_v').val());
        var flh = parseFloat($('#fl_ch_bv').val());
        var dmo = parseFloat($('#d_monta').val());
        var via = parseFloat($('#viaticos').val());
        var otr = parseFloat($('#otros').val());

        var tasa_cambio = parseFloat($('#tasa_cambio').val());
        var vfob = parseFloat($('#valor_fob').val());

        var costo_totbod = que+dai+mul+alm+mar+mue+fum+mdo+tra+hon+frm+fla+flc+flh+dmo+via+otr;
        var fac_costeo =  (costo_totbod + (vfob * tasa_cambio)) / vfob;
 
        $('#costo_pbod').val(costo_totbod);
        $('#fac_costeo').val(fac_costeo);
    });

    $(document).on('focusout', '#viaticos', function() {
        var que = parseFloat($('#quetzalizacion').val());
        var dai = parseFloat($('#d_arancelarios_imp').val());
        var mul = parseFloat($('#multas').val());
        var alm = parseFloat($('#almacenaje_algesa').val());
        var mar = parseFloat($('#marchamo').val());
        var mue = parseFloat($('#muellaje').val());
        var fum = parseFloat($('#fumigacion').val());
        var mdo = parseFloat($('#m_documentacion').val());
        var tra = parseFloat($('#tram_al').val());
        var hon = parseFloat($('#hono_aa').val());
        var frm = parseFloat($('#formulario').val());
        var fla = parseFloat($('#fl_i_a_v').val());
        var flc = parseFloat($('#fl_i_c_v').val());
        var flh = parseFloat($('#fl_ch_bv').val());
        var dmo = parseFloat($('#d_monta').val());
        var via = parseFloat($('#viaticos').val());
        var otr = parseFloat($('#otros').val());

        var tasa_cambio = parseFloat($('#tasa_cambio').val());
        var vfob = parseFloat($('#valor_fob').val());

        var costo_totbod = que+dai+mul+alm+mar+mue+fum+mdo+tra+hon+frm+fla+flc+flh+dmo+via+otr;
        var fac_costeo =  (costo_totbod + (vfob * tasa_cambio)) / vfob;
 
        $('#costo_pbod').val(costo_totbod);
        $('#fac_costeo').val(fac_costeo);
    });

    $(document).on('focusout', '#otros', function() {
        var que = parseFloat($('#quetzalizacion').val());
        var dai = parseFloat($('#d_arancelarios_imp').val());
        var mul = parseFloat($('#multas').val());
        var alm = parseFloat($('#almacenaje_algesa').val());
        var mar = parseFloat($('#marchamo').val());
        var mue = parseFloat($('#muellaje').val());
        var fum = parseFloat($('#fumigacion').val());
        var mdo = parseFloat($('#m_documentacion').val());
        var tra = parseFloat($('#tram_al').val());
        var hon = parseFloat($('#hono_aa').val());
        var frm = parseFloat($('#formulario').val());
        var fla = parseFloat($('#fl_i_a_v').val());
        var flc = parseFloat($('#fl_i_c_v').val());
        var flh = parseFloat($('#fl_ch_bv').val());
        var dmo = parseFloat($('#d_monta').val());
        var via = parseFloat($('#viaticos').val());
        var otr = parseFloat($('#otros').val());

        var tasa_cambio = parseFloat($('#tasa_cambio').val());
        var vfob = parseFloat($('#valor_fob').val());

        var costo_totbod = que+dai+mul+alm+mar+mue+fum+mdo+tra+hon+frm+fla+flc+flh+dmo+via+otr;
        var fac_costeo =  (costo_totbod + (vfob * tasa_cambio)) / vfob;
 
        $('#costo_pbod').val(costo_totbod);
        $('#fac_costeo').val(fac_costeo);
    });

    $(document).on('focusout', '#fob', function() {
        $('#subtotal').val(parseInt($('#cantidad').val())*parseFloat($('#fob').val()));
    });

    function chkflds() {
        if ($('#cantidad').val() && $('#fob').val()) {
            return true
        } else {
            return false
        }
    }

    $('#agregar-detalle').click(function(e) {
        e.preventDefault();
        if (chkflds()) {
            //calculates the subtotal
            var subt = parseFloat($('#fob').val()) * parseFloat($('#cantidad').val());
            //limits subtotal decimal places to two
            subt = subt.toFixed(2);
            //adds the form data to the table
            detalle_table.row.add({
                'articulo_id': $('#articulo_id').val(),
                'articulo': $('#desc_art').val(),
                'cantidad': $('#cantidad').val(),
                'fob': $('#fob').val(),
                'subtotal': subt
            }).draw();
            //adds all subtotal row data and sets the total input
            var total = 0;
            detalle_table.column(4).data().each(function(value, index) {
                total = total + parseFloat(value);
                // parseFloat(total);
                $('#total').val(total.toFixed(2));
                $('#total-error').remove();
            });
            //resets form data
            $('#articulo_id').val('default');
            $('#desc_art').val(null);
            $('#cantidad').val(null);
            $('#fob').val(null);
            $('#subtotal').val(null);
        } else {
            alertify.set('notifier', 'position', 'top-center');
            alertify.error('Debe seleccionar un artículo, ingresar cantidad o precio')
        }
    });



    $(document).on('click', '#ButtonImportacion', function(e) {
        e.preventDefault();
        if ($('#ImportacionForm').valid()) {
            var arr1 = $('#ImportacionForm').serializeArray();
            var arr2 = detalle_table.rows().data().toArray();
            var arr3 = arr1.concat(arr2);

            $.ajax({
                type: 'POST',
                url: "{{route('importaciones.save')}}",
                headers: {
                    'X-CSRF-TOKEN': $('#tokenReset').val(), 
                },
                data: JSON.stringify(arr3), 
                dataType: 'json',
                success: function() {
                    $('#no_hoja').val(null);
                    $('#no_pedido').val(null);
                    $('#fecha').val(null);
                    $('#orden_compra_id').val(null);
                    $('#proveedor_id').val('default');
                    $('#poliza').val(null);
                    $('#tipo_transporte_id').val('default');
                    $('#no_factura').val(null);
                    $('#tipo_mercaderia').val(null);
                    $('#valor_fob').val(null);
                    $('#tasa_cambio').val(null);
                    $('#consular_fees').val(null);
                    $('#insurance').val(null);
                    $('#handing_and_po').val(null);
                    $('#bl_pc').val(null);
                    $('#others').val(null);
                    $('#d_arancelarios_imp').val(null);
                    $('#almacenaje_algesa').val(null);
                    $('#muellaje').val(null);
                    $('#tram_al').val(null);
                    $('#fl_i_a_v').val(null);
                    $('#d_monta').val(null);
                    $('#multas').val(null);
                    $('#marchamo').val(null);
                    $('#m_documentacion').val(null);
                    $('#formulario').val(null);
                    $('#fl_i_c_v').val(null);
                    $('#otros').val(null);
                    $('#fumigacion').val(null);
                    $('#hono_aa').val(null);
                    $('#fl_ch_bv').val(null);
                    $('#viaticos').val(null);
                    $('#articulo_id').val('default');
                    $('#cantidad').val(null);
                    $('#fob').val(null);
                    $('#subtotal').val(null);
                    $('#total').val(null);
                    detalle_table.rows().remove().draw();
                    window.location.assign('/importaciones')
                },
                error: function() {
                    alertify.set('notifier', 'position', 'top-center');
                    alertify.error('Hubo un error al registrar la importación')
                }
            })
        }
    });

</script>

<script src="{{asset('js/importaciones/detalle.js')}}"></script>{{-- datatable --}}
<script src="{{asset('js/importaciones/create.js')}}"></script>{{-- validator --}}
@endpush
