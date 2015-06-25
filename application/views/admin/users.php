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
                                <th style="width:50px;text-align: center;" class="text-center">#</th>
                                <th style="width:100px;text-align: center;">First Name</th>
                                <th style="width:100px;text-align: center;">Last Name</th>
                                <th style="width:220px;text-align: center;">Email Address</th>
                                <th style="width:120px;text-align: center;">Product A Recurring Date</th>
                                <th style="width:120px;text-align: center;">Product B Recurring Date</th>
                                <th style="width:150px;text-align: center;">Product A</th>
                                <th style="width:150px;text-align: center;">Product B</th>
                                <th style="width:100px;text-align: center;" class="text-center">View</th>                                
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
                                    <td style="text-align: center;">
                                        <?php
                                        if($user['multi_product_a_status'] == '1'){
                                            $next_shipping_date_a = $this->common_model->last_shipping_date($user['id'],'a');
                                            if($next_shipping_date_a){
                                                echo date("d-M-Y", strtotime($next_shipping_date_a));

                                            }  else {
                                                echo "N/A";
                                            }
                                        }else{
                                            echo "Cancelled";
                                        }    
                                       
                                        ?>
                                    </td>
                                    <td style="text-align: center;">
                                        <?php
                                        if ($user['multi_product_b_status'] == '1') {
                                                $next_shipping_date_b = $this->common_model->last_shipping_date($user['id'], 'b');
                                                if ($next_shipping_date_b) {
                                                    echo date("d-M-Y", strtotime($next_shipping_date_b));
                                                } else {
                                                    echo "N/A";
                                                }
                                            } else {
                                                echo "Cancelled";
                                            }
                                        ?>
                                    </td>
                                    <td class="text-center">
                                        <?php
                                        if ($user['multi_product_a_status'] == '1') {
                                            $flag = $this->common_model->checkUserIsPaidByUserID($user['id']);                                        
                                            if($flag == '1'){
                                            ?>
                                            <?php                                        
                                                $diff = (strtotime($next_shipping_date_a) - strtotime(date('d-M-Y H:i:s')));                                            
                                                if($diff <= 0){
                                                $shipfusion = $this->common_model->getShipFusionInfoByUserIDAndMonth($user['id'],'a');
                                                if($shipfusion==false){                        
                                            ?>
                                            <a class="btn btn-primary btn-small btn-sm" href="<?php echo base_url('admin/shipfusion/a') . '/' . $user['id'] ?>">Shipfusion</a>
                                                <?php } } ?>
                                            <a class="btn btn-primary btn-small btn-sm" href="<?php echo base_url('admin/cancel/a') . '/' . $user['id'] ?>" onclick="javascript: return confirm('Are you realy want to canecl, Once you cancel then this record not shown in user table')">Cancel</a>
                                            <?php }else if($flag == '0'){ ?>
                                            Canceled
                                            <?php }else { ?>
                                            Unpaid    
                                            <?php } ?>
                                        <?php }else{ echo "Cancelled"; } ?>    
                                    </td>
                                    <td class="text-center">
                                        <?php
                                        if ($user['multi_product_b_status'] == '1') {
                                            $flag = $this->common_model->checkUserIsPaidByUserID($user['id']);                                        
                                            if($flag == '1'){
                                            ?>
                                            <?php
                                                $diff = (strtotime($next_shipping_date_b) - strtotime(date('d-M-Y H:i:s')));                                            
                                                if($diff <= 0){
                                                $shipfusion = $this->common_model->getShipFusionInfoByUserIDAndMonth($user['id'],'b');
                                                if($shipfusion==false){                                                                                           
                                            ?>
                                            <a class="btn btn-primary btn-small btn-sm" href="<?php echo base_url('admin/shipfusion/b') . '/' . $user['id'] ?>">Shipfusion</a>
                                                <?php } } ?>
                                            <a class="btn btn-primary btn-small btn-sm" href="<?php echo base_url('admin/cancel/b') . '/' . $user['id'] ?>" onclick="javascript: return confirm('Are you realy want to canecl, Once you cancel then this record not shown in user table')">Cancel</a>
                                            <?php }else if($flag == '0'){ ?>
                                            Canceled
                                            <?php }else { ?>
                                            Unpaid    
                                            <?php } ?>
                                        <?php }else{ echo "Cancelled"; } ?>  
                                    </td>
                                                                        
                                    <td class="text-center">
                                        <a href="<?php echo base_url('admin/viewusers') . '/' . $user['id'] ?>"><i class="fa fa-search"></i></a>
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