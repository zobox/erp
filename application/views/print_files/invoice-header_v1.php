<table style="margin-left:18px;">
    <tr>
        <td class="myco">
            <!--<img src="<?php $loc = location($invoice['loc']);
            echo FCPATH . 'userfiles/company/' . $loc['logo'] ?>"
                 class="top_logo" style="height:140px;width:120px;margin-top:40px;">-->
                 <img src="<?php echo base_url('userfiles/company/16088996411285771464.png')?>"
                 class="top_logo" style="height:140px;width:120px;margin-top:40px;"> 
                  <br><br>
                 <!--<span style="margin-top:50px;font-size:22px;"><b>Zobox Retails Pvt. Ltd.</b></span>-->
				  </td>
        <td>

        </td>
        <td class="myw" style="padding-top:25px;">
            <table class="top_sum">
                <tr>
                    <td colspan="1" class="t_center"><h2><?= $general['title'] ?></h2><br><br></td>
                </tr>
                <tr>
                    <td><?= $general['title'] ?></td>
                    <td><?= $general['prefix'] . ' ' . $invoice['tid'] ?></td>
                </tr>
                <tr>
                    <td><?= $general['title'] . ' ' . $this->lang->line('Date') ?></td>
                    <td><?php echo dateformat($invoice['invoicedate']) ?></td>
                </tr>
                <!--<tr>
                    <td><?php echo $this->lang->line('Due Date') ?></td>
                    <td><?php echo dateformat($invoice['invoiceduedate']) ?></td>
                </tr>-->
                <?php if ($invoice['refer']) { ?>
                    <tr>
                        <td><?php echo $this->lang->line('Reference') ?></td>
                        <td><?php echo $invoice['refer'] ?></td>
                    </tr>
                <?php } ?>
				 <?php if ($invoice['ewayBillNo']) { ?>
                    <tr>
                        <td>E - WAY BILL:</td>
                        <td><?php echo $invoice['ewayBillNo'] ?></td>
                    </tr>
                <?php } ?>
            </table>


        </td>
    </tr>
</table>
<br>