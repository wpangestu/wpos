<script type="text/javascript">
    $(document).ready(function() {

        $('.select2category').select2({
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
            const text = $(this).data('text');
            $('#md-add-category #name').val(text);
            $('#md-add-category').modal('show');
            $('#md-add-category input#name').focus();
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
                    $('#form_add_product .select2category').append(newOption).trigger('change');
                    $('#md-add-category').modal('hide');
                }
            });
        });

        $('body').tooltip({selector: '[data-toggle="tooltip"]'});

        $.fn.dataTableExt.oApi.fnPagingInfo = function(oSettings) {
            console.log(oSettings)
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

        var t = $("#mytable").dataTable({
            initComplete: function() {
                var api = this.api();
                $('#mytable_filter input')
                    .off('.DT')
                    .on('keyup.DT', function(e) {
                        if (e.keyCode == 13) {
                            api.search(this.value).draw();
                        }
                    });
            },
            responsive: true,
            oLanguage: {
                sProcessing: "loading..."
            },
            processing: true,
            serverSide: true,
            ajax: {
                "url": "<?= base_url('product/json') ?>",
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
                    "data": "price_sale_3",
                    render: $.fn.dataTable.render.number('.', ',', ''),
                    "className": "text-right",
                },
                {
                    "data": "price_sale_5",
                    render: $.fn.dataTable.render.number('.', ',', ''),
                    "className": "text-right",
                },
                {
                    "data": "price_sale_10",
                    render: $.fn.dataTable.render.number('.', ',', ''),
                    "className": "text-right",
                },
                {
                    "data": "category_id"
                },
                {
                    "data": "update_at"
                },
                {
                    "data": "action",
                    "orderable": false,
                    "className": "text-center"
                }
            ],
            order: [
                [10, 'desc']
            ],
            rowCallback: function(row, data, iDisplayIndex) {
                // console.log(data);
                var info = this.fnPagingInfo();
                var page = info.iPage;
                var length = info.iLength;
                var index = page * length + (iDisplayIndex + 1);
                $('td:eq(0)', row).html(index);
            },
        });

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
                    $('#kode_product').val(data);
                }
            });
        });

        // $('#price').on('keyup', function() {
        //     var a = $('#price').val();
        //     if (a == "") {
        //         $('#harpok').html(0);
        //     } else {
        //         $('#harpok').html(a);
        //     }
        //     $('#harpok').priceFormat({
        //         prefix: '',
        //         centsLimit: 0,
        //         thousandsSeparator: '.'
        //     });
        // });

        // $('#price_sale').on('keyup', function() {
        //     var a = $('#price_sale').val();
        //     if (a == "") {
        //         $('#harjul').html(0);
        //     } else {
        //         $('#harjul').html(a);
        //     }
        //     $('#harjul').priceFormat({
        //         prefix: '',
        //         centsLimit: 0,
        //         thousandsSeparator: '.'
        //     });
        // });

        $('.price').priceFormat({
            prefix: '',
            centsLimit: 0,
            thousandsSeparator: '.'
        })
    });
</script>