<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class CC_Router extends CI_Router {
    
    /**
     * Constructor
     *
     * @access  public
     */
    function CC_Router()
    {
        parent::CI_Router();
    }
    
    /**
     * Validate Routing Request
     *
     * @access  public
     */
    function _validate_request($segments)
    {
        // Check the root folder first
        if (file_exists(APPPATH.'controllers/'.$segments[0].EXT))
        {
            return $segments;
        }
        
        global $CFG;
        
        if ($segments[0] == $CFG->item('backend_base'))
        {
            // Not in the root, but not enough segments
            if (count($segments) < 2)
            {
                // Calling the index function of a controller of the same directory...
                $segments[1] = $segments[0];
            }

            // Does the requested controller exist as a full path including the directory?
            if (file_exists(APPPATH.'controllers/'.$segments[0].'/'.$segments[1].EXT))
            {
                //Set the directory
                $this->set_directory($segments[0]);

                //Drop the directory segment
                $segments = array_slice($segments, 1);
                return $segments;
            }

            // Otherwise, try duplicating segment 1
            if (file_exists(APPPATH.'controllers/backend/'.$segments[1].'/'.$segments[1].EXT))
            {
                $segments[0] = $segments[1];
                
                //Set the directory
                $this->set_directory('backend/'.$segments[0]);
                
                return $segments;
            }
        }

        // Can't find the requested controller
        die('Fatal Error');
    }
}