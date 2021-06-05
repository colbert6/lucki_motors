<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
require_once dirname(__FILE__) . '/tcpdf/tcpdf.php';
 
class Pdf_comprobantes extends TCPDF
{
    function __construct($orientation='P', $unit='mm', $format='A4', $unicode=true, $encoding='UTF-8', $diskcache=false, $pdfa=false)
    {
        parent::__construct($orientation, $unit, $format, $unicode, $encoding, $diskcache, $pdfa);

        $MY_controller = & get_instance();
        //Parametros de la cabecera
        $this->sistema = $MY_controller->sistema ;
        $this->logo_empresa = $MY_controller->logo_empresa ;
        $this->razon_social = $MY_controller->razon_social ;
        $this->ruc = $MY_controller->ruc ;
        $this->rubro = $MY_controller->rubro ;
        $this->direccion = $MY_controller->direccion ;

    }

    public $motivo;

    public $sistema;

    public $logo_empresa;
    public $razon_social;
    public $ruc;
    public $rubro;
    public $direccion;

    public $tipo_documento;
    public $nro_documento;

    public $pos_y;
    public $pos_x;

    public function Header() {        

        $this->SetAuthor('Colbert Calampa Tantachuco');
        $this->SetSubject('Comprobante - Infarsel');
        $this->SetKeywords('Comprobante, Electrónico, Infarsel');
        
        //------------- width : 200pts---------//
        //Format A4 orientation P : --img:50--Data empresa:100--Data Documento:50--
        //$this->SetY(5);
        
        $this->Image($this->logo_empresa, 5, 5, 45, 15, 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false); 

        $this->SetFont('helvetica', '', 10);
        $text="<strong> {$this->razon_social} </strong><br>" ;
        $text.=" {$this->rubro}<br>" ;
        $text.=" {$this->direccion}" ;
        $this->MultiCell( 100 , 15, $text,  0, 'J', 0, 0, 55, 5, true,1,true  );

        $this->SetFont('helvetica', '', 10);
        $text="<strong> R.U.C {$this->ruc} </strong><br>";
        $text.=" {$this->tipo_documento}<br>" ;
        $text.=" {$this->nro_documento} " ;
        $this->MultiCell( 50 , 15, $text,  1, 'C', 0, 1, '','', true,1,true  );
        
    }

    // Page footer
    public function Footer() {
        // Position at 15 mm from bottom
        $this->SetY(-15);
        // Set font
        $this->SetFont('helvetica', 'I', 8);
        // Page number
        $this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }


    public function set_formato($formato = 'A4_V') {
        
        if($formato){
            $this->SetFont('', '', 9);
            $this->setCellPaddings(1, 1.5, 1, '');
            $this->SetMargins(5, 25,5 );
            $this->setY(21);
        }
        
    }

    public function data_format_table($n_col , $data) {
        
        $colspan = 0;
        $max_colspan = array_sum( array_column($data, '1'));

        $text= '<table>';
        $text.= '<tr>';

        foreach ($data as $key => $value) {
            $text.="<th colspan='".$value[1]."' > ".$key." : ".$value[0]."</th>" ;
            $colspan += $value[1];
            if($colspan % $n_col == 0  &&  $colspan < $max_colspan ) {
                $text.= '</tr><tr>';
            }
        }

        $text.='</tr>';
        $text.='</table>';
        $this->MultiCell( 200, '', $text, 1, 'L', 0,1, '', '', false, 0,true );      
        //echo $text;      exit();   
    }

    public function data_table( $data, $head_cols, $flag_nro_item = false, $formato = 'basico'  ) {//suma de $widthcols = 200 - $flag_nro_item
        
        $this->SetFillColor(241, 241, 241);//color

        $linea_final_table = array_sum(array_column($head_cols,'1')) ;
        $head_cols['nro_item'] = 8;   

        $this->Ln(1);

        if($flag_nro_item){ //Mostrar nro de item
            $this->Cell($head_cols['nro_item'], 5, 'Item', 1, 0, 'C', false); 
            $linea_final_table += $head_cols['nro_item'];
        }

        foreach ($head_cols as $key => $value) {
            $this->Cell($value[1], 5, $value[0], 1, 0, 'C', false);
        }        
        $this->Ln();
        
        $fill = $nro_item = 0;       

        foreach ($data as $key => $val) {
            //Mostrar nro de item
            if($flag_nro_item){$this->Cell($head_cols['nro_item'], 5, ++$nro_item, 'LR', 0, 'R', $fill);}
            
            if( $formato == 'basico'){

                $this->Cell($head_cols[0][1], 5, $val['cantidad'], 'LR', 0, 'R', $fill);
                $this->Cell($head_cols[1][1], 5, $val['descripcion'], 'LR', 0, 'L', $fill);
                $this->Cell($head_cols[2][1], 5, $val['precio'], 'LR', 0, 'R', $fill);
                $this->Cell($head_cols[3][1], 5, $val['subtotal'], 'LR', 0, 'R', $fill);

            }else if( $formato == 'general' ){

                $ind=0;
                foreach ($val as $sub_key => $sub_value) {
                    $this->Cell($head_cols[$ind][1], 5, $sub_value, 'LR', 0, 'L', $fill);
                    $ind++;
                }

            }
            
            $this->Ln();  

            $fill = !$fill; //Flag de coor de celda  
        }

        $this->Cell($linea_final_table, 0, '', 'T',0);
        $this->Ln(1);     
        
    }

    public function data_table_footer( $formato, $data ) {

        $this->pos_y = $this->getY();

        if($formato == 'monto_venta'){

            $width_letras = (isset($data['monto_letra']['width'])) ? $data['monto_letra']['width'] : 150  ;
            $texto_letras = (isset($data['monto_letra']['texto'])) ? $data['monto_letra']['texto'] : 'No especificado'  ;
           
            $this->MultiCell( $width_letras , 5, $texto_letras, 1, 'L',false,0,'','',true,0,true );

            $width_monto = (isset($data['monto']['width'])) ? $data['monto']['width'] : 50  ;
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
            $this->MultiCell( $width_monto, '', $text, 1, 'R',false,0,'','',true,0,true );

            $this->MultiCell( 40, '', 'QR' , 1, 'L',false,0,'', $this->pos_y+6,true,0,true );


            $this->SetFont('', '', 7);
            $text= "Bienes transferidos en la amazonía para ser consumidos en la misma<br>";
            $text.="Representación de Comprobante Electrónico<br>";
            $text.="Elaborado por {$this->sistema} <br>";
            $this->MultiCell( $width_letras-40 , '', $text, 0, 'L',false,2,'', '',true,0,true );
            $this->SetFont('', '', 9);

        }    

        $this->Ln();       
    }



}