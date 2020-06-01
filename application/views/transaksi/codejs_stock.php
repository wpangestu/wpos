<script>
	$(document).ready(function() {
		$('.datepicker').datepicker({
			format: 'dd/mm/yyyy',
			autoclose: true,
			language: 'id',
			todayHighlight: true,
			enableOnReadonly: true,
		});

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
							$('#name_product').val(msg.data.nama);
							$('#stock_product').val(msg.data.stok);
						} else {
							$('#name_product').val('');
							$('#stock_product').val('');
						}
					}
				});
			} else {
				$('#name_product').val('');
				$('#stock_product').val('');
			}
		});

		$('#databarang').on('click', '.pilihbarang', function() {
			let kode = $(this).data('id');

			$('#kodebarang').val(kode);

			$('#itemModal').modal('hide');
			$('#kodebarang').focus();
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

		$('.detail_stock').click(function(){
			let id_product = $(this).data('id');
			let name_product = $(this).data('name');
			let qty = $(this).data('qty');
			let tgl = $(this).data('tgl');
			let ket = $(this).data('ket');

			$('#tgl_si').text(tgl);
			$('#kd_brg_si').text(id_product);
			$('#nm_brg_si').text(name_product);
			$('#qty_si').text(qty);
			$('#ket_si').text(ket);
		});
	});
</script>