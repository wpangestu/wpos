<?php
class Grafik extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        check_is_login();
        is_admin();
        $this->load->model('Chart_model','cm');
        $this->load->model('Report_model','rm');
    }
    public function index()
    {        
        $data['startdate'] = date('01/m/Y');
        $data['enddate'] = date('t/m/Y');
        
        $data['startmonth'] = "Jan ".date('Y');
        $data['endmonth'] = "Des ".date('Y');
        
        $data['startyear'] = date('Y');
        $data['endyear'] = date('Y');
      
      
        $data['c_tahun'] = $this->rm->sell_yearly($data['startyear'],$data['endyear']);
        $data['chart'] = $this->cm->get_sale_by_bulan(date('Y-m'));
        $data['c_bulan'] = $this->rm->sell_monthly(bulanindo_to_mysql($data['startmonth']),bulanindo_to_mysql($data['endmonth']));
        $data['main_title'] = 'Grafik';
        $data['sub_title'] = 'Show Grafik';
        $data['content'] = 'grafik/index';
        $data['codejs'] = 'grafik/codejs';
        $this->load->view('template',$data);
    }

    public function sale_json()
    {   
        $get = $this->input->post('tglrange');
      
        if($get!=null){
          $tgl = pecah_daterange($get);
          $data['startdate'] = $tgl['start'];
          $data['enddate'] = $tgl['end'];
        }else{
          $data['startdate'] = date('01/m/Y');
          $data['enddate'] = date('t/m/Y');
          // $startdate ='01/09/2019';
          // $enddate ='30/09/2019';
        }
        $data = $this->rm->get_sell_daily(datemysql($data['startdate']),datemysql($data['enddate']));
        // $data = $this->cm->get_sale_by_bulan(date('Y-m'));
        if($data->num_rows()>0){
            $chart = $data->result();
            $success = true;
        }else{
            $success = false;
            $chart = null;
        }
        
        $result = array(
            'dataChart' => $chart,
            'success' => $success
        );
        echo json_encode($result);
    }

    public function sale_json_month()
    {   
        $post = $this->input->post();
        if($post!=null){            
            $startmonth = $post['start'];
            $endmonth = $post['end'];
        }else{
            $startmonth = "Jan ".date('Y');
            $endmonth = "Des ".date('Y');
        }
 
        $data = $this->rm->sell_monthly(bulanindo_to_mysql($startmonth),bulanindo_to_mysql($endmonth));
        if($data->num_rows()>0){
            $chart = $data->result();
            $success = true;
        }else{
            $success = false;
            $chart = null;
        }
        
        $result = array(
            'dataChart' => $chart,
            'success' => $success
        );
        echo json_encode($result);
    }

    public function sale_json_year()
    {   
        $post = $this->input->post();
        if($post!=null){            
            $startyear = $post['start'];
            $endyear = $post['end'];
        }else{
            $startyear = date('Y');
            $endyear = date('Y');
        }
   
        $data = $this->rm->sell_yearly($startyear,$endyear);
        if($data->num_rows()>0){
            $chart = $data->result();
            $success = true;
        }else{
            $success = false;
            $chart = null;
        }
        
        $result = array(
            'dataChart' => $chart,
            'success' => $success
        );
        echo json_encode($result);
    }
}