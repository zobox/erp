<!doctype html>
<html lang="en">
  <head> 
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;500;700;900&display=swap" rel="stylesheet">
​
  <title><?=$product_name;?></title>
  <style>
      table {
  border-collapse: collapse;
  width: 100%;
  vertical-align: top;
  display: flex;
  border-radius: 20px !important;
  align-items: flex-start;
}

  </style>
  </head>
  <body style="width:300px;height: 188px;">
    
    <?php
 
    if($label_size==2)
    {

        ?>

    
    <table style="width: 300px;">
            <thead></thead>
            <tbody>
             
                <tr>
                    
                                      <th colspan="2">
                        <table class="table-box" style="width: 300px;">
                            <thead></thead>
                            <tbody>

                               
                                <tr>
                                    <td  rowspan="1" style="text-align: left;border:1px solid #000;vertical-align: top;width:180px;padding:17px 5px;">
                                        <table>
                                            <tbody style="vertical-align: top;">
                                                <tr>
                                                   
                                                    <td style="font-size: 15px;padding-bottom:12px;vertical-align: top;font-weight: bold;"> <?=$product_name;?></td>
                                                </tr>
                                               
                                                <tr>
                                                   
                                                    <td style="font-size: 15px;vertical-align: top;padding-bottom:12px;">   <?=$product_detail['unit_name'];?> </td>
                                                </tr>
                                             
                                              <tr >
                                                    
                                                    <td style="font-size: 15px;padding-bottom:12px;vertical-align: top;">  <?=$product_detail['colour_name'];?></td>
                                                </tr>
                                                <tr >
                                                    
                                                    <td style="font-size: 15px;padding-bottom:12px;vertical-align: top;">&#8377; <span style="font-weight: bold;"> <?=$product_detail['product_price'];?>/-</span> <span style="font-size: 10px;">Inclusive of all Taxes</span></td>
                                                </tr>
                                            
                                                
                                                <tr>
                                                   
                                                    <td style="font-size: 15px;padding-bottom:12px;vertical-align: top;"> 1U</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                    <td style="text-align: left;border-top:1px solid #000;border-right:1px solid #000;border-bottom:1px solid #000;vertical-align: top;padding:17px 5px;"><table>
                                            <tbody>
                                                
                                                <tr>
                                                   <td style="padding: 25px 10px 5px;">
                                                        <!--<img alt="Barcode Generator TEC-IT" src="barcode.jpg" style="padding-top: 5px;width:100%;height:40px;">-->
                                                            <img alt='Barcode Generator TEC-IT'
       src='https://barcode.tec-it.com/barcode.ashx?data=<?=$serial?>&code=Code128&multiplebarcodes=false&translate-esc=true&unit=Fit&dpi=96&imagetype=Gif&rotation=0&color=%23000000&bgcolor=%23ffffff&codepage=Default&qunit=Mm&quiet=0' style="padding-top: 5px;height:70px;width: 80%" >

       <!--<barcode type="C39" code="<?=$product_detail[0]->imei_1?>" text="1" class="barcode" size="1" height="1.4"/></barcode>
       <br><span><?=$product_detail[0]->imei_1?></span>-->

                                                    </td>
                                                    
                                                    
                                                </tr>
                                                <!--<tr style="border-top: 1px solid #000">
                                                    <td style="width:150px;padding: 5px 16px 5px;<?php if($product_detail[0]->product_type==2) echo 'padding-top:30px;';?>">
                                                        <h6 style="margin:0px;font-size: 12px;">ZUPC <span style="margin-left: 0px;"><?=$product_detail[0]->zupc_code;?></span></h6>
                                                    </td>
                                                </tr>-->
                                                <tr>
                                                    <td style="padding: 0px 10px 10px;padding-top:5px;">
                                                        <!--<img alt="Barcode Generator TEC-IT" src="barcode.jpg" style="padding-top: 5px;width:100%;height:40px;">-->

                                                        <img alt='Barcode Generator TEC-IT'
       src="https://barcode.tec-it.com/barcode.ashx?data=<?=$product_detail['warehouse_product_code']?>&code=Code128&multiplebarcodes=false&translate-esc=true&unit=Fit&dpi=96&imagetype=Gif&rotation=0&color=%23000000&bgcolor=%23ffffff&codepage=Default&qunit=Mm&quiet=0" style="padding-top: 5px;height:70px;width: 80%;" >
       <!--<barcode type="C39" code="<?=$product_detail[0]->zupc_code?>" text="1" class="barcode" size="0.8" height="1.7"/></barcode>
       
       <span style="text-align: center;"><?=$product_detail[0]->zupc_code?></span>-->

                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                               <tr>
                                    <td  style="border-left: 1px solid #000;padding:20px 5px;text-align:left;font-size:12px;padding-bottom: 16px;border-right: 1px solid #000;font-weight: bold;" colspan="2">
                                        <span>Marketed & Sold By: </span><span>Zobox Retails Pvt. Ltd.</span> &nbsp;&nbsp; <span>E-mail: care@zobox.in</span>
                                    </td>
                                    
                                </tr>
                                <tr>
                                    <td  style="border-left: 1px solid #000;border-bottom: 1px solid #000;padding-left:5px;text-align:left;font-size:13px;border-right: 1px solid #000;padding-bottom: 20px;font-weight: bold;" colspan="2">
                                        <span>Zobox Care  No.: +91-8368573109</span> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span>Website: care.zobox.in &nbsp;&nbsp;</span>
                                    </td>

                                     
                                </tr>


                            </tbody>
                        </table>
                    </th>
                </tr>

            </tbody>
        </table>
        <?php
       }
       elseif($label_size==3)
       {
        ?>
          <table style="width: 300px;">
            <thead></thead>
            <tbody>
             
                <tr>
                    
                                      <th colspan="2">
                        <table class="table-box" style="width: 300px;">
                            <thead></thead>
                            <tbody>

                               
                                <tr>
                                    <td  rowspan="1" style="text-align: left;border:1px solid #000;vertical-align: top;width:180px;padding:17px 5px;">
                                        <table>
                                            <tbody style="vertical-align: top;">
                                                <tr>
                                                   
                                                    <td style="font-size: 15px;padding-bottom:12px;vertical-align: top;font-weight: bold;"> <?=$product_name;?></td>
                                                </tr>
                                               
                                                <tr>
                                                   
                                                    <td style="font-size: 15px;vertical-align: top;padding-bottom:12px;">   <?=$product_detail['unit_name'];?> </td>
                                                </tr>
                                             
                                              <tr >
                                                    
                                                    <td style="font-size: 15px;padding-bottom:12px;vertical-align: top;">  <?=$product_detail['colour_name'];?></td>
                                                </tr>
                                                <tr >
                                                    
                                                    <td style="font-size: 15px;padding-bottom:12px;vertical-align: top;">&#8377; <span style="font-weight: bold;"> <?=$product_detail['product_price'];?>/-</span> <span style="font-size: 10px;">Inclusive of all Taxes</span></td>
                                                </tr>
                                            
                                                
                                                <tr>
                                                   
                                                    <td style="font-size: 15px;padding-bottom:12px;vertical-align: top;"> 1U</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                    <td style="text-align: left;border-top:1px solid #000;border-right:1px solid #000;border-bottom:1px solid #000;vertical-align: top;padding:17px 5px;"><table>
                                            <tbody>
                                                
                                                <tr>
                                                   <td style="padding: 25px 10px 5px;">
                                                        <!--<img alt="Barcode Generator TEC-IT" src="barcode.jpg" style="padding-top: 5px;width:100%;height:40px;">-->
                                                            <img alt='Barcode Generator TEC-IT'
       src='https://barcode.tec-it.com/barcode.ashx?data=<?=$serial?>&code=Code128&multiplebarcodes=false&translate-esc=true&unit=Fit&dpi=96&imagetype=Gif&rotation=0&color=%23000000&bgcolor=%23ffffff&codepage=Default&qunit=Mm&quiet=0' style="padding-top: 5px;height:70px;width: 80%" >

       <!--<barcode type="C39" code="<?=$product_detail[0]->imei_1?>" text="1" class="barcode" size="1" height="1.4"/></barcode>
       <br><span><?=$product_detail[0]->imei_1?></span>-->

                                                    </td>
                                                    
                                                    
                                                </tr>
                                                <!--<tr style="border-top: 1px solid #000">
                                                    <td style="width:150px;padding: 5px 16px 5px;<?php if($product_detail[0]->product_type==2) echo 'padding-top:30px;';?>">
                                                        <h6 style="margin:0px;font-size: 12px;">ZUPC <span style="margin-left: 0px;"><?=$product_detail[0]->zupc_code;?></span></h6>
                                                    </td>
                                                </tr>-->
                                                <tr>
                                                    <td style="padding: 0px 10px 10px;padding-top:5px;">
                                                        <!--<img alt="Barcode Generator TEC-IT" src="barcode.jpg" style="padding-top: 5px;width:100%;height:40px;">-->

                                                        <img alt='Barcode Generator TEC-IT'
       src="https://barcode.tec-it.com/barcode.ashx?data=<?=$product_detail['warehouse_product_code']?>&code=Code128&multiplebarcodes=false&translate-esc=true&unit=Fit&dpi=96&imagetype=Gif&rotation=0&color=%23000000&bgcolor=%23ffffff&codepage=Default&qunit=Mm&quiet=0" style="padding-top: 5px;height:70px;width: 80%;" >
       <!--<barcode type="C39" code="<?=$product_detail[0]->zupc_code?>" text="1" class="barcode" size="0.8" height="1.7"/></barcode>
       
       <span style="text-align: center;"><?=$product_detail[0]->zupc_code?></span>-->

                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                               <tr>
                                    <td  style="border-left: 1px solid #000;padding:20px 5px;text-align:left;font-size:12px;padding-bottom: 16px;border-right: 1px solid #000;font-weight: bold;" colspan="2">
                                        <span>Marketed & Sold By: </span><span>Zobox Retails Pvt. Ltd.</span> &nbsp;&nbsp; <span>E-mail: care@zobox.in</span>
                                    </td>
                                    
                                </tr>
                                <tr>
                                    <td  style="border-left: 1px solid #000;border-bottom: 1px solid #000;padding-left:5px;text-align:left;font-size:13px;border-right: 1px solid #000;padding-bottom: 20px;font-weight: bold;" colspan="2">
                                        <span>Zobox Care  No.: +91-8368573109</span> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span>Website: care.zobox.in &nbsp;&nbsp;</span>
                                    </td>

                                     
                                </tr>


                            </tbody>
                        </table>
                    </th>
                </tr>

            </tbody>
        </table>
        <?php
       }
       elseif($label_size==1)
       {


        ?>

         <table style="width: 300px;">
            <thead></thead>
            <tbody>
             
                <tr>
                    
                                      <th colspan="2">
                        <table class="table-box" style="width: 300px;">
                            <thead></thead>
                            <tbody>

                               
                                <tr>
                                    <td  rowspan="1" style="text-align: left;border:1px solid #000;vertical-align: top;width:180px;padding:17px 5px;">
                                        <table>
                                            <tbody style="vertical-align: top;">
                                                <tr>
                                                   
                                                    <td style="font-size: 15px;padding-bottom:12px;vertical-align: top;font-weight: bold;"> <?=$product_name;?></td>
                                                </tr>
                                               
                                                <tr>
                                                   
                                                    <td style="font-size: 15px;vertical-align: top;padding-bottom:12px;">   <?=$product_detail['unit_name'];?> </td>
                                                </tr>
                                             
                                              <tr >
                                                    
                                                    <td style="font-size: 15px;padding-bottom:12px;vertical-align: top;">  <?=$product_detail['colour_name'];?></td>
                                                </tr>
                                                <tr >
                                                    
                                                    <td style="font-size: 15px;padding-bottom:12px;vertical-align: top;">&#8377; <span style="font-weight: bold;"> <?=$product_detail['product_price'];?>/-</span> <span style="font-size: 10px;">Inclusive of all Taxes</span></td>
                                                </tr>
                                            
                                                
                                                <tr>
                                                   
                                                    <td style="font-size: 15px;padding-bottom:12px;vertical-align: top;"> 1U</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                    <td style="text-align: left;border-top:1px solid #000;border-right:1px solid #000;border-bottom:1px solid #000;vertical-align: top;padding:17px 5px;"><table>
                                            <tbody>
                                                
                                                <tr>
                                                   <td style="padding: 25px 10px 5px;">
                                                        <!--<img alt="Barcode Generator TEC-IT" src="barcode.jpg" style="padding-top: 5px;width:100%;height:40px;">-->
                                                            <img alt='Barcode Generator TEC-IT'
       src='https://barcode.tec-it.com/barcode.ashx?data=<?=$serial?>&code=Code128&multiplebarcodes=false&translate-esc=true&unit=Fit&dpi=96&imagetype=Gif&rotation=0&color=%23000000&bgcolor=%23ffffff&codepage=Default&qunit=Mm&quiet=0' style="padding-top: 5px;height:70px;width: 80%" >

       <!--<barcode type="C39" code="<?=$product_detail[0]->imei_1?>" text="1" class="barcode" size="1" height="1.4"/></barcode>
       <br><span><?=$product_detail[0]->imei_1?></span>-->

                                                    </td>
                                                    
                                                    
                                                </tr>
                                                <!--<tr style="border-top: 1px solid #000">
                                                    <td style="width:150px;padding: 5px 16px 5px;<?php if($product_detail[0]->product_type==2) echo 'padding-top:30px;';?>">
                                                        <h6 style="margin:0px;font-size: 12px;">ZUPC <span style="margin-left: 0px;"><?=$product_detail[0]->zupc_code;?></span></h6>
                                                    </td>
                                                </tr>-->
                                                <tr>
                                                    <td style="padding: 0px 10px 10px;padding-top:5px;">
                                                        <!--<img alt="Barcode Generator TEC-IT" src="barcode.jpg" style="padding-top: 5px;width:100%;height:40px;">-->

                                                        <img alt='Barcode Generator TEC-IT'
       src="https://barcode.tec-it.com/barcode.ashx?data=<?=$product_detail['warehouse_product_code']?>&code=Code128&multiplebarcodes=false&translate-esc=true&unit=Fit&dpi=96&imagetype=Gif&rotation=0&color=%23000000&bgcolor=%23ffffff&codepage=Default&qunit=Mm&quiet=0" style="padding-top: 5px;height:70px;width: 80%;" >
       <!--<barcode type="C39" code="<?=$product_detail[0]->zupc_code?>" text="1" class="barcode" size="0.8" height="1.7"/></barcode>
       
       <span style="text-align: center;"><?=$product_detail[0]->zupc_code?></span>-->

                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                               <tr>
                                    <td  style="border-left: 1px solid #000;padding:20px 5px;text-align:left;font-size:12px;padding-bottom: 16px;border-right: 1px solid #000;font-weight: bold;" colspan="2">
                                        <span>Marketed & Sold By: </span><span>Zobox Retails Pvt. Ltd.</span> &nbsp;&nbsp; <span>E-mail: care@zobox.in</span>
                                    </td>
                                    
                                </tr>
                                <tr>
                                    <td  style="border-left: 1px solid #000;border-bottom: 1px solid #000;padding-left:5px;text-align:left;font-size:13px;border-right: 1px solid #000;padding-bottom: 20px;font-weight: bold;" colspan="2">
                                        <span>Zobox Care  No.: +91-8368573109</span> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span>Website: care.zobox.in &nbsp;&nbsp;</span>
                                    </td>

                                     
                                </tr>


                            </tbody>
                        </table>
                    </th>
                </tr>

            </tbody>
        </table>
    <?php }
     elseif($label_size==4)
       {


        ?>

          <table style="width: 300px;">
            <thead></thead>
            <tbody>
             
                <tr>
                    
                                      <th colspan="2">
                        <table class="table-box" style="width: 300px;">
                            <thead></thead>
                            <tbody>

                               
                                <tr>
                                    <td  rowspan="1" style="text-align: left;border:1px solid #000;vertical-align: top;width:180px;padding:17px 5px;">
                                        <table>
                                            <tbody style="vertical-align: top;">
                                                <tr>
                                                   
                                                    <td style="font-size: 15px;padding-bottom:12px;vertical-align: top;font-weight: bold;"> <?=$product_name;?></td>
                                                </tr>
                                               
                                                <tr>
                                                   
                                                    <td style="font-size: 15px;vertical-align: top;padding-bottom:12px;">   <?=$product_detail['unit_name'];?> </td>
                                                </tr>
                                             
                                              <tr >
                                                    
                                                    <td style="font-size: 15px;padding-bottom:12px;vertical-align: top;">  <?=$product_detail['colour_name'];?></td>
                                                </tr>
                                                <tr >
                                                    
                                                    <td style="font-size: 15px;padding-bottom:12px;vertical-align: top;">&#8377; <span style="font-weight: bold;"> <?=$product_detail['product_price'];?>/-</span> <span style="font-size: 10px;">Inclusive of all Taxes</span></td>
                                                </tr>
                                            
                                                
                                                <tr>
                                                   
                                                    <td style="font-size: 15px;padding-bottom:12px;vertical-align: top;"> 1U</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                    <td style="text-align: left;border-top:1px solid #000;border-right:1px solid #000;border-bottom:1px solid #000;vertical-align: top;padding:17px 5px;"><table>
                                            <tbody>
                                                
                                                <tr>
                                                   <td style="padding: 25px 10px 5px;">
                                                        <!--<img alt="Barcode Generator TEC-IT" src="barcode.jpg" style="padding-top: 5px;width:100%;height:40px;">-->
                                                            <img alt='Barcode Generator TEC-IT'
       src='https://barcode.tec-it.com/barcode.ashx?data=<?=$serial?>&code=Code128&multiplebarcodes=false&translate-esc=true&unit=Fit&dpi=96&imagetype=Gif&rotation=0&color=%23000000&bgcolor=%23ffffff&codepage=Default&qunit=Mm&quiet=0' style="padding-top: 5px;height:70px;width: 80%" >

       <!--<barcode type="C39" code="<?=$product_detail[0]->imei_1?>" text="1" class="barcode" size="1" height="1.4"/></barcode>
       <br><span><?=$product_detail[0]->imei_1?></span>-->

                                                    </td>
                                                    
                                                    
                                                </tr>
                                                <!--<tr style="border-top: 1px solid #000">
                                                    <td style="width:150px;padding: 5px 16px 5px;<?php if($product_detail[0]->product_type==2) echo 'padding-top:30px;';?>">
                                                        <h6 style="margin:0px;font-size: 12px;">ZUPC <span style="margin-left: 0px;"><?=$product_detail[0]->zupc_code;?></span></h6>
                                                    </td>
                                                </tr>-->
                                                <tr>
                                                    <td style="padding: 0px 10px 10px;padding-top:5px;">
                                                        <!--<img alt="Barcode Generator TEC-IT" src="barcode.jpg" style="padding-top: 5px;width:100%;height:40px;">-->

                                                        <img alt='Barcode Generator TEC-IT'
       src="https://barcode.tec-it.com/barcode.ashx?data=<?=$product_detail['warehouse_product_code']?>&code=Code128&multiplebarcodes=false&translate-esc=true&unit=Fit&dpi=96&imagetype=Gif&rotation=0&color=%23000000&bgcolor=%23ffffff&codepage=Default&qunit=Mm&quiet=0" style="padding-top: 5px;height:70px;width: 80%;" >
       <!--<barcode type="C39" code="<?=$product_detail[0]->zupc_code?>" text="1" class="barcode" size="0.8" height="1.7"/></barcode>
       
       <span style="text-align: center;"><?=$product_detail[0]->zupc_code?></span>-->

                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                               <tr>
                                    <td  style="border-left: 1px solid #000;padding:20px 5px;text-align:left;font-size:12px;padding-bottom: 16px;border-right: 1px solid #000;font-weight: bold;" colspan="2">
                                        <span>Marketed & Sold By: </span><span>Zobox Retails Pvt. Ltd.</span> &nbsp;&nbsp; <span>E-mail: care@zobox.in</span>
                                    </td>
                                    
                                </tr>
                                <tr>
                                    <td  style="border-left: 1px solid #000;border-bottom: 1px solid #000;padding-left:5px;text-align:left;font-size:13px;border-right: 1px solid #000;padding-bottom: 20px;font-weight: bold;" colspan="2">
                                        <span>Zobox Care  No.: +91-8368573109</span> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span>Website: care.zobox.in &nbsp;&nbsp;</span>
                                    </td>

                                     
                                </tr>


                            </tbody>
                        </table>
                    </th>
                </tr>

            </tbody>
        </table>
    <?php }
     ?>
  </body>
</html>




