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
        <h3 class="box-title"><b>Company Head</b></h3>
      </div><!-- /.box-header -->
      <div class="box-body">
        <div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
          <div class="row">
            <div class="col-sm-6">
              
            </div>
            <div class="col-sm-6">
            <?php //echo "<pre>"; print_r($data);die; ?>
            </div>
          </div>
          <div id="message"><?php echo $this->session->flashdata('message_name');?></div>
          <div class="row">
          <div class="col-sm-12">

<form name="addcompanyhead" id="addcompanyhead" method="post" action="<?php echo base_url()?>web/Superadmin/editcompanyheadprocess">

<table class="table table-bordered table-striped dataTable" id="example1" role="grid" aria-describedby="example1_info">
  <input id="company_head_id" name="company_head_id" type="hidden" value="<?php echo $data['company_head_id'];?>" autofocus>
 <tr><td>Full Name</td><td>
 <div class="form-group has-feedback">
 <input class="form-control" id="fullname" name="fullname" type="text" readonly value="<?php echo $data['full_name'];?>" autofocus>
 </div>
 <div id="fullname-error"></div>
</td></tr>

 <tr><td>Address</td><td>
 <div class="form-group has-feedback">
 <input class="form-control" id="address" name="address" type="text" readonly value="<?php echo $data['address']; ?>" autofocus>
 </div>
 <div id="address-error"></div>
</td></tr>

 <tr><td>Aadhar No.</td><td>
 <div class="form-group has-feedback">
 <input class="form-control" id="aadhar_number" name="aadhar_number" readonly type="text" value="<?php echo $data['aadhar_number']; ?>" autofocus>
 </div>
 <div id="aadhar_number-error"></div>
</td></tr>

<tr><td>Employee Id</td><td>
 <div class="form-group has-feedback">
 <input class="form-control" id="employee_id" name="employee_id" readonly type="text" value="<?php echo $data['employee_id']; ?>" autofocus>
 </div>
 <div id="employee_id-error"></div>
</td></tr>

<tr><td>Email</td><td>
 <div class="form-group has-feedback">
 <input class="form-control" id="email" name="email" type="text" readonly value="<?php echo $data['email']; ?>" autofocus>
 </div>
 <div id="email-error"></div>
</td></tr>


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
