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
        <h3 class="box-title"><b>Edit Supervisor</b></h3>
      </div><!-- /.box-header -->
      <div class="box-body">
        <div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
          <div class="row">
            <div class="col-sm-6">
              
            </div>
            <div class="col-sm-6">
            <?php //echo "<pre>"; print_r($data);die;?>
            </div>
          </div>
          <div id="message"><?php echo $this->session->flashdata('message_name');?></div>
          <div class="row">
          <div class="col-sm-12">

<form name="addcompanyhead" id="addcompanyhead" method="post" action="<?php echo base_url()?>web/Companyhead/editsupervisorprocess">

<table class="table table-bordered table-striped dataTable" id="example1" role="grid" aria-describedby="example1_info">
  <input id="supervisor_id" name="supervisor_id" type="hidden" value="<?php echo $data['supervisor_id']; ?>" autocomplete="off">
 <tr><td>Full Name</td><td>
 <div class="form-group has-feedback" style="float: left;">
 <input class="form-control" id="fullname" name="fullname" type="text" maxlength="50" value="<?php echo $data['full_name']; ?>" autocomplete="off">
 </div>
 <div id="fullname-error" style="float: left; margin-left: 10px;"></div>
</td></tr>

 <tr><td>Address</td><td>
 <div class="form-group has-feedback" style="float: left;">
 <input class="form-control" id="address" name="address" type="text" value="<?php echo $data['address']; ?>" autocomplete="off">
 </div>
 <div id="address-error" style="float: left; margin-left: 10px;"></div>
</td></tr>

 <tr><td>Aadhar No.</td><td>
 <div class="form-group has-feedback" style="float: left;">
 <input class="form-control" id="aadhar_number" name="aadhar_number" type="text" maxlength="13" value="<?php echo $data['aadhar_number']; ?>" autocomplete="off">
 </div>
 <div id="aadhar_number-error" style="float: left; margin-left: 10px;"></div>
</td></tr>

<tr><td>Employee Id</td><td>
 <div class="form-group has-feedback" style="float: left;">
 <input class="form-control" id="employee_id" name="employee_id" type="text" maxlength="6" value="<?php echo $data['employee_id']; ?>" autocomplete="off">
 </div>
 <div id="employee_id-error" style="float: left; margin-left: 10px;"></div>
</td></tr>

<tr><td>Reasonal Head</td><td>
 <div class="form-group has-feedback" style="float: left;">
 <select id="reasonal_head" name="reasonal_head">
   <option value="<?php echo $data['reasonal_head']; ?>" selected><?php echo $data['reasonal_head_name']; ?></option>
   <?php 
   foreach ($reasonalheads as $key => $value) 
   {  
    if ($value['full_name'] != $data['reasonal_head_name']) 
    {
    ?>
    <option value="<?php echo $value['reasonal_head_id'];?>"><?php echo $value['full_name'];?> </option>   
   <?php
    }
   } 
   ?>
 </select>
 </div>
 <div id="reasonal_head-error" style="float: left; margin-left: 10px;"></div>
</td></tr>

<tr><td>Email</td><td>
 <div class="form-group has-feedback" style="float: left;">
 <input class="form-control" id="email" name="email" type="text" value="<?php echo $data['email']; ?>" autocomplete="off">
 </div>
 <div id="email-error" style="float: left; margin-left: 10px;"></div>
</td></tr>

<tr><td>
<div>
   <input type="submit" name="submit" value="Save" id="submitt" style="width:37%; background-color: #062758; border-color: #062758; border: 1px solid transparent; color: #fff; padding: 7px;">           
</div></td>
</tr>


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
      $("#submitt").on("click", function(event){

        var filter = /^[0-9]+$/;    
        var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;    
        var formStatus = true;    
        
        if ($("#fullname").val() == "") 
        {      
          formStatus = false;      
          $("#fullname-error" ).text( "Please enter Full Name." ).show().fadeOut( 3000 );    
        }  

        if ($("#address").val() == "") 
        {      
          formStatus = false;      
          $("#address-error" ).text( "Please enter Address." ).show().fadeOut( 3000 );    
        } 

        if ($("#aadhar_number").val() == "") 
        {      
          formStatus = false;      
          $("#aadhar_number-error" ).text( "Please enter Aadhar no." ).show().fadeOut( 3000 );    
        }

        if ($("#aadhar_number").val() !== "" && !$.isNumeric($("#aadhar_number").val())) 
        {      
          formStatus = false;      
          $("#aadhar_number-error" ).text( "Please enter number not string." ).show().fadeOut( 3000 );    
        }  

        if ($("#employee_id").val() == "") 
        {      
          formStatus = false;      
          $("#employee_id-error" ).text( "Please enter Employee Id." ).show().fadeOut( 3000 );    
        } 

        if ($("#reasonal_head").val() == null) {
          formStatus = false;      
          $("#reasonal_head-error" ).text( "Please select Reasonal Head." ).show().fadeOut( 3000 ); 
        } 

        if ($("#email").val() == "") 
        {      
          formStatus = false;      
          $("#email-error" ).text( "Please enter Email." ).show().fadeOut( 3000 );    
        } 

        return formStatus;
      });
  });
    

</script>