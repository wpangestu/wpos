<?php
class Users extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        check_is_login();
        is_admin();
    }    

    public function index()
    {
        $data['main_title'] = 'Pengguna';
        $data['sub_title'] = 'Data Users';
        $data['content'] = 'user/v_user';
        $data['users'] = $this->db->get('users');
        $this->load->view('template',$data);
    }

    public function tambah()
    {
        $this->_rules();

        if($this->form_validation->run()==false){
            $data['codejs'] = 'user/codejs';
            $data['main_title'] = 'Users';
            $data['sub_title'] = 'Tambah Users';
            $data['content'] = 'user/form_input';
            $this->load->view('template',$data);        
        }else{

            $image = $_FILES['image']['name'];
            if($image==null){
                $image = 'default.jpg';
            }else{
                $config['upload_path']      = './assets/img/';
                $config['allowed_types']    = 'gif|jpg|png|jpeg|JPEG|JPG|PNG';
                $config['file_name']        = 'image_'.$this->input->post('username').'_'.time();
                $config['overwrite']        = true;
                
                $this->load->library('upload', $config);
                if (!$this->upload->do_upload('image'))
                {
                    echo $this->upload->display_error();
                }
                else
                {
                    $image = $this->upload->data('file_name');
                }    
            }

            $data = array(
                'username' => $this->input->post('username'),
                'name' => $this->input->post('name'),
                'password' => md5($this->input->post('password')),
                'level' => $this->input->post('level'),
                'is_active' => $this->input->post('is_active'),
                'image' => $image
            );
            $this->db->insert('users', $data);
            $this->session->set_flashdata('type', 'success');
            $this->session->set_flashdata('message', 'Pengguna berhasil ditambah');
            redirect(base_url('users'));
        }
    }

    function _rules()
    {
        $this->form_validation->set_rules('username', 'Username', 'required|min_length[3]|trim|is_unique[users.username]');
        $this->form_validation->set_rules('name', 'Nama', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[4]');
        $this->form_validation->set_rules('level', 'Level', 'required');

        $this->form_validation->set_message('min_length', '{field} harus minimal {param} karakter');
        $this->form_validation->set_message('is_unique','{field} tersebut sudah digunakan');
        $this->form_validation->set_message('required','{field} harus diisi');

        $this->form_validation->set_error_delimiters('<div class="text-red">', '</div>');
    }

    public function ubah($id)
    {
        $user = $this->db->get_where('users', array('id'=>$id)); 
        if($user->num_rows()>0){
            $data['codejs'] = 'user/codejs';
            $data['main_title'] = 'Users';
            $data['sub_title'] = 'Ubah Users';
            $data['content'] = 'user/form_ubah';
            $data['user'] = $user->row();
            $this->load->view('template',$data);
        }else{
            redirect(base_url('users'));
        }
    }
    
    public function proses_ubah()
    {        
        $image = $_FILES['image']['name'];
        if($image!=null){
            $config['upload_path']      = './assets/img/';
            $config['allowed_types']    = 'gif|jpg|png|jpeg|JPEG|JPG|PNG';
            $config['file_name']        = 'image_'.$this->input->post('username').'_'.time();
            $config['overwrite']        = true;
            
            $this->load->library('upload', $config);
            if (!$this->upload->do_upload('image'))
            {
                echo $this->upload->display_error();
            }
            else
            {
                $image = $this->upload->data('file_name');
                $this->db->set('image',$image);
            }
        }

        $password = $this->input->post('password');
        if($password!=null){
            $this->db->set('password',md5($password));
        }

        $nama = $this->input->post('name');
        $level = $this->input->post('level');
        $aktiv = $this->input->post('is_active');

        $this->db->set('name',$nama);
        $this->db->set('level',$level);
        $this->db->set('is_active',$aktiv);

        $this->db->where('username', $this->input->post('username'));
        $this->db->update('users');

        $this->session->set_flashdata('type', 'success');
        $this->session->set_flashdata('message', 'Pengguna berhasil diubah');
        redirect(base_url('users'));
    }

    public function aktifnonaktif($id)
    {
        $user = $this->db->get_where('users', array('id'=>$id));
        if($user->num_rows()>0){
            $user = $user->row();
            if($user->is_active==1){
                $this->db->set('is_active',0);
                $this->session->set_flashdata('message', 'Pengguna berhasil dinonaktifkan');
            }else{
                $this->db->set('is_active',1);
                $this->session->set_flashdata('message', 'Pengguna berhasil diaktifkan');
            }
            $this->db->where('id',$id);
            $this->db->update('users');
            $this->session->set_flashdata('type', 'success');
            redirect(base_url('users'));
        }else{
            redirect(base_url('users'));
        }
    }
}