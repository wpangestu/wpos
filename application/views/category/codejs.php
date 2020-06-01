<script>
  $(document).ready(function(){
    $('.edit-category').on('click', function(){
      const id = $(this).data('id');
      const kategori = $(this).data('kategori');
      const desc = $(this).data('desc');
      $('#name_category').val(kategori);
      $('#deskripsi_category').val(desc);
      $('#idkategori').val(id);
      $('#md-ubah-category').modal('show');
    });
  })
</script>