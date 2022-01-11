<?php

namespace App\Infile;

use App\Cliente;
use App\Abono_Maestro;
use App\Abono_Detalle;

class NotaCreditoel{

    public function generarFEL($idAbonoMaestro, $idCliente){
        $abonoMaestro = Abono_Maestro::where('id',$idAbonoMaestro)->first();

        $cliente = Cliente::where('id',$idCliente)->first();

        $abonoDetalle = Abono_Detalle::select(
            'abono_detalle.id',
            'abono_detalle.descripcion',
            'abono_detalle.total_factura',
            'abono_detalle.abono',
            'abono_detalle.saldo',
            'factura_maestro.fel_uuid',
            'factura_maestro.fel_fecha_certificacion',
            'factura_maestro.fel_serie',
            'factura_maestro.fel_numero'
        )->join(
            'factura_maestro',
            'abono_detalle.factura_maestro_id',
            '=',
            'factura_maestro.id'
        )->where(
            'abono_detalle.abono_maestro_id',
            '=',
            $abonoMaestro->id
        )->get();

        //dd($abonoDetalle);

        //SETUP INFILE
        $INFILE_USUARIO= env('INFILE_USUARIO', '');
        $INFILE_URL_FIRMA=env('INFILE_URL_FIRMA', '');
        $INFILE_URL_CERTIFICA=env('INFILE_URL_CERTIFICA', '');
        $INFILE_LLAVE_FIRMA=env('INFILE_LLAVE_FIRMA', '');
        $INFILE_LLAVE_CERTIFICA=env('INFILE_LLAVE_CERTIFICA', '');

        //Establecer timezone para Guatemala
        date_default_timezone_set('America/Guatemala');

        //DocumentoFel
        $documento_fel = new DocumentoFel();

        //Datos del Emisor
        $datos_emisor = new DatosEmisor();
	    $datos_emisor->setAfiliacionIVA("GEN");
	    $datos_emisor->setCodigoEstablecimiento(1);
	    $datos_emisor->setCodigoPostal("01002");
	    $datos_emisor->setCorreoEmisor(env('EMISOR_CORREO_ELECTRONICO', ''));
	    $datos_emisor->setDepartamento(env('EMISOR_DEPARTAMENTO', ''));
	    $datos_emisor->setMunicipio(env('EMISOR_MUNICIPIO', ''));
	    $datos_emisor->setDireccion(env('EMISOR_DIRECCION', ''));
	    $datos_emisor->setNITEmisor(env('EMISOR_NIT', ''));
	    $datos_emisor->setNombreComercial(env('EMISOR_NOMBRE_COMERCIAL', ''));
	    $datos_emisor->setNombreEmisor(env('EMISOR_NOMBRE', ''));
	    $datos_emisor->setPais("GT");
        //Agregar datos del emisor a Documento FEL
	    $documento_fel->setDatosEmisor($datos_emisor);
	    

        //Datos generales Documento Fel
        $datos_generales = new DatosGenerales();
	    $datos_generales->setCodigoMoneda("GTQ");
        $datos_generales->setFechaHoraEmision(date("c"));
        //$datos_generales->setNumeroAcceso(11111);
        $datos_generales->setTipo("NCRE");
        //Agregar Datos Generales a Documento FEL
        $documento_fel->setDatosGenerales($datos_generales);

        //Datos del Recepctor
        $idReceptor =  str_replace ( "-", '', $cliente->nit);
        $datos_receptor = new DatosReceptor();
        $datos_receptor->setCodigoPostal("01001");
        $datos_receptor->setCorreoReceptor("marvinolalez@gmail.com");
        $datos_receptor->setDepartamento("Guatemala");
        $datos_receptor->setDireccion($cliente->direccion_comercial);
        $datos_receptor->setIDReceptor($idReceptor);
        $datos_receptor->setMunicipio("Guatemala");
        $datos_receptor->setNombreReceptor($cliente->nombre_comercial);
        $datos_receptor->setPais("GT");
        //Agregar Datos del Receptor a Documento FEL
        $documento_fel->setDatosReceptor( $datos_receptor);
        

        //Datos Frases
        // $frases = new Frases();
        // $frases->setTipoFrase(1);
        // $frases->setCodigoEscenario(1);

        //Agregar Frases a Documento FEL
        // $documento_fel->setFrases($frases);

        //Detalle Factura
        $granTotal=0;
        $numeroLinea=0;
        $montoGravable=0;
        $montoImpuestos=0;
        $totalImpuestos=0;
        foreach ($abonoDetalle as $item) {
            $numeroLinea++;
            $items = new Items();
            $items->setNumeroLinea($numeroLinea);
            $items->setBienOServicio("B");
            $items->setCantidad(1);
            $items->setDescripcion($item->descripcion);
            $items->setDescuento(0);
            $items->setPrecio($item->abono);
            $items->setPrecioUnitario($item->abono);
            $items->setUnidadMedida("UND");
            $items->setTotal($item->abono);
            $montoGravable=Round(($item->abono/1.12),2);
            $montoImpuestos=($item->abono-$montoGravable);
            $totalImpuestos+=$montoImpuestos;
            $granTotal+=$item->abono;

            //Detalle de impuestos
            $impuestos_detalle = new ImpuestosDetalle();
            $impuestos_detalle->setNombreCorto("IVA");
            $impuestos_detalle->setCodigoUnidadGravable(1);
            $impuestos_detalle->setMontoGravable($montoGravable);
            $impuestos_detalle->setMontoImpuesto($montoImpuestos);

            $items->setImpuestosDetalle($impuestos_detalle);
            $documento_fel->setItems($items);
     }
     $total_impuestos = new TotalImpuestos();
     $total_impuestos->setNombreCorto("IVA");
     $total_impuestos->setTotalMontoImpuesto($totalImpuestos);
     $documento_fel->setImpuestosResumen($total_impuestos);

     $totales = new Totales();
     $totales->setGranTotal($granTotal);
     $documento_fel->setTotales($totales);


     $complemento_notas=new ComplementoNotas();
     $complemento_notas->setIdComplemento("NCRE");
     $complemento_notas->setNombreComplemento("NCRE");
     $complemento_notas->setUriComplemento("NCRE");
     $complemento_notas->setRegimenAntiguo(""); #Si es FACE COLOCAR LA PALABRA ANTIGUO
     $complemento_notas->setNumeroAutorizacionDocumentoOrigen($abonoDetalle[0]->fel_uuid); #Si es FACE COLOCAR EL NUMERO DE RESOLUCION CON LOS GUIONES
     $complemento_notas->setFechaEmisionDocumentoOrigen(substr($abonoDetalle[0]->fel_fecha_certificacion,0,10));
     $complemento_notas->setMotivoAjuste("ABONO DE NOTA DE CREDITO");
     $complemento_notas->setSerieDocumentoOrigen($abonoDetalle[0]->fel_serie);
     $complemento_notas->setNumeroDocumentoOrigen($abonoDetalle[0]->fel_numero);
     $documento_fel->setComplementos($complemento_notas);


     $adendas = new Adendas();
     $adendas->setAdenda("Cajero", "Luis Morales");
     $adendas->setAdenda("Lote", "45121");
     $adendas->setAdenda("OrdenCompra", "1041-90");
     $documento_fel->setAdenda($adendas);


      // Generacion del XML
      $generar_xml = new GenerarXml();
      $respuesta = $generar_xml->ToXml($documento_fel);

      //DATOS de conexion
      $conexion = new ConexionServiceFel();
      //$conexion->setUrl("https://certificador.feel.com.gt/fel/certificacion/v2/dte/");
      $conexion->setMetodo("POST");
      $conexion->setContentType("application/xml");
      $conexion->setUsuario("SUPLISA");
      $conexion->setLlave("0E62538ECB6AADA585C52E36B2E90B0D");
      //$conexion->setIdentificador("pruebas7");

      $firma = new FirmaEmisor();
      $xml_firmado = $firma->firmar($respuesta->getXml(), $INFILE_USUARIO, $INFILE_LLAVE_FIRMA);

      //Certificacion
      $servicio = new ServicioFel();
      $respuesta_servicio = $servicio->Certificar($conexion, $xml_firmado);
          
      $errores="";
      foreach ($respuesta_servicio->getDescripcionErrores() as $error) {
        $errores.="[".$error->mensaje_error."] ";
     }

     if(strlen($errores)>0){
        return false;
     }

     $abonoMaestro->fel_fecha_certificacion=$respuesta_servicio->getFecha();
     $abonoMaestro->fel_uuid=$respuesta_servicio->getUuid();
     $abonoMaestro->fel_serie=$respuesta_servicio->getSerie();
     $abonoMaestro->fel_numero=$respuesta_servicio->getNumero();
     $abonoMaestro->fel_xml=$respuesta_servicio->getXmlCertificado();
     $abonoMaestro->save();
     return true;
    }




