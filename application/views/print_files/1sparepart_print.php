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
                <img src="http://13.233.62.90/zobox/userfiles/company/1618553743309630865.png" style="width: 50px;">
            </td>
            <td style="font-size: 40px;font-weight: 500;font-family: arial;text-align: center;width: 55%;margin-left:-200px;">Zobox Retails Pvt Ltd</td>
            <td>
                <table style="width: 100%;text-align: right;">
                    <tr style="margin-left:-50px;">
                        <td style="font-family: arial;font-size: 16px;">Date: <strong><?=date('d M Y',strtotime(substr($products[0]->date_created,0,10)));?></strong></td>

                    </tr>
                    <tr>
                        <td style="font-family: arial;font-size: 18px;">Issue ID: <strong>ISU_<?=$products[0]->issue_id?></strong></td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td colspan="3">
            <table style="width: 100%;margin:0px auto;border-collapse: collapse;margin-top:40px;text-align: center;">
                <thead>
                    <tr>
                        <th style="border-collapse: collapse;border: 1px solid #dee2e6;padding: 16px;font-family: arial;width: 20%;">ZUPC</th>
                        <th style="border-collapse: collapse;border: 1px solid #dee2e6;padding: 16px;font-family: arial;width: 60%;">Product Label Name</th>
                        <th style="border-collapse: collapse;border: 1px solid #dee2e6;padding: 16px;font-family: arial;width: 20%;">Qty</th>
                    </tr>
                    
                </thead>
                <tbody>
                    
                    <tr>
                        <td style="border: 1px solid #dee2e6;padding: 16px;font-family: arial;"><?=$products[0]->zupc?></td>
                        <td style="border: 1px solid #dee2e6;padding: 16px;font-family: arial;"><?=$products[0]->product_name?></td>
                        <td style="border: 1px solid #dee2e6;padding: 16px;font-family: arial;"><?=count($component_list)?></td>
                    </tr>
                    <tr>
                        <?php
                        $serial_no = array();
                        for($i=0;$i<count($component_list);$i++)
                        {
                            $serial_no[] = $component_list[$i]->serial;
                            $vals1[] = $component_list[$i]->component_name;
                            $zupc[] = $component_list[$i]->warehouse_product_code;
                        }
                        $serial = implode(', ',$serial_no);
                        ?>
                        <th style="border: 1px solid #dee2e6;padding: 16px;font-family: arial;">Serial No.</th>
                        <td style="border: 1px solid #dee2e6;padding: 16px;font-family: arial;" colspan="2"><?=$serial?></td>
                        
                    </tr>
                </tbody>
            </table>
            </td>
        </tr> 
        <?php
        $vals = array_count_values($vals1);
        $zupc2 = array_unique($zupc);
        $zupc1 = array_values($zupc2);
        
        if(count($vals)>0)
        {
            ?>
        <tr>
            <td colspan="3">
                <table  style="width: 100%;margin:auto;border-collapse: collapse;text-align: center;">
                    <thead>
                        <tr>
                            <th style="width: 25%;border-collapse: collapse;border: 1px solid #dee2e6;padding: 16px;font-family: arial;">Spare Parts ZUPC</th>
                            <th style="width: 25%;border-collapse: collapse;border: 1px solid #dee2e6;padding: 16px;font-family: arial;">Spare Parts Name</th>
                            <th style="width: 25%;border-collapse: collapse;border: 1px solid #dee2e6;padding: 16px;font-family: arial;">Color</th>
                            <th style="width: 25%;border-collapse: collapse;border: 1px solid #dee2e6;padding: 16px;font-family: arial;">Qty</th>
                        </tr>
                    </thead>
                    <tbody class="tbl-bg">
                        <?php
                        $k=0;
                        foreach($vals as $key=>$row)
                        {

                            ?>
                        <tr >
                            <td style="border: 1px solid #dee2e6;padding: 16px;font-family: arial;"><?=$zupc1[$k++]?></td>
                            <td style="border: 1px solid #dee2e6;padding: 16px;font-family: arial;"><?=$key?></td>
                            <td style="border: 1px solid #dee2e6;padding: 16px;font-family: arial;"></td>
                            <td style="border: 1px solid #dee2e6;padding: 16px;font-family: arial;"><?=$row?></td>
                        </tr>
                    <?php } ?>
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
                            <th style="width: 33%;border-collapse: collapse;font-family: arial;padding-top: 50px;">
                                <table style="width: 90%;text-align: left;">
                                    <tr>
                                        <td>Issued By</td>
                                        <td style="border-bottom: 1px solid #dee2e6;width: 60%;padding-right: 10%;"></td>
                                    </tr>
                                    <tr style=" margin-top: 40px;">
                                        <td style="padding-top: 40px;">Date</td>
                                        <td style="border-bottom: 1px solid #dee2e6;width: 60%;padding-right: 10%;padding-top: 40px;"></td>
                                    </tr>
                                </table>
                            </th>
                            <th style="width: 33%;border-collapse: collapse;font-family: arial;padding-top: 50px;">
                                <table style="width: 90%;text-align: left;">
                                    <tr>
                                        <td>Checked  By</td>
                                        <td style="border-bottom: 1px solid #dee2e6;width: 60%;padding-right: 10%;"></td>
                                    </tr>
                                    <tr style=" margin-top: 40px;">
                                        <td style="padding-top: 40px;">Date</td>
                                        <td style="border-bottom: 1px solid #dee2e6;width: 60%;padding-right: 10%;padding-top: 40px;"></td>
                                    </tr>
                                </table>
                            </th>
                            <th style="width: 33%;border-collapse: collapse;font-family: arial;padding-top: 50px;">
                                <table style="width: 90%;text-align: left;">
                                    <tr>
                                        <td>Received  By</td>
                                        <td style="border-bottom: 1px solid #dee2e6;width: 60%;padding-right: 10%;"></td>
                                    </tr>
                                    <tr style=" margin-top: 40px;">
                                        <td style="padding-top: 40px;">Date</td>
                                        <td style="border-bottom: 1px solid #dee2e6;width: 60%;padding-right: 10%;padding-top: 40px;"></td>
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
