</aside><!-- /.right-side -->
</div><!-- ./wrapper -->

<!-- add new calendar event modal -->

<!-- jQuery 2.0.2 -->
<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
<!-- jQuery UI 1.10.3 -->
<script src="<?php echo base_url('assets/admin/js') ?>/jquery-ui-1.10.3.min.js" type="text/javascript"></script>
<!-- Bootstrap -->
<script src="<?php echo base_url('assets/admin/js') ?>/bootstrap.min.js" type="text/javascript"></script>
<!-- iCheck -->
<script src="<?php echo base_url('assets/admin/js') ?>/plugins/iCheck/icheck.min.js" type="text/javascript"></script>

<!-- AdminLTE App -->
<script src="<?php echo base_url('assets/admin/js') ?>/AdminLTE/app.js" type="text/javascript"></script>

<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="<?php echo base_url('assets/admin/js') ?>/AdminLTE/dashboard.js" type="text/javascript"></script>

<script src="<?php echo base_url('assets/admin/js') ?>/custom.js" type="text/javascript"></script>

<script src="<?php echo base_url('assets/ckeditor') ?>/ckeditor.js" type="text/javascript"></script>

<script type="text/javascript">
    $('#logout').click(function() {
        location.href = "<?php echo base_url('admin/logout') ?>";
    });
</script>
<script type="text/javascript">
    $(".per-page").on('click',function() {
        var page_num = $(this).attr("page_num");
        jQuery.ajax({
            url: "http://savin.rt.cisinlive.com/admin/users/",
            type: "POST",
            data: {page: page_num},
            success: function(res) {
                jQuery("#users_list").replaceWith(res);
            }
        });
    });
</script>    
</body>
</html>