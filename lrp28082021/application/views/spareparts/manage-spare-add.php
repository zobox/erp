<div class="app-content content container-fluid">
  <div class="content-wrapper">
    <div class="content-header row"> </div>
    <div class="content-body">
      <?php if ($this->session->flashdata("messagePr")) { ?>
      <div class="alert alert-info"> <?php echo $this->session->flashdata("messagePr") ?> </div>
      <?php } ?>
      <div class="card card-block">
        <div class="card-content">
                <div id="notify" class="alert alert-warning" style="display:none;"> <a href="#" class="close" data-dismiss="alert">×</a>
                  <div class="message" id="msg"></div>
                </div>
                <div class="card-header p-0">
                  <h4 class="card-title">  Products </h4>
                  <hr>
                  <div class="card-body px-0">
                      <table class="table table-striped table-bordered zero-configuration dataTable" id="cgrtable">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>WarehouseID</th>
                          <th>Name</th>
                          <th>Stock</th>
                          <th>ZUPC Code</th>
                          <th> Settings</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        $k=1;
                        $i=0;
                        $twid = $warehouse['id'];

                        for($i;$i<count($result);$i++)
                        {
                            
                        
                        ?>
                        <tr>
                          <td><?=$k++?></td>
                          <td>New Spareparts(<?=$warehouse['title']?>)</td>
                          <td><?php echo $result[$i]->product; ?> </td>
                          <td><?php echo $qty[$i]; ?></td>
                          <td><?php echo $result[$i]->warehouse_product_code; ?></td>
                          <td>
                            <a class="btn btn-success btn-sm  view-object text-white"><span class="fa fa-eye"></span> View</a> 
                            <a href="<?php echo base_url('spareparts/spare_more_details?pid=' . $result[$i]->component_id . '&wid='.$twid) ?>" class="btn btn-primary btn-sm  ">
                              <span class="fa fa-eye"></span> More Details</a>
                          </td>
                        </tr>
                      <?php } ?>
                      </tbody>
                      <tfoot>
                        <tr>
                          <th>#</th>
                          <th>WarehouseID</th>
                          <th>Name</th>
                          <th>Stock</th>
                          <th>ZUPC Code</th>
                          <th> Settings</th>
                        </tr>
                      </tfoot>
                    </table>
                  </div>
                </div>
              </div>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
        $(document).ready(function () {

            //datatables
            $('#cgrtable').DataTable({
                responsive: true,
                "columnDefs": [
                    {
                        "targets": [0],
                        "orderable": true,
                    },
                ], dom: 'Blfrtip',
                buttons: [
                    {
                        extend: 'excelHtml5',
                        footer: true,
                        exportOptions: {
                            columns: [1, 2, 3, 4]
                        }
                    }
                ],

        });
        });
    </script>


