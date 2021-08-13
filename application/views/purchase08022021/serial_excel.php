<?php 
header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
header("Content-type:   application/x-msexcel; charset=utf-8");
header("Content-Disposition: attachment; filename=Serial Number.xlsx"); 
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Cache-Control: private",false);
?>

<table border="1">
<?php $qty = $Pdata->items-$Pdata->pending_qty;	?>
<tr>
<td colspan="3"><?php echo $this->lang->line('Purchase Order') ?> - <?php echo prefix(2).$Pdata->tid; ?></td>
</tr>
<tr>
<td>Sl. No.</td>
<td>Product Name</td>
<td>Serial Number</td>
</tr>
<?php for($i=1; $i<=$qty; $i++){ ?>
<tr>
<td><?php echo $i; ?></td>
<td><?php echo $Pdata->product; ?></td>
<td></td>
</tr>
<?php } ?>
</table>