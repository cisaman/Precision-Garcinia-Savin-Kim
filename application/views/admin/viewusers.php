<?php include_once 'includes/header.php'; ?>

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>User</h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo base_url('admin/index') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">User</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">

    <!-- top row -->
    <div class="row">
        <div class="col-xs-12 connectedSortable">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title text-green">View Page | <a href="<?php echo base_url('admin/users') ?>" class="text-blue">Back to Users List</a></h3>
                </div><!-- /.box-header -->
                <div class="box-body table-responsive">
                    <table id="example2" class="table table-bordered table-hover">
                        <tbody>                            
                            <tr><th>First Name: <?php echo $user['first_name']; ?></th></tr>
                            <tr><td>Last Name: <?php echo $user['last_name']; ?></td></tr>
                            <tr><td>E-Mail: <?php echo $user['email_address']; ?></td></tr>
                            <tr><td>Country: <?php echo $user['country_name']; ?></td></tr>
                            <tr><td>address: <?php echo $user['address']; ?></td></tr>
                            <tr><td>City: <?php echo $user['city']; ?></td></tr>
                            <tr><td>State: <?php echo $user['state_name']; ?></td></tr>
                            <tr><td>Zip Code: <?php echo $user['zipcode']; ?></td></tr>
                            <tr><td>Phone Number: <?php echo $user['phone_number']; ?></td></tr>
                            <tr><td>Product ID: <?php echo ($user['product_id']=='1')?"Product A":"Product B"; ?></td></tr>
                            <tr><td>Created: <?php echo date('d-M-Y',strtotime($user['created'])); ?></td></tr>
                            <tr><td>Payment Date: <?php  echo  isset($user['payment_date']) ? date('d-M-Y',strtotime($user['payment_date'])) : "N/A"; ?></td></tr>
                            <?php  $next_shipping_date_a = $this->common_model->last_shipping_date($user['id'], 'a');  ?>
                            <?php  $next_shipping_date_b = $this->common_model->last_shipping_date($user['id'], 'b');  ?>
                            <tr><td>Product A Recurring Payment date: <?php if(!empty($next_shipping_date_a)){echo date('d-M-Y',strtotime($next_shipping_date_a));}else{echo "N/A";} ?></td></tr>
                            <tr><td>Product B Recurring Payment date: <?php if(!empty($next_shipping_date_b)){echo date('d-M-Y',strtotime($next_shipping_date_b));}else{echo "N/A";} ?></td></tr>
                        </tfoot>
                    </table>
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div><!-- /.col -->
    </div>
    <!-- /.row -->

</section><!-- /.content -->

<?php include_once 'includes/footer.php'; ?>