<script>
  $(document).ready(function(){
    $('.edit-unit').on('click', function(){
      const id = $(this).data('id');
      const kode = $(this).data('kode');
      const ket = $(this).data('ket');
      console.log(kode);
      $('#kode_unit_produk').val(kode);
      $('#name_unit').val(ket);
      $('#idunit').val(id);
      $('#md-ubah-unit').modal('show');
    });
  })
</script>