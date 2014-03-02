<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Frontend extends Controller {

    /**
     * Constructor
     *
     * @access  public
     */
    function Frontend()
    {
        parent::Controller();
        
        /* Frontend login?:
        if ( ! BOARD_LOCKED OR current_user('group') == 1)
        */
        
        /* Debugging:
        echo round(xdebug_memory_usage()/1024/1024,2).' MB';
        echo xdebug_time_index();
        */
    }

    /**
     * Home Page
     *
     * @access  public
     */
    function index()
    {
        
        // Load the main libraries
        $this->load->library('preferences');
        $this->load->library('template');

        // Grab the template folder
        $template_name = $this->preferences->get('template');
        
        // Process the template basics and work out where we are
        $requested = $this->template->initialize($template_name);
        
        // Ok, before we start parsing stuff, a locked system goes nowhere      
        $locked = $this->permission->_check_locked();

        if ($locked)
        {
            die('locked');
        }
        
        // @TODO Force login page when locked.
/*
        if ($locked && $this->uri->uri_string() != '/member/login')
        {
            $this->load->library('authentication');
            $this->authentication->logout();
            
            $this->session->set_flashdata('error', $this->lang->line('error_board_locked'));
            redirect('member/login');
        }
*/
        
        // Take off an id if there is one
        $id = end($this->uri->segment_array());
        
        if (is_numeric($id))
        {
            $segments = array_slice($this->uri->segment_array(), 0, -1);
            $requested = implode('/', $segments);
        }

        $final = $this->template->render($requested);
        $this->output->set_output($final);
    /*  
        echo $final;
        die;
        
        echo '<pre>';
        print_r($this->template->_processed);
        echo '</pre>';
    */  
    }
    
    /**
     * Home Home Page
     *
     * @access  public
     */
    function create_admin()
    {
        // For my own sanity
        die('locked');
        
        $this->load->model('authentication_model');
        
        $data = array(
            'group_id'  => 1,
            'username'  => 'inparo',
            'email'     => 'inparo@example.com',
            'password'  => 'emma',
            'join_date' => time()
        );
        
        if ($this->authentication_model->register_user($data))
        {
            echo 'created!';
        }
        else
        {
            echo 'failed';
        }
    }
}