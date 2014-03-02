<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Settings extends Backend_Controller {

    /**
     * Constructor
     *
     * @access  public
     */
    function Settings()
    {
        parent::Backend_Controller();
        
        $this->permission->secure_restrict();
        $this->layout->set_section('settings');
    }

    /**
     * Settings Home Page
     *
     * @access  public
     */
    function index()
    {
        $this->layout->gen_crumb(array(
            backend_url('')             => 'Backend',
            backend_url('statistics')   => 'Settings'
        ));
        
        $this->layout->render('settings/home');
    }
}