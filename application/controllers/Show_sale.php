<?php

use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\Printer;

class Show_sale extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
    check_is_login();
    $this->load->model('Report_model');
  }

  public function index()
  {
    $get = $this->input->post();

    if ($get != null) {
      $data['startdate'] = $get['startdate'];
      $data['enddate'] = $get['enddate'];
    } else {
      $data['startdate'] = date('d/m/Y');
      $data['enddate'] = date('d/m/Y');
    }

    $data['sales'] = $this->Report_model->getsalesbetween($data['startdate'], $data['enddate']);
    $data['codejs'] = 'report/codejs';
    $data['main_title'] = 'Tampil Penjualan';
    $data['sub_title'] = 'Data Penjualan';
    $data['content'] = 'report/index';
    $this->load->view('template', $data);
  }

  public function by_customer()
  {
    $get = $this->input->post();

    if ($get != null) {
      $data['startdate'] = $get['startdate'];
      $data['enddate'] = $get['enddate'];
    } else {
      $data['startdate'] = date('d/m/Y');
      $data['enddate'] = date('d/m/Y');
    }

    $id_customer = $get['id_customer'];

    $sales = $this->Report_model->getsalesbetween($data['startdate'], $data['enddate'],$id_customer);
    if($sales->num_rows()>0){

      // $datas = $sales->result();
      $success = true;
      $datas = array();
      foreach($sales->result() as $d){
        $datetime = date_create($d->datetime_sales);
        $temp = array(
          "tanggal" => date_format($datetime,"d/m/Y"),
          "waktu" => date_format($datetime,"H.i"),
          "invoice" => $d->invoice,
          "total" => $d->total_sales
        );
        array_push($datas,$temp);
      }
    }else{
        $success = false;
        $datas = null;
    }

    $response = array(
      'data' => $datas,
      'success' => $success
    );
    echo json_encode($response);
  }

  public function show_display_transaksi()
  {
    $invoice = $this->input->post('invoice');
    if ($invoice != null) {
      $data = $this->db->get_where('sale_detail', array('invoice' => $invoice));
      if ($data->num_rows() > 0) {
        $output = '';
        $no = 0;
        foreach ($data->result() as $d) {
          $no++;
          $output .= '
              <tr>
                <td>' . $no . '</td>
                <td>' . $d->kode_product . '</td>
                <td>' . $d->name_product . '</td>
                <td class="text-right">' . rupiah($d->price_sale) . '</td>
                <td class="text-right">' . $d->qty . '</td>
                <td class="text-right">' . rupiah($d->discount) . '</td>
                <td class="text-right">' . rupiah($d->sub_total) . '</td>
              </tr>
           ';
        }
        echo $output;
      } else {
        echo "deta tidak ditemukan";
      }
    } else {
      echo "invoice belum diinputkan";
    }
  }

  public function printf()
  {
    $invoice = $this->input->post('invoice');
    $sale = $this->Report_model->get_struk_sale($invoice)->result();
    $datetime = date_create($sale[0]->datetime_sales);
    try {

      $connector = new WindowsPrintConnector(getsetting()->printer_name);

      /* Print a "Hello world" receipt" */
      $printer = new Printer($connector);
      $printer->setJustification(Printer::JUSTIFY_CENTER);
      $printer->text(getsetting()->nm_toko . "\n");
      $printer->text(getsetting()->keterangan_toko . "\n");
      $printer->setJustification(Printer::JUSTIFY_LEFT);
      $printer->text("----------------------------------------\n");
      $printer->text("Tgl:".date_format($datetime,'d/m/Y')."          Kasir:".$sale[0]->username."\n");
      $printer->text("No#:".$sale[0]->invoice."          Jam  :".date_format($datetime,'H.i')."\n");
      $printer->text("----------------------------------------\n");
      $disc = 0;
      $total_item=0;
      foreach ($sale as $s ) {
        $printer->setJustification(Printer::JUSTIFY_LEFT);
        $printer->text($s->name_product."\n");
        $printer->setJustification(Printer::JUSTIFY_RIGHT);
        // $printer->text(rupiah($s->price_sale)."   x ".$s->qty." PC   ".rupiah($s->sub_total)."\n");
        $line = sprintf('%6.40s %-1.1s %9.40s %-1.4s %13.40s',$s->qty.' PC', 'X',rupiah($s->price_sale), '= Rp', rupiah($s->qty*$s->price_sale));
        $printer->text($line."\n");
        $total_item += ($s->qty*$s->price_sale);
        if($s->discount>0){
          $printer->setJustification(Printer::JUSTIFY_LEFT);
          $printer->text("Disc. -".rupiah($s->discount)."\n");
          $disc += ($s->discount*$s->qty);
        }
      }
      $printer->setJustification(Printer::JUSTIFY_RIGHT);
      $printer->text("----------------------------------------\n");
      if($disc>0){
        $line_item = sprintf('%-5.40s %-1.05s %13.40s','Total Item', '= Rp',rupiah($total_item));
        $line_total_disc = sprintf('%-5.40s %-1.05s %13.40s','Total Disc.', '= Rp',rupiah($disc));
        $printer->text($line_item."\n");
        $printer->text($line_total_disc."\n");
      }
      $line1 = sprintf('%-5.40s %-1.05s %13.40s','Total Belanja', '= Rp',rupiah($sale[0]->total_sales));
      $line2 = sprintf('%-5.40s %-1.05s %13.40s','Uang Tunai', '= Rp',rupiah($sale[0]->pay_money));
      $line3 = sprintf('%-5.40s %-1.05s %13.40s','Kembali', '= Rp',rupiah($sale[0]->refund));
      // $printer->text("                T O T A L : Rp ".rupiah($sale[0]->total_sales)."\n");
      // $printer->text("               Uang Bayar : Rp ".rupiah($sale[0]->pay_money)."\n");
      // $printer->text("                  Kembali : Rp ".rupiah($sale[0]->refund)."\n");
      $printer->text($line1."\n");
      $printer->text($line2."\n");
      $printer->text($line3."\n");

      $printer->text("----------------------------------------\n");
      $printer->setJustification(Printer::JUSTIFY_CENTER);
      $printer->text(getsetting()->footer_struk."\n");
      
      $printer->cut();

      /* Close printer */
      echo true;
      $printer->close();
    } catch (Exception $e) {
      echo "Couldn't print to this printer: " . $e->getMessage() . "\n";
    }
  }

  public function tes()
  {
    $this->load->view('print/testing');
  }
}