    public function anularFEL($idAbonoMaestro, $idCliente){
        $abonoMaestro = Abono_Maestro::where('id',$idAbonoMaestro)->first();
        $cliente = Cliente::where('id',$idCliente)->first();

        $nitEmisor=env('EMISOR_NIT', '');
        $INFILE_USUARIO= env('INFILE_USUARIO', '');
        $INFILE_URL_FIRMA=env('INFILE_URL_FIRMA', '');
        $INFILE_URL_CERTIFICA=env('INFILE_URL_CERTIFICA', '');
        $INFILE_LLAVE_FIRMA=env('INFILE_LLAVE_FIRMA', '');
        $INFILE_LLAVE_CERTIFICA=env('INFILE_LLAVE_CERTIFICA', '');

        // $cliente = Cliente::where('id',$facturaMaestro->id)->select('nit')->first();
        $idReceptor = str_replace ( "-", '', $cliente->nit);
        date_default_timezone_set('America/Guatemala');

        $conexion = new ConexionServiceFel();
        $conexion->setMetodo("POST");
        $conexion->setContentType("application/xml");
        $conexion->setUsuario("SUPLISA");
        $conexion->setLlave("0E62538ECB6AADA585C52E36B2E90B0D");

        $anulacion_fel = new AnulacionFel();
        $anulacion_fel->setFechaEmisionDocumentoAnular($abonoMaestro->fel_fecha_certificacion);
        $anulacion_fel->setFechaHoraAnulacion(date("c"));
        $anulacion_fel->setIDReceptor($idReceptor);
        $anulacion_fel->setNITEmisor($nitEmisor);
        $anulacion_fel->setMotivoAnulacion("ANULACION DE ABONO");
        $anulacion_fel->setNumeroDocumentoAnular($abonoMaestro->fel_uuid);

        $generar_xml = new GenerarXml();
        $respuesta = $generar_xml->ToXml($anulacion_fel);

        $firma = new FirmaEmisor();
        $xml_firmado = $firma->firmar($respuesta->getXml(), $INFILE_USUARIO, $INFILE_LLAVE_FIRMA);

        $servicio = new ServicioFel();
        $respuesta_servicio = $servicio->Certificar($conexion, $xml_firmado);

        $errores="";
        foreach ($respuesta_servicio->getDescripcionErrores() as $error) {
          $errores.="[".$error->mensaje_error."] ";
        }

        if(strlen($errores)>0){
            return false;
         }

        $abonoMaestro->fel_fecha_certificacion_anula=$respuesta_servicio->getFecha();
        $abonoMaestro->fel_uuid_anula=$respuesta_servicio->getUuid();
        $abonoMaestro->fel_serie_anula=$respuesta_servicio->getSerie();
        $abonoMaestro->fel_numero_anula=$respuesta_servicio->getNumero();
        $abonoMaestro->fel_xml_anula=$respuesta_servicio->getXmlCertificado();
        $abonoMaestro->save();
        //dd($respuesta_servicio);
        return true;
    }
}
