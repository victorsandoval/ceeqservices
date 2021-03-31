<?php
namespace EEQServices;

use GuzzleHttp\Client;

class ConsultaClientes
{

    private $url = null;

    public function __construct(string $url){
        $this->url = $url;
    }
    /**
     * @param string $cedula
     * @return array
     */
    public function PorCedula(string $cedula)
    {

        $client = new Client([
            'verify' => false,
            'force_ip_resolve' => 'v4',
            'connect_timeout' => 3.14
            ]);

        $response = $client->get($this->url.'/ConsultaPorCedula', [
            'json' => [
                "cedula" => $cedula,
                "correo" => "",
                "tipoConsulta" => "cuentas"
            ]
        ]);

        $datoFinal = json_decode(utf8_encode($response->getBody()->getContents()));
        $filtered = [];

        foreach ($datoFinal as $key => $item) {
            if (is_numeric($key)) {
                $filtered[$key] = [
                    'codigo_contrato' => $key,
                    'direccion' => $item
                ];
            }
        }

        sort($filtered);
        $filtered = array_values($filtered);

        return $filtered;
    }

    public function PorContrato($contrato){

        $client = new Client([
            'verify' => false,
            'force_ip_resolve' => 'v4',
            'connect_timeout' => 3.14
        ]);

        $response = $client->get($this->url.'/ValorUltimaFactura', [
            'json' => [
                "cuentaContrato" => $contrato
            ]
        ]);

        $datoFinal = json_decode(utf8_encode($response->getBody()->getContents()));

        $convert = new ConsultaContrato();
        $dato = $convert->Convert($datoFinal);

        return ($dato);
    }

    public function dinarDapCliente($cedula){

        $client = new Client([
            'verify' => false,
            'force_ip_resolve' => 'v4',
            'connect_timeout' => 3.14
        ]);

        $response = $client->get($this->url.'/ConsultaDinardap?cedula='.$cedula);
        $datosServicio = json_decode(utf8_encode($response->getBody()->getContents()), true);

        $respuesta = [];
        $respuesta['nombres'] = $datosServicio['NOMBRE'];
        $respuesta['fecha_defuncion'] = $datosServicio['FECHADEFUNCION'];
        $respuesta['cedula'] = $datosServicio['CEDULA'];
        $respuesta['domicilio'] = $datosServicio['DOMICILIO'];
        $respuesta['calle_domicilio'] = $datosServicio['CALLESDOMICILIO'];
        $respuesta['fecha_nacimiento'] = $datosServicio['FECHANACIMIENTO'];

        return $respuesta;
    }
}
