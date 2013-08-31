<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of test
 *
 * @author Administrador
 */
class Prueba extends CI_Controller {

    public function index() {
        
        //$this->session('google');
        $this->load->model('test');
        $model = new Test();
        print_r($model->get());
    }

    public function session($provider) {
        
        $this->load->helper('url_helper');

        $this->load->spark('oauth2/0.4.0');

        $provider = $this->oauth2->provider($provider, array(
            'id' => '176795936943.apps.googleusercontent.com',
            'secret' => 'JbEQhokykm1a-KwQ_bCwoNm9',
        ));

        if (!$this->input->get('code')) {
            // By sending no options it'll come back here
            $url = $provider->authorize();

            redirect($url);
        } else {
            try {
                // Have a go at creating an access token from the code
                $token = $provider->access($_GET['code']);

                // Use this object to try and get some user details (username, full name, etc)
                $user = $provider->get_user_info($token);

                // Here you should use this information to A) look for a user B) help a new user sign up with existing data.
                // If you store it all in a cookie and redirect to a registration page this is crazy-simple.
                echo "<pre>Tokens: ";
                var_dump($token);

                echo "\n\nUser Info: ";
                var_dump($user);
            } catch (OAuth2_Exception $e) {
                show_error('That didnt work: ' . $e);
            }
        }
    }

}

?>
