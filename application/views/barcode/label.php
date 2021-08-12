<?php 
if(strlen($lab['barcode'])<=12)
            {
                $ctype = $lab['code_type'];
            }
            else
            {
                $ctype = 'C39';
            }
?>            
<table cellpadding="20" style="width: 100%">

    <tr>
        <td style="border: 1px solid; width: 33.333%">
            <strong><?= $lab['product_name'] ?></strong><br><?= $lab['product_code'] ?><br><br>
            <barcode  code="<?= $lab['barcode'] ?>" type="<?=$ctype?>" text="1" class="barcode" height=".6"/>
            </barcode><br><center><?=$lab['barcode']?></center><br>

            <?php
            if ($lab['expiry']) echo $this->lang->line('Expiry Date') . ' ' . dateformat($lab['expiry']) . '<br><br>';
            ?>
            <h3> &nbsp; &nbsp;
                &nbsp; <?= amountExchange($lab['product_price'], 0, $this->aauth->get_user()->loc) ?></h3>
        </td>
        <td style="border: 1px solid; width: 33.333%">
            <strong><?= $lab['product_name'] ?></strong><br><?= $lab['product_code'] ?><br><br>
            <barcode code="<?= $lab['barcode'] ?>" type="<?=$ctype?>" text="1" class="barcode" height=".6"/>
            </barcode><br><center><?=$lab['barcode']?></center><br>

            <?php
            if ($lab['expiry']) echo $this->lang->line('Expiry Date') . ' ' . dateformat($lab['expiry']) . '<br><br>';
            ?>
            <h3> &nbsp; &nbsp;
                &nbsp; <?= amountExchange($lab['product_price'], 0, $this->aauth->get_user()->loc) ?></h3>
        </td>
        <td style="border: 1px solid; width: 33.333%">
            <strong><?= $lab['product_name'] ?></strong><br><?= $lab['product_code'] ?><br><br>
            <barcode code="<?= $lab['barcode'] ?>" type="<?=$ctype?>" text="1" class="barcode" height=".6"/>
            </barcode><br><center><?=$lab['barcode']?></center><br>

            <?php
            if ($lab['expiry']) echo $this->lang->line('Expiry Date') . ' ' . dateformat($lab['expiry']) . '<br><br>';
            ?>
            <h3> &nbsp; &nbsp;
                &nbsp; <?= amountExchange($lab['product_price'], 0, $this->aauth->get_user()->loc) ?></h3>
        </td>
    </tr>

    <tr>
        <td style="border: 1px solid; width: 33.333%">
            <strong><?= $lab['product_name'] ?></strong><br><?= $lab['product_code'] ?><br><br>
            <barcode code="<?= $lab['barcode'] ?>" type="<?=$ctype?>" text="1" class="barcode" height=".6"/>
            </barcode><br><center><?=$lab['barcode']?></center><br>

            <?php
            if ($lab['expiry']) echo $this->lang->line('Expiry Date') . ' ' . dateformat($lab['expiry']) . '<br><br>';
            ?>
            <h3> &nbsp; &nbsp;
                &nbsp; <?= amountExchange($lab['product_price'], 0, $this->aauth->get_user()->loc) ?></h3>
        </td>
        <td style="border: 1px solid; width: 33.333%">
            <strong><?= $lab['product_name'] ?></strong><br><?= $lab['product_code'] ?><br><br>
            <barcode code="<?= $lab['barcode'] ?>" type="<?=$ctype?>" text="1" class="barcode" height=".6"/>
            </barcode><br><center><?=$lab['barcode']?></center><br>

            <?php
            if ($lab['expiry']) echo $this->lang->line('Expiry Date') . ' ' . dateformat($lab['expiry']) . '<br><br>';
            ?>
            <h3> &nbsp; &nbsp;
                &nbsp; <?= amountExchange($lab['product_price'], 0, $this->aauth->get_user()->loc) ?></h3>
        </td>
        <td style="border: 1px solid; width: 33.333%">
            <strong><?= $lab['product_name'] ?></strong><br><?= $lab['product_code'] ?><br><br>
            <barcode code="<?= $lab['barcode'] ?>" type="<?=$ctype?>" text="1" class="barcode" height=".6"/>
            </barcode><br><center><?=$lab['barcode']?></center><br>

            <?php
            if ($lab['expiry']) echo $this->lang->line('Expiry Date') . ' ' . dateformat($lab['expiry']) . '<br><br>';
            ?>
            <h3> &nbsp; &nbsp;
                &nbsp; <?= amountExchange($lab['product_price'], 0, $this->aauth->get_user()->loc) ?></h3>
        </td>
    </tr>
    <tr>
        <td style="border: 1px solid; width: 33.333%">
            <strong><?= $lab['product_name'] ?></strong><br><?= $lab['product_code'] ?><br><br>
            <barcode code="<?= $lab['barcode'] ?>" type="<?=$ctype?>" text="1" class="barcode" height=".6"/>
            </barcode><br><center><?=$lab['barcode']?></center><br>

            <?php
            if ($lab['expiry']) echo $this->lang->line('Expiry Date') . ' ' . dateformat($lab['expiry']) . '<br><br>';
            ?>
            <h3> &nbsp; &nbsp;
                &nbsp; <?= amountExchange($lab['product_price'], 0, $this->aauth->get_user()->loc) ?></h3>
        </td>
        <td style="border: 1px solid; width: 33.333%">
            <strong><?= $lab['product_name'] ?></strong><br><?= $lab['product_code'] ?><br><br>
            <barcode code="<?= $lab['barcode'] ?>" type="<?=$ctype?>" text="1" class="barcode" height=".6"/>
            </barcode><br><center><?=$lab['barcode']?></center><br>

            <?php
            if ($lab['expiry']) echo $this->lang->line('Expiry Date') . ' ' . dateformat($lab['expiry']) . '<br><br>';
            ?>
            <h3> &nbsp; &nbsp;
                &nbsp; <?= amountExchange($lab['product_price'], 0, $this->aauth->get_user()->loc) ?></h3>
        </td>
        <td style="border: 1px solid; width: 33.333%">
            <strong><?= $lab['product_name'] ?></strong><br><?= $lab['product_code'] ?><br><br>
            <barcode code="<?= $lab['barcode'] ?>" type="<?=$ctype?>" text="1" class="barcode" height=".6"/>
            </barcode><br><center><?=$lab['barcode']?></center><br>

            <?php
            if ($lab['expiry']) echo $this->lang->line('Expiry Date') . ' ' . dateformat($lab['expiry']) . '<br><br>';
            ?>
            <h3> &nbsp; &nbsp;
                &nbsp; <?= amountExchange($lab['product_price'], 0, $this->aauth->get_user()->loc) ?></h3>
        </td>
    </tr>
    <tr>
        <td style="border: 1px solid; width: 33.333%">
            <strong><?= $lab['product_name'] ?></strong><br><?= $lab['product_code'] ?><br><br>
            <barcode code="<?= $lab['barcode'] ?>" type="<?=$ctype?>" text="1" class="barcode" height=".6"/>
            </barcode><br><center><?=$lab['barcode']?></center><br>

            <?php
            if ($lab['expiry']) echo $this->lang->line('Expiry Date') . ' ' . dateformat($lab['expiry']) . '<br><br>';
            ?>
            <h3> &nbsp; &nbsp;
                &nbsp; <?= amountExchange($lab['product_price'], 0, $this->aauth->get_user()->loc) ?></h3>
        </td>
        <td style="border: 1px solid; width: 33.333%">
            <strong><?= $lab['product_name'] ?></strong><br><?= $lab['product_code'] ?><br><br>
            <barcode code="<?= $lab['barcode'] ?>" type="<?=$ctype?>" text="1" class="barcode" height=".6"/>
            </barcode><br><center><?=$lab['barcode']?></center><br>

            <?php
            if ($lab['expiry']) echo $this->lang->line('Expiry Date') . ' ' . dateformat($lab['expiry']) . '<br><br>';
            ?>
            <h3> &nbsp; &nbsp;
                &nbsp; <?= amountExchange($lab['product_price'], 0, $this->aauth->get_user()->loc) ?></h3>
        </td>
        <td style="border: 1px solid; width: 33.333%">
            <strong><?= $lab['product_name'] ?></strong><br><?= $lab['product_code'] ?><br><br>
            <barcode code="<?= $lab['barcode'] ?>" type="<?=$ctype?>" text="1" class="barcode" height=".6"/>
            </barcode><br><center><?=$lab['barcode']?></center><br>

            <?php
            if ($lab['expiry']) echo $this->lang->line('Expiry Date') . ' ' . dateformat($lab['expiry']) . '<br><br>';
            ?>
            <h3> &nbsp; &nbsp;
                &nbsp; <?= amountExchange($lab['product_price'], 0, $this->aauth->get_user()->loc) ?></h3>
        </td>
    </tr>

    <tr>
        <td style="border: 1px solid; width: 33.333%">
            <strong><?= $lab['product_name'] ?></strong><br><?= $lab['product_code'] ?><br><br>
            <barcode code="<?= $lab['barcode'] ?>" type="<?=$ctype?>" text="1" class="barcode" height=".6"/>
            </barcode><br><center><?=$lab['barcode']?></center><br>

            <?php
            if ($lab['expiry']) echo $this->lang->line('Expiry Date') . ' ' . dateformat($lab['expiry']) . '<br><br>';
            ?>
            <h3> &nbsp; &nbsp;
                &nbsp; <?= amountExchange($lab['product_price'], 0, $this->aauth->get_user()->loc) ?></h3>
        </td>
        <td style="border: 1px solid; width: 33.333%">
            <strong><?= $lab['product_name'] ?></strong><br><?= $lab['product_code'] ?><br><br>
            <barcode code="<?= $lab['barcode'] ?>" type="<?=$ctype?>" text="1" class="barcode" height=".6"/>
            </barcode><br><center><?=$lab['barcode']?></center><br>

            <?php
            if ($lab['expiry']) echo $this->lang->line('Expiry Date') . ' ' . dateformat($lab['expiry']) . '<br><br>';
            ?>
            <h3> &nbsp; &nbsp;
                &nbsp; <?= amountExchange($lab['product_price'], 0, $this->aauth->get_user()->loc) ?></h3>
        </td>
        <td style="border: 1px solid; width: 33.333%">
            <strong><?= $lab['product_name'] ?></strong><br><?= $lab['product_code'] ?><br><br>
            <barcode code="<?= $lab['barcode'] ?>" type="<?=$ctype?>" text="1" class="barcode" height=".6"/>
            </barcode><br><center><?=$lab['barcode']?></center><br>

            <?php
            if ($lab['expiry']) echo $this->lang->line('Expiry Date') . ' ' . dateformat($lab['expiry']) . '<br><br>';
            ?>
            <h3> &nbsp; &nbsp;
                &nbsp; <?= amountExchange($lab['product_price'], 0, $this->aauth->get_user()->loc) ?></h3>
        </td>
    </tr>

</table>