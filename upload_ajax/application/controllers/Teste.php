<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Controller
 * 
 * @category Upload
 * @package  Upload
 * @author   Adão Duque <adaoduquesn@gmail.com>
 * @license  MIT https://opensource.org/licenses/MIT
 * @link     https://github.com/adaoduque/dicascodeigniter
 */
class Teste extends CI_Controller
{

    /**
     * Construct
     *
     * @return void
     */    
    public function __construct()
    {
		parent::__construct();
	}

    /**
     * Page initial
     *
     * @return void
     */
	public function index()
	{
		$data = array('url' => base_url());
		$this->parser->parse('teste', $data);
	}

	public function singleFile() 
	{
		//Load helper
		$this->load->helper('upload');

		$file  = isset($_FILES['myfile1']) ?  $_FILES['myfile1'] : null;

        //Set dir to save all files uploaded
        $dirToSave      =   'assets/img/uploads/';

        //Limit size by file
        $length         =   1048576 * 3; //3 MB by file

        //Extension permiteds
        $fileExtension  =   array( 'png', 'jpeg', 'jpg' );

        //Instance helper
        $FILES = new Files($file);

        //Set config
        $FILES->initialize($dirToSave, $length, $fileExtension);
		
		//Process file
		$upload  = $FILES->singleFile();

		echo json_encode( array( 'mess' => $upload['status'] ) );

    }

	public function multipleFiles() 
	{
		//Load helper
		$this->load->helper('upload');

		$file  = isset($_FILES['myfile2']) ?  $_FILES['myfile2'] : null;

        //Set dir to save all files uploaded
        $dirToSave      =   'assets/img/uploads/';

        //Limit size by file
        $length         =   1048576 * 3; //3 MB by file

        //Extension permiteds
        $fileExtension  =   array( 'png', 'jpeg', 'jpg' );

        //Instance helper
        $FILES = new Files($file);

        //Set config
        $FILES->initialize($dirToSave, $length, $fileExtension);
		
		//Process file
		$upload  = $FILES->multipleFiles();

		echo json_encode( array( 'mess' => isset( $upload[0]['status'] ) ? $upload[0]['status'] : $upload['status'] ) );

    }	

}