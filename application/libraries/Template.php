<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Template {

    var $CI;                        // CI super object
    var $paths;                     // named paths
    var $slugs;                     // forced slugs
    var $tmp_folder;                // root template folder
    
    var $_processed = array();      // parsing counter
    var $_db_store  = array();      // unsafe input
    var $_bc_store  = array();      // breadcrumbs
    /**
     * Constructor
     *
     * @access  public
     */
    function Template()
    {
        $this->CI =& get_instance();
        log_message('debug', "Layout Class Initialized");
    }
    
    /**
     * Checks the template folder and keeps track of the paths
     *
     * @access  public
     * @param   new title
     */
    function initialize($template_name)
    {
        $this->tmp_folder   = APPPATH.'templates/'.$template_name.'/';
        $paths_file         = $this->tmp_folder.'_paths'.EXT;
        
        $requested          = $this->CI->uri->uri_string();     
        $requested          = trim($requested, '/');
        
        if ( ! is_dir($this->tmp_folder))
        {
            show_error( lang('error_no_template_group') );
        }
        
        if ( ! file_exists($paths_file))
        {
            show_error( lang('error_no_paths_file') );
        }

        include($paths_file);
        
        // Named Paths
        if (
            ! isset($paths) OR
            ! is_array($paths) OR
            ! isset($paths['home']) OR
            ! isset($paths['404']) OR
            ! isset($paths['login'])
            )
        {
            show_error( lang('error_paths_incomplete') );
        }
        
        $this->paths = $paths;
        
        // Homepage needs immediate redirect
        if ($requested == '')
        {
            $requested = $this->paths['home'];
        }

        // Forced Slugs
        if (isset($force_slug) && is_array($force_slug))
        {
            $this->slugs = $force_slug;
            
            if ( ! $this->_check_segments($requested))
            {
                die('missing segment');
            }
        }
        
        // Looks good - load the parser
        $this->CI->load->library('parser');
        
        // Return the location
        return $requested;
    }
    
    /**
     * Parsing coordinator
     *
     * @access  public
     * @param   Root template path
     */
    function render($path)
    {
        $text = $this->_render($path);

        return $text;
    }
    
    /**
     * Start the parsing phase
     *
     * Makes sure all required templates are available
     * and recursively runs through the files - sending
     * each to the parser in turn.
     *
     * @access  private
     * @param   Root template path
     * @param   Nesting variables
     */
    function _render($path, $nest_vars = array())
    {
        $path = trim($path, '/');

        // Prevent infinite recursion
        if ( isset($this->_processed[$path]) && $this->_processed[$path] > 100 )
        {
            die('Same template parsed more than 100 times.  Possible infinite recursion caught.');
        }
        
        if ( ! file_exists($this->tmp_folder.$path.EXT))
        {
            die('cannot find template '.$path);
        }
                
        // Iterate through the includes and build a parsing map
        $text = file_get_contents($this->tmp_folder.$path.EXT);

        // Parse the current template
        $text = $this->CI->parser->parse($text, $nest_vars);
        
        $this->_processed[$path]++;
        
        // Find the nesting calls
        $optional = '(?: (.+?))?';
        $pattern = "#{nest:(.+?)" . $optional . "}#is";

        preg_match_all($pattern, $text, $matches);
        
        foreach($matches[0] as $key => $match)
        {
            // Grab the path and the optional extras
            $nest_path = $matches[1][$key];
            $variables = $matches[2][$key];

            if ($variables)
            {
                $variables = $this->CI->parser->_split_optional($variables);
            }

            // Recurse into each file
            $inner = $this->_render($nest_path, $variables);

            // Replace on the way out
            $text = str_replace($match, $inner, $text);
            
            // And clean the db store
            foreach($this->_db_store as $unique => $content)
            {
                $text = str_replace($unique, $content, $text);
            }
            
            // Reset the store
            $this->db_store = array();
        }
        
        return $text;
    }
    
    /**
     * Validates the requested path
     *
     * @access  public
     * @param   new title
     */
    function _check_segments($requested)
    {
        foreach($this->slugs as $section => $slug)
        {
            if (preg_match('#^('.$section.')(.*)$#i', $requested))
            {
                // Section is right - how about that slug
                if (preg_match('#^('.$section.')/'.$slug.'$#i', $requested))
                {
                    return TRUE;
                }
                return FALSE;
            }
        }
        
        // Not in there? move along.
        return TRUE;
    }
    
    /**
     * Path Accessor
     *
     * @access  public
     */
    function get_path($key)
    {
        if (isset($this->paths[$key]))
        {
            return $this->paths[$key];
        }
        return FALSE;
    }
}