<?php

use FontLib\EOT\Header;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class Report extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        check_is_login();
        is_admin();
        $this->load->model('Report_model');
    }

    public function index()
    {
      $data['main_title'] = 'Laporan';
      $data['sub_title'] = 'Jenis Laporan Penjualan';
      $data['content'] = 'report/choose';
      $this->load->view('template',$data);
    }

    public function choose()
    {
      $data['main_title'] = 'Laporan';
      $data['sub_title'] = 'Jenis Laporan Penjualan';
      $data['content'] = 'report/choose';
      $this->load->view('template',$data);
    }

    public function sell_detail()
    {
      $get = $this->input->post('tglrange');
      
      if($get!=null){
        $tgl = pecah_daterange($get);
        $data['startdate'] = $tgl['start'];
        $data['enddate'] = $tgl['end'];
      }else{
        $data['startdate'] = date('d/m/Y');
        $data['enddate'] = date('d/m/Y');
      }
      $data['sale_detail'] = $this->Report_model->getsale_detail($data['startdate'],$data['enddate']);
      $data['main_title'] = 'Laporan';
      $data['sub_title'] = 'Detail penjualan';
      $data['content'] = 'report/sell_detail';
      $this->load->view('template',$data);
    }

    public function print_sell_detail()
    {
        $data['startdate'] = $this->input->post('start');
        $data['enddate'] = $this->input->post('end');
        $data['sub_title'] = 'Detail penjualan';
        $data['sale_detail'] = $this->Report_model->getsale_detail($data['startdate'],$data['enddate']);
        $this->load->library('Pdfgenerator');
        
        $this->pdfgenerator->setPaper('A4', 'landscape');
        $this->pdfgenerator->filename = "Laporan Penjualan Detail - ".time().".pdf";
        $this->pdfgenerator->load_view('print/sale/detail',$data);
    }

    public function excel_sell_detail()
    {
        $startdate = $this->input->get('start');
        $enddate = $this->input->get('end');
        // $sub_title = 'Detail penjualan';
        $sale_detail= $this->Report_model->getsale_detail($startdate,$enddate);
        
        $filename="Detail Penjualan - ".time();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->mergeCells('A1:L1');
        $sheet->mergeCells('A2:L2');
        $sheet->mergeCells('A3:L3');
        $sheet->mergeCells('A4:L4');
        $sheet->mergeCells('A5:L5');

        $sheet->setCellValue('A1', getsetting()->nm_toko);
        $sheet->getStyle('A1')->getFont()->setBold(true);
        $sheet->getStyle('A1')->getFont()->setSize(26);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);


        $sheet->setCellValue('A2', getsetting()->keterangan_toko);
        $sheet->getStyle('A2')->getFont()->setBold(true);        
        $sheet->getStyle('A2')->getFont()->setSize(13);
        $sheet->getStyle('A2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $sheet->setCellValue('A4', 'Laporan Detail Penjualan');
        if($startdate==$enddate){
          $sheet->setCellValue('A5', tanggal_indo2($startdate));
        }else{
          $sheet->setCellValue('A5', tanggal_indo2($startdate).' - '.tanggal_indo2($enddate));
        }
        $sheet->getStyle('A4:A5')->getFont()->setBold(true);
        $sheet->getStyle('A4:A5')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $sheet->setCellValue('A6', 'No')
              ->setCellValue('B6', 'No Trans')
              ->setCellValue('C6', 'Tanggal')
              ->setCellValue('D6', 'Jam')
              ->setCellValue('E6', 'Kode Produk')
              ->setCellValue('F6', 'Nama Produk')
              ->setCellValue('G6', 'Harga Pokok')
              ->setCellValue('H6', 'Harga Jual')
              ->setCellValue('I6', 'Qty')
              ->setCellValue('J6', 'Diskon')
              ->setCellValue('K6', 'Total')
              ->setCellValue('L6', 'Laba/Rugi');
        $sheet->getColumnDimension('A')->setWidth(4);
        $sheet->getColumnDimension('B')->setWidth(15);
        $sheet->getColumnDimension('C')->setWidth(15);
        $sheet->getColumnDimension('D')->setWidth(10);
        $sheet->getColumnDimension('E')->setWidth(16);
        $sheet->getColumnDimension('F')->setWidth(35);
        $sheet->getColumnDimension('G')->setWidth(15);
        $sheet->getColumnDimension('H')->setWidth(15);
        $sheet->getColumnDimension('I')->setWidth(5);
        $sheet->getColumnDimension('J')->setWidth(10);
        $sheet->getColumnDimension('J')->setWidth(15);
        $sheet->getColumnDimension('K')->setWidth(15);
        $sheet->getColumnDimension('L')->setWidth(15);
        $sheet->getStyle('A6:L6')->getFont()->setBold(true);

        $kolom = 7;
        $nomor = 1;
        $tqty = 0;
        $tdisc = 0;
        $tsale = 0;
        $tlaba = 0;
        foreach($sale_detail->result() as $sd) {
          $k = $sd->price * $sd->qty;
          $untung = $sd->sub_total - $k;
          $tqty += $sd->qty;
          $tdisc +=$sd->discount;
          $tsale +=$sd->sub_total;
          $tlaba += $untung;

          $datetime = date_create($sd->datetime_sales);
          $sheet->setCellValue('A' . $kolom, $nomor)
                ->setCellValue('B' . $kolom, $sd->invoice)
                ->setCellValue('C' . $kolom, date_format($datetime,'d/m/Y'))
                ->setCellValue('D' . $kolom, date_format($datetime,'H:i:s'))
                ->setCellValue('E' . $kolom, $sd->kode_product)
                ->setCellValue('F' . $kolom, $sd->name_product)
                ->setCellValue('G' . $kolom, $sd->price)
                ->setCellValue('H' . $kolom, $sd->price_sale)
                ->setCellValue('I' . $kolom, $sd->qty)
                ->setCellValue('J' . $kolom, $sd->discount)
                ->setCellValue('K' . $kolom, $sd->sub_total)
                ->setCellValue('L' . $kolom, $untung);
          $sheet->getStyle('G'.$kolom)
                ->getNumberFormat()
                ->setFormatCode(NumberFormat::FORMAT_ACCOUNTING_RP);
          $sheet->getStyle('H'.$kolom)
                ->getNumberFormat()
                ->setFormatCode(NumberFormat::FORMAT_ACCOUNTING_RP);
          $sheet->getStyle('J'.$kolom)
                ->getNumberFormat()
                ->setFormatCode(NumberFormat::FORMAT_ACCOUNTING_RP);
          $sheet->getStyle('K'.$kolom)
                ->getNumberFormat()
                ->setFormatCode(NumberFormat::FORMAT_ACCOUNTING_RP);
          $sheet->getStyle('L'.$kolom)
                ->getNumberFormat()
                ->setFormatCode(NumberFormat::FORMAT_ACCOUNTING_RP);

          $kolom++;
          $nomor++;
        }
        $styleArray=[
          'borders' => [
              'allBorders' => [
                'borderStyle' => Border::BORDER_THIN,
                'color' => ['rgb' => '000000'],
              ],
            ]
          ];
          $stylethead = array(
            'fill'=> array(
              'fillType' => Fill::FILL_SOLID,
              'color' => ['rgb' => 'ABFC2F'],
            )
          );
        $sheet->getStyle('A6:L6')->applyFromArray($stylethead);
        $sheet->getStyle('A6:L'.$kolom)->applyFromArray($styleArray);

        $sheet->mergeCells('A'.$kolom.':H'.$kolom);
        $sheet->setCellValue('A'.$kolom, 'T O T A L');
        $sheet->getStyle('A'.$kolom)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A'.$kolom)->getFont()->setBold(true);
        $sheet->getStyle('A'.$kolom)->getFont()->setSize(14);
        
        $sheet->setCellValue('I'.$kolom, $tqty);
        $sheet->setCellValue('J'.$kolom, $tdisc);
        $sheet->setCellValue('K'.$kolom, $tsale);
        $sheet->setCellValue('L'.$kolom, $tlaba);
        $sheet->getStyle('J'.$kolom.':L'.$kolom)
        ->getNumberFormat()
        ->setFormatCode(NumberFormat::FORMAT_ACCOUNTING_RP);

        $kolom++;
        $sheet->mergeCells('A'.$kolom.':L'.$kolom);
        $sheet->setCellValue('A'.$kolom, 'Digenerate pada tanggal : '.date('d/m/Y H:i:s'));
        $sheet->getStyle('A'.$kolom)->getFont()->setItalic(true);
        $kolom++;
        $sheet->mergeCells('A'.$kolom.':L'.$kolom);
        $sheet->setCellValue('A'.$kolom, 'Digenerate Oleh : '.getuser()->username);
        $sheet->getStyle('A'.$kolom)->getFont()->setItalic(true);

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$filename.'.xlsx"');
        header('Cache-Control: max-age=0');

        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');
    }

    public function sell_summary()
    {
      $get = $this->input->post('tglrange');
      
      if($get!=null){
        $tgl = pecah_daterange($get);
        $data['startdate'] = $tgl['start'];
        $data['enddate'] = $tgl['end'];
      }else{
        $data['startdate'] = date('01/m/Y');
        $data['enddate'] = date('t/m/Y');
      }

      $data['sales'] = $this->Report_model->getselling($data['startdate'],$data['enddate']);
      $data['main_title'] = 'Laporan';
      $data['sub_title'] = 'Ringkasan penjualan';
      $data['content'] = 'report/sale/summary';
      $this->load->view('template',$data);
    }

    public function print_sale_summary()
    {
      $data['startdate'] = $this->input->get('start');
      $data['enddate'] = $this->input->get('end');
      $data['sub_title'] = 'Ringkasan penjualan';
      $data['sale_summary'] = $this->Report_model->getselling($data['startdate'],$data['enddate']);
      $this->load->library('Pdfgenerator');
      
      $this->pdfgenerator->setPaper('A4', 'potrait');
      $this->pdfgenerator->filename = "Laporan Penjualan Ringkasan - ".time().".pdf";
      $this->pdfgenerator->load_view('print/sale/summary',$data);
    }

    public function excel_sale_summary()
    {
      $startdate = $this->input->get('start');
      $enddate = $this->input->get('end');
      $sub_title = 'Ringkasan penjualan';
      $sale_summary = $this->Report_model->getselling($startdate,$enddate);
      $filename="Ringkasan Penjualan - ".time();
      
      $spreadsheet = new Spreadsheet();
      $sheet = $spreadsheet->getActiveSheet();
      $sheet->mergeCells('A1:G1');
      $sheet->mergeCells('A2:G2');
      $sheet->mergeCells('A3:G3');
      $sheet->mergeCells('A4:G4');
      $sheet->mergeCells('A5:G5');

      $sheet->setCellValue('A1', getsetting()->nm_toko);
      $sheet->getStyle('A1')->getFont()->setBold(true);        
      $sheet->getStyle('A1')->getFont()->setSize(26);
      $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);


      $sheet->setCellValue('A2', getsetting()->keterangan_toko);
      $sheet->getStyle('A2')->getFont()->setBold(true);        
      $sheet->getStyle('A2')->getFont()->setSize(13);
      $sheet->getStyle('A2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

      $sheet->setCellValue('A4', 'Laporan Ringkasan Penjualan');
      if($startdate==$enddate){
        $sheet->setCellValue('A5', tanggal_indo2($startdate));
      }else{
        $sheet->setCellValue('A5', tanggal_indo2($startdate).' - '.tanggal_indo2($enddate));
      }
      $sheet->getStyle('A4:A5')->getFont()->setBold(true);
      $sheet->getStyle('A4:A5')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

      $sheet->setCellValue('A6', 'No')
            ->setCellValue('B6', 'No Transaksi')
            ->setCellValue('C6', 'Tanggal')
            ->setCellValue('D6', 'Jam')
            ->setCellValue('E6', 'Kasir')
            ->setCellValue('F6', 'Pelanggan')
            ->setCellValue('G6', 'Total Transaksi')
            ->setCellValue('H6', 'Laba/Rugi');
      $sheet->getColumnDimension('A')->setWidth(4);
      $sheet->getColumnDimension('B')->setWidth(15);
      $sheet->getColumnDimension('C')->setWidth(15);
      $sheet->getColumnDimension('D')->setWidth(10);
      $sheet->getColumnDimension('E')->setWidth(15);
      $sheet->getColumnDimension('F')->setWidth(15);
      $sheet->getColumnDimension('G')->setWidth(30);
      $sheet->getColumnDimension('H')->setWidth(25);
      $sheet->getStyle('A6:H6')->getFont()->setBold(true);
      
      $kolom = 7;$nomor=1; $total=0; $untung=0;
      foreach($sale_summary->result() as $sale){
        $datetime = date_create($sale->datetime_sales);
        $total += $sale->total;
        $untung += $sale->untung;
        $sheet->setCellValue('A' . $kolom, $nomor)
              ->setCellValue('B' . $kolom, $sale->invoice)
              ->setCellValue('C' . $kolom, date_format($datetime,'d/m/Y'))
              ->setCellValue('D' . $kolom, date_format($datetime,'H:i:s'))
              ->setCellValue('E' . $kolom, $sale->username)
              ->setCellValue('F' . $kolom, $sale->name_customer)
              ->setCellValue('G' . $kolom, $sale->total)
              ->setCellValue('H' . $kolom, $sale->untung);
        $sheet->getStyle('G'.$kolom)
              ->getNumberFormat()
              ->setFormatCode(NumberFormat::FORMAT_ACCOUNTING_RP);
        $sheet->getStyle('H'.$kolom)
              ->getNumberFormat()
              ->setFormatCode(NumberFormat::FORMAT_ACCOUNTING_RP);
        $nomor++;
        $kolom++;
      }
      $styleArray=[
        'borders' => [
            'allBorders' => [
              'borderStyle' => Border::BORDER_THIN,
              'color' => ['rgb' => '000000'],
            ],
          ]
        ];
        $stylethead = array(
          'fill'=> array(
            'fillType' => Fill::FILL_SOLID,
            'color' => ['rgb' => 'ABFC2F'],
          )
        );
      $sheet->getStyle('A6:H6')->applyFromArray($stylethead);
      $sheet->getStyle('A6:H'.$kolom)->applyFromArray($styleArray);

      $sheet->mergeCells('A'.$kolom.':F'.$kolom);
      $sheet->setCellValue('A'.$kolom, 'T O T A L');
      $sheet->getStyle('A'.$kolom)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
      $sheet->getStyle('A'.$kolom)->getFont()->setBold(true);
      $sheet->getStyle('A'.$kolom)->getFont()->setSize(14);

      $sheet->setCellValue('G'.$kolom, $total);
      $sheet->setCellValue('H'.$kolom, $untung);
      $sheet->getStyle('G'.$kolom.':H'.$kolom)
      ->getNumberFormat()
      ->setFormatCode(NumberFormat::FORMAT_ACCOUNTING_RP);

      $kolom++;
      $sheet->mergeCells('A'.$kolom.':H'.$kolom);
      $sheet->setCellValue('A'.$kolom, 'Digenerate pada tanggal : '.date('d/m/Y H:i:s'));
      $sheet->getStyle('A'.$kolom)->getFont()->setItalic(true);

      $kolom++;      
      $sheet->mergeCells('A'.$kolom.':H'.$kolom);
      $sheet->setCellValue('A'.$kolom, 'Digenerate Oleh : '.getuser()->username);
      $sheet->getStyle('A'.$kolom)->getFont()->setItalic(true);

      header('Content-Type: application/vnd.ms-excel');
      header('Content-Disposition: attachment;filename="'.$filename.'.xlsx"');
      header('Cache-Control: max-age=0');

      $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
      $writer->save('php://output');

    }

    public function sell_daily()
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
      $data['sales'] = $this->Report_model->get_sell_daily(datemysql($data['startdate']),datemysql($data['enddate']));
      // var_dump($data['sales']);
      $data['main_title'] = 'Laporan';
      $data['sub_title'] = 'Penjualan Harian';
      $data['content'] = 'report/sale/dialy';
      $this->load->view('template',$data);
    }

    public function sell_daily_by_customer()
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
  
      $sales = $this->Report_model->get_sell_daily(datemysql($data['startdate']), datemysql($data['enddate']),$id_customer);
      if($sales->num_rows()>0){
        $datas = $sales->result();
        $success = true;
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

    public function sale_monthly_bycustomer()
    {
      $get = $this->input->post();

      $startmonth = $get['start'];
      $endmonth = $get['end'];

      $id_customer = $get['id_customer'];

      $sales = $this->Report_model->sell_monthly(bulanindo_to_mysql($startmonth),bulanindo_to_mysql($endmonth),$id_customer);
      if($sales->num_rows()>0){

        $datas = array();
        foreach($sales->result() as $d){
          $temp = array(
            "bulan" => bulan_indo3($d->bulan),
            "modal" => $d->modal,
            "total" => $d->total,
            "untung" => $d->untung
          );
          array_push($datas,$temp);
        }
        $success = true;
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
    public function sale_yearly_bycustomer()
    {
      $get = $this->input->post();

      $startyear = $get['startyear'];
      $endyear = $get['endyear'];

      $id_customer = $get['id_customer'];

      $sales = $this->Report_model->sell_yearly($startyear,$endyear,$id_customer);
      if($sales->num_rows()>0){

        $datas = $sales->result();
        $success = true;
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

    public function print_sale_dialy()
    {
      $data['startdate'] = $this->input->get('start');
      $data['enddate'] = $this->input->get('end');
      $data['sub_title'] = 'Penjualan Harian';
      $data['sales'] = $this->Report_model->get_sell_daily(datemysql($data['startdate']),datemysql($data['enddate']));
      $this->load->library('Pdfgenerator');
      
      $this->pdfgenerator->setPaper('A4', 'potrait');
      $this->pdfgenerator->filename = "Laporan Penjualan Harian - ".time().".pdf";
      $this->pdfgenerator->load_view('print/sale/dialy',$data);
    }
    
    public function excel_sale_dialy()
    {
      $startdate = $this->input->get('start');
      $enddate = $this->input->get('end');
      $sub_title = 'Ringkasan penjualan';
      $sales = $this->Report_model->get_sell_daily(datemysql($startdate),datemysql($enddate));
      $filename="Laporan Penjualan Harian - ".time();

      $spreadsheet = new Spreadsheet();
      $sheet = $spreadsheet->getActiveSheet();
      $sheet->mergeCells('A1:D1');
      $sheet->mergeCells('A2:D2');
      $sheet->mergeCells('A3:D3');
      $sheet->mergeCells('A4:D4');
      $sheet->mergeCells('A5:D5');

      $sheet->setCellValue('A1', getsetting()->nm_toko);
      $sheet->getStyle('A1')->getFont()->setBold(true);        
      $sheet->getStyle('A1')->getFont()->setSize(26);
      $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);


      $sheet->setCellValue('A2', getsetting()->keterangan_toko);
      $sheet->getStyle('A2')->getFont()->setBold(true);        
      $sheet->getStyle('A2')->getFont()->setSize(13);
      $sheet->getStyle('A2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

      $sheet->setCellValue('A4', 'Laporan Penjualan Harian');
      if($startdate==$enddate){
        $sheet->setCellValue('A5', tanggal_indo2($startdate));
      }else{
        $sheet->setCellValue('A5', tanggal_indo2($startdate).' - '.tanggal_indo2($enddate));
      }
      $sheet->getStyle('A4:A5')->getFont()->setBold(true);
      $sheet->getStyle('A4:A5')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

      $sheet->setCellValue('A6', 'No')
            ->setCellValue('B6', 'Tanggal')
            ->setCellValue('C6', 'Total Transaksi')
            ->setCellValue('D6', 'Total Laba/Rugi');
      $sheet->getColumnDimension('A')->setWidth(4);
      $sheet->getColumnDimension('B')->setWidth(15);
      $sheet->getColumnDimension('C')->setWidth(30);
      $sheet->getColumnDimension('D')->setWidth(25);
      $sheet->getStyle('A6:D6')->getFont()->setBold(true);
      
      $kolom = 7;$nomor=1; $total=0; $untung=0;
      foreach($sales->result() as $sale){
        $datetime = date_create($sale->tanggal);
        $total += $sale->total;
        $untung += $sale->untung;
        $sheet->setCellValue('A' . $kolom, $nomor)
              ->setCellValue('B' . $kolom, date_format($datetime,'d/m/Y'))
              ->setCellValue('C' . $kolom, $sale->total)
              ->setCellValue('D' . $kolom, $sale->untung);
        $sheet->getStyle('C'.$kolom)
              ->getNumberFormat()
              ->setFormatCode(NumberFormat::FORMAT_ACCOUNTING_RP);
        $sheet->getStyle('D'.$kolom)
              ->getNumberFormat()
              ->setFormatCode(NumberFormat::FORMAT_ACCOUNTING_RP);
        $nomor++;
        $kolom++;
      }
      $styleArray=[
        'borders' => [
            'allBorders' => [
              'borderStyle' => Border::BORDER_THIN,
              'color' => ['rgb' => '000000'],
            ],
          ]
        ];
        $stylethead = array(
          'fill'=> array(
            'fillType' => Fill::FILL_SOLID,
            'color' => ['rgb' => 'ABFC2F'],
          )
        );
      $sheet->getStyle('A6:D6')->applyFromArray($stylethead);
      $sheet->getStyle('A6:D'.$kolom)->applyFromArray($styleArray);

      $sheet->mergeCells('A'.$kolom.':B'.$kolom);
      $sheet->setCellValue('A'.$kolom, 'T O T A L');
      $sheet->getStyle('A'.$kolom)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
      $sheet->getStyle('A'.$kolom)->getFont()->setBold(true);
      $sheet->getStyle('A'.$kolom)->getFont()->setSize(14);

      $sheet->setCellValue('C'.$kolom, $total);
      $sheet->setCellValue('D'.$kolom, $untung);
      $sheet->getStyle('C'.$kolom.':D'.$kolom)
      ->getNumberFormat()
      ->setFormatCode(NumberFormat::FORMAT_ACCOUNTING_RP);

      $kolom++;
      $sheet->mergeCells('A'.$kolom.':D'.$kolom);
      $sheet->setCellValue('A'.$kolom, 'Digenerate pada tanggal : '.date('d/m/Y H:i:s'));
      $sheet->getStyle('A'.$kolom)->getFont()->setItalic(true);

      $kolom++;      
      $sheet->mergeCells('A'.$kolom.':D'.$kolom);
      $sheet->setCellValue('A'.$kolom, 'Digenerate Oleh : '.getuser()->username);
      $sheet->getStyle('A'.$kolom)->getFont()->setItalic(true);

      header('Content-Type: application/vnd.ms-excel');
      header('Content-Disposition: attachment;filename="'.$filename.'.xlsx"');
      header('Cache-Control: max-age=0');

      $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
      $writer->save('php://output');

    }

    function sell_monthly()
    {
      $post = $this->input->post();
      
      if($post!=null){
        $data['startmonth'] = $post['start'];
        $data['endmonth'] = $post['end'];
      }else{
        $data['startmonth'] = "Jan ".date('Y');
        $data['endmonth'] = "Des ".date('Y');
        // $data['startmonth'] = '01/2019';
        // $data['endmonth'] = '12/2019';
      }
      $data['sales'] = $this->Report_model->sell_monthly(bulanindo_to_mysql($data['startmonth']),bulanindo_to_mysql($data['endmonth']));
      $data['main_title'] = 'Laporan';
      $data['sub_title'] = 'Penjualan Bulanan';
      $data['content'] = 'report/sale/monthly';
      $data['codejs'] = 'report/codejs';
      $this->load->view('template',$data);
    }

    public function print_sale_monthly()
    {
      $data['startmonth'] = $this->input->get('start');
      $data['endmonth'] = $this->input->get('end');
      $data['sub_title'] = 'Penjualan Bulanan';
      $data['sales'] = $this->Report_model->sell_monthly($data['startmonth'],$data['endmonth']);
      $this->load->library('Pdfgenerator');
      
      $this->pdfgenerator->setPaper('A4', 'potrait');
      $this->pdfgenerator->filename = "Laporan Penjualan Bulanan - ".time().".pdf";
      $this->pdfgenerator->load_view('print/sale/monthly',$data);
    }

    public function excel_sale_monthly()
    {
      $startmonth = $this->input->get('start');
      $endmonth = $this->input->get('end');
      $sub_title = 'Ringkasan penjualan';
      $sales = $this->Report_model->sell_monthly($startmonth,$endmonth);
      $filename="Laporan Penjualan Bulanan - ".time();

      $spreadsheet = new Spreadsheet();
      $sheet = $spreadsheet->getActiveSheet();
      $sheet->mergeCells('A1:D1');
      $sheet->mergeCells('A2:D2');
      $sheet->mergeCells('A3:D3');
      $sheet->mergeCells('A4:D4');
      $sheet->mergeCells('A5:D5');

      $sheet->setCellValue('A1', getsetting()->nm_toko);
      $sheet->getStyle('A1')->getFont()->setBold(true);        
      $sheet->getStyle('A1')->getFont()->setSize(26);
      $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);


      $sheet->setCellValue('A2', getsetting()->keterangan_toko);
      $sheet->getStyle('A2')->getFont()->setBold(true);        
      $sheet->getStyle('A2')->getFont()->setSize(13);
      $sheet->getStyle('A2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

      $sheet->setCellValue('A4', 'Laporan Penjualan Bulanan');
      if($startmonth==$endmonth){
        $sheet->setCellValue('A5', bulan_indo3($startmonth));
      }else{
        $sheet->setCellValue('A5', bulan_indo3($startmonth).' - '.bulan_indo3($endmonth));
      }
      $sheet->getStyle('A4:A5')->getFont()->setBold(true);
      $sheet->getStyle('A4:A5')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

      $sheet->setCellValue('A6', 'No')
            ->setCellValue('B6', 'Bulan')
            ->setCellValue('C6', 'Total Transaksi')
            ->setCellValue('D6', 'Total Laba/Rugi');
      $sheet->getColumnDimension('A')->setWidth(4);
      $sheet->getColumnDimension('B')->setWidth(20);
      $sheet->getColumnDimension('C')->setWidth(30);
      $sheet->getColumnDimension('D')->setWidth(25);
      $sheet->getStyle('A6:D6')->getFont()->setBold(true);
      
      $kolom = 7;$nomor=1; $total=0; $untung=0;
      foreach($sales->result() as $sale){
        $datetime = date_create($sale->bulan);
        $total += $sale->total;
        $untung += $sale->untung;
        $sheet->setCellValue('A' . $kolom, $nomor)
              ->setCellValue('B' . $kolom, bulan_indo2(date_format($datetime,'m/Y')))
              ->setCellValue('C' . $kolom, $sale->total)
              ->setCellValue('D' . $kolom, $sale->untung);
        $sheet->getStyle('C'.$kolom)
              ->getNumberFormat()
              ->setFormatCode(NumberFormat::FORMAT_ACCOUNTING_RP);
        $sheet->getStyle('D'.$kolom)
              ->getNumberFormat()
              ->setFormatCode(NumberFormat::FORMAT_ACCOUNTING_RP);
        $nomor++;
        $kolom++;
      }
      $styleArray=[
        'borders' => [
            'allBorders' => [
              'borderStyle' => Border::BORDER_THIN,
              'color' => ['rgb' => '000000'],
            ],
          ]
        ];
        $stylethead = array(
          'fill'=> array(
            'fillType' => Fill::FILL_SOLID,
            'color' => ['rgb' => 'ABFC2F'],
          )
        );
      $sheet->getStyle('A6:D6')->applyFromArray($stylethead);
      $sheet->getStyle('A6:D'.$kolom)->applyFromArray($styleArray);

      $sheet->mergeCells('A'.$kolom.':B'.$kolom);
      $sheet->setCellValue('A'.$kolom, 'T O T A L');
      $sheet->getStyle('A'.$kolom)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
      $sheet->getStyle('A'.$kolom)->getFont()->setBold(true);
      $sheet->getStyle('A'.$kolom)->getFont()->setSize(14);

      $sheet->setCellValue('C'.$kolom, $total);
      $sheet->setCellValue('D'.$kolom, $untung);
      $sheet->getStyle('C'.$kolom.':D'.$kolom)
      ->getNumberFormat()
      ->setFormatCode(NumberFormat::FORMAT_ACCOUNTING_RP);

      $kolom++;
      $sheet->mergeCells('A'.$kolom.':D'.$kolom);
      $sheet->setCellValue('A'.$kolom, 'Digenerate pada tanggal : '.date('d/m/Y H:i:s'));
      $sheet->getStyle('A'.$kolom)->getFont()->setItalic(true);

      $kolom++;      
      $sheet->mergeCells('A'.$kolom.':D'.$kolom);
      $sheet->setCellValue('A'.$kolom, 'Digenerate Oleh : '.getuser()->username);
      $sheet->getStyle('A'.$kolom)->getFont()->setItalic(true);

      header('Content-Type: application/vnd.ms-excel');
      header('Content-Disposition: attachment;filename="'.$filename.'.xlsx"');
      header('Cache-Control: max-age=0');

      $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
      $writer->save('php://output');
    }

    public function sale_yearly()
    {
      $post = $this->input->post();
      
      if($post!=null){
        $data['startyear'] = $post['start'];
        $data['endyear'] = $post['end'];
      }else{
        $data['startyear'] = date('Y');
        $data['endyear'] = date('Y');
        // $data['startmonth'] = '01/2019';
        // $data['endmonth'] = '12/2019';
      }
      $data['sales'] = $this->Report_model->sell_yearly($data['startyear'],$data['endyear']);
      $data['main_title'] = 'Laporan';
      $data['sub_title'] = 'Penjualan Tahunan';
      $data['content'] = 'report/sale/yearly';
      $data['codejs'] = 'report/codejs';
      $this->load->view('template',$data);
    }

    public function print_sale_yearly()
    {
      $post = $this->input->get();
      $data['startyear'] = $post['start'];
      $data['endyear'] = $post['end'];

      $data['sales'] = $this->Report_model->sell_yearly($data['startyear'],$data['endyear']);
      $data['sub_title'] = 'Penjualan Tahunan';

      $this->load->library('Pdfgenerator');
      
      $this->pdfgenerator->setPaper('A4', 'potrait');
      $this->pdfgenerator->filename = "Laporan Penjualan Tahunan - ".time().".pdf";
      $this->pdfgenerator->load_view('print/sale/yearly',$data);

    }

    public function excel_sale_yearly()
    {
      $startyear = $this->input->get('start');
      $endyear = $this->input->get('end');
      $sub_title = 'Ringkasan penjualan';
      $sales = $this->Report_model->sell_yearly($startyear,$endyear);
      $filename="Laporan Penjualan Tahunan - ".time();

      $spreadsheet = new Spreadsheet();
      $sheet = $spreadsheet->getActiveSheet();
      $sheet->mergeCells('A1:D1');
      $sheet->mergeCells('A2:D2');
      $sheet->mergeCells('A3:D3');
      $sheet->mergeCells('A4:D4');
      $sheet->mergeCells('A5:D5');

      $sheet->setCellValue('A1', getsetting()->nm_toko);
      $sheet->getStyle('A1')->getFont()->setBold(true);        
      $sheet->getStyle('A1')->getFont()->setSize(26);
      $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);


      $sheet->setCellValue('A2', getsetting()->keterangan_toko);
      $sheet->getStyle('A2')->getFont()->setBold(true);        
      $sheet->getStyle('A2')->getFont()->setSize(13);
      $sheet->getStyle('A2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

      $sheet->setCellValue('A4', 'Laporan Penjualan Tahunan');
      if($startyear==$endyear){
        $sheet->setCellValue('A5', $startyear);
      }else{
        $sheet->setCellValue('A5', $startyear.' - '.$endyear);
      }
      $sheet->getStyle('A4:A5')->getFont()->setBold(true);
      $sheet->getStyle('A4:A5')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

      $sheet->setCellValue('A6', 'No')
            ->setCellValue('B6', 'Tahun')
            ->setCellValue('C6', 'Total Transaksi')
            ->setCellValue('D6', 'Total Laba/Rugi');
      $sheet->getColumnDimension('A')->setWidth(4);
      $sheet->getColumnDimension('B')->setWidth(20);
      $sheet->getColumnDimension('C')->setWidth(30);
      $sheet->getColumnDimension('D')->setWidth(25);
      $sheet->getStyle('A6:D6')->getFont()->setBold(true);
      
      $kolom = 7;$nomor=1; $total=0; $untung=0;
      foreach($sales->result() as $sale){
        $total += $sale->total;
        $untung += $sale->untung;
        $sheet->setCellValue('A' . $kolom, $nomor)
              ->setCellValue('B' . $kolom, $sale->tahun)
              ->setCellValue('C' . $kolom, $sale->total)
              ->setCellValue('D' . $kolom, $sale->untung);
        $sheet->getStyle('C'.$kolom)
              ->getNumberFormat()
              ->setFormatCode(NumberFormat::FORMAT_ACCOUNTING_RP);
        $sheet->getStyle('D'.$kolom)
              ->getNumberFormat()
              ->setFormatCode(NumberFormat::FORMAT_ACCOUNTING_RP);
        $nomor++;
        $kolom++;
      }
      $styleArray=[
        'borders' => [
            'allBorders' => [
              'borderStyle' => Border::BORDER_THIN,
              'color' => ['rgb' => '000000'],
            ],
          ]
        ];
        $stylethead = array(
          'fill'=> array(
            'fillType' => Fill::FILL_SOLID,
            'color' => ['rgb' => 'ABFC2F'],
          )
        );
      $sheet->getStyle('A6:D6')->applyFromArray($stylethead);
      $sheet->getStyle('A6:D'.$kolom)->applyFromArray($styleArray);

      $sheet->mergeCells('A'.$kolom.':B'.$kolom);
      $sheet->setCellValue('A'.$kolom, 'T O T A L');
      $sheet->getStyle('A'.$kolom)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
      $sheet->getStyle('A'.$kolom)->getFont()->setBold(true);
      $sheet->getStyle('A'.$kolom)->getFont()->setSize(14);

      $sheet->setCellValue('C'.$kolom, $total);
      $sheet->setCellValue('D'.$kolom, $untung);
      $sheet->getStyle('C'.$kolom.':D'.$kolom)
      ->getNumberFormat()
      ->setFormatCode(NumberFormat::FORMAT_ACCOUNTING_RP);

      $kolom++;
      $sheet->mergeCells('A'.$kolom.':D'.$kolom);
      $sheet->setCellValue('A'.$kolom, 'Digenerate pada tanggal : '.date('d/m/Y H:i:s'));
      $sheet->getStyle('A'.$kolom)->getFont()->setItalic(true);

      $kolom++;      
      $sheet->mergeCells('A'.$kolom.':D'.$kolom);
      $sheet->setCellValue('A'.$kolom, 'Digenerate Oleh : '.getuser()->username);
      $sheet->getStyle('A'.$kolom)->getFont()->setItalic(true);

      header('Content-Type: application/vnd.ms-excel');
      header('Content-Disposition: attachment;filename="'.$filename.'.xlsx"');
      header('Cache-Control: max-age=0');

      $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
      $writer->save('php://output');
    }

    public function cetak_struk()
    {
      $this->load->view('report/struk');
    }

    public function stock_in_out()
    {
      $post = $this->input->post();
      
      if($post!=null){
        $data['startdate'] = $post['start'];
        $data['enddate'] = $post['end'];
        $data['type'] = $post['type'];
      }else{
        $data['startdate'] = date('01/m/Y');
        $data['enddate'] = date('t/m/Y');
        $data['type'] = 2;
        // $data['startmonth'] = '01/2019';
        // $data['endmonth'] = '12/2019';
      }
      $data['stokinout'] = $this->Report_model->get_stok_in_out(datemysql($data['startdate']),datemysql($data['enddate']),$data['type']);
      $data['main_title'] = 'Laporan';
      $data['sub_title'] = 'Stok Masuk/Keluar';
      $data['content'] = 'report/stok/in_out';
      $data['codejs'] = 'report/codejs';
      $this->load->view('template',$data);
    }

    public function purchase(){

      $get = $this->input->post();
      
      if($get!=null){
        $data['startdate'] = $get['startdate'];
        $data['enddate'] = $get['enddate'];
      }else{
        $data['startdate'] = date('01/m/Y');
        $data['enddate'] = date('t/m/Y');
      }

      $data['purchase'] = $this->Report_model->getpurchase(datemysql($data['startdate']),datemysql($data['enddate']));
      $data['codejs'] = 'report/codejs';
      $data['main_title'] = 'Laporan';
      $data['sub_title'] = 'Pembelian';
      $data['content'] = 'report/purchase/ringkasan_detail';
      $this->load->view('template',$data);      
    }

    public function print_purchase()
    {
      $post = $this->input->get();
      $data['startdate'] = $post['start'];
      $data['enddate'] = $post['end'];

      $data['purchase'] = $this->Report_model->getpurchase(datemysql($data['startdate']),datemysql($data['enddate']));
      $data['sub_title'] = 'Laporan Pembelian';

      $this->load->library('Pdfgenerator');
      
      $this->pdfgenerator->setPaper('A4', 'potrait');
      $this->pdfgenerator->filename = "Laporan Pembelian - ".time().".pdf";
      $this->pdfgenerator->load_view('print/purchase/ringkasan',$data);
    }

    public function print_purchase_detail()
    {
      $invoice = $this->input->get('invoice');
      
      $data['purchase_detail'] = $this->Report_model->getpurchasedetail($invoice);
      // echo "<pre>";
      // var_dump($data['purchase_detail']->result());die;
      $data['sub_title'] = 'Laporan Pembelian';
      $data['getinvoice'] = $invoice;

      $this->load->library('Pdfgenerator');
      
      $this->pdfgenerator->setPaper('A4', 'potrait');
      $this->pdfgenerator->filename = "Laporan Penjualan Detail - ".time().".pdf";
      $this->pdfgenerator->load_view('print/purchase/detail',$data);
    }

    public function show_display_purchase()
    {
      $invoice = $this->input->post('invoice');
      if($invoice!=null){
        $data = $this->db->get_where('purchase_detail', array('id_purchase' => $invoice));
        if($data->num_rows()>0){
          $output = '';
          $no = 0;
          $total=0;
          foreach ($data->result() as $d) {
           $no++;
           $total+=$d->sub_total;
           $output .= '
              <tr>
                <td>'.$no.'</td>
                <td>'.$d->kode_product.'</td>
                <td>'.$d->name_product.'</td>
                <td class="text-right">'.rupiah($d->price).'</td>
                <td class="text-right">'.$d->qty.'</td>
                <td class="text-right">'.rupiah($d->sub_total).'</td>
              </tr>
           '; 
          }
          $output .='
            <tr>
              <th class="text-right" colspan="5">T O T A L</th>
              <td class="text-right">'.rupiah($total).'</td>
            </tr>
          ';
          echo $output;
        }else{
          echo "deta tidak ditemukan";
        }
      }else{
        echo "invoice belum diinputkan";
      }
    }

    public function printt()
    {
      $this->load->library('Pdfgenerator');
        
      $this->pdfgenerator->setPaper('A4', 'potrait');
      $this->pdfgenerator->filename = "Laporan Data Penggajian - ".time().".pdf";
      $this->pdfgenerator->load_view('print/coba');
    }

    public function excel()
    {
      $filename='nama_custom.xlsx';

      header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
      header('Content-Disposition: attachment;filename="'.$filename.'"');
      
      $spreadsheet = new Spreadsheet();
      $sheet = $spreadsheet->getActiveSheet();
      $sheet->setCellValue('A1', 'Hello Spreadsheet Wpangestu');

      $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
      $writer->save('php://output');
    }

    public function excel_product()
    {

      $filename="Laporan Data Barang - ".time();

      $spreadsheet = new Spreadsheet();
      $sheet = $spreadsheet->getActiveSheet();
      $sheet->mergeCells('A1:J1');
      $sheet->mergeCells('A2:J2');
      $sheet->mergeCells('A3:J3');
      $sheet->mergeCells('A4:J4');
      $sheet->mergeCells('A5:J5');

      $sheet->setCellValue('A1', getsetting()->nm_toko);
      $sheet->getStyle('A1')->getFont()->setBold(true);        
      $sheet->getStyle('A1')->getFont()->setSize(26);
      $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);


      $sheet->setCellValue('A2', getsetting()->keterangan_toko);
      $sheet->getStyle('A2')->getFont()->setBold(true);        
      $sheet->getStyle('A2')->getFont()->setSize(13);
      $sheet->getStyle('A2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

      $sheet->setCellValue('A4', 'Laporan Data Barang');

      $sheet->getStyle('A4:A5')->getFont()->setBold(true);
      $sheet->getStyle('A4:A5')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

      $sheet->setCellValue('A6', 'No')
            ->setCellValue('B6', 'Kode Barang')
            ->setCellValue('C6', 'Nama Barang')
            ->setCellValue('D6', 'Stok')
            ->setCellValue('E6', 'Harga Pokok')
            ->setCellValue('F6', 'Harga Jual')
            ->setCellValue('G6', 'Kategori')
            ->setCellValue('H6', 'Create At')
            ->setCellValue('I6', 'Update At')
            ->setCellValue('J6', 'Deskripsi');
      $sheet->getColumnDimension('A')->setWidth(6);
      $sheet->getColumnDimension('B')->setWidth(15);
      $sheet->getColumnDimension('C')->setWidth(40);
      $sheet->getColumnDimension('D')->setWidth(8);
      $sheet->getColumnDimension('E')->setWidth(15);
      $sheet->getColumnDimension('F')->setWidth(15);
      $sheet->getColumnDimension('G')->setWidth(15);
      $sheet->getColumnDimension('H')->setWidth(20);
      $sheet->getColumnDimension('I')->setWidth(20);
      $sheet->getColumnDimension('J')->setWidth(45);
      $sheet->getStyle('A6:J6')->getFont()->setBold(true);
      
      $this->db->select('product.*, category.name');
      $this->db->join('category','category.id=product.category_id','left');
      $products = $this->db->get('product');

      $nomor=1;$kolom=7;
      foreach($products->result() as $product){

        $sheet->setCellValue('A' . $kolom, $nomor)
              ->setCellValue('B' . $kolom, $product->id_product)
              ->setCellValue('C' . $kolom, $product->name_product)
              ->setCellValue('D' . $kolom, $product->stock)
              ->setCellValue('E' . $kolom, $product->price)
              ->setCellValue('F' . $kolom, $product->price_sale)
              ->setCellValue('G' . $kolom, $product->name)
              ->setCellValue('H' . $kolom, $product->create_at)
              ->setCellValue('I' . $kolom, $product->update_at)
              ->setCellValue('J' . $kolom, $product->description);
              $sheet->getStyle('F'.$kolom)
              ->getNumberFormat()
              ->setFormatCode(NumberFormat::FORMAT_ACCOUNTING_RP);
        $sheet->getStyle('G'.$kolom)
              ->getNumberFormat()
              ->setFormatCode(NumberFormat::FORMAT_ACCOUNTING_RP);
        $nomor++;
        $kolom++;
      }
      $styleArray=[
        'borders' => [
            'allBorders' => [
              'borderStyle' => Border::BORDER_THIN,
              'color' => ['rgb' => '000000'],
            ],
          ]
        ];
        $stylethead = array(
          'fill'=> array(
            'fillType' => Fill::FILL_SOLID,
            'color' => ['rgb' => 'ABFC2F'],
          )
        );
      $sheet->getStyle('A6:J6')->applyFromArray($stylethead);
      $sheet->getStyle('A6:J'.$kolom)->applyFromArray($styleArray);

      // $sheet->mergeCells('A'.$kolom.':B'.$kolom);
      // $sheet->setCellValue('A'.$kolom, 'T O T A L');
      // $sheet->getStyle('A'.$kolom)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
      // $sheet->getStyle('A'.$kolom)->getFont()->setBold(true);
      // $sheet->getStyle('A'.$kolom)->getFont()->setSize(14);

      $kolom++;
      $sheet->mergeCells('A'.$kolom.':D'.$kolom);
      $sheet->setCellValue('A'.$kolom, 'Digenerate pada tanggal : '.date('d/m/Y H:i:s'));
      $sheet->getStyle('A'.$kolom)->getFont()->setItalic(true);

      $kolom++;      
      $sheet->mergeCells('A'.$kolom.':D'.$kolom);
      $sheet->setCellValue('A'.$kolom, 'Digenerate Oleh : '.getuser()->username);
      $sheet->getStyle('A'.$kolom)->getFont()->setItalic(true);

      header('Content-Type: application/vnd.ms-excel');
      header('Content-Disposition: attachment;filename="'.$filename.'.xlsx"');
      header('Cache-Control: max-age=0');

      $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
      $writer->save('php://output');
    }

    public function sell_bycustomer()
    {
      $get = $this->input->get('tglrange');
      
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
      // $data['sales'] = $this->Report_model->get_sell_daily(datemysql($data['startdate']),datemysql($data['enddate']));
      $data['sales'] = $this->Report_model->get_sale_customer(datemysql($data['startdate']),datemysql($data['enddate']));
      $data['customer'] = $this->db->get('customer');
      $data['main_title'] = 'Laporan';
      $data['sub_title'] = 'Penjualan Pelanggan';
      $data['content'] = 'report/sale/bycustomer';
      $this->load->view('template',$data);
    }

    public function sell_customer_detail($kode)
    {
      $post = $this->input->post();
      $data['kode'] = $kode;
      
      // $data['sales'] = $this->Report_model->get_sale_customer_detail(bulanindo($data['startmonth']),bulanindo($data['endmonth']),$kode);
      $data['pelanggan'] = $this->db->get_where('customer',array('id_customer'=>$kode))->row();
      $data['last_sale'] = $this->Report_model->get_last_sell_customer($kode)->row();
      $data['sale_today'] = $this->Report_model->get_sell_daily(date('Y-m-d'),date('Y-m-d'),$kode)->row();
      $data['sale_thismonth'] = $this->Report_model->sell_monthly(date('Y-m'),date('Y-m'),$kode)->row();
      // var_dump($data['sale_thismonth']);die;
      $data['main_title'] = 'Laporan';
      $data['sub_title'] = 'Penjualan pelanggan detail';
      $data['content'] = 'report/sale/customerdetail';
      $data['codejs'] = 'report/codejs';
      $this->load->view('template',$data);
    }

    public function get_detail_invoice()
    {
      $invoice = $this->input->post('invoice');
      // $invoice = $i;

      $this->db->select('sales.*,users.username');
      $this->db->where('invoice',$invoice);
      $this->db->join('users','users.id=sales.id_user','left');
      $sale = $this->db->get('sales')->row();
      
      $this->db->where('invoice',$invoice);
      $detail = $this->db->get('sale_detail')->result();
      

      if(isset($sale)&&isset($detail)){
        $datetime = date_create($sale->datetime_sales);
        $info_sale = array(
          "invoice" => $sale->invoice,
          "tanggal" => date_format($datetime,'d/m/Y'),
          "jam" => date_format($datetime,'H.i'),
          "kasir" => $sale->username,
          "total" => $sale->total_sales,
          "pay_money" => $sale->pay_money,
          "refund" => $sale->refund
        );

        $detail_sales=$detail;

        $success=true;
        $data = array(
          "info" => $info_sale,
          "detail"=>$detail_sales
        );

      }else{
        $success=false;
        $data=null;
      }

      $response = array(
        "success" => $success,
        "data" => $data
      );

      echo json_encode($response);
    }
} 