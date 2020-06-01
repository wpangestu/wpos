<script>
  $(document).ready(function(){
  
    $('.dropify').dropify();

    <?php $message = $this->session->flashdata('message');
      if($message!=null): ?>
        $.toast({
          text: 'Data Berhasil diubah', // Text that is to be shown in the toast
          heading: 'Sukses', // Optional heading to be shown on the toast
          icon: 'success', // Type of toast icon
          showHideTransition: 'fade', // fade, slide or plain
          allowToastClose: true, // Boolean value true or false
          hideAfter: 3000, // false to make it sticky or number representing the miliseconds as time after which toast needs to be hidden
          stack: 5, // false if there should be only one toast at a time or a number representing the maximum number of toasts to be shown at a time
          position: 'bottom-right', // bottom-left or bottom-right or bottom-center or top-left or top-right or top-center or mid-center or an object representing the left, right, top, bottom values

          loader: false,
          textAlign: 'left', // Text alignment i.e. left, right or center
          loaderBg: '#9ec600', // Background color of the toast loader
          beforeShow: function() {}, // will be triggered before the toast is shown
          afterShown: function() {}, // will be triggered after the toat has been shown
          beforeHide: function() {}, // will be triggered before the toast gets hidden
          afterHidden: function() {} // will be triggered after the toast has been hidden
        });
      <?php endif ?>
  });
</script>