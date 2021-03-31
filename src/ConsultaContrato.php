<?php

namespace EEQServices;

class ConsultaContrato
{
    public function Convert($data)
    {

        $dataResponse = [];

        $data = (array) $data;

        $dataResponse['contrato'] = $data['CUENTACONTRATO'];
        $dataResponse['valor_ultima_factura'] = floatval(str_replace(',', '.', $data['VALORULTIMAFACTURA']));

        $dataResponse['fecha_vencimiento_ulima_factura'] = $data['FECVENCIULTIFACT'];
        $dataResponse['direccion'] = $data['DIRECCION'];
        $dataResponse['meses_adeudados'] = (int) str_replace(['(', ')'], '', $data['MESESADEUDADOS']);
        //$dataResponse['conexion'] = $data['conexion'];

        $dataResponse['estado_ultima_reclamacion'] = $data['ESTADORECLAMACION'] ?: null;
        $dataResponse['fecha_ultimo_pago'] = $data['FECHAULTPAGO'];
        $dataResponse['fecha_ultima_emision'] = $data['ULTEMISION'];
        //$dataResponse['nombre'] = $data['NOMBRE'];
        $dataResponse['deuda'] = $data['DEUDA'];

        return $dataResponse;
    }
}
