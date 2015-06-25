<?php include_once 'includes/login_header.php'; ?>

<div class="form-box" id="login-box">
    <div class="header bg-black">
        <h1 style="margin: 0px;">Precision Vitality</h1>Log In
    </div>

    <?php if ($this->session->flashdata('message')) { ?>
        <div id="statusMsg" class="alert alert-<?php echo $this->session->flashdata('type'); ?>">
            <?php echo $this->session->flashdata('message'); ?>
        </div>
    <?php } ?>

    <?php echo form_open('admin/login', 'method="post" name="login" id="login" autocomplete="off"') ?>
        <div class="body bg-gray">
            <div class="form-group">
                <input type="text" name="email_id" id="email_id" class="form-control" placeholder="Email ID"/>
                <div class="text-red" id="email_id_error"></div>
            </div>
            <div class="form-group">
                <input type="password" name="password" id="password" class="form-control" placeholder="Password"/>
                <div class="text-red" id="password_error"></div> 
            </div>
        </div>
        <div class="footer">                                                               
            <button type="submit" class="btn bg-black btn-block" id="btnLogin">Sign me in</button>
            <p class="text-center"><a href="<?php echo base_url('admin/forgotpassword') ?>">I forgot my password</a></p>
        </div>
    </form>
</div>

<?php include_once 'includes/login_footer.php'; ?>


<script type="text/javascript">
    $('#btnLogin').click(function() {
        var email_id = $('#email_id');
        var password = $('#password');

        var email_id_error = $('#email_id_error');
        var password_error = $('#password_error');
        
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

        if(password.val() == '') {
            password_error.html('Please enter Password');
            password.focus();
            return false;
        } else {
            password_error.html('');
        }
    });

    function IsEmail(email) {
        var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        return regex.test(email);
    }
</script>