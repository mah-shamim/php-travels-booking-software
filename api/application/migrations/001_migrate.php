<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_migrate extends CI_Migration {

        public function up()
        {
                $this->dbforge->add_field(array(
                        'blog_id' => array(
                                'type' => 'INT',
                                'constraint' => 5,
                                'unsigned' => TRUE,
                                'auto_increment' => TRUE
                        ),
                        'blog_title' => array(
                                'type' => 'VARCHAR',
                                'constraint' => '100',
                        ),
                        'blog_description' => array(
                                'type' => 'TEXT',
                                'null' => TRUE,
                        ),
                ));
                $this->dbforge->add_key('blog_id', TRUE);
                $this->dbforge->create_table('a_migrate_table');


            $this->dbforge->add_field(array(
                'blog_id' => array(
                    'type' => 'INT',
                    'constraint' => 5,
                    'unsigned' => TRUE,
                    'auto_increment' => TRUE
                ),
                'blog_title' => array(
                    'type' => 'VARCHAR',
                    'constraint' => '100',
                ),
                'blog_description' => array(
                    'type' => 'TEXT',
                    'null' => TRUE,
                ),
            ));
            $this->dbforge->add_key('blog_id', TRUE);
            $this->dbforge->create_table('ab_migrate_table');
        }

        public function down()
        {
                $this->dbforge->drop_table('a_migrate_table');
                $this->dbforge->drop_table('ab_migrate_table');
        }
}