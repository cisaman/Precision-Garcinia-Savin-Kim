<?php include_once 'includes/header.php'; ?>

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Dashboard
        <small>Control panel</small>
    </h1>
</section>

<!-- Main content -->
<section class="content">

    <!-- Small boxes (Stat box) -->
    <div class="row">
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-aqua">
                <div class="inner">
                    <h3>
                        <?php 
                        $this->load->model('common_model');
                        echo $this->common_model->countRecords('_pages');
                        ?>
                    </h3>
                    <p>
                        Pages
                    </p>
                </div>
                <div class="icon">
                    <i class="ion ion-navicon-round"></i>
                </div>
                <a href="<?php echo base_url('admin/pages'); ?>" class="small-box-footer">
                    More info <i class="fa fa-arrow-circle-right"></i>
                </a>
            </div>
        </div><!-- ./col -->
        <div class="col-lg-3 col-xs-6">
            <div class="small-box bg-green">
                <div class="inner">
                    <h3>
                      <?php  echo $this->common_model->countRecords('_users'); ?>
                    </h3>
                    <p>
                        Users 
                    </p>
                </div>
                <div class="icon">
                    <i class="ion ion-person-add"></i>
                </div>
                <a href="<?php echo base_url('admin/users'); ?>" class="small-box-footer">
                    More info <i class="fa fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
    </div>
</section>

<?php include_once 'includes/footer.php'; ?>