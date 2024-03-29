<script>

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
                sProcessing: "loading...",
            },
            processing: true,
            serverSide: true,
            ajax: {
                "url": "<?= base_url('kasir/json') ?>",
                "type": "POST"
            },
            language: {
                "search": "_INPUT_",            // Removes the 'Search' field label
                "searchPlaceholder": "Search"   // Placeholder for the search box
            },
            search: {
                "addClass": 'form-control input-lg col-xs-12'
            },
            fnDrawCallback:function(){
                $("input[type='search']").attr("id", "searchBox");
                $('#dialPlanListTable').css('cssText', "margin-top: 0px !important;");
                $("select[name='dialPlanListTable_length'], #searchBox").removeClass("input-sm");
                $('#searchBox').css("width", "350px").focus();
                $('#dialPlanListTable_filter').removeClass('dataTables_filter');
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


    $(document).ready(function() {

        $('#tbl_cart').dataTable({
            fixedHeader : true,
            paging    : false,
            scrollY   :320,
            searching : false,
            order     : false,
        });

        $('.rupiah').priceFormat({
            prefix: '',
            centsLimit: 0,
            thousandsSeparator: '.'
        })
    
        $('#kodebarang').on('change', function() {
            var input_k = $('#kodebarang').val();
            $('#diskon_tmp').val('');
            $('#jumlah_tmp').val('');
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

                        if (msg.status == true) {

                            var produk_id = msg.data.kode_item;
                            var produk_nama = msg.data.nama;
                            var produk_satuan = msg.data.satuan;
                            var produk_harga = msg.data.harga;
                            var produk_harga_pokok = msg.data.harga_pokok;
                            var quantity = 1;
                            var diskon = 0;
                            $.ajax({
                                url: "<?php echo base_url() ?>kasir/insert_cart",
                                method: "POST",
                                data: {
                                    id_barang_tmp: produk_id,
                                    nmbrg_tmp: produk_nama,
                                    satuan_tmp: produk_satuan,
                                    harga_tmp: produk_harga,
                                    harpok : produk_harga_pokok,
                                    diskon_tmp: diskon,
                                    jumlah_tmp: quantity
                                },
                                success: function(data) {
                                    $('#kodebarang').val('');
                                    $('#detail_cart').html(data);
                                    // $('#tbl_cart').DataTable().ajax.reload();
                                    let a = $('#jumlahtotal').val();
                                    $('.pembayaran_total').val(a);
                                    $('#hargatotalbesar').text(a);
                                    $('#formtemp').hide();
                                    $('#pembayaran_uang_bayar').val(0);
                                    $('#form_kembali').removeClass('has-success');
                                    $('#pembayaran_uang_kembali').val(0);
                                    if(a==0){
                                        $('#btn-bayar').attr('disabled');
                                    }else{
                                        $('#btn-bayar').removeAttr('disabled');
                                    }
                                    $('#kodebarang').focus();
                                }
                            });
                        } else {
                            console.log('gagal')
                            $('#formtemp').hide();
                        }
                    }
                });
            } else {
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
            var produk_satuan = $('#satuan_tmp').val();
            var produk_harga = $('#harga_tmp').val();
            var produk_harga_pokok = $('#harga_pokok_tmp').val();
            var quantity = $('#jumlah_tmp').val();
            var diskon = $('#diskon_tmp').val();
            $.ajax({
                url: "<?php echo base_url() ?>kasir/insert_cart",
                method: "POST",
                data: {
                    id_barang_tmp: produk_id,
                    nmbrg_tmp: produk_nama,
                    satuan_tmp: produk_satuan,
                    harga_tmp: produk_harga,
                    harpok : produk_harga_pokok,
                    diskon_tmp: diskon,
                    jumlah_tmp: quantity
                },
                success: function(data) {
                    $('#kodebarang').val('');
                    $('#detail_cart').html(data);
                    let a = $('#jumlahtotal').val();
                    $('.pembayaran_total').val(a);
                    $('#hargatotalbesar').text(a);
                    $('#formtemp').hide();
                    $('#pembayaran_uang_bayar').val(0);
                    $('#form_kembali').removeClass('has-success');
                    $('#pembayaran_uang_kembali').val(0);
                    if(a==0){
                        $('#btn-bayar').attr('disabled');
                    }else{
                        $('#btn-bayar').removeAttr('disabled');
                    }
                    $('#kodebarang').focus();
                }
            });
        });

        // Load shopping cart
        // $('#detail_cart').load("<?php echo base_url(); ?>index.php/cart/load_cart");

        //Hapus Item Cart
        $(document).on('click', '.hapus_cart', function() {
            var row_id = $(this).data('id');
            $.ajax({
                url: "<?php echo base_url(); ?>kasir/hapus_cart",
                method: "POST",
                data: {
                    row_id: row_id
                },
                success: function(data) {
                    $('#kodebarang').focus();  
                    $('#detail_cart').html(data);
                    let a = $('#jumlahtotal').val();
                    $('.pembayaran_total').val(a);
                    $('#hargatotalbesar').text(a);
                    $('#pembayaran_uang_bayar').val(0);
                    $('#form_kembali').removeClass('has-success');
                    $('#pembayaran_uang_kembali').val(0);
                    if(a==0){
                        $('#btn-bayar').attr('disabled');
                    }else{
                        $('#btn-bayar').removeAttr('disabled');
                    }
                    $('.rupiah').priceFormat({
                        prefix: '',
                        centsLimit: 0,
                        thousandsSeparator: '.'
                    })
                }
            });
            
        });

        // ENTER CUSTOME QTY
        // $(document).on('keypress', '.qty-input', function(e) {
        //     if(e.which == 13){
        //         const rowid = $(this).data('rowid');
        //         const qty = $(this).val();
        //         $.ajax({
        //             url: "<?php echo base_url(); ?>kasir/custom_qty",
        //             method: "POST",
        //             data: {
        //                 rowid: rowid,
        //                 qty: qty
        //             },
        //             success: function(data) {
        //                 $('#detail_cart').html(data);
        //                 let a = $('#jumlahtotal').val();
        //                 $('#pembayaran_total').val(a);
        //                 $('#hargatotalbesar').text(a);
        //                 $('#pembayaran_uang_bayar').val(0);
        //                 $('#form_kembali').removeClass('has-success');
        //                 $('#pembayaran_uang_kembali').val(0);
        //                 if(a==0){
        //                     $('#btn-bayar').attr('disabled');
        //                 }else{
        //                     $('#btn-bayar').removeAttr('disabled');
        //                 }
        //                 $('#kodebarang').focus();                    
        //             }
        //         });
        //     }
        // });

        $(document).on('click', '.btn_tambah', function() {
            let rowid = $(this).data('rowid');
            $.ajax({
                url: "<?php echo base_url(); ?>kasir/tambah_qty",
                method: "POST",
                data: {
                    rowid: rowid
                },
                success: function(data) {
                    $('#detail_cart').html(data);
                    let a = $('#jumlahtotal').val();
                    $('.pembayaran_total').val(a);
                    $('#hargatotalbesar').text(a);
                    $('#pembayaran_uang_bayar').val(0);
                    $('#form_kembali').removeClass('has-success');
                    $('#pembayaran_uang_kembali').val(0);
                    if(a==0){
                        $('#btn-bayar').attr('disabled');
                    }else{
                        $('#btn-bayar').removeAttr('disabled');
                    }                    
                }
            });
        });

        $(document).on('click', '.btn_kurang', function() {
            let rowid = $(this).data('rowid');
            $.ajax({
                url: "<?php echo base_url(); ?>kasir/kurang_qty",
                method: "POST",
                data: {
                    rowid: rowid
                },
                success: function(data) {
                    $('#detail_cart').html(data);
                    let a = $('#jumlahtotal').val();
                    $('.pembayaran_total').val(a);
                    $('#hargatotalbesar').text(a);
                    $('#pembayaran_uang_bayar').val(0);
                    $('#form_kembali').removeClass('has-success');
                    $('#pembayaran_uang_kembali').val(0);
                    if(a==0){
                        $('#btn-bayar').attr('disabled');
                    }else{
                        $('#btn-bayar').removeAttr('disabled');
                    }                    
                }
            });
        });

        $(document).on('submit', '#detail_cart .form_cart', function(e) {
            e.preventDefault();
            const data = $(this).serialize();
            
            $.ajax({
                url: "<?php echo base_url(); ?>kasir/update_cart",
                method: "POST",
                data: data,
                success: function(data) {
                    $('#editproduk').modal('hide');
                    $('#detail_cart').html(data);
                    let a = $('#jumlahtotal').val();
                    $('.pembayaran_total').val(a);
                    $('#hargatotalbesar').text(a);

                    $('#pembayaran_uang_bayar').val(0);
                    $('#form_kembali').removeClass('has-success');
                    $('#pembayaran_uang_kembali').val(0);
                    if(a==0){
                        $('#btn-bayar').attr('disabled');
                    }else{
                        $('#btn-bayar').removeAttr('disabled');
                    }
                    $('#kodebarang').focus();
                    $('.rupiah').priceFormat({
                        prefix: '',
                        centsLimit: 0,
                        thousandsSeparator: '.'
                    })                    
                }
            });
        })

        $(document).on('click', '.cb_cart', function() {
            const v = $(this).val();
            const id = $(this).data('id');
            if($(this).is(':checked')){
                $('#detail_cart #inputjual-'+id).removeAttr('readonly');
                $('#detail_cart #custom-'+id).val('on');
            }else{
                $('#detail_cart #inputjual-'+id).attr('readonly',true);
                $('#detail_cart #custom-'+id).val('off');

                const data = $('#form_cart-'+id).serialize();
                
                // console.log(data);
                $.ajax({
                    url: "<?php echo base_url(); ?>kasir/update_cart",
                    method: "POST",
                    data: data,
                    success: function(data) {
                        $('#editproduk').modal('hide');
                        $('#detail_cart').html(data);
                        let a = $('#jumlahtotal').val();
                        $('.pembayaran_total').val(a);
                        $('#hargatotalbesar').text(a);

                        $('#pembayaran_uang_bayar').val(0);
                        $('#form_kembali').removeClass('has-success');
                        $('#pembayaran_uang_kembali').val(0);
                        if(a==0){
                            $('#btn-bayar').attr('disabled');
                        }else{
                            $('#btn-bayar').removeAttr('disabled');
                        }
                        $('#kodebarang').focus();
                        $('.rupiah').priceFormat({
                            prefix: '',
                            centsLimit: 0,
                            thousandsSeparator: '.'
                        })                    
                    }
                });

            }
        })

        $(document).on('change', '.input-price_sale', function() {
            let val = $(this).val();
            const id = $(this).data('id');
            $('#detail_cart #price_sale-'+id).val(val);
        })

        $(document).on('keypress', '.input-price_sale', function(e) {
            const id = $(this).data('id');
            if(e.which == 13){                
                $('#detail_cart #inputqty-'+id).focus();
            }
        })

        $(document).on('keypress', '.input-discount', function(e) {
            const id = $(this).data('id');
            if(e.which == 13){                
                $('#detail_cart #inputqty-'+id).focus();
            }
        })

        $(document).on('change', '.input-price_sale', function() {
            let val = $(this).val();
            const id = $(this).data('id');
            $('#detail_cart #price_sale-'+id).val(val);
        })

        $(document).on('change', '.input-discount', function() {
            let val = $(this).val();
            const id = $(this).data('id');
            $('#detail_cart #disc-'+id).val(val);
        })

        $(document).on('click', '#btn_proses_ubah_cart', function() {
            let rowid = $('#rowid').val();
            let hrgjual = $('#hrgjual').val();
            let qty = $('#qtycart').val();
            let disc = $('#disc').val();

            $.ajax({
                url: "<?php echo base_url(); ?>kasir/ubahcart",
                method: "POST",
                data: {
                    rowid: rowid,
                    hrgjual : hrgjual,
                    qty : qty,
                    disc : disc
                },
                success: function(data) {
                    $('#editcart').modal('hide');
                    $('#detail_cart').html(data);
                    let a = $('#jumlahtotal').val();
                    $('.pembayaran_total').val(a);
                    $('#hargatotalbesar').text(a);

                    $('#pembayaran_uang_bayar').val(0);
                    $('#form_kembali').removeClass('has-success');
                    $('#pembayaran_uang_kembali').val(0);
                    if(a==0){
                        $('#btn-bayar').attr('disabled');
                    }else{
                        $('#btn-bayar').removeAttr('disabled');
                    }
                    $('#kodebarang').focus();                    
                }
            });
        })

        $(document).on('click', '#btn_proses_ubah_produk', function() {
            
            const data = $('#form_edit_produk').serialize();

            // console.log(data);
            $.ajax({
                url: "<?php echo base_url(); ?>kasir/updateharga",
                method: "POST",
                data: data,
                success: function(data) {
                    $('#editproduk').modal('hide');
                    $('#detail_cart').html(data);
                    let a = $('#jumlahtotal').val();
                    $('.pembayaran_total').val(a);
                    $('#hargatotalbesar').text(a);

                    $('#pembayaran_uang_bayar').val(0);
                    $('#form_kembali').removeClass('has-success');
                    $('#pembayaran_uang_kembali').val(0);
                    if(a==0){
                        $('#btn-bayar').attr('disabled');
                    }else{
                        $('#btn-bayar').removeAttr('disabled');
                    }
                    $('#kodebarang').focus();
                    $('.rupiah').priceFormat({
                        prefix: '',
                        centsLimit: 0,
                        thousandsSeparator: '.'
                    })
                    $.toast({
                        text: 'Produk berhasil diubah', // Text that is to be shown in the toast
                        heading: 'Sukses', // Optional heading to be shown on the toast
                        icon: 'success', // Type of toast icon
                        showHideTransition: 'fade', // fade, slide or plain
                        allowToastClose: true, // Boolean value true or false
                        hideAfter: 3000, // false to make it sticky or number representing the miliseconds as time after which toast needs to be hidden
                        stack: 5, // false if there should be only one toast at a time or a number representing the maximum number of toasts to be shown at a time
                        position: 'bottom-right', // bottom-left or bottom-right or bottom-center or top-left or top-right or top-center or mid-center or an object representing the left, right, top, bottom values

                        loader: false,
                        textAlign: 'left', // Text alignment i.e. left, right or center
                    });
                }
            });
        })

        $(document).on('click', '.edit_cart', function() {

            let row_id = $(this).attr("id"); //mengambil row_id dari artibut id
            let idbarang = $(this).data('idbarang');
            let nmbarang = $(this).data('nmbarang');
            let hrgjual = $(this).data('hrgjual');
            let hrgpokok = $(this).data('hrgpokok');
            let disc = $(this).data('disc');
            let qty = $(this).data('qty');

            $('#rowid').val(row_id);
            $('#idbarang').val(idbarang);
            $('#nmbarang').val(nmbarang);
            $('#hrgpokok').val(hrgpokok);
            $('#hrgjual').val(hrgjual);
            $('#qtycart').val(qty);
            $('#disc').val(disc);
            $('.rupiahjs').priceFormat({
                prefix: '',
                centsLimit: 0,
                thousandsSeparator: '.'
            })

            $('#editcart').modal({
                backdrop : 'static',
                keyboard : false
            });
        });

        $(document).on('click', '.editproduk', function() {

            const id    = $(this).data('id'); //mengambil row_id dari artibut id
            const rowid = $(this).data('rowid'); 
            $.ajax({
                url: "<?php echo base_url(); ?>kasir/getitem",
                method: "POST",
                data: {
                    kode_brg: id
                },
                dataType: "json",
                success: function(data) {

                    $('#editproduk [name="rowid"]').val(rowid)
                    $('#editproduk [name="idbarang"]').val(data.data.kode_item)
                    $('#editproduk [name="nmbarang"]').val(data.data.nama)
                    $('#editproduk [name="hrgpokok"]').val(data.data.harga_pokok)
                    $('#editproduk [name="hrgjual"]').val(data.data.harga)
                    $('#editproduk [name="hrgjual3"]').val(data.data.harga3)
                    $('#editproduk [name="hrgjual5"]').val(data.data.harga5)
                    $('#editproduk [name="hrgjual10"]').val(data.data.harga10)
                    $('.rupiahjs').priceFormat({
                        prefix: '',
                        centsLimit: 0,
                        thousandsSeparator: '.'
                    })
                }
            });
            $('#editproduk').modal({
                backdrop : 'static',
                keyboard : false
            });
        });

        $('#pembayaran_uang_bayar').priceFormat({
            prefix: '',
            centsLimit: 0,
            thousandsSeparator: '.'
        });


        $('#pembayaran_uang_bayar').on('keyup focus', function(){
            var b = $('.pembayaran_total').val();
            var a = $(this).val();
            const bayar = a.replace(/\./g,'');
            const total = b.replace(/\./g,'');
            const uang_bayar = parseInt(bayar);
            const total_harga = parseInt(total);
            if(uang_bayar>=total_harga){
                const kembali = uang_bayar-total_harga;
                $('#form_kembali').addClass('has-success');
                $('#pembayaran_uang_kembali').val(kembali);
                $('#btn-print-save').removeAttr('disabled');
                $('#btn-just-save').removeAttr('disabled');
                $('#pembayaran_uang_kembali').priceFormat({
                    prefix: '',
                    centsLimit: 0,
                    thousandsSeparator: '.'
                });
            }else{
                $('#form_kembali').removeClass('has-success');
                $('#pembayaran_uang_kembali').val(0);
                $('#btn-print-save').attr('disabled',true);
                $('#btn-just-save').attr('disabled',true);
                $('#pembayaran_uang_kembali').priceFormat({
                    prefix: '',
                    centsLimit: 0,
                    thousandsSeparator: '.'
                });
            }
        });

        $('#pembayaran_uang_muka').on('keyup focus', function(){
            // alert('okok');
            var b = $('.pembayaran_total').val();
            var a = $(this).val();
            const bayar = a.replace(/\./g,'');
            const total = b.replace(/\./g,'');
            const uang_muka = parseInt(bayar);
            const total_harga = parseInt(total);
            if(uang_muka<=total_harga){
                const sisa_tagihan = total_harga-uang_muka;
                $('#pembayaran_sisa_tagihan').val(sisa_tagihan);
                $('.btn_print_save_hutang').removeAttr('disabled');
                $('.btn_only_save_hutang').removeAttr('disabled');
                $('#pembayaran_sisa_tagihan').priceFormat({
                    prefix: '',
                    centsLimit: 0,
                    thousandsSeparator: '.'
                });
            }else{
                $('#pembayaran_sisa_tagihan').val(total_harga);
                $('.btn_print_save_hutang').attr('disabled',true);
                $('.btn_only_save_hutang').attr('disabled',true);
                $('#pembayaran_sisa_tagihan').priceFormat({
                    prefix: '',
                    centsLimit: 0,
                    thousandsSeparator: '.'
                });
            }

        });

        $('#hargatotalbesar').priceFormat({
            prefix: '',
            centsLimit: 0,
            thousandsSeparator: '.'
        })

        

        $('.dataTables_filter input[type="search"]').css(
            {'width':'500px','display':'inline-block'}
        );

     

        $('#prosesmodal').on('shown.bs.modal', function () {
            $("#prosesmodal #pembayaran_uang_bayar").focus();
        })

        $('#addproduk').on('shown.bs.modal', function () {
            $("#addproduk #addproduk_idbarang").focus()
        })
    

        $('#itemModal').on('shown.bs.modal', function () {
            $('#databarang').DataTable().search('').columns().search('').draw();
            $("#searchBox").focus();
        })

        $('#itemModal').on('hidden.bs.modal', function () {

            // $('#kodebarang').blur();
            $('#kodebarang').focus();

        })

        // $('.select2').select2({
            
        // });
        
        $('.select_customer_modal').select2({
            "dropdownParent" : $('#prosesmodal'),
            "language" : {
                "noResults": function(){
                    let text = event.target.value;
                    return `<a id="modal_add_customer" data-text="${text}">+ ${text} (Tambah)</a>`
                }
            },
            "escapeMarkup":function(markup){
                return markup;
            }            
        });

        $(document).on("click","#modal_add_customer",function(){

            $.ajax({
                url: "<?php echo base_url() ?>customer/get_number_customer",
                method: "get",
                success: function(response) {
                    $('#modal_add_customer_2 #id_customer').val(response);
                }
            });

            $('#credit_customer').select2('close');
            const text = $(this).data('text');
            $('#modal_add_customer_2 #name_customer').val(text);
            $('#modal_add_customer_2').modal('show');

        })

        $('#btn-print-save').on('click',function(){
            $(this).html('<i class="fa fa-spinner fa-spin fa-lg"></i> Simpan & Cetak');
        })

        $('.btn_print_save_hutang').on('click',function(){
            $(this).html('<i class="fa fa-spinner fa-spin fa-lg"></i> Simpan & Cetak');
        })

        $('#btn-just-save').on('click',function(){
            $(this).html('<i class="fa fa-spinner fa-spin fa-lg"></i> Simpan saja');
        })
        
        $('#btn_close_modal_edit_product').click(function(){
            $('#editproduk').modal('hide');
            $('#kodebarang').focus();
        })
        
        $('#btn_close_edit_cart').click(function(){
            $('#editcart').modal('hide');
            $('#kodebarang').focus();
        })
        $('#btn_close_modal_add_product').click(function(){
            // $("#addproduk #addproduk_idbarang").blur()
            $('#addproduk').modal('hide');
            $('#kodebarang').focus();
            // $('#kodebarang').trigger('focus');
        })
        $('.btn_close_modal_proses_bayar').click(function(){
            $('#prosesmodal').modal('hide');
            $('#kodebarang').focus();
        })
        

        $( "#kodebarang" ).autocomplete({
                source: "<?php echo site_url('kasir/get_autocomplete');?>",
                // response : function(event,ui){
                //     if(!ui.content.length){
                //         let t = $('#kodebarang').val()
                //         var noresult = { value:"",label:"+ Tambahkan "+t,name:t};
                //         ui.content.push(noresult)
                //     }
                // },
                // "escapeMarkup":function(markup){
                //     return markup;
                // },
                // messages:{
                //     noResults : function(){
                //         let text = event.target.value;
                //         alert(text)
                //     }               
                // },
                select: function (event, ui) {
                    var produk_id = ui.item.value;
                    var produk_nama = ui.item.name;
                    var produk_satuan = ui.item.unit;
                    var produk_harga = ui.item.price_sale;
                    var produk_harga_pokok = ui.item.price;
                    var quantity = 1;
                    var diskon = 0;
                    
                    $.ajax({
                        url: "<?php echo base_url() ?>kasir/insert_cart",
                        method: "POST",
                        data: {
                            id_barang_tmp: produk_id,
                            nmbrg_tmp: produk_nama,
                            satuan_tmp: produk_satuan,
                            harga_tmp: produk_harga,
                            harpok : produk_harga_pokok,
                            diskon_tmp: diskon,
                            jumlah_tmp: quantity
                        },
                        success: function(data) {
                            // console.log(data);
                            $('#kodebarang').val('');
                            $('#detail_cart').html(data);
                            // $('#tbl_cart').DataTable().ajax.reload();
                            let a = $('#jumlahtotal').val();
                            $('.pembayaran_total').val(a);
                            $('#hargatotalbesar').text(a);
                            $('#formtemp').hide();
                            $('#pembayaran_uang_bayar').val(0);
                            $('#form_kembali').removeClass('has-success');
                            $('#pembayaran_uang_kembali').val(0);
                            if(a==0){
                                $('#btn-bayar').attr('disabled');
                            }else{
                                $('#btn-bayar').removeAttr('disabled');
                            }
                            $('#kodebarang').focus();
                            $('.rupiah').priceFormat({
                                prefix: '',
                                centsLimit: 0,
                                thousandsSeparator: '.'
                            })
                        }
                    });
                }
        });
        
       $(document).tooltip({
            items:".name_product",
            content: function(callback){
                const kode = $(this).data('kode');
                $.get('<?= base_url('kasir/get_tooltip_price') ?>', {
                    id:kode
                }, function(data) {
                    callback(data);
                }); 
                // return "Harga Normal: 10.000</br>Harga min 3: 12.000";
            }
       });

       $('#btn_show_modal_add_produk').click(function(){
           $('#addproduk').modal({
                backdrop : 'static',
                keyboard : false
           })
       })
       $('#btn_modal_proses').click(function(){
           $('#prosesmodal').modal({
                backdrop : 'static',
                keyboard : false
           })
       })

       $('#btn_generate_kb').on('click', function() {
            var a = <?= date('ymd') ?>;
            $.ajax({
                url: "<?php echo base_url() ?>product/generate_kode",
                method: "POST",
                type: 'text',
                data: {
                    prefix: a,
                },
                success: function(data) {
                    $('#addproduk #addproduk_idbarang').val(data);
                }
            });
        });

        $('#form_add_produk').submit(function(e){
            e.preventDefault();
            
            $.ajax({
                url: "<?php echo base_url('kasir/insert_produk') ?>",
                method: "POST",
                dataType: "json",
                data: $(this).serialize(),
                success: function(data) {
                    if(data.status){
                        $.toast({
                            text: data.message, // Text that is to be shown in the toast
                            heading: 'Sukses', // Optional heading to be shown on the toast
                            icon: 'success', // Type of toast icon
                            showHideTransition: 'fade', // fade, slide or plain
                            allowToastClose: true, // Boolean value true or false
                            hideAfter: 3000, // false to make it sticky or number representing the miliseconds as time after which toast needs to be hidden
                            position: 'bottom-right', // bottom-left or bottom-right or bottom-center or top-left or top-right or top-center or mid-center or an object representing the left, right, top, bottom values

                            loader: false,
                        });
                        $('#addproduk').modal('hide');
                        $('#form_add_produk')[0].reset();
                        $('#form_add_produk #message_exist').html('');
                        $('#kodebarang').focus();
                    }else{
                        $('#form_add_produk #message_exist').html(data.message);
                    }
                }
            });
        })

        $('.select_category').select2({
            "selectOnClose": true,
            "dropdownParent" : $('#addproduk'),
            "language" : {
                "noResults": function(){
                let text = event.target.value;
                return `<a id="md_category" data-text="${text}"> +Tambahkan ${text}</a>`
                }
            },
            "escapeMarkup":function(markup){
                return markup;
            }
        });

        $(document).on('click','#md_category',function(){
            $('.select_category').select2('close');
            const text = $(this).data('text');
            $('#md_add_category #name').val(text);
            $('#md_add_category').modal('show');
            $('#md_add_category input#name').focus();
            // $('.select_category').prop('disabled',false);
        })

        $('form#quick_add_category').submit(function(e){
            e.preventDefault();
            
            $.ajax({
                url: "<?php echo base_url() ?>category/quickAddCategory",
                method: "POST",
                dataType: "json",
                data: $(this).serialize(),
                success: function(response) {
                    const data = {
                        id: response.id,
                        text: response.name
                    }
                    const newOption = new Option(data.text,data.id,true,true);
                    $('.select_category').append(newOption).trigger('change');
                    $('#md_add_category').modal('hide');
                }
            });
        });

        $('#tab_hutang').click(function(){
            // $('.form_pelanggan').removeAttr('hidden');
            // $('.form_pelanggan select').attr('required',true);
            // $('#prosesmodal #tab_2 #pembayaran_uang_muka').focus();
        })
        $('#tab_lunas').click(function(){
            // $('.form_pelanggan').attr('hidden',true);
            // $('.form_pelanggan select').removeAttr('required');
            // $('#prosesmodal #tab_2 #pembayaran_uang_bayar').val(0);
        })

        function html_cash()
        {
            return `
            <div class="form-group">
                    <label for="inputEmail3" class="col-sm-4 control-label">Uang Bayar</label>
                    <div class="col-sm-8">
                      <div class="input-group input-group-lg">
                        <div class="input-group-addon">Rp</div>
                        <input type="text" name="uangbayar" onclick="this.select()" autocomplete="off" class="form-control" id="pembayaran_uang_bayar" placeholder="0">
                      </div>
                    </div>
                  </div>
                  <div class="form-group" id="form_kembali">
                    <label for="inputEmail3" class="col-sm-4 control-label">Uang Kembali </label>
                    <div class="col-sm-8">
                      <div class="input-group input-group-lg">
                        <div class="input-group-addon">Rp</div>
                        <input type="text" readonly class="form-control" id="pembayaran_uang_kembali" name="uangkembali">
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="col-md-4"></div>
                    <div class="col-md-8">
                      <button disabled type=submit name="print_save" class="btn btn-success" id="btn-print-save"><i class="fa fa-print"></i> Simpan & Cetak</button>
                      <button disabled type="submit" name="just_save" class="btn btn-info" id="btn-just-save"><i class="fa fa-save"></i> Simpan saja</button>
                      <button class="btn btn_close_modal_proses_bayar" type="button">Tutup</button>
                    </div>
                  </div>
            `
        }

        function html_hutang()
        {
            return `
                <div class="form-group form_pelanggan">
                    <label for="inputEmail3" class="col-sm-4 control-label">Pelanggan</label>
                    <div class="col-sm-8">
                      <div class="input-group">
                        <div class="input-group-addon"><i class="fa fa-user-circle"></i></div>
                        <select name="customer" style="width:100%" class="form-control select_customer_modal">
                          <option value="">Pilih</option>
                          <?php foreach ($customers as $c) : ?>
                            <option value="<?= $c->id_customer ?>"><?= $c->name_customer ?></option>
                          <?php endforeach ?>
                        </select>
                        <input type="hidden" name="credit" value="true">
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputEmail3" class="col-sm-4 control-label">Uang Muka</label>
                    <div class="col-sm-8">
                      <div class="input-group input-group-lg">
                        <div class="input-group-addon">Rp</div>
                        <input type="text" name="uangmuka" value="0" onclick="this.select()" autocomplete="off" class="form-control rupiah" id="pembayaran_uang_muka" placeholder="0">
                      </div>
                    </div>
                  </div>
                  <div class="form-group" id="form_kembali">
                    <label for="inputEmail3" class="col-sm-4 control-label">Sisa Tagihan </label>
                    <div class="col-sm-8">
                      <div class="input-group input-group-lg">
                        <div class="input-group-addon">Rp</div>
                        <input type="text" readonly class="form-control" id="pembayaran_sisa_tagihan" name="sisa_tagihan">
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="col-md-4"></div>
                    <div class="col-md-8">
                      <button type=submit name="print_save" class="btn btn-success btn_print_save_hutang"><i class="fa fa-print"></i> Simpan & Cetak</button>
                      <button type="submit" name="just_save" class="btn btn-info btn_only_save_hutang"><i class="fa fa-save"></i> Simpan saja</button>
                      <button class="btn btn_close_modal_proses_bayar" type="button">Tutup</button>
                    </div>
                  </div>
            `
        }

        $('#tab_lunas').on('shown.bs.tab',function(){
            const view_cash = html_cash();
            $('#pembayaran_uang_bayar').focus();
            $('#form_credit').val("");
            // console.log(view_cash);
            // $('#prosesmodal #tab_1').html(``);
        })
        $('#tab_hutang').on('shown.bs.tab',function(){
            const view = html_hutang();
            $('#form_credit').val("true");
            $('#credit_customer').select2('open');
            // console.log(view);
            // $('#prosesmodal #tab_1').html(``);
        })                

        $('#credit_customer').on('select2:select', function(e) {
            var data = e.params.data;
            $('#pembayaran_uang_muka').focus();
        })

        $('#form_customer').submit(function(e){
            e.preventDefault();
            const data = $(this).serialize();

            $.ajax({
                url: "<?php echo base_url() ?>customer/quickAddCustomer",
                method: "POST",
                dataType: "json",
                data: $(this).serialize(),
                success: function(response) {
                    const data = {
                        id: response.id,
                        text: response.name
                    }
                    const newOption = new Option(data.text,data.id,true,true);
                    $('.select_customer_modal').append(newOption).trigger('change');
                    $('#modal_add_customer_2').modal('hide');
                    // $('#md_add_category').modal('hide');
                }
            });
        });

        $('#btn_add_customer').click(function(){
            $.ajax({
                url: "<?php echo base_url() ?>customer/get_number_customer",
                method: "get",
                success: function(response) {
                    $('#modal_add_customer_2 #id_customer').val(response);
                }
            });

            $('#credit_customer').select2('close');
            $('#modal_add_customer_2').modal('show');
        });

    });

</script>