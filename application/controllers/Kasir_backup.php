<?php

use Mike42\Escpos\CapabilityProfiles\DefaultCapabilityProfile;
use Mike42\Escpos\PrintConnectors\FilePrintConnector;
use Mike42\Escpos\Printer;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;

class Kasir extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        check_is_login();
        $this->load->model('Product_model');
        $this->load->library('datatables');
        $this->load->model('customer_model');
        $this->load->model('Report_model');
    }
    public function index()
    {
        $data['main_title'] = 'Transaksi';
        $data['sub_title'] = 'Penjualan';
        $data['content'] = 'kasir/v_kasir';
        $data['lebar'] = true;
        $data['customers'] = $this->customer_model->get_all();
        $data['kategori'] = $this->db->get('category');
        $data['item'] = $this->db->get('product');
        $data['codejs'] = 'kasir/codejs';
        $this->load->view('template', $data);
    }

    public function json()
    {
        header('Content-Type: application/json');
        echo $this->Product_model->json_for_kasir();
    }

    public function coba()
    {
        is_admin();
        $data['main_title'] = 'Transaksi';
        $data['sub_title'] = 'Penjualan';
        $data['content'] = 'kasir/coba';
        $data['item'] = $this->db->get('item');
        $data['codejs'] = 'kasir/codejs2';
        $this->load->view('template', $data);
    }

    public function getitem()
    {
        $kode = $this->input->post('kode_brg');
        $getitem = $this->db->get_where('product', array('id_product' => $kode));
        if ($getitem->num_rows() > 0) {
            $item = $getitem->row();
            $status = true;
            $data = array(
                'kode_item' => $item->id_product,
                'nama' => $item->name_product,
                'satuan' => $item->unit_id,
                'stok' => $item->stock,
                'harga_pokok' => $item->price,
                'harga' => $item->price_sale,
                'harga3' => $item->price_sale_3,
                'harga5' => $item->price_sale_5,
                'harga10' => $item->price_sale_10,
            );
        } else {
            $status = false;
            $data = 'no data';
        }

        $response = array(
            'status' => $status,
            'data' => $data,
        );

        echo json_encode($response);
    }

    public function insert_cart()
    {
        $idbrng = $this->input->post('id_barang_tmp');
        $nmbrg = $this->input->post('nmbrg_tmp');
        $satuan = $this->input->post('satuan_tmp');
        $harga = $this->input->post('harga_tmp');
        $diskon = $this->input->post('diskon_tmp');
        $jumlah = $this->input->post('jumlah_tmp');
        $harpok = $this->input->post('harpok');

        $data = array(
            'id'            => $idbrng,
            'name'          => $nmbrg,
            'satuan'        => $satuan,
            'custom'        => 'off',
            'hargapokok'    => $harpok,
            'harga_jual'    => $harga,
            'price'         => $harga - $diskon,
            'disc'          => $diskon,
            'qty'           => $jumlah,
            'type'          => 1,
        );

        $cart = $this->cart->contents(); //get all items in the cart
        $exists = false;             //lets say that the new item we're adding is not in the cart
        $rowid = '';

        foreach ($cart as $item) {
            if ($item['id'] == $idbrng && $item['type'] == 1)     //if the item we're adding is in cart add up those two quantities
            {
                $exists = true;
                $rowid = $item['rowid'];
                $qty = $item['qty'] + $jumlah;
            }
        }

        if ($exists) {
            $getproduk = $this->db->get_where('product', array('id_product' => $idbrng))->row();

            if($getproduk->price_sale_10>0 && $qty>=10){
                $price = $getproduk->price_sale_10;
            }elseif($getproduk->price_sale_5>0 && $qty>=5){
                $price = $getproduk->price_sale_5;
            }elseif($getproduk->price_sale_3>0 && $qty>=3){
                $price = $getproduk->price_sale_3;
            }
            if(isset($price)){
                $up = array(
                    'harga_jual' => $price,
                    'price' => $price-$diskon,
                    'rowid' => $rowid,
                    'qty' => $qty,
                );
            }else{
                $up = array(
                    'rowid' => $rowid,
                    'qty' => $qty,
                );
            }
            $this->cart->update($up);
        } else {
            $this->cart->insert($data);
        }
        echo $this->show_cart(); //tampilkan cart setelah added
        // redirect(base_url('kasir'));
    }

    public function remove()
    {
        $row_id = $this->uri->segment(3);
        $this->cart->update(array(
            'rowid'      => $row_id,
            'qty'     => 0
        ));
        redirect(base_url('kasir'));
    }

    public function updateharga()
    {
        $rowid = $this->input->post('rowid');
        $idbarang = $this->input->post('idbarang');
        $nmbarang = $this->input->post('nmbarang');
        $harpok = $this->input->post('hrgpokok');
        $price = $this->input->post('hrgjual');
        $price3 = $this->input->post('hrgjual3');
        $price5 = $this->input->post('hrgjual5');
        $price10 = $this->input->post('hrgjual10');

        $this->db->set('name_product', $nmbarang);
        $this->db->set('price', str_replace('.','',$harpok));
        $this->db->set('price_sale', str_replace('.','',$price));
        $this->db->set('price_sale_3', str_replace('.','',$price3));
        $this->db->set('price_sale_5', str_replace('.','',$price5));
        $this->db->set('price_sale_10', str_replace('.','',$price10));
        $this->db->where('id_product', $idbarang);
        $this->db->update('product');

        $up = array(
            'rowid'     => $rowid,
            'name'      => $nmbarang,
            'hargapokok'=> str_replace('.','',$harpok),
            'harga_jual'=> str_replace('.','',$price),
            'price'     => str_replace('.','',$price),
            'qty'       => 1,
            'disc'      => 0
        );
        $this->cart->update($up);
        
        echo $this->show_cart();

    }

    public function show_cart()
    { //Fungsi untuk menampilkan Cart
        $output = '';
        $no = 0;
        $total = 0;
        $cek=false;
        foreach ($this->cart->contents(TRUE) as $items) {
            if ($items['type'] == 1) {
                $cek=true;
                $total += $items['subtotal'];
                $no++;
                $output .= '
                    <tr>
                        <td>' . $no . '</td>
                        <td width="100px">' . $items['id'] . '</td>
                        <td width="250px"><span class="name_product" data-kode="'.$items['id'].'">'.$items['name'].'</span></td>
                        <td class="text-right"><a href="#" class="editproduk" data-id="'.$items['id'].'">' . number_format($items['harga_jual']) . '</a></td>
                        <td class="text-right" width="50px">' . $items['disc'] . '</td>
                        <td width="110px">
                            <div class="input-group">
                                
                                <input onclick="this.select()" min="0" data-rowid="'.$items['rowid'] .'" type="number" value="'.$items['qty'] .'" class="form-control text-center input-sm qty-input">
                            </div>
                        </td>
                        <td class="text-right">' . number_format($items['subtotal']) . '</td>
                        <td width="70px">
                            <div class="btn-group">
                                <button
                                data-rowid="' . $items['rowid'] . '" 
                                data-idbarang="' . $items['id'] . '" 
                                data-nmbarang="' . $items['name'] . '" 
                                data-hrgjual="' . $items['harga_jual'] . '"
                                data-hrgpokok="' . $items['hargapokok'] . '"
                                data-disc="' . $items['disc'] . '"
                                data-qty="' . $items['qty'] . '"
                                type="button" id="' . $items['rowid'] . '" class="edit_cart btn btn-primary btn-xs"><i class="fa fa-edit"></i></button>
                                <button type="button" id="' . $items['rowid'] . '" class="hapus_cart btn btn-danger btn-xs"><i class="fa fa fa-times"></i></button>
                            <div>
                        </td>
                    </tr>
                ';
            }
        }
        $output .= '<input type="hidden" name="jumlahtotal" id="jumlahtotal" value="' . rupiah($total) . '">';
        if(!$cek){
            $output .= '
                <tr>
                    <td colspan="8">Cart kosong</td>
                </tr>
            ';
        }
        return $output;
    }

    function load_cart()
    { //load data cart
        echo $this->show_cart();
    }

    function add_to_cart()
    { //fungsi Add To Cart
        $data = array(
            'id' => $this->input->post('produk_id'),
            'name' => $this->input->post('produk_nama'),
            'price' => $this->input->post('produk_harga'),
            'qty' => $this->input->post('quantity'),
        );
        $this->cart->insert($data);
        echo $this->show_cart(); //tampilkan cart setelah added
    }

    function hapus_cart()
    { //fungsi untuk menghapus item cart
        $data = array(
            'rowid' => $this->input->post('row_id'),
            'qty' => 0,
        );
        $this->cart->update($data);
        echo $this->show_cart();
    }

    function update_cart(){

        $rowid = $this->input->post('rowid');
        $qtynew = $this->input->post('qty');
        $custom = $this->input->post('custom');
        $price_sale = str_replace('.','',$this->input->post('price_sale'));
        $diskon = $this->input->post('diskon');

        if($custom=="on"){
            $price = $price_sale;
            $custom = "on";
        }else{
            $custom = "off";
            $cart = $this->cart->contents(); //get all items in the cart
            foreach ($cart as $item) {
                if ($item['rowid'] == $rowid)     //if the item we're adding is in cart add up those two quantities
                {
                    $idbarang=$item['id'];
                    $diskon=$item['disc'];
                }
            }
    
            $getproduk = $this->db->get_where('product', array('id_product' => $idbarang))->row();
    
            if($getproduk->price_sale_10>0 && $qty>=10){
                $price = $getproduk->price_sale_10;
            }elseif($getproduk->price_sale_5>0 && $qty>=5){
                $price = $getproduk->price_sale_5;
            }elseif($getproduk->price_sale_3>0 && $qty>=3){
                $price = $getproduk->price_sale_3;
            }else{
                $price = $getproduk->price_sale;
            }
        }
        $data = array(
            'harga_jual' => $price,
            'price' => $price,
            'rowid' => $rowid,
            'qty' => $qtynew,
            'custom' => $custom
        );
        $this->cart->update($data);
        echo $this->show_cart();
    }

    function custom_qty()
    {
        $rowid = $this->input->post('rowid');
        $qtynew = $this->input->post('qty');

        $cart = $this->cart->contents(); //get all items in the cart
        foreach ($cart as $item) {
            if ($item['rowid'] == $rowid)     //if the item we're adding is in cart add up those two quantities
            {
                $qty = $qtynew;
                $idbarang=$item['id'];
                $diskon=$item['disc'];
            }
        }

        $getproduk = $this->db->get_where('product', array('id_product' => $idbarang))->row();

            if($getproduk->price_sale_10>0 && $qty>=10){
                $price = $getproduk->price_sale_10;
            }elseif($getproduk->price_sale_5>0 && $qty>=5){
                $price = $getproduk->price_sale_5;
            }elseif($getproduk->price_sale_3>0 && $qty>=3){
                $price = $getproduk->price_sale_3;
            }else{
                $price = $getproduk->price_sale;
            }

        $data = array(
            'harga_jual' => $price,
            'price' => $price-$diskon,
            'rowid' => $rowid,
            'qty' => $qty
        );
        $this->cart->update($data);
        echo $this->show_cart();
    }

    function tambah_qty()
    {
        $rowid = $this->input->post('rowid');
        $cart = $this->cart->contents(); //get all items in the cart
        foreach ($cart as $item) {
            if ($item['rowid'] == $rowid)     //if the item we're adding is in cart add up those two quantities
            {
                $qty = $item['qty'] + 1;
                $idbarang=$item['id'];
                $diskon=$item['disc'];
            }
        }

        $getproduk = $this->db->get_where('product', array('id_product' => $idbarang))->row();

            if($getproduk->price_sale_10>0 && $qty>=10){
                $price = $getproduk->price_sale_10;
            }elseif($getproduk->price_sale_5>0 && $qty>=5){
                $price = $getproduk->price_sale_5;
            }elseif($getproduk->price_sale_3>0 && $qty>=3){
                $price = $getproduk->price_sale_3;
            }else{
                $price = $getproduk->price_sale;
            }

        $data = array(
            'harga_jual' => $price,
            'price' => $price-$diskon,
            'rowid' => $rowid,
            'qty' => $qty
        );
        $this->cart->update($data);
        echo $this->show_cart();
    }

    function kurang_qty()
    {
        $rowid = $this->input->post('rowid');
        $cart = $this->cart->contents(); //get all items in the cart
        foreach ($cart as $item) {
            if ($item['rowid'] == $rowid)     //if the item we're adding is in cart add up those two quantities
            {
                $qty = $item['qty'] - 1;
                $idbarang=$item['id'];
                $diskon=$item['disc'];
            }
        }

        $getproduk = $this->db->get_where('product', array('id_product' => $idbarang))->row();

            if($getproduk->price_sale_10>0 && $qty>=10){
                $price = $getproduk->price_sale_10;
            }elseif($getproduk->price_sale_5>0 && $qty>=5){
                $price = $getproduk->price_sale_5;
            }elseif($getproduk->price_sale_3>0 && $qty>=3){
                $price = $getproduk->price_sale_3;
            }else{
                $price = $getproduk->price_sale;
            }

        $data = array(
            'harga_jual' => $price,
            'price' => $price-$diskon,
            'rowid' => $rowid,
            'qty' => $qty
        );
        $this->cart->update($data);
        echo $this->show_cart();
    }

    public function ubahcart()
    {
        $rowid = $this->input->post('rowid');
        $hrgjual = str_replace('.', '', $this->input->post('hrgjual'));
        $qty = $this->input->post('qty');
        $disc = str_replace('.', '', $this->input->post('disc'));

        $data = array(
            'rowid' => $rowid,
            'harga_jual' => $hrgjual,
            'price'    => $hrgjual - $disc,
            'disc'     => $disc,
            'qty' => $qty
        );
        $this->cart->update($data);
        echo $this->show_cart();
    }

    public function proses_penjualan()
    {
        // PROSES SIMPAN
        $print = $this->input->post('print_save');
        $save = $this->input->post('just_save');

        if ($this->cart->contents() != null) {
            $totalharga = $this->input->post('totalharga');
            $uangbayar = $this->input->post('uangbayar');
            $uangkembali = $this->input->post('uangkembali');
            $invoice = $this->input->post('invoice');
            $customer = $this->input->post('customer');

            $data = array(
                'invoice' => $invoice,
                'total_sales' => str_replace('.', '', $totalharga),
                'pay_money' => str_replace('.', '', $uangbayar),
                'refund' => str_replace('.', '', $uangkembali),
                'total_qty' => '5',
                'id_customer' => $customer,
                'id_user' => getuser()->id,
            );
            $this->db->insert('sales', $data);

            foreach ($this->cart->contents() as $items) {
                if ($items['type'] == 1) {
                    $data = array(
                        'invoice' => $invoice,
                        'kode_product' => $items['id'],
                        'name_product' => $items['name'],
                        'price' => $items['hargapokok'],
                        'price_sale' => $items['harga_jual'],
                        'qty' => $items['qty'],
                        'discount' => $items['disc'],
                        'sub_total' => $items['subtotal'],
                    );

                    $this->db->insert('sale_detail', $data);

                    $this->db->set('stock', 'stock-' . $items['qty'], false);
                    $this->db->where('id_product', $items['id']);
                    $this->db->update('product');
                }
            }
            $this->cart->destroy();

            if (isset($print)) {
                $this->printt($invoice);
                $this->session->set_flashdata('type', 'success_sw');
                $this->session->set_flashdata('message', 'Transaksi Berhasil Dicetak');
                redirect(base_url('kasir'));
            }elseif(isset($save)){

                $this->session->set_flashdata('type', 'success_sw');
                $this->session->set_flashdata('message', 'Transaksi Berhasil');
                redirect(base_url('kasir'));
            }

        } else {
            $this->session->set_flashdata('type', 'failed_sw');
            $this->session->set_flashdata('message', 'Tidak ada barang dimasukan');
            redirect(base_url('kasir'));
        }
    }

    public function printt($invoice)
    {
      $sale = $this->Report_model->get_struk_sale($invoice)->result();
      $datetime = date_create($sale[0]->datetime_sales);
      try {
  
        $connector = new WindowsPrintConnector(getsetting()->printer_name);
        
        /* Print a "Hello world" receipt" */
        $printer = new Printer($connector);
        // $a = $printer->getPrintConnector();
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

        $printer->text($line1."\n");
        $printer->text($line2."\n");
        $printer->text($line3."\n");
        
        $printer->text("----------------------------------------\n");
        $printer->setJustification(Printer::JUSTIFY_CENTER);
        $printer->text(getsetting()->footer_struk."\n");
        
        $printer->cut();
  
        /* Close printer */

        $printer->close();

      } catch (Exception $e) {
        echo "Couldn't print to this printer: " . $e->getMessage() . "\n";
      }
    }

    public function reset()
    {
        $this->cart->destroy();
        redirect(base_url('penjualan'));
    }
   
    function get_autocomplete(){
        if (isset($_GET['term'])) {
            $result = $this->Product_model->search_product($_GET['term']);
            if (count($result) > 0) {
            foreach ($result as $row)
                $arr_result[] = array(
                    "id"            => $row->id_product,
                    "label"         => $row->name_product." | Rp ".rupiah($row->price_sale),
                    "value"         => $row->id_product,
                    "name"          => $row->name_product,
                    "unit"          => $row->unit_id,
                    "price"         => $row->price,
                    "price_sale"    => $row->price_sale
                );
                echo json_encode($arr_result);
            }
        }
    }

    function get_tooltip_price(){
        $id = $this->input->get('id');
        $result ='';
        $produk = $this->db->where('id_product',$id)
                            ->get('product')
                            ->row();
        if(isset($produk)){
            $result .= "Harga Normal : Rp ".rupiah($produk->price_sale)."</br>";
            $result .= "Harga Min 3 : Rp ".rupiah($produk->price_sale_3)."</br>";
            $result .= "Harga Min 5 : Rp ".rupiah($produk->price_sale_5)."</br>";
            $result .= "Harga Min 10 : Rp ".rupiah($produk->price_sale_10)."</br>";
        }
        echo $result;
    }

    public function insert_produk(){
        $idbarang = $this->input->post('idbarang');
        
        $produk = $this->db->where('id_product',$idbarang)
                                ->get('product');
        $status='';
        $message='';
        if($produk->num_rows() > 0){
            $status = false;
            $message = "Kode barang sudah digunakan, masukan kodebarang lain";
        }else{
            $data = array(
                'id_product' => $this->input->post('idbarang',TRUE),
                'name_product' => strtoupper($this->input->post('nmbarang',TRUE)),
                'stock' => $this->input->post('stok',TRUE),
                'price' => str_replace('.','',$this->input->post('hrgpokok',TRUE)),
                'price_sale' => str_replace('.','',$this->input->post('hrgjual',TRUE)),
                'price_sale_3' => str_replace('.','',$this->input->post('hrgjual3',TRUE)),
                'price_sale_5' => str_replace('.','',$this->input->post('hrgjual5',TRUE)),
                'price_sale_10' => str_replace('.','',$this->input->post('hrgjual10',TRUE)),
                'category_id' => $this->input->post('category_id',TRUE),
                );
        
            $produk = $this->Product_model->insert($data);
            $status = true;
            $message = "Data berhasil disimpan";
        }
        $result = array(
            "status" => $status,
            "message" => $message
        );
        echo json_encode($result);
    }

}
