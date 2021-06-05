<?php

use Greenter\Model\Client\Client;
use Greenter\Model\Company\Company;
use Greenter\Model\Company\Address;
use Greenter\Model\Sale\Invoice;
use Greenter\Model\Sale\SaleDetail;
use Greenter\Model\Sale\Legend;

require dirname(__FILE__) . '/vendor/autoload.php';

use Greenter\Ws\Services\SunatEndpoints;




class Envio_cpe {
   //funciones que queremos implementar en Miclase.



    function enviar($data){

        

        $return = array('estado' => false, 'msj' => '' , 'error'=> '' , 'idsave' => '');   

        $see =  new \Greenter\See();

        $see->setService(SunatEndpoints::FE_BETA);
        $see->setCertificate(file_get_contents(__DIR__.'/certificate.pem'));
        $see->setCredentials('20000000001MODDATOS', 'moddatos');


        $setTipoDoc = '0';
        $setNumDoc = '';
        $tam_doc = strlen($data['venta']['cliente_documento']) ;
        $setRznSocial = $data['venta']['cliente_razon_social'] ;

        if(  $tam_doc == 8){
            $setTipoDoc = '1';
            $setNumDoc = $data['venta']['cliente_documento'];

        } elseif(  $tam_doc == 11) {
            $setTipoDoc = '6';
            $setNumDoc = $data['venta']['cliente_documento'];
        }

        $util = Util::getInstance();

        // Cliente
        $client = new Client();
        $client->setTipoDoc($setTipoDoc)
            ->setNumDoc($setNumDoc)
            ->setRznSocial($setRznSocial);

        // Emisor
        $address = new Address();
        $address->setUbigueo('150101')
            ->setDepartamento('LIMA')
            ->setProvincia('LIMA')
            ->setDistrito('LIMA')
            ->setUrbanizacion('NONE')
            ->setDireccion('AV LS');

        $company = new Company();
        $company->setRuc('20000000001')
            ->setRazonSocial('EMPRESA SAC')
            ->setNombreComercial('EMPRESA')
            ->setAddress($address);

        $setSerie = $data['venta']['serie'] ;
        $setCorrelativo = $data['venta']['numero'] ;
        $setFechaEmision = new DateTime( $data['venta']['fecha_venta'] );

        $setMtoOperGravadas = $data['venta']['total'] ;
        $setMtoIGV = 18.00 ;
        $setTotalImpuestos = 0.00;
        $setValorVenta = $data['venta']['total'];
        $setMtoImpVenta = $data['venta']['total'];
        // Venta
        $invoice = (new Invoice())
            ->setUblVersion('2.1')
            ->setTipoOperacion('0101') // Catalog. 51
            ->setTipoDoc('01')
            ->setSerie($setSerie)
            ->setCorrelativo($setCorrelativo)
            ->setFechaEmision($setFechaEmision)
            ->setTipoMoneda('PEN')
            ->setClient($client)
            ->setMtoOperGravadas($setMtoOperGravadas)
            ->setMtoIGV($setMtoIGV)
            ->setTotalImpuestos($setTotalImpuestos)
            ->setValorVenta($setValorVenta)
            ->setMtoImpVenta($setMtoImpVenta)
            ->setCompany($company);

        $item = (new SaleDetail())
            ->setCodProducto('P001')
            ->setUnidad('NIU')
            ->setCantidad(2)
            ->setDescripcion('PRODUCTO 1')
            ->setMtoBaseIgv(100)
            ->setPorcentajeIgv(18.00) // 18%
            ->setIgv(18.00)
            ->setTipAfeIgv('10')
            ->setTotalImpuestos(18.00)
            ->setMtoValorVenta(100.00)
            ->setMtoValorUnitario(50.00)
            ->setMtoPrecioUnitario(56.00);

        $legend = (new Legend())
            ->setCode('1000')
            ->setValue('SON DOSCIENTOS TREINTA Y SEIS CON 00/100 SOLES');

        $invoice->setDetails([$item,$item])
                ->setLegends([$legend]);

        $result = $see->send($invoice);

        $util->writeXml($invoice, $see->getFactory()->getLastXml());

        //print_r($result);
        $return ['msj'] = 'Envio cpe' ;
        if ($result->isSuccess()) {

            $cdr = $result->getCdrResponse();

            //echo $cdr->getDescription();

            /**@var $res \Greenter\Model\Response\BillResult*/
            $util->writeCdr($invoice, $result->getCdrZip());

            //$util->showResponse($invoice, $cdr);//mostrar resultado
            $return['estado']=true;
            $return ['msj']=  $cdr->getDescription();

        } else {
           $return ['error'] = array($result->getError());
        }

        return $return; 
   }

    function enviar2(){

          $see =  new \Greenter\See();

    $see->setService(SunatEndpoints::FE_BETA);
    $see->setCertificate(file_get_contents(__DIR__.'/certificate.pem'));
    $see->setCredentials('20000000001MODDATOS', 'moddatos');


        $util = Util::getInstance();

        // Cliente
        $client = new Client();
        $client->setTipoDoc('6')
            ->setNumDoc('20000000001')
            ->setRznSocial('EMPRESA 1');

        // Emisor
        $address = new Address();
        $address->setUbigueo('150101')
            ->setDepartamento('LIMA')
            ->setProvincia('LIMA')
            ->setDistrito('LIMA')
            ->setUrbanizacion('NONE')
            ->setDireccion('AV LS');

        $company = new Company();
        $company->setRuc('20000000001')
            ->setRazonSocial('EMPRESA SAC')
            ->setNombreComercial('EMPRESA')
            ->setAddress($address);

        // Venta
        $invoice = (new Invoice())
            ->setUblVersion('2.1')
            ->setTipoOperacion('0101') // Catalog. 51
            ->setTipoDoc('01')
            ->setSerie('F001')
            ->setCorrelativo('1')
            ->setFechaEmision(new DateTime())
            ->setTipoMoneda('PEN')
            ->setClient($client)
            ->setMtoOperGravadas(100.00)
            ->setMtoIGV(18.00)
            ->setTotalImpuestos(18.00)
            ->setValorVenta(100.00)
            ->setMtoImpVenta(118.00)
            ->setCompany($company);

        $item = (new SaleDetail())
            ->setCodProducto('P001')
            ->setUnidad('NIU')
            ->setCantidad(2)
            ->setDescripcion('PRODUCTO 1')
            ->setMtoBaseIgv(100)
            ->setPorcentajeIgv(18.00) // 18%
            ->setIgv(18.00)
            ->setTipAfeIgv('10')
            ->setTotalImpuestos(18.00)
            ->setMtoValorVenta(100.00)
            ->setMtoValorUnitario(50.00)
            ->setMtoPrecioUnitario(56.00);

        $legend = (new Legend())
            ->setCode('1000')
            ->setValue('SON DOSCIENTOS TREINTA Y SEIS CON 00/100 SOLES');

        $invoice->setDetails([$item])
                ->setLegends([$legend]);

        $result = $see->send($invoice);

        $util->writeXml($invoice, $see->getFactory()->getLastXml());

        //print_r($result);
        if ($result->isSuccess()) {

            $cdr = $result->getCdrResponse();

            echo $cdr->getDescription();

            /**@var $res \Greenter\Model\Response\BillResult*/
            $util->writeCdr($invoice, $result->getCdrZip());

            $util->showResponse($invoice, $cdr);

        } else {
            var_dump($result->getError());
        }
   }
}

