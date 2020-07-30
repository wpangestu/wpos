<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Product_model extends CI_Model
{

    public $table = 'product';
    public $id = 'id_product';
    public $order = 'DESC';
 
    function __construct()
    {
        parent::__construct();
    }

    // datatables
    function json() {
        if(getuser()->level=="admin"){
            $this->datatables->select('id_product,name_product,product.description,stock,price,price_sale,price_sale_3,price_sale_5,price_sale_10,category.name as category_id,create_at,update_at');
            $this->datatables->from('product');
            //add this line for join
            $this->datatables->join('category', 'category.id = product.category_id','left');
            $this->datatables->add_column('action',
            anchor(site_url('product/read/$1'),'<i class="fa fa-search"></i>','title="Detail" data-toggle="tooltip" class="btn bg-navy btn-xs"').' '.
            anchor(site_url('product/update/$1'),'<i class="fa fa-edit"></i>','data-toggle="tooltip" data-placement="top" title="Ubah" class="btn btn-info btn-xs"').' '.
            anchor(site_url('product/delete/$1'),'<i class="fa fa-trash-o"></i>','title="Hapus" data-toggle="tooltip" class="btn btn-danger btn-xs" onclick="javasciprt: return confirm(\'Apa anda yakin ?\')"').' ',
            'id_product');
            return $this->datatables->generate();
        }else{
            $this->datatables->select('id_product,name_product,product.description,stock,price,price_sale,price_sale_3,price_sale_5,price_sale_10,category.name as category_id,create_at,update_at');
            $this->datatables->from('product');
            //add this line for join
            $this->datatables->join('category', 'category.id = product.category_id');
            $this->datatables->add_column('action',
            anchor(site_url('product/read/$1'),'<i class="fa fa-search"></i>','title="Detail" data-toggle="tooltip" class="btn bg-navy btn-xs"').'',
            'id_product');
            return $this->datatables->generate();
        }
    }

    // datatables kasir
    function json_for_kasir() {
        $this->datatables->select('id_product,name_product,product.description,stock,price,price_sale,category.name as category_id,create_at');
        $this->datatables->from('product');
        //add this line for join
        $this->datatables->join('category', 'category.id = product.category_id');
        $this->datatables->add_column('action', '<button type="button" data-id="$1" class="pilihbarang btn btn-info btn-xs"><i class="fa fa-check"></i> Pilih</button>','id_product');
        return $this->datatables->generate();
    }

    // get all
    function get_all()
    {
        $this->db->order_by($this->id, $this->order);
        return $this->db->get($this->table)->result();
    }

    // get data by id
    function get_by_id($id)
    {
        $this->db->select($this->table.'.*, category.name as category_id');
        $this->db->where($this->id, $id);
        $this->db->join('category', 'category.id = product.category_id','left');
        return $this->db->get($this->table)->row();
    }
    
    // get total rows
    function total_rows($q = NULL) {
        $this->db->like('id_product', $q);
	$this->db->or_like('name_product', $q);
	$this->db->or_like('description', $q);
	$this->db->or_like('stock', $q);
	$this->db->or_like('price', $q);
	$this->db->or_like('price_sale', $q);
	$this->db->or_like('category_id', $q);
	$this->db->or_like('create_at', $q);
	$this->db->or_like('update_at', $q);
	$this->db->from($this->table);
        return $this->db->count_all_results();
    }

    // get data with limit and search
    function get_limit_data($limit, $start = 0, $q = NULL) {
        $this->db->order_by($this->id, $this->order);
        $this->db->like('id_product', $q);
	$this->db->or_like('name_product', $q);
	$this->db->or_like('description', $q);
	$this->db->or_like('stock', $q);
	$this->db->or_like('price', $q);
	$this->db->or_like('price_sale', $q);
	$this->db->or_like('category_id', $q);
	$this->db->or_like('create_at', $q);
	$this->db->or_like('update_at', $q);
	$this->db->limit($limit, $start);
        return $this->db->get($this->table)->result();
    }

    // insert data
    function insert($data)
    {
        $this->db->insert($this->table, $data);
    } 

    // update data
    function update($id, $data)
    {
        $this->db->where($this->id, $id);
        $this->db->update($this->table, $data);
    }

    // delete data
    function delete($id)
    {
        $this->db->where($this->id, $id);
        $this->db->delete($this->table);
    }

    function search_product($query){
        $this->db->like('name_product', $query , 'both');
        $this->db->order_by('name_product', 'ASC');
        $this->db->limit(10);
        return $this->db->get('product')->result();
    }

}

/* End of file Product_model.php */
/* Location: ./application/models/Product_model.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2019-08-28 04:57:26 */
/* http://harviacode.com */