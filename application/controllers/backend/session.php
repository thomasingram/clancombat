<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Session extends Backend_Controller {

    /**
     * Constructor
     *
     * @access  public
     */
    function Session()
    {
        parent::Backend_Controller();
        $this->load->library('authentication');
    }

    /**
     * Backend Login Page
     *
     * @access  public
     */
    function login()
    {
        $this->load->library('form_validation');
        $this->load->helper('form');
        
        if ( $this->permission->logged_in() )
        {
            if (current_user('session'))
            {
                redirect( backend_url('') );
            }
        }
        
        if ($this->form_validation->run('backend/login') == FALSE)
        {
            $this->layout->set_title('Login');
            $this->layout->render('session/login');
        }
        else
        {
            redirect( backend_url('') );
        }
    }

    /**
     * Backend Logout Page
     *
     * @access  public
     */
    function logout()
    {
        $this->authentication->logout();
        redirect( backend_url('') );
    }
}