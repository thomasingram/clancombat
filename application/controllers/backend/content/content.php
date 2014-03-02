<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Content extends Backend_Controller {

    /**
     * Constructor
     *
     * @access  public
     */
    function Content()
    {
        parent::Backend_Controller();
        
        $this->permission->secure_restrict();
        $this->layout->set_section('content');
    }

    /**
     * Content Home Page
     *
     * @access  public
     */
    function index()
    {
        $this->layout->gen_crumb(array(
            backend_url('')         => 'Backend',
            backend_url('content')  => 'Content'
        ));
        
        $this->layout->render('content/home');
    }
}