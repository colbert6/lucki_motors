<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
require_once dirname(__FILE__) . '/tcpdf/tcpdf.php';
 
class Pdf_documentacion extends TCPDF
{
    function __construct($orientation='P', $unit='mm', $format='A4', $unicode=true, $encoding='UTF-8', $diskcache=false, $pdfa=false)
    {
        
        $this->format = $format ;
        $this->orientation = $orientation ;

        if( $orientation == 'L' ){
            $this->max_width = 287;  
            $this->max_heigth = 200;   
        }
        if( $format == 'Ticket_A' ){
            $format = array(60, 150);
            $this->max_width = 50;   
        }


        parent::__construct($orientation, $unit, $format, $unicode, $encoding, $diskcache, $pdfa);

        $MY_controller = & get_instance();
        //Parametros de la cabecera
        $this->sistema = $MY_controller->sistema ;
        $this->logo_empresa = $MY_controller->logo_empresa ;
        $this->razon_social = $MY_controller->razon_social ;
        $this->ruc = $MY_controller->ruc ;
        $this->rubro = $MY_controller->rubro ;
        $this->direccion = $MY_controller->direccion;
        $this->contacto = $MY_controller->contacto ;
    }

    public $motivo = 'venta';
    public $max_width = 200;
    public $max_heigth = 287;
    public $h_footer = -15;

    public $orientation ;
    public $format  ;

    public $sistema;

    public $logo_empresa;
    public $razon_social;
    public $ruc;
    public $rubro;
    public $direccion;
    public $contacto;

    public $tipo_documento;
    public $nro_documento;

    /* ---Sectores del comprobante ---*/

    public $logo_data = array ( 'mostrar'=> true , 'w'=> 40 , 'y' => 20);
    public $empresa_data = array ( 'align'=> 'J', 'w'=> 100 , 'ln' => 0 , 'font_h'=> 9 );
    public $comprobante_id = array ( 'border' => 1,'w' => 50, 'ln'=> 1, 'font_h'=> 10 );       
    public $receptor_data = array ( 'max_col'=>0,'border' => 1, 'ln' => 1 ,'w' => 200, 'font_h'=> 10);       
    public $comprobante_data_title = array ( 'align'=>'C' , 'border' => 0, 'ln' => 1 ,'w' => 190, 'font_h'=> 14);
    public $comprobante_data = array ( 'align'=>'L' ,'border' => 1, 'ln' => 1 ,'w' => 190, 'font_h'=> 12);      

    public $comprobante_table_head = array('font_h'=> 10 , 'max_w' => 200, 'border'=>1 , 'h'=>5 );     
    public $comprobante_table_body =array('font_h'=> 10 , 'border'=>'LR' , 'h'=>5 );      
    public $comprobante_table_footer_letras =array('w'=> 130 , 'border'=>1 , 'h'=>5 , 'ln' => false);           
    public $comprobante_table_footer_totales =array( 'align'=> 'R','w' => 70,'border'=>1 , 'h'=>5 , 'ln'=> 1 );  
    public $comprobante_codigo_qr = array( 'align'=> 'C','w' => 25,'border'=>0 ,'ln'=>0 , 'h'=>25);    
    public $comprobante_mensaje = array( 'align'=> 'L','w' =>  90,'border'=>1 ,'ln'=>0 ,'font_h'=> 10 , 'pos_x' => 5  );         
    

    public $pos_y=4;
    public $pos_x=10;

