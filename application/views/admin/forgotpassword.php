<?php include_once 'includes/login_header.php'; ?>
<div class="form-box" id="login-box">
    <div class="header bg-black">
        <h1 style="margin: 0px;">Precision Vitality</h1>Forgot Password
    </div>
    <?php if ($this->session->flashdata('message')) { ?>
        <div id="statusMsg" class="alert alert-<?php echo $this->session->flashdata('type'); ?>">
            <?php echo $this->session->flashdata('message'); ?>
        </div>
    <?php } ?>

    <?php echo form_open('admin/forgotpassword', 'method="post" name="forgotpassword" id="forgotpassword" autocomplete="off"') ?>
        <div class="body bg-gray">
            <div class="form-group">
                <input type="text" name="email_id" id="email_id" class="form-control" placeholder="Email ID"/>
                <div class="text-red" id="email_id_error"></div>
            </div>
        </div>
        <div class="footer">                                                               
            <button type="submit" class="btn bg-black btn-block" id="btnSubmit">Submit</button>
            <p class="text-center"><a href="<?php echo base_url('admin/login') ?>">Back to Log In</a></p>
        </div>
    </form>
</div>
<?php include_once 'includes/login_footer.php'; ?>

<script type="text/javascript">
    $('#btnSubmit').click(function() {
        var email_id = $('#email_id');
        var email_id_error = $('#email_id_error');        
        
        if(email_id.val() == '') {
            email_id_error.html('Please enter Email ID');
            email_id.focus();
            return false;
        } else {
            if(!IsEmail(email_id.val())) {
                email_id_error.html('Invalid Email ID');
                email_id.focus();
                return false;
            } else {
                email_id_error.html('');
            }
        }
    });

    function IsEmail(email) {
        var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        return regex.test(email);
    }
</script>