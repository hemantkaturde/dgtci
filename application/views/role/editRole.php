<?php

$roleId = '';
$role = '';
$discription = '';
$access='';

if(!empty($roleInfo))
{
    foreach ($roleInfo as $rf)
    {
        $roleId = $rf->roleId;
        $role = $rf->role;
        $role_type = $rf->role_type;
        $discription = $rf->discription;
        $access = $rf->access; 
    }
}
?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <i class="fa fa-check-square-o"></i> Role Management
            <small>Add / Edit</small>
        </h1>
    </section>

    <section class="content">
    <?php $this->load->helper("form"); ?>
      <form role="form" id="addUser" action="<?php echo base_url() ?>editRoleRecord" method="post" role="form">
        <div class="row">
            <div class="col-md-12">
                <!-- SECTION 1 -->
                <div class="col-md-4">
                    <div class="box box-primary">
                        <div class="box-header">
                            <h3 class="box-title">Add Role</h3>
                        </div>
                        <div class="box-body">
                            <div class="row">
                            <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="role">Role</label>
                                        <input type="text" class="form-control required" id="role" name="role" value="<?php echo $role; ?>"
                                            maxlength="255">
                                        <input type="hidden" name="roleId" id="roleId" value="<?php echo $roleId ?>">
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="discription">Role Type</label>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="roletype" id="roletypesystem" value="system" <?php if($role_type=='system'){ echo 'checked';}?>>
                                                    System
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="roletype" id="roletypecompany" value="company" <?php if($role_type=='company'){ echo 'checked';}?>>
                                                    User
                                                </div>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="discription">Role Description</label>
                                        <textarea type="text" class="form-control" id="discription" value="<?php echo $discription; ?>" name="discription"><?php echo $discription; ?></textarea>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div><!-- SECTION 1-->


                <div class="col-md-8">
                    <div class="box box-primary">
                        <div class="box-header">
                            <h3 class="box-title">Assign Roles</h3>
                        </div>
                        <div class="box-body">
                            <table class="table table-bordered" >
                                <thead>
                                    <tr>
                                            <th scope="col">Module Name</th>
                                            <th scope="col">Module</th>
                                            <th scope="col">Page</th>
                                            <th scope="col">Add</th>
                                            <th scope="col">Edit</th>
                                            <th scope="col">Delete</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                    
                                            <td style="color:#a83131"><b>Dashboard</b></td>
                                            <td><input type="checkbox" id="homepagemodule" name="checkbox[]" value="homepagemodule" <?php if(in_array("homepagemodule", json_decode($access))){ echo 'checked'; } ?>></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>


                                    </tr>
                                   
                                   
                                    <tr>
                                            <td style="color:#a83131"><b>Users</b></td>
                                            <td><input type="checkbox" id="usersmodule" name="checkbox[]" value="usersmodule" <?php if(in_array("usersmodule", json_decode($access))){ echo 'checked'; } ?>></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                    </tr>

                                    <tr>
                                            <td>&nbsp&nbsp&nbsp&nbsp User</td>
                                            <td></td>
                                            <td><input type="checkbox" id="userpage" name="checkbox[]" value="userpage" <?php if(in_array("userpage", json_decode($access))){ echo 'checked'; } ?>></td>
                                            <td><input type="checkbox" id="useradd" name="checkbox[]" value="useradd" <?php if(in_array("useradd", json_decode($access))){ echo 'checked'; } ?>></td>
                                            <td><input type="checkbox" id="useredit" name="checkbox[]" value="useredit" <?php if(in_array("useredit", json_decode($access))){ echo 'checked'; } ?>></td>
                                            <td><input type="checkbox" id="userdelete" name="checkbox[]" value="userdelete" <?php if(in_array("userdelete", json_decode($access))){ echo 'checked'; } ?>></td>
                                    </tr>

                                    <tr>
                                            <td>&nbsp&nbsp&nbsp&nbsp Roles</td>
                                            <td></td>
                                            <td><input type="checkbox" id="rolepage" name="checkbox[]" value="rolepage" <?php if(in_array("rolepage", json_decode($access))){ echo 'checked'; } ?>></td>
                                            <td><input type="checkbox" id="roleadd" name="checkbox[]" value="roleadd" <?php if(in_array("roleadd", json_decode($access))){ echo 'checked'; } ?>></td>
                                            <td><input type="checkbox" id="roleedit" name="checkbox[]" value="roleedit" <?php if(in_array("roleedit", json_decode($access))){ echo 'checked'; } ?>></td>
                                            <td><input type="checkbox" id="roledelete" name="checkbox[]" value="roledelete" <?php if(in_array("roledelete", json_decode($access))){ echo 'checked'; } ?>></td>
                                    </tr>

                                   
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div><!-- SECTION 1-->

            </div>
            <div>
            <div class="col-md-12">
                <!-- ENTER BUTTON HERE -->
                <input type="submit" class="btn btn-primary" value="UPDATE" />
                <input type="reset" class="btn btn-default" onClick="location.href='<?php echo base_url() ?>roleListing'" value="BACK" />
            </div>
            <div class="col-md-4">
                <div class="row">
                    <div class="col-md-12">
                        <?php echo validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?>
                    </div>
                </div>
            </div>
        </div>
      </form>
    </section>

