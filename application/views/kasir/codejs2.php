<script type="text/javascript">
	$(document).ready( function () 
{
	$('#txtsalesdate,#txtfirstperiod,#txtlastperiod').datepicker({
		format: 'dd-mm-yyyy',
	});

	function reposition() {
		var modal = $(this),
		dialog = modal.find('.modal-dialog');
		modal.css('display', 'block');
		dialog.css("margin-top", Math.max(0, ($(window).height() - dialog.height()) / 2));
	}

	$('.modal').on('show.bs.modal', reposition);
	$(window).on('resize', function() {
		$('.modal:visible').each(reposition);
	});

	$( "#modaleditparam" ).find( ".modal-footer" ).remove();
	$( "#modalpayment" ).find( ".modal-footer" ).remove();
	decimal();
	money();
	init_data();
	$( "#txtsearchitem" ).autocomplete({
		search  : function(){$(this).addClass('working');},
		open    : function(){$(this).removeClass('working');},
		source: function(request, response) {
			$.getJSON("autocomplete_item.php", { term: $('#txtsearchitem').val() }, 
				response); },
			minLength:1,
			select:function(event, ui){
				temptabel(ui.item.id_item);
			}
		}).autocomplete( "instance" )._renderItem = function( ul, item ) {
		return $( "<li>" )
		.append( "<dl><dt>"+item.label + "</dt>"+item.price+item.note+ "</dl>"  )
		.appendTo( ul );
	};
});

$(document).on("click",'#btncheckpass',function(){

	var trx = $("#txthiddentrans").val();
	var id_sales = $("#txthidetrxid").val();
	if(id_sales == '' || id_sales == null)
	{
		$.notify({
			message: "No transaction processed"
		},{
			type: 'warning',
			delay: 5000,
		});
		return;
	}
	var pass=$("#txtpass").val();
	var value = {
		pass : pass,
		method : "check_password"
	};
	$.ajax(
	{
		url : "../model/check_password.php",
		type: "POST",
		data : value,
		success: function(data, textStatus, jqXHR)
		{
			var data = jQuery.parseJSON(data);
			if(data.auth == true)
			{
				$("#passwordmodal").modal("hide");
				$("#txtpass").val("");
				delete_trans(id_sales);
			}else{
				$.notify({
					message: "Password does not match"
				},{
					type: 'danger',
					delay: 10000,
				});
				set_focus("#txtpass");
				return;
			}
		},
		error: function(jqXHR, textStatus, errorThrown)
		{
			loading_stop();
		}
	});


});
function delete_trans(sale_id)
{
	var value = {
		sale_id : sale_id,
		method : "delete_trans"
	};
	loading_start();
	$.ajax(
	{
		url : "c_pos.php",
		type: "POST",
		data : value,
		success: function(data, textStatus, jqXHR)
		{

			var data = jQuery.parseJSON(data);
			if(data.result == true)
			{
				$("#btnfiltersale").click();
			}else{
				$.notify({
					message: "Error delete transaction , Error : "+data.error
				},{
					type: 'danger',
					delay: 10000,
				});
			}	
			loading_stop();
		},
		error: function(jqXHR, textStatus, errorThrown)
		{
			loading_stop();
			
		}
	});	
}
$(document).on("click",".btndeletesale",function(){
	$("#passwordmodal").modal("show");
	$("#txthidetrxid").val($(this).attr("sale_id"));
	$("#txthiddentrans").val("D");
	$("#notepassword").html("Please enter user password to delete transaction!");
	set_focus("#txtpass");
});

