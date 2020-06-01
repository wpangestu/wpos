<?php

if (!defined('BASEPATH'))
  exit('No direct script access allowed');

class Stock_model extends CI_Model
{

  public $table = 'stock_in_out';
  public $id = 'id';
  public $order = 'DESC';

  function __construct()
  {
    parent::__construct();
  }

  // get all
  function get_all($type)
  {
    $this->db->select($this->table . '.*, product.name_product');
    $this->db->join('product', 'product.id_product=' . $this->table . '.id_product', 'left');
    $this->db->where('type', $type);
    $this->db->order_by('datetime', 'DESC');
    $this->db->order_by('id', 'DESC');
    return $this->db->get($this->table);
  }

  // get total rows
  function total_rows($q = NULL)
  {
    $this->db->like('id', $q);
    $this->db->or_like('kode_unit', $q);
    $this->db->or_like('name', $q);
    $this->db->or_like('created', $q);
    $this->db->or_like('updated', $q);
    $this->db->from($this->table);
    return $this->db->count_all_results();
  }

  // get data with limit and search
  function get_limit_data($limit, $start = 0, $q = NULL)
  {
    $this->db->order_by($this->id, $this->order);
    $this->db->like('id', $q);
    $this->db->or_like('kode_unit', $q);
    $this->db->or_like('name', $q);
    $this->db->or_like('created', $q);
    $this->db->or_like('updated', $q);
    $this->db->limit($limit, $start);
    return $this->db->get($this->table)->result();
  }

  // insert data
  function insert($data)
  {
    $this->db->insert($this->table, $data);
  }

  // delete data
  function delete($id)
  {
    $this->db->where($this->id, $id);
    $this->db->delete($this->table);
  }
}
