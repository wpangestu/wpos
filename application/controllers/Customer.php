<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Customer extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        check_is_login();
        $this->load->model('Customer_model');
        $this->load->library('form_validation');        
        $this->load->library('datatables');
    }

    public function index()
    {
        $data['main_title'] = 'Pelanggan';
        $data['sub_title'] = 'Data Pelaggan';
        $data['content'] = 'customer/customer_list';
        $data['codejs'] = 'customer/codejs';
        $data['newid'] = getAutoNumber('customer','id_customer','P',4);
        $this->load->view('template',$data);
    } 
    
    public function json() {
        header('Content-Type: application/json');
        echo $this->Customer_model->json();
    }

    public function read($id) 
    {
        $row = $this->Customer_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id' => $row->id,
		'id_customer' => $row->id_customer,
		'name_customer' => $row->name_customer,
		'gender' => $row->gender,
		'address' => $row->address,
		'phone' => $row->phone,
		'create_at' => $row->create_at,
		'update_at' => $row->update_at,
	    );
            $this->load->view('customer/customer_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('customer'));
        }
    }

    public function create() 
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('customer/create_action'),
	    'id' => set_value('id'),
	    'id_customer' => set_value('id_customer'),
	    'name_customer' => set_value('name_customer'),
	    'gender' => set_value('gender'),
	    'address' => set_value('address'),
	    'phone' => set_value('phone'),
	    'create_at' => set_value('create_at'),
	    'update_at' => set_value('update_at'),
	);
        $this->load->view('customer/customer_form', $data);
    }
    
    public function create_action() 
    {
    
        $data = array(
		'id_customer' => $this->input->post('id_customer',TRUE),
		'name_customer' => $this->input->post('name_customer',TRUE),
		'gender' => $this->input->post('gender',TRUE),
		'address' => $this->input->post('address',TRUE),
		'phone' => $this->input->post('phone',TRUE),
	    );

        $cek = $this->db->get_where('customer', array('id_customer' => $data['id_customer']));
        if($cek->num_rows() > 0 ) {
            $this->session->set_flashdata('message', 'Kode Pelanggan sudah digunakan');
            $this->session->set_flashdata('type', 'failed');
        }else{
            $this->Customer_model->insert($data);
            $this->session->set_flashdata('message', 'Data berhasil ditambah');
            $this->session->set_flashdata('type', 'success');
        }
        redirect(site_url('customer'));        
    }

    public function quickAddCustomer()
    {

        $data = array(
            'id_customer' => $this->input->post('id_customer',TRUE),
            'name_customer' => ucfirst($this->input->post('name_customer',TRUE)),
            'gender' => $this->input->post('gender',TRUE),
            'address' => $this->input->post('address',TRUE),
            'phone' => $this->input->post('phone',TRUE),
        );

        $this->db->insert('customer',$data);

        $id = $this->db->insert_id();

        $data = $this->Customer_model->get_by_id($id);

        $result = array(
            'id' => $data->id_customer,
            'name' => $data->name_customer
        );

        echo json_encode($result);
    }
    
    public function update($id) 
    {
        $row = $this->Customer_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('customer/update_action'),
		'id' => set_value('id', $row->id),
		'id_customer' => set_value('id_customer', $row->id_customer),
		'name_customer' => set_value('name_customer', $row->name_customer),
		'gender' => set_value('gender', $row->gender),
		'address' => set_value('address', $row->address),
		'phone' => set_value('phone', $row->phone),
		'create_at' => set_value('create_at', $row->create_at),
		'update_at' => set_value('update_at', $row->update_at),
	    );
            $this->load->view('customer/customer_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('customer'));
        }
    }
    
    public function update_action() 
    {

            $data = array(
		'id_customer' => $this->input->post('id_customer',TRUE),
		'name_customer' => $this->input->post('name_customer',TRUE),
		'gender' => $this->input->post('gender',TRUE),
		'address' => $this->input->post('address',TRUE),
		'phone' => $this->input->post('phone',TRUE),
	    );

        $this->Customer_model->update($this->input->post('id', TRUE), $data);
        $this->session->set_flashdata('message', 'Ubah data berhasil');
        $this->session->set_flashdata('type', 'success');
        redirect(site_url('customer'));

    }
    
    public function delete($id) 
    {
        $row = $this->Customer_model->get_by_id($id);

        if ($row) {
            $this->Customer_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('customer'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('customer'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('id_customer', 'id customer', 'trim|required');
	$this->form_validation->set_rules('name_customer', 'name customer', 'trim|required');
	$this->form_validation->set_rules('gender', 'gender', 'trim|required');
	$this->form_validation->set_rules('address', 'address', 'trim|required');
	$this->form_validation->set_rules('phone', 'phone', 'trim|required');
	$this->form_validation->set_rules('create_at', 'create at', 'trim|required');
	$this->form_validation->set_rules('update_at', 'update at', 'trim|required');

	$this->form_validation->set_rules('id', 'id', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    public function get_number_customer()
    {
        $id_customer = getAutoNumber('customer','id_customer','P',4);
        echo $id_customer;
    }    

}

/* End of file Customer.php */
/* Location: ./application/controllers/Customer.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2019-10-11 09:38:24 */
/* http://harviacode.com */