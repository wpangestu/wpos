<?php
class Report_model extends CI_Model {

    public function getsalesbetween($start,$end,$id_customer=null,$type=null,$o_asc_desc=null)
    {
      $this->db->select('sales.*, users.username, customer.name_customer');
      $this->db->where('DATE(datetime_sales) >=', datemysql($start));
      $this->db->where('DATE(datetime_sales) <=', datemysql($end));
      if($type!=null){
        $this->db->where('type', $type);
      }else{
        $this->db->where('type', 'cash');
      }
      if($id_customer!=null){
        $this->db->where('sales.id_customer', $id_customer);
      }
      $this->db->join('users', 'users.id = sales.id_user');
      $this->db->join('customer', 'customer.id_customer = sales.id_customer');
      if($o_asc_desc==null){
        $this->db->order_by('datetime_sales', 'ASC');
      }else{
        $this->db->order_by('datetime_sales', $o_asc_desc);
      }
      return $this->db->get('sales');
    }

    function getsale_detail($start, $end)
    {
      $this->db->select('sale_detail.*,sales.datetime_sales, users.username');
      $this->db->where('DATE(datetime_sales) >=', datemysql($start));
      $this->db->where('DATE(datetime_sales) <=', datemysql($end));
      $this->db->join('sales', 'sales.invoice = sale_detail.invoice');
      $this->db->join('users', 'users.id = sales.id_user');
      $this->db->order_by('datetime_sales', 'ASC');
      return $this->db->get('sale_detail');
    }
    
