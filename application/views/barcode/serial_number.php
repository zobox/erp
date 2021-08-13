<table cellpadding="20">
	<?php  		
	foreach($code as $key=>$serial){ 
	if($serial<=13){
		$ctype = 'EAN13';
	}elseif($serial>13 && $serial<=39){
		$ctype = 'C39';
	}elseif($serial>39){
		$ctype = 'C128A';
	}	
	?>
	<tr>
        <td>
            <small><?= $name[$key] ?><br><br></small>
            <small><?= $serial ?><br><br></small>
            <barcode type="<?= $ctype ?>" code="<?= $serial ?>" text="1" class="barcode" height=".6"/>
            </barcode><br></td>       
    </tr>
	<?php } ?>
	
	
	
    <!--<tr>
        <td>
            <small><?= $name ?><br><br></small>
            <barcode type="<?= $ctype ?>" code="<?= $code ?>" text="1" class="barcode" height=".6"/>
            </barcode><br></td>
        <td>
            <small><?= $name ?><br><br></small>
            <barcode type="<?= $ctype ?>" code="<?= $code ?>" text="1" class="barcode" height=".6"/>
            </barcode><br></td>
        <td>
            <small><?= $name ?><br><br></small>
            <barcode type="<?= $ctype ?>" code="<?= $code ?>" text="1" class="barcode" height=".6"/>
            </barcode><br></td>
        <td>
            <small><?= $name ?><br><br></small>
            <barcode type="<?= $ctype ?>" code="<?= $code ?>" text="1" class="barcode" height=".6"/>
            </barcode><br></td>
    </tr>
    <tr>
        <td>
            <small><?= $name ?><br><br></small>
            <barcode type="<?= $ctype ?>" code="<?= $code ?>" text="1" class="barcode" height=".6"/>
            </barcode><br></td>
        <td>
            <small><?= $name ?><br><br></small>
            <barcode type="<?= $ctype ?>" code="<?= $code ?>" text="1" class="barcode" height=".6"/>
            </barcode><br></td>
        <td>
            <small><?= $name ?><br><br></small>
            <barcode type="<?= $ctype ?>" code="<?= $code ?>" text="1" class="barcode" height=".6"/>
            </barcode><br></td>
        <td>
            <small><?= $name ?><br><br></small>
            <barcode type="<?= $ctype ?>" code="<?= $code ?>" text="1" class="barcode" height=".6"/>
            </barcode><br></td>
    </tr>
    <tr>
        <td>
            <small><?= $name ?><br><br></small>
            <barcode type="<?= $ctype ?>" code="<?= $code ?>" text="1" class="barcode" height=".6"/>
            </barcode><br></td>
        <td>
            <small><?= $name ?><br><br></small>
            <barcode type="<?= $ctype ?>" code="<?= $code ?>" text="1" class="barcode" height=".6"/>
            </barcode><br></td>
        <td>
            <small><?= $name ?><br><br></small>
            <barcode type="<?= $ctype ?>" code="<?= $code ?>" text="1" class="barcode" height=".6"/>
            </barcode><br></td>
        <td>
            <small><?= $name ?><br><br></small>
            <barcode type="<?= $ctype ?>" code="<?= $code ?>" text="1" class="barcode" height=".6"/>
            </barcode><br></td>
    </tr>
    <tr>
        <td>
            <small><?= $name ?><br><br></small>
            <barcode type="<?= $ctype ?>" code="<?= $code ?>" text="1" class="barcode" height=".6"/>
            </barcode><br></td>
        <td>
            <small><?= $name ?><br><br></small>
            <barcode type="<?= $ctype ?>" code="<?= $code ?>" text="1" class="barcode" height=".6"/>
            </barcode><br></td>
        <td>
            <small><?= $name ?><br><br></small>
            <barcode type="<?= $ctype ?>" code="<?= $code ?>" text="1" class="barcode" height=".6"/>
            </barcode><br></td>
        <td>
            <small><?= $name ?><br><br></small>
            <barcode type="<?= $ctype ?>" code="<?= $code ?>" text="1" class="barcode" height=".6"/>
            </barcode><br></td>
    </tr>
    <tr>
        <td>
            <small><?= $name ?><br><br></small>
            <barcode type="<?= $ctype ?>" code="<?= $code ?>" text="1" class="barcode" height=".6"/>
            </barcode><br></td>
        <td>
            <small><?= $name ?><br><br></small>
            <barcode type="<?= $ctype ?>" code="<?= $code ?>" text="1" class="barcode" height=".6"/>
            </barcode><br></td>
        <td>
            <small><?= $name ?><br><br></small>
            <barcode type="<?= $ctype ?>" code="<?= $code ?>" text="1" class="barcode" height=".6"/>
            </barcode><br></td>
        <td>
            <small><?= $name ?><br><br></small>
            <barcode type="<?= $ctype ?>" code="<?= $code ?>" text="1" class="barcode" height=".6"/>
            </barcode><br></td>
    </tr>
    <tr>
        <td>
            <small><?= $name ?><br><br></small>
            <barcode type="<?= $ctype ?>" code="<?= $code ?>" text="1" class="barcode" height=".6"/>
            </barcode><br></td>
        <td>
            <small><?= $name ?><br><br></small>
            <barcode type="<?= $ctype ?>" code="<?= $code ?>" text="1" class="barcode" height=".6"/>
            </barcode><br></td>
        <td>
            <small><?= $name ?><br><br></small>
            <barcode type="<?= $ctype ?>" code="<?= $code ?>" text="1" class="barcode" height=".6"/>
            </barcode><br></td>
        <td>
            <small><?= $name ?><br><br></small>
            <barcode type="<?= $ctype ?>" code="<?= $code ?>" text="1" class="barcode" height=".6"/>
            </barcode><br></td>
    </tr>
    <tr>
        <td>
            <small><?= $name ?><br><br></small>
            <barcode type="<?= $ctype ?>" code="<?= $code ?>" text="1" class="barcode" height=".6"/>
            </barcode><br></td>
        <td>
            <small><?= $name ?><br><br></small>
            <barcode type="<?= $ctype ?>" code="<?= $code ?>" text="1" class="barcode" height=".6"/>
            </barcode><br></td>
        <td>
            <small><?= $name ?><br><br></small>
            <barcode type="<?= $ctype ?>" code="<?= $code ?>" text="1" class="barcode" height=".6"/>
            </barcode><br></td>
        <td>
            <small><?= $name ?><br><br></small>
            <barcode type="<?= $ctype ?>" code="<?= $code ?>" text="1" class="barcode" height=".6"/>
            </barcode><br></td>
    </tr>-->


</table>