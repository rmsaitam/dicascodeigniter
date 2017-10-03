<?php

/**
 * Upload single and multiple files
 * 
 * @category Upload
 * @package  Upload
 * @author   Adão Duque <adaoduquesn@gmail.com>
 * @license  MIT https://opensource.org/licenses/MIT
 * @link     https://github.com/adaoduque/dicascodeigniter
 */
class Files
{

    private $_Files        =   null;

    private $_SaveTo       =   null;

    private $_Length       =   null;        

    private $_Response     =   array();

    private $_Extensions   =   array();

    /**
     * Set file to manipulate
     *
     * @param $_FILE Object $file - Attribute name from form
     * 
     * @return void
     */    
    public function __construct( $file )
    {
        $this->_Files   =   $file;
    }

    /**
     * Set parameters to save file and resctrict it with extension and size
     *
     * @param String $dirToSave     - Directory to save file after upload
     * @param Int    $length        - max length to restrict file size
     * @param array  $fileExtension - Array with extension permited
     * 
     * @return void
     */
    public function initialize( $dirToSave, $length, $fileExtension = array() ) 
    {

        //Set dir to save file
        $this->_SaveTo      =  $dirToSave;

        //Set max length to size file
        $this->_Length      =  $length;

        //Set array with extension permited to files
        $this->_Extensions  =  $fileExtension;

    }

    /**
     * Process multiple files
     * 
     * @return array string
     */    
    public function multipleFiles() 
    {
        //Check if directory exists
        if (is_dir($this->_SaveTo)) {

            //Count elements to upload
            $countFiles   =   count($this->_Files['name']);

            //Check if is not minor with zero
            if ($countFiles > 0) {

                //Loop to access all object files
                for ($i = 0; $i < $countFiles; $i++ ) { 

                    //Check if object in index loop is valid
                    if (isset($this->_Files['name'][$i]) && trim($this->_Files['name'][$i]) != '' ) {

                        //Get extension from file
                        $extensao  =  explode('.', $this->_Files['name'][$i]);
                        $extensao  =  strtolower(end($extensao));

                        //Get size
                        $length    =  $this->_Files['size'][$i];

                        //Get name
                        $name      =  $this->_Files['name'][$i];

                        //Check if extension is permitted
                        if (array_search($extensao, $this->_Extensions) === false) {

                            //Error, set message
                            $this->_Response['status'] = $extensao . ' - Arquivo não permitido';

                            //Set response error
                            $this->_Response['error']   = true;

                            //Brake loop, aborting
                            return $this->_Response;

                        } else if ($length > $this->_Length) {

                            //Check length is not minor
                            //Error, set message
                            $this->_Response['status'] = $name . ' - Arquivo excede o limite de tamanho de: ' . $this->_Length . ' KB';
                            
                            //Set response error
                            $this->_Response['error']   = true;

                            //Brake loop, aborting
                            return $this->_Response;

                        }

                    }

                }

                //Not error, continue, now in new looping to save files
                for ($i = 0; $i < $countFiles; $i++ ) {

                    //Check object item is valid
                    if (isset($this->_Files['name'][$i]) && trim($this->_Files['name'][$i]) != '') {

                        //Set condition is false
                        $cond  =  false;

                        //While to save files always with name different
                        while (!$cond) {

                            //Generate new name
                            $name    =   rand(000000000, 9999999999).'.'.$extensao;

                            //Set name and directory to save
                            $file    =   $this->_SaveTo . $name;

                            //Check if file exists in directory
                            if (!file_exists($file)) {
                                //If file not exists
                                $cond  =  true;
                            }

                        }

                        //Check if is possible to move file with new name
                        if (move_uploaded_file($this->_Files['tmp_name'][$i], $file)) {

                            //Set status
                            $this->_Response[$i]['status']  =  'No error';

                            //Set name file
                            $this->_Response[$i]['file']    =  $file;

                            //Set response
                            $this->_Response[$i]['error']   =  false;

                        } else {

                            //Delete files processed with success
                            $this->deleteFileProcessed($this->_Response);

                            //Error
                            $this->_Response['status']  =  $name . ' - Permissão de escrita revogada';

                            //Set error response
                            $this->_Response['error']   =  true;

                            //Brake loop, aborting
                            return $this->_Response;

                        }

                    }

                }

                //Return response
                return $this->_Response;

            }

        } else {

            //Error
            $this->_Response['status']  =  'Diretório para salvar os arquivos inexistente';

            //Set error response
            $this->_Response['error']   =  true;

        }

        //Return
        return $this->_Response;

    }

