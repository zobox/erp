<?php
$due = false;
if ($this->input->get('due')) {
    $due = true;
} ?>

<div class="content-body">
  <div class="card">
    <div class="card-header">
      <h4 class="card-title"> Pending job Work </h4>
      <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
      <div class="heading-elements">
        <ul class="list-inline mb-0">
          <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
          <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
          <li><a data-action="close"><i class="ft-x"></i></a></li>
        </ul>
      </div>
      <hr>
    </div>
    <div class="card-content">
      <div id="notify" class="alert alert-success" style="display:none;"> <a href="#" class="close" data-dismiss="alert">&times;</a>
        <div class="message"></div>
      </div>
      <div class="card-body pt-0">
        <table id="cgrtable" class="table table-striped table-bordered zero-configuration" cellspacing="0"
                       width="100%">
          <thead>
            <tr>
              <th>#</th>
              <th>Hindizo Product Name</th>
              <th>Category Name</th>
              <th>Product Code</th>
              <th>Serial No</th>
			  <th>Action</th>
            </tr>
          </thead>
		  
          <tbody>
		  	<?php 
		    /* 	$arr = array(
				array('h_product_name' => 'Pen Test','h_product_serial' => '1001', 'p_code' => 'pt1001','serail_no' => '12536','r_c'=>100,'p_c'=>100),
				array('h_product_name' => 'Pen Test1','h_product_serial' => '1002', 'p_code' => 'pt1002','serail_no' => '12537','r_c'=>100,'p_c'=>100),
				array('h_product_name' => 'Pen Test2','h_product_serial' => '1003', 'p_code' => 'pt1003','serail_no' => '12539','r_c'=>100,'p_c'=>100),
				array('h_product_name' => 'Pen Test3','h_product_serial' => '1004', 'p_code' => 'pt1004','serail_no' => '125376','r_c'=>100,'p_c'=>100));
			$arr = json_decode(json_encode($records)); */
			/*echo "<pre>";
			print_r($arr);
			echo "</pre>";*/
			$i = 1;
			foreach($records as $row){			
				echo '<tr><td>'.$i.'</td><td>'.$row->product_name.'</td><td>'.$row->category_name.'</td><td>'.$row->hsn_code.'</td><td>'.$row->serial.'</td><td><a href="'.base_url().'jobwork/pendingproduct/'.$row->id.'" class="btn btn-success btn-sm"><span class="fa fa-eye"></span> view</a></td></tr>';
				$i++;	
			}
		  ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
        $(document).ready(function () {
            //datatables
            $('#cgrtable').DataTable({responsive: true});
        });
    </script>
