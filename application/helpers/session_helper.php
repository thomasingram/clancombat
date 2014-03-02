<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Simplify session operations
 * 
 * @access  public
 * @return  string  session item to get
 * 
 */
function current_user($item = '')
{
    $CI =& get_instance();
    return $CI->session->userdata($item);
}