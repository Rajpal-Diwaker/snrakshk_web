<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Snrakshk | Log in</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>temp/bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>temp/dist/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>temp/dist/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>temp/dist/css/AdminLTE.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>temp/dist/css/magnific-popup.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>temp/plugins/iCheck/square/blue.css">
  
    <script src="<?php echo base_url(); ?>temp/dist/js/jquery.min.js"></script>
    <script src="<?php echo base_url(); ?>temp/dist/js/jquery.validate.js"></script>

  </head>
<style>
img {
    height: 94px;
    }
</style>
  <body class="hold-transition login-page">
    <div class="login-box">
      <div class="login-logo">
      </div><!-- /.login-logo -->
      <div class="login-box-body">
      <div id="logerror"></div>
        <p class="login-box-msg"><center><h4><b>Sign In</b></h4></center></p>
        <form action="" method="post" name="login_form" id="login_form">
          <div class="form-group has-feedback">
            <div id="disp"></div>
          </div>
          <div class="form-group has-feedback">
            <select class="form-control" id="admintype" name="admintype">
              <option value="">---Select Admin Type---</option>
              <option value="superadmin">Super Admin</option>
              <option value="companyhead">Company Head</option>
              <option value="reasonalhead">Reasonal Head</option>
              <option value="supervisor">Supervisor</option>

            </select>
            
          </div>
          <div class="form-group has-feedback">
            <input class="form-control" id="email" placeholder="Email" name="email" type="email" autofocus>
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback">
            <input class="form-control" id="id_password" placeholder="Password" name="password" type="password"  autofocus>
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
          </div>
          <div class="row">
            <div class="col-xs-8">
              <a href="<?php echo base_url();?>web/Snrakshklog/forgot">Forgot Password</a>
          </div><!-- /.col -->
          <div class="col-xs-4">
          <input type="submit" name="submit" value="Sign In" style="width:99%; background-color: #062758; border-color: #062758; border: 1px solid transparent; color: #fff; padding: 7px;">        
          </div><!-- /.col -->
        </div>
        </form>
      </div><!-- /.login-box-body -->
    </div><!-- /.login-box -->
</body>
</html>
 <script>
  $(function()
  {
    $("form[name='login_form']").validate({
    rules: {
            admintype: "required",
            email: {
                    required: true,
                    email: true 
                    },
            password: "required"
            },
    message: {
              admintype: "Please select admin type",
              email: "Please fill the email id.",
              password: "Please fill the password."
              },

    submitHandler: function(form)
    {
      $.ajax({
            url: "<?php echo base_url()?>loginprocess",
            type: 'POST',
            data:$("#login_form").serialize(),
            success: function(response)
            { 
              console.log(response)
              
              if(response == "superadmin")
              {
                window.location.href = "<?php echo base_url().'web/Superadmin/companyheadlist'; ?>";
              }
              else if(response == "supervisor")
              {
                window.location.href = "<?php echo base_url().'web/Supervisor/fieldinspectorlist'; ?>";
              }
              else if(response == "reasonalhead")
              {
                window.location.href = "<?php echo base_url().'web/Reasonalhead/supervisorlist'; ?>";
              }
              else if(response == "companyhead")
              {
                window.location.href = "<?php echo base_url().'web/Companyhead/reasonalheadlist'; ?>";
              }
              else
              {
                $('#logerror').html('Username or Password incorrect. Please try again');
              }
            }
          }); 
    }
  });
});
</script>