    public function Header() {        

        $this->SetAuthor('Colbert Calampa Tantachuco');
        $this->SetSubject('Comprobante Documentacion');
        $this->SetKeywords('Comprobante, Electrónico');

        $this->set_formato($this->format);

        
        $h = 15;

        $this->SetXY($this->pos_x,$this->pos_y);

        if( $this->format == 'A4'){
            if($this->orientation == 'L'){
                $this->empresa_data['w'] = 160;
                $this->comprobante_id['w'] = 80;
            }

        }else if ( $this->format == 'Ticket_A' ){

            $this->logo_data['mostrar'] = false;
            $this->empresa_data['align'] = 'C';
            $this->empresa_data['w'] = $this->max_width;
            $this->empresa_data['ln'] = 1;
            $this->empresa_data['font_h'] = 7;
            $this->comprobante_id['font_h'] = 8;            
            $this->comprobante_id['border'] = 'TB';
            $this->comprobante_id['w'] = $this->max_width;
        }
        
        if($this->logo_data['mostrar']){
            $ld = $this->logo_data ;
            $this->Image($this->logo_empresa, $this->pos_x, $this->pos_y, $ld['w'], $ld['y'], 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);    
        }         


        $ed = $this->empresa_data;
        $this->SetFont('helvetica', '', $ed['font_h']);
        $text="<strong> {$this->razon_social} </strong><br>" ;
        $text.=" {$this->direccion}<br>" ;
        $text.=" {$this->contacto}" ;
        $this->MultiCell( $ed['w'],'', $text,0, $ed['align'], 0, $ed['ln'], '','' , true,1,true  );


        switch ($this->motivo) {
            case 'venta':
                $text="<strong> R.U.C {$this->ruc} </strong><br>";
                $text.=" {$this->tipo_documento}<br>" ;
                $text.=" {$this->nro_documento} " ;
                break;

            case 'compra':
                $text="<strong> DOC. DE COMPRA </strong><br>";
                $text.=" {$this->tipo_documento}<br>" ;
                $text.=" {$this->nro_documento} " ;
                break;
            
            default:
                $text=" No identificado ";
                break;       
        }
        $ci = $this->comprobante_id;
        $this->SetFont('helvetica', '', $ci['font_h']);
        $this->MultiCell(  $ci['w'] , '', $text,  $ci['border'], 'C', 0, $ci['ln'], '','', true,1,true  );
    }

    // Page footer
    public function Footer() {
        // Position at 15 mm from bottom
        $mostrar_pie = true;
        if ( $this->format == 'Ticket_A' ){
            $mostrar_pie = false;
        }

        if($mostrar_pie){
            $this->SetY($this->h_footer);
            $this->Setx($this->pos_x);
            // Set font
            $ed = $this->empresa_data;
            $text=" {$this->direccion} - " ;
            $text.=" {$this->contacto}" ;

            $this->MultiCell(80  * ($this->max_width/100), 8, $text, 0, $ed['align'], 0, $ed['ln'], '','' , true,1,true );

            $this->MultiCell(20  * ($this->max_width/100), 8, 'Pagina '.$this->getAliasNumPage().' de '.$this->getAliasNbPages(), 0, 'R', 0 ,0);
        }
    }

    public function set_formato($formato = 'A4_V') {
        
        if( $formato == 'A4'){
            $this->setCellPaddings(1, 1.5, 1, '');
            $this->SetMargins(5, 30,5 );
        }else if($formato == 'Ticket_A'){
            $this->SetMargins(5, 30,5 );
        }
    }

    public function comprobante_data_title($title) {         

        $ln = true;//Salto de linea pdebajo del cuadro receptor data

        if( $this->format == 'A4'){
            if($this->orientation == 'L'){
                $this->comprobante_data_title['w'] = 140;
                $ln = false;
            }

        }else if ( $this->format == 'Ticket_A' ){
            $this->comprobante_data_title['w'] = $this->max_width;
            $this->comprobante_data_title['font_h'] = 7;
            $this->comprobante_data_title['max_col'] = 1;
            $this->comprobante_data_title['border'] = 'B';
        }

        $cdt = $this->comprobante_data_title;

        if($ln){
            $this->Ln(1);  
        }else{
            $this->SetX( $this->GetX() + 5);   
        }         
        
        $this->SetFont('helvetica', '', $cdt['font_h']);
        $this->MultiCell( $cdt['w'], '', ''.$title, $cdt['border'], $cdt['align'], 0,$cdt['ln'], '', '', false, 0,true );  
             

        //echo $text;      exit();   
    }

