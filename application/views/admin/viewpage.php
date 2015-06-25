<?php include_once 'includes/header.php'; ?>

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>Pages</h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo base_url('admin/index') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Pages</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">

    <!-- top row -->
    <div class="row">
        <div class="col-xs-12 connectedSortable">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title text-green">View Page | <a href="<?php echo base_url('admin/pages') ?>" class="text-blue">Back to Pages List</a></h3>
                </div><!-- /.box-header -->
                <div class="box-body table-responsive">
                    <table id="example2" class="table table-bordered table-hover">
                        <thead>
                            <tr><th><?php echo $pages['page_name']; ?></th></tr>
                        </thead>
                        <tbody>
                            <tr><td><?php echo $pages['page_desc']; ?></td></tr>
                        </tfoot>
                    </table>
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div><!-- /.col -->
    </div>
    <!-- /.row -->

</section><!-- /.content -->

<?php include_once 'includes/footer.php'; ?>