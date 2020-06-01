<?php
class Supplier extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        check_is_login();
    }

    public function index()
    {
        $data['codejs'] = 'supplier/codejs';
        $data['main_title'] = 'Supplier';
        $data['sub_title'] = 'Data Supplier';
        $data['content'] = 'supplier/v_supplier';
        $data['supplier'] = $this->db->get('supplier');
        $this->load->view('template',$data);
    }

    public function tambah()
    {
        $data = array(
            'name' => $this->input->post('name'),
            'phone' => $this->input->post('telepon'),
            'address' => $this->input->post('alamat'),
            'description' => $this->input->post('keterangan'),
        );

        $tambah = $this->db->insert('supplier',$data);
        if($tambah){
            $this->session->set_flashdata('message', 'Data berhasil ditambah');
            $this->session->set_flashdata('type', 'success');
            redirect(base_url('supplier'));
        }else{
            $this->session->set_flashdata('message', 'Data gagal ditambah');
            $this->session->set_flashdata('type', 'failed');
            redirect(base_url('supplier'));
        }
    }

    public function update()
    {
        $id = $this->input->post('id');
        $data = array(
            'name' => $this->input->post('name'),
            'phone' => $this->input->post('telepon'),
            'address' => $this->input->post('alamat'),
            'description' => $this->input->post('keterangan'),
        );

        $this->db->where('supplier_id', $id);
        $tambah = $this->db->update('supplier',$data);
        
        if($tambah){
            $this->session->set_flashdata('message', 'Data berhasil diubah');
            $this->session->set_flashdata('type', 'success');
            redirect(base_url('supplier'));
        }else{
            $this->session->set_flashdata('message', 'Data gagal ditambah');
            $this->session->set_flashdata('type', 'failed');
            redirect(base_url('supplier'));
        }
    }

    public function delete($id)
    {
        if($id==null){
            $this->session->set_flashdata('message', 'Data gagal dihapus');
            $this->session->set_flashdata('type', 'failed');
            redirect(base_url('supplier'));
        }else{
            $get = $this->db->get_where('supplier', array('supplier_id' => $id));
            if($get->num_rows() > 0){
                $this->db->where('supplier_id', $id);
                $this->db->delete('supplier');
                $this->session->set_flashdata('message', 'Data berhasil dihapus');
                $this->session->set_flashdata('type', 'success');
                redirect(base_url('supplier'));
            }else{
                $this->session->set_flashdata('message', 'Data tidak ditemukan');
                $this->session->set_flashdata('type', 'failed');
                redirect(base_url('supplier'));
            }
        }
    }
}