<script type="text/javascript">
            $(document).ready(function() {

                $.fn.dataTableExt.oApi.fnPagingInfo = function(oSettings)
                {
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
                                    api.search(this.value).draw();
                        });
                    },
                    oLanguage: {
                        sProcessing: "loading..."
                    },
                    processing: true,
                    serverSide: true,
                    ajax: {"url": "customer/json", "type": "POST"},
                    columns: [
                        {
                            "data": "id",
                            "orderable": false
                        },
                        {"data": "id_customer"},
                        {"data": "name_customer"},
                        {"data": "gender"},
                        {"data": "address"},
                        {"data": "phone"},
                        {
                            "data": "total",
                            render: $.fn.dataTable.render.number('.', ',', ''),
                            "className": "text-right",
                        },
                        {"data": "update_at"},
                        {
                            "data" : "action",
                            "orderable": false,
                            "className" : "text-center"
                        }
                    ],
                    order: [[7, 'desc']],
                    rowCallback: function(row, data, iDisplayIndex) {
                        var info = this.fnPagingInfo();
                        var page = info.iPage;
                        var length = info.iLength;
                        var index = page * length + (iDisplayIndex + 1);
                        $('td:eq(0)', row).html(index);
                        if(data.id==1){
                            $('td:eq(7)', row).html('');
                        }
                    }
                });

                $('#mytable').on('click', '.btn-ubah-customer', function() {
                  let id = $(this).data('id');
                  let kdcustomer = $(this).data('id_customer');
                  let nama = $(this).data('name')
                  let gender = $(this).data('gender')
                  let alamat = $(this).data('address')
                  let phone = $(this).data('phone')
                  $('#cust_id').val(id)
                  $('#cust_id_customer').val(kdcustomer)
                  $('#cust_name_customer').val(nama)
                  $('#cust_address').val(alamat)
                  $('#cust_phone').val(phone)
                  if(gender=="Laki-laki"){
                      $('#custgender').html(`
                          <option value="l" selected>Laki-laki</option>
                          <option value="p">Perempuan</option>
                      `)
                  }else if(gender=="Perempuan"){
                      $('#custgender').html(`
                          <option value="l">Laki-laki</option>
                          <option value="p" selected>Perempuan</option>
                      `)
                  }

                  $('#ubah-customer').modal('show');
                })
            });
        </script>