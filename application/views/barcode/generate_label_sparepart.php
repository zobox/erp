<?php 	
	if($serial_no1<=13){
		$ctype1 = 'EAN13';
	}elseif($serial_no1>13 && $serial<=39){
		$ctype1 = 'C39';
	}elseif($serial_no1>39){
		$ctype1 = 'C128A';
	}
	
	$component = explode('-',$component_details->component_name);
	
?>
	
<!DOCTYPE html>
<html>

<head>
  <title>Page Title</title>
  <style>
  th,
  td {
    white-space: nowrap;
  }
  
  #box {
    border-radius: 50px;
  }
  
  .barcode {
    width: 250px;
  }
  table td {
word-wrap:break-word;
white-space: normal;
}
  </style>
</head>

<body>
  
  
  
  
  <!--<h4>Accessories or sparepart label</h4>-->
  
  <?php for($i=1; $i<=$qty; $i++){ ?>
  <table style="border:1px solid #000;width: 350px;height: 200px;border-radius: 4px; margin-bottom: 0px;margin-top: 20px;">
    <tbody>
      <tr>
        <td style="font-size: 14px;font-weight: 600;font-family: arial;text-align: left;border:none;vertical-align: top;">
          <table>
            <tr style="padding:0px;">
              <td style="font-size: 11px;vertical-align: top;font-weight: bold;padding:0px 0px 0px !important;">Product Name :</td>
              <td style="font-size: 11px;vertical-align: top;padding:0px 0px 0px !important;"><?php echo $component[0]; ?></td>
            </tr>
            <tr style="padding:0px;">
              <td style="font-size: 11px;vertical-align: top;font-weight: bold;padding:0px 0px 0px !important;">Variant :</td>
              <td style="font-size: 11px;vertical-align: top;padding:0px !important;"><?php echo $component[1].'-'.$component[2].'-'.$component[3]; ?></td>
            </tr>
            
            
          </table>
        </td>
        <td style="font-size: 14px;font-weight: 600;font-family: arial;text-align: left;border:none;vertical-align: top;padding-top: 5px;">
          <table>
            <tr style="padding:0px;">
              <td style="font-size: 11px;vertical-align: top;font-weight: bold;padding:0px 0px 0px !important;">Color :</td>
              <td style="font-size: 11px;vertical-align: top;padding:0px 0px 0px !important;"><?php echo $component[5]; ?></td>
            </tr>
            <tr style="padding:0px;">
              <td style="font-size: 11px;vertical-align: top;font-weight: bold;padding:0px 0px 10px !important;">PO # :</td>
              <td style="font-size: 11px;vertical-align: top;padding:0px 0px 10px !important;"><?php echo $purchase_order; ?></td>
            </tr>
       
          </table>
        </td>
      </tr>
	  
	  <tr>
			<td colspan="2" style="border-top:1px solid #000;padding-top: 5px;vertical-align: middle;border-left: none;border-right: none;padding-bottom: 5px;text-align: center;">
			<strong style="display: block;text-align: center;font-size: 10px;">ZUPC</strong>
			</td>
		</tr>
      <tr>        
        <td colspan="2" style="padding-top: 5px;vertical-align: middle;border-left: none;border-right: none;padding-bottom: 5px;text-align: center;">
          
          <barcode type="<?= $ctype1 ?>" code="<?php echo $serial_no1; ?>" text="1" class="barcode" height="1" style="width:100%;"/></barcode>
          
        </td>
      </tr>
	  <tr>
			<td colspan="2" style="border-bottom:0px solid #000;padding-top: 0px;vertical-align: middle;border-left: none;border-right: none;padding-bottom: 5px;text-align: center;">
			<strong style="font-size: 10px;"><?php echo $serial_no1; ?></strong>
			</td>
		</tr>
      
      
    </tbody>
  </table>
  <?php } ?>

</body>
</html>	
	
	
	
	

