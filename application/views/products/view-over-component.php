<h5><?php echo $product['component_name'] . ' (' . $product['title'] . ')'; ?></h5>

<table class="table">
  <!--<a href="' . base_url() . 'products/edit?id=' . $product['id'] . '" class="btn btn-primary btn-sm"><span class="icon-pencil"></span> ' . $this->lang->line('Edit') . '</a>-->
    <?php echo '<tr><td>' . $product['component_name'] . '</td><td>ZUPC Code : ' . $product['warehouse_product_code'] . '</td><td> ' . $this->lang->line('Stock') . ' : ' . $product['qty'] . '<br><br>  <div class="btn-group">
                                 
                                    <div class="dropdown-menu">
                                       

                                        <div class="dropdown-divider"></div>
                                        
                                          <div class="dropdown-divider"></div>
                                           

                                        <div class="dropdown-divider"></div>
                                         

                                    </div>
                                </div>  </td></tr>'; ?>
</table>
 <a href="<?=base_url()?>products/add_component_variation?id=<?=$product['id']?>" target="_blank" class="btn btn-primary btn-sm">Add Variation</a> 
 <br>
 <br>
<?php if ($product_variations) {

    echo '<h6>' . $this->lang->line('Products') . ' ' . $this->lang->line('Variations') . '</h6>';
    ?>

    <table class="table table-striped table-bordered">
        <?php
        foreach ($product_variations as $product_variation) {
            echo '<tr><td><a href="' . base_url() . 'products/component_edit?id=' . $product_variation['id'] . '" class="btn btn-primary btn-sm"><span class="icon-pencil"></span> ' . $this->lang->line('Edit') . '</a>  <div class="btn-group">
                                    
                                   
                                </div> ' . $product_variation['component_name'] . '</td><td>Code : ' . $product_variation['warehouse_product_code'] . '</td><td> ' . $this->lang->line('Stock') . ' : ' . $product_variation['qty'] . ' </td></tr>';
        } ?>
    </table>
<?php } ?>

<?php if ($product_warehouse) {
    echo '<h6> ' . $this->lang->line('Warehouse') . '</h6>';
    ?>
    <table class="table table-striped table-bordered">
        <?php
        foreach ($product_warehouse as $product_variation) {
            echo '<tr><td><a href="' . base_url() . 'products/component_edit?id=' . $product_variation['id'] . '" class="btn btn-primary btn-sm"><span class="icon-pencil"></span> ' . $this->lang->line('Edit') . '</a> <div class="btn-group">
                                    <button type="button" class="btn btn-blue dropdown-toggle   btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="icon-print"></i>  ' . $this->lang->line('Print') . '                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="' . base_url() . 'products/barcode?id=' . $product_variation['id'] . '" target="_blank"> ' . $this->lang->line('BarCode') . '</a>

                                        <div class="dropdown-divider"></div>
                                         <a class="dropdown-item" href="' . base_url() . 'products/posbarcode?id=' . $product_variation['id'] . '" target="_blank"> ' . $this->lang->line('BarCode') . ' - Compact</a>
                                          <div class="dropdown-divider"></div>
                                             <a class="dropdown-item" href="' . base_url() . 'products/label?id=' . $product_variation['id'] . '" target="_blank"> ' . $this->lang->line('Product') . ' Label</a>

                                        <div class="dropdown-divider"></div>
                                         <a class="dropdown-item" href="' . base_url() . 'products/poslabel?id=' . $product_variation['id'] . '" target="_blank"> Label - Compact</a>

                                    </div>
                                </div>   <a class="btn btn-pink  btn-sm" href="' . base_url() . 'products/report_product?id=' . $product_variation['id'] . '" target="_blank"> <span class="icon-pie-chart2"></span> ' . $this->lang->line('Sales') . '</a> ' . $product_variation['component_name'] . '</td><td>Code : ' . $product_variation['warehouse_product_code'] . '</td><td>' . $product_variation['title'] . '</td><td> ' . $this->lang->line('Stock') . ' : ' . $product_variation['qty'] . '  </td></tr>';
        } ?>
    </table>
<?php } ?>
<hr>

