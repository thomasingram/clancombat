<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function reorder_tree($tree)
{
    if ( ! $tree)
    {
        return FALSE;
    }
    
    $CI =& get_instance();
    $CI->load->library('tree_iterator');
    
    $CI->tree_iterator->initialize($tree);
    
    $tree = $CI->tree_iterator->get_tree();
    return $tree;
}