$(document).on("click","#btnpayment",function(){
	var id_trans = $("#txtidsales").val();
	var tgl_trans = $("#txtsalesdate").val();

	if(id_trans == '' || id_trans == null){
		$.notify({
			message: "Please fill out id transaction!"
		},{
			type: 'warning',
			delay: 10000,
		});	
		return;
	}
	if(tgl_trans == '' || tgl_trans == null){
		$.notify({
			message: "Please fill out transaction date!"
		},{
			type: 'warning',
			delay: 10000,
		});	
		return;
	}
	var value = {
		method : "check_tempsale"
	};
	$.ajax(
	{
		url : "c_pos.php",
		type: "POST",
		data : value,
		success: function(data, textStatus, jqXHR)
		{
			var data = jQuery.parseJSON(data);
			if(data.tempsale == false)
			{
				$.notify({
					message: "No items have been selected in the shopping cart list!"
				},{
					type: 'warning',
					delay: 10000,
				});	
				set_focus("#txtsearchitem");
				return;
			}else
			{
				var total = parseInt(cleanString($("#txttotal").html()));
				$("#txtinfoidtrans").val($("#txtidsales").val());
				$("#txtinfodatetrans").val($("#txtsalesdate").val());
				$("#txtgrandtotal").val(addCommas(total));
				$("#txtmoneypay").val(addCommas(total));
				$("#txtoddmoney").val(0);
				$("#modalpayment").modal("show");
				set_focus("#txtmoneypay");
			}
		},
		error: function(jqXHR, textStatus, errorThrown)
		{
			
		}
	});

})

$(document).on("blur","#txtmoneypay",function (){
	var total = parseInt(cleanString($("#txttotal").html()));
	var paid =  parseInt(cleanString($(this).val()));
	var returnchange = paid - total;
	if(isNaN(returnchange))
	{
		returnchange = 0;
		$("#txtmoneypay").val(addCommas(total));
	}
	if(paid < total){
		$("#txtmoneypay").val(addCommas(total));
		$("#txtoddmoney").val(0);
	}else{
		$("#txtoddmoney").val(addCommas(returnchange));
	}
});

$(document).on("click","#btnsavetrans",function()
{
	var sale_id = $("#txtidsales").val();
	var sale_date = $("#txtsalesdate").val();
	var paid =  parseInt(cleanString($("#txtmoneypay").val()));
	var disc_prcn = parseFloat(cleanString($("#txttotaldiscprc").val())); 
	var disc_rp = parseInt(cleanString($("#txttotaldiscrp").val()));
	var note= $("#txtnote").val();
	
	swal({   
		title: "Payment",   
		text: "Save payment ?",   
		type: "warning",   
		showCancelButton: true,   
		confirmButtonColor: "#DD6B55",   
		confirmButtonText: "Purchase",   
		closeOnConfirm: true }, 
		function(){   
			$("#btnsavetrans").prop('disabled', true);
			proccess_waiting("#infoproccesspayment");
			var value = {
				sale_id : sale_id,
				sale_date : sale_date,
				paid : paid,
				disc_prcn : disc_prcn,
				disc_rp : disc_rp,
				note : note,
				method : "save_trans"
			};
			$.ajax(
			{
				url : "c_pos.php",
				type: "POST",
				data : value,
				success: function(data, textStatus, jqXHR)
				{
					$("#btnsavetrans").prop('disabled', false);
					$("#infoproccesspayment").html("");
					var data = jQuery.parseJSON(data);
					if(data.result == true){
						var xid_sales = data.xid_sales;
						$("#modalpayment").modal('hide');
							setTimeout(function() {
							$.redirect("nota_jual.php",{ id_sales: xid_sales,duplikasi:0},'POST','_blank'); }, 500); // After 420 ms
						
						reset_data();
					}else{
						$.notify({
							message: "Error save transaction, error :"+data.error
						},{
							type: 'danger',
							delay: 10000,
						});		
					}

				},
				error: function(jqXHR, textStatus, errorThrown)
				{
					$("#infoproccesspayment").html("");
					$("#btnsavetrans").prop('disabled', false);
				}
			});
		});

})

$(document).on("click",".btndiscprc",function (e){
	e.preventDefault();
	$("#txttotaldiscprc").prop('disabled', false);
	$("#txttotaldiscrp").prop('disabled', true);
	$("#txttotaldiscprc").focus();
});
$(document).on("click",".btndiscrp",function (e){
	e.preventDefault();
	$("#txttotaldiscrp").prop('disabled', false);
	$("#txttotaldiscprc").prop('disabled', true);
	$("#txttotaldiscrp").focus();
});
$(document).on("blur","#txttotaldiscprc",function(){
	if (isNaN($(this).val()))
	{
		$(this).val(0);
	}
	if($(this).val() > 100 || $(this).val() < 0 ){
		$(this).val(0);
		var prcn = 0;
	}else{
		var prcn = parseFloat($(this).val());
	}
	var subtotal = parseInt(cleanString($("#txtsubtotal").val()));
	var discrp = subtotal * (prcn/100);
	var total = subtotal - discrp;
	$("#txttotaldiscrp").val(addCommas(discrp));
	$("#txttotal").html(addCommas(total)); 
});

$(document).on("blur","#txttotaldiscrp",function(){
	var subtotal = parseInt(cleanString($("#txtsubtotal").val()));
	if(parseInt(cleanString($(this).val())) > subtotal || parseInt(cleanString($(this).val())) < 0 ){
		$(this).val(0);
		var discrp = 0;
	}else{
		var discrp = parseInt(cleanString($(this).val()));
	}
	var prcn = (discrp/subtotal) * 100;
	if(isNaN(prcn)){
		prcn = 0;
	}
	if(isNaN(discrp)){
		discrp = 0;
	}
	var total = subtotal - discrp;

	$("#txttotaldiscprc").val(prcn.toFixed(2));
	$("#txttotal").html(addCommas(total)); 
});



$(document).on("click","#btnubahedit",function(){
	var nilai = cleanString($("#txtvalue").val());
	var jenis = $("#txtdataparam").val();
	var key = $("#txtkey").val();

	var value = {
		nilai: nilai,
		jenis:jenis,
		key:key,
		method : "updatedetail"
	};
	$.ajax(
	{
		url : "c_pos.php",
		type: "POST",
		data : value,
		success: function(data, textStatus, jqXHR)
		{
			var data = jQuery.parseJSON(data);
			if(data.result ==1){
				var table = $('#table_transaction').DataTable(); 
				table.ajax.reload( null, false );
				$( "#modaleditparam" ).modal("hide");
				refresh_total();
			}else{
				$.notify({
					message: "Error edit , error :"+data.error
				},{
					type: 'danger',
					delay: 10000,
				});		
			}

		},
		error: function(jqXHR, textStatus, errorThrown)
		{
			
		}
	});
});
$(document).on("click",".btndelete",function(){
	var id_item = $(this).attr("id_item");
	var value = {
		id_item: id_item,
		method : "deletedetail"
	};
	$.ajax(
	{
		url : "c_pos.php",
		type: "POST",
		data : value,
		success: function(data, textStatus, jqXHR)
		{
			var data = jQuery.parseJSON(data);
			if(data.result ==1){
				var table = $('#table_transaction').DataTable(); 
				table.ajax.reload( null, false );
				refresh_total();
			}else{
				$.notify({
					message: "Error delete list item , error :"+data.error
				},{
					type: 'danger',
					delay: 10000,
				});		
			}

		},
		error: function(jqXHR, textStatus, errorThrown)
		{
		}
	});
});

$(document).on("click",".editparam",function(){
	var dataparam=$(this).attr("dataparam");
	var datatitle=$(this).attr("datatitle");
	var val=$(this).attr("val");
	var key = $(this).attr("key");

	$( "#modaleditparam" ).find( ".modal-title" ).html(datatitle);
	$("#txtdataparam").val(dataparam);
	$("#txtvalue").val(val);
	$("#txtkey").val(key)

	$("#modaleditparam").modal("show");
	set_focus("#txtvalue");


})
$(document).on("click",".btnnota",function(){
	var idjual = $(this).attr("id_sales");
	var jnsjual = $(this).attr("jns_jual");
	if(jnsjual == 1)
	{
		$.redirect("nota_jual.php",{ id_sales: idjual,duplikasi:1},'POST','_blank');
	}else{
		$.redirect("nota_tempo.php",{ id_sales: idjual,duplikasi:1},'POST','_blank'); 

	}
});

$(document).on("click","#btncancel",function(){
	swal({   
		title: "Reset",   
		text: "Empty transaction ?",   
		type: "warning",   
		showCancelButton: true,   
		confirmButtonColor: "#DD6B55",   
		confirmButtonText: "Reset",   
		closeOnConfirm: true }, 
		function(){   
			reset_data();
		});
});

