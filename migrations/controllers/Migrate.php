<?php 

class Migrate extends CI_Controller {

	/**
	* Método construtor
	*/
	public function __construct() {
		parent::__construct();
	}

    public function versao($version){
		$this->load->library("migration");
		if(!$this->migration->version($version)){
		  	show_error($this->migration->error_string());
		}else {
			echo "Migration $version aplicado com sucesso";
		}

    }
}