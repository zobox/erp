<style>
	table tr td,th{ text-align:center;}
</style>
<div class="app-content content container-fluid">
  <div class="content-wrapper">
    <div class="content-header row"> </div>
    <div class="content-body">
      <?php if ($this->session->flashdata("messagePr")) { ?>
      <div class="alert alert-info"> <?php echo $this->session->flashdata("messagePr") ?> </div>
      <?php } ?>
      <div class="card card-block">
        <div class="box-header with-border">
          <h3 class="box-title" style="text-align:center"><?php echo $this->lang->line('Comission Wallet') ?></h3>
          <p style="text-align:center"><strong><?php echo $this->lang->line('Current Commission Wallet Balance') ?> &#8377; 1,600,710.00</strong><br>
          </p>
          <table id="invoices" class="cell-border example1 table table-striped table1 delSelTable">
            <thead>
              <tr>
                <th>#</th>
                <th><?php echo $this->lang->line('Commission Amount') ?></th>
                <th><?php echo $this->lang->line('Commission Invoice No') ?></th>
                <th><?php echo $this->lang->line('Commission Invoice Amount') ?></th>
                <th><?php echo $this->lang->line('Date') ?></th>
                <th class="no-sort"><?php echo $this->lang->line('Commission Settings') ?></th>
              </tr>
            </thead>
			<?php 
				$arr = array( array('id' => 1, 'c_amount' => 1200, 'c_invoice_no' => 'Invoice001', 'c_invoice_amount' => 12000, 'c_date' => date("d M, Y")), array('id' => 2, 'c_amount' => 1300, 'c_invoice_no' => 'Invoice002', 'c_invoice_amount' => 13000, 'c_date' => date("d M, Y")), array('id' => 3, 'c_amount' => 1400, 'c_invoice_no' => 'Invoice003', 'c_invoice_amount' => 14000, 'c_date' => date("d M, Y")), array('id' => 4, 'c_amount' => 1500, 'c_invoice_no' => 'Invoice004', 'c_invoice_amount' => 15000, 'c_date' => date("d M, Y")), array('id' => 5, 'c_amount' => 1600, 'c_invoice_no' => 'Invoice005', 'c_invoice_amount' => 16000, 'c_date' => date("d M, Y"))); $arr = json_decode(json_encode($arr));
				
			?>
            <tbody>
				<?php 
					$i = 1;
					foreach($arr as $row){
						echo "<tr>
							<td> ".$i." </td>
							<td> ".$row->c_amount." </td>
							<td> #".$row->c_invoice_no." </td>
							<td> ".$row->c_invoice_amount." </td>
							<td> ".$row->c_date." </td>
							<td> <a href='commission_wallet/view/".$row->id."' class='btn btn-primary btn-sm'> view </a> </td>
						</tr>";
					$i++;
					}
				?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
