<!DOCTYPE html>
<html>
<head>
<title>Page Title</title>
<style>
    .tbl-bg tr:nth-of-type(odd) {
    background-color: rgba(0,0,0,.05);
}
</style>
</head>
<body>
    <table style="width: 100%;margin:0px auto;">
        <tr>
            <td> 
                <img src="http://13.233.62.90/zobox/userfiles/company/1618553743309630865.png" style="width: 40px;">
            </td>
            <td style="font-size: 40px;font-weight: 500;font-family: arial;text-align: center;width: 55%;">Zobox Retails Pvt Ltd</td>
            <td style="">
                <table style="width: 100%;text-align: right;">
                    <tr>
                        <td style="font-family: arial;font-size: 16px;">Date: <strong><?=date('d M Y',strtotime(substr($products[0]->date_created,0,10)));?></strong></td>

                    </tr>
                    <tr>
                        <td style="font-family: arial;font-size: 18px;">Issue ID: <strong>ISU_<?=$products[0]->issue_id?></strong></td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td colspan="3" style="padding-top: 40px;padding-bottom: 40px;">
                <table>
                    <tr>
                        <td style="font-family: arial;font-size: 16px;padding-bottom: 10px;">Zupc: </td>
                        <td style="font-family: arial;font-size: 16px;padding-bottom: 10px;"><?=$products[0]->zupc?></td>
                    </tr>
                    <tr>
                        <td style="font-family: arial;font-size: 16px;padding-bottom: 10px;">Product: </td>
                        <td style="font-family: arial;font-size: 16px;padding-bottom: 10px;"><?=$products[0]->product_name?></td>
                    </tr>
                    <tr>
                        <td style="font-family: arial;font-size: 16px;padding-bottom: 10px;">Quantity: </td>
                        <td style="font-family: arial;font-size: 16px;padding-bottom: 10px;"><?=count($component_list)?></td>
                    </tr>
                    <tr>
                         <?php
						 
						 /* echo "<pre>";
						 print_r($component_list);
						 echo "</pre>";
						 echo "HHHHHHHHHHH"; exit; */
						 
                        $serial_no = array();
                        for($i=0;$i<count($component_list);$i++)
                        {
                            $serial_no[] = $component_list[$i]->product_serial;
                            $vals1[] = $component_list[$i]->component_name.'-'.$component_list[$i]->product_name.'-'.$component_list[$i]->unit;
                            $zupc[] = $component_list[$i]->warehouse_product_code;
                            $colour_name[] = $component_list[$i]->colour_name;
                        }
                        $serial = implode(', ',$serial_no);
                        ?>
                        <td style="font-family: arial;font-size: 16px;padding-bottom: 10px;">IMEI / Serial No: </td>
                        <?php if(count($serial_no)>0) {?><td style="font-family: arial;font-size: 16px;padding-bottom: 10px;"><?=$serial?></td><?php } ?>
                    </tr>
                </table>
            </td>
        </tr>
        <?php
        $vals = array_count_values($vals1);
        $zupc2 = array_unique($zupc);
        $zupc1 = array_values($zupc2);

        $colour1 = array_unique($colour_name);

        $colour_list = array_values($colour1);

        
        if(count($vals)>0)
        {
            ?>
        <tr>
            <td colspan="3">
                <table  style="width: 100%;margin:auto;border-collapse: collapse;text-align: center;">
                    <thead>
                        <tr>
                            <th style="width: 25%;border-collapse: collapse;border: 1px solid #dee2e6;padding: 16px;font-family: arial;">Component ZUPC</th>
                            <th style="width: 25%;border-collapse: collapse;border: 1px solid #dee2e6;padding: 16px;font-family: arial;">Component Name</th>
                            
                            <th style="width: 25%;border-collapse: collapse;border: 1px solid #dee2e6;padding: 16px;font-family: arial;">Qty</th>
                            <th style="width: 25%;border-collapse: collapse;border: 1px solid #dee2e6;padding: 16px;font-family: arial;">Color</th>
                        </tr>
                    </thead>
                    <tbody class="tbl-bg">
                        <?php
                        $k=0;
                        foreach($vals as $key=>$row)
                        {
                           
                            ?>
                        <tr >
                            <td style="border: 1px solid #dee2e6;padding: 16px;font-family: arial;"><?=$zupc1[$k]?></td>
                            <td style="border: 1px solid #dee2e6;padding: 16px;font-family: arial;"><?=$key?></td>
                            
                            <td style="border: 1px solid #dee2e6;padding: 16px;font-family: arial;"><?=$row?></td>
                            <td style="border: 1px solid #dee2e6;padding: 16px;font-family: arial;"><?=$colour_list[$k]?></td>
                        </tr>

                       <?php $k++; } ?>
                        <tr>
                            <td style="padding: 16px;font-family: arial;font-weight: bold;border: 1px solid #dee2e6;border-right:  none;" colspan="2">
                               Total Quantity 
                            </td>
                            <td style="padding: 16px;font-family: arial;font-weight: bold;border:1px solid #dee2e6;border-right: none;">
                                <?=count($component_list)?>
                            </td>
                            <td style="border: 1px solid #dee2e6;border-left: none;"></td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
        <?php } ?>
        <tr>
            <td colspan="3">
                <table  style="width: 100%;margin:auto;border-collapse: collapse;text-align: center;">
                    <thead>
                        <tr>
                            <th style="width: 33%;border-collapse: collapse;font-family: arial;padding-top: 50px;text-align: center;">
                                <table style="width: 50%;text-align: center;margin:0px auto;">
                                    <tr>
                                        <td>Issued By</td>
                                        
                                    </tr>
                                    
                                    
                                </table>
                            </th>
                            <th style="width: 33%;border-collapse: collapse;font-family: arial;padding-top: 50px;text-align: center;">
                                <table style="width: 50%;text-align: center;margin:0px auto;">
                                    <tr>
                                        <td>Checked By</td>
                                        
                                    </tr>
                                    
                                    
                                </table>
                            </th>
                            <th style="width: 33%;border-collapse: collapse;font-family: arial;padding-top: 50px;text-align: center;">
                                <table style="width: 50%;text-align: center;margin:0px auto;">
                                    <tr>
                                        <td>Received By</td>
                                        
                                    </tr>
                                    
                                    
                                </table>
                            </th>
                            
                        </tr>
                    </thead>
                    
                </table>
            </td>
        </tr>
    </table>


</body>
</html>