    public function comprobante_data($data) {
        $ln = true;//Salto de linea pdebajo del cuadro receptor data

        if( $this->format == 'A4'){
            if($this->orientation == 'L'){
                $this->comprobante_data['w'] = 140;
                $ln = false;
            }

        }else if ( $this->format == 'Ticket_A' ){
            $this->comprobante_data['w'] = $this->max_width;
            $this->comprobante_data['font_h'] = 7;
            $this->comprobante_data['max_col'] = 1;
            $this->comprobante_data['border'] = 'B';
        }

        $cd = $this->comprobante_data;

        if($ln){
            $this->Ln(1);  
        }else{
            $this->SetX( $this->GetX() + 5);   
        }         
        
        foreach ($data as $key => $val) {
                    
            $this->SetFont('helvetica', '', 12);
            $w_aux = $cd['w'];
            $align_aux = $cd['align'];
            $borde_aux = 0;

            if($val['add_borde'] > 0){
                $borde_aux = 1;
            }
            
            $new_h = '' ;//heigt minimo

            if($val['add_descripcion'] > 0){
                $w_aux = $w_aux/3;
                $padding = - 5;//Teniendo en cuenta el padding

                $w_dato = ($w_aux + $padding) ;
                $w_valor = ($w_aux + $padding) * 2;

                $ln_descripcion = 0;
                $align_aux = 'C';

                $new_h_dato = $this->getNumLines($val['descripcion_dato'],$w_dato);
                $new_h_valor = $this->getNumLines($val['valor'],$w_valor);
                $new_h = $new_h_dato > $new_h_valor ? $new_h_dato : $new_h_valor;

                $new_h *= 6;

                $this->MultiCell($w_dato, $new_h, $val['descripcion_dato'], $borde_aux, $align_aux, 0,$ln_descripcion, '', '' );
                
                $w_aux = $w_valor;
                
            }

            $this->MultiCell($w_aux, $new_h, $val['valor'], $borde_aux, $cd['align'], 0,$cd['ln'], '', '' );

            if($val['salto_linea'] > 0){
                $salto = $val['salto_linea'] * 1; 
                $this->Ln($salto); 
            }        
             
        }
        //echo $text;      exit();     


    }

    public function data_table( $data, $head_cols, $flag_nro_item = false ) {//suma de $widthcols = 200 - $flag_nro_item
        $this->set_formato($this->format);

        $this->Ln(1);        
        $this->SetFillColor(241, 241, 241);//color

        if( $this->format == 'A4'){
            if($this->orientation == 'L'){
                $this->comprobante_table_head['max_w'] = 285;
                $this->comprobante_table_head['border'] = 1;
            }

        }else if ( $this->format == 'Ticket_A' ){
            $this->comprobante_table_head['h'] = 4;
            $this->comprobante_table_head['border'] = 0;
            $this->comprobante_table_head['max_w'] = $this->max_width;
            $this->comprobante_table_head['font_h'] = 7;
            $this->comprobante_table_body['border'] = 0;
            $this->comprobante_table_body['h'] = 4;

            $flag_nro_item = false;
            $count_head_cols = count($head_cols) ;            


        } 
        //Calcular espacio libre y de saltos
        if ( $this->format == 'Ticket_A' ){

            $espacio_libre = $ind_esp_libre = $espacio_repartir= 0;
            for ($i=0; $i < $count_head_cols; $i++) {                 
                if( $head_cols[$i][1] >= 30 ){
                    $espacio_libre += $head_cols[$i][1];
                    $head_cols[$i][1] = 100; // % porcentaje
                    $ind_esp_libre ++;
                }
            }

            $espacio_repartir = number_format($espacio_libre / ( $count_head_cols - ($ind_esp_libre) ),2);

            for ($i=0; $i < $count_head_cols; $i++) {                 
                if( $head_cols[$i][1] < 30 ){                   
                    $head_cols[$i][1] += $espacio_repartir; // % porcentaje
                }
            }

        } 
        
        $th = $this->comprobante_table_head;
        $this->SetFont('helvetica', '', $th['font_h']);


        $nro_item_w = 0; //el width de item
        if($flag_nro_item){ //Mostrar nro de item
            $nro_item_w = 5 * ($th['max_w']/100);
            $this->comprobante_table_head['max_w'] -= $nro_item_w;

            $this->Cell($nro_item_w, $th['h'], 'Item', $th['border'], 0, 'C', 1); 
        }

        $th = $this->comprobante_table_head;

        //print_r($head_cols);exit();        
        foreach ($head_cols as $key => $value) {
            $cell_w = $value[1] * ($th['max_w']/100);//Calculo el espacio en porcetanje
            $align_td = ( isset($value[2]))? $value[2] :'C';
            $this->Cell($cell_w, $th['h'],  $value[0], $th['border'], 0, $align_td, 1);
            if($cell_w >=$th['max_w']){
                $this->Ln(); 
            }
        }        
        $this->Ln();
               
        

        $tb = $this->comprobante_table_body;
        $fill = $nro_item =  0;       

        foreach ($data as $key => $val) {

            $hc_i = 0;
            $h_min = 0;//heigt minimo

            foreach ($val as $skey => $svalue) {

                $cell_w = $head_cols[$hc_i][1] * ($th['max_w']/100);
                $new_h = $this->getNumLines($svalue,$cell_w);
                $h_min = ($new_h>$h_min)?$new_h:$h_min;
            }

            $h_min *= 6;//heigt minimo

            //Mostrar nro de item
            if($flag_nro_item){$this->Cell($nro_item_w, $h_min, ++$nro_item, $tb['border'], 0, 'R', $fill);}
            

            foreach ($val as $skey => $svalue) {
                $cell_w = $head_cols[$hc_i][1] * ($th['max_w']/100);                
                $align_td = ( isset($head_cols[$hc_i][2]))? $head_cols[$hc_i][2] :'L';

                $tb['h'] = $h_min;//heigt minimo
                $ln_new = 0;

                if($cell_w >=$th['max_w']){
                   $ln_new = 1;
                }
                //$this->Cell($cell_w, $tb['h'], $svalue, $tb['border'], 0,$align_td , $fill);
                $nuevo = $this->MultiCell($cell_w, $h_min, $svalue , $tb['border'], $align_td , $fill, $ln_new);
                
                $hc_i++;
                
            }
            $this->Ln(); 
             

            $fill = !$fill; //Flag de coor de celda  
        }

        $this->Cell($th['max_w'] + $nro_item_w, 2, '', 'T',0); 
        $this->Ln(1); 
             
//        
    }

