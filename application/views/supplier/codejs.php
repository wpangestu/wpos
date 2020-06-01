<script>
  $(document).ready(function(){
    $('.btn-ubah-supplier').click(function () {
      let id = $(this).data('id');
      let nama = $(this).data('name')
      let alamat = $(this).data('address')
      let phone = $(this).data('phone')
      let desc = $(this).data('desc')

      $('#supp_id').val(id)
      $('#supp_nama').val(nama)
      $('#supp_alamat').val(alamat)
      $('#supp_telepon').val(phone)
      $('#supp_keterangan').val(desc)

      $('#ubah-supplier').modal('show');
    })
  })
</script>