<?php
class Profile extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        check_is_login();
    }
    public function index()
    {
        $data['main_title'] = 'Profile';
        $data['sub_title'] = 'My Profile';
        $data['user'] = $this->db->get_where('users', array('id'=>getuser()->id))->row();
        $data['tab'] = '1';
        $data['content'] = 'user/profile';
        $data['codejs'] = 'user/codejs';
        $this->load->view('template',$data);
    }

    function _rules()
    {
        $this->form_validation->set_rules('username_new','Username', 'min_length[3]|is_unique[users.username]');
        $this->form_validation->set_rules('name','Nama', 'required');
        $this->form_validation->set_rules('password','Password', 'min_length[5]');
        $this->form_validation->set_message('required', '{field} tidak boleh kosong');
        $this->form_validation->set_message('is_unique', '{field} sudah digunakan');
        $this->form_validation->set_error_delimiters('<span class="text-red">','</span>');
    }

    public function update()
    {
        $this->_rules();
        if($this->form_validation->run()==false){
            $data['main_title'] = 'Profile';
            $data['sub_title'] = 'My Profile';
            $data['user'] = $this->db->get_where('users', array('id'=>getuser()->id))->row();
            $data['content'] = 'user/profile';
            $data['codejs'] = 'user/codejs';
            $data['tab'] = '2';
            $this->load->view('template',$data);
        }else{
            $image = $_FILES['image']['name'];    
            $username = $this->input->post('username_new');
            $nama = $this->input->post('name');
            $password = $this->input->post('password');
            
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

            if($username!=null){
                $this->db->set('username',$username);
            }
            
            if($password!=null){
                $this->db->set('password',md5($password));
            }

            $this->db->set('name',$nama);
            $this->db->where('id', getuser()->id);
            $this->db->update('users');

            redirect(base_url('profile'));
        }
    }


    
}