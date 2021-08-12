<!doctype html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Print Invoice #<?php echo $invoice['tid'] ?></title>
    <style>
        body {
            color: #2B2000;
            font-family: 'Helvetica';
        }

        .invoice-box {
            width: 210mm;
            height: 297mm;
            margin: auto;
            padding: 4mm;
            border: 0;
            font-size: 10pt;
            line-height: 14pt;
            color: #000;
        }

        table {
            width: 100%;
            line-height: 16pt;
            text-align: left;
            border-collapse: collapse;
        }

        .plist tr td {
            line-height: 12pt;
        }

        .subtotal {
            page-break-inside: avoid;
        }

        .subtotal tr td {
            line-height: 10pt;
            padding: 6pt;
        }

        .subtotal tr td {
            border: 1px solid #ddd;
        }

        .sign {
            text-align: right;
            font-size: 10pt;
            margin-right: 110pt;
        }

        .sign1 {
            text-align: right;
            font-size: 10pt;
            margin-right: 90pt;
        }

        .sign2 {
            text-align: right;
            font-size: 10pt;
            margin-right: 115pt;
        }

        .sign3 {
            text-align: right;
            font-size: 10pt;
            margin-right: 115pt;
        }

        .terms {
            font-size: 9pt;
            line-height: 16pt;
            margin-right: 20pt;
        }

        .invoice-box table td {
            padding: 5pt 4pt 5pt 4pt;
            vertical-align: top;
        }

        .invoice-box table.top_sum td {
            padding: 0;
            font-size: 9px;
        }

        .party tr td:nth-child(3) {
            text-align: center;
        }

        .invoice-box table tr.top table td {
            padding-bottom: 10pt;
            font-size: 9px !important;
        }

        table tr.top table td.title {
            font-size: 45pt;
            line-height: 45pt;
            color: #555;
        }

        table tr.information table td {
            padding-bottom: 10pt;
        }

        table tr.heading td {
            background: #515151;
            color: #FFF;
            padding: 6pt;
        }

        table tr.details td {
            padding-bottom: 10pt;
        }

        .invoice-box table tr.item td {
            border: 1px solid #ddd;
        }

        table tr.b_class td {
            border-bottom: 1px solid #ddd;
        }

        table tr.b_class.last td {
            border-bottom: none;
        }

        table tr.total td:nth-child(4) {
            border-top: 2px solid #fff;
            font-weight: bold;
        }

        .myco {
            width: 400pt;
        }

        .myco2 {
            width: 200pt;
        }

        .myw {
            width: 300pt;
            font-size: 14pt;
            line-height: 14pt;
        }

        .mfill {
            background-color: #eee;
        }

        .descr {
            font-size: 10pt;
            color: #515151;
        }

        .tax {
            font-size: 10px;
            color: #515151;
        }

        .t_center {
            text-align: right;
        }

        .party {
            border: #ccc 1px solid;

        }

        .top_logo {
            max-height: 100px;
            max-width: 150px;
        <?php if(LTR=='rtl') echo 'margin-left: 200px;' ?>
        }
        .party tbody td{
            font-size: 12px !important;
            padding: 4px 10px;
        }
        .party{
            margin-top: -40px !important;
        }
        .plist td{
            font-size: 12px !important;
            padding: 4px 10px;
        }
        .subtotal td{
            font-size: 10px !important;
            padding: 4px 10px;
        }
        .new-tb td{
           border: #ccc 1px solid; 
           text-align: center;
           font-size: 10px;
        }
    </style>
</head>
<body dir="<?= LTR ?>">
   
