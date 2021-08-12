
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

#box{
  border-radius: 50px;
}
.barcode{
  width: 250px;
}

</style>
</head>
<body>

<table style="border:1px solid #000;width: 550px;height: 377px;border-radius: 4px;padding:2px 5px; margin-bottom: 0px;">
<thead>
            <tr>
              <td style="font-size: 16px;font-weight: 600;font-family: arial;text-align: left;padding-top:10px;border:none;width:30%;vertical-align: top;">
                <table>
                  <tr>
                    <td><strong>Sticker No.</strong></td>
                  </tr>
                  <tr>

                    <td style="text-align: left;"><?php echo $serial_details[0]->sticker_no; ?></td>
                  </tr>
                </table>
        
        </td>
              <td style="font-size: 16px;font-weight: 600;font-family: arial;text-align: center;padding:0px;border:none;">
        <barcode type="<?= $ctype ?>" code="<?= $name[0] ?>" text="1" class="barcode" height="2" style="width:100%;"/></barcode>
        <!--<barcode type="<?= $ctype ?>" code="<?= $name[0] ?>" text="1" class="barcode" height="2" style="width:100%;"/></barcode>-->
        <br><?= $name[0] ?>
        </td>
        
            </tr>
          </thead>
          <tbody>
            <tr style="padding:0px;">
              <td style="font-size: 14px;vertical-align: top;font-weight: bold;padding:0px !important;">Product Name :</td>
              <td style="font-size: 14px;vertical-align: top;padding:0px !important;"><?php echo $product[0] ?></td>
            </tr>
            <tr style="padding:0px;">
              <td style="font-size: 14px;vertical-align: top;font-weight: bold;padding:0px !important;">Variant :</td>
              <td style="font-size: 14px;vertical-align: top;padding:0px !important;"><?php echo $product[2] ?></td>
            </tr>
            <tr style="padding:0px;">
              <td style="font-size: 14px;vertical-align: top;font-weight: bold;padding:0px !important;">Color :</td>
              <td style="font-size: 14px;vertical-align: top;padding:0px !important;"><?php echo $product[3] ?></td>
            </tr>

            <tr style="padding:0px;">
              <td style="font-size: 14px;vertical-align: top;font-weight: bold;padding:0px !important;">PO # :</td>
              <td style="font-size: 14px;vertical-align: top;padding:0px !important;"><?php echo 'MRG_PO#'.$serial_details[0]->tid; ?></td>
            </tr>
            
       <tr style="padding:0px;">
              <td style="font-size: 14px;vertical-align: top;font-weight: bold;padding:0px !important;">IMEI 1 :</td>
            
              <td style="font-size: 14px;vertical-align: top;padding:0px !important;">
       </td></tr>
       <tr style="padding:0px;">
              <td style="font-size: 14px;vertical-align: top;font-weight: bold;padding:0px !important;">Qc Engineer :</td>        
              <td style="font-size: 14px;vertical-align: top;padding:0px !important;"><?php echo $serial_details[0]->qc_engineer; ?>
       </td></tr>
       <tr style="padding:0px;">
              <td style="font-size: 14px;vertical-align: top;font-weight: bold;padding:0px !important;">Current Grade :</td>
              <td style="font-size: 14px;vertical-align: top;padding:0px !important;"><?php echo $product[3] ?></td>
            </tr>
            <tr style="padding:0px;">
              <td style="font-size: 14px;vertical-align: top;font-weight: bold;padding:0px !important;">Final Grade :</td>
              <td style="font-size: 14px;vertical-align: top;padding:0px !important;"><?php echo $product[3] ?></td>
            </tr>
       <tr style="padding:0px;text-align: right; ">
              <td style="font-size: 16px;vertical-align: top;font-weight: bold;padding:0px;text-align:center;" colspan="2">
       <!-- <img src="assets/images/barcode.png" style="width: 540px;height: 80px;margin-top: 10px;" >-->
        <barcode type="<?= $ctype ?>" code="<?= $serial ?>" text="1" class="barcode" height="2" barWidth="7" /></barcode>
        <!--<img alt='Barcode Generator TEC-IT'
       src='https://barcode.tec-it.com/barcode.ashx?data=<?= $serial ?>&code=Code128&multiplebarcodes=false&translate-esc=true&unit=Fit&dpi=96&imagetype=Gif&rotation=0&color=%23000000&bgcolor=%23ffffff&codepage=Default&qunit=Mm&quiet=0' style="width: 260px;height: 90px;margin-top: 10px;margin-left:130px;" >-->
      
       </td>
            
        </tr>
    <tr>
    <td style="text-align:center;" colspan="2">
    <?= $serial ?>
    </td>
    </tr>
          </tbody>
        </table>
</body>
</html>
<?php } ?>