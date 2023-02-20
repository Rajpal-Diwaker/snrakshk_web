<!DOCTYPE html>
<html>
<head>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.js"></script>

    <style>
.label {
    padding: 11px 18px!important;
}
  
</style>
</head>
<body>


<section class="content-wrapper">
<div class="row">
	<div class="col-xs-12">
		<div class="box">
			<div class="box-header">
				<h3 class="box-title"><b>Change Password</b></h3>
			</div><!-- /.box-header -->
			<div class="box-body">
				<div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
					<div class="row">
						<div class="col-sm-6">
						  
						</div>
						<div class="col-sm-6">
						
						</div>
					</div>
					<div id="changepassword"></div>
				  <div class="row">
				  <div class="col-sm-12">

<form name="change_password" id="change_password" method="post" action="<?php echo base_url();?>web/Supervisor/changepasswordprocess">

<table class="table table-bordered table-striped dataTable" id="example1" role="grid" aria-describedby="example1_info">
							

<!-- <?php //echo form_open('admin/Admin_panel/changepassword',array('method' => 'post', 'name' => 'change_password' , 'id' => 'change_password' ));?> -->

 <tr><td>Old Password</td><td>
 <div class="form-group has-feedback">
 <input class="form-control" id="old_pass" name="old_pass" type="password" autofocus>
 </div>
</td></tr>

 <tr><td>New Password</td><td>
 <div class="form-group has-feedback">
<input class="form-control" id="new_pass" name="new_pass" type="password" autofocus>
 </div>
</td></tr>

 
 <tr><td>Confirm New Password</td><td>
 <div class="form-group has-feedback">
<input class="form-control" id="confirm_new_pass" name="confirm_new_pass" type="password" autofocus>

 </div>
</td></tr>
<tr><td>
<div>
   <input type="submit" name="submit" value="Submit" id="submit" class="btn btn-primary">           
             </div></td><td>
	
<div >
   <a href="<?php echo base_url();?>web/Supervisor/fieldinspectorlist"><input type="button" name="submit" value="Cancel" class="btn btn-primary">
   </a>

					  	
					</div></td></tr>


</table>
</form>


				  </div>
				</div>
			</div><!-- /.box-body -->
		</div>
	</div>
</div>
</section>
</body>
</html>
<script>
  
  $(function(){

    $("#change_password").validate({

      rules: {
        old_pass: "required",
        new_pass: "required",
        confirm_new_pass: {
equalTo: "#new_pass"
}
      },

      message: {
        old_pass: "please enter old password",
        new_pass: "please enter new password",
        confirm_new_pass: "please enter confirm new password same new password"

      },

      submitHandler: function(form){  
         //event.preventDefault();
         //form.submit(); 

          $.ajax({

          url: "<?php echo base_url()?>web/Supervisor/changepasswordprocess",
          type: 'POST',
          data:$("#change_password").serialize(),
          success: function(response){
            
            if(response == 1){
              
             $('#changepassword').html('Password Change Successfully.');
         
              }else{

              $('#changepassword').html('Old Password incorrect. Please try again');
            }

               }

        }); 

                         
      }


    });
  });
    

</script>