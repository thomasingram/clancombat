<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Form Declaration - CSRF Safe
 *
 * Creates the opening portion of the form as well as a hidden field with a unique id.
 *
 * @access  public
 * @param   string  the URI segments of the form destination
 * @param   array   a key/value pair of attributes
 * @param   array   a key/value pair hidden data
 * @return  string
 */
function form_open_safe($action = '', $attributes = '', $hidden = array())
{
    $CI =& get_instance();
    
    $sig = $CI->input->get_csrf_token();
    $hidden = array_merge($hidden, array('act_s' => $sig));
    
    return form_open($action, $attributes, $hidden);
}