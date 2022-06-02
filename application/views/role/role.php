<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <i class="fa fa-check-square-o"></i> Role Management
            <small>Add ,Edit, Delete</small>
        </h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12 text-right">
                <div class="form-group">
                    <a class="btn btn-primary" href="<?php echo base_url(); ?>addRole">
                        <i class="fa fa-plus"></i> Add Role</a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Role List</h3>
                                    </div>
                      <!-- /.box-header -->
          <div class="box-body table-responsive no-padding">
            <?php
                    $this->load->helper('form');
                    $error = $this->session->flashdata('error');
                    if($error)
                    {
                ?>
              <div class="alert alert-danger alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <?php echo $this->session->flashdata('error'); ?>
                                </div>
              <?php } ?>
              <?php  
                    $success = $this->session->flashdata('success');
                    if($success)
                    {
                ?>
              <div class="alert alert-success alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <?php echo $this->session->flashdata('success'); ?>
                        </div>
              <?php } ?>
              <div class="panel-body">
                <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                  <thead>
                            <tr>
                                
                                <th>Role Name</th>
                                <th>Description</th>
                                <th>Role Type</th>
                                <th>Action</th>
                            </tr>
                  </thead>
                  <tbody>
                            <?php
                    if(!empty($userRecords))
                    {
                        foreach($userRecords as $record)
                        {
                           
                    ?>
                                <tr>
                                    
                                    <td>
                                        <?php echo $record->role ?>
                                    </td>
                                    <td>
                                        <?php echo $record->discription ?>
                                    </td>
                                    <td>
                                        <?php echo $record->role_type ?>
                                    </td>
                                  
                                    <td class="text-center">
                                        <a class="btn btn-xs btn-info" href="<?php echo base_url().'editRole/'.$record->roleid; ?>" title="Edit">
                                            <i class="fa fa-pencil"></i>
                                        </a>
                                        <a class="btn btn-xs btn-danger deleteRole" href="#" data-roleid="<?php echo $record->roleid; ?>" title="Delete">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                                <?php
                            
                        }
                    }
                    ?>
                  </tbody>
                        </table>
              </div>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
        </div>
    </section>
</div>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/common.js" charset="utf-8"></script>