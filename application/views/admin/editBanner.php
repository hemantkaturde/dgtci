<?php

$banner_id = '';
$banner_title = '';
$banner_image = '';
$banner_description = '';
$banner_status = '';

if(!empty($bannerInfo))
{
    foreach ($bannerInfo as $bf)
    {
        $banner_id = $bf->banner_id;
        $banner_title = $bf->banner_title;
        $banner_image = $bf->banner_image;
        $banner_description = $bf->banner_description;
        $banner_status = $bf->banner_status;
    }
}


?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <i class="fa fa-users"></i> Banner Management
        </h1>
    </section>

    <section class="content">
        <div class="row">
            <!-- left column -->
            <div class="col-md-8">
                <!-- general form elements -->

                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Update Banner information</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <?php $this->load->helper("form"); ?>
                    <form role="form" action="<?php echo base_url() ?>updateBanner" method="post" role="form" enctype="multipart/form-data">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="fname">Title</label>
                                        <input type="hidden" name="bannerId" value="<?php echo $banner_id ?>">
                                        <input type="text" class="form-control required" value="<?php echo $banner_title; ?>" id="title" name="title" maxlength="128" placeholder="Enter Title Here">
                                    </div>

                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="email">Status</label>
                                        <select name="status" id="status" class="form-control required">
                                            <option value="">Please Select</option>
                                            <option value="1" <?php if($banner_status == 1){ echo "selected"; } ?>>Published</option>
                                            <option value="0" <?php if($banner_status == 0){ echo "selected"; } ?>>Unpublished</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="photo">Image</label>
                                        <input type="file" class="form-control required" id="photo" value="<?php echo $banner_image; ?>" name="photo">
                                        <input type="hidden" name="photo1" id="photo1" value="<?php echo $banner_image; ?>">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="user_name">Description</label>
                                        <textarea type="text" class="form-control required" id="desc" name="desc" placeholder="Enter Description"><?php echo $banner_description; ?></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.box-body -->

                        <div class="box-footer">
                            <input type="submit" class="btn btn-primary" value="UPDATE" />
                            <input type="reset" class="btn btn-default" onClick="location.href='<?php echo base_url() ?>banner'" value="BACK" />
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