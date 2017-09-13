<?php if ( ! defined('BASEPATH') ) exit( 'No direct script access allowed' );

class Pagseguro {

	private $paymentRequest;

	public function initializePagSeguroAPI() {

		require APPPATH . 'libraries/pagseguro/api/PagSeguroLibrary.php'; 

	}

	public function requestPayment() {

		$this->paymentRequest   =   new PagSeguroPaymentRequest();

	}

	//Instance of credential PagSeguro
	protected function instanceCredential() {	
        
        //Instance of credential of config file. Location libraries/pagseguro/api/config/PagSeguroConfig.php
        return PagSeguroConfig::getAccountCredentials();

    }

	//Adiciona os itens que serao comprados na requisiçao
	/**
	 *@parm     array( 
	 * 				'idProduct'     => INT,  
	 *				'nameProduct'   => STRING,
	 *				'qtdProduct'    => INT
	 *				'priceProduct'  => FLOAT/DOUBLE
     *			 )
     *
     *@return  VOID
	 *
	**/		
	public function addItemToPaymentRequest( $item = array() ) {

		$this->paymentRequest->addItem( $item[0], $item[1], $item[2], $item[3] );

	}

	/**
	 * Seta o endereco do comprador
	 *
	 * @param $cep - cep do comprador
	 * @param $addr - endereco do comprador
	 * @param $numberAddr - numero da residencia
	 * @param $complement - casa, ap.. ??
	 * @param $bai - bairro do comprador
	 * @param $cid - cidade do comprador
	 * @param $est - estado do comprador
     * @return VOID
	 */
	public function setShipping($cep, $addr, $numberAddr, $complement, $bai, $cid, $est, $pais = 'BRL'){
		$this->paymentRequest->setShippingAddress(  
			$cep,
			$addr,
			$numberAddr,
			$complement,
			$bai,
			$cid,
			$est,
			$pais
		);  
	}

	/** 
	 * Seta o tipo de frete para enviar o produto físico
	 *
	 * @param $tpFrete - SEDEX, PAC...
	 * @return VOID
	 */
	public function setFrete( $tpFrete = 'SEDEX') {
		$sedexCode = PagSeguroShippingType::getCodeByType( $tpFrete );  
		$this->paymentRequest->setShippingType($sedexCode);
	}

	/**
	 * Seta a URL que o PAGSEGURO vai redirecionar o cliente, logo após o pagamento for feito
	 * Geralmente, essa URL mostra um resumo da compra que o cliente acabou de fazer.
	 *
	 * @param $url - URL para o pagseguro redirecionar o cliente
	 */
	public function redirectUrlToSite( $url ) {
		$this->paymentRequest->setRedirectUrl( $url );  
	}

	/**
	 * Seta uma taxa de desconto em % para ser oferecido com base no método de pagamento realizado no pagseguro
	 * Esse desconto será oferecido no checkout no ambiente Pagseguro. 
	 * Dê se o quiser.
	 *
	 * @return VOID
	 */
	public function setDiscount() {
		$this->paymentRequest->addPaymentMethodConfig('CREDIT_CARD', 1.00, 'DISCOUNT_PERCENT');  
		$this->paymentRequest->addPaymentMethodConfig('EFT', 2.90, 'DISCOUNT_PERCENT');  
		$this->paymentRequest->addPaymentMethodConfig('BOLETO', 10.00, 'DISCOUNT_PERCENT');  
		$this->paymentRequest->addPaymentMethodConfig('DEPOSIT', 3.45, 'DISCOUNT_PERCENT');  
		$this->paymentRequest->addPaymentMethodConfig('BALANCE', 0.01, 'DISCOUNT_PERCENT');  		
	}

	/**
	 * Set o Pais corrente da requisiçao
	 *@param   STRING  DEFAULT "BRL"
	 *
     *@return  VOID
	 *
	**/	
	public function setCurrency( $currency = 'BRL' ) {

		$this->paymentRequest->setCurrency( $currency );

	}	


	//Codigo de referencia para o pagamento, usado como controle interno
	/**
	 *@param   INT
	 *
     *@return  VOID
	 *
	**/		
	public function setReferencePayment( $reference ) {

		$this->paymentRequest->setReference( $reference );

	}	


	//Seta a URL que sera enviado o POST com a atualizaçao do pagamento
	/**
	 *@param   URL FORMAT
	 *
     *@return  VOID
	 *
	**/		
	public function setUrlNotification( $url ) {

		$this->paymentRequest->addParameter( 'notificationURL', $url );

	}		

	//Prazo maximo de validade para a requisiçao do PagSeguro
	/**
	 *@param   INT    DEFAULT 172800 (2 Days)
	 *
     *@return  VOID
	 *
	**/		
	public function setMaxAgePayment( $value = 172800 ) {

		$this->paymentRequest->setMaxAge( $value );

	}	


	//Gera a URL de redirecionamento do pagseguro
	/**
	 *
     *@return  STRING
	 *
	**/		
	public function generationUrl() {
		try {  		
			$credentials =  PagSeguroConfig::getAccountCredentials(); // getApplicationCredentials()  
			$checkoutUrl =  $this->paymentRequest->register($credentials);  			
			return $checkoutUrl;
		} catch (PagSeguroServiceException $e) {  
			//die($e->getMessage());
			return FALSE;
		}  

	}


	protected function log( $log ) {

		LogPagSeguro::debug( $log );		

	}



	/**
	 *@description  Metodo processa uma 
	 *
	 *@param  $codeTransaction  Id da transaçao enviada pelo PagSeguro
	 *
	 *@return Obj|Bool
	 *
	 */
	public function returnRequestTransaction( $idTransaction ) {

        try { 

        	$credentials  =  $this->instanceCredential();

        	$this->log( 'Recebendo retorno da transaçao: ' . $idTransaction  . " date(d/m/Y h:i:s)");
              
            //Realizando uma consulta de transação a partir do código identificador para obtero o objeto PagSeguroTransaction       
            $transaction  =  PagSeguroTransactionSearchService::searchByCode(   

                $credentials,  

                $idTransaction  

            );  
              
        } catch (PagSeguroServiceException $e) {  

        	$this->log( 'Falha ao receber retorno da transaçao: ' . $idTransaction . " date(d/m/Y h:i:s)");
              
            return false;

        }

        return $transaction; 
        
	}


	/**
	 *@description  Metodo recebe a notificaçao enviada pelo PagSeguro e a processa
	 *
	 *@param  $codeNotification  Id da notificaçao enviada pelo PagSeguro
	 *
	 *@return Obj|Bool
	 *
	 */
	public function returnRequestNotification( $codeNotification ) {

        try { 

        	$credentials  =  $this->instanceCredential();

        	$this->log( 'Recebendo notificaçao da transaçao: ' . $codeNotification . " date(d/m/Y h:i:s)");;
              
            $transaction = PagSeguroNotificationService::checkTransaction(  

                $credentials,  

                $codeNotification

            );  
              
        } catch (PagSeguroServiceException $e) {  

        	$this->log( 'falha ao receber notificaçao da transaçao: ' . $codeNotification . " date(d/m/Y h:i:s)");
              
            return FALSE;

        }

        return $transaction; 
        
	}


}