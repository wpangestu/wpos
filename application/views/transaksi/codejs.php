<script>
  $(document).ready(function() {

    $('#tglbeli').datepicker({
      format: 'dd/mm/yyyy',
      autoclose: true,
      language: 'id',
      todayHighlight: true,
      enableOnReadonly: true,
    })

    $('.datepicker').datepicker({
      format: 'dd/mm/yyyy',
      autoclose: true,
      language: 'id',
      todayHighlight: true,
      enableOnReadonly: true,
    })

    $('#kodebarang').on('change blur', function() {
      var input_k = $('#kodebarang').val();
      $('#qty_tmp').val('');
      if (input_k !== "") {

        var kobar = {
          kode_brg: input_k
        };

        $.ajax({
          type: "POST",
          url: "<?php echo base_url() . 'kasir/getitem'; ?>",
          data: kobar,
          dataType: "json",

          success: function(msg) {
            console.log(msg);

            if (msg.status == true) {

              $('#formtemp').show();

              $('#id_barang_tmp').val(msg.data.kode_item);
              $('#nmbrg_tmp').val(msg.data.nama);
              $('#harjul_tmp').val(msg.data.harga);
              $('#harjul3_tmp').val(msg.data.harga3);
              $('#harjul5_tmp').val(msg.data.harga5);
              $('#harjul10_tmp').val(msg.data.harga10);
              $('#harpok_tmp').val(msg.data.harga_pokok);
              $('#qty_tmp').val(1);
              $('#harpok_tmp').focus();

              $('.rupiah').priceFormat({
                  prefix: '',
                  centsLimit: 0,
                  thousandsSeparator: '.'
              });
            } else {
              console.log('false 1');
              $('#formtemp').hide();
            }
          }
        });
      } else {
        console.log('false 2');
        $('#formtemp').hide();
      }
    });


    $('#databarang').on('click', '.pilihbarang', function() {
      let kode = $(this).data('id');

      $('#kodebarang').val(kode);

      $('#itemModal').modal('hide');
      $('#kodebarang').focus();
    });

    $('#btn_add_to_cart').click(function() {
      var produk_id = $('#id_barang_tmp').val();
      var produk_nama = $('#nmbrg_tmp').val();
      var produk_harga_jual = $('#harjul_tmp').val();
      var produk_harga_jual3 = $('#harjul3_tmp').val();
      var produk_harga_jual5 = $('#harjul5_tmp').val();
      var produk_harga_jual10 = $('#harjul10_tmp').val();
      var produk_harga_pokok = $('#harpok_tmp').val();
      var quantity = $('#qty_tmp').val();

      $.ajax({
        url: "<?php echo base_url() ?>transaction/insert_cart",
        method: "POST",
        data: {
          id_barang_tmp: produk_id,
          nmbrg_tmp: produk_nama,
          harga_jual_tmp: produk_harga_jual,
          harga_jual3_tmp: produk_harga_jual3,
          harga_jual5_tmp: produk_harga_jual5,
          harga_jual10_tmp: produk_harga_jual10,
          harga_pokok_tmp: produk_harga_pokok,
          qty_tmp: quantity
        },

        success: function(data) {
          $('#kodebarang').val('');
          $('#detail_cart').html(data);
          let a = $('#totalharga').val();
          // $('#pembayaran_total').val(a);
          $('#total').text(a);
          $('#formtemp').hide();
          // $('#pembayaran_uang_bayar').val(0);
          // $('#form_kembali').removeClass('has-success');
          // $('#pembayaran_uang_kembali').val(0);
          // if (a == 0) {
          //   $('#btn-bayar').attr('disabled');
          // } else {
          //   $('#btn-bayar').removeAttr('disabled');
          // }
        }
      });
    });

    $(document).on('click', '.hapus_cart', function() {
      var row_id = $(this).attr("id"); //mengambil row_id dari artibut id
      $.ajax({
        url: "<?php echo base_url(); ?>transaction/hapus_cart",
        method: "POST",
        data: {
          row_id: row_id
        },
        success: function(data) {
          $('#detail_cart').html(data);
          let total = $('#totalharga').val();
          // $('#pembayaran_total').val(a);
          $('#total').text(total);
          // $('#pembayaran_uang_bayar').val(0);
          // $('#form_kembali').removeClass('has-success');
          // $('#pembayaran_uang_kembali').val(0);
          // if (a == 0) {
          //   $('#btn-bayar').attr('disabled');
          // } else {
          //   $('#btn-bayar').removeAttr('disabled');
          // }
        }
      });
    });

    $.fn.dataTableExt.oApi.fnPagingInfo = function(oSettings) {
      return {
        "iStart": oSettings._iDisplayStart,
        "iEnd": oSettings.fnDisplayEnd(),
        "iLength": oSettings._iDisplayLength,
        "iTotal": oSettings.fnRecordsTotal(),
        "iFilteredTotal": oSettings.fnRecordsDisplay(),
        "iPage": Math.ceil(oSettings._iDisplayStart / oSettings._iDisplayLength),
        "iTotalPages": Math.ceil(oSettings.fnRecordsDisplay() / oSettings._iDisplayLength)
      };
    };

    var t = $("#databarang").dataTable({
      initComplete: function() {
        var api = this.api();
        $('#mytable_filter input')
          .off('.DT')
          .on('keyup.DT', function() {
            api.search(this.value).draw();
          });
      },
      responsive: true,
      oLanguage: {
        sProcessing: "loading..."
      },
      processing: true,
      serverSide: true,
      ajax: {
        "url": "<?= base_url('kasir/json') ?>",
        "type": "POST"
      },
      columns: [{
          "data": "id_product",
          "orderable": false
        },
        {
          "data": "id_product",
        },
        {
          "data": "name_product"
        },
        {
          "data": "stock"
        },
        {
          "data": "price",
          "className": "text-right",
          render: $.fn.dataTable.render.number('.', ',', ''),
        },
        {
          "data": "price_sale",
          render: $.fn.dataTable.render.number('.', ',', ''),
          "className": "text-right",
        },
        {
          "data": "create_at"
        },
        {
          "data": "action",
          "orderable": false,
          "className": "text-center"
        }
      ],
      order: [
        [6, 'desc']
      ],
      rowCallback: function(row, data, iDisplayIndex) {
        var info = this.fnPagingInfo();
        var page = info.iPage;
        var length = info.iLength;
        var index = page * length + (iDisplayIndex + 1);
        $('td:eq(0)', row).html(index);
      }
    });
  })
</script>