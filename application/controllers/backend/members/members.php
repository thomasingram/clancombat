<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Members extends Backend_Controller {

    /**
     * Constructor
     *
     * @access  public
     */
    function Members()
    {
        parent::Backend_Controller();
        
        $this->permission->secure_restrict();
        $this->layout->set_section('members');
        
        $this->load->model('member_model');
    }

    /**
     * Member Home Page
     *
     * @access  public
     */
    function index()
    {
        $data['members'] = $this->member_model->get_all();
        
        $this->layout->gen_crumb(array(
            backend_url('')         => 'Backend',
            backend_url('members')  => 'Members'
        ));
        
        $this->layout->render('members/home', $data);
    }

    /**
     * Add a new member
     *
     * @access  public
     */
    function create()
    {
        $this->layout->gen_crumb(array(
            backend_url('')         => 'Backend',
            backend_url('members')  => 'Members'
        ));
        
        $this->layout->render('members/home');
    }
}