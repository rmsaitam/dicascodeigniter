<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Vendas extends CI_Controller {

	public function __construct() {
		parent::__construct();

		//Create instace of pagseguro
		$this->load->library('pagseguro/pagseguro');

		//Inictialize pagseguro API
		$this->pagseguro->initializePagSeguroAPI();
	}

	/**
	 * Faz requisicão de pagamento no pagseguro
	 * @link https://pagseguro.uol.com.br/v2/guia-de-integracao/documentacao-da-biblioteca-pagseguro-em-php.html#!rmcl
	 *
	 */
	public function comprar() {

		$this->pagseguro->requestPayment();
		
		//Set product array
		$product  =   array( 
			9385634,           //'idProduct'
			"Play Station 2",  //'nameProduct'
			1,                 //'qtdProduct'
			200.00             //'priceProduct'
		);

		$urlNotify  =  "your_url";

		//Reference
		$ref = "PS_3850184";
		
		//Add product
		$this->pagseguro->addItemToPaymentRequest( $product );

		//set reference
		$this->pagseguro->setReferencePayment( $ref );

		//Set URL to get notification pagseguro
		$this->pagseguro->setUrlNotification( base_url() . 'vendas/notify' );

		//Set max age to client pay it. Default 2 days
		$this->pagseguro->setMaxAgePayment();

		//Set frete
		$this->pagseguro->setFrete();

		//Set currency = BRL
		$this->pagseguro->setCurrency();

		//Set address client
		$this->pagseguro->setShipping('08346575', 'Rua Bras Lima', '33', 'Casa', 'Jardim Nova Conquista', 'São Paulo', 'SP');

		//Set discount percent
		//$this->pagseguro->setDiscount();

		//Get url to redirect to pagseguro
		$urlRedirect  =  $this->pagseguro->generationUrl();

		//Debug
		var_dump( $urlRedirect );

	}

	/**
	 * Esse será o método controle chamado para receber a notificacão das vendas que o sistema realizar
	 * Lembrando que no sistema deve ser permitido o uso de CORS vindos do pagseguro
	 * @link https://pagseguro.uol.com.br/v2/guia-de-integracao/api-de-notificacoes.html#v2-item-servico-de-notificacoes
	 * @link https://pagseguro.uol.com.br/v2/guia-de-integracao/api-de-notificacoes.html#!v2-item-api-de-notificacoes-status-da-transacao
	 *
	 * @method POST
	 * @param  $notificationType - Tipo da ntoficacão que chegou
	 * @param  $notificationCode - Código da notificacão
	 */
	public function notify() {

        //Get type notification
        $type         =   $this->input->post( 'notificationType' );
          
        //Get code of notification
		$notifyCode   =   $this->input->post( 'notificationCode' );
		
		//Checks type notification
		if( $type != 'transaction' ){
			die( 'Error. Aborting' );
		}

        //Call API pagseguro and get transaction by code notification
        $transaction    =    $this->pagseguro->returnRequestNotification( $notifyCode );		

        //Check return is object
        if( !is_object( $transaction ) ){
			die('Error. Aborting');
		}

        //Get code transaction
        $code                      =   $transaction->getCode();

        //Get reference
        $referencia                =   $transaction->getReference();

        //get status transaction
        $status                    =   $transaction->getStatus()->getValue();

        //Get method payment
        $tpPagto                   =   $transaction->getPaymentMethod()->getType()->getValue();

        //Get code of payment
		$codTpPagto                =   $transaction->getPaymentMethod()->getCode()->getValue();	
		
		//end

	}

}