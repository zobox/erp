<?php  		
	
	if($serial_no1<=13){
		$ctype1 = 'EAN13';
	}elseif($serial_no1>13 && $serial<=39){
		$ctype1 = 'C39';
	}elseif($serial_no1>39){
		$ctype1 = 'C128A';
	}	
	
	if($zupc_code<=13){
		$ctype2 = 'EAN13';
	}elseif($zupc_code>13 && $serial<=39){
		$ctype2 = 'C39';
	}elseif($zupc_code>39){
		$ctype2 = 'C128A';
	}
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
  <table style="border:1px solid #000;width: 350px;height: 200px;border-radius: 4px; margin-bottom: 0px;margin-top: 20px;">
    <tbody>
		<tr>
			<td colspan="2" style="border-bottom:0px solid #000;padding-top: 5px;vertical-align: middle;border-left: none;border-right: none;padding-bottom: 0px;text-align: center;">
			<strong style="display: block;text-align: center;font-size: 10px;">ZUPC</strong>
			</td>
		</tr>
      <tr>        
        <td colspan="2" style="padding-top: 0px;vertical-align: middle;border-left: none;border-right: none;padding-bottom: 0px;text-align: center;">
          
          <barcode type="<?= $ctype2 ?>" code="<?php echo $zupc_code; ?>" text="1" class="barcode" height="1" style="width:100%;"/></barcode>
          
        </td>
      </tr>
	  <tr>
			<td colspan="2" style="border-bottom:1px solid #000;padding-top: 0px;vertical-align: middle;border-left: none;border-right: none;padding-bottom: 5px;text-align: center;">
			<strong style="font-size: 10px;"><?php echo $zupc_code; ?></strong>
			</td>
		</tr>
      <tr>
        <td style="font-size: 16px;font-weight: 600;font-family: arial;text-align: left;border:none;width:30%;vertical-align: top;">
          <table>
            <tr style="padding:0px;">
              <td style="font-size: 11px;vertical-align: top;font-weight: bold;padding:0px 0px 0px !important;">Product Name :</td>
              <td style="font-size: 11px;vertical-align: top;padding:0px 0px 0px !important;"><?php echo $product_name; ?></td>
            </tr>
            <tr style="padding:0px;">
              <td style="font-size: 11px;vertical-align: top;font-weight: bold;padding:0px 0px 0px !important;">Variant :</td>
              <td style="font-size: 11px;vertical-align: top;padding:0px !important;"><?php echo $varient; ?></td>
            </tr>
            
            <tr style="padding:0px;">
              <td style="font-size: 11px;vertical-align: top;font-weight: bold;padding:0px 0px 0px !important;">PO # :</td>
              <td style="font-size: 11px;vertical-align: top;padding:0px 0px 0px !important;"><?php echo $purchase_order; ?></td>
            </tr>
			
			<tr style="padding:0px;">
              <td style="font-size: 11px;vertical-align: top;font-weight: bold;padding:0px 0px 0px !important;">Current Grade :</td>
              <td style="font-size: 11px;vertical-align: top;padding:0px 0px 0px !important;"><?php echo $current_grade; ?></td>
            </tr>
            
            <tr style="padding:0px;">
              <td style="font-size: 11px;vertical-align: top;font-weight: bold;padding:0px 0px 0px !important;">Required Spare Parts :</td>
              <td style="font-size: 11px;vertical-align: top;padding:0px 0px 0px !important;"><?php echo $items; ?></td>
            </tr>
            
          </table>
        </td>
        <td style="font-size: 14px;font-weight: 600;font-family: arial;text-align: left;border:none;width:30%;vertical-align: top;">
          <table>
            <tr style="padding:0px;">
              <td style="font-size: 11px;vertical-align: top;font-weight: bold;padding:0px 0px 0px !important;">Sticker No :</td>
              <td style="font-size: 11px;vertical-align: top;padding:0px 0px 0px !important;"><?php echo $sticker_no; ?> </td>
            </tr>
            <tr style="padding:0px;">
              <td style="font-size: 11px;vertical-align: top;font-weight: bold;padding:0px 0px 0px !important;">Color :</td>
              <td style="font-size: 11px;vertical-align: top;padding:0px 0px 0px !important;"><?php echo $colour; ?></td>
            </tr>
            
            <tr style="padding:0px;">
              <td style="font-size: 11px;vertical-align: top;font-weight: bold;padding:0px 0px 0px !important;">Qc Engineer :</td>
              <td style="font-size: 11px;vertical-align: top;padding:0px 0px 0px !important;"><?php echo $qc_engineer; ?> </td>
            </tr>
			
			<tr style="padding:0px;">
              <td style="font-size: 11px;vertical-align: top;font-weight: bold;padding:0px 0px 0px !important;">Final Grade :</td>
              <td style="font-size: 11px;vertical-align: top;padding:0px 0px 0px !important;"><?php echo $final_grade; ?> </td>
            </tr>
			
          </table>
        </td>
      </tr>
      
	  
	  <tr>
			<td colspan="2" style="border-top:1px solid #000;padding-top: 5px;vertical-align: middle;border-left: none;border-right: none;padding-bottom: 0px;text-align: center;">
			<strong style="display: block;text-align: center;font-size: 10px;">IMEI</strong>
			</td>
		</tr>
      <tr>        
        <td colspan="2" style="padding-top: 0px;vertical-align: middle;border-left: none;border-right: none;padding-bottom: 0px;text-align: center;">
          
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
</body>

</html>	
	
	
	
	

