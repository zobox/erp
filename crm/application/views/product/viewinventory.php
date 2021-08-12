<div class="app-content content container-fluid">
  <div class="content-wrapper">
    <div class="content-header row"> </div>
    <div class="content-body">
      <?php if ($this->session->flashdata("messagePr")) { ?>
      <div class="alert alert-info"> <?php echo $this->session->flashdata("messagePr") ?> </div>
      <?php } ?>
      <div class="card card-block">
        <div class="box-header with-border">
          <h3 class="box-title">Product Inventory</h3>
          <p><br>
          </p>
          <div id="invoices_wrapper" class="dataTables_wrapper">
            <div class="dataTables_length" id="invoices_length">
              <label>Show
              <select name="invoices_length" aria-controls="invoices" class="">
                <option value="10">10</option>
                <option value="25">25</option>
                <option value="50">50</option>
                <option value="100">100</option>
              </select>
              entries</label>
            </div>
            <div id="invoices_filter" class="dataTables_filter">
              <label>Search:
              <input type="search" class="" placeholder="" aria-controls="invoices">
              </label>
            </div>
            <div id="invoices_processing" class="dataTables_processing" style="display: none;">Processing...</div>
            <div class="table-responsive">
			<table id="invoices" class="cell-border example1 table table-striped table1 delSelTable dataTable" role="grid" aria-describedby="invoices_info" style="width: 945px;">
              <thead>
              <tr role="row">
            <!--    <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 2px;" aria-label="#">#</th> -->
                <th class="sorting" tabindex="0" aria-controls="productstable" rowspan="1" colspan="1" style="width: 80px;" aria-label="Name: activate to sort column ascending">Name</th>
            <!--<th class="sorting" tabindex="0" aria-controls="productstable" rowspan="1" colspan="1" style="width: 15px;" aria-label="Qty: activate to sort column ascending">Qty</th> -->
            <th class="sorting" tabindex="0" aria-controls="productstable" rowspan="1" colspan="1" style="width: 5px;" aria-label="Code: activate to sort column ascending">S.No.</th>
            <!--    <th class="sorting" tabindex="0" aria-controls="productstable" rowspan="1" colspan="1" style="width: 85px;" aria-label="Category: activate to sort column ascending">Category</th> -->
            <!--   <th class="sorting" tabindex="0" aria-controls="productstable" rowspan="1" colspan="1" style="width: 64px;" aria-label="Warehouse: activate to sort column ascending">Warehouse</th> -->
                <th class="sorting" tabindex="0" aria-controls="productstable" rowspan="1" colspan="1" style="width: 50px;" aria-label=" Price: activate to sort column ascending"> Price</th>
                <th class="sorting" tabindex="0" aria-controls="productstable" rowspan="1" colspan="1" style="width: 90px;" aria-label="Settings: activate to sort column ascending">Settings</th>
              </tr>
            </thead>
              <tbody>
			  
			  <?php 
			  /* echo "<pre>";
			  print_r($product);
			  echo "</pre>";  
			  
			  print_r($warehouse);
			  $burl = base_url();
			  $baseurl_array = explode('crm', $burl);
			  echo $baseurl_array[0]; */
			  
			  //print_r($warehouse);
			  
			  foreach($product as $key=>$row){
			  ?>
              <tr role="row" class="odd">
                <td tabindex="0">1</td>
                <td><a href="#" data-object-id="41" class="view-object"><span class="avatar-lg align-baseline"><img src="http://localhost/zobox/userfiles/product/thumbnail/default.png"></span>&nbsp;<?php echo $row->product_name; ?></a></td>
                <td><?php echo $row->avlqty; ?></td>
                <td><?php echo $row->product_code; ?></td>
                <td><?php echo $row->category; ?></td>
                <td><?php echo $warehouse->title; ?></td>
                <td><?php echo $row->sale_price; ?></td>
                <td><a href="#" data-object-id="41" class="btn btn-success  btn-sm  view-object"><span class="fa fa-eye"></span> View</a>
                  <div class="btn-group">
                    <button type="button" class="btn btn-indigo dropdown-toggle btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-print"></i> Print</button>
                    <div class="dropdown-menu"> <a class="dropdown-item" href="<?php $baseurl_array[0]; ?>products/barcode?id=<?php echo $row->pid; ?>" target="_blank"> BarCode</a>
                      <div class="dropdown-divider"></div>
                      <a class="dropdown-item" href="#id=41" target="_blank"> BarCode - Compact</a>
                      <div class="dropdown-divider"></div>
                      <a class="dropdown-item" href="#id=41" target="_blank"> Label</a>
                      <div class="dropdown-divider"></div>
                      <a class="dropdown-item" href="#id=41" target="_blank"> Label - Compact</a></div>
                  </div>
              <!--    <a class="btn btn-pink  btn-sm" href="#id=41" target="_blank"> <span class="fa fa-pie-chart"></span> Reports</a>-->
                  <div class="btn-group">
                    <button type="button" class="btn btn btn-primary dropdown-toggle   btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="fa fa-cog"></i> </button>
                    <div class="dropdown-menu"> &nbsp;<a href="#id=41" class="btn btn-purple btn-sm"><span class="fa fa-edit"></span>Edit</a>
                      <div class="dropdown-divider"></div>
                       <a href="#" data-object-id="41" class="btn btn-danger btn-sm  delete-object"><span class="fa fa-trash"></span>Delete</a> </div>
                  </div></td>
              </tr>
			  <?php } ?>
			  
              <!--<tr role="row" class="even">
                <td tabindex="0">10</td>
                <td><a href="#" data-object-id="1" class="view-object"><span class="avatar-lg align-baseline"><img src="http://15.206.89.124/zobox/userfiles/product/thumbnail/default.png"></span>&nbsp;Bottle</a></td>
                <td>0</td>
                <td>Test VAriation</td>
                <td>4g Phones</td>
                <td>Master Warehouse</td>
                <td>? 0.00</td>
                <td><a href="#" data-object-id="1" class="btn btn-success  btn-sm  view-object"><span class="fa fa-eye"></span> View</a>
                  <div class="btn-group">
                    <button type="button" class="btn btn-indigo dropdown-toggle btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-print"></i> Print</button>
                    <div class="dropdown-menu"> <a class="dropdown-item" href="#id=1" target="_blank"> BarCode</a>
                      <div class="dropdown-divider"></div>
                      <a class="dropdown-item" href="#id=1" target="_blank"> BarCode - Compact</a>
                      <div class="dropdown-divider"></div>
                      <a class="dropdown-item" href="#id=1" target="_blank"> Label</a>
                      <div class="dropdown-divider"></div>
                      <a class="dropdown-item" href="#id=1" target="_blank"> Label - Compact</a></div>
                  </div>
                  <a class="btn btn-pink  btn-sm" href="#id=1" target="_blank"> <span class="fa fa-pie-chart"></span> Reports</a>
                  <div class="btn-group">
                    <button type="button" class="btn btn btn-primary dropdown-toggle   btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="fa fa-cog"></i> </button>
                    <div class="dropdown-menu"> &nbsp;<a href="#id=1" class="btn btn-purple btn-sm"><span class="fa fa-edit"></span>Edit</a>
                      <div class="dropdown-divider"></div>
                       <a href="#" data-object-id="1" class="btn btn-danger btn-sm  delete-object"><span class="fa fa-trash"></span>Delete</a> </div>
                  </div></td>
              </tr>-->
			  
            </tbody>
              
            </table>
			</div>
            <div class="dataTables_info" id="invoices_info" role="status" aria-live="polite"></div>
            <div class="dataTables_paginate paging_simple_numbers" id="invoices_paginate"><a class="paginate_button previous disabled" aria-controls="invoices" data-dt-idx="0" tabindex="0" id="invoices_previous">Previous</a><span><a class="paginate_button current" aria-controls="invoices" data-dt-idx="1" tabindex="0">1</a></span><a class="paginate_button next disabled" aria-controls="invoices" data-dt-idx="2" tabindex="0" id="invoices_next">Next</a></div>
          </div>
          
        </div>
      </div>
    </div>
  </div>
</div>
