<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Product extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        check_is_login();
        $this->load->model('Product_model');
        $this->load->library('form_validation');        
	    $this->load->library('datatables');
    }

    public function index()
    {
        $data['codejs'] = 'product/codejs';
        $data['main_title'] = 'Barang';
        $data['sub_title'] = 'List Barang';
        $data['content'] = 'product/product_list';
        $this->load->view('template',$data);
    }

    public function json() {
        header('Content-Type: application/json');
        echo $this->Product_model->json();
    }

    public function read($id) 
    {
        $row = $this->Product_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id_product' => $row->id_product,
		'name_product' => $row->name_product,
		'description' => $row->description,
		'stock' => $row->stock,
		'price' => $row->price,
		'price_sale' => $row->price_sale,
		'price_sale_3' => $row->price_sale_3,
		'price_sale_5' => $row->price_sale_5,
		'price_sale_10' => $row->price_sale_10,
		'category_id' => $row->category_id,
		'create_at' => $row->create_at,
        'update_at' => $row->update_at,
        'main_title' => 'Barang',
        'sub_title' => 'Tambah Barang',
        'content' => 'product/product_read',
	    );
            $this->load->view('template', $data);
        } else {
            $this->session->set_flashdata('type', 'failed');
            $this->session->set_flashdata('message', 'Data tidak ditemukan');
            redirect(site_url('product'));
        }
    }

    public function create() 
    {
        $data = array(
            'main_title' => 'Barang',
            'sub_title' => 'Tambah Barang',
            'content' => 'product/product_form',
            'button' => 'Simpan',
            'codejs' => 'product/codejs',
            'kategori' => $this->db->get('category'),
            'action' => site_url('product/create_action'),
	    'kode_product' => set_value('kode_product'),
	    'name_product' => set_value('name_product'),
	    'description' => set_value('description'),
	    'stock' => set_value('stock'),
	    'price' => set_value('price'),
	    'price_sale' => set_value('price_sale'),
	    'price_sale_3' => set_value('price_sale_3'),
	    'price_sale_5' => set_value('price_sale_5'),
	    'price_sale_10' => set_value('price_sale_10'),
	    'category_id' => set_value('category_id'),
	);
        $this->load->view('template', $data);
    }
    
    public function generate_kode()
    {
        $tgl = $this->input->post('prefix');
        $kode = getAutoNumber('product','id_product','BRG'.$tgl,12);
        echo $kode;
    }

    public function create_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
		'id_product' => $this->input->post('kode_product',TRUE),
		'name_product' => strtoupper($this->input->post('name_product',TRUE)),
		'description' => $this->input->post('description',TRUE),
		'stock' => $this->input->post('stock',TRUE),
		'price' => str_replace('.','',$this->input->post('price',TRUE)),
		'price_sale' => str_replace('.','',$this->input->post('price_sale',TRUE)),
		'price_sale_3' => str_replace('.','',$this->input->post('price_sale_3',TRUE)),
		'price_sale_5' => str_replace('.','',$this->input->post('price_sale_5',TRUE)),
		'price_sale_10' => str_replace('.','',$this->input->post('price_sale_10',TRUE)),
		'category_id' => $this->input->post('category_id',TRUE),
	    );

            $this->Product_model->insert($data);
            $this->session->set_flashdata('type', 'success');
            $this->session->set_flashdata('message', 'Data berhasil ditambah');
            redirect(site_url('product'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Product_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Simpan',
                'action' => site_url('product/update_action'),
                'kategori' => $this->db->get('category'),
		'kode_product' => set_value('kode_product', $row->id_product),
		'name_product' => set_value('name_product', $row->name_product),
		'description' => set_value('description', $row->description),
		'stock' => set_value('stock', $row->stock),
		'price' => set_value('price', $row->price),
		'price_sale' => set_value('price_sale', $row->price_sale),
		'price_sale_3' => set_value('price_sale_3', $row->price_sale_3),
		'price_sale_5' => set_value('price_sale_5', $row->price_sale_5),
		'price_sale_10' => set_value('price_sale_10', $row->price_sale_10),
		'category_id' => set_value('category_id', $row->category_id),
        'main_title' => 'Barang',
        'sub_title' => 'Ubah Data Barang',
        'content' => 'product/form_update',
        'codejs' => 'product/codejs'
	    );
            $this->load->view('template', $data);
        } else {
            $this->session->set_flashdata('type', 'failed');
            $this->session->set_flashdata('message', 'Data tidak ditemukan');
            redirect(site_url('product'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules_update();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_product', TRUE));
        } else {
            $data = array(
		'name_product' => strtoupper($this->input->post('name_product',TRUE)),
		'description' => $this->input->post('description',TRUE),
		'stock' => $this->input->post('stock',TRUE),
		'price' => str_replace('.','',$this->input->post('price',TRUE)),
		'price_sale' => str_replace('.','',$this->input->post('price_sale',TRUE)),
		'price_sale_3' => str_replace('.','',$this->input->post('price_sale_3',TRUE)),
		'price_sale_5' => str_replace('.','',$this->input->post('price_sale_5',TRUE)),
		'price_sale_10' => str_replace('.','',$this->input->post('price_sale_10',TRUE)),
		'category_id' => $this->input->post('category_id',TRUE)
	    );

            $this->Product_model->update($this->input->post('id_product', TRUE), $data);
            $this->session->set_flashdata('type', 'success');
            $this->session->set_flashdata('message', 'Data berhasil diubah');
            redirect(site_url('product'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Product_model->get_by_id($id);

        if ($row) {
            $this->Product_model->delete($id);
            $this->session->set_flashdata('message', 'Data berhasil dihapus');
            $this->session->set_flashdata('type', 'success');
            redirect(site_url('product'));
        } else {
            $this->session->set_flashdata('message', 'Data tidak ditemukan');
            $this->session->set_flashdata('type', 'failed');
            redirect(site_url('product'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('kode_product', 'Kode Barang', 'trim|required|is_unique[product.id_product]');
	$this->form_validation->set_rules('name_product', 'Nama barang', 'trim|required');
	$this->form_validation->set_rules('stock', 'Stok', 'trim|required|is_natural_no_zero');
	$this->form_validation->set_rules('price', 'Harga Pokok', 'trim|required');
	$this->form_validation->set_rules('price_sale', 'Harga Jual', 'trim|required');
	$this->form_validation->set_rules('price_sale_3', 'Harga Jual min. 3', 'trim');
	$this->form_validation->set_rules('price_sale_5', 'Harga Jual min. 5', 'trim');
	$this->form_validation->set_rules('price_sale_10', 'Harga Jual min. 10', 'trim');
	$this->form_validation->set_rules('category_id', 'Kategori', 'trim|required');

    $this->form_validation->set_message('is_unique', '{field} tersebut sudah digunakan');
    $this->form_validation->set_message('required', '{field} harus diisi');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    public function _rules_update() 
    {
	$this->form_validation->set_rules('name_product', 'Nama barang', 'trim|required');
	$this->form_validation->set_rules('stock', 'Stok', 'trim|required');
	$this->form_validation->set_rules('price', 'Harga Pokok', 'trim|required');
	$this->form_validation->set_rules('price_sale', 'Harga Jual', 'trim|required');
	$this->form_validation->set_rules('category_id', 'Kategori', 'trim|required');

    $this->form_validation->set_message('is_unique', '{field} tersebut sudah digunakan');
    $this->form_validation->set_message('required', '{field} harus diisi');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }



    public function excel()
    {
        $this->load->helper('exportexcel');
        $namaFile = "product.xls";
        $judul = "product";
        $tablehead = 0;
        $tablebody = 1;
        $nourut = 1;
        //penulisan header
        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0,pre-check=0");
        header("Content-Type: application/force-download");
        header("Content-Type: application/octet-stream");
        header("Content-Type: application/download");
        header("Content-Disposition: attachment;filename=" . $namaFile . "");
        header("Content-Transfer-Encoding: binary ");

        xlsBOF();

        $kolomhead = 0;
        xlsWriteLabel($tablehead, $kolomhead++, "No");
	xlsWriteLabel($tablehead, $kolomhead++, "Name Product");
	xlsWriteLabel($tablehead, $kolomhead++, "Description");
	xlsWriteLabel($tablehead, $kolomhead++, "Stock");
	xlsWriteLabel($tablehead, $kolomhead++, "Price");
	xlsWriteLabel($tablehead, $kolomhead++, "Price Sale");
	xlsWriteLabel($tablehead, $kolomhead++, "Category Id");
	xlsWriteLabel($tablehead, $kolomhead++, "Create At");
	xlsWriteLabel($tablehead, $kolomhead++, "Update At");

	foreach ($this->Product_model->get_all() as $data) {
            $kolombody = 0;

            //ubah xlsWriteLabel menjadi xlsWriteNumber untuk kolom numeric
            xlsWriteNumber($tablebody, $kolombody++, $nourut);
	    xlsWriteLabel($tablebody, $kolombody++, $data->name_product);
	    xlsWriteLabel($tablebody, $kolombody++, $data->description);
	    xlsWriteNumber($tablebody, $kolombody++, $data->stock);
	    xlsWriteLabel($tablebody, $kolombody++, $data->price);
	    xlsWriteLabel($tablebody, $kolombody++, $data->price_sale);
	    xlsWriteNumber($tablebody, $kolombody++, $data->category_id);
	    xlsWriteLabel($tablebody, $kolombody++, $data->create_at);
	    xlsWriteLabel($tablebody, $kolombody++, $data->update_at);

	    $tablebody++;
            $nourut++;
        }

        xlsEOF();
        exit();
    }

}

/* End of file Product.php */
/* Location: ./application/controllers/Product.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2019-08-28 04:57:26 */
/* http://harviacode.com */