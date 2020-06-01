<?php
if (!defined('BASEPATH'))
  exit('No direct script access allowed');

class Chart_model extends CI_Model
{

  function __construct()
  {
    parent::__construct();
  }

  function get_sale($bulan)
  {
    $this->db->select('DATE_FORMAT(datetime_sales,"%Y-%m-%d") as tanggal, SUM(price*qty) as modal, SUM(sub_total) as total, SUM(sub_total - price*qty) as untung');
    $this->db->join('sales', 'sales.invoice = sale_detail.invoice', 'left');
    $this->db->where('DATE_FORMAT(datetime_sales,"%Y-%m") =', $bulan);
    $this->db->group_by('DATE_FORMAT(datetime_sales,"%Y-%m-%d")');
    $this->db->order_by('datetime_sales', 'ASC');
    $query = $this->db->get('sale_detail');
    
    $record = $query->result();
    $data = [];

    foreach($record as $row) {
          $data['label'][] = $row->tanggal;
          $data['data'][] = (int) $row->total;
    }
    return $data;
  }

  function get_sale_by_bulan($bulan)
  {
    $this->db->select('DATE_FORMAT(datetime_sales,"%Y-%m-%d") as tanggal, SUM(price*qty) as modal, SUM(sub_total) as total, SUM(sub_total - price*qty) as untung');
    $this->db->join('sales', 'sales.invoice = sale_detail.invoice', 'left');
    $this->db->where('DATE_FORMAT(datetime_sales,"%Y-%m") =', $bulan);
    $this->db->group_by('DATE_FORMAT(datetime_sales,"%Y-%m-%d")');
    $this->db->order_by('datetime_sales', 'ASC');
    return $this->db->get('sale_detail');

  }

  function get_sale_last_recored($last)
  {
    $this->db->select('DATE_FORMAT(datetime_sales,"%Y-%m-%d") as tanggal, SUM(price*qty) as modal, SUM(sub_total) as total, SUM(sub_total - price*qty) as untung');
    $this->db->join('sales', 'sales.invoice = sale_detail.invoice', 'left');
    $this->db->group_by('DATE_FORMAT(datetime_sales,"%Y-%m-%d")');
    $this->db->order_by('datetime_sales', 'DESC');
    $this->db->limit($last); 
    return $this->db->get('sale_detail');

  }

  function get_last($limit)
  {
    $this->db->select('DATE_FORMAT(datetime_sales,"%Y-%m-%d") as tanggal, SUM(price*qty) as modal, SUM(sub_total) as total, SUM(sub_total - price*qty) as untung');
    $this->db->join('sales', 'sales.invoice = sale_detail.invoice', 'left');
    $this->db->where('DATE_FORMAT(datetime_sales,"%Y-%m-%d") >= DATE(NOW()) - INTERVAL '.$limit.' DAY');
    $this->db->group_by('DATE_FORMAT(datetime_sales,"%Y-%m-%d")');
    $this->db->order_by('datetime_sales', 'DESC');
    return $this->db->get('sale_detail');
  }

  function get_sale_by_tahun($tahun)
  {
    $this->db->select('DATE_FORMAT(datetime_sales,"%Y-%m") as bulan, SUM(price*qty) as modal, SUM(sub_total) as total, SUM(sub_total - price*qty) as untung');
    $this->db->join('sales', 'sales.invoice = sale_detail.invoice', 'left');
    $this->db->where('DATE_FORMAT(datetime_sales,"%Y") =', $tahun);
    $this->db->group_by('DATE_FORMAT(datetime_sales,"%Y-%m")');
    $this->db->order_by('datetime_sales', 'ASC');
    return $this->db->get('sale_detail');
  }

  function get_total_penjualan($bulan)
  {
    $this->db->select_sum('total_sales','total');
    $this->db->where('DATE_FORMAT(datetime_sales,"%Y-%m") =', $bulan);
    return $this->db->get('sales');
  }

  function get_transaksi($bulan)
  {
    $this->db->where('DATE_FORMAT(datetime_sales,"%Y-%m") =', $bulan);
    return $this->db->count_all_results('sales');
  }

  function get_most_sale($bulan,$jml)
  {
    $this->db->select('kode_product, name_product, sum(qty) as jumlah');
    $this->db->join('sales', 'sales.invoice = sale_detail.invoice', 'left');
    $this->db->where('DATE_FORMAT(datetime_sales,"%Y-%m") =', $bulan);
    $this->db->group_by('kode_product');
    $this->db->order_by('jumlah', 'DESC');
    $this->db->limit($jml);
    return $this->db->get('sale_detail');
  }

  public function get_jml_user()
  {
    return $this->db->count_all('users');
  }

  public function get_last_sale_per_day($limit){
    
    $today=date('Y-m-d');
    $begin = new DateTime($today);
    $begin = $begin->modify( '+1 day' );
    $end = new DateTime($today);
    $end = $end->modify( '-'.$limit.' day' );
    $interval = new DateInterval('P1D');
    $daterange = new DatePeriod($end, $interval ,$begin);
    
    $data=array();
    
    foreach($daterange as $date){
        $this->db->select('DATE_FORMAT(datetime_sales,"%Y-%m-%d") as tanggal, SUM(price*qty) as modal, SUM(sub_total) as total, SUM(sub_total - price*qty) as untung');
        $this->db->join('sales', 'sales.invoice = sale_detail.invoice', 'left');
        $this->db->where('DATE_FORMAT(datetime_sales,"%Y-%m-%d") = ',$date->format('Y-m-d'));
        $data_single = $this->db->get('sale_detail')->row();

        $temp = array(
            "tanggal" => $date->format('Y-m-d'),
            "untung" => $data_single->untung != null ? $data_single->untung : 0,
            "total" => $data_single->total != null ? $data_single->total : 0 
        );
        array_push($data,$temp);
    }

    return $data;
  }

}