    /**
     * Method proccess single file
     *
     * @return void
     */
    public function singleFile() 
    {

        //Check if directory exists
        if (is_dir($this->_SaveTo)) {
            
            //Count elements to upload
            $countFiles = count($this->_Files['name' ]);

            //Check if is equals 1
            if ($countFiles == 1) {

                //Check if object in index loop is valid
                if (isset($this->_Files['name']) && trim($this->_Files['name']) != '') {

                    //Get extension from file
                    $extensao  =  explode('.', $this->_Files['name']);
                    $extensao  =  strtolower(end($extensao));
                    
                    //Get size
                    $length    =  $this->_Files['size']; 

                    //Get name
                    $name      =  $this->_Files['name']; 

                    //Check if extension is permitted
                    if (array_search($extensao, $this->_Extensions) === false) {

                        //Error, set message
                        $this->_Response['status'] = $extensao . ' - Arquivo não permitido';

                        //Set response error
                        $this->_Response['error']  = false;

                        //Brake loop, aborting
                        return $this->_Response;                        

                    } else if ($length > $this->_Length) {

                        //Error, set message
                        $this->_Response['status'] = $name . ' - Arquivo excede o limite de tamanho de: ' . $this->_Length . ' KB';

                        //Set response error
                        $this->_Response['error']  = true;
                        
                        //Brake loop, aborting
                        return $this->_Response;

                    }

                } else {

                    //Error, set message
                    $this->_Response['status'] = 'Arquivo inválido';

                    //Set response error
                    $this->_Response['error']  = true;
                    
                    //Brake loop, aborting
                    return $this->_Response;

                }

                //Check object item is valid
                if (isset($this->_Files['name']) && trim($this->_Files['name']) != '') {

                    //Set condition is false
                    $cond  =  false;
                    
                    //While to save files always with name different
                    while (!$cond) {

                        //Generate new name
                        $name  =  rand(000000000, 9999999999).'.'.$extensao;

                        //Set name and directory to save
                        $file  =  $this->_SaveTo . $name;

                        //Check if file exists in directory
                        if (!file_exists($file)) {
                            //If file not exists
                            $cond  =  true;
                        }

                    }

                    //Check if is possible to move file with new name
                    if (move_uploaded_file($this->_Files['tmp_name'], $file)) {

                        //Set status
                        $this->_Response['status'] = 'No error';

                        //Set name file
                        $this->_Response['file']   = $file;

                        //Set response
                        $this->_Response['error'] = true;

                    } else {

                        //Error
                        $this->_Response['status']  =  $name . ' - Permissão de escrita revogada';

                        //Set error response
                        $this->_Response['error']   =  true;

                        //Brake loop, aborting
                        return $this->_Response;

                    }

                }

            }

        } else {

            //Error
            $this->_Response['status']  =  'Diretório para salvar os arquivos inexistente';

            //Set error response
            $this->_Response['error']   =  true;

        }

        //Return response
        return $this->_Response;

    }

    /**
     * Delete files processed with successful
     *
     * @param array String $files - Files processed with success
     * 
     * @return void
     */
    public function deleteFileProcessed( $files = array() ) 
    {   
        //Get all index array and delete all files processed
        foreach ($files as $key => $value) {
            //Delete file quiet
            @unlink($value['file']);
        }

    }

}