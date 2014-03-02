<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class CC_Form_validation extends CI_Form_validation {
        
    /**
     * Constructor
     *
     * @access  public
     */
    function CC_Form_validation($config = array())
    {
        parent::CI_Form_validation($config);
        
        $this->set_error_delimiters('<li>', '</li>');
    }
    
    /**
     * Check Login
     *
     * @access  public
     * @param   string  password, email-field name
     * @return  bool
     */
    function check_login()
    {
        // Already failing? Don't bother...
        if( ! empty($this->_error_array))
        {
            return TRUE;
        }
        
        $username   = $this->CI->input->post('username');
        $password   = $this->CI->input->post('password');

        // Try authenticating
        $login = $this->CI->authentication->login($username, $password);

        if($login === BANNED)
        {
            $this->set_message('check_login', 'Your account has been suspended.');          
            return FALSE;
        }
        else if($login === TIMEOUT)
        {
            // Throttled authentication
            $this->_error_array = array();          
            $this->set_message('check_login', 'Too many attempts.  You can try again in 20 seconds.');
            return FALSE;
        }
        
        if($login)
        {
            // Authentication valid
            return TRUE;
        }
        else
        {
            // Wrong username/password combination
            $this->set_message('check_login', 'Credentials do not match.');
            return FALSE;
        }       
    }
    
    /**
     * Check Username availability
     *
     * @access  public
     * @param   string  username
     * @return  bool
     */
    function check_username($username)
    {
        if ($this->CI->users_model->check_unique('username', $username))
        {
            return FALSE;
        }
        else
        {
            return TRUE;
        }
    }
    
    /**
     * Check Email availability
     *
     * @access  public
     * @param   string  email
     * @return  bool
     */
    function check_email($email, $old = FALSE)
    {
        if ($email !== $old AND $this->CI->users_model->check_unique('email', $email))
        {
            return FALSE;
        }
        else
        {
            return TRUE;
        }
    }
    
    /**
     * Check the password confirmation
     *
     * @access  public
     * @param   string  password, confirmation
     * @return  bool
     */
    function pwd_match($pass, $confirm)
    {
        if ($pass !== $this->CI->input->post($confirm))
        {
            return FALSE;
        }
        else
        {
            return TRUE;
        }
    }
    
    /**
     * Make sure the project name is unique (to user)
     *
     * @access  public
     * @param   string  project title
     * @return  bool
     */
    function p_title_unique($title)
    {
        return $this->CI->project_model->check_unique($title);
    }
}