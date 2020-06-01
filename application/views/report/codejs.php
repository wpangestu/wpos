<script>
  $(function() {

    //Initialize Select2 Elements
    // $('.datepicker').datepicker({
    //   format: 'dd/mm/yyyy',
    //   autoclose : true,
    //   language : 'id',
    //   todayHighlight : true,
    //   enableOnReadonly : true,
    // });
    // $('.input-daterange').datepicker();
    // $('.input-monthrange').datepicker({
    //     format: 'M yyyy'
    // });

    $('#tbl_daftar').dataTable({
        fixedHeader : true,
        paging    : false,
        scrollY   :300,
        searching : false,
        order     : false,
    });

    $('.datepicker').datepicker({
      format: 'dd/mm/yyyy',
      autoclose: true,
      language: 'id',
      todayHighlight: true,
      enableOnReadonly: true,
    });

    $('.yearpick').datepicker({
      format: 'yyyy',
      autoclose: true,
      language: 'id',
      maxViewMode: 0,
      minViewMode: 2,
    });

    $('.monthpicker').datepicker({
      format: 'mm/yyyy',
      autoclose: true,
      language: 'id',
      maxViewMode: 2,
      minViewMode: 1,
      enableOnReadonly: true
    });

    $('.monthpicker2').datepicker({
      format: 'M yyyy',
      autoclose: true,
      language: 'id',
      maxViewMode: 2,
      minViewMode: 1,
      enableOnReadonly: true
    });

    $('.input-daterange').datepicker({

    });








    // $('#start').datepicker()
    //   .on('hide', function(e) {
    //     // `e` here contains the extra attributes
    //     var g = $('#start').datepicker('getDate');
    //     $('#end').datepicker('setStartDate', g);
    //     $('#end').datepicker('setDate', g);
    //   });

    $('.rowtable').click(function() {
      let invoice = $(this).data('id');
      let tgl = $(this).data('tgl');
      let jam = $(this).data('jam');
      let user = $(this).data('kasir');
      let total = $(this).data('total');
      let ubayar = $(this).data('uangbayar');
      let ukembali = $(this).data('uangkembali');

      $('#invoice').text(invoice);
      $('#tanggal').text(tgl);
      $('#user').text(user);
      $('#jam').text(jam);
      $('#btn_cetak_struct').data('invoice', invoice);
 
      $.ajax({
        url: "<?php echo base_url() ?>show_sale/show_display_transaksi",
        method: "POST",
        data: {
          invoice: invoice,
        },
        success: function(data) {
          $('#bodytable').html(data);
          $('#totalharga').text(total);
          $('#uangbayar').text(ubayar);
          $('#uangkembali').text(ukembali);
        }
      });
    })

    $(document).on('click', '#btn_cetak_struct', function() {
    // $('#btn_cetak_struct').click(function(){
      let id = $(this).data('invoice');
      $.ajax({
        url: "<?php echo base_url() ?>show_sale/printf",
        method: "POST",
        data: {
          invoice: id,
        },
        success: function(data) {
          if(data){
            Swal.fire({
              type: 'success',
              title: 'Sukses',
              text: 'Struk berhasil dicetak',
            })
          }
        }
      });
    });
    $(document).on('click', 'tr.rowtable', function() {
    // $("tr.rowtable").click(function() {
      $('#tfooter').show();
      $(this).addClass("selected").siblings().removeClass("selected");
    });

    $('.penjualan').click(function () {
      let tgl = $(this).data('tanggal');
      let jam = $(this).data('jam');
      let invoice = $(this).data('invoice');
      let supplier = $(this).data('supplier');
      let user = $(this).data('user');

      $('#tgl').text(tgl);
      $('#supplier').text(supplier);
      $('#user').text(user);
      $('#jam').text(jam);
      $('#invoice').text(invoice);
      $('#invoicehidden').val(invoice);


      $.ajax({
        url: "<?php echo base_url() ?>report/show_display_purchase",
        method: "POST",
        data: {
          invoice: invoice,
        },
        success: function(data) {
          $('#bodytable').html(data);
        }
      });

      $('#modal-detail').modal('show');
    })

    $('form#penjualan_detail').submit(function(e){
      e.preventDefault();

      $('#btn-penjualan-detail').html('<i class="fa fa-spinner fa-spin"></i>')

      const data = $(this).serialize();
      let res = '';
      $.ajax({
        url: "<?php echo base_url() ?>show_sale/by_customer",
        method: "POST",
        data: data,
        dataType: 'json',
        success: function(response) {
          setTimeout(()=>{
            $('#btn-penjualan-detail').html('Tampil')
          },1000)
          if(response.success==true){
            const data = response.data;
            // console.log(data);
            res = detail_filled(data);
            $('#result-tab-1').html(res);
            $('#tbl_detail_penjualan_pelanggan').DataTable({
              order:false,
              searching: false
            });
          }else{
            res += detail_empty();
            $('#result-tab-1').html(res);
          }
        }
      });
    })

    function number_format(data){
      return data.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }

    function detail_filled(data){
      let html = '';
      html += `
                <table id="tbl_detail_penjualan_pelanggan" class="table table-bordered table-fixed">
                  <thead>
                    <tr>
                      <th width="10px">No</th>
                      <th>Tanggal</th>
                      <th>Waktu</th>
                      <th>Invoice</th>
                      <th>Total Belanja</th>
                    </tr>
                  </thead>
                  <tbody>`;
        data.forEach((element,i) => {
          html += `
                    <tr class="rowtable" data-invoice="${element.invoice}" data>
                      <td width="10px">${i+1}</td>
                      <td>${element.tanggal}</td>
                      <td>${element.waktu}</td>
                      <td>${element.invoice}</td>
                      <td align="right">Rp. ${number_format(element.total)}</td>
                    </tr>
          `;
        });
        html += `</tbody>
                </table>`
        return html;
    }

    function detail_empty(){
      return `
      <table class="table table-bordered">
        <thead>
          <tr>
            <th>No</th>
            <th>Tanggal</th>
            <th>Waktu</th>
            <th>Invoice</th>
            <th>Total Belanja</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td colspan="5">Data tidak ditemukan</td>
          </tr>
        </tbody>
      </table>
      `;
    }

    $(document).on('click', '.rowtable', function() {
      const invoice = $(this).data('invoice');
      $.ajax({
        url: "<?php echo base_url() ?>report/get_detail_invoice",
        method: "POST",
        data: { invoice : invoice},
        dataType: 'json',
        success: function(response) {

          if(response.success==true){
            const info = response.data.info;
            const detail = response.data.detail;
            console.log(info)
            console.log(detail)
            let res = process_invoice(info,detail);
            // res = detail_filled(data);
            $('#result_struk').html(res);
          }else{

            // res += detail_empty();
            // $('#result-tab-1').html(res);
          }
        }
      });
    })

    function process_invoice(info,detail){
      let HTML="";
      HTML +=`
      <div class="well well-sm">
      <h5 class="text-center">Struk Transaksi</h5>
      <div class="row">
          <div class="col-xs-12">
            <table class="table">
              <tbody><tr>
                <th>Tanggal</th>
                <td>: ${info.tanggal}</td>
                <th class="text-right">Kasir</th>
                <td>: ${info.kasir}</td>
              </tr>
              <tr>
                <th>No#</th>
                <td>: ${info.invoice}</td>
                <th class="text-right">Jam</th>
                <td>: ${info.jam}</td>
              </tr>
            </tbody></table>
          </div>
        </div>
      `
      HTML += `<div class="row">
          <div class="col-md-12">
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Kode Barang</th>
                  <th>Nama Barang</th>
                  <th class="text-center">Harga</th>
                  <th class="text-center">Qty</th>
                  <th class="text-center">Diskon</th>
                  <th class="text-center">Sub Total</th>
                </tr>
              </thead>
              <tbody>`;
              detail.forEach((d,i) => {
                HTML +=`              <tr>
                <td>${i+1}</td>
                <td>${d.kode_product}</td>
                <td>${d.name_product}</td>
                <td class="text-right">${number_format(d.price_sale)}</td>
                <td class="text-right">${d.qty}</td>
                <td class="text-right">${number_format(d.discount)}</td>
                <td class="text-right">${number_format(d.sub_total)}</td>
              </tr>`
              })
            HTML +=
           `</tbody>
              <tfoot>
                <tr>
                  <th class="text-right" colspan="6">T O T A L</th>
                  <td class="text-right">${number_format(info.total)}</td>
                </tr>
                <tr>
                  <th colspan="6" class="text-right">JUMLAH UANG</th>
                  <td class="text-right">${number_format(info.pay_money)}</td>
                </tr>
                <tr>
                  <th colspan="6" class="text-right">KEMBALI</th>
                  <td class="text-right">${number_format(info.refund)}</td>
                </tr>
                <tr>
                  <td colspan="7"><button type="button" data-invoice="${info.invoice}" id="btn_cetak_struct" class="btn btn-default btn-md"><i class="fa fa-print"></i> Cetak Struk</button></td>
                </tr>
              </tfoot>
            </table>
          </div>
        </div>
        </div>`
        return HTML;
    }

    $('form#penjualan_harian').submit(function(e){
      e.preventDefault();
      
      $('#btn-penjualan-harian').html('<i class="fa fa-spinner fa-spin"></i>');
      const data = $(this).serialize();
      let res = '';
      $.ajax({
        url: "<?php echo base_url() ?>report/sell_daily_by_customer",
        method: "POST",
        data: data,
        dataType: 'json',
        success: function(response) {
          
          if(response.success==true){
            const data = response.data;
            res = daily_filled(data);
            $('#result_tab_2').html(res);

          }else{
            // console.log('fail');
            // console.log(response);
            res += daily_empty();
            $('#result_tab_2').html(res);

          }
          setTimeout(()=>$('#btn-penjualan-harian').html('Tampil'),1000);
          
        }
      });

      function daily_empty(){
        return `
        <table class="table table-bordered">
        <thead>
          <tr>
            <th width="10px">No</th>
            <th>Tanggal</th>
            <th>Total Belanja</th>
            <th>Laba/Rugi</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td colspan="4">Data tidak ditemukan</td>
          </tr>
        </tbody>
      </table>
        `;
      }

      function daily_filled(data){
        let html = '';
        html += `
                  <table class="table table-hover table-bordered">
                    <thead>
                      <tr>
                        <th width="10px">No</th>
                        <th>Tanggal</th>
                        <th>Total Belanja</th>
                        <th>Laba/Rugi</th>
                      </tr>
                    </thead>
                    <tbody>`;
          let tot_sale = 0;
          let tot_laba = 0;
          data.forEach((s,i) => {
            tot_sale += parseInt(s.total);
            tot_laba += parseInt(s.untung);
            const tanggal = s.tanggal.split("-");
            html += `
                      <tr>
                        <td width="10px">${i+1}</td>
                        <td>${tanggal[2]}/${tanggal[1]}/${tanggal[0]}</td>
                        <td align="right">Rp. ${number_format(s.total)}</td>
                        <td align="right">Rp. ${number_format(s.untung)}</td>
                      </tr>
            `;
          });
          html += `
                  <tr>
                    <th class="text-right" colspan="2">T O T A L</th>
                    <td align="right">Rp. ${number_format(tot_sale)}</td>
                    <td align="right">Rp. ${number_format(tot_laba)}</td>
                  </tr>
          `
          html += `</tbody>
                  </table>`
        return html;        
      }
    });

    $('form#penjualan_bulanan').submit(function(e){
      e.preventDefault();
      const data = $(this).serialize();
      let res = '';
      $('#btn-penjualan-bulan').html('<i class="fa fa-spinner fa-spin"></i>');
      $.ajax({
        url: "<?php echo base_url() ?>report/sale_monthly_bycustomer",
        method: "POST",
        data: data,
        dataType: 'json',
        success: function(response) {
          if(response.success==true){
            const data = response.data;
            res = month_filled(data);
            $('#result_tab_3').html(res);

          }else{
            res += month_empty();
            $('#result_tab_3').html(res);
          }
          setTimeout(()=>$('#btn-penjualan-bulan').html('Tampil'),500);
         }
      });
    })

    function month_empty(){
      return `
        <table class="table table-bordered">
        <thead>
          <tr>
            <th width="10px">No</th>
            <th>Bulan</th>
            <th>Total Belanja</th>
            <th>Laba/Rugi</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td colspan="4">Data tidak ditemukan</td>
          </tr>
        </tbody>
      </table>
        `;      
    }

    function month_filled(data){
      let html = '';
        html += `
                  <table class="table table-hover table-bordered">
                    <thead>
                      <tr>
                        <th width="10px">No</th>
                        <th>Bulan</th>
                        <th>Total Belanja</th>
                        <th>Laba/Rugi</th>
                      </tr>
                    </thead>
                    <tbody>`;
          let tot_sale=0;
          let tot_laba=0;
          data.forEach((s,i) => {
            tot_sale += parseInt(s.total);
            tot_laba += parseInt(s.untung);
            html += `
                      <tr>
                        <td>${i+1}</td>
                        <td>${s.bulan}</td>
                        <td align="right">Rp. ${number_format(s.total)}</td>
                        <td align="right">Rp. ${number_format(s.untung)}</td>
                      </tr>
            `;
          });
          html += `
            <tr>
              <th class="text-right" colspan="2">T O T A L</th>
              <td align="right">Rp ${number_format(tot_sale)}</td>
              <td align="right">Rp ${number_format(tot_laba)}</td>
            </tr>
          `
          html += `</tbody>
                  </table>`
        return html;              
    }

    $('form#penjualan_tahunan').submit(function(e){
      e.preventDefault();
      const data = $(this).serialize();
      let res = '';
      $('#btn-penjualan-tahun').html('<i class="fa fa-spinner fa-spin"></i>')
      // console.log(data);
      $.ajax({
        url: "<?php echo base_url() ?>report/sale_yearly_bycustomer",
        method: "POST",
        data: data,
        dataType: 'json',
        success: function(response) {
          if(response.success==true){
            const data = response.data;
            res = year_filled(data);
            $('#result-tab-4').html(res);

          }else{
            res += year_empty();
            $('#result-tab-4').html(res);
          }
          setTimeout(()=>$('#btn-penjualan-tahun').html('Tampil'),500);
        }
      });
    })

    function year_empty(){
      return `
        <table class="table table-bordered">
        <thead>
          <tr>
            <th width="10px">No</th>
            <th>Tahun</th>
            <th>Total Belanja</th>
            <th>Laba/Rugi</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td colspan="4">Data tidak ditemukan</td>
          </tr>
        </tbody>
      </table>
        `;      
    }
    
    function year_filled(data){
      let html = '';
        html += `<table class="table table-hover table-bordered">
                    <thead>
                      <tr>
                        <th width="10px">No</th>
                        <th>Tahun</th>
                        <th>Total Belanja</th>
                        <th>Laba/Rugi</th>
                      </tr>
                    </thead>
                    <tbody>`;
          let tot_sale=0;
          let tot_laba=0;
          data.forEach((s,i) => {
            tot_sale += parseInt(s.total);
            tot_laba += parseInt(s.untung);
            html += `<tr>
                        <td>${i+1}</td>
                        <td>${s.tahun}</td>
                        <td align="right">Rp. ${number_format(s.total)}</td>
                        <td align="right">Rp. ${number_format(s.untung)}</td>
                      </tr>`;
          });
          html += `<tr>
                    <th colspan="2" class="text-right">T O T A L </th>
                    <td align="right">Rp. ${number_format(tot_sale)}</td>
                    <td align="right">Rp. ${number_format(tot_laba)}</td>
                  </tr>`
          html += `</tbody>
                  </table>`
        return html;              
    }

  })
</script>