</div>
<script src="<?php echo base_url(); ?>assets/js/addUser.js" type="text/javascript"></script>

<script type="text/javascript">
$('#clientmodule').click(function() {
    if ($(this).is(':checked')) {
        $('#clientpage').prop('checked', true);
        $('#clientadd').prop('checked', true);
        $('#clientedit').prop('checked', true);
        $('#clientdelete').prop('checked', true);
    }else{
        $('#clientpage').prop('checked', false);
        $('#clientadd').prop('checked', false);
        $('#clientedit').prop('checked', false);
        $('#clientdelete').prop('checked', false);
}
});
$('#clientpage,#clientadd,#clientedit,#clientdelete').click(function() {
    if ($('#clientpage').is(':checked') && $('#clientadd').is(':checked') && $('#clientedit').is(':checked') && $('#clientdelete').is(':checked')) {
         $('#clientmodule').prop('checked', true);
    }
});


$('#vendormodule').click(function() {
    if ($(this).is(':checked')) {
        $('#vendorpage').prop('checked', true);
        $('#vendoradd').prop('checked', true);
        $('#vendoredit').prop('checked', true);
        $('#vendordelete').prop('checked', true);
    }else{
        $('#vendorpage').prop('checked', false);
        $('#vendoradd').prop('checked', false);
        $('#vendoredit').prop('checked', false);
        $('#vendordelete').prop('checked', false);
}
});
$('#vendorpage,#vendoradd,#vendoredit,#vendordelete').click(function() {
    if ($('#vendorpage').is(':checked') && $('#vendoradd').is(':checked') && $('#vendoredit').is(':checked') && $('#vendordelete').is(':checked')) {
         $('#vendormodule').prop('checked', true);
    }
});



$('#warehousemodule').click(function() {
    if ($(this).is(':checked')) {
        $('#warehousepage').prop('checked', true);
        $('#warehouseadd').prop('checked', true);
        $('#warehousedit').prop('checked', true);
        $('#warehousedelete').prop('checked', true);
    }else{
        $('#warehousepage').prop('checked', false);
        $('#warehouseadd').prop('checked', false);
        $('#warehousedit').prop('checked', false);
        $('#warehousedelete').prop('checked', false);
}
});
$('#warehousepage,#warehouseadd,#warehousedit,#warehousedelete').click(function() {
    if ($('#warehousepage').is(':checked') && $('#warehouseadd').is(':checked') && $('#warehousedit').is(':checked') && $('#warehousedelete').is(':checked')) {
         $('#warehousemodule').prop('checked', true);
    }
});


$('#ratemastermodule').click(function() {
    if ($(this).is(':checked')) {
        $('#ratemasterpage').prop('checked', true);
        $('#ratemasteradd').prop('checked', true);
        $('#ratemasteredit').prop('checked', true);
        $('#ratemasterdelete').prop('checked', true);
    }else{
        $('#ratemasterpage').prop('checked', false);
        $('#ratemasteradd').prop('checked', false);
        $('#ratemasteredit').prop('checked', false);
        $('#ratemasterdelete').prop('checked', false);
}
});
$('#ratemasterpage,#ratemasteradd,#ratemasteredit,#ratemasterdelete').click(function() {
    if ($('#ratemasterpage').is(':checked') && $('#ratemasteradd').is(':checked') && $('#ratemasteredit').is(':checked') && $('#ratemasterdelete').is(':checked')) {
         $('#ratemastermodule').prop('checked', true);
    }
});


