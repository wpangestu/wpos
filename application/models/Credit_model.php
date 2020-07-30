<?php
if (!defined('BASEPATH'))
  exit('No direct script access allowed');

class Credit_model extends CI_Model
{

  function __construct()
  {
    parent::__construct();
  }

  function get_detail_credit($invoice)
  {
    return $this->db->select('sales.*,customer.name_customer,customer.address,users.username')
                ->where('invoice',$invoice)
                ->join('customer','customer.id_customer = sales.id_customer','left')
                ->join('users','users.id = sales.id_user','left')
                ->get('sales');
  }

  function get_payment_credit($invoice)
  {
    return $this->db->select('credit_payment.*,username')
                ->where('invoice',$invoice)
                ->join('users','users.id = created_by','left')
                ->order_by('created_at','asc')
                ->get('credit_payment');
  }
}