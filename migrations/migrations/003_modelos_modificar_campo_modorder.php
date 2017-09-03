<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_modelos_add_campo_modorder extends CI_Migration {

    public function up() {

        $fields = array(
                'mod_order' => array(
                        'name'        => 'mod_order',
                        'type'        => 'INT',
                        'constraint'  => '11'
                ),
        );

        $this->dbforge->modify_column('modelos', $fields);

    }
}        
        
        
