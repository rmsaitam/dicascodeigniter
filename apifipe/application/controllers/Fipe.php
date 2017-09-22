<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * API FIPE NÃO OFICIAL
 *
 * @package  Api_Fipe
 * @author   Adão Duque <adaoduquesn@gmail.com>
 * @link     https://github.com/adaoduque/dicascodeigniter/apifipe
 */
class Fipe extends CI_Controller {

	/**
     * Construct
     * Initialize Class Api Fipe
     * @return Void
     */
	public function __construct() {
		parent::__construct();

		//Initialize class ApiFipe
		$this->load->library('api_fipe');
	}

	/**
     * Recuperar marca dos veiculos
     * @return Void
     */
	public function getMarcas() {

		//Type
		$typeVehicle = 3;

		//Check type
		switch ( $typeVehicle ) {
			case 1:
				//Car
				$code = $typeVehicle;
				break;
			case 2:
				//moto
				$code = $typeVehicle;
				break;
			case 3:
				//Truck
				$code = $typeVehicle;
				break;
		}

		//Get last code table reference
		$codTablereference  =  $this->api_fipe->getLastOptionTable( $code );

		//Parameters to send in post
		$param   =  array( 'codigoTabelaReferencia' => $codTablereference, 'codigoTipoVeiculo' => $code );

		//Serialize data to send in post
		$stringParam  =  $this->urlify( $param );

		//Get brands
		$data   =  $this->api_fipe->getBrands( $stringParam );

		//Debug
		var_dump( $data );
	}

	/**
     * Recuperar modelo dos veiculos
     * @return Void
     */
	public function getModelos() {
		//Type
		$typeVehicle = 3;

		//Brand
		$brandCar  =  103;

		//Check type
		switch ( $typeVehicle ) {
			case 1:
				//Car
				$code = $typeVehicle;
				break;
			case 2:
				//moto
				$code = $typeVehicle;
				break;
			case 3:
				//Truck
				$code = $typeVehicle;
				break;
		}

		//Get last code table reference
		$codTablereference  =  $this->api_fipe->getLastOptionTable( $code );

		//Parameters to send in post
		$param   =  array( 'codigoTabelaReferencia' => $codTablereference, 'codigoTipoVeiculo' => $code, 'codigoMarca' => $brandCar );

		//Serialize data to send in post
		$stringParam  =  $this->urlify( $param );

		//Get models
		$data   =  $this->api_fipe->getModels( $stringParam );

		//Debug
		var_dump( $data );

	}

	/**
     * Recuperar ano modelo do veiculo
     * @return Void
     */
	public function getAnoModelo() {
		//Type
		$typeVehicle = 3;

		//Brand
		$brandCar  =  103;

		//Model vehicle
		$modelCode = 3130;

		//Check type
		switch ( $typeVehicle ) {
			case 1:
				//Car
				$code = $typeVehicle;
				break;
			case 2:
				//moto
				$code = $typeVehicle;
				break;
			case 3:
				//Truck
				$code = $typeVehicle;
				break;
		}

		//Get last code table reference
		$codTablereference  =  $this->api_fipe->getLastOptionTable( $code );

		//Parameters to send in post
		$param   =  array( 'codigoTabelaReferencia' => $codTablereference, 'codigoTipoVeiculo' => $code, 'codigoMarca' => $brandCar, 'codigoModelo' => $modelCode );

		//Serialize data to send in post
		$stringParam  =  $this->urlify( $param );

		//Get models
		$data   =  $this->api_fipe->getYearModels( $stringParam );

		//Debug
		var_dump( $data );

	}

	/**
     * Recuperar as informacões gerais do veiculo
     * @return Void
     */
	public function getInfoGeral() {
		//Type
		$codeTypeVehicle = 3;

		//Brand
		$brandCar  =  103;

		//Model vehicle
		$modelCode = 3130;

		//Type request
		$codeTypeRequest = 'tradicional';

		//Year model vehicle
		$year  =  '1989-3';

		//Code type fuel
		$codeTypeFuel  =  substr( $year, -1 );

		//Format year model vehicle
		$year  =  substr( $year, 0, -2 );

		//Check type
		switch ( $codeTypeVehicle ) {
			case 1:
				//Car
				$code = $codeTypeVehicle;
				$typeVehicle = 'carro';
				break;
			case 2:
				//moto
				$code = $codeTypeVehicle;
				$typeVehicle = 'moto';
				break;
			case 3:
				//Truck
				$code = $codeTypeVehicle;
				$typeVehicle = 'caminhao';
				break;
		}

		//Get last code table reference
		$codTablereference  =  $this->api_fipe->getLastOptionTable( $code );

		//Parameters to send in post
		$param   =  array(
			'tipoConsulta'           => $codeTypeRequest,
			'codigoTabelaReferencia' => $codTablereference,
			'codigoTipoVeiculo'      => $code,
			'codigoMarca'            => $brandCar,
			'codigoModelo'           => $modelCode,
			'tipoVeiculo'            => $typeVehicle,
			'codigoTipoCombustivel'  => $codeTypeFuel,
			'anoModelo'              => $year
		);

		//Serialize data to send in post
		$stringParam  =  $this->urlify( $param );

		//Get models
		$data   =  $this->api_fipe->getInfoGeneral( $stringParam );

		//Debug
		var_dump( $data );

	}

	/**
     * Serealize data to url-ify
     *
     * @param  ARRAY $data  -  Array with key and value to send
     * @return String
     */
    public function urlify( $data = array() ) {

		//Init $post
		$post = '';

		//url-ify the data for the POST
        foreach($data as $key => $value) {
            $post .= $key . '=' . $value . '&';
        }

        //Remove last &
        $post = substr( $post, 0, -1);

        //Return class
        return $post;
    }

}
