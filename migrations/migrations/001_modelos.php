<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_modelos extends CI_Migration {

	public function up() {

        $this->dbforge->add_field( array(
            'mod_id' => array(
                'type'           =>  'INT', //Tipo
                'constraint'     =>  '11', //Largura da coluna
                'auto_increment' =>  TRUE
            ),
            'mod_name' => array(
                'type'       => 'VARCHAR',
                'constraint' => '100'
            ),
            'mod_register' => array(
                'type'    =>  'datetime'
            ),
        ));

        //Set primary key
        $this->dbforge->add_key('mod_id', TRUE);

        //Create table
        $this->dbforge->create_table( 'modelos' );
	}
}