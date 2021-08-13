<div class="content-body">
  <div class="card">
    <div class="card-header">
      <h5 class="title"> <?php echo "Purchase Calculator"; ?> </h5>
      <hr>
      <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
      <div class="heading-elements">
        <ul class="list-inline mb-0">
          <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
          <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
          <li><a data-action="close"><i class="ft-x"></i></a></li>
        </ul>
      </div>
    </div>
    <div class="card-content">
      <div id="notify" class="alert alert-success" style="display:none;"> <a href="#" class="close" data-dismiss="alert">&times;</a>
        <div class="message"></div>
      </div>
      <div class="card-body">
        <form class="row" name="calculator-form" id="calculator-form"  action="" method="" enctype="multipart/form-data">
          <div class="form-group col-md-6">
            <label for="product_name" class="caption">HindiZo Product Name</label>
            <input type="text" class="form-control" name="product_name" id="product_name" placeholder="Enter HindiZo Product Name" />
          </div>
          <div class="form-group col-md-6">
            <label style="color:white; width: 100%; margin-top: 2px;">false label</label>
            <label for="data_came" class="caption">Data : </label>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="data_entered" id="inlineRadio2" value="1" checked="checked">
              <label class="form-check-label" for="inlineRadio2">Manual</label>
            </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="data_entered" id="inlineRadio1" value="2">
              <label class="form-check-label" for="inlineRadio1">Online</label>
            </div>
          </div>
          <div class="form-group col-md-4 manual">
            <label for="flipkart_price" class="caption">Flipkart Price</label>
            <input type="text" class="form-control" name="flipkart_price" id="flipkart_price" placeholder="Enter Flipkart Price" />
          </div>
          <div class="form-group col-md-4 manual">
            <label for="amazon_price" class="caption">Amazon Price</label>
            <input type="text" class="form-control" name="amazon_price" id="amazon_price" placeholder="Enter Amazon Price" />
          </div>
          <div class="form-group col-md-4 manual">
            <label for="snapdeal_price" class="caption">Snapdeal Price</label>
            <input type="text" class="form-control" name="snapdeal_price" id="snapdeal_price" placeholder="Enter Snapdeal Price" />
          </div>
          <div class="form-group col-md-4 manual">
            <label for="2gud_price" class="caption">2GuD Price</label>
            <input type="text" class="form-control" name="2gud_price" id="2gud_price" placeholder="Enter 2GuD Price" />
          </div>
          <div class="form-group col-md-4 manual">
            <label for="infibeam_price" class="caption">Infibeam Price</label>
            <input type="text" class="form-control" name="infibeam_price" id="infibeam_price" placeholder="Enter Infibeam Price" />
          </div>
          <div class="form-group col-md-4 manual">
            <button type="button" class="btn btn-primary" id="add-another" style="margin: 25px 5px;">ADD ROW</button>
            <!--data-toggle="modal" data-target="#add-another"-->
          </div>
          <div class="form-group col-md-4 average">
            <label for="average_price_p_calc" class="caption">Average Price</label>
            <input type="text" class="form-control" name="average_price_p_calc" id="average_price_p_calcu" placeholder="Enter Average Price" />
          </div>
          <!--<div class="form-group col-md-6">
		  <label for="buying_price_p_calc" class="caption">Buying Price</label>
            <input type="text" class="form-control" name="buying_price_p_calc" id="buying_price_p_calc" placeholder="Enter Buying Price" />
          </div>-->
          <div class="col-sm-4 form-group ">
            <label for="taxformat" class="caption">Tax </label>
            <select class="form-control" id="taxformat">
              <option value="yes" selected="">>>On</option>
              <option value="yes">On</option>
              <option value="inclusive">Inclusive</option>
              <option value="off">Off</option>
              <option value="inclusive">CGST + SGST</option>
              <option value="inclusive">IGST</option>
              <option value="inclusive">Central GST 28%</option>
              <option value="inclusive">Local GST 28%</option>
              <option value="inclusive">Central GST 18%</option>
              <option value="inclusive">Local GST 18%</option>
              <option value="inclusive">Central GST 12%</option>
              <option value="inclusive">Local GST 12%</option>
              <option value="inclusive">Central GST 5%</option>
              <option value="inclusive"> Local GST 5%</option>
            </select>
          </div>
          <div class="col-sm-4 form-group">
            <label for="discountFormat" class="caption"> Discount</label>
            <select class="form-control" id="discountFormat">
              <option value="b_p">-- % Discount Before TAX--</option>
              <option value="%"> % Discount After TAX</option>
              <option value="flat">Flat Discount After TAX</option>
              <option value="b_p"> % Discount Before TAX</option>
              <option value="bflat">Flat Discount Before TAX</option>
            </select>
          </div>
          <div id="saman-row" class="col-sm-12 form-group">
            <table class="table-responsive tfr my_stripe">
              <thead>
                <tr class="item_header bg-gradient-directional-amber">
                  <th width="10%" class="text-center">Enter Supplier Offer Price</th>
                  <th width="10%" class="text-center">Supplier Offered Discount</th>
                  <th width="10%" class="text-center">Tax(%)</th>
                  <th width="7%" class="text-center"> Projected Hindizo Price( Net )</th>
                  <th width="10%" class="text-center"> Projected GST(&#8377;) </th>
				   <th width="10%" class="text-center"> Grand Total ( Incl. GST ) </th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td><input type="text" class="form-control req prc" name="product_price[]" id="price-0" onkeypress="return isNumber(event)" onkeyup="rowTotal('0'), billUpyog()" autocomplete="off"></td>
                  <td><input type="text" class="form-control vat " name="product_tax[]" id="vat-0" onkeypress="return isNumber(event)" onkeyup="rowTotal('0'), billUpyog()" autocomplete="off"></td>
                  <td><input type="text" class="form-control discount" name="product_discount[]" onkeypress="return isNumber(event)" id="discount-0" onkeyup="rowTotal('0'), billUpyog()" autocomplete="off"></td>
                  <td class="text-center" id="texttaxa-0">0.00</td>
                  <td style="text-align: center;"><span class="currenty"> &#8377;</span> <strong><span class="ttlText" id="result-0">0.00</span></strong></td>
				  <td style="text-align: center;"><span class="currenty"> &#8377;</span> <strong><span class="ttlText" id="result-0">0.00</span></strong></td>
                </tr>
              </tbody>
            </table>
          </div>
          <!--<div class="form-group col-md-4">
            <input type="text" class="form-control" name="hindizo_buying_gst" id="hindizo_buying_gst" placeholder="Hindizo Buying GST" />
          </div>
          <div class="form-group col-md-4">
            <input type="text" class="form-control" name="hindizo_buying_price_p_calc" id="hindizo_buying_price_p_calc" placeholder="Hindizo Buying Price Without GST" />
          </div>
          <div class="form-group col-md-4">
            <input type="text" class="form-control" name="hindizo_buying_with_gst" id="hindizo_buying_with_gst" placeholder="Hindizo Buying Gross Price" />
          </div>-->
          <div class="form-group col-md-4 average">
            <label for="average_price_p_calc" class="caption">Discount Offer From Average Online Price</label>
            <input type="text" class="form-control" name="average_price_p_calc" id="average_price_p_calcu" placeholder="Enter Discount Offer" />
          </div>
          <div class="col-sm-4 form-group ">
            <label for="taxformat" class="caption">Tax </label>
            <select class="form-control" id="taxformat">
              <option value="yes" selected="">>>On</option>
              <option value="yes">On</option>
              <option value="inclusive">Inclusive</option>
              <option value="off">Off</option>
              <option value="inclusive">CGST + SGST</option>
              <option value="inclusive">IGST</option>
              <option value="inclusive">Central GST 28%</option>
              <option value="inclusive">Local GST 28%</option>
              <option value="inclusive">Central GST 18%</option>
              <option value="inclusive">Local GST 18%</option>
              <option value="inclusive">Central GST 12%</option>
              <option value="inclusive">Local GST 12%</option>
              <option value="inclusive">Central GST 5%</option>
              <option value="inclusive"> Local GST 5%</option>
            </select>
          </div>
          <div class="col-sm-4 form-group">
            <label for="discountFormat" class="caption"> Discount</label>
            <select class="form-control" id="discountFormat">
              <option value="b_p">-- % Discount Before TAX--</option>
              <option value="%"> % Discount After TAX</option>
              <option value="flat">Flat Discount After TAX</option>
              <option value="b_p"> % Discount Before TAX</option>
              <option value="bflat">Flat Discount Before TAX</option>
            </select>
          </div>
          <div class="form-group col-md-12">
            <input type="submit" class="btn btn-primary" name="submit" id="submit" value="SET PRICE AND PURCHASE THE PRODUCT" style="width:15%; margin: 15px 0px; float:right" />
            <input type="button" class="btn btn-primary" name="calc" id="calc" value="CALCULATE" style="width:15%; margin: 15px 10px; float:right" />
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<script>
	$('#add-another').click(function(){
		var num = Math.floor(Math.random() * 6) + 1;
		var parents = $(this).parent();
		$('<div class="col-md-4 row manual new'+num+'"><div class="col-md-8 form-group"><label style="color:white;">ABC</label><input type="text" class="form-control" name="otherwebsite_price" id="otherwebsite_price" placeholder="Enter Other Website Price" /></div><div class="col-md-4"><button type="button" value="1" class="btn btn-warning" style="margin: 25px 0px;" onclick="remove_otherwebsite('+num+')">REMOVE</button></div></div>').insertBefore(parents);
	});
	
	
	function remove_otherwebsite(e){
		$('.new'+e).remove();
	}
</script>
