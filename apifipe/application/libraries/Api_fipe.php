<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * API FIPE NÃO OFICIAL
 *
 * @package  Api_Fipe
 * @author   Adão Duque <adaoduquesn@gmail.com>
 * @link     https://github.com/adaoduque/dicascodeigniter/apifipe
 */
class Api_fipe {

    //Instance CI
    private $CI  =  null;

    //Url and Option to curl
    private $OPT  =  array();

    //urls
    private static $URL  =  array(
        'tabelas'    => 'http://www.fipe.org.br/pt-br/indices/veiculos',
        'marcas'     => 'http://veiculos.fipe.org.br/api/veiculos/ConsultarMarcas',
        'modelos'    => 'http://veiculos.fipe.org.br/api/veiculos/ConsultarModelos',
        'anoModelos' => 'http://veiculos.fipe.org.br/api/veiculos/ConsultarAnoModelo',
        'veiculo'    => 'http://veiculos.fipe.org.br/api/veiculos/ConsultarValorComTodosParametros'
    );

    /**
     * Construct
     * Load curl library
     * Set URLS to request data on server FIPE
     * Set options curl default, change especific data in array
     * @return Void
     */
    public function __construct() {

        //Get instance CI
        $this->CI = &get_instance();

        //Load library curl
        $this->CI->load->library('curl');

		//Curl Array options
		$this->OPT = array(
			CURLOPT_URL             =>  '',
			CURLOPT_POSTFIELDS      =>  '',
			CURLOPT_POST            =>  1,
			CURLOPT_SSL_VERIFYPEER  =>  0,
			CURLOPT_RETURNTRANSFER  =>  true,
            CURLOPT_HTTPHEADER      =>  array(
	                'Accept:application/json, text/javascript, */*; q=0.01',
	                'Accept-Encoding:gzip, deflate',
	                'Accept-Language:pt-BR,pt;q=0.8,en-US;q=0.6,en;q=0.4',
	                'Connection:keep-alive',
	                'Content-Type:application/x-www-form-urlencoded; charset=UTF-8',
	                'Cookie:_ga=GA1.3.472052299.1466616166; _gat=1',
	                'Host:veiculos.fipe.org.br',
	                'Origin:http://veiculos.fipe.org.br',
	                'Referer:http://veiculos.fipe.org.br/',
	                'User-Agent:Mozilla/5.0 (X11; Linux x86_64; rv:55.0) Gecko/20100101 Firefox/55.0',
	                'X-Requested-With:XMLHttpRequest',
	        )
        );
    }

    /**
     * Get brand of vehicles
     *
     * Set url to get brands
     * Set data to send in post request
     * @return Mixed
     */
    public function getBrands( $post ) {

        //Set url to get brands
        $this->OPT[CURLOPT_URL] = SELF::$URL['marcas'];

        //Set post fields
        $this->OPT[CURLOPT_POSTFIELDS] = $post;

        //Execute curl and get data
        return $this->CI->curl->setCurlOptArray( $this->OPT )->execute();

    }

    /**
     * Get models of vehicles
     *
     * Set url to get brands
     * Set data to send in post request
     * @return Mixed
     */
    public function getModels( $post ) {

        //Set url to get models
        $this->OPT[CURLOPT_URL] = SELF::$URL['modelos'];

        //Set post fields
        $this->OPT[CURLOPT_POSTFIELDS] = $post;

        //Execute curl and get data
        return $this->CI->curl->setCurlOptArray( $this->OPT )->execute();

    }

    /**
     * Get year model of vehicles
     *
     * Set url to get brands
     * Set data to send in post request
     * @return Mixed
     */
    public function getYearModels( $post ) {

        //Set url to get year model
        $this->OPT[CURLOPT_URL] = SELF::$URL['anoModelos'];

        //Set post fields
        $this->OPT[CURLOPT_POSTFIELDS] = $post;

        //Execute curl and get data
        return $this->CI->curl->setCurlOptArray( $this->OPT )->execute();

    }

    /**
     * Get info general
     *
     * Set url to get brands
     * Set data to send in post request
     * @return Mixed
     */
    public function getInfoGeneral( $post ) {

        //Set url to get year model
        $this->OPT[CURLOPT_URL] = SELF::$URL['veiculo'];

        //Set post fields
        $this->OPT[CURLOPT_POSTFIELDS] = $post;

        //Execute curl and get data
        return $this->CI->curl->setCurlOptArray( $this->OPT )->execute();

    }

    /**
     * Get last id table reference
     *
     * @param int $code  -  Code to get table of cars, truck or moto
     * @return Mixed
     */
    public function getLastOptionTable( $code ) {

        //Check type
		switch ( $code ) {
			case 1:
				//Car
				$id = 'selectTabelaReferenciacarro';
				break;
			case 2:
				//moto
				$id = 'selectTabelaReferenciamoto';
				break;
			case 3:
				//Truck
				$id = 'selectTabelaReferenciacaminhao';
				break;
		}

        $table  =  false;

        //Initialize Simple Dom Class
        $this->CI->load->library( 'Simple_html_dom' );

        //Get html from page
        $html  =  file_get_html( self::$URL['tabelas'] );

        //Check return is not empty
        if (!empty($html)) {

            //Find first select element with id selectTabelaReferenciacarro
            $content = $html->find("select[id=$id]", 0);

            //Select found ?
            if (!empty($content)) {

                //Get first value from option in select element
                $table  =  $content->find('option', 0)->value;
            }

        }

        //Return
        return $table;

    }

}
