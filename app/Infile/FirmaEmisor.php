<?php

namespace App\Infile;

class FirmaEmisor {
		 public function firmar( $xml, $aliaspfx, $llave_pfx) {
		 	$url_servicio_firma = "https://signer-emisores.feel.com.gt/sign_solicitud_firmas/firma_xml";

        	$es_anulacion = "N";

        	if (strpos($xml, 'GTAnulacionDocumento') !== false) {
            	$es_anulacion = "S";
            }

      		$archivo_xml =  base64_encode($xml);


            $body = [
                'llave' => $llave_pfx,
                'archivo' => $archivo_xml,
                'codigo' => "n/a",
                'alias' => $aliaspfx,
                'es_anulacion' => $es_anulacion
            ];
            

        $json_body = json_encode( $body);

        $response = \Httpful\Request::post($url_servicio_firma)
               ->sendsJson()
               ->body($json_body)
               ->send();
               

           return base64_decode($response->body->archivo);
		 }
	}
?>