    public function data_table_footer( $formato, $data ,$msj) {



        if( $this->format == 'A4'){
           
            $this->comprobante_codigo_qr['w'] = 25;
            $this->comprobante_codigo_qr['h'] = 25;

            if($this->orientation == 'L'){
                $this->comprobante_table_footer_letras['w'] = 215;
                $this->comprobante_table_footer_totales['w'] = 70;
                $this->comprobante_table_footer_letras['h'] = 5;
                $this->comprobante_table_footer_totales['h'] = 5;
                $this->comprobante_mensaje['w'] = 170;
            }
            if($this->getY() > $this->max_heigth + $this->h_footer ){ 
                $this->AddPage() ;
                $this->Setx($this->pos_x);
            }

            $this->pos_y = $this->getY();
            $this->pos_x = $this->getX();

            

            $this->comprobante_codigo_qr['pos_y'] = $this->pos_y + 8;
            $this->comprobante_mensaje['pos_y'] = $this->pos_y + 8;
            $this->comprobante_mensaje['pos_x'] = $this->pos_x +  $this->comprobante_codigo_qr['w'] + 10;



        }elseif ( $this->format == 'Ticket_A' ){
            $this->comprobante_table_footer_letras['w'] = $this->max_width;
            $this->comprobante_table_footer_letras['h'] = 4;
            $this->comprobante_table_footer_letras['ln'] = 1;
            $this->comprobante_table_footer_totales['w'] = $this->max_width;
            
            $this->comprobante_table_footer_letras['border'] = 0; 
            $this->comprobante_codigo_qr['w'] = $this->max_width ;
            $this->comprobante_codigo_qr['ln'] = 1;
            $this->comprobante_codigo_qr['align'] = 'C';
            $this->comprobante_codigo_qr['pos_y'] = '';

            $this->comprobante_mensaje['w'] = $this->max_width;
            $this->comprobante_mensaje['align'] = 'C';
            $this->comprobante_mensaje['border'] = 0;

        }

        $ctfl = $this->comprobante_table_footer_letras;
        $ctft = $this->comprobante_table_footer_totales;
        $cqr = $this->comprobante_codigo_qr;
        $cm = $this->comprobante_mensaje;


        if($formato == 'monto_venta'){

            
            $texto_letras = (isset($data['monto_letra']['texto'])) ? $data['monto_letra']['texto'] : ' - '  ;
           
            $this->MultiCell( $ctfl['w'] , $ctfl['h'], 'son : '.$texto_letras, $ctfl['border'], 'L',false,$ctfl['ln'],'','',true,0,true );

            $op_gratuitas = (isset($data['monto']['op_gratuitas'])) ? $data['monto']['op_gratuitas'] : '0.00'  ;
            $op_exonerados = (isset($data['monto']['op_exonerados'])) ? $data['monto']['op_exonerados'] : '0.00'  ;
            $op_inafectas = (isset($data['monto']['op_inafectas'])) ? $data['monto']['op_inafectas'] : '0.00'  ;
            $op_igv = (isset($data['monto']['op_igv'])) ? $data['monto']['op_igv'] : '0.00'  ;
            $op_importe = (isset($data['monto']['op_importe'])) ? $data['monto']['op_importe'] : '0.00'  ;

            $text= "<table>";
            $text.="<tr><th>OP. Gratuitas   </th>    <td>$op_gratuitas</td></tr>";
            $text.="<tr><th>OP. Exoneradas  </th>    <td>$op_exonerados</td></tr>";
            $text.="<tr><th>OP. Inafectas   </th>    <td>$op_inafectas</td></tr>";
            $text.="<tr><th>I.G.V (18%)     </th>    <td>$op_igv</td></tr>";
            $text.="<tr><th>Importe Total   </th>    <td>$op_importe</td></tr>";
            $text.="</table>";


            $this->MultiCell( $ctft['w'],'', $text,$ctft['border'], $ctft['align'],false,$ctft['ln'],'','',true,0,true );

            $imgdata = base64_decode($data['qr_code']);
            //$this->Image('@'.$imgdata, 10,245 , 28, 28);

            $this->Image('@'.$imgdata, '', $cqr['pos_y'] , $cqr['w'], $cqr['h']   );
           
            //$this->MultiCell( $cqr['w'], '', 'QR' , $cqr['border'], $cqr['align'],false,$cqr['ln'],'', $cqr['pos_y'],true,0,true );

            $this->SetFont('', '', 7);
            $text= "Bienes transferidos en la amazonía para ser consumidos en la misma<br>";
            $text.="Representación de Comprobante Electrónico<br>";
            $text.="Generado por {$this->sistema} <br>";
            $text.="Representación impresa de la FACTURA ELECTRÓNICA, visita www.nubefact.com/20602440908 ";
            $this->MultiCell( $cm['w'], '', $text,  $cm['border'],  $cm['align'],false, $cm['ln'],$cm['pos_x'], $cm['pos_y'] ,true,0,true );
            $this->SetFont('', '', 9);

        }elseif($formato =='pie_movimiento'){

            $cm['w'] = $ctfl['w'];
            $cm['border'] = 0;

            $this->SetFont('', '', 8);
            $text= "*Este documento representa un movimiento en almacén <br>";
            $this->MultiCell( $cm['w'], '', $text,  $cm['border'],  $cm['align'],false,0,'', '',true,0,true );


            $op_importe = (isset($data['monto']['op_importe'])) ? $data['monto']['op_importe'] : '0.00'  ;

            $this->SetFont('', '', 9);
            $text= "<table>";
            $text.="<tr><th>TOTAL  </th>    <td>$op_importe</td></tr>";
            $text.="</table>";
            $this->MultiCell( $ctft['w'],'', $text,$ctft['border'], $ctft['align'],false,$ctft['ln'],'','',true,0,true );

        }elseif( $formato == 'pie_proforma'){
            
            $cm['border'] = 1;


            $this->SetFont('', '', 10);

            $texto_letras = (isset($data['monto_letra']['texto'])) ? $data['monto_letra']['texto'] : ' - '  ;
           
            $this->MultiCell( $ctfl['w'] , $ctfl['h'], 'son : '.$texto_letras, $ctfl['border'], 'L',false,$ctfl['ln'],'','',true,0,true );

            $op_importe = (isset($data['monto']['op_importe'])) ? $data['monto']['op_importe'] : '0.00'  ;

            
            $text= "<table>";
            $text.="<tr><th>TOTAL</th> <th> S/.  </th>    <td>$op_importe</td></tr>";
            $text.="</table>";
            $this->MultiCell( $ctft['w'],$ctft['h'], $text,$ctft['border'], $ctft['align'],false,$ctft['ln'],'','',true,0,true );
            $this->Ln();

            $observacion = (isset($data['observacion']['texto'])) ? $data['observacion']['texto'] : '  '  ;

            $this->SetFont('', '', $cm['font_h']);
            $text= "Obs : ".$observacion;
            $this->MultiCell( $cm['w'], '', $text,  $cm['border'],  $cm['align'],false,0,'', '',true,0,true );


        }    

        $this->Ln();       
    }



}