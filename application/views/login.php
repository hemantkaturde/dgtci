<style>
.wrapper {
    width: 100vw;
    min-height: 100vh;
    background-color: #ccc;
    padding: 30px 15px;
    /* background: linear-gradient(45deg, #90d18566, #91c78866); */
    background-color: #63a4ff6b;
    /* background-image: linear-gradient(315deg, #63a4ff14 0%, #83eaf173 74%); */
    display: flex;
    align-items: center;
    justify-content: center;
}
.login {
    width: 100%;
    max-width: 400px;
    background-color: #fff;
    display: flex;
    /* border-radius: 10px; */
    overflow: hidden;
    box-shadow: 0 10px 30px -10px rgba(0, 0, 0, 0.4);
    /* background-color: rgba(255,255,255,.15); */
  /* backdrop-filter: blur(8px); */
  /* box-shadow: 0 12px 40px rgba(0,0,0,.5); */
}
.login .login-form {
    flex-grow: 1;
    flex-shrink: 0;
    flex-basis: auto;
    max-width: 100%;
    /* background-color: #fff; */
    padding: 60px 45px;
}
@media only screen and (max-width: 767.98px) {
    .login .login-form {
        max-width: 100%;
   }
}
@media only screen and (max-width: 575.98px) {
    .login .login-form {
        padding: 40px 20px;
   }
}
.login .login-form .login-title {
    font-family: 'Montserrat', sans-serif;  
    font-size: 3rem;
    color: #393939;
    margin-bottom: 25px;
}
.login .login-form .form-wrapper .input-wrapper .label, .login .login-form .form-wrapper .input-wrapper .input {
    display: block;
    width: 100%;
}
.login .login-form .form-wrapper .input-wrapper .label {
    padding-bottom: 3px;
    font-size: 1.5rem;
    display: flex;
    color: #393939;
}

.login .login-decoration {
  align-self: center;
}
@media only screen and (max-width: 767.98px) {
    .login .login-decoration {
        display: none;
   }
}

</style>
<html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>PARCELBHEJ ADMIN | Management panel Login</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
  <link href="<?php echo base_url(); ?>assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css"
  />
  <link href="<?php echo base_url(); ?>assets/dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
  <link rel="icon" href="https://example.com/favicon.png">
</head>
<body>
  
    <div class="wrapper">
        
    <div class="login">
    
    <div class="login-form">      
            <h1 class="login-title" style="color:#ccc; text-align:center"><b>ADMIN</b>
        <br><small>Management panel</small></h1>
        <?php $this->load->helper('form'); ?>
            <div class="form-wrapper">
            <div class="col-md-12">
              <?php echo validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?>
            </div>
            <?php
        $this->load->helper('form');
        $error = $this->session->flashdata('error');
        if($error)
        {
            ?>
            <div class="alert alert-danger alert-dismissable">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
          <?php echo $error; ?>
        </div>
        <?php }
        $success = $this->session->flashdata('success');
        if($success)
        {
            ?>
            <div class="alert alert-success alert-dismissable">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
          <?php echo $success; ?>
        </div>
        <?php } ?>
              <div class="input-wrapper" style="margin-bottom:30px">
              <form action="<?php echo base_url(); ?>loginMe" method="post">
                  <label class="label" for="email">Email Address</label>
                  <input type="text" class="form-control" placeholder="Email" name="email" required style="padding: 20px 12px;"/>
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                </div>
                <div class="input-wrapper" style="margin-bottom:30px">
                   <label class="label" for="password">Password</label>
                   <input type="password" class="form-control" placeholder="Password" name="password" required style="padding: 20px 12px;"/>
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                </div>
                <!-- <div class="action-help">
                  <a class="help-link" href="#">Forgot your password?</a>
                </div> -->
                <div class="actions" style="margin-top:10px;">
                  <input type="submit" class="btn btn-primary btn-block btn-flat" value="Login" />
                 
                </form>
              </div>

            </div>
          </div>
          
        </div>
      </div>
</body>
</html>