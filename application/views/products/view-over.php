<h5><?php echo $product['product_name'] . ' (' . $product['title'] . ')'; ?></h5>

<table class="table">
  <!--<a href="' . base_url() . 'products/edit?id=' . $product['pid'] . '" class="btn btn-primary btn-sm"><span class="icon-pencil"></span> ' . $this->lang->line('Edit') . '</a>-->
    <?php echo '<tr><td>' . $product['product_name'] . '</td><td>ZUPC Code : ' . $product['warehouse_product_code'] . '</td><td> ' . $this->lang->line('Qty') . ' : ' . $product['qty'] . '<br><br>  <div class="btn-group">
                                    <button type="button" class="btn btn-blue dropdown-toggle   btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="icon-print"></i>  ' . $this->lang->line('Print') . '                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="' . base_url() . 'products/barcode?id=' . $product['pid'] . '" target="_blank"> ' . $this->lang->line('BarCode') . '</a>

                                        <div class="dropdown-divider"></div>
                                         <a class="dropdown-item" href="' . base_url() . 'products/posbarcode?id=' . $product['pid'] . '" target="_blank"> ' . $this->lang->line('BarCode') . ' - Compact</a>
                                          <div class="dropdown-divider"></div>
                                             <a class="dropdown-item" href="' . base_url() . 'products/label?id=' . $product['pid'] . '" target="_blank"> ' . $this->lang->line('Product') . ' Label</a>

                                        <div class="dropdown-divider"></div>
                                         <a class="dropdown-item" href="' . base_url() . 'products/poslabel?id=' . $product['pid'] . '" target="_blank"> Label - Compact</a>

                                    </div>
                                </div>   <a class="btn btn-pink  btn-sm" href="' . base_url() . 'products/report_product?id=' . $product['pid'] . '" target="_blank"> <span class="icon-pie-chart2"></span> ' . $this->lang->line('Sales') . '</a> </td></tr>'; ?>
</table>

<?php if ($product_variations) {

    echo '<h6>' . $this->lang->line('Products') . ' ' . $this->lang->line('Variations') . '</h6>';
    ?>
    <table  class="table table-striped table-bordered" cellspacing="0"
                       width="110%">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th><?php echo $this->lang->line('Category') ?></th>
                        <th><?php echo $this->lang->line('Brand') ?></th>
                        <th><?php echo $this->lang->line('Product Name') ?></th>
                        <th><?php echo $this->lang->line('Varient') ?></th>
                        <th><?php echo $this->lang->line('Colour') ?></th>
                        <th><?php echo $this->lang->line('Condition') ?></th>
                        <th><?php echo $this->lang->line('Qty') ?></th>
                        <th><?php echo $this->lang->line('Action') ?></th>
                    </tr>
                    </thead>
                    <tbody>
                        <?php
                        
                          $i=1;
                         foreach ($product_variations as $product_variation) {
                             
                            ?>
                      <tr>
                        <td><?=$i++?></td>
                        <td><?=$producat_cat;?>
                        <td><?=$product_variation['brand_name']?></td>
                        <td><?=$product['product_name']?></td>
                        <td><?=$product_variation['unit_name']?></td>
                        <td><?=$product_variation['colour_name']?></td>
                        <td><?=$product_variation['condition_type']?></td>
                        <td><?=$product_variation['qty']?></td>
                        <?php echo '<td><a href="' . base_url() . 'products/edit?id=' . $product_variation['pid'] . '" class="btn btn-primary btn-sm"><span class="icon-pencil"></span> ' . $this->lang->line('Edit') . '</a>  <div class="btn-group">
                                    <button type="button" class="btn btn-blue dropdown-toggle   btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="icon-print"></i>  ' . $this->lang->line('Print') . '                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="' . base_url() . 'products/barcode?id=' . $product_variation['pid'] . '" target="_blank"> ' . $this->lang->line('BarCode') . '</a>

                                        <div class="dropdown-divider"></div>
                                         <a class="dropdown-item" href="' . base_url() . 'products/posbarcode?id=' . $product_variation['pid'] . '" target="_blank"> ' . $this->lang->line('BarCode') . ' - Compact</a>
                                          <div class="dropdown-divider"></div>
                                             <a class="dropdown-item" href="' . base_url() . 'products/label?id=' . $product_variation['pid'] . '" target="_blank"> ' . $this->lang->line('Product') . ' Label</a>

                                        <div class="dropdown-divider"></div>
                                         <a class="dropdown-item" href="' . base_url() . 'products/poslabel?id=' . $product_variation['pid'] . '" target="_blank"> Label - Compact</a>

                                    </div>
                                </div>   <a class="btn btn-pink  btn-sm" href="' . base_url() . 'products/report_product?id=' . $product_variation['pid'] . '" target="_blank"> <span class="icon-pie-chart2"></span> ' . $this->lang->line('Sales') . '</a></td>'; ?>
                       <!-- <td><a href=<?=base_url()?>products/edit?id=<?=$product_variation['pid']?>" class="btn btn-primary btn-sm"><span class="icon-pencil"></span> Edit</a></td>-->
                      </tr>
                  <?php } ?>
                    </tbody>

                    <tfoot>
                    <tr>
                        <th>#</th>
                        <th><?php echo $this->lang->line('Category') ?></th>
                        <th><?php echo $this->lang->line('Brand') ?></th>
                        <th><?php echo $this->lang->line('Product Name') ?></th>
                        <th><?php echo $this->lang->line('Varient') ?></th>
                        <th><?php echo $this->lang->line('Colour') ?></th>
                        <th><?php echo $this->lang->line('Condition') ?></th>
                        <th><?php echo $this->lang->line('Qty') .' : ' . $product_variation['qty'];?></th>
                        <th><?php echo $this->lang->line('Action') ?></th>
                    </tr>
                    </tfoot>
                </table>
    <!--<table class="table table-striped table-bordered">
        <?php
        foreach ($product_variations as $product_variation) {
            echo '<tr><td><a href="' . base_url() . 'products/edit?id=' . $product_variation['pid'] . '" class="btn btn-primary btn-sm"><span class="icon-pencil"></span> ' . $this->lang->line('Edit') . '</a>  <div class="btn-group">
                                    <button type="button" class="btn btn-blue dropdown-toggle   btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="icon-print"></i>  ' . $this->lang->line('Print') . '                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="' . base_url() . 'products/barcode?id=' . $product_variation['pid'] . '" target="_blank"> ' . $this->lang->line('BarCode') . '</a>

                                        <div class="dropdown-divider"></div>
                                         <a class="dropdown-item" href="' . base_url() . 'products/posbarcode?id=' . $product_variation['pid'] . '" target="_blank"> ' . $this->lang->line('BarCode') . ' - Compact</a>
                                          <div class="dropdown-divider"></div>
                                             <a class="dropdown-item" href="' . base_url() . 'products/label?id=' . $product_variation['pid'] . '" target="_blank"> ' . $this->lang->line('Product') . ' Label</a>

                                        <div class="dropdown-divider"></div>
                                         <a class="dropdown-item" href="' . base_url() . 'products/poslabel?id=' . $product_variation['pid'] . '" target="_blank"> Label - Compact</a>

                                    </div>
                                </div>   <a class="btn btn-pink  btn-sm" href="' . base_url() . 'products/report_product?id=' . $product_variation['pid'] . '" target="_blank"> <span class="icon-pie-chart2"></span> ' . $this->lang->line('Sales') . '</a>  ' . $product_variation['product_name'] . '</td><td>Code : ' . $product_variation['product_code'] . '</td><td> ' . $this->lang->line('Stock') . ' : ' . $product_variation['qty'] . ' </td></tr>';
        } ?>
    </table>-->
<?php } ?>

