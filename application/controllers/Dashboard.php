<?php
class Dashboard extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        check_is_login();
        $this->load->model('Chart_model','cm');
    }
    public function index()
    {

        $data['chart_data'] = $this->cm->get_sale(date('Y-m'));
        // $data['chartlast'] = $this->cm->get_last(6);
        $data['chartlast'] = $this->cm->get_last_sale_per_day(6);
        // echo "<pre>";
        // var_dump($data['chartlast']);die;
        $data['product'] = $this->db->get('product');
        $data['total_month'] = $this->cm->get_total_penjualan(date('Y-m'))->row();
        $data['transaksi'] = $this->cm->get_transaksi(date('Y-m'));
        $data['mostsale'] = $this->cm->get_most_sale(date('Y-m'),5);
        // var_dump($data['monstsale']);die;
        $data['jmluser'] = $this->cm->get_jml_user();

        $data['main_title'] = 'Dashboard';
        // $data['sub_title'] = 'Beranda';
        $data['content'] = 'dashboard/v_dashboard';
        $data['codejs'] = 'dashboard/codejs';
        $this->load->view('template',$data);
    }
}