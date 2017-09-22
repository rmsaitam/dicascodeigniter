<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Curl {

    //Object curl
    private $ch    =  null;

    /**
     * Construct
     * Initialize curl
     * @return Void
     */
    public function __construct() {
        //Init curl
        $this->ch  =  curl_init();
    }

    /**
     * Parameters opt in array
     * @param  ARRAY $option  -  Array with options to curl
     * @return Curl Class
     */
    public function setCurlOptArray( $option = array() ) {
        //Set opt
        curl_setopt_array($this->ch, $option );
        //Return class
        return $this;
    }

    /**
     * Parameters opt in array
     *
     * @param  String $option  -  Option curl
     * @param  String $data    -  Data to set in option curl
     * @return Curl Class
     */
    public function setOptCurl( $option, $data ) {
        //Set opt
        curl_setopt($this->ch, $option, $data );
        //Return class
        return $this;
    }

    /**
     * Execute curl, return data and close curl.
     * @return Mixed
     */
    public function execute() {

        //Execute curl
        $data  =  curl_exec( $this->ch );

        //Close
        curl_close( $this->ch );

        //Return data
        return $data;
    }


}
