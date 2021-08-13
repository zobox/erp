<article class="content">
  <div class="card card-block">
    <div id="notify" class="alert alert-success" style="display:none;"> <a href="#" class="close" data-dismiss="alert">&times;</a>
      <div class="message"></div>
    </div>
    <div class="card card-block"> <?php //echo "<pre>";print_r($Pdata);echo "</pre>";?>
      <form method="post" id="data_form" class="card-body" action="<?php echo  base_url(); ?>purchase/addscan">
        <!-- <form method="post" id="data_form" class="card-body">-->
        <h5><?php echo $this->lang->line('Add Serial Number') ?></h5>
        <hr>
      
        <div class="form-group row">
          <label class="col-sm-2 col-form-label" for="product_catname"><?php echo $this->lang->line('Item Name') ?></label>
          
          <div class="col-sm-4">
            <select name="product" id="product" class="form-control margin-bottom rqty required" required>
      <option value="" selected="selected" disabled="disabled"> --- SELECT ITEM--- </option>
      <?php 
     
        foreach($Pdata->pitems as $row){
        echo '<option value="'.$row->component_id.'">'.$row->product_name.'</option>';
        }
      ?>
           </select>           
          </div>
        </div>

    <div class="form-group row">
          <label class="col-sm-2 col-form-label" for="product_catname"><?php echo "Serial Number"; ?></label>
          
          <div class="col-sm-4">
            <input type="text" name="serial" id="serial" class="form-control margin-bottom rqty required" required placeholder='Serial Number'>
           
          </div>
        </div>
        <?php
        if($type!=3)
        {
          ?>
    
    <div class="form-group row">
          <label class="col-sm-2 col-form-label" for="product_catname">Send To Job Work</label>
       <div class="col-sm-4">
      <select name="jobwork_required" id="jobwork_required" class="form-control margin-bottom rqty required" required>
        <option value="1" selected="selected"> Yes </option>
        <option value="0"> No </option>     
            </select>         
      </div>
        </div>
        <div class="form-group row">
          <label class="col-sm-2 col-form-label" for="product_catname">Components</label>
       <div class="col-sm-4">
      <div class="multiple-select-input">
        <div class="select-item-container">
          <div class="select-item-list">
            
            <div class="select-item-list--single">
                
                <div class="directorist-select directorist-select-multi" id="multiSelect" data-isSearch="true" data-max="5" data-multiSelect="['apple', 'banana', 'orange', 'mango']" >               
                    <input type="hidden">
                </div>
            </div>
            
          </div> 
        </div>  
      </div>
      </div>
        </div>
      <?php } ?>
        <div class="form-group row">
          <label class="col-sm-2 col-form-label"></label>
          <div class="col-sm-4">
            <input type="submit" id="submit-data" class="btn btn-success margin-bottom"
                               value="<?php echo $this->lang->line('Add') ?>" data-loading-text="Adding...">
                               <?php
                               if($type==3)
                               {
                                ?>
            <input type="hidden" value="purchase/addscanComponent" id="action-url">                    
                                <?php
                               }
                               else
                               {
                                ?>
            <input type="hidden" value="purchase/addscan" id="action-url">
                               <?php } ?>
            <input type="hidden" name="purchaseid" value="<?php echo $id; ?>" id="id">
          </div>
        </div>
      </form>
    </div>
  </div>
</article>

