<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class CC_Input extends CI_Input {

    var $csrf_token;

    /**
     * Constructor
     *
     * @access  public
     */
    function CC_Input()
    {
        parent::CI_Input();
    }
    
    /**
     * Check and update the unique token
     *
     * @access  private
     */
    function require_csrf_token()
    {
        $this->_ensure_ci_instance();
        $CI =& get_instance();
        
        // Presume evil
        $this->csrf_token = FALSE;
                
        if( ! empty($_POST) )
        {
            // Grab the transaction signature data from various sources
            $sig    = $this->cookie('act_s');
            $req    = $this->post('act_s');
            $dt     = $CI->config->item('request_time') - $CI->session->userdata('token_time');
            
            $err = FALSE;
            
            if ( ! $sig)
            {
                $err = 'Cookies Required.';
            }
            if ( ! $req OR $req !== $sig)
            {
                $err = 'Security Violation';
            }
            else if ($dt > (3 * 60))
            {
                $err = 'Form Expired';
            }
            
            if( $err )
            {
                $E =& load_class('Exceptions');
                echo $E->show_error('<strong>Server Error:</strong> '.$err, '<p>' . anchor( current_url(), 'Try Again') . '</p>Clear your cookies if you see this message repeatedly.');
                die;
            }
        }

        // New request - new token
        $this->_regenerate_token();
    }
    
    /**
     * Create a new CSRF token
     *
     * @access  private
     */
    function _regenerate_token()
    {
        $CI =& get_instance();
        
        $CI->load->library('session');
        $CI->load->helper('cookie');
        
        // Work out a transaction signature for this uri
        $token  = sha1($CI->uri->uri_string() . uniqid(rand(), TRUE));

        // Store relevant data
        $this->csrf_token = $token;
        set_cookie('act_s', $token, 2*60*60);
        $CI->session->set_userdata('token_time', $CI->config->item('request_time'));
    }
    
    /**
     * Get the CSRF token
     *
     * @access  public
     */
    function get_csrf_token()
    {
        return $this->csrf_token;
    }
    
    /**
     * Make sure we can get a CI instance
     *
     * @access  private
     */
    private function _ensure_ci_instance()
    {
        if ( ! function_exists('get_instance'))
        {
            die('require_csrf_token must be called after super-object instantiation.');
        }
    }
}