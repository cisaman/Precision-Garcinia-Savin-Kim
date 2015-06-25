<?php include_once 'includes/header.php'; ?>

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>Users</h1>
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
                                <th style="width:100px;">First Name</th>
                                <th style="width:100px;">Last Name</th>
                                <th style="width:220px;">Email Address</th>
                                <th style="width:100px;">State</th>
                                <th style="width:100px;">City</th>
                                <th style="width:120px;">Recurring Date</th>
                                <th style="width:100px;" class="text-center">View</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody id="users_list">
                            <?php $count = ($limit * ($page - 1)); ?>
                            <?php foreach ($users as $user) { ?>
                                <tr>
                                    <td class="text-center"><?php echo ($count + 1); $count++; ?></td>
                                    <td><?php echo $user['first_name']; ?></td>
                                    <td><?php echo $user['last_name']; ?></td>
                                    <td><?php echo $user['email_address']; ?></td>
                                    <td>
                                        <?php
                                        $this->load->model('common_model');
                                        echo $user['state_name'];
                                        ?>                                        
                                    </td>
                                    <td>
                                        <?php echo $user['city']; ?>
                                    </td>
                                    <td style="text-align: center;">
                                        <?php
                                          $next_shipping_date = $this->common_model->last_shipping_date($user['id']);
                                          if($next_shipping_date){
                                              echo date("d-M-Y", strtotime($next_shipping_date));
                                              
                                          }  else {
                                              echo "N/A";
                                          }
                                       
                                        ?>
                                    </td>                                    
                                    <td class="text-center">
                                        <a href="<?php echo base_url('admin/viewusers') . '/' . $user['id'] ?>"><i class="fa fa-search"></i></a>
                                    </td>
                                    <td class="text-center">
                                        <?php
                                        $flag = $this->common_model->checkUserIsPaidByUserID($user['id']);                                        
                                        if($flag == '1'){
                                        ?>
                                        <?php
                                            $diff = (strtotime($next_shipping_date) - strtotime(date('d-M-Y H:i:s')));
                                            
                                            if($diff <= 0){
                                            $shipfusion = $this->common_model->getShipFusionInfoByUserIDAndMonth($user['id']);
                                            if($shipfusion==false){
                                                                                           
                                        ?>
                                        <a class="btn btn-primary btn-small btn-sm" href="<?php echo base_url('admin/shipfusion') . '/' . $user['id'] ?>">Shipfusion</a>
                                            <?php } } ?>
                                        <a class="btn btn-primary btn-small btn-sm" href="<?php echo base_url('admin/cancel') . '/' . $user['id'] ?>" onclick="javascript: return confirm('Are you realy want to canecl, Once you cancel then this record not shown in user table')">Cancel</a>
                                        <?php }else if($flag == '0'){ ?>
                                        Canceled
                                        <?php }else { ?>
                                        Unpaid    
                                        <?php } ?>
                                    </td>
                                </tr>
                            <?php } ?>
                            </tfoot>
                        </tbody>
                    </table>
                    <?php echo '<div style="text-align:center;">' . $this->pagination->create_links() . '</div>'; ?>
                </div>
            </div>
        </div>
    </div>    
</section>
<?php include_once 'includes/footer.php'; ?>
<style type="text/css">
    td{
        word-break: break-all;
    }
</style>