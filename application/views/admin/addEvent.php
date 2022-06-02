<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <i class="fa fa-users"></i> Event Management
        </h1>
    </section>

    <section class="content">

        <div class="row">
            <!-- left column -->
            <div class="col-md-8">
                <!-- general form elements -->

                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Enter Event information</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <?php $this->load->helper("form"); ?>
                    <form role="form" action="<?php echo base_url() ?>addNewEvents" method="post" role="form" enctype="multipart/form-data">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="fname">Title</label>
                                        <input type="text" class="form-control required" value="<?php //echo set_value('fname'); ?>" id="title" name="title" maxlength="128" placeholder="Enter Title Here">
                                    </div>

                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="email">Status</label>
                                        <select name="status" id="status" class="form-control required">
                                            <option value="">Please Select</option>
                                            <option value="1">Published</option>
                                            <option value="0">Unpublished</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="email">Image</label>
                                        <input type="file" class="form-control required" id="photo" value="<?php //echo set_value('email'); ?>" name="photo">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="user_name">Description</label>
                                        <textarea type="text" class="form-control required" id="desc" value="<?php //echo set_value('user_name'); ?>" name="desc"
                                            placeholder="Enter Description"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.box-body -->

                        <div class="box-footer">
                            <input type="submit" class="btn btn-primary" value="SEND" />
                            <input type="reset" class="btn btn-default" onClick="location.href='<?php echo base_url() ?>events'" value="BACK" />
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-4">
                    <div class="row">
                        <div class="col-md-12">
                            <?php echo validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?>
                        </div>
                    </div>
            </div>
        </div>
    </section>
</div>
<script src="<?php echo base_url(); ?>assets/js/addUser.js" type="text/javascript"></script>