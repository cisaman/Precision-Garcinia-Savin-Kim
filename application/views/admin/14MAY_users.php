<?php include_once 'includes/header.php'; ?>

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>Pages</h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo base_url('admin/index') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Users</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">

    <!-- top row -->
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title text-green">Manage Users</h3>
                </div><!-- /.box-header -->
                <div class="box-body table-responsive">
                    
                    <?php if ($this->session->flashdata('message')) { ?>
                        <div id="statusMsg" class="alert alert-<?php echo $this->session->flashdata('type'); ?>">
                            <?php echo $this->session->flashdata('message'); ?>
                        </div>
                    <?php } ?>
                    
                    <table id="example2" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th style="width:50px;" class="text-center">#</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Email Address</th>
                                <th>State</th>
                                <th>City</th>
                                <th>Payment Status</th>
                                <th style="width:50px;" class="text-center">View</th>
                                <th style="width:50px;" class="text-center">Recurring</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $count = 1; ?>
                            <?php foreach ($users as $user) { ?>
                                <tr>
                                    <td class="text-center"><?php echo $count++; ?></td>
                                    <td><?php echo $user['first_name']; ?></td>
                                    <td><?php echo $user['last_name']; ?></td>
                                    <td><?php echo $user['email_address']; ?></td>
                                    <td>
                                        <?php 
                                        $this->load->model('common_model');
                                        echo $this->common_model->getStateByStateID($user['state']);
                                        ?>                                        
                                    </td>
                                    <td>
                                        <?php echo $user['city']; ?>
                                    </td>
                                    <td> - </td>
                                    <td class="text-center">
                                        <a href="<?php echo base_url('admin/viewusers').'/'.$user['id'] ?>"><i class="fa fa-search"></i></a>
                                    </td>
                                    <td class="text-center">
                                        <a class="btn btn-primary btn-small btn-sm" href="<?php echo base_url('admin/payment').'/'.$user['id'] ?>">Send</a>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tfoot>
                    </table>
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div><!-- /.col -->
    </div>
    <!-- /.row -->

</section><!-- /.content -->

<?php include_once 'includes/footer.php'; ?>