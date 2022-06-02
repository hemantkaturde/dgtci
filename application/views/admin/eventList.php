<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <i class="fa fa-users"></i> Event Management
        </h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12 text-right">
                <div class="form-group">
                    <a class="btn btn-primary" href="<?php echo base_url(); ?>addEvents">
                        <i class="fa fa-plus"></i> Add Event</a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Event List</h3>
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
                                <th>Image</th>
                                <th>Title</th>
                                <th>Description</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                  </thead>
                  <tbody>
                            <?php
                    if(!empty($eventRecords))
                    {
                        foreach($eventRecords as $record)
                        {
                    ?>
                                <tr>
                                    <td>
                                        <img src="<?php echo base_url().'uploads/event/'.$record->event_image; ?>" alt="" width="60">
                                    </td>
                                    <td>
                                        <?php echo $record->event_title ?>
                                    </td>
                                    <td>
                                        <?php echo $record->event_description ?>
                                    </td>
                                    <td>
                                        <?php if($record->event_status == 1){ echo 'Published'; }else{ echo 'Unpublieshed'; } ?>
                                    </td>
                                    <td class="text-center">
                                        
                                        <a class="btn btn-xs btn-info" href="<?= base_url().'editEvents/'.$record->event_id; ?>" title="Edit">
                                            <i class="fa fa-pencil"></i>
                                        </a>
                                        <a class="btn btn-xs btn-danger deleteUser" href="#" data-eventid="<?php echo $record->event_id; ?>" title="Delete">
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