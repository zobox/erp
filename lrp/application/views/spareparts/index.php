<div class="app-content content container-fluid">
  <div class="content-wrapper">
    <div class="content-header row"> </div>
    <div class="content-body">
      <?php if ($this->session->flashdata("messagePr")) { ?>
        <div class="alert alert-info">
          <?php echo $this->session->flashdata("messagePr") ?>
        </div>
        <?php } ?>
          <div class="card card-block">
              <div class="card-content">
                <div id="notify" class="alert alert-warning" style="display:none;"> <a href="#" class="close" data-dismiss="alert">×</a>
                  <div class="message" id="msg"></div>
                </div>
                <div class="card-header">
                  <h4 class="card-title"> Received Spareparts </h4>
                  <hr>
                  <div class="card-body px-0">
                    <div class="row">
                      <div class="col-sm-6">
                        <div class="form-group">
                          <label> Supplier </label>
                          <select class="form-control" id="product_cat" name="supplier_id" required="required">
                            <option value="">Select Supplier</option>
                            <option value="5">Manak Waste Management Pvt. Ltd.</option>
                            <option value="20">Supplier_Test_Company</option>
                            <option value="21">Onsite Phones Private Limited</option>
                            <option value="22">Joltme Electrovision (India) Private Limited </option>
                            <option value="23">GreenTek Reman Pvt. Ltd</option>
                            <option value="57">AMAZON SELLER SERVICES PRIVATE LIMITED</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-sm-6">
                        <div class="form-group">
                          <label> Pending PO List </label>
                          <select id="sub_cat"  class="form-control select-box" required="required">
                          <option value="" selected="selected"> --- Select ---</option>
                        </select>
                        </div>
                      </div>
                      <div class="col-sm-6">
                        <div class="form-group">
                          <label> Product List </label>
                          <select class="form-control" id="sub_sub_cat" name="purchase_item_id" required="required">
                                       <option value="" selected="selected"> --- Select ---</option>
                                    </select>
                        </div>
                      </div>
                      <div class="col-sm-6">
                        <div class="form-group">
                          <label> ZUPC </label>
                          <input type="text" class="form-control margin-bottom" name="serial_no1" id="serial_no1" required="required">
                        </div>
                      </div>
                      <div class="col-sm-6">
                        <div class="form-group">
                          <label> Quantity </label>
                          <input type="text" class="form-control margin-bottom" name="qty" id="qty" required="required">
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-sm-12">
                        <div class="text-center">
                          <input type="submit" name="submit" id="submit" class="btn btn-success mt-2" value="Submit">
                            <!--<button type="submit" class="btn btn-success ">Submit</button>-->
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
          </div>
    </div>
  </div>
</div>
<div id="assigntl" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content mdcontent">
      <div class="modal-header">
        <h4 class="modal-title">Assign TL</h4>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
      </div>
      <div class="modal-body">
        <form class="payment" method="post" action="<?php echo base_url()?>workhousejob/assign_engineer">
          <div class="row">
            <div class="col">
              <div class="input-group modinput">
                <input type="text" class="form-control" placeholder="Assign TL" name="engineer_name" id="engineer_name" required value="<?=$product_info->assign_engineer;?>">
                <input type="hidden" name="jobwork_id" value="<?=$jobwork_id?>" id="jobwork_id"> </div>
            </div>
          </div>
          <div class="modal-footer">
            <input type="hidden" class="form-control required" name="type" id="type" value="1">
            <button type="button" class="btn btn-default" data-dismiss="modal">
              <?php echo $this->lang->line('Close') ?>
            </button>
            <button type="submit" class="btn btn-primary" id="assign_engineer_submit">
              <?php echo $this->lang->line('Submit') ?>
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script type="text/javascript">
$(document).ready(function(event) {
  /*$('.source').change(function(){
      $.ajax({
        type : 'POST',
        data : {source : $('.source').val()},
        url : baseurl+'lead/changesource',
        cache : false,
        success : function(result){
          window.location.href = result;
        },
        error : function (jqXHR, textStatus, errorThrown){
         if (jqXHR.status == 500) {
                      alert('Internal error: ' + jqXHR.responseText);
                  } else {
                      alert('Unexpected error.'+jqXHR.status);
                  }
      }
      })
    });*/
});
$('.statusChange').change(function(event) {
  var itsid = $(this).attr('id');
  itsid = itsid.split("chnage");
  itsid = itsid[1];
  var selectedValue = $(this).val();
  $.ajax({
    type: 'post',
    url: baseurl + 'lead/changeStatus',
    data: {
      leadid: itsid,
      selectedStatus: selectedValue
    },
    cache: false,
    success: function(result) {
      swal("", result, "success");
      $.ajax({
        type: 'POST',
        url: baseurl + 'lead/getStatusHtml',
        data: {
          id: itsid
        },
        cache: false,
        success: function(data) {
          $('#stauschnage' + itsid).html(data);
          setTimeout(function() {
            location.reload();
          }, 3000);
        },
        error: function(jqXHR, textStatus, errorThrown) {
          if(jqXHR.status == 500) {
            alert('Internal error: ' + jqXHR.responseText);
          } else {
            alert('Unexpected error.' + jqXHR.status);
          }
        }
      });
    },
    error: function(jqXHR, textStatus, errorThrown) {
      if(jqXHR.status == 500) {
        alert('Internal error: ' + jqXHR.responseText);
      } else {
        alert('Unexpected error.' + jqXHR.status);
      }
    }
  });
});
</script>