<?php

    if ( ! defined('BASEPATH') ) exit( 'No direct script access allowed' );

    //Library to generate files in format MICROSOFT EXCEL
    require_once APPPATH . 'libraries/excel/PHPExcel.php';

	class Exportar {

		private $excel;

		public $file;

        /**
        * Esse é o método constructor da classe, ele automaticamente inicializa a classe de manipulação de arquivos para o Microsoft Excel
        *
        * @param   NONE
        * @return  VOID
        * @access  public
        *
        **/
		public function __construct(){

			//Instancia a classe de manipulação de arquivos do Microsoft Excel
			$this->excel   =   new PHPExcel();
				
			$this->excel->getProperties()->setCreator( "http://www.seu_site.com.br" );
			
			$this->excel->getProperties()->setLastModifiedBy( "http://www.seu_site.com.br" );
			
			$this->excel->getProperties()->setSubject( "Escreva algo aqui, pode ser qualquer coisa, seila" );					

		}


		public function setActiveSheetIndex() {

			$this->excel->setActiveSheetIndex(0);

		}


		public function setDescription( $descricao = 'Documento Office' ) {

			$this->excel->getProperties()->setDescription( $documento );

		}


		public function setTitle( $title = 'Exportacão' ) {

			$this->excel->getProperties()->setTitle( $title );

		}


        /**
        * Esse método cria linhas no arquivo Excel, porém, ele cria as linhas colonando valores nas células
        * Portanto você precisa informar em qual célula será inserido o valor
        *
        * @param   STRING $cell    -   Célula que deseja inserir o valor
        * @param   STRING $value   -   Valor que deseja inserir na celula
        * @return  VOID
        * @access  public
        *
        **/		
		public function SetCellValue( $cell, $value ) {

			$this->excel->getActiveSheet()->SetCellValue( $cell, $value );

		}


        /**
        * Esse método seta o HEADER para geração de um arquivo XLSX e força seu download
        *
        * @param   STRING $nameFile  - Nome do arquivo que deseja fazer o download
        * @return  Exportar.class
        * @access  public
        *
        **/	
		public function setHeaderFile( $file = 'arquivo.xlsx' ) {
			// We'll be outputting an excel file
			$this->file  =  $file;
			if( strpos($file, '.xlsx') ) {
				header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			}else {
				header('Content-Type: application/vnd.ms-excel');
			}
			
			header('Content-Disposition: attachment; filename="' . $file . '"');
			header('Cache-Control: max-age=0');
		

		}

		public function download( $version = 'Excel2007' ) {
			$writer = PHPExcel_IOFactory::createWriter($this->excel, $version );
			$writer->save( 'php://output' );
		}

        /**
        * Esse método retorna um arquivo Microsoft Excel
        *
        * @param   STRING $version  -  Refere-se ao tipo de arquivo que é gerado com base na versão do excel
        * @return  VOID   
        * @access  public
        *
        **/	
		public function save( $dir, $version = 'Excel2007' ) {
			$writer = PHPExcel_IOFactory::createWriter($this->excel, $version );
			$writer->save( $dir . $this->file );			
		}		

	}






