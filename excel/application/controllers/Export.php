<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Export extends CI_Controller {

	public function __construct() {
		parent::__construct();
	}

	public function xlsx() {

		//Load library
        $this->load->library('excel/exportar');
		
		//Set title for cells in file
        $this->exportar->SetCellValue( 'A1', 'Linguagem' );
        $this->exportar->SetCellValue( 'B1', 'Criador' );

        //Increment
        $i = 2;

        //Get data
        $data = $this->getLanguages();

		//Fetch data
		foreach ( $data as $key ) {
			$this->exportar->SetCellValue( 'A'.$i, $key[0] );
			$this->exportar->SetCellValue( 'B'.$i, $key[1] );
			$i++;
		}

		$this->exportar->setHeaderFile( 'name_file.xlsx' );

		//If file is .csv: Excel5
		$this->exportar->download('Excel2007');
	}

	public function xlsx_save() {

		//Load library
        $this->load->library('excel/exportar');
		
		//Set title for cells in file
        $this->exportar->SetCellValue( 'A1', 'Linguagem' );
        $this->exportar->SetCellValue( 'B1', 'Criador' );

        //Increment
        $i = 2;

        //Get data
        $data = $this->getLanguages();

		//Fetch data
		foreach ( $data as $key ) {
			$this->exportar->SetCellValue( 'A'.$i, $key[0] );
			$this->exportar->SetCellValue( 'B'.$i, $key[1] );
			$i++;
		}

		$this->exportar->file = 'name_file.xlsx';
		$this->exportar->save( 'assets/export/' );
	}	

	public function getLanguages() {
		$data  =  array(
			array( 'C', 'Dennis Ritchie' ),
			array('C++', 'Bjarne Stroustrup'),
			array('PHP', 'Rasmus Lerdorf'),
			array('Java', 'James Gosling'),
			array('Javascript', 'Brendan Eich'),
			array('C#', 'Microsoft'),
			array('Swift', 'Apple'),
			array('Go', 'Google')
		);
		return $data;
	}

}