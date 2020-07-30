<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Credit extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        check_is_login();
        $this->load->model('Report_model');
        $this->load->model('Credit_model');
        // $this->load->library('datatables');
    }

    public function index()
    {

        $get = $this->input->get();

        if ($get != null) {
          $data['startdate'] = $get['startdate'];
          $data['enddate'] = $get['enddate'];
        } else {
          $data['startdate'] = date('01/m/Y');
          $data['enddate'] = date('t/m/Y');
        }
    
        $data['credit'] = $this->Report_model->getsalesbetween($data['startdate'], $data['enddate'],null,'credit','desc');
        // var_dump($data['credit']);die();
        $data['main_title'] = 'Hutang pelanggan';
        $data['sub_title'] = 'Daftar  Hutang Pelanggan';
        $data['content'] = 'credit/index';
        $data['codejs'] = 'credit/codejs';
    
        $this->load->view('template', $data);
    }

    public function invoice($no_invoice=null)
    {
        if(empty($no_invoice)){
            redirect(base_url('credit'));
        }
        $data['main_title'] = 'Detail Transaksi';
        $data['sub_title'] = 'Detail Transaksi Hutang';
        $data['content'] = 'credit/detail';
        $data['codejs'] = 'credit/codejs';

        $data['invoice'] = $this->Credit_model->get_detail_credit($no_invoice)->row();
        $data['payment'] = $this->Credit_model->get_payment_credit($no_invoice)->result();
        $data['product'] = $this->db->where('invoice',$no_invoice)->get('sale_detail');
        // var_dump($data['product']->result());die();
        $this->load->view('template', $data);
    }

    public function add_payment()
    {
        $invoice = $this->input->post('invoice');

        $amount = str_replace('.','',$this->input->post('amount'));

        $total_amount = 0;

        $cek_total_pembayaran = $this->db->select('total_sales as totalbelanja, pay_money')->where('invoice',$invoice)->get('sales')->row();
        $cek_history_payment = $this->db->where('invoice',$invoice)->get('credit_payment');
        if($cek_history_payment->num_rows()>0){
            foreach ($cek_history_payment->result() as $key => $value) {
                # code...
                $total_amount += $value->amount;
            }
        }

        $sisa_bayar = $cek_total_pembayaran->totalbelanja-$total_amount; 
        if($amount > $sisa_bayar){
            $amount = $sisa_bayar;
        }

        $this->db->trans_start();
        
            // Insert Credit Payment
            $data = array(
                'invoice'=> $invoice,
                'amount' => $amount,
                'created_by' => getuser()->id
            );
            $this->db->insert('credit_payment',$data);

            // Update Sales
            $this->db->set('pay_money', 'pay_money+' . $amount, false)
                        ->where('invoice',$invoice)
                        ->update('sales');
            
            $this->update_paid($invoice);
        
        $this->db->trans_complete();
        
        if ($this->db->trans_status() === FALSE)
        {
            echo "Error...";
                // generate an error... or use the log_message() function to log your error
        }else{
            $this->session->set_flashdata('type', 'success');
            $this->session->set_flashdata('message', 'Pembayaran Berhasil Ditambahkan');
            redirect(base_url('credit/invoice/'.$invoice));
        }
    }

    public function update_paid($invoice)
    {
        $sale = $this->db->where('invoice',$invoice)->get('sales')->row();
        // var_dump($sale);die();
        if( $sale->pay_money >= $sale->total_sales)
        {
            return $this->db->set('paid', '1')
                    ->where('invoice',$invoice)
                    ->update('sales');
        }else{
            // die($invoice);
            return $this->db->set('paid', '0')
                    ->where('invoice',$invoice)
                    ->update('sales');
        }
    }

    public function delete_payment_credit($id)
    {
        // get credit payment
        $cp = $this->db->where('id',$id)->get('credit_payment')->row();

        $this->db->trans_start();

            // Update Sales
            $this->db->set('pay_money', 'pay_money-' . $cp->amount, false)
                        ->where('invoice',$cp->invoice)
                        ->update('sales');

            // Delete Credit Payment
            $this->db->delete('credit_payment',array('id'=>$id));

            $this->update_paid($cp->invoice);

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE)
        {
            echo "Error...";
                // generate an error... or use the log_message() function to log your error
        }else{
            $this->session->set_flashdata('type', 'success');
            $this->session->set_flashdata('message', 'Pembayaran Berhasil Dihapus');
            redirect(base_url('credit/invoice/'.$cp->invoice));
        }
    }
}