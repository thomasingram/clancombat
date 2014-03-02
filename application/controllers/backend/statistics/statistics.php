<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Statistics extends Backend_Controller {

    /**
     * Constructor
     *
     * @access  public
     */
    function Statistics()
    {
        parent::Backend_Controller();
        
        $this->permission->secure_restrict();
        $this->layout->set_section('statistics');
    }

    /**
     * Statistics Home Page
     *
     * @access  public
     */
    function index()
    {
        $this->layout->gen_crumb(array(
            backend_url('')             => 'Backend',
            backend_url('statistics')   => 'Statistics'
        ));
        
        $this->layout->render('statistics/home');
    }
}