    function getselling($start, $end){
      return $this->db->query('
        SELECT datetime_sales, sale_detail.invoice, SUM(sub_total) as total, SUM(sub_total - price*qty) as untung , username, name_customer
        FROM sale_detail
        LEFT JOIN sales ON sales.invoice = sale_detail.invoice
        LEFT JOIN users ON users.id = sales.id_user
        LEFT JOIN customer ON customer.id_customer = sales.id_customer
        WHERE DATE_FORMAT(datetime_sales, "%Y-%m-%d") >= "'.datemysql($start).'"
        AND DATE_FORMAT(datetime_sales, "%Y-%m-%d") <= "'.datemysql($end).'"
        GROUP BY invoice
        ORDER BY datetime_sales ASC
        ');
    }
    
    function get_sell_daily($start,$end,$id_customer=null)
    {
      $this->db->select('DATE_FORMAT(datetime_sales,"%Y-%m-%d") as tanggal, SUM(price*qty) as modal, SUM(sub_total) as total, SUM(sub_total - price*qty) as untung');
      $this->db->join('sales', 'sales.invoice = sale_detail.invoice', 'left');
      if($id_customer!=null){
        $this->db->where('sales.id_customer', $id_customer);
      }
      $this->db->where('DATE_FORMAT(datetime_sales,"%Y-%m-%d") >=', $start);
      $this->db->where('DATE_FORMAT(datetime_sales,"%Y-%m-%d") <=', $end);
      $this->db->group_by('DATE_FORMAT(datetime_sales,"%Y-%m-%d")');
      $this->db->order_by('datetime_sales', 'ASC');
      return $this->db->get('sale_detail');
    }
    
    function sell_monthly($start,$end,$id_customer=null)
    {
      $this->db->select('DATE_FORMAT(datetime_sales,"%Y-%m") as bulan, SUM(price*qty) as modal, SUM(sub_total) as total, SUM(sub_total - price*qty) as untung');
      $this->db->join('sales', 'sales.invoice = sale_detail.invoice', 'left');
      $this->db->where('DATE_FORMAT(datetime_sales,"%Y-%m") >=', $start);
      $this->db->where('DATE_FORMAT(datetime_sales,"%Y-%m") <=', $end);
      if($id_customer!=null){
        $this->db->where('sales.id_customer', $id_customer);
      }
      $this->db->group_by('DATE_FORMAT(datetime_sales,"%Y-%m")');
      $this->db->order_by('datetime_sales', 'ASC');
      return $this->db->get('sale_detail');
    }

    function sell_yearly($start,$end,$id_customer=null)
    {
      $this->db->select('DATE_FORMAT(datetime_sales,"%Y") as tahun, SUM(price*qty) as modal, SUM(sub_total) as total, SUM(sub_total - price*qty) as untung');
      $this->db->join('sales', 'sales.invoice = sale_detail.invoice', 'left');
      $this->db->where('DATE_FORMAT(datetime_sales,"%Y") >=', $start);
      $this->db->where('DATE_FORMAT(datetime_sales,"%Y") <=', $end);
      if($id_customer!=null){
        $this->db->where('sales.id_customer', $id_customer);
      }
      $this->db->group_by('DATE_FORMAT(datetime_sales,"%Y")');
      $this->db->order_by('datetime_sales', 'ASC');
      return $this->db->get('sale_detail');
    }

    function get_stok_in_out($start,$end,$type)
    {
      $this->db->select('stock_in_out.*, name_product');
      $this->db->join('product', 'product.id_product=stock_in_out.id_product','left');
      $this->db->where('datetime >=', $start);
      $this->db->where('datetime <=', $end);
      if($type!=2){
        $this->db->where('type', $type);
      }
      $this->db->order_by('datetime', 'ASC');
      return $this->db->get('stock_in_out');
    }

    public function getpurchase($start,$end)
    {
      $this->db->select('purchase.*, users.username, supplier.name');
      $this->db->where('DATE(datetime_purchase) >=', $start);
      $this->db->where('DATE(datetime_purchase) <=', $end);
      $this->db->join('users', 'users.id = purchase.id_user', 'left');
      $this->db->join('supplier', 'supplier.supplier_id = purchase.id_supplier', 'left');
      $this->db->order_by('datetime_purchase', 'ASC');
      return $this->db->get('purchase');
    }

    public function getpurchasedetail($invoice)
    {
      $this->db->select('purchase_detail.*, users.username, datetime_purchase, supplier.name');
      $this->db->where('purchase_detail.id_purchase =', $invoice);
      $this->db->join('purchase', 'purchase.id_purchase = purchase_detail.id_purchase', 'left');
      $this->db->join('users', 'users.id = purchase.id_user', 'left');
      $this->db->join('supplier', 'supplier.supplier_id = purchase.id_supplier', 'left');
      return $this->db->get('purchase_detail');
    }

    public function get_struk_sale($invoice)
    {
      $this->db->select('sale_detail.*, users.username, datetime_sales, pay_money, refund, total_sales');
      $this->db->where('sale_detail.invoice =', $invoice);
      $this->db->join('sales', 'sales.invoice =sale_detail.invoice', 'left');
      $this->db->join('users', 'users.id = sales.id_user', 'left');
      return $this->db->get('sale_detail');
    }

    // public function get_sale_customer($start,$end)
    // {
    //   $this->db->select('sum(total_sales) as total, customer.id_customer, customer.name_customer');
    //   $this->db->where('DATE(datetime_sales) >=', $start);
    //   $this->db->where('DATE(datetime_sales) <=', $end);
    //   $this->db->join('customer', 'customer.id_customer = sales.id_customer','right');
    //   $this->db->order_by('name_customer', 'ASC');
    //   $this->db->group_by('name_customer');
    //   return $this->db->get('sales');
    // }

    public function get_sale_customer($start,$end)
    {
      $this->db->select('sum(total_sales) as total, customer.id_customer, customer.name_customer');
      $this->db->join('sales', 'sales.id_customer = customer.id_customer');
      $this->db->order_by('name_customer', 'ASC');
      $this->db->group_by('name_customer');
      $this->db->where('DATE(datetime_sales) >=', $start);
      $this->db->where('DATE(datetime_sales) <=', $end);
      return $this->db->get('customer');
    }

    function get_sale_customer_detail($start,$end,$kode)
    {
      $this->db->select('customer.id_customer, customer.name_customer, DATE_FORMAT(datetime_sales,"%Y-%m") as bulan, SUM(total_sales) as total');
      $this->db->join('customer', 'customer.id_customer = sales.id_customer', 'left');
      $this->db->where('DATE_FORMAT(datetime_sales,"%Y-%m") >=', $start);
      $this->db->where('DATE_FORMAT(datetime_sales,"%Y-%m") <=', $end);
      $this->db->where('sales.id_customer', $kode);
      $this->db->group_by('DATE_FORMAT(datetime_sales,"%Y-%m")');
      $this->db->order_by('datetime_sales', 'ASC');
      return $this->db->get('sales');
    }

    function get_last_sell_customer($kode)
    {
      $this->db->select('datetime_sales');
      $this->db->where('id_customer',$kode);
      $this->db->order_by('datetime_sales', 'DESC');
      $this->db->limit('1');
      return $this->db->get('sales');
    }

}