<div class="invoice-box">
    <br>
    <table class="party">
        <thead>
        <tr class="heading">
            <td style="padding:2px 10px;font-size: 12px;"> <?php if($invoice['type'] == 2){echo "Bill From";}else{echo $this->lang->line('Our Info');} ?>:</td>
            <td style="padding:2px 10px;font-size: 12px;"><?= $general['person'] ?>:</td>
        </tr>
        </thead>
        <tbody>
        <?php if($invoice['type'] != 2){?>
        <tr>
            
            <td><strong><?php $loc = location($invoice['loc']);
                    echo $loc['cname']; ?></strong><br>
                <?php echo
                    //$loc['address'] . '<br>' . $loc['city'] . ', ' . $loc['region'] . '<br>' . $loc['country'] . ' -  ' . $loc['postbox'] . '<br>' . $this->lang->line('Phone') . ': ' . $loc['phone'] . '<br> ' . $this->lang->line('Email') . ': ' . $loc['email'];
                    $loc['address'] . '<br>' . $loc['city'] . ', ' . $loc['region'] . '<br>' . $loc['country'] . ' -  ' . $loc['postbox'];
                if ($loc['taxid']) echo '<br>' . $this->lang->line('Tax') . ' ID: ' . $loc['taxid'];
                ?>
            </td>
            <td>
                <?php echo '<strong>' . $invoice['name'] . '</strong><br>';
                if ($invoice['company']) echo $invoice['company'] . '<br>';

                echo $invoice['address'] . '<br>' . $invoice['city'] . ', ' . $invoice['region'];
                if ($invoice['country']) echo '<br>' . $invoice['country'];
                if ($invoice['postbox']) echo ' - ' . $invoice['postbox'];
                if ($invoice['phone']) echo '<br>' . $this->lang->line('Phone') . ': ' . $invoice['phone'];
                if ($invoice['email']) echo '<br> ' . $this->lang->line('Email') . ': ' . $invoice['email'];

                if ($invoice['taxid']) echo '<br>' . $this->lang->line('Tax') . ' ID: ' . $invoice['taxid'];
                
                /* if (is_array($c_custom_fields)) {
                    echo '<br>';
                    foreach ($c_custom_fields as $row) {
                        echo $row['name'] . ': ' . $row['data'] . '<br>';
                    }
                } */
                ?>
                </ul>
            </td>
        </tr>
        <?php }
          elseif($invoice['type'] == 2){?>
        <tr>
            
            <td><strong><?php /* $loc = location($invoice['loc']);
                    echo $loc['cname']; */  echo $invoice['from_address']['cname']?></strong><br>
                <?php echo
                    //$loc['address'] . '<br>' . $loc['city'] . ', ' . $loc['region'] . '<br>' . $loc['country'] . ' -  ' . $loc['postbox'] . '<br>' . $this->lang->line('Phone') . ': ' . $loc['phone'] . '<br> ' . $this->lang->line('Email') . ': ' . $loc['email'];

                   /*
                    $loc['address'] . '<br>' . $loc['city'] . ', ' . $loc['region'] . '<br>' . $loc['country'] . ' -  ' . $loc['postbox'];
                if ($loc['taxid']) echo '<br>' . $this->lang->line('Tax') . ' ID: ' . $loc['taxid'];

                */
               

                $invoice['from_address_franchise']['address'] . '<br>' . $invoice['from_address_franchise']['city'] . ', ' . $invoice['from_address_franchise']['region'] . '<br>' . $invoice['from_address_franchise']['country'] . ' -  ' . $invoice['from_address_franchise']['postbox'];
                if ($invoice['from_address']['taxid']) echo '<br>' . $this->lang->line('Tax') . ' ID: ' . $invoice['from_address']['taxid'];

                ?>
            </td>
            <td>
                <?php
                 echo '<strong>' . $invoice['c_name'] . '</strong><br>';
                 /*
                if ($invoice['company']) echo $invoice['company'] . '<br>';

                echo $invoice['address'] . '<br>' . $invoice['city'] . ', ' . $invoice['region'];
                if ($invoice['country']) echo '<br>' . $invoice['country'];
                if ($invoice['postbox']) echo ' - ' . $invoice['postbox'];*/
                if ($invoice['c_phone']) echo $this->lang->line('Phone') . ': ' . $invoice['c_phone'];
                if ($invoice['c_email']) echo '<br> ' . $this->lang->line('Email') . ': ' . $invoice['c_email'];
                if ($invoice['c_address']) echo '<br>' . $this->lang->line('Tax') . ' ID: ' . $invoice['c_address'];
                /*if ($invoice['taxid']) echo '<br>' . $this->lang->line('Tax') . ' ID: ' . $invoice['taxid'];*/
                /* if (is_array($c_custom_fields)) {
                    echo '<br>';
                    foreach ($c_custom_fields as $row) {
                        echo $row['name'] . ': ' . $row['data'] . '<br>';
                    }
                } */
                ?> 
                </ul>
            </td>
        </tr>
        <?php }
        else{ //echo "<pre>"; print_r($invoice); echo "</pre>";  exit; ?>
        <tr>
            <td><strong><?php //$fromName = explode("-",$invoice['from_address']['cname']); echo $fromName[1];
            
            
                echo $invoice['from_address']['cname'];
            ?></strong><br>
                <?php echo
                    $invoice['from_address_franchise']['address'] . '<br>' . $invoice['from_address_franchise']['city'] . ', ' . $invoice['from_address_franchise']['region'] . '<br>' . $invoice['from_address_franchise']['country'] . ' -  ' . $invoice['from_address_franchise']['postbox'];
                $loc = location($invoice['loc']);
                if ($loc['taxid']) echo '<br>' . $this->lang->line('Tax') . ' ID: ' . $loc['taxid'];
                ?>
            </td>
            <td>
                <?php echo '<strong>' . $invoice['to_address']['name'] . '</strong><br>';
                if ($invoice['to_address']['company']) echo $invoice['to_address']['company'] . '<br>';

                echo $invoice['to_address']['address'];
                if ($invoice['to_address']['phone']) echo '<br>' . $this->lang->line('Phone') . ': ' . $invoice['to_address']['phone'];
                if ($invoice['to_address']['email']) echo '<br> ' . $this->lang->line('Email') . ': ' . $invoice['to_address']['email'];

                if ($invoice['to_address']['taxid']) echo '<br>' . $this->lang->line('Tax') . ' ID: ' . $invoice['to_address']['taxid'];
                
                ?>
                </ul>
            </td>
        </tr>
        <?php } ?><?php if (@$invoice['name_s']) { ?>
            <tr>
                <td>
                    <?php echo '<strong>' . $this->lang->line('Shipping Address') . '</strong>:<br>';
                    echo $invoice['name_s'] . '<br>';
                    echo $invoice['address_s'] . '<br>' . $invoice['city_s'] . ', ' . $invoice['region_s'];
                    if ($invoice['country_s']) echo '<br>' . $invoice['country_s'];
                    if ($invoice['postbox_s']) echo ' - ' . $invoice['postbox_s'];
                    if ($invoice['phone_s']) echo '<br>' . $this->lang->line('Phone') . ': ' . $invoice['phone_s'];
                    if ($invoice['email_s']) echo '<br> ' . $this->lang->line('Email') . ': ' . $invoice['email_s'];

                    ?>
                </td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
    <br>
    <table class="plist" cellpadding="0" cellspacing="0">
        <tr class="heading">
            <td style="width: 1rem;" style="padding:2px 10px;font-size: 12px;">#</td>
            <td style="padding:2px 10px;font-size: 12px;"><?php echo $this->lang->line('Description') ?></td>
            <td style="padding:2px 10px;font-size: 12px;"><?php echo $this->lang->line('HSN') ?></td>
            <td style="padding:2px 10px;font-size: 12px;"><?php echo $this->lang->line('Price') ?></td>
            <td style="padding:2px 10px;font-size: 12px;"><?php echo $this->lang->line('Qty') ?></td>
            <td style="padding:2px 10px;font-size: 12px;"><?php echo $this->lang->line('CGST') ?></td>
            <?php  echo '<td style="padding:2px 10px;font-size: 12px;">' . $this->lang->line('SGST') . '</td>';
                    echo '<td style="padding:2px 10px;font-size: 12px;">' . $this->lang->line('Discount') . '</td>'; ?>
            <td class="t_center" style="padding:2px 10px;font-size: 12px;">
                <?php echo $this->lang->line('SubTotal') ?>
            </td>
        </tr>
        <?php
        $fill = true;
        $sub_t = 0;
        $sub_t_col = 3;
        $n = 1;
        $marginal_gst_price = 0;
        $grand_price = 0;
        $total_cgst = 0;
        $total_sgst = 0;
        $pcat = array();
        $marginal_pid = array();
        $pid = array();
        foreach ($products as $row) {
            $cols = 4;
            if ($fill == true) {
                $flag = ' mfill';
            } else {
                $flag = '';
            }
            
            if($row['marginal_product_type']==2)
            {
             $marginal_gst_price += $row['marginal_gst_price'];
             $cgst = $row['marginal_gst_price']/2;
             $sgst = $row['marginal_gst_price']/2;
             $total_cgst += $cgst;  
             $total_sgst += $sgst; 

             $marginal_pid[] = 1;
            }
            else
            {
             $marginal_gst_price = $marginal_gst_price; 
             $cgst = $row['totaltax']/2;
             $sgst = $row['totaltax']/2;
             $total_cgst += $cgst;  
             $total_sgst += $sgst;
             if($row['product_info'][0]['pcat']!=14)
             {
             $pid[] = 1;
             }
             
            }

           
             

            $grand_price += $row['subtotal'];
           
            
            $sub_t += $row['price'] * $row['qty'];


            //if ($row['serial']) $row['product_des'] .= ' - ' . $row['serial'];
            //if ($row['serial']) $row['product_des'] .= ' - ' . $row['serial'];
            if($row['product_info'][0]['pcat']==14)

            {

                $pcat[]=1;
                echo '<tr class="item' . $flag . '">  <td>' . $n . '</td>
                            <td>' . $row['product_info'][0]['product_name'] .'</td>
                            <td>' . $row['code'] . '</td>
                            <td style="width:12%;">' . amountExchange($row['price'], $invoice['multi'], $invoice['loc']) . '</td>
                            <td style="width:12%;" >' . +$row['qty'] . $row['unit'] . '</td> 
                            <td style="width:12%;" >'.amountFormat_s($cgst).' (9%)</td>   ';
            }

            else
            {
                if($row['product_info'][0]['unit_name']!='')
                {


            echo '<tr class="item' . $flag . '">  <td>' . $n . '</td>
                            <td>' . $row['product_info'][0]['product_name'] . '-('.$row['product_info'][0]['unit_name'].')<br>'.$row['serial'].'</td>
                            <td>' . $row['code'] . '</td>
                            <td style="width:12%;">' . amountExchange($row['price'], $invoice['multi'], $invoice['loc']) . '</td>
                            <td style="width:12%;" >' . +$row['qty'] . $row['unit'] . '</td>   
                            <td style="width:12%;" >'. amountFormat_s($cgst) .' (9%)</td> ';
                }
                else
                {
                    echo '<tr class="item' . $flag . '">  <td>' . $n . '</td>
                            <td>' . $row['product_info'][0]['product_name'] . '<br>'.$row['serial'].'</td>
                            <td>' . $row['code'] . '</td>
                            <td style="width:12%;">' . amountExchange($row['price'], $invoice['multi'], $invoice['loc']) . '</td>
                            <td style="width:12%;" >' . +$row['qty'] . $row['unit'] . '</td>   
                            <td style="width:12%;" >'.amountFormat_s($sgst).' (9%)</td> ';
                }
            }
            //if ($invoice['tax'] > 0) {
                $cols++;
                echo '<td style="width:16%;">' . amountExchange($sgst) . ' <span class="tax">(9%)</span></td>';
           // }
            //if ($invoice['discount'] > 0) {
                $cols++;
                echo ' <td style="width:16%;">' . amountExchange($row['totaldiscount'], $invoice['multi'], $invoice['loc']) . '</td>';
           // }
            echo '<td class="t_center">' . amountExchange($row['subtotal'], $invoice['multi'], $invoice['loc']) . '</td></tr>';

            if ($row['product_des']) {
                $cc = $cols++;

                echo '<tr class="item' . $flag . ' descr">  <td> </td>
                            <td colspan="' . $cc . '">' . $row['product_des'] . '&nbsp;</td>
                            
                        </tr>';
            }
            if (CUSTOM) {
                $p_custom_fields = $this->custom->view_fields_data($row['pid'], 4, 1);

                if (is_array($p_custom_fields[0])) {
                    $z_custom_fields = '';

                    foreach ($p_custom_fields as $row) {
                        $z_custom_fields .= $row['name'] . ': ' . $row['data'] . '<br>';
                    }

                    echo '<tr class="item' . $flag . ' descr">  <td> </td>
                            <td colspan="' . $cc . '">' . $z_custom_fields . '&nbsp;</td>
                            
                        </tr>';
                }
            }
            $fill = !$fill;
            $n++;
        }

        if ($invoice['shipping'] > 0) {

            $sub_t_col++;
        }
        if ($invoice['tax'] > 0) {
            $sub_t_col++;
        }
        if ($invoice['discount'] > 0) {
            $sub_t_col++;
        }
        ?>


    </table>
    <br> <?php if (is_array(@$i_custom_fields)) {

        foreach ($i_custom_fields as $row) {
            echo $row['name'] . ': ' . $row['data'] . '<br>';
        }
        echo '<br>';
    }
    ?>
    <table class="new-tb" cellpadding="0" cellspacing="0">
        
        <tr>
            <td colspan="5"><strong style="font-size:12px;">Summary</strong></td>
        </tr>
        <tr>
            <td style="padding:2px 10px;font-size: 12px;">SubTotal</td>
            <td style="padding:2px 10px;font-size: 12px;">Tax Bifurcation</td>
            <td style="padding:2px 10px;font-size: 12px;">CGST(9%) </td>
            <td style="padding:2px 10px;font-size: 12px;">SGST(9%) </td>
            <td style="padding:2px 10px;font-size: 12px;">IGST(18%) </td>
        </tr>
        <tr>
            <td><?php echo amountExchange($grand_price); ?></td>
            <td><?php echo amountExchange($marginal_gst_price); ?></td>
            <td><?php echo amountExchange($total_cgst); ?></td>
            <td><?php echo amountExchange($total_sgst); ?></td>
            <td></td>

        </tr>
        <tr>
            <td style="padding:2px 10px;font-size: 12px;"><strong>Status</strong></td>
            <td style="padding:2px 10px;font-size: 12px;"><strong>Total Tax</strong></td>
            <td style="padding:2px 10px;font-size: 12px;"><strong>Total Amount</strong></td>
            <td style="padding:2px 10px;font-size: 12px;" colspan="2"><strong>Paid Amount</strong></td>
        </tr>
        <tr>
            <td>Paid</td>
            <td><?php echo amountExchange($total_cgst+$total_sgst); ?></td>
            <td><?php echo amountExchange($grand_price); ?></td>
            <td colspan="2"><?php echo amountExchange($grand_price); ?></td>
        </tr>
    </table>
    <!--<table class="subtotal">


        <tr>
            <td class="myco2" rowspan="7"><br>
                <p><?php echo '<strong>' . $this->lang->line('Status') . ': ' . $this->lang->line(ucwords($invoice['status'])) . '</strong></p>';
                    if (!$general['t_type']) {
                        echo '<br><p>' . $this->lang->line('Total Amount') . ': ' . amountExchange($invoice['total'], $invoice['multi'], $invoice['loc']) . '</p><br><p>';
                        if (@$round_off['other']) {
                            $final_amount = round($invoice['total'], $round_off['active'], constant($round_off['other']));
                            echo '<p>' . $this->lang->line('Round Off') . ' ' . $this->lang->line('Amount') . ': ' . amountExchange($final_amount, $invoice['multi'], $invoice['loc']) . '</p><br><p>';
                        }

                        echo $this->lang->line('Paid Amount') . ': ' . amountExchange($invoice['pamnt'], $invoice['multi'], $invoice['loc']);
                    }

                    if ($general['t_type'] == 1) {
                        echo '<hr>' . $this->lang->line('Proposal') . ': </br></br><small>' . $invoice['proposal'] . '</small>';
                    }
                    ?></p>
            </td>
            <td><strong><?php echo $this->lang->line('Summary') ?> :</strong></td>
            <td>&nbsp;</td>
        </tr>
        <tr class="f_summary">
            <td><?php echo $this->lang->line('SubTotal') ?> :</td>
            <td><?php echo amountExchange($sub_t, $invoice['multi'], $invoice['loc']); ?></td>
        </tr>
        <?php
        if($marginal_gst_price>0)
        {
            ?>
            <tr class="f_summary">
            <td>Tax BIfurcation :</td>
            <td><?php echo amountExchange($marginal_gst_price); ?></td>
        </tr>
        <tr class="f_summary">
            <td>CGST(0%) :</td>
            <td><?php echo amountExchange($marginal_gst_price); ?></td>
        </tr>
        <tr class="f_summary">
            <td>SGST(0%) :</td>
            <td><?php echo amountExchange($marginal_gst_price); ?></td>
        </tr>
        <tr class="f_summary">
            <td>IGST(18%) :</td>
            <td><?php echo amountExchange($marginal_gst_price); ?></td>
        </tr>
            <?php
        }
         /*if ($invoice['tax'] > 0) {
            echo '<tr>
            <td> GST :</td>
            <td>' . amountExchange($invoice['tax'], $invoice['multi'], $invoice['loc']) . '</td>
        </tr>';
        }*/
        if ($invoice['discount'] > 0) {
            echo '<tr>
            <td>' . $this->lang->line('Total Discount') . ':</td>
            <td>' . amountExchange($invoice['discount'], $invoice['multi'], $invoice['loc']) . '</td>
        </tr>';
        }
        if ($invoice['shipping'] > 0) {
            echo '<tr>
            <td>' . $this->lang->line('Shipping') . ':</td>
            <td>' . amountExchange($invoice['shipping'], $invoice['multi'], $invoice['loc']) . '</td>
        </tr>';
        }
        ?>
        <tr>
            <td><?php echo $this->lang->line('Balance Due') ?>:</td>
            <td><strong><?php $rming = $invoice['total'] - $invoice['pamnt'];
    if ($rming < 0) {
        $rming = 0;
    }
    if (@$round_off['other']) {
        $rming = round($rming, $round_off['active'], constant($round_off['other']));
    }
    echo amountExchange($rming, $invoice['multi'], $invoice['loc']);
    echo '</strong></td>
        </tr>
        </table><br><div class="sign">' . $this->lang->line('Authorized person') . '</div><div class="sign1"><img src="' . FCPATH . 'userfiles/employee_sign/' . $employee['sign'] . '" width="160" height="50" border="0" alt=""></div><div class="sign2">(' . $employee['name'] . ')</div><div class="terms">' . $invoice['notes'];

   
    ?></strong>
</td>
</tr>
</table>-->
<table>
    <thead>
        <tr>
            <?php 
                 
                        if(count($pid)>0 || count($marginal_pid)>0)
                        {
            ?>
            <th style="font-size:12px;padding-bottom: 0px;margin-bottom: 0px;padding-top: 20px;">Warranty Policy</th>
            <?php }
             if(count($marginal_pid)>0)
             {
             ?>
            <th style="font-size:12px;padding-bottom: 0px;margin-bottom: 0px;padding-top: 20px;">Terms & Conditions</th>
        <?php } ?>
        </tr>
    </thead>
    <tbody style="padding-top: 0px !important;">
        <tr>
            <?php
            if(count($pid)>0  || count($marginal_pid)>0)
                        {
                            ?>
            <td style="width:50%;padding-top: 0px;">
                <table>
                    <tbody>
                        
                     
                        <tr>
                            <td style="font-size:10px;padding:0px !important;">1. The Limited Warranty Period of the Device is Six (06) months from the date of Purchase.</td>
                        </tr>
                        <tr>
                            <td style="font-size:10px;padding:0px !important;">2. Warranty Covers Only the Functional Defects in the Device.</td>
                        </tr>
                        <tr>
                            <td style="font-size:10px;padding:0px !important;">3. Warranty Does Not Cover Any Damage, Related to the Screen of the Device (Visible Lines, Blank Screen, or Even the Dead Pixels). </td>
                        </tr>
                        <tr>
                            <td style="font-size:10px;padding:0px !important;">4. Warranty is Void if Any Unauthorised Repair / Physical Damage / Liquid Damage is Found Internally/Externally in the Device.</td>
                        </tr>
                        <tr>
                            <td style="font-size:10px;padding:0px !important;">
                                <strong>For Queries / Claim</strong>
                            </td>
                        </tr>
                        <tr>
                            <td style="font-size:10px;padding:0px !important;">(Mon To Sat) 09:00 am To 06:30 pm</td>
                        </tr>
                        <tr>
                            <td style="font-size:10px;padding:0px !important;">Mob&nbsp;&nbsp;&nbsp;&nbsp;: &nbsp;&nbsp;83 685 73 109</td>
                        </tr>
                        <tr>
                            <td style="font-size:10px;padding:0px !important;">Email&nbsp;&nbsp;:&nbsp;&nbsp; care@zobox.in</td>
                        </tr>
                        <tr>
                            <td style="font-size:10px;padding:0px !important;">Web &nbsp;&nbsp;&nbsp;: &nbsp;&nbsp;care.zobox.in</td>
                        </tr>
                    </tbody>
                </table>
            </td>
        <?php }
        if(count($marginal_pid)>0)
             {
                ?>

            <td style="width:50%;padding-top: 0px;">
                <table>
                    <tbody>
                        <tr>
                            <td style="font-size:10px;padding:0px !important;line-height: 20px;">1. Value of supply is determined in accordance to section 15(5) of the Central Goods and Services Tax Act read with Rule 32(5) of "Determination of Value of Supply" rules. The credit for GST input shall not be available to the buyer if buyer follow the same valuation rule.</td>
                        </tr>
                        <tr>
                            <td style="font-size:10px;padding:0px !important;line-height: 20px;">2.Goods once sold cannot be returned and the buyer assumes all responsibility of goods once taken out of Seller's premises physically by Buyer or Buyer's representative(s).</td>
                        </tr>
                        <tr>
                            <td style="font-size:10px;padding:0px !important;line-height: 20px;">3.Buyer agrees to save and hold seller harmless from any claims, demands, liabilities, costs, expenses or judgement arising in whole or in part, directly or indirectly, out of the negligence of Buyer involving the goods supplied by Seller.</td>
                            
                        </tr>
                    </tbody>
                </table>
            </td>
        <?php } ?>
        </tr>
    </tbody>
</table>
</div>
</div>
</body>
</html>