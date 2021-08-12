<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;500;700;900&display=swap" rel="stylesheet">
​
  <title><?=$product_detail[0]->product_name;?></title>
  <style>
      table {
  border-collapse: collapse;
  width: 100%;
  vertical-align: top;
  display: flex;
  align-items: flex-start;
}

  </style>
  </head>
  <body style="width:300px;height: 188px;">
    
    <?php
 
    if($product_detail[0]->label_size==2 && $label_type!='mini')
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
                                                   
                                                    <td style="font-size: 15px;padding-bottom:12px;vertical-align: top;font-weight: bold;">: <?=$product_detail[0]->product_name;?></td>
                                                </tr>
                                                <?php
                                                if($product_detail[0]->product_type!=2)
                                                {
                                                    ?> 
                                                <tr>
                                                   
                                                    <td style="font-size: 15px;vertical-align: top;padding-bottom:12px;">:   <?=$product_detail[0]->unit_name;?> </td>
                                                </tr>
                                            <?php } ?>
                                              <tr >
                                                    
                                                    <td style="font-size: 15px;padding-bottom:12px;vertical-align: top;">: <?=$product_detail[0]->colour_name;?></td>
                                                </tr>
                                                <tr >
                                                    
                                                    <td style="font-size: 15px;padding-bottom:12px;vertical-align: top;">: &#8377; <span style="font-weight: bold;"><?=$product_detail[0]->price;?>/-</span> <span style="font-size: 10px;">Inclusive of all Taxes</span></td>
                                                </tr>
                                            
                                                
                                                <tr>
                                                   
                                                    <td style="font-size: 15px;padding-bottom:12px;vertical-align: top;">: <?=$product_detail[0]->qty;?></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                    <td style="text-align: left;border-top:1px solid #000;border-right:1px solid #000;border-bottom:1px solid #000;vertical-align: top;padding:17px 5px;"><table>
                                            <tbody>
                                                <?php
                                                if($product_detail[0]->product_type!=2)
                                                {
                                                    ?>
                                               <!-- <tr>
                                                    <td style="width:200px;padding: 7px 10px 5px;">
                                                        <h6 style="margin:0px;font-size: 12px;">IMEI 1 <span style="margin-left: 10px;">: <?=$product_detail[0]->imei_1;?></span></h6>
                                                    </td>
                                                    
                                                    
                                                </tr>
                                                <tr>
                                                    <td style="width:200px;padding: 0px 10px 10px;">
                                                        <h6 style="margin:0px;font-size: 12px;">IMEI 2 <span style="margin-left: 10px;">: <?=$product_detail[0]->imei_2;?></span></h6>
                                                    </td>
                                                    
                                                    
                                                </tr>-->
                                            
                                                <tr>
                                                   <td style="padding: 25px 10px 5px;">
                                                        <!--<img alt="Barcode Generator TEC-IT" src="barcode.jpg" style="padding-top: 5px;width:100%;height:40px;">-->
                                                            <img alt='Barcode Generator TEC-IT'
       src='https://barcode.tec-it.com/barcode.ashx?data=<?=$product_detail[0]->imei_1?>&code=Code128&multiplebarcodes=false&translate-esc=true&unit=Fit&dpi=96&imagetype=Gif&rotation=0&color=%23000000&bgcolor=%23ffffff&codepage=Default&qunit=Mm&quiet=0' style="padding-top: 5px;height:70px;width: 80%" >

       <!--<barcode type="C39" code="<?=$product_detail[0]->imei_1?>" text="1" class="barcode" size="1" height="1.4"/></barcode>
       <br><span><?=$product_detail[0]->imei_1?></span>-->

                                                    </td>
                                                    
                                                    
                                                </tr>
                                            <?php } ?>
                                                <!--<tr style="border-top: 1px solid #000">
                                                    <td style="width:150px;padding: 5px 16px 5px;<?php if($product_detail[0]->product_type==2) echo 'padding-top:30px;';?>">
                                                        <h6 style="margin:0px;font-size: 12px;">ZUPC <span style="margin-left: 0px;"><?=$product_detail[0]->zupc_code;?></span></h6>
                                                    </td>
                                                </tr>-->
                                                <tr>
                                                    <td style="padding: 0px 10px 10px;padding-top:5px;">
                                                        <!--<img alt="Barcode Generator TEC-IT" src="barcode.jpg" style="padding-top: 5px;width:100%;height:40px;">-->

                                                        <img alt='Barcode Generator TEC-IT'
       src='https://barcode.tec-it.com/barcode.ashx?data=<?=$product_detail[0]->zupc_code?>&code=Code128&multiplebarcodes=false&translate-esc=true&unit=Fit&dpi=96&imagetype=Gif&rotation=0&color=%23000000&bgcolor=%23ffffff&codepage=Default&qunit=Mm&quiet=0' style="padding-top: 5px;height:70px;width: 80%;" >
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
       elseif($product_detail[0]->label_size==3 || $label_type=='mini')
       {
        ?>
         <table style="width: 143px;">
            <thead></thead>
            <tbody>
             
                <tr>
                    
                                      <th colspan="2">
                        <table class="table-box" style="width: 143px;">
                            <thead></thead>
                            <tbody>

                               
                                <tr>
                                    <td  rowspan="1" style="text-align: left;border:1px solid #000;vertical-align: top;">
                                        <table>
                                            <tbody style="vertical-align: top;">
                                                <tr>
                                                    <td style="font-size: 7px;vertical-align: top;font-weight: bold;">Brand</td>
                                                    <td style="font-size: 7px;vertical-align: top;padding-bottom: 5px;">: <?=$product_detail[0]->brand_name?></td>
                                                </tr>
                                                <tr>
                                                    <td style="font-size: 7px;vertical-align: top;font-weight: bold;">Product</td>
                                                    <td style="font-size: 7px;vertical-align: top;padding-bottom: 5px;">: <?=$product_detail[0]->product_name;?></td>
                                                </tr>
                                                <tr>
                                                    <td style="font-size: 7px;vertical-align: top;font-weight: bold;">Variant</td>
                                                    <td style="font-size: 7px;vertical-align: top;padding-bottom: 5px;">:  <?=$product_detail[0]->unit_name;?> </td>
                                                </tr>
                                              <tr >
                                                    <td style="font-size: 7px;vertical-align: top;font-weight: bold;">Color</td>
                                                    <td style="font-size: 7px;vertical-align: top;padding-bottom: 5px;">: <?=$product_detail[0]->colour_name;?></td>
                                                </tr>
                                               
                                                
                                            </tbody>
                                        </table>
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
       elseif($product_detail[0]->label_size==1 && $label_type!='mini')
       {


        ?>

        <table style="width: 283px;vertical-align: top;height: 258px;">
            <thead></thead>
            <tbody>
             
                <tr>
                    
                    <th colspan="2" style="vertical-align: top;">
                        <table class="table-box" style="width: 283px;height: 188px;">
                            <thead></thead>
                            <tbody>

                               
                                <tr>
                                    <td  rowspan="1" style="text-align: left;border:1px solid #000;vertical-align: top;width:200px;padding:30px 10px;">
                                        <table>
                                            <tbody style="vertical-align: top;">
                                                <tr>
                                                    <!--<td style="font-size: 9px;vertical-align: top;font-weight: bold;padding-bottom:10px;">Product</td>-->
                                                    <td style="font-size: 20px;padding-bottom:15px;vertical-align: top;font-weight: bold;"><?=$product_detail[0]->product_name;?></td>
                                                </tr>
                                                 <?php
                                                if($product_detail[0]->product_type!=2)
                                                {
                                                    ?>
                                                <tr>
                                                   
                                                    <td style="font-size: 20px;vertical-align: top;padding-bottom: 15px;"><?=$product_detail[0]->unit_name;?> </td>
                                                </tr>
                                            <?php } ?>
                                              <tr >
                                                   
                                                    <td style="font-size: 20px;padding-bottom:15px;vertical-align: top;"><?=$product_detail[0]->colour_name;?></td>
                                                </tr>
                                                <tr >
                                                    <!--<td style="font-size: 9px;padding-bottom:0px;vertical-align: top;font-weight: bold;">MRP <h5 style="font-size: 7px;margin-top: 0px;">Inclusive of all taxes</h5></td>-->
                                                    <td style="font-size: 20px;padding-bottom:15px;vertical-align: top;padding-bottom:10px;">&#8377; <span style="font-weight: bold;"><?=$product_detail[0]->price;?>/-</span> <span style="font-size: 12px;">Inclusive of all Taxes</span></td>
                                                </tr>
                                            
                                                
                                                <tr>
                                                    
                                                    <td style="font-size: 18px;padding-bottom:12px;vertical-align: top;"><?=$product_detail[0]->qty;?></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                    <td style="text-align: left;border-top:1px solid #000;border-right:1px solid #000;border-bottom:1px solid #000;vertical-align: top;width:200px;">
                                        <table style="width:50px">
                                            <tbody>
                                                <?php
                                                if($product_detail[0]->product_type!=2)
                                                {
                                                    ?>
                                               <!-- <tr>
                                                    <td style="width:100px;padding: 7px 5px 0px;">
                                                        <h6 style="margin:0px;font-size: 12px;">IMEI 1 <span style="margin-left: 10px;">: <?=$product_detail[0]->imei_1;?></span></h6>
                                                    </td>
                                                    
                                                    
                                                </tr>
                                                <tr>
                                                    <td style="width:100px;padding: 0px 5px 5px;">
                                                        <h6 style="margin:0px;font-size: 12px;">IMEI 2 <span style="margin-left: 10px;">: <?=$product_detail[0]->imei_2;?></span></h6>
                                                    </td>
                                                    
                                                    
                                                </tr>-->
                                           
                                                <tr>
                                                   <td style="max-width:100px !important;padding: 0px 0px 10px;">
                                                        <!--<img alt="Barcode Generator TEC-IT" src="barcode.jpg" style="padding-top: 5px;width:100%;height:30px;">-->
                        
     <img alt='Barcode Generator TEC-IT'
       src='https://barcode.tec-it.com/barcode.ashx?data=<?=$product_detail[0]->zupc_code?>&code=Code128&multiplebarcodes=false&translate-esc=true&unit=Fit&dpi=96&imagetype=Gif&rotation=0&color=%23000000&bgcolor=%23ffffff&codepage=Default&qunit=Mm&quiet=0' style="padding-top: 5px;width:150px;height:30px;" >
       
       
 <!--
       <barcode type="C39" code="<?=$product_detail[0]->imei_1?>" text="1" class="barcode" size="0.5" height="1.5"/></barcode>-->
                                                    </td>
                                                    
                                                    
                                                </tr>
                                                 <?php } ?>
                                               <!-- <tr style="border-top: 1px solid #000;">
                                                    <td style="padding: 0px 7px 0px;<?php if($product_detail[0]->product_type==2) echo 'padding-top:50px;';?>">
                                                        <h6 style="margin:0px;font-size: 18px;">ZUPC <span style="margin-left: 10px;"><?=$product_detail[0]->zupc_code;?></span></h6>
                                                    </td>
                                                </tr>-->
                                                <tr>
                                                    <td style="padding: 70px 20px 20px;">
                                                        <!--<img alt="Barcode Generator TEC-IT" src="barcode.jpg" style="padding-top: 5px;width:100%;height:30px;">-->
                        
     <img alt='Barcode Generator TEC-IT'
       src='https://barcode.tec-it.com/barcode.ashx?data=<?=$product_detail[0]->zupc_code?>&code=Code128&multiplebarcodes=false&translate-esc=true&unit=Fit&dpi=96&imagetype=Gif&rotation=0&color=%23000000&bgcolor=%23ffffff&codepage=Default&qunit=Mm&quiet=0' style="padding-top: 5px;width:100%;height:90px;" >
       
       
        <!--
       <barcode type="C39" code="<?=$product_detail[0]->zupc_code?>" text="1" class="barcode" size="0.9" height="2.4" style="min-width: 100px;"/></barcode>-->
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td  style="border-left: 1px solid #000;padding:31px 5px;text-align:left;font-size:14px;padding-bottom: 20px;border-right: 1px solid #000;font-weight: bold;" colspan="2">
                                        <span>Marketed & Sold By: </span><span>Zobox Retails Pvt. Ltd.</span> &nbsp;&nbsp;&nbsp;&nbsp; <span>E-mail: care@zobox.in</span>
                                    </td>
                                    
                                </tr>
                                <tr>
                                    <td  style="border-left: 1px solid #000;border-bottom: 1px solid #000;padding-left:5px;text-align:left;font-size:14px;border-right: 1px solid #000;padding-bottom: 31px;font-weight: bold;" colspan="2">
                                        <span>Zobox Care  No.: +91-8368573109</span> &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span>Website: care.zobox.in</span>
                                    </td>

                                    
                                </tr>
                            </tbody>
                        </table>
                    </th>
                </tr>

            </tbody>
        </table>
    <?php } ?>
  </body>
</html>




