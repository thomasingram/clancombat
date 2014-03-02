<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Backend_Controller extends Controller {
    
    /**
     * Constructor
     *
     * @access  public
     */
    function Backend_Controller()
    {
        parent::Controller();
        
        $this->input->require_csrf_token();
        
        $this->lang->load('member');
        
        // I use these so much - may move them later
        $this->load->library('layout');
        $this->load->helper(array('html','form'));
    }

    /**
     * Update unique token
     *
     * @access  private
     */
    private function _csrf_refresh()
    {
        // Only refresh if it was posted
        if( ! $sent = $this->input->get_post('act_s'))
        {
            $this->load->helper('cookie');
            
            // Work out transaction signature for this uri
            $random = ']rnu<^hdgg%y|\T$w?lva$~U3+hM0Jp{HOr!<,qSdxM-!fEE07q_IwRO"B1=5.~';
            $csrf_token = md5( $_SERVER['PATH_INFO'] . $this->input->user_agent() . $random . $this->input->ip_address() );

            // Store relevant data
            set_cookie('act_s', $csrf_token, 2*60*60);
            $this->session->set_userdata('token_time', $this->config->item('request_time'));
        }
        else
        {
            // Keep the current one
            $csrf_token = $this->input->cookie('act_s');
        }

        // Set response data
        $this->javascript->set_constant('act_s', $csrf_token);
        $this->javascript->add_response('act_s', $csrf_token);
        
        // Add user information
        if ($this->access->logged_in())
        {
            $user_js = current_user('js');
            $this->javascript->set_constant('user', $user_js['user']);
            $this->javascript->set_constant('interface', $user_js['interface']);
        }
    }
}