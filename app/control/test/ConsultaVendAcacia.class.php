<?php

use Adianti\Control\TPage;
use Adianti\Widget\Base\TElement;
use Adianti\Widget\Container\TVBox;

/**
 * ConsultaVendAcacia
 *
 * @version    1.0
 * @package    ConsultaVendAcacia
 * @subpackage cadcli
 * @author     Ademilson NUnes
 * @copyright  Copyright (c) 2021 Sobel Suprema Insdustria de produtos de limpeza LTDA. (http://www.sobelsuprema.com.br)
 * @license    http://www.adianti.com.br/framework-license
 */
class ConsultaVendAcacia extends TPage
{ 
    /**
     * Page constructor
     */
    function __construct()
    {
        parent::__construct();  
           
        $vends = $this->getVendedores();

        //Conta registros no array 
        $totalVends = count($vends) - 1;
        for ($i=0; $i <= $totalVends; $i++) 
        { 
            echo $vends[$i]['CODVENDACACIA'] .','. $vends[$i]['VENDEDOR'] .','. $vends[$i]['USUARIO'] .','. md5($vends[$i]['USUARIO']) , '<br>';
        }

    }

    /**
     * retorna stdClass contendo vendedores
     */
    public function getVendedores()
    {        
        $query = "SELECT V.NOME                      AS 'VENDEDOR', 
                         V.CODIGOVENDEDOR            AS 'CODVENDACACIA', 
                         LEFT(V.CODIGOVENDEDORESP,6) AS 'CODVENDPROTHEUS', 
                         USUARIO                     AS 'USUARIO',
                         USUARIO                     AS 'SENHA_CADCLI',
                         SENHA                       AS 'SENHA_ACACIA'
                   FROM  T\$_USUARIO U
                   INNER JOIN T_VENDEDOR V ON V.CODIGOVENDEDOR = U.CODIGOEMPRESA";    

        try
        {
           TTransaction::open('acacia');      
            $conn = TTransaction::get(); 
             // realiza a consulta
             $result = $conn->query($query);

             $vend = array();
             $i = 0;                    
             foreach ($result as $row)
             {                          
                $vend[$i]['VENDEDOR']        = $row['VENDEDOR'];
                $vend[$i]['CODVENDACACIA']   = $row['CODVENDACACIA'];                        
                $vend[$i]['CODVENDPROTHEUS'] = $row['CODVENDPROTHEUS'];                       
                $vend[$i]['USUARIO']         = $row['USUARIO'];   
                $vend[$i]['SENHA_CADCLI']    = $row['SENHA_CADCLI'];   
                $vend[$i]['SENHA_ACACIA']    = $row['SENHA_ACACIA'];  
                $i++;
             }
             return  $vend;
 
           TTransaction::close(); // fecha a transação.
        }
        catch (Exception $e)
        {
           new TMessage('error', $e->getMessage());
        }
    }

    /**
     * shows the page
     */
     function show()
     {
         parent::show();
     }

}    