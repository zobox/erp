<?php  		
	foreach($code as $key=>$serial){ 
	if($serial<=13){
		$ctype = 'EAN13';
	}elseif($serial>13 && $serial<=39){
		$ctype = 'C39';
	}elseif($serial>39){
		$ctype = 'C128A';
	}	
	
	$product = explode('-',$serial_details[0]->product_name);
	//print_r($product); exit;
	?>

<!DOCTYPE html>
<html>
<head>
<title>Page Title</title>
<style>
    th, td {
  white-space: nowrap;
}
</style>
</head>
<body>

<table style="border:1px solid #000;width: 377px;height: 377px;border-radius: 4px;padding:2px 5px; margin-bottom: 0px;">
<thead>
            <tr>
              <td style="font-size: 16px;font-weight: 600;font-family: arial;text-align: center;padding:0px;border:none;width:30%;">
			  <img src="<?php echo base_url();?>assets/images/bar.png" style="width: 50px;">
			  <?php echo $serial_details[0]->sticker_no; ?>
			  </td>
              <td style="font-size: 16px;font-weight: 600;font-family: arial;text-align: center;padding:0px;border:none;">
			  <!--<img src="<?php echo base_url();?>assets/images/barcode.png" style="width:100%;">-->
			  <barcode type="<?= $ctype ?>" code="<?= $name[0] ?>" text="1" class="barcode" height="2" style="width:100%;"/></barcode>
			  <br><?= $name[0] ?>
			  </td>
			  
            </tr>
          </thead>
          <tbody>
            <tr style="padding:0px;">
              <td style="font-size: 16px;vertical-align: top;font-weight: bold;padding:0px !important;">Product Name :</td>
              <td style="font-size: 16px;vertical-align: top;padding:0px !important;"><?php echo $product[0] ?></td>
            </tr>
            <tr style="padding:0px;">
              <td style="font-size: 16px;vertical-align: top;font-weight: bold;padding:0px !important;">Variant :</td>
              <td style="font-size: 16px;vertical-align: top;padding:0px !important;"><?php echo $product[2] ?></td>
            </tr>
            <tr style="padding:0px;">
              <td style="font-size: 16px;vertical-align: top;font-weight: bold;padding:0px !important;">Color :</td>
              <td style="font-size: 16px;vertical-align: top;padding:0px !important;"><?php echo $product[3] ?></td>
            </tr>
            <tr style="padding:0px;">
              <td style="font-size: 16px;vertical-align: top;font-weight: bold;padding:0px !important;">PO #</td>
              <td style="font-size: 16px;vertical-align: top;padding:0px !important;"><?php echo 'MRG_PO#'.$serial_details[0]->tid; ?></td>
            </tr>
            <tr style="padding:0px;">
              <td style="font-size: 16px;vertical-align: top;font-weight: bold;padding:0px !important;">Qc Engineer</td>			  
              <td style="font-size: 16px;vertical-align: top;padding:0px !important;"><?php echo $serial_details[0]->qc_engineer; ?>
       </td></tr>
       <tr style="padding:0px;">
              <td style="font-size: 16px;vertical-align: top;font-weight: bold;padding:0px !important;">IMEI 1</td>
            
              <td style="font-size: 16px;vertical-align: top;padding:0px !important;">
       </td></tr>
       <tr style="padding:0px;">
              <td style="font-size: 16px;vertical-align: top;font-weight: bold;padding:0px;text-align:center;" colspan="2">
			  <!--<img src="<?php echo base_url();?>assets/images/barcode.png" style="width:100%;">-->
			  <barcode type="<?= $ctype ?>" code="<?= $serial ?>" text="1" class="barcode" height="2" style="width:100%;"/></barcode>
			
			 </td>
            
        </tr>
		<tr>
		<td colspan="2" style="text-align:center;">
		<?= $serial ?>
		</td>
		</tr>
          </tbody>
        </table>
</body>
</html>
<?php } ?>