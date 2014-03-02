<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Backend extends Backend_Controller {

    /**
     * Constructor
     *
     * @access  public
     */
    function Backend()
    {
        parent::Backend_Controller();

        $this->permission->secure_restrict();
        $this->layout->set_section('home');
    }

    /**
     * Backend Home Page
     *
     * @access  public
     */
    function index()
    {
        $this->layout->gen_crumb(array(
                            backend_url('')     => 'Backend'
        ));
        
        $this->layout->render('main/home');
    }
}