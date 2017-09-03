<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_modelos_add_campo_modorder extends CI_Migration {

    public function up() {

        if ( !$this->db->field_exists('mod_order', 'modelos') ) {
            $this->load->dbforge();
            $fields  =  array(
                'mod_order'   =>  array(
                    'type'       =>  'INT',
                    'constraint' =>  '5'
                )
            );
            $this->dbforge->add_column('modelos', $fields);
        }

    }
}