$('#ordersmodule').click(function() {
    if ($(this).is(':checked')) {
        $('#orderspage').prop('checked', true);
        $('#ordersadd').prop('checked', true);
        $('#ordersedit').prop('checked', true);
        $('#ordersdelete').prop('checked', true);

        $('#reverseorderpage').prop('checked', true);
        $('#reverseorderadd').prop('checked', true);
        $('#reverseorderedit').prop('checked', true);
        $('#reverseorderdelete').prop('checked', true);

    }else{
        $('#orderspage').prop('checked', false);
        $('#ordersadd').prop('checked', false);
        $('#ordersedit').prop('checked', false);
        $('#ordersdelete').prop('checked', false);

        $('#reverseorderpage').prop('checked', false);
        $('#reverseorderadd').prop('checked', false);
        $('#reverseorderedit').prop('checked', false);
        $('#reverseorderdelete').prop('checked', false);
}
});
$('#orderspage,#ordersadd,#ordersedit,#ordersdelete,#reverseorderpage,#reverseorderadd,#reverseorderedit,#reverseorderdelete').click(function() {
    if ($('#orderspage').is(':checked') && $('#ordersadd').is(':checked') && $('#ordersedit').is(':checked') && $('#ordersdelete').is(':checked')
        && $('#reverseorderpage').is(':checked') && $('#reverseorderadd').is(':checked') && $('#reverseorderedit').is(':checked') && $('#reverseorderdelete').is(':checked')
    
       ) {
         $('#ordersmodule').prop('checked', true);
    }
});



$('#usersmodule').click(function() {
    if ($(this).is(':checked')) {
        $('#userpage').prop('checked', true);
        $('#useradd').prop('checked', true);
        $('#useredit').prop('checked', true);
        $('#userdelete').prop('checked', true);

        $('#rolepage').prop('checked', true);
        $('#roleadd').prop('checked', true);
        $('#roleedit').prop('checked', true);
        $('#roledelete').prop('checked', true);

    }else{
        $('#userpage').prop('checked', false);
        $('#useradd').prop('checked', false);
        $('#useredit').prop('checked', false);
        $('#userdelete').prop('checked', false);

        $('#rolepage').prop('checked', false);
        $('#roleadd').prop('checked', false);
        $('#roleedit').prop('checked', false);
        $('#roledelete').prop('checked', false);
}
});
$('#userpage,#useradd,#useredit,#userdelete,#rolepage,#roleadd,#roleedit,#roledelete').click(function() {
    if ($('#userpage').is(':checked') && $('#useradd').is(':checked') && $('#useredit').is(':checked') && $('#userdelete').is(':checked')
        && $('#rolepage').is(':checked') && $('#roleadd').is(':checked') && $('#roleedit').is(':checked') && $('#roledelete').is(':checked')
    
       ) {
         $('#usersmodule').prop('checked', true);
    }
});


$('#reportsmodule').click(function() {
    if ($(this).is(':checked')) {
        $('#allorders').prop('checked', true);
    }else{
        $('#allorders').prop('checked', false);
}
});
$('#allorders').click(function() {
    if ($('#allorders').is(':checked')) {
         $('#reportsmodule').prop('checked', true);
    }
});


$('#settingsmodule').click(function() {
    if ($(this).is(':checked')) {
        $('#emailsettingpage').prop('checked', true);
        $('#emailsettingadd').prop('checked', true);
        $('#emailsettingedit').prop('checked', true);
        $('#emailsettingdelete').prop('checked', true);

        $('#apiintepage').prop('checked', true);
        $('#apiinteadd').prop('checked', true);
        $('#apiinteedit').prop('checked', true);
        $('#apiintedelete').prop('checked', true);

    }else{
        $('#emailsettingpage').prop('checked', false);
        $('#emailsettingadd').prop('checked', false);
        $('#emailsettingedit').prop('checked', false);
        $('#emailsettingdelete').prop('checked', false);

        $('#apiintepage').prop('checked', false);
        $('#apiinteadd').prop('checked', false);
        $('#apiinteedit').prop('checked', false);
        $('#apiintedelete').prop('checked', false);
}
});
$('#emailsettingpage,#emailsettingadd,#emailsettingedit,#emailsettingdelete,#apiintepage,#apiinteadd,#apiinteedit,#apiintedelete').click(function() {
    if ($('#emailsettingpage').is(':checked') && $('#emailsettingadd').is(':checked') && $('#emailsettingedit').is(':checked') && $('#emailsettingdelete').is(':checked')
        && $('#apiintepage').is(':checked') && $('#apiinteadd').is(':checked') && $('#apiinteedit').is(':checked') && $('#apiintedelete').is(':checked')
    
       ) {
         $('#settingsmodule').prop('checked', true);
    }
});



$('#optionssmodule').click(function() {
    if ($(this).is(':checked')) {
        $('#logrecordpage').prop('checked', true);
        $('#uploadbackuppage').prop('checked', true);
        $('#logrecordbackuppage').prop('checked', true);
      

    }else{
        $('#logrecordpage').prop('checked', false);
        $('#uploadbackuppage').prop('checked', false);
        $('#logrecordbackuppage').prop('checked', false);
}
});
$('#logrecordpage,#uploadbackuppage,#logrecordbackuppage').click(function() {
    if ($('#logrecordpage').is(':checked') && $('#uploadbackuppage').is(':checked') && $('#logrecordbackuppage').is(':checked')) {
         $('#optionssmodule').prop('checked', true);
    }
});
</script>