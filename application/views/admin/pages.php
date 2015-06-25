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
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title text-green">Manage Pages | <a href="<?php echo base_url('admin/addpage') ?>" class="text-blue">Add Page</a></h3>
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
                                <th>Page Title</th>
                                <th style="width:50px;" class="text-center">View</th>
                                <th style="width:50px;" class="text-center">Edit</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $count = 1; ?>
                            <?php foreach ($pages as $page) { ?>
                                <tr>
                                    <td class="text-center"><?php echo $count++; ?></td>
                                    <td><?php echo $page['page_name']; ?></td>
                                    <td class="text-center">
                                        <a href="<?php echo base_url('admin/viewpage').'/'.$page['page_id'] ?>"><i class="fa fa-search"></i></a>
                                    </td>
                                    <td class="text-center">
                                        <a href="<?php echo base_url('admin/updatepage').'/'.$page['page_id'] ?>"><i class="fa fa-edit"></i></a>
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