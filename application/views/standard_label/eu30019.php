<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;500;700;900&display=swap" rel="stylesheet">
​
​
  <title>EU30019</title>
  </head>

  <body>
    <?php 
    
    if($style[barcode_type]==0)
    {
    ?>
   <table style="width: 220px;" >
            <thead></thead>
            <tbody>

                <?php
                 $show_serial_no = 3; 

                 $rows = ceil(count($style[serial])/$show_serial_no);
                
                  
                    
                    for($i=1;$i<=$rows;$i++)
                    {
                        $rows_start = ($i-1)*$show_serial_no;
                        if(count($style[serial])>$show_serial_no)
                        {
                          
                        if(($i*$show_serial_no)>count($style[serial]))
                        {

                            
                            $end_rows = ($i*$show_serial_no)-count($style[serial])+$show_serial_no;
                            
                        }
                        else
                        {
                          
                        $end_rows = ($i*$show_serial_no);


                        
                        }
                    }
                        else
                        {
                            $rows_start = 0;
                            $end_rows = count($style[serial]);
                        }

                                               ?>
                    
                <tr>
                    <?php 
                    
                     for ($j=$rows_start; $j<$end_rows; $j++) 
                       
                     //foreach($style[serial] as $serial_list)
                     {
                        
                        //$serial_no = explode('-',$serial_list[serial_id]);
                         
               if($style[serial][$j][product_name]!='')
               {
                      ?>
                    <th colspan="2">
                        <table class="table-box" style="width: 200px;">
                            <thead></thead>
                            <tbody>

                               
                                <tr>
                                    <td colspan="6" rowspan="1" style="text-align: left;border:1px solid #000;vertical-align: top;width:100px;">
                                        <table>
                                            <tbody style="vertical-align: top;">
                                              <tr >
                                                    <td style="font-size: 9px;vertical-align: top;font-weight: bold;">Color</td>
                                                    <td style="font-size: 9px;vertical-align: top;">: </td>
                                                </tr>
                                                <tr>
                                                    <td style="font-size: 9px;vertical-align: top;font-weight: bold;">Product Name</td>
                                                    <td style="font-size: 8px;vertical-align: top;">: <?php if(strlen($style[serial][$j][product_name])>40) { echo substr($style[serial][$j][product_name],0,40).'...'; } else { echo $style[serial][$j][product_name]; } ?></td>
                                                </tr>
                                                <tr>
                                                    <td style="font-size: 9px;vertical-align: top;font-weight: bold;">Variant</td>
                                                    <td style="font-size: 8px;vertical-align: top;width:80px;">:  <?php if(strlen($style[serial][$j][product_name])>40) { echo substr($style[serial][$j][product_name],0,40).'...'; } else { echo $style[serial][$j][product_name]; } ?></td>
                                                </tr>
                                                <tr>
                                                    <td style="font-size: 9px;vertical-align: top;font-weight: bold;">Code</td>
                                                    <td style="font-size: 8px;vertical-align: top;">: <?=$style[serial][$j][product_code]?></td>
                                                </tr>
                                                <tr>
                                                    <td style="font-size: 9px;vertical-align: top;font-weight: bold;">Max. Price <span style="font-size: 7px;">(Inclusive of all Taxes)</span></td>
                                                    <td style="font-size: 8px;vertical-align: top;">: Rs. <?php if($style[serial][$j][sale_price]<1) { echo '0.00'; } else { echo $style[serial][$j][sale_price]; } ?>/-</td>
                                                </tr>
                                                
                                                <tr>
                                                    <td style="font-size: 9px;vertical-align: top;font-weight: bold;">Quantity</td>
                                                    <td style="font-size: 8px;vertical-align: top;">: 1U</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                    <td style="text-align: left;border-top:1px solid #000;border-right:1px solid #000;border-bottom:1px solid #000;vertical-align: top;width:40px;">
                                        <table >
                                            <tbody>
                                                <tr>
                                                    <td style="width:40px;">
                                                        <h6 style="font-size: 7px;line-height: 10px;margin:0px;padding:0px;"><span>Marketed & Sold By</span></h6>
                                                        <h6 style="font-size: 7px;line-height: 12     px;margin:0px;">Zobox Retails Pvt. Ltd.</h6>
                                                        <h6 style="margin:0px;line-height: 12px;"> <span style="font-size: 7px;vertical-align: top;">Regd Office</span>
                                                        <span style="font-size: 7px;vertical-align: top;">: 3rd Floor, 1 Kohat Enclave, Pitam Pura, Delhi, New Delhi 110033, INDIA</span> 
                                                        </h6>
                                                        <h6 style="margin:0px;line-height: 12px;">
                                                            <span style="font-size: 7px;vertical-align: top;">Tel</span>
                                                            <span style="font-size: 7px;vertical-align: top;">: +91-1135-111783</span> 
                                                        </h6>
                                                        <h6 style="font-size: 7px;margin:0px;line-height: 12px;"> <span>Email</span> <span>hello@zobox.in</span></h6>
                                                    </td>
                                                    
                                                    
                                                </tr>
                                                <tr>
                                                    <td  style="border-top:1px solid black;">
                                                        <!--<img src="https://barcode.tec-it.com/barcode.ashx?data=<?=$serial_list[serial]?>&amp;code=362" alt="product-barcode" style="width: 100px;padding-top: 12px;">-->
                          <!--<img src="https://barcode.tec-it.com/barcode.ashx?data=<?=$style[serial][$j][serial]?>&code=Code128&translate-esc=on" alt="product-barcode" style="padding-top: 5px;width:90px;height:70px;" class="barcode">-->


       <img alt='Barcode Generator TEC-IT'
       src='https://barcode.tec-it.com/barcode.ashx?data=<?=$style[serial][$j][serial]?>&code=Code128&multiplebarcodes=false&translate-esc=true&unit=Fit&dpi=96&imagetype=Gif&rotation=0&color=%23000000&bgcolor=%23ffffff&codepage=Default&qunit=Mm&quiet=0' style="padding-top: 5px;width:90px;height:70px;"/>
                                                        
                                                    </td>
                                                </tr>
                                                
​
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>






                                
                            </tbody>
                        </table>
                    </th>
                <?php } } ?>
                    
                </tr>
            <?php } ?>
            </tbody>
        </table>
             <?php 
         }
         else
         {
            ?>
             <table style="width: 520px;">
            <thead></thead>
            <tbody>
              <?php

              for($k=0;$k<count($style[serial]);$k++)
              {
                ?>
              

                <tr>
                    
                                      <th colspan="2">
                        <table class="table-box" style="width: 300px;">
                            <thead></thead>
                            <tbody>

                               
                                <tr>
                                    <td colspan="6" rowspan="1" style="text-align: left;border:1px solid #000;vertical-align: top;width:300px;">
                                        <table>
                                            <tbody style="vertical-align: top;">
                                              <tr >
                                                    <td style="font-size: 14px;vertical-align: top;font-weight: bold;">Color</td>
                                                    <td style="font-size: 14px;vertical-align: top;">: </td>
                                                </tr>
                                                <tr>
                                                    <td style="font-size: 14px;vertical-align: top;font-weight: bold;">Product Name</td>
                                                    <td style="font-size: 14px;vertical-align: top;">: <?php if(strlen($style[serial][$k][product_name])>40) { echo substr($style[serial][$k][product_name],0,40).'...'; } else { echo $style[serial][$k][product_name]; } ?></td>
                                                </tr>
                                                <tr>
                                                    <td style="font-size: 14px;vertical-align: top;font-weight: bold;">Variant</td>
                                                    <td style="font-size: 14px;vertical-align: top;">:  <?php if(strlen($style[serial][$k][product_name])>40) { echo substr($style[serial][$k][product_name],0,40).'...'; } else { echo $style[serial][$k][product_name]; } ?></td>
                                                </tr>
                                                <tr>
                                                    <td style="font-size: 14px;vertical-align: top;font-weight: bold;">Code</td>
                                                    <td style="font-size: 14px;vertical-align: top;">: <?=$style[serial][$k][product_code]?></td>
                                                </tr>
                                                <tr>
                                                    <td style="font-size: 14px;vertical-align: top;font-weight: bold;">Max. Price <h6 style="font-size: 10px;display:">(Inclusive of all Taxes)</h6></td>
                                                    <td style="font-size: 14px;vertical-align: top;">: Rs. <?php if($style[serial][$k][sale_price]<1) { echo '0.00'; } else { echo $style[serial][$k][sale_price]; } ?>/-</td>
                                                </tr>
                                                
                                                <tr>
                                                    <td style="font-size: 14px;vertical-align: top;font-weight: bold;">Quantity</td>
                                                    <td style="font-size: 14px;vertical-align: top;">: 1U</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                    <td style="text-align: left;border-top:1px solid #000;border-right:1px solid #000;border-bottom:1px solid #000;vertical-align: top;width:170px;">
                                        <table >
                                            <tbody>
                                                <tr>
                                                    <td style="width:170px;">
                                                        <h6 style="font-size: 11px;line-height: 10px;margin:0px;padding:0px;font-weight: normal;"><span>Marketed & Sold By</span></h6>
                                                        <h6 style="font-size: 11px;line-height: 12     px;margin:0px;font-weight: normal;">Zobox Retails Pvt. Ltd.</h6>
                                                        <h6 style="margin:0px;line-height: 12px;"> <span style="font-size: 11px;vertical-align: top;font-weight: normal;">Regd Office</span>
                                                        <span style="font-size: 11px;vertical-align: top;font-weight: normal;">: 3rd Floor, 1 Kohat Enclave, Pitam Pura, Delhi, New Delhi 110033, INDIA</span> 
                                                        </h6>
                                                        <h6 style="margin:0px;line-height: 12px;font-weight: normal;">
                                                            <span style="font-size: 11px;vertical-align: top;">Tel</span>
                                                            <span style="font-size: 11px;vertical-align: top;">: +91-1135-111783</span> 
                                                        </h6>
                                                        <h6 style="font-size: 11px;margin:0px;line-height: 12px;font-weight: normal;"> <span>Email</span> <span>hello@zobox.in</span></h6>
                                                    </td>
                                                    
                                                    
                                                </tr>
                                                <tr>
                                                    <td  style="border-top:1px solid black;">
                                                        <!--<img src="https://barcode.tec-it.com/barcode.ashx?data=<?=$serial_list[serial]?>&amp;code=362" alt="product-barcode" style="width: 100px;padding-top: 12px;">-->
                                                        


                                                        <img alt='Barcode Generator TEC-IT'
       src='https://barcode.tec-it.com/barcode.ashx?data=<?=$style[serial][$k][serial]?>&code=Code128&multiplebarcodes=false&translate-esc=true&unit=Fit&dpi=96&imagetype=Gif&rotation=0&color=%23000000&bgcolor=%23ffffff&codepage=Default&qunit=Mm&quiet=0' style="padding-top: 5px;width:180px;height:100px;"/>


                                                        
                                                    </td>
                                                </tr>
                                                
​
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>






                                
                            </tbody>
                        </table>
                    </th>
                </tr>
            <?php } ?>
            </tbody>
        </table>
            <?php
         }
         ?>

  </body>

</html>





