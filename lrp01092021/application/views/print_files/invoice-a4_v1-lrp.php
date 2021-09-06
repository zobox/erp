<?php 
/* echo "<pre>";
print_r($invoice);
echo "</pre>"; exit; */
?>

<!doctype html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
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
            font-size: 12pt;
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
            padding: 10pt 4pt 8pt 4pt;
            vertical-align: top;
        }

        .invoice-box table.top_sum td {
            padding: 0;
            font-size: 12pt;
        }

        .party tr td:nth-child(3) {
            text-align: center;
        }

        .invoice-box table tr.top table td {
            padding-bottom: 20pt;
        }

        table tr.top table td.title {
            font-size: 45pt;
            line-height: 45pt;
            color: #555;
        }

        table tr.information table td {
            padding-bottom: 20pt;
        }

        table tr.heading td {
            background: #515151;
            color: #FFF;
            padding: 6pt;
        }

        table tr.details td {
            padding-bottom: 20pt;
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
            max-height: 180px;
            max-width: 250px;
        <?php if(LTR=='rtl') echo 'margin-left: 200px;' ?>
        }

    </style>
</head>
<body dir="<?= LTR ?>">
<div class="invoice-box">
    <br>
    <table class="party" style="margin-top:30px;">
        <thead>
        <tr class="heading">
            <td colspan='2'> <?php if($invoice['type'] == 2){echo "Bill From";}else{echo $this->lang->line('Our Info');} ?>:</td>
            <!--<td><?php if($invoice['type']==7){ echo "Bill To"; }else{ $general['person']; } ?>:</td>-->
        </tr>
        </thead>
        <tbody>
		<?php if($invoice['type'] != 2){?>
        <tr>
            <td style="width:60%;">
                <?php 
				echo '<strong>' . $invoice['name'] . '</strong><br>';
					if ($invoice['company']) echo $invoice['company'] . '<br>';

					echo $invoice['address'] . '<br>' . $invoice['city'] . ', ' . $invoice['region'];
					if ($invoice['country']) echo '<br>' . $invoice['country'];
					if ($invoice['postbox']) echo ' - ' . $invoice['postbox'];
					if ($invoice['phone']) echo '<br>' . $this->lang->line('Phone') . ': ' . $invoice['phone'];
					if ($invoice['email']) echo '<br> ' . $this->lang->line('Email') . ': ' . $invoice['email'];

					if ($invoice['gst_number']) echo '<br>' . $this->lang->line('Tax') . ' ID: ' . $invoice['gst_number'];
					
					
						if (is_array($c_custom_fields)) {
							echo '<br>';
							foreach ($c_custom_fields as $row) {
								echo $row['name'] . ': ' . $row['data'] . '<br>';
							}
						}
                ?>
                </ul>
            </td>
            <td><strong><?php $loc = location($invoice['loc']);
                    echo $loc['cname']; ?></strong><br>
                <?php 
				
				if($invoice['type']==7){
					echo $invoice['faddress'] . '<br>' . $invoice['fcity'] . ', ' . $invoice['fregion'] . '<br>' . $invoice['fcountry'] . ' -  ' . $invoice['fpostbox'];
					if ($loc['taxid']) echo '<br>' . $this->lang->line('Tax') . ' ID: ' . $loc['taxid'];
				}else{
				echo
                    //$loc['address'] . '<br>' . $loc['city'] . ', ' . $loc['region'] . '<br>' . $loc['country'] . ' -  ' . $loc['postbox'] . '<br>' . $this->lang->line('Phone') . ': ' . $loc['phone'] . '<br> ' . $this->lang->line('Email') . ': ' . $loc['email'];
                    $loc['address'] . '<br>' . $loc['city'] . ', ' . $loc['region'] . '<br>' . $loc['country'] . ' -  ' . $loc['postbox'];
                if ($loc['taxid']) echo '<br>' . $this->lang->line('Tax') . ' ID: ' . $loc['taxid'];
				}
                ?>
            </td>
            
        </tr>
		<?php } ?>
        </tbody>
    </table>
    <br>
    <table class="plist" cellpadding="0" cellspacing="0">
        <tr class="heading">
            <td style="width: 1rem;">#</td>
            <td style="font-size:11px;"><?php echo $this->lang->line('Description') ?></td>
            <td style="font-size:11px;"><?php echo $this->lang->line('HSN') ?></td>
            <td style="font-size:11px;">Item Purchase Price </td>
            <td style="font-size:11px;">Total Spare parts Cost</td>
            <td style="font-size:11px;">Job Work Service Type</td>
            <td style="font-size:11px;">Net Service Cost</td>
            <td style="font-size:11px;width: 5%;">GST</td>
            <td style="font-size:11px;">Total Service Cost</td>
            <td style="font-size:11px;">Item Landing Cost</td>
            <!--<td><?php echo $this->lang->line('Qty') ?></td>
            <?php  echo '<td>' . $this->lang->line('Tax') . '</td>';
					echo '<td>' . $this->lang->line('Discount') . '</td>'; ?>
            <td class="t_center">
                <?php echo $this->lang->line('SubTotal') ?>
            </td>-->
        </tr>
        <?php
        $fill = true;
        $sub_t = 0;
        $sub_t_col = 3;
        $n = 1;
        $marginal_gst_price = 0;
		//print_r($products); exit;
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
            }
            else
            {
               $marginal_gst_price = $marginal_gst_price; 
            }
            
           
            
            $sub_t += $row['price'] * $row['qty'];

            //if ($row['serial']) $row['product_des'] .= ' - ' . $row['serial'];
			//if ($row['serial']) $row['product_des'] .= ' - ' . $row['serial'];
            echo '<tr class="item' . $flag . '">  <td>' . $n . '</td>
                            <td style="width:15%;font-size:10px;">' . $row['product'] .'<br>'.$row['serial'].'</td>
                            <td style="font-size:10px;">' . $row['code'] . '</td>
							<td style="font-size:10px;">' . amountExchange($purchase_price, $invoice['multi'], $invoice['loc']) . '</td>
                            <td style="font-size:10px;">'.$total_component_price.'</td>
                            <td style="font-size:10px;">'.$service_type.'</td>
                           
                            <td style="font-size:10px;">' .$service_charge . '</td>   ';
            //if ($invoice['tax'] > 0) {
                $cols++;
                echo '<td style="font-size:10px;width:10%;">' . $gst_service_charge . ' <span class="tax">(18%)</span></td>';
           // }
            //if ($invoice['discount'] > 0) {
                $cols++;
                echo ' <td style="font-size:10px;">' . $total_service_charge . '</td>';
           // }
            echo '<td class="t_center" style="font-size:10px;">' . amountExchange($row['subtotal'], $invoice['multi'], $invoice['loc']) . '</td></tr>';

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
    <table class="subtotal">


        <tr>
            <td class="myco2" rowspan="6"><br>
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
        <tr class="f_summary">
            <td>Total Service Cost :</td>
            <td><?php echo amountExchange($sub_t, $invoice['multi'], $invoice['loc']); ?></td>
            
        </tr>
        <tr class="f_summary">
            <td>Total Service GST :</td>
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
            <?php
        }
         if ($invoice['tax'] > 0) {
            echo '<tr>
            <td> ' . $this->lang->line('Total Tax') . ' :</td>
            <td>' . amountExchange($invoice['tax'], $invoice['multi'], $invoice['loc']) . '</td>
        </tr>';
        }
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

   
    ?>
<p style="text-align: justify;"><strong>Terms & Conditions</strong><br>
<span>1. Value of supply is determined in accordance to section 15(5) of the Central Goods and Services Tax Act read with Rule 32(5) of "Determination of Value of Supply" rules. The credit for GST input shall not be available to the buyer if buyer follow the same valuation rule.
</span>
<br>
<span>2.Goods once sold cannot be returned and the buyer assumes all responsibility of goods once taken out of Seller's premises physically by Buyer or Buyer's representative(s).</span>
<br>
<span>3.Buyer agrees to save and hold seller harmless from any claims, demands, liabilities, costs, expenses or judgement arising in whole or in part, directly or indirectly, out of the negligence of Buyer involving the goods supplied by Seller.</span>
</p>

</div>
</div>
</body>
</html>