function temptabel(idbrg){
	var value = {
		id_item: idbrg,
		method : "save_temptable"
	};
	$.ajax(
	{
		url : "c_pos.php",
		type: "POST",
		data : value,
		success: function(data, textStatus, jqXHR)
		{
			var data = jQuery.parseJSON(data);
			if(data.result ==1){
				var table = $('#table_transaction').DataTable(); 
				table.ajax.reload( null, false );
				$("#txtsearchitem").val("");
				refresh_total();
				set_focus("#txtsearchitem");
			}else{
				$.notify({
					message: "Error save item , error :"+data.error
				},{
					type: 'danger',
					delay: 10000,
				});		
			}

		},
		error: function(jqXHR, textStatus, errorThrown)
		{
		}
	});
}
function refresh_total(){
	var value = {
		method : "get_subtotal"
	};
	$.ajax(
	{
		url : "c_pos.php",
		type: "POST",
		data : value,
		success: function(data, textStatus, jqXHR)
		{
			var data = jQuery.parseJSON(data);
			var subtotal = data.subtotal;
			$("#txtsubtotal").val(addCommas(subtotal));
			$("#txttotaldiscprc").blur();
			var discrp = cleanString($("#txttotaldiscrp").val());
			var total =addCommas(subtotal - discrp);
			$("#txttotal").html(total);
		},
		error: function(jqXHR, textStatus, errorThrown)
		{
		}
	});
	
}
$(document).bind('keydown', 'f9', function(){
	$("#btnpayment").click();
});
function newkdtrans(){
	var tgl = $("#txtsalesdate").val();
	var thn = tgl.substr(8, 4);
	var bln = tgl.substr(3, 2);
	var dy = tgl.substr(0, 2);
	var _first = 'J';
	$("#txtidsales").val(_first+thn+bln+dy+'###');
}
function reset_data(){
	var value = {
		method : "reset_table"
	};
	$.ajax(
	{
		url : "c_pos.php",
		type: "POST",
		data : value,
		success: function(data, textStatus, jqXHR)
		{
			var data = jQuery.parseJSON(data);
			if(data.result ==1){
				var table = $('#table_transaction').DataTable(); 
				table.ajax.reload( null, false );
				$("#txttotaldiscprc").val(0);
				$("#txttotaldiscrp").val(0);
				$("#txtsubtotal").val(0);
				$("#txttotal").html("0");
				$("#txtnote").val("");
				refresh_total();
				set_focus("#txtsearchitem");
			}else{
				$.notify({
					message: "Can not reset data, error :"+data.error
				},{
					type: 'danger',
					delay: 10000,
				});		
			}
		},
		error: function(jqXHR, textStatus, errorThrown)
		{
		}
	});
}

$(document).on("click","#btnopentransaction",function(){

	$("#modallasttrans").modal("show");
	$("#table_last_transaction tbody").html("");
});
$(document).on("click","#btnfiltersale",function(){
	var first = $("#txtfirstperiod").val();
	var last = $("#txtlastperiod").val();
	var value = {
		first : first,
		last : last,
		method : "get_trans_sale"
	};
	$.ajax(
	{
		url : "c_pos.php",
		type: "POST",
		data : value,
		success: function(data, textStatus, jqXHR)
		{
			var data = jQuery.parseJSON(data);
			$("#table_last_transaction tbody").html(data.hasil);
		},
		error: function(jqXHR, textStatus, errorThrown)
		{
			
		}
	});
});
function init_data(){

	var value = {
		method : "getdata"
	};
	$('#table_transaction').DataTable({
		"paging": false,
		"lengthChange": false,
		"searching": false,
		"ordering": false,
		"info": false,
		"responsive": true,
		"autoWidth": false,
		"pageLength": 50,
		"dom": '<"top"f>rtip',
		"columnDefs": [
		{ className: "textright", "targets": [ 3,4,5,6 ] }
		],
		"ajax": {
			"url": "c_pos.php",
			"type": "POST",
			"data":value,
		},
		"columns": [
		{ "data": "urutan" },
		{ "data": "id_item" },
		{ "data": "item_name" },
		{ "data": "price" },
		{ "data": "qty" },
		{ "data": "discprc" },
		{ "data": "subtotal" },
		{ "data": "button" },
		]
	});
	$("#txttotaldiscprc").val(0);
	$("#txttotaldiscrp").val(0);
	$("#txtsubtotal").val(0);
	$("#txttotal").html("0");
	refresh_total();
	set_focus("#txtsearchitem");
	newkdtrans();
}
</script>