<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function backend_url($segments)
{
    $CI =& get_instance();
    $base = $CI->config->item('backend_base');
    
    return $base . '/' . trim($segments, '/');
}