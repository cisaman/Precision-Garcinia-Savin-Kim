<?php include_once 'includes/header.php'; ?>

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>Profile</h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo base_url('admin/index') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Admin profile</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">

    <!-- top row -->
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
<!--                <div class="box-header">
                    <h3 class="box-title text-green">Add Page | <a href="<?php echo base_url('admin/pages') ?>" class="text-blue">Back to Pages List</a></h3>
                </div> /.box-header -->
                <!-- form start -->
                
                <?php if ($this->session->flashdata('message')) { ?>
                    <div id="statusMsg" class="alert alert-<?php echo $this->session->flashdata('type'); ?>">
                        <?php echo $this->session->flashdata('message'); ?>
                    </div>
                <?php } ?>

                <?php echo form_open('admin/profile', 'method="post" name="pages" id="pages" autocomplete="off"') ?>              
                    <div class="box-body">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" value="<?php echo $adminDetails['admin_name'] ;?>" placeholder="Enter User Name" id="page_title" name="admin_name" class="form-control">
                            <div class="text-red" id="page_title_error"></div>
                        </div>
                        <div class="form-group">
                            <label>Email ID</label>
                            <input id="page_desc" value="<?php echo $adminDetails['admin_email'] ;?>" name="admin_email" placeholder="Enter User Email ID" class="form-control "/>
                            <div class="text-red" id="page_desc_error"></div>
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" id="admin_password"  name="admin_password" placeholder="Please enter password" class="form-control" autocomplete="off"/>
                            <div class="text-red" id="admin_password_error"></div>
                        </div>
                    </div><!-- /.box-body -->

                    <div class="box-footer">
                        <button class="btn btn-primary" type="submit" id="btnSave">Submit</button>
                    </div>
                </form>
            </div>
        </div><!-- /.col -->
    </div>
    <!-- /.row -->

</section><!-- /.content -->

<?php include_once 'includes/footer.php'; ?>

<script type="text/javascript">
    $('#btnSave').click(function() {
        var page_title = $('#page_title');
        //var page_desc = $('#page_desc');
        var page_desc = CKEDITOR.instances.page_desc.getData();
       
        var page_title_error = $('#page_title_error');
        var page_desc_error = $('#page_desc_error');
        
        if(page_title.val() == '') {
            page_title_error.html('Please enter Page Title');
            page_title.focus();
            return false;
        } else {            
            page_title_error.html('');
        }

        if(page_desc == '') {
            page_desc_error.html('Please enter Page Description');
            page_desc.focus();
            return false;
        } else {
            page_desc_error.html('');
        }
    });
</script>