<?php if ($product_warehouse) {
    echo '<h6> ' . $this->lang->line('Warehouse') . '</h6>';
    ?>
    <table class="table table-striped table-bordered">
        <?php
        foreach ($product_warehouse as $product_variation) {
            echo '<tr><td><a href="' . base_url() . 'products/edit?id=' . $product_variation['pid'] . '" class="btn btn-primary btn-sm"><span class="icon-pencil"></span> ' . $this->lang->line('Edit') . '</a> <div class="btn-group">
                                    <button type="button" class="btn btn-blue dropdown-toggle   btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="icon-print"></i>  ' . $this->lang->line('Print') . '                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="' . base_url() . 'products/barcode?id=' . $product_variation['pid'] . '" target="_blank"> ' . $this->lang->line('BarCode') . '</a>

                                        <div class="dropdown-divider"></div>
                                         <a class="dropdown-item" href="' . base_url() . 'products/posbarcode?id=' . $product_variation['pid'] . '" target="_blank"> ' . $this->lang->line('BarCode') . ' - Compact</a>
                                          <div class="dropdown-divider"></div>
                                             <a class="dropdown-item" href="' . base_url() . 'products/label?id=' . $product_variation['pid'] . '" target="_blank"> ' . $this->lang->line('Product') . ' Label</a>

                                        <div class="dropdown-divider"></div>
                                         <a class="dropdown-item" href="' . base_url() . 'products/poslabel?id=' . $product_variation['pid'] . '" target="_blank"> Label - Compact</a>

                                    </div>
                                </div>   <a class="btn btn-pink  btn-sm" href="' . base_url() . 'products/report_product?id=' . $product_variation['pid'] . '" target="_blank"> <span class="icon-pie-chart2"></span> ' . $this->lang->line('Sales') . '</a> ' . $product_variation['product_name'] . '</td><td>Code : ' . $product_variation['product_code'] . '</td><td>' . $product_variation['title'] . '</td><td> ' . $this->lang->line('Stock') . ' : ' . $product_variation['qty'] . '  </td></tr>';
        } ?>
    </table>
<?php } ?>
<hr>

