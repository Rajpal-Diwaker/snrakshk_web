<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Snrakshk | Forgot Password</title>
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
        <p class="login-box-msg"><center><h4><b>Forgot Password</b></h4></center></p>
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
          <div class="row">
            <div class="col-xs-8">
             <a href="<?php echo base_url();?>web/Snrakshklog/login">Sign In</a>
          </div><!-- /.col -->
          <div class="col-xs-4">
          <input type="submit" name="submit" value="Send" style="width:99%; background-color: #062758; border-color: #062758; border: 1px solid transparent; color: #fff; padding: 7px;">        
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
            },
    message: {
              email: "Please fill the email id.",
              },

    submitHandler: function(form)
    {
      $.ajax({
            url: "<?php echo base_url()?>forgotprocess",
            type: 'POST',
            data:$("#login_form").serialize(),
            success: function(response)
            { 
              if (response == 1) 
              { 
                $('#logerror').html('A link has been sent to your registered email address.');
                $('#login_form')[0].reset();
              }
              else
              {
                $('#logerror').html('Please check email and try again');
                $('#login_form')[0].reset();
              }
              
              
            }
          }); 
    }
  });
});
</script>