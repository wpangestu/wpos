<?php
class Transaction extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        check_is_login();
        // $this->load->model('Report_model');
        $this->load->model('Stock_model','sim');
    }

    public function purchase()
    {
      $data['main_title'] = 'Transaksi';
      $data['sub_title'] = 'Pembelian';
      $data['content'] = 'transaksi/pembelian';
      $data['codejs'] =  'transaksi/codejs';
      $data['supplier'] = $this->db->get('supplier');
      $this->load->view('template',$data);
    }

    public function process_purchase()
    {
        $total = $this->input->post('totalharga');
        $id_supplier = $this->input->post('id_supplier');
        $id_purchase = $this->input->post('id_purchase');
        $id_user = getuser()->id;

        if($total>0){

            $data = array(
                'id_purchase' => $id_purchase,
                'id_supplier' => $id_supplier,
                'total'     => str_replace('.','',$total),
                'id_user'   => $id_user,
            );

            $this->db->insert('purchase',$data);

            foreach ($this->cart->contents() as $items) {
                if($items['type']==0){
                    $data = array(
                        'id_purchase'=> $id_purchase,
                        'kode_product'=> $items['id'],
                        'name_product'=> $items['name'],
                        'price'=> $items['price'],
                        'price_sale'=> $items['harga_jual'],
                        'qty'=> $items['qty'],
                        'sub_total' => $items['subtotal'],
                    );
                    
                    $this->db->insert('purchase_detail', $data);
                    
                    $this->db->set('price', $items['price']);
                    $this->db->set('price_sale', $items['harga_jual']);
                    $this->db->set('price_sale_3', $items['harga_jual3']);
                    $this->db->set('price_sale_5', $items['harga_jual5']);
                    $this->db->set('price_sale_10', $items['harga_jual10']);
                    $this->db->set('stock', 'stock+'.$items['qty'], false);
                    $this->db->where('id_product', $items['id']);
                    $this->db->update('product');
                }
            }
            $this->cart->destroy();

            $this->session->set_flashdata('type','success_sw');
            $this->session->set_flashdata('message','Transaksi Berhasil');
            redirect(base_url('transaksi/pembelian'));

        }else{
            $this->session->set_flashdata('type','failed_sw');
            $this->session->set_flashdata('message','Tidak ada barang dimasukan');
            redirect(base_url('transaksi/pembelian'));
        }
    }

    public function insert_cart()
    {
        $idbrng = $this->input->post('id_barang_tmp');
        $nmbrg = $this->input->post('nmbrg_tmp');
        $harpok = str_replace('.','',$this->input->post('harga_pokok_tmp'));
        $harga_jual = str_replace('.','',$this->input->post('harga_jual_tmp'));
        $harga_jual3 = str_replace('.','',$this->input->post('harga_jual3_tmp'));
        $harga_jual5 = str_replace('.','',$this->input->post('harga_jual5_tmp'));
        $harga_jual10 = str_replace('.','',$this->input->post('harga_jual10_tmp'));
        $qty = $this->input->post('qty_tmp');
        $subtotal = $harpok*$qty;

        $data = array(
            'id'       => $idbrng,
            'name'     => $nmbrg,
            'hargapokok' => $harpok,
            'harga_jual' => $harga_jual,
            'harga_jual3' => $harga_jual3,
            'harga_jual5' => $harga_jual5,
            'harga_jual10' => $harga_jual10,
            'price'    => $harpok,
            'qty'      => $qty,
            'subtotal' => $subtotal,
            'type'      => 0,
        );

        $cart = $this->cart->contents();
            $exists = false;
            $rowid = '';

            foreach($cart as $item){
                if($item['id'] == $idbrng && $item['type']==0)
                {
                    $exists = true;
                    $rowid = $item['rowid'];
                    $jumlah = $item['qty'] + $qty;
                }       
            }

            if($exists)
            {
                $up=array(
                    'rowid'=> $rowid,
                    'qty'=>$jumlah,
                );
                $this->cart->update($up);
            }
            else
            {
                $this->cart->insert($data);
            }
        echo $this->show_cart(); 
    }

    function hapus_cart(){ //fungsi untuk menghapus item cart
        $data = array(
            'rowid' => $this->input->post('row_id'), 
            'qty' => 0, 
        );
        $this->cart->update($data);
        echo $this->show_cart();
    }

    public function show_cart(){ //Fungsi untuk menampilkan Cart
        $output = '';
        $no = 0;
        $total = 0;
        foreach ($this->cart->contents() as $items) {
            if($items['type']==0){
                $total += $items['subtotal'];
                $no++;
                $output .='
                    <tr>
                        <td>'.$no.'</td>
                        <td width="100px">'.$items['id'].'</td>
                        <td width="250px">'.$items['name'].'</td>
                        <td class="text-right">'.number_format($items['price']).'</td>
                        <td class="text-right">'.number_format($items['harga_jual']).'</td>
                        <td class="text-right">'.$items['qty'].' PC</td>
                        <td class="text-right">'.number_format($items['subtotal']).'</td>
                        <td class="text-center" width="70px">
                            <button type="button" id="'.$items['rowid'].'" class="hapus_cart btn btn-danger btn-xs"><i class="fa fa fa-times"></i></button>
                        </td>
                    </tr>
                ';
            }
        }
        if($total==0){
            $output .= '
            <tr>
                <td colspan="8">Tidak ada data</td>
            </tr>
            ';
        }
        $output .='<input type="hidden" id="totalharga" name="totalharga" value="'.rupiah($total).'">';
        return $output;
    }

    public function stock_in()
    {
        $data['main_title'] = 'Transaksi';
        $data['sub_title'] = 'Stok In';
        $data['content'] = 'transaksi/stock_in';
        $data['stockin'] = $this->sim->get_all('1');
        $data['codejs'] = 'transaksi/codejs_stock';
        $this->load->view('template',$data);

    }

    public function stock_in_add()
    {
        $data['main_title'] = 'Stok In';
        $data['sub_title'] = 'Tambah data';
        $data['content'] = 'transaksi/stock_in_add';
        $data['codejs'] = 'transaksi/codejs_stock';
        $this->load->view('template',$data);
    }

    public function process_stockin_add()
    {
        $id_product = $this->input->post('kodebarang');
        $qty = $this->input->post('qty');
        $tanggal = $this->input->post('tanggal');
        $data = array(
            'id_product' => $id_product,
            'detail' => $this->input->post('detail'),
            'qty' => $qty,
            'datetime' => datemysql($tanggal),
            'type' => 1
        );

        $this->db->insert('stock_in_out',$data);

        $this->db->set('stock', 'stock+'.$qty, false);
        $this->db->where('id_product', $id_product);
        $this->db->update('product');

        $this->session->set_flashdata('type', 'success');
        $this->session->set_flashdata('message', 'Data berhasil ditambah');
        redirect(base_url('transaksi/stokin'));
    }

    public function stock_out()
    {
        $data['main_title'] = 'Transaksi';
        $data['sub_title'] = 'Stok Out';
        $data['content'] = 'transaksi/stock_out';
        $data['stockin'] = $this->sim->get_all('0');
        $data['codejs'] = 'transaksi/codejs_stock';
        $this->load->view('template',$data);

    }

    public function stock_out_add()
    {
        $data['main_title'] = 'Stok Out';
        $data['sub_title'] = 'Tambah data';
        $data['content'] = 'transaksi/stock_out_add';
        $data['codejs'] = 'transaksi/codejs_stock';
        $this->load->view('template',$data);
    }

    public function process_stockout_add()
    {
        $id_product = $this->input->post('kodebarang');
        $qty = $this->input->post('qty');
        $tanggal = $this->input->post('tanggal');
        $data = array(
            'id_product' => $id_product,
            'detail' => $this->input->post('detail'),
            'qty' => $qty,
            'datetime' => datemysql($tanggal),
            'type' => 0
        );

        $this->db->insert('stock_in_out',$data);

        $this->db->set('stock', 'stock-'.$qty, false);
        $this->db->where('id_product', $id_product);
        $this->db->update('product');

        $this->session->set_flashdata('type', 'success');
        $this->session->set_flashdata('message', 'Data berhasil disimpan');
        redirect(base_url('transaksi/stokout'));
    }

}