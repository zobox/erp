<?php
$due = false;
if ($this->input->get('due')) {
    $due = true;
} ?>
<div class="content-body">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title"> Manage job Work </h4>
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
            <div id="notify" class="alert alert-success" style="display:none;">
                <a href="#" class="close" data-dismiss="alert">&times;</a>

                <div class="message"></div>
            </div>
            <div class="card-body pt-0">

                <table id="cgrtable" class="table table-striped table-bordered zero-configuration table-responsive" cellspacing="0" style="border:none;">
                    <thead>
                    <tr>
                        <th width="10%">#</th>
                        <th width="15%">Hindizo Product Name</th>
						<th width="15%">Product Code</th>
                        <th width="15%">Serial No</th>
                        <th width="15%">Previous Condition</th>
						<th width="1%">Current Condition</th>
                        <th width="17%">Action</th>


                    </tr>
                    </thead>
                    <tbody>
                        <?php 
           
							$i = 1;
							foreach($records as $key=>$row){
								switch($row->previous_condition){
									case 1: $prv = 'Ok';
									break;
									case 2: $prv = 'Good';
									break;
									case 3: $prv = 'Superb';
									break;
								}
								
								
								switch($row->new_condition){
									case 1: $new = 'Ok';
									break;
									case 2: $new = 'Good';
									break;
									case 3: $new = 'Superb';
									break;
								}
								
								
								echo '<tr><td>'.$i.'</td><td>'.$row->product_name.'</td><td>'.$row->hsn_code.'</td><td>'.$row->serial.'</td><td>'.$prv.'</td><td>'.$new.'</td><td><a href="'.base_url().'jobwork/manage_product/'.$row->serial_id.'" class="btn btn-success btn-sm">view</a></td></tr>';
								$i++;   
							}
						?>
                    </tbody>
                    <tfoot>
                    <tr>
                        <th width="10%">#</th>
                        <th width="15%">Hindizo Product Name</th>
                        <th width="15%">Product Code</th>
                        <th width="15%">Serial No</th>
                        <th width="15%">Previous Condition</th>
                        <th width="1%">Current Condition</th>
                        <th width="17%">Action</th>


                    </tr>
                    </tfoot>
                    
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