<style type="text/css">
  .error{
    color:red;
  }
</style>
<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.16.0/jquery.validate.js"></script>
 <div class="container">
<div class="row">
<div class="col-sm-12">
<center><h1>Reset Password</h1></center>
<center><div id="changepassword"></div>
</div>
</div>
<?php 
$uid = $this->uri->segment(4);
$admintype = $this->uri->segment(5);
//$uid = convert_uudecode(base64_decode($id));
?>
<div class="row">
<div class="col-sm-6 col-sm-offset-3">
<form method="post" id="resetpassword" action="<?= base_url().'api/v1/Resetpass/changepassword/'.$uid.'/'.$admintype; ?>" autocomplete="off">
<input type="password" class="input-lg form-control" name="newpass" id="newpass" placeholder="New Password" autocomplete="off" minlength="6" required><br>
<!-- <input type="hidden" name="statuscode" value="<?= $statuscode;?>"><br> -->
<input type="password" class="input-lg form-control" name="conpass" id="conpass" placeholder="Confirm Password" autocomplete="off" minlength="6" required><br>
<input type="submit" class="col-xs-12 btn btn-primary btn-load btn-lg" data-loading-text="Changing Password..." value="Reset Password">
</form>
</div><!--/col-sm-6-->
</div><!--/row-->
</div>

<script>
  
  $(function(){

    $("#resetpassword").validate({

      rules: {
        newpass: "required",
        conpass: {
         equalTo: "#newpass"
         }
      },

      message: {
        newpass: "Please enter new password",
        conpass: "New password and Confirm password should be same."

      },

      submitHandler: function(form)
      {  
         //event.preventDefault();
         //form.submit(); 
      $.ajax({

          url: "<?php echo base_url().'web/Snrakshklog/reset/'.$uid.'/'.$admintype; ?>"
          ,
          type: 'POST',
          data:$("#resetpassword").serialize(),
          success: function(response){
           
            if(response == 1){
              
             $('#changepassword').html('Password Changed Successfully.');
              $('#resetpassword')[0].reset();
              }else{

              $('#changepassword').html('Please try again');
              $('#resetpassword')[0].reset();
            }

               }

        }); 

                         
      }


    });
  });
    

</script>