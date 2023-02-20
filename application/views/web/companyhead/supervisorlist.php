<style>
.label {
    padding: 11px 18px!important;
}

	
</style>
<!DOCTYPE html>
<html>
<head>
	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.js"></script>
    <script type="text/javascript">
    	function deletepro(){
    		var con = confirm("Are you really want to deactivate account.");
    		if(con){
    			return true;
    		}else{
    			return false;
    		}
    	}
    </script>
</head>
<body>



<?php  //echo "<pre>";print_r($datas); die;?>
<section class="content-wrapper">
<div class="row">
	<div class="col-xs-12">
		<div class="box">
			<div class="box-header">
				<h3 class="box-title"><b>Supervisor List</b></h3>
			</div>
			
			<div class="box-body">
				<div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
					<div class="row">
						<div class="col-sm-2">
						  <a href="<?php echo base_url();?>web/Companyhead/addsupervisor"><p style="border: 1px solid;width: 173px;padding: 8px;background: #062758;color: white;border-color: #062758;border-radius: 4px;text-align: center;">Add Supervisor</p></a>
						</div>
						<div class="col-sm-5">
						
						</div>
						<div class="col-sm-5">
						
						</div>
					</div>
				  <div class="row">
				  <div class="col-sm-12">
<table class="table table-bordered table-striped dataTable" id="example1" role="grid" aria-describedby="example1_info">
						<thead>
						  <tr role="row">
							<th>S.No</th>
							<th>Supervisor Name</th>
							<th>Reasonal Head Name</th>
							<th>No. Of Field Inspector</th>
							<th>Assigned Consumers</th>
							<th>Inspection Completed</th>
							<th>View</th>
							<th>Edit</th>
							<th>Action</th>
							
						  </tr>
						</thead>
						<tbody id="mysearchdata"> 

						<?php $i=0; ?>						
						<?php foreach($datas as $data){
						 
						 ?>
							<?php $i++; ?>
								<tr role="row" class="odd">
									<td class="sorting_1"><?php echo $i; ?></td>
									<td><?php  echo $data['supervisor_name']; ?></td>
									<td><?php  echo $data['reasonal_head_name']; ?></td>
									<td><?php  echo $data['total_field_inspector']; ?></td>
									<td><?php  echo $data['total_consumer'];?></td>
									<td>0</td>
									<td><a class="btn btn-success" href="<?php echo base_url()?>web/Companyhead/viewsupervisor?id=<?php echo $data['supervisor_id'];?>">View</a>
									</td>
									<td>
										<a class="btn btn-success" href="<?php echo base_url()?>web/Companyhead/editsupervisor?id=<?php echo $data['supervisor_id'];?>">Edit</a>
									</td>
									<td>
										<?php 
										if ($data['status'] == '1') 
										{
										?>
											<a class="btn btn-danger" href="<?php echo base_url()?>web/Companyhead/endissupervisor?id=<?php echo $data['supervisor_id'];?>&status=0" style="background:#f4930a; border:0px;" onclick="return deletepro()">Disable</a>
										<?php 
									}else{
										?>
										<a class="btn btn-success" href="<?php echo base_url()?>web/Companyhead/endissupervisor?id=<?php echo $data['supervisor_id'];?>&status=1">Enable</a>
										<?php
									}
										 ?>
										</td>
									
								</tr>
						<?php } 
						 ?>
					   </tbody>
					  </table>
					  	
					</div>
				  </div>
				</div>
			</div><!-- /.box-body -->
		</div>
	</div>
</div>
</section>

