<script>
  // $(document).ready(function(){
  $(document).ready(function(){
    
    $('.datepicker').datepicker({
      format: 'dd/mm/yyyy',
      autoclose: true,
      language: 'id',
      todayHighlight: true,
      enableOnReadonly: true,
    });

    $('.input-daterange').datepicker({

    });

    $('#tbl_daftar_credit').dataTable()

    $('#tbl_daftar_pembayaran').dataTable({
        fixedHeader : true,
        paging    : false,
        scrollY   :200,
        searching : false,
        order     : false,
    })
    $('#tbl_product').dataTable({
        fixedHeader : true,
        paging    : false,
        scrollY   :150,
        scrollX   :250,
        searching : false,
        order     : false,
    })

    $('#btn_add_pay_credit').click(function(){
      const no_trans = $(this).data('invoice');
      const customer = $(this).data('customer');
      const date = $(this).data('date');
      const total = $(this).data('total');
      const dibayar = $(this).data('dibayar');
      const sisa = $(this).data('sisa');
      // console.log(no_trans)
      $('#md_add_pay_credit #no_transaksi').html(no_trans)
      $('#md_add_pay_credit #input_invoice').val(no_trans)
      $('#md_add_pay_credit .customer').html(customer)
      $('#md_add_pay_credit .no_invoice').html(no_trans)
      $('#md_add_pay_credit .date').html(date)
      $('#md_add_pay_credit .total').html(total)
      $('#md_add_pay_credit .dibayar').html(dibayar)
      $('#md_add_pay_credit .sisa').html(sisa)

      $('#md_add_pay_credit #amount').focus();
      $('#md_add_pay_credit').modal('show')

    })

    $('.rupiah').priceFormat({
        prefix: '',
        centsLimit: 0,
        thousandsSeparator: '.'
    })

    $('#md_add_pay_credit').on('shown.bs.modal', function () {
        $("#md_add_pay_credit #amount").focus();
    })

    $('#amount').on('keyup focus', function(){
        let sisa = $(this).data('sisa');
        let amount = $(this).val();
        sisa = sisa.replace(/\./g,'');
        amount = amount.replace(/\./g,'');
        sisa = parseInt(sisa);
        amount = parseInt(amount);

        if(amount > sisa){
          
          const refund = amount - sisa;
          const rupiah = formatNumber(refund);
          $('#kembalian').html(`<strong>Kembalian</strong> : Rp ${rupiah}`)

        }else{
          
          $('#kembalian').html(``)
        
        }
    });

    function formatNumber (num) {
      return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.")
    }
    
  })
</script>