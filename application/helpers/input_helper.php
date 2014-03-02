<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Filters allowed post keys
 *
 * @access  private
 */
function filter_input_data($allowed, $data)
{
    $allowed = array_flip($allowed);
    return array_intersect_key($data, $allowed);
}

/**
 * Checks if $value for $field is already used
 *
 * @access  private
 * @param   string  email
 * @return  bool
 */
function check_unique($table, $field, $value)
{
    $this->db->select($field);
    $this->db->where($field, $value);
    $this->db->limit(1);

    return ($this->db->count_all_results($this->table) > 0) ? TRUE : FALSE;
}