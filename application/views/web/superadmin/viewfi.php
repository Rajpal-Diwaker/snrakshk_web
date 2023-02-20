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
        <h3 class="box-title"><b>Field Inspector</b></h3>
      </div><!-- /.box-header -->
      <div class="box-body">
        <div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
          <?php //echo "<pre>"; print_r($data);die;?>
          <div class="row">
            <div class="col-sm-6">
              <?php echo $data['area']['full_name'];?>
            </div>
            <div class="col-sm-6">
             <?php if ($data['area']['status'] == '1') {
               echo "Active";
             }
             else
              {
                echo "Deactive";
              }?>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-6">
              Inspection Status
            </div>
            <div class="col-sm-6">
             <span>Pending :<?php if (!empty($data['total_pendding']['pending'])) {
               echo $data['total_pendding']['pending'];
             }else{ echo "0"; }?></span><br><span>Completed : <?php echo $data['total_completed']['completed'];?></span>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-6">
              Area
            </div>
            <div class="col-sm-6">
             <?php echo $data['area']['area'];?>
            </div>
          </div>
          <div id="message"><?php echo $this->session->flashdata('message_name');?></div>
          <div class="row">
          <div class="col-sm-12">

<div class="col-sm-12"><h1 align="center"><strong>Assigned Consumers</strong></h1></div>
<table class="table table-bordered table-striped dataTable" role="grid" aria-describedby="example1_info">
  <thead>
              <tr role="row">
              <th>S.No</th>
              <th>Consumer Name</th>
              <th>Inspection Completed</th>
              </tr>
            </thead>
            <tbody id="mysearchdata"> 

            <?php $i=0; ?>            
            <?php foreach($data['consumerdata'] as $data){
             
             ?>
              <?php $i++; ?>
                <tr role="row" class="odd">
                  <td class="sorting_1"><?php echo $i; ?></td>
                  <td><?php  echo $data['full_name']; ?></td>
                  <td><?php  if ($data['status'] == '1' || $data['status'] == '0') 
                      {
                        echo "Pending";
                      } 
                      else
                      {
                        echo "completed";
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
      </div><!-- /.box-body -->
    </div>
  </div>
</div>
</section>
</body>
</html>
