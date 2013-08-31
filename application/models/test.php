<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of test
 *
 * @author Administrador
 */
class Test extends CI_Model {

    public function get() {
        $query = $this->db->get('empleados');
        return $query->result_array();
    }

}

?>
