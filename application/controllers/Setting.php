<?php

class Setting extends CI_Controller {

    public function __construct()
    {
      parent::__construct();
      check_is_login();
      is_admin();
    }

    public function index()
    {
      $data['setting'] = $this->db->get('setting')->row();
      $data['main_title'] = 'Pengaturan';
      $data['sub_title'] = 'Pengaturan Aplikasi';
      $data['content'] = 'setting/index';
      $data['codejs'] = 'setting/codejs';
      $this->load->view('template',$data);
    }

    public function ubah_setting()
    {
      $image = $_FILES['image']['name'];
        if($image!=null){
            $config['upload_path']      = './assets/img/';
            $config['allowed_types']    = 'gif|jpg|png|jpeg|JPEG|JPG|PNG';
            $config['file_name']        = 'logo_toko';
            $config['overwrite']        = true;
            
            $this->load->library('upload', $config);
            if (!$this->upload->do_upload('image'))
            {
                echo $this->upload->display_error();
            }
            else
            {
                $image = $this->upload->data('file_name');
                $this->db->set('logo',$image);
            }
        }

        $nmtoko = $this->input->post('nm_toko');
        $keterangan = $this->input->post('keterangan');
        $footer = $this->input->post('footer_struk');
        $printer = $this->input->post('printer_name');

        $this->db->set('nm_toko',$nmtoko);
        $this->db->set('keterangan_toko',$keterangan);
        $this->db->set('footer_struk',$footer);
        $this->db->set('printer_name',$printer);

        $this->db->where('id', 1);
        $this->db->update('setting');

        $this->session->set_flashdata('message', 'Data berhasil dihapus');
        // $this->session->set_flashdata('type', 'success');
        
        redirect(base_url('setting'));
    }

    public function theme($skin){
      $this->db->set('theme',$skin);

      $this->db->where('id', 1);
      $this->db->update('setting');

      redirect(base_url('setting'));
    }
}