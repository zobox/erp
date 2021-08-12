<?php
header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
header("Content-type:   application/x-msexcel; charset=utf-8");
header("Content-Disposition: attachment; filename=product_cost_report.xls");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Cache-Control: private",false);
?>

                <table id="" border=1>
                    <thead>
                    <tr>
                        
                        <th>Category</th>
                        <th>Product Name</th>
                        <th>ZoRetails Price</th>
                        <th>ZoBulk Price</th>
                        
                    </tr>
                    </thead>
                    <tbody>
                    <?php $i = 1;

                                  
                        foreach($result as $data)
                        {
                            $bulk = explode(',',$data['bulk_sale_price']);
                            $sale_price = explode(',',$data['sale_price']);
                            
                            $i++;
                            ?>
                            <tr>
                                
                                <td><?=$data['category_name'];?></td>
                                <td><?=$data['product_name'];?></td>
                                <td>

                                    <table border=1>
                                       <?php
                                     for($i=0;$i<count($sale_price);$i++)
                                     {
                                        ?>
                                      <tr>

                                        <td><?=$sale_price[$i]?></td>
                                      </tr>
                                      <?php
                                     }
                                 ?>
                                    </table>
                                
                                      
                                 </td>


                                <td>

                                    <table  border=1>
                                       <?php
                                     for($i=0;$i<count($bulk);$i++)
                                     {
                                        ?>
                                      <tr>

                                        <td><?=$bulk[$i]?></td>
                                      </tr>
                                      <?php
                                     }
                                 ?>
                                    </table>
                                
                                      
                                 </td>

                             </tr>
                            <?php
                        }
                    
                    ?>
                    </tbody>
                    <tfoot>
                    <tr>
                        <th>Category</th>
                        <th>Product Name</th>
                        <th>ZoRetails Price</th>
                        <th>ZoBulk Price</th>
                    </tr>
                    </tfoot>
                </table>
            