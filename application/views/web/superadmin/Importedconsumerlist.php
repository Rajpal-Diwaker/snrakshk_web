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
				<h3 class="box-title"><b>Field Consumer List</b></h3>
			</div>
			
			<div class="box-body">
				<div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
					<div class="row">
						<div class="col-sm-2">
						<form method="post" action="<?php echo base_url('web/Superadmin/mergeConsumer'); ?>">
						  <input type="submit" value="Merge consumer"  style="border: 1px solid;width: 173px;padding: 8px;background:
						   #062758;color: white;border-color: #062758;border-radius: 4px;
						   text-align: center;"/>
						   </form>
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
							<th>Consumer No</th>
							<th>Consumer Connection No</th>
							<th>Consumer Name</th>
							<th>Phone </th>						
							<th>Address</th>
							<th>Dist Code</th>
							<th>City</th>
							<th>Area Name</th>
							<!-- <th>View</th> -->
							<!-- <th>Edit</th> -->
							<!-- <th>Action</th>							 -->
						  </tr>
						</thead>
						<tbody id="mysearchdata"> 

						<?php $i=0; ?>						
						<?php foreach($datas as $data){
						 
						 ?>
							<?php $i++; ?>
								<tr role="row" class="odd">
									<td class="sorting_1"><?php echo $i; ?></td>
									<td><?php echo $data['CONS_ID'];?></td>
									<td><?php echo $data['CONS_NO'];?></td>
									<td><?php echo $data['CONS_NAME'];?></td>
									<td><?php  echo $data['MOBILE']; ?></td>
									<td><?php  echo $data['ADDRESS']; ?></td>	
									<td><?php  echo $data['DIST_CODE']; ?></td>	
									<td><?php  echo $data['CONS_CITY']; ?></td>	
									<td><?php  echo $data['AREA_NAME']; ?></td>									
									<!-- <td><a class="btn btn-success" href="<?php echo base_url()?>web/Superadmin/viewfi?id=<?php echo $data['consumer_id'];?>">View</a> -->
									</td>
									<!-- <td>
										<a class="btn btn-success" href="<?php echo base_url()?>web/Superadmin/editfi?id=<?php echo $data['consumer_id'];?>">Edit</a>
									</td> -->
									<!-- <td>
										<?php 
										if ($data['status'] == '1') 
										{
										?>
											<a class="btn btn-danger" href="<?php echo base_url()?>web/Superadmin/endisfieldinspector?id=<?php echo $data['field_inspector_id'];?>&status=0" style="background:#f4930a; border:0px;" onclick="return deletepro()">Disable</a>
										<?php 
									}else{
										?>
										<a class="btn btn-success" href="<?php echo base_url()?>web/Superadmin/endisfieldinspector?id=<?php echo $data['field_inspector_id'];?>&status=1">Enable</a>
										<?php
									}
										 ?> -->
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

