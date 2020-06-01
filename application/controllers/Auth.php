<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller
{
    function __construct()
    {
        parent::__construct();

        $this->load->library('form_validation');
    }

    public function index()
    {
    	redirect(base_url('auth/login'));
    }

    public function login()
    {

        $is_login = $this->session->userdata('is_login');
		if($is_login==true){
			redirect('/');
        }
        
        $this->_rule_login();
        
        if($this->form_validation->run()==false){
            $this->load->view('auth/v_login');
        }else{
            $this->_login();
        }

    }

    public function logout()
    {
        $this->session->unset_userdata('iduser');
        $this->session->unset_userdata('is_login');
        
        $this->session->set_flashdata('message', '<div class="alert alert-success">Anda telah Logout</div>');
        redirect(base_url('auth/'));
    }

    public function _login()
    {
        $username = $this->input->post('username',true);
        $pass = md5($this->input->post('password',true));

        $user = $this->db->get_where('users', array('username' => $username, 'password'=>$pass))->row();

        if($user==null){
            $this->session->set_flashdata('message', '<div class="alert alert-danger"><i class="fa fa-warning"></i> Username atau Password salah</div>');
            redirect(base_url('auth/login'));
        }else{
            if($user->is_active==0){
                $this->session->set_flashdata('message', '<div class="alert alert-danger"><i class="fa fa-warning"></i> Akun anda sudah tidak aktif</div>');
                redirect(base_url('auth/login'));
            }else{
                $this->session->set_userdata('iduser', $user->id);
                $this->session->set_userdata('is_login', true);
                
                redirect(base_url('dashboard'));
            }
        }
    }

    public function _rule_login()
    {
        $this->form_validation->set_rules('username','Username','trim|required');
        $this->form_validation->set_rules('password','Password','trim|required|min_length[5]');

        $this->form_validation->set_error_delimiters('<div class="text-red">', '</div>');
    }

    public function blocked()
    {
        $this->load->view('auth/akses_tolak');
    }
}
