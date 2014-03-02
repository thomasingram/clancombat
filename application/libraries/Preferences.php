<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Preferences {
    
    var $CI;
    var $prefs;
    
    /**
     * Constructor
     *
     * @access  public
     */
    function Preferences()
    {
        $this->CI =& get_instance();
        
        $query = $this->CI->db->get('general', 1, 0);
        $this->prefs = $query->row();
        
        // Set the default language to our global language
        $this->CI->config->set_item('language', $this->prefs->language);
        
        // Global config overrides
        if ($this->CI->config->item('system_locked'))
        {
            $this->prefs->locked = 1;
        }
        
        // Backend URLs
        $this->set('backend_base_url', backend_url('') );
        $this->set('backend_login', backend_url('session/login') );
    }
    
    /**
     * Preferences Accessor
     *
     * @access  public
     */
    function get($key)
    {
        if (isset($this->prefs->$key))
        {
            return $this->prefs->$key;
        }
        return FALSE;
    }
    
    /**
     * Preferences Setter
     *
     * @access  public
     */
    function set($key, $value)
    {
        $this->prefs->$key = $value;
    }
}