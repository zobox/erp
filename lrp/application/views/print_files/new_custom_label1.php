<!doctype html>
<html lang="en">
  <head> 
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;500;700;900&display=swap" rel="stylesheet">
​
  <title><?=$lebal_detail->product_name;?></title>
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
    
    <table style="width:276px;">
            <thead></thead>
            <tbody>
                <tr>
                    <td colspan="2" style="text-align:center;width: 100%;padding:0px;">
                        <table class="table-box" style="width:100%;border-spacing: 0px;">
                            <thead></thead>
                            <tbody>
                                <tr>
                                    <td style="text-align: center;">
                                        <img src="<?=base_url()?>/userfiles/label/default.png" style="height: 40px;" />
                                    </td>
                                    <td style="padding: 5px 0px 0px; text-align: center;">
                                        <!--<img src="<?=base_url()?>/userfiles/label/bar.png" style="height:30px;width: 160px;">-->
                                        <img alt='Barcode Generator TEC-IT' src='https://barcode.tec-it.com/barcode.ashx?data=<?=$lebal_detail->serial?>&code=Code128&multiplebarcodes=false&translate-esc=true&unit=Fit&dpi=96&imagetype=Gif&rotation=0&color=%23000000&bgcolor=%23ffffff&codepage=Default&qunit=Mm&quiet=0' style="height:40px;width: 160px;" >
                                        
                                    </td>
                                    <td style="width:40px;height: 40px;align-items: center;justify-content: center;font-size: 32px;margin-bottom: 4px;">G<?=$lebal_detail->jobwork_service_type;?>
                                    </td>
                                </tr>
                                <tr>
                    <td></td>
                </tr>
                <tr>
                    <td></td>
                </tr>

                                <tr>
                                    <td rowspan="1" colspan="3" style="border:1px solid #000;padding:2px 10px;border-radius: 4px;font-size: 11px;">
                                        <strong><?=$lebal_detail->product_name;?> </strong> 
                                    </td>
                                </tr>
                                
                            </tbody>
                        </table>
                    </td>
                   
                </tr>
                <tr>
                    <td></td>
                </tr>
                <tr>
                    <td></td>
                </tr>
                <tr>
                    <td style="border:1px solid #000;border-radius: 4px;" colspan="1">
                        <table style="width:270px;">
                            <tbody>
                                <tr>
                                    <td style="width:100px;text-align: left;font-size: 14px;padding-bottom: 0px;font-size: 11px;">ZUPC</td>
                                    <td style="text-align: left;font-size: 14px;padding-bottom: 5px;font-size: 11px;">: <strong><?=$lebal_detail->zupc_code?></strong></td>
                                </tr>
                                <tr>
                                    <td style="width:100px;text-align: left;font-size: 14px;padding-bottom: 0px;font-size: 11px;">Color</td>
                                    <td style="text-align: left;font-size: 14px;padding-bottom: 5px;font-size: 11px;">: <strong><?=$lebal_detail->colour_name;?></strong></td>
                                </tr>
                                <tr>
                                    <td style="width:100px;text-align: left;font-size: 14px;padding-bottom: 0px;font-size: 11px;">Varient</td>
                                    <td style="text-align: left;font-size: 14px;padding-bottom: 5px;font-size: 11px;">:<strong> <?=$lebal_detail->varient;?></strong></td>
                                </tr>
                                
                                
                            </tbody>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td></td>
                </tr>
                <tr>
                    <td></td>
                </tr>
                <tr>
                    <td style="width:100px;text-align: center;font-size: 14px;padding-bottom: 0px;font-size: 12px;border:1px solid #000;border-radius: 4px;padding:3px 10px;" colspan="2"><strong>100% Working Phone</strong></td>
                </tr>
            </tbody>
        </table>
    
  </body>
</html>




