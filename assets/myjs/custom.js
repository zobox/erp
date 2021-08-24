var billtype = $('#billtype').val();
var d_csrf = crsf_token + '=' + crsf_hash;
$('#addproduct-asset').on('click', function () {
    var cvalue = parseInt($('#ganak').val()) + 1;
    var nxt = parseInt(cvalue);
    $('#ganak').val(nxt);
    var functionNum = "'" + cvalue + "'";
    count = $('#saman-row div').length;
    var pro_tax = $('#pro_tax').val();

    var data = '<tr><td><input type="text" class="form-control" name="product_name[]" placeholder="Enter Product name or Code" id="productname-' + cvalue + '"></td><td><input type="text" class="form-control req amnt" name="product_qty[]" id="amount-' + cvalue + '" onkeypress="return isNumber(event)" onkeyup="rowTotal(' + functionNum + '), billUpyog()" autocomplete="off" value="1"  inputmode="numeric"><input type="hidden" id="alert-' + cvalue + '" value=""  name="alert[]"> </td> <td><input type="text" class="form-control req prc" name="product_price[]" id="price-' + cvalue + '" onkeypress="return isNumber(event)" onkeyup="rowTotal(' + functionNum + '), billUpyog()" autocomplete="off" inputmode="numeric"></td><td> <input type="text" class="form-control vat" value="'+pro_tax+'" name="product_tax[]" id="vat-' + cvalue + '" onkeypress="return isNumber(event)" readonly onkeyup="rowTotal(' + functionNum + '), billUpyog()" autocomplete="off" inputmode="numeric"></td> <td id="texttaxa-' + cvalue + '" class="text-center">0</td> <td><input type="text" class="form-control discount" name="product_discount[]" onkeypress="return isNumber(event)" id="discount-' + cvalue + '" onkeyup="rowTotal(' + functionNum + '), billUpyog()" autocomplete="off"></td> <td><span class="currenty">' + currency + '</span> <strong><span class=\'ttlText\' id="result-' + cvalue + '">0</span></strong></td> <td class="text-center"><button type="button" data-rowid="' + cvalue + '" class="btn btn-danger removeProd" title="Remove" > <i class="fa fa-minus-square"></i> </button> </td><input type="hidden" name="taxa[]" id="taxa-' + cvalue + '" value="0"><input type="hidden" name="disca[]" id="disca-' + cvalue + '" value="0"><input type="hidden" class="ttInput" name="product_subtotal[]" id="total-' + cvalue + '" value="0"> <input type="hidden" class="pdIn" name="pid[]" id="pid-' + cvalue + '" value="0"> <input type="hidden" name="unit[]" id="unit-' + cvalue + '" value=""> <input type="hidden" name="hsn[]" id="hsn-' + cvalue + '" value=""> <input type="hidden" name="serial[]" id="serial-' + cvalue + '" value=""> </tr><tr><td colspan="8"><textarea class="form-control"  id="dpid-' + cvalue + '" name="product_description[]" placeholder="Enter Product description" autocomplete="off"></textarea><br></td></tr>';
     //ajax request
    // $('#saman-row').append(data);
    $('tr.last-item-row').before(data);

    row = cvalue;

    $('#productname-' + cvalue).autocomplete({
        source: function (request, response) {
            $.ajax({
                url: baseurl + 'search_products/' + billtype,
                dataType: "json",
                method: 'post',
                data: 'name_startsWith=' + request.term + '&type=product_list&row_num=' + row + '&wid=' + $("#s_warehouses option:selected").val() + '&' + d_csrf,
                success: function (data) {
                    response($.map(data, function (item) {
                        var product_d = item[0];
                        return {
                            label: product_d,
                            value: product_d,
                            data: item
                        };
                    }));
                }
            });
        },
        autoFocus: true,
        minLength: 0,
        select: function (event, ui) {
            id_arr = $(this).attr('id');
            id = id_arr.split("-");
            var t_r = ui.item.data[3];
            if ($("#taxformat option:selected").attr('data-trate')) {

                t_r = $("#taxformat option:selected").attr('data-trate');
            }
            var discount = ui.item.data[4];
            var custom_discount = $('#custom_discount').val();
            if (custom_discount > 0) discount = deciFormat(custom_discount);

            $('#amount-' + id[1]).val(1);
            $('#price-' + id[1]).val(ui.item.data[1]);
            $('#pid-' + id[1]).val(ui.item.data[2]);
            $('#vat-' + id[1]).val(t_r);
            $('#discount-' + id[1]).val(discount);
            $('#dpid-' + id[1]).val(ui.item.data[5]);
            $('#unit-' + id[1]).val(ui.item.data[6]);
            $('#hsn-' + id[1]).val(ui.item.data[7]);
            $('#alert-' + id[1]).val(ui.item.data[8]);
            $('#serial-' + id[1]).val(ui.item.data[10]);
            $('#serial_id-' + id[1]).val(ui.item.data[11]);
            rowTotal(cvalue);
            billUpyog();


        },
        create: function (e) {
            $(this).prev('.ui-helper-hidden-accessible').remove();
        }
    });

});




$('#addproduct2').on('click', function () {
    var cvalue = parseInt($('#ganak').val()) + 1;
    

    var nxt = parseInt(cvalue);
    $('#ganak').val(nxt);
    var functionNum = "'" + cvalue + "'";
    count = $('#saman-row div').length;

    //var pro_tax = ui.item.data[3];
        if ($("#taxformat option:selected").attr('data-trate')) {

          var pro_tax = $("#taxformat option:selected").attr('data-trate');
        }
   // var pro_tax = $('#pro_tax').val();

    var data = '<tr><td><input type="text" class="form-control" name="product_name[]" placeholder="Enter Product name or Code" id="productname-' + cvalue + '"></td><td><input type="text" class="form-control req amnt" name="product_qty[]" id="amount-' + cvalue + '" onkeypress="return isNumber(event)" onkeyup="rowTotal(' + functionNum + '), billUpyog()" autocomplete="off" value="1"  inputmode="numeric"><input type="hidden" id="alert-' + cvalue + '" value=""  name="alert[]"> </td> <td><input type="text" class="form-control req prc" name="product_price[]" id="price-' + cvalue + '" onkeypress="return isNumber(event)" onkeyup="rowTotal(' + functionNum + '), billUpyog()" autocomplete="off" inputmode="numeric"></td><td> <input type="text" class="form-control vat" value="'+pro_tax+'" name="product_tax[]" id="vat-' + cvalue + '" onkeypress="return isNumber(event)" onkeyup="rowTotal(' + functionNum + '), billUpyog()" autocomplete="off" inputmode="numeric"></td> <td id="texttaxa-' + cvalue + '" class="text-center">0</td> <td><input type="text" class="form-control discount" name="product_discount[]" onkeypress="return isNumber(event)" id="discount-' + cvalue + '" onkeyup="rowTotal(' + functionNum + '), billUpyog()" autocomplete="off"></td> <td><span class="currenty">' + currency + '</span> <strong><span class=\'ttlText\' id="result-' + cvalue + '">0</span></strong></td> <td class="text-center"><button type="button" data-rowid="' + cvalue + '" class="btn btn-danger removeProd" title="Remove" > <i class="fa fa-minus-square"></i> </button> </td><input type="hidden" name="taxa[]" id="taxa-' + cvalue + '" value="0"><input type="hidden" name="disca[]" id="disca-' + cvalue + '" value="0"><input type="hidden" class="ttInput" name="product_subtotal[]" id="total-' + cvalue + '" value="0"> <input type="hidden" class="pdIn" name="pid[]" id="pid-' + cvalue + '" value="0"> <input type="hidden" name="unit[]" id="unit-' + cvalue + '" value=""> <input type="hidden" name="hsn[]" id="hsn-' + cvalue + '" value=""> <input type="hidden" name="serial[]" id="serial-' + cvalue + '" value=""> </tr><tr><td colspan="8"><textarea class="form-control"  id="dpid-' + cvalue + '" name="product_description[]" placeholder="Enter Product description" autocomplete="off"></textarea><br></td></tr>';
     //ajax request
    // $('#saman-row').append(data);
    $('tr.last-item-row').before(data);

    row = cvalue;
    
    var po = $('#po_type').val();
    //if(po=='0')
    //{
    $('#productname-' + cvalue).autocomplete({
        source: function (request, response) {
            $.ajax({
                url: baseurl + 'search_products/' + billtype,
                dataType: "json",
                method: 'post',
                data: 'name_startsWith=' + request.term + '&type=product_list&row_num=' + row + '&wid=' + $("#s_warehouses option:selected").val() + '&' + d_csrf,
                success: function (data) {
                    response($.map(data, function (item) {
                        var product_d = item[0];
                        return {
                            label: product_d,
                            value: product_d,
                            data: item
                        };
                    }));
                }
            });
        },
        autoFocus: true,
        minLength: 0,
        select: function (event, ui) {
            id_arr = $(this).attr('id');
            id = id_arr.split("-");
            var t_r = ui.item.data[3];
            if ($("#taxformat option:selected").attr('data-trate')) {

                t_r = $("#taxformat option:selected").attr('data-trate');
            }
            var discount = ui.item.data[4];
            var custom_discount = $('#custom_discount').val();
            if (custom_discount > 0) discount = deciFormat(custom_discount);

            $('#amount-' + id[1]).val(1);
            $('#price-' + id[1]).val(ui.item.data[1]);
            $('#pid-' + id[1]).val(ui.item.data[2]);
            //$('#vat-' + id[1]).val(t_r);
            $('#discount-' + id[1]).val(discount);
            $('#dpid-' + id[1]).val(ui.item.data[5]);
            $('#unit-' + id[1]).val(ui.item.data[6]);
            $('#hsn-' + id[1]).val(ui.item.data[7]);
            $('#alert-' + id[1]).val(ui.item.data[8]);
            $('#serial-' + id[1]).val(ui.item.data[10]);
            $('#serial_id-' + id[1]).val(ui.item.data[11]);
            rowTotal(cvalue);
            billUpyog();


        },
        create: function (e) {
            $(this).prev('.ui-helper-hidden-accessible').remove();
        }
    });
//}

});


$('#addproduct').on('click', function () {
    var cvalue = parseInt($('#ganak').val()) + 1;
    var nxt = parseInt(cvalue);
    $('#ganak').val(nxt);
    var functionNum = "'" + cvalue + "'";
    count = $('#saman-row div').length;

    
    
    var data = '<tr><td><input type="text" class="form-control" name="product_name[]" placeholder="Enter Product name or Code" id="productname-' + cvalue + '"></td><td><input type="text" class="form-control req amnt" name="product_qty[]" id="amount-' + cvalue + '" onkeypress="return isNumber(event)" onkeyup="rowTotal(' + functionNum + '), billUpyog()" autocomplete="off" value="1"  inputmode="numeric"><input type="hidden" id="alert-' + cvalue + '" value=""  name="alert[]"> </td> <td><input type="text" class="form-control req prc" name="product_price[]" id="price-' + cvalue + '" onkeypress="return isNumber(event)" onkeyup="rowTotal(' + functionNum + '), billUpyog()" autocomplete="off" inputmode="numeric"></td><td> <input type="text" class="form-control vat" value="0" name="product_tax[]" id="vat-' + cvalue + '" onkeypress="return isNumber(event)" onkeyup="rowTotal(' + functionNum + '), billUpyog()" autocomplete="off" inputmode="numeric"></td> <td id="texttaxa-' + cvalue + '" class="text-center">0</td> <td><input type="text" class="form-control discount" name="product_discount[]" onkeypress="return isNumber(event)" id="discount-' + cvalue + '" onkeyup="rowTotal(' + functionNum + '), billUpyog()" autocomplete="off"></td> <td><span class="currenty">' + currency + '</span> <strong><span class=\'ttlText\' id="result-' + cvalue + '">0</span></strong></td> <td class="text-center"><button type="button" data-rowid="' + cvalue + '" class="btn btn-danger removeProd" title="Remove" > <i class="fa fa-minus-square"></i> </button> </td><input type="hidden" name="taxa[]" id="taxa-' + cvalue + '" value="0"><input type="hidden" name="disca[]" id="disca-' + cvalue + '" value="0"><input type="hidden" class="ttInput" name="product_subtotal[]" id="total-' + cvalue + '" value="0"> <input type="hidden" class="pdIn" name="pid[]" id="pid-' + cvalue + '" value="0"> <input type="hidden" name="unit[]" id="unit-' + cvalue + '" value=""> <input type="hidden" name="hsn[]" id="hsn-' + cvalue + '" value=""> <input type="hidden" name="serial[]" id="serial-' + cvalue + '" value=""> </tr><tr><td colspan="8"><textarea class="form-control"  id="dpid-' + cvalue + '" name="product_description[]" placeholder="Enter Product description" autocomplete="off"></textarea><br></td></tr>';
     //ajax request
    // $('#saman-row').append(data);
    $('tr.last-item-row').before(data);

    row = cvalue;

    $('#productname-' + cvalue).autocomplete({
        source: function (request, response) {
            $.ajax({
                url: baseurl + 'search_products/' + billtype,
                dataType: "json",
                method: 'post',
                data: 'name_startsWith=' + request.term + '&type=product_list&row_num=' + row + '&wid=' + $("#s_warehouses option:selected").val() + '&' + d_csrf,
                success: function (data) {
                    
                    response($.map(data, function (item) {
                        console.log(data);
                        var product_d = item[0];
                        return {
                            label: product_d,
                            value: product_d,
                            data: item
                        };
                    }));
                }
            });
        },
        autoFocus: true,
        minLength: 0,
        select: function (event, ui) {
            id_arr = $(this).attr('id');
            id = id_arr.split("-");
            var t_r = ui.item.data[3];
            if ($("#taxformat option:selected").attr('data-trate')) {

                t_r = $("#taxformat option:selected").attr('data-trate');
            }
            var discount = ui.item.data[4];
            var custom_discount = $('#custom_discount').val();
            if (custom_discount > 0) discount = deciFormat(custom_discount);

            $('#amount-' + id[1]).val(1);
            $('#price-' + id[1]).val(ui.item.data[1]);
            $('#pid-' + id[1]).val(ui.item.data[2]);
            //$('#vat-' + id[1]).val(t_r);
            $('#discount-' + id[1]).val(discount);
            $('#dpid-' + id[1]).val(ui.item.data[5]);
            $('#unit-' + id[1]).val(ui.item.data[6]);
            $('#hsn-' + id[1]).val(ui.item.data[7]);
            $('#alert-' + id[1]).val(ui.item.data[8]);
            $('#serial-' + id[1]).val(ui.item.data[10]);
            $('#serial_id-' + id[1]).val(ui.item.data[11]);
            rowTotal(cvalue);
            billUpyog();


        },
        create: function (e) {
            $(this).prev('.ui-helper-hidden-accessible').remove();
        }
    });

});

$('#marginal-addproduct').on('click', function () {
    var cvalue = parseInt($('#ganak').val()) + 1;
    var nxt = parseInt(cvalue);
    $('#ganak').val(nxt);
    var functionNum = "'" + cvalue + "'";
    count = $('#saman-row div').length;

    
    
    var data = '<tr><td><input type="text" class="form-control" name="product_name[]" placeholder="Enter Product name or Code" id="productname-' + cvalue + '"></td><td><input type="text" class="form-control req amnt" name="product_qty[]" id="amount-' + cvalue + '" onkeypress="return isNumber(event)" onkeyup="rowTotal(' + functionNum + '), billUpyog()" autocomplete="off" value="1"  inputmode="numeric"><input type="hidden" id="alert-' + cvalue + '" value=""  name="alert[]"> </td> <td><input type="text" class="form-control req prc" name="product_price[]" id="price-' + cvalue + '" onkeypress="return isNumber(event)" onkeyup="rowTotal(' + functionNum + '), billUpyog()" autocomplete="off" inputmode="numeric"></td><td> <input type="text" class="form-control vat" value="0" name="product_tax[]" readonly id="vat-' + cvalue + '" onkeypress="return isNumber(event)" onkeyup="rowTotal(' + functionNum + '), billUpyog()" autocomplete="off" inputmode="numeric"></td> <td id="texttaxa-' + cvalue + '" class="text-center">0</td> <td><input type="text" class="form-control discount" name="product_discount[]" onkeypress="return isNumber(event)" id="discount-' + cvalue + '" onkeyup="rowTotal(' + functionNum + '), billUpyog()" autocomplete="off"></td> <td><span class="currenty">' + currency + '</span> <strong><span class=\'ttlText\' id="result-' + cvalue + '">0</span></strong></td> <td class="text-center"><button type="button" data-rowid="' + cvalue + '" class="btn btn-danger removeProd" title="Remove" > <i class="fa fa-minus-square"></i> </button> </td><input type="hidden" name="taxa[]" id="taxa-' + cvalue + '" value="0"><input type="hidden" name="disca[]" id="disca-' + cvalue + '" value="0"><input type="hidden" class="ttInput" name="product_subtotal[]" id="total-' + cvalue + '" value="0"> <input type="hidden" class="pdIn" name="pid[]" id="pid-' + cvalue + '" value="0"> <input type="hidden" name="unit[]" id="unit-' + cvalue + '" value=""> <input type="hidden" name="hsn[]" id="hsn-' + cvalue + '" value=""> <input type="hidden" name="serial[]" id="serial-' + cvalue + '" value=""> </tr><tr><td colspan="8"><textarea class="form-control"  id="dpid-' + cvalue + '" name="product_description[]" placeholder="Enter Product description" autocomplete="off"></textarea><br></td></tr>';
     //ajax request
    // $('#saman-row').append(data);
    $('tr.last-item-row').before(data);

    row = cvalue;

    $('#productname-' + cvalue).autocomplete({
        source: function (request, response) {
            $.ajax({
                url: baseurl + 'search_products/' + billtype,
                dataType: "json",
                method: 'post',
                data: 'name_startsWith=' + request.term + '&type=product_list&row_num=' + row + '&wid=' + $("#s_warehouses option:selected").val() + '&' + d_csrf,
                success: function (data) {
                    
                    response($.map(data, function (item) {
                        console.log(data);
                        var product_d = item[0];
                        return {
                            label: product_d,
                            value: product_d,
                            data: item
                        };
                    }));
                }
            });
        },
        autoFocus: true,
        minLength: 0,
        select: function (event, ui) {
            id_arr = $(this).attr('id');
            id = id_arr.split("-");
            var t_r = ui.item.data[3];
            if ($("#taxformat option:selected").attr('data-trate')) {

                t_r = $("#taxformat option:selected").attr('data-trate');
            }
            var discount = ui.item.data[4];
            var custom_discount = $('#custom_discount').val();
            if (custom_discount > 0) discount = deciFormat(custom_discount);

            $('#amount-' + id[1]).val(1);
            $('#price-' + id[1]).val(ui.item.data[1]);
            $('#pid-' + id[1]).val(ui.item.data[2]);
            //$('#vat-' + id[1]).val(t_r);
            $('#discount-' + id[1]).val(discount);
            $('#dpid-' + id[1]).val(ui.item.data[5]);
            $('#unit-' + id[1]).val(ui.item.data[6]);
            $('#hsn-' + id[1]).val(ui.item.data[7]);
            $('#alert-' + id[1]).val(ui.item.data[8]);
            $('#serial-' + id[1]).val(ui.item.data[10]);
            $('#serial_id-' + id[1]).val(ui.item.data[11]);
            rowTotal(cvalue);
            billUpyog();


        },
        create: function (e) {
            $(this).prev('.ui-helper-hidden-accessible').remove();
        }
    });

});
//For Stock Transfer
$('#addproduct1').on('click', function () {
    var cvalue = parseInt($('#ganak').val()) + 1;
    var nxt = parseInt(cvalue);
    $('#ganak').val(nxt);
    var functionNum = "'" + cvalue + "'";
    count = $('#saman-row div').length;
//product row
    var data = '<tr><td><input type="text" class="form-control" name="product_name[]" placeholder="Enter Product name or Code" id="productname-' + cvalue + '"></td><td><input type="text" class="form-control req amnt" name="product_qty[]" id="amount-' + cvalue + '" onkeypress="return isNumber(event)" onkeyup="rowTotal(' + functionNum + '), billUpyog()" autocomplete="off" value="1"  inputmode="numeric"><input type="hidden" id="alert-' + cvalue + '" value=""  name="alert[]"> </td> <td><input type="text" class="form-control req prc" name="product_price[]" id="price-' + cvalue + '" onkeypress="return isNumber(event)" onkeyup="rowTotal(' + functionNum + '), billUpyog()" autocomplete="off" inputmode="numeric"></td><td> <input type="text" class="form-control vat" name="product_tax[]" id="vat-' + cvalue + '" onkeypress="return isNumber(event)" onkeyup="rowTotal(' + functionNum + '), billUpyog()" autocomplete="off" inputmode="numeric"></td> <td id="texttaxa-' + cvalue + '" class="text-center">0</td> <td><input type="text" class="form-control discount" name="product_discount[]" onkeypress="return isNumber(event)" id="discount-' + cvalue + '" onkeyup="rowTotal(' + functionNum + '), billUpyog()" autocomplete="off"></td> <td><span class="currenty">' + currency + '</span> <strong><span class=\'ttlText\' id="result-' + cvalue + '">0</span></strong></td> <td class="text-center"><button type="button" data-rowid="' + cvalue + '" class="btn btn-danger removeProd" title="Remove" > <i class="fa fa-minus-square"></i> </button> </td><input type="hidden" name="taxa[]" id="taxa-' + cvalue + '" value="0"><input type="hidden" name="disca[]" id="disca-' + cvalue + '" value="0"><input type="hidden" class="ttInput" name="product_subtotal[]" id="total-' + cvalue + '" value="0"> <input type="hidden" class="pdIn" name="pid[]" id="pid-' + cvalue + '" value="0"> <input type="hidden" name="unit[]" id="unit-' + cvalue + '" value=""> <input type="hidden" name="hsn[]" id="hsn-' + cvalue + '" value=""> <input type="hidden" name="serial[]" id="serial-' + cvalue + '" value=""> </tr><tr><td colspan="8"><textarea class="form-control"  id="dpid-' + cvalue + '" name="product_description[]" placeholder="Enter Product description" autocomplete="off"></textarea><br></td></tr>';
    //ajax request
    // $('#saman-row').append(data);
    $('tr.last-item-row').before(data);

    row = cvalue;
    //alert(billtype);
    $('#productname-' + cvalue).autocomplete({
        source: function (request, response) {
            $.ajax({
                url: baseurl + 'search_products/' + billtype,
                dataType: "json",
                method: 'post',
                data: 'name_startsWith=' + request.term + '&type=product_list&row_num=' + row + '&wid=' + $("#s_warehouses option:selected").val() + '&' + d_csrf,
                success: function (data) {
                    //console.log(data);
                    response($.map(data, function (item) {
                        var product_d = item[0];
                        return {
                            label: product_d,
                            value: product_d,
                            data: item
                        };
                    }));
                }
            });
        },
        autoFocus: true,
        minLength: 0,
        select: function (event, ui) {
            id_arr = $(this).attr('id');
            id = id_arr.split("-");
            var t_r = ui.item.data[3];
            if ($("#taxformat option:selected").attr('data-trate')) {

                t_r = $("#taxformat option:selected").attr('data-trate');
            }
            var discount = ui.item.data[4];
            var custom_discount = $('#custom_discount').val();
            if (custom_discount > 0) discount = deciFormat(custom_discount);

            $('#amount-' + id[1]).val(1);
            $('#price-' + id[1]).val(ui.item.data[1]);
            $('#pid-' + id[1]).val(ui.item.data[2]);
            $('#vat-' + id[1]).val(t_r);
            $('#discount-' + id[1]).val(discount);
            $('#dpid-' + id[1]).val(ui.item.data[5]);
            $('#unit-' + id[1]).val(ui.item.data[6]);
            $('#hsn-' + id[1]).val(ui.item.data[7]);
            $('#alert-' + id[1]).val(ui.item.data[8]);
            $('#serial-' + id[1]).val(ui.item.data[10]);
            $('#serial_id-' + id[1]).val(ui.item.data[11]);
            rowTotal(cvalue);
            billUpyog();
        },
        create: function (e) {
            $(this).prev('.ui-helper-hidden-accessible').remove();
        }
    });

});

//caculations
var precentCalc = function (total, percentageVal) {
    var pr = (total / 100) * percentageVal;
    return parseFloat(pr);
};
//format
var deciFormat = function (minput) {
    if (!minput) minput = 0;
    return parseFloat(minput).toFixed(2);
};
var formInputGet = function (iname, inumber) {
    var inputId;
    inputId = iname + '-' + inumber;
    var inputValue = $(inputId).val();

    if (inputValue == '') {

        return 0;
    } else {
        return inputValue;
    }
};

//ship calculation
var coupon = function () {
    var cp = 0;
    if ($('#coupon_amount').val()) {
        cp = accounting.unformat($('#coupon_amount').val(), accounting.settings.number.decimal);
    }
    return cp;
};
var shipTot = function () {
    var ship_val = accounting.unformat($('.shipVal').val(), accounting.settings.number.decimal);
    var ship_p = 0;
    if ($("#taxformat option:selected").attr('data-trate')) {
        var ship_rate = $("#taxformat option:selected").attr('data-trate');
    } else {
        var ship_rate = accounting.unformat($('#ship_rate').val(), accounting.settings.number.decimal);
    }
    var tax_status = $("#ship_taxtype").val();
    if (tax_status == 'excl') {
        ship_p = (ship_val * ship_rate) / 100;
        ship_val = ship_val + ship_p;
    } else if (tax_status == 'incl') {
        ship_p = (ship_val * ship_rate) / (100 + ship_rate);
    }
    $('#ship_tax').val(accounting.formatNumber(ship_p));
    $('#ship_final').html(accounting.formatNumber(ship_p));
    return ship_val;
};

//product total
var samanYog = function () {
    var itempriceList = [];
    var idList = [];
    var r = 0;
    $('.ttInput').each(function () {
        var vv = accounting.unformat($(this).val(), accounting.settings.number.decimal);
        var vid = $(this).attr('id');
        vid = vid.split("-");
        itempriceList.push(vv);
        idList.push(vid[1]);
        r++;
    });
    var sum = 0;
    var taxc = 0;
    var discs = 0;
    var marginal_gst_price = 0;
    for (var z = 0; z < idList.length; z++) {

        var x = idList[z];
        if (itempriceList[z] > 0) {
            sum += itempriceList[z];
        }
        var t1=accounting.unformat($("#taxa-" + x).val(), accounting.settings.number.decimal);
        var d1=accounting.unformat($("#disca-" + x).val(), accounting.settings.number.decimal);
        

        var marginal_product_type=accounting.unformat($("#marginal_product_type" + x).val(), accounting.settings.number.decimal);
        var marginal_price=accounting.unformat($("#marginal_gst_price"+x).val(), accounting.settings.number.decimal);

        if (t1 > 0) {
            taxc += t1;

        }
        if (d1 > 0) {
            discs += d1;
            //marginal_gst_price +=marginal_price;
        }
        if(marginal_price>0)
         {
         marginal_gst_price +=marginal_price;
         }
        
        
    }
    
    $("#discs").html(accounting.formatNumber(discs));
    //alert(accounting.formatNumber(taxc));
   $('#marginal_gst').html(accounting.formatNumber(marginal_gst_price));
    $("#taxr").html(accounting.formatNumber(taxc));
    return accounting.unformat(sum, accounting.settings.number.decimal);
};

//actions
var deleteRow = function (num) {
    var totalSelector = $("#subttlform");
    var prodttl = accounting.unformat($("#total-" + num).val(),accounting.settings.number.decimal);
    var subttl =  accounting.unformat(totalSelector.val(),accounting.settings.number.decimal);
    var totalSubVal =subttl - prodttl;
    totalSelector.val(totalSubVal);
    $("#subttlid").html(accounting.formatNumber(totalSubVal));
    var totalBillVal = totalSubVal + shipTot - coupon;
    //final total
    var clean = accounting.formatNumber(totalBillVal);
    $("#mahayog").html(clean);
    $("#invoiceyoghtml").val(clean);
    $("#bigtotal").html(clean);
};


var billUpyog = function () {
    var out = 0;
    var disc_val = accounting.unformat($('.discVal').val(),accounting.settings.number.decimal);
    if (disc_val) {
        $("#subttlform").val( accounting.formatNumber(samanYog()));
        var disc_rate = $('#discountFormat').val();

        switch (disc_rate) {
            case '%':
                out = precentCalc(accounting.unformat($('#subttlform').val(),accounting.settings.number.decimal), disc_val);
                break;
            case 'b_p':
                out = precentCalc(accounting.unformat($('#subttlform').val(),accounting.settings.number.decimal), disc_val);
                break;
            case 'flat':
                out = accounting.unformat(disc_val,accounting.settings.number.decimal);
                break;
            case 'bflat':
                out = accounting.unformat(disc_val,accounting.settings.number.decimal);
                break;
        }
        out = parseFloat(out).toFixed(two_fixed);

        $('#disc_final').html(accounting.formatNumber(out));
        $('#after_disc').val(accounting.formatNumber(out));
    } else {
        $('#disc_final').html(0);
        $('#after_disc').val(0);
    }
    var totalBillVal = accounting.formatNumber(samanYog() + shipTot() - coupon() - out);
    $("#mahayog").html(totalBillVal);
    $("#subttlform").val(accounting.formatNumber(samanYog()));
    $("#invoiceyoghtml").val(totalBillVal);
    $("#bigtotal").html(totalBillVal);
};

var o_rowTotal = function (numb) {
    //most res
    var result;
    var totalValue;
    var amountVal = formInputGet("#amount", numb);
    var priceVal = formInputGet("#price", numb);
    var discountVal = formInputGet("#discount", numb);
    if (discountVal == '') {
        $("#discount-" + numb).val(0);
        discountVal = 0;
    }
    var vatVal = formInputGet("#vat", numb);
    if (vatVal == '') {
        $("#vat-" + numb).val(0);
        vatVal = 0;
    }
    var taxo = 0;
    var disco = 0;
    var totalPrice = (parseFloat(amountVal).toFixed(2)) * priceVal;
    var tax_status = $("#taxformat option:selected").val();
    var disFormat = $("#discount_format").val();

    //tax after bill
    if (tax_status == 'yes') {
        if (disFormat == '%' || disFormat == 'flat') {
            //tax
            var Inpercentage = precentCalc(totalPrice, vatVal);
            totalValue = parseFloat(totalPrice) + parseFloat(Inpercentage);
            taxo = deciFormat(Inpercentage);


            if (disFormat == 'flat') {
                disco = deciFormat(discountVal);
                totalValue = parseFloat(totalValue) - parseFloat(discountVal);
            } else if (disFormat == '%') {
                var discount = precentCalc(totalValue, discountVal);
                totalValue = parseFloat(totalValue) - parseFloat(discount);
                disco = deciFormat(discount);
            }

        } else {
//before tax
            if (disFormat == 'bflat') {
                disco = deciFormat(discountVal);
                totalValue = parseFloat(totalPrice) - parseFloat(discountVal);
            } else if (disFormat == 'b_p') {
                var discount = precentCalc(totalPrice, discountVal);
                totalValue = parseFloat(totalPrice) - parseFloat(discount);
                disco = deciFormat(discount);
            }

            //tax
            var Inpercentage = precentCalc(totalValue, vatVal);
            totalValue = parseFloat(totalValue) + parseFloat(Inpercentage);
            taxo = deciFormat(Inpercentage);


        }
    } else if (tax_status == 'inclusive') {
        if (disFormat == '%' || disFormat == 'flat') {
            //tax
            var Inpercentage = (+totalPrice * +vatVal) / (100 + +vatVal);
            totalValue = parseFloat(totalPrice);
            taxo = deciFormat(Inpercentage);


            if (disFormat == 'flat') {
                disco = deciFormat(discountVal);
                totalValue = parseFloat(totalValue) - parseFloat(discountVal);
            } else if (disFormat == '%') {
                var discount = precentCalc(totalValue, discountVal);
                totalValue = parseFloat(totalValue) - parseFloat(discount);
                disco = deciFormat(discount);
            }

        } else {
//before tax
            if (disFormat == 'bflat') {
                disco = deciFormat(discountVal);
                totalValue = parseFloat(totalPrice) - parseFloat(discountVal);
            } else if (disFormat == 'b_p') {
                var discount = precentCalc(totalPrice, discountVal);
                totalValue = parseFloat(totalPrice) - parseFloat(discount);
                disco = deciFormat(discount);
            }

            //tax
            var Inpercentage = (+totalPrice * +vatVal) / (100 + +vatVal);
            totalValue = parseFloat(totalValue);
            taxo = deciFormat(Inpercentage);


        }
    } else {
        taxo = 0;
        if (disFormat == '%' || disFormat == 'flat') {
            //tax

            //  totalValue = deciFormat(totalPrice);


            if (disFormat == 'flat') {
                disco = deciFormat(discountVal);
                totalValue = parseFloat(totalPrice) - parseFloat(discountVal);
            } else if (disFormat == '%') {
                var discount = precentCalc(totalPrice, discountVal);
                totalValue = parseFloat(totalPrice) - parseFloat(discount);
                disco = deciFormat(discount);
            }

        } else {
//before tax
            if (disFormat == 'bflat') {
                disco = deciFormat(discountVal);
                totalValue = parseFloat(totalPrice) - parseFloat(discountVal);
            } else if (disFormat == 'b_p') {
                var discount = precentCalc(totalPrice, discountVal);
                totalValue = parseFloat(totalPrice) - parseFloat(discount);
                disco = deciFormat(discount);
            }
        }
    }
    $("#result-" + numb).html(deciFormat(totalValue));
    $("#taxa-" + numb).val(taxo);
    $("#texttaxa-" + numb).text(taxo);
    $("#disca-" + numb).val(disco);
    var totalID = "#total-" + numb;
    $(totalID).val(deciFormat(totalValue));
    samanYog();
};
var rowTotal = function (numb) {
    //most res
    var result;
    var page = '';
    var totalValue = 0;
    var amountVal = accounting.unformat($("#amount-" + numb).val(), accounting.settings.number.decimal);
    var priceVal = accounting.unformat($("#price-" + numb).val(), accounting.settings.number.decimal);
    var discountVal = accounting.unformat($("#discount-" + numb).val(), accounting.settings.number.decimal);
    var vatVal = accounting.unformat($("#vat-" + numb).val(), accounting.settings.number.decimal);
    var taxo = 0;
    var disco = 0;
    var totalPrice = amountVal.toFixed(two_fixed) * priceVal;   
    var tax_status = $("#taxformat option:selected").val();
    var disFormat = $("#discount_format").val();
    if ($("#inv_page").val() == 'new_i' && formInputGet("#pid", numb) > 0) {
        var alertVal = accounting.unformat($("#alert-" + numb).val(), accounting.settings.number.decimal);
        if (alertVal <= +amountVal) {
            var aqt = alertVal-amountVal;
            alert('Low Stock! ' + accounting.formatNumber(aqt));
        }
    }
    //tax after bill
    if (tax_status == 'yes') {
        if (disFormat == '%' || disFormat == 'flat') {
            //tax
            var Inpercentage = precentCalc(totalPrice, vatVal);
            totalValue = totalPrice + Inpercentage;
            taxo = accounting.formatNumber(Inpercentage);
            if (disFormat == 'flat') {
                disco = accounting.formatNumber(discountVal);
                totalValue = totalValue - discountVal;
            } else if (disFormat == '%') {
                var discount = precentCalc(totalValue, discountVal);
                totalValue = totalValue - discount;
                disco = accounting.formatNumber(discount);
            }
        } else {
//before tax
            if (disFormat == 'bflat') {
                disco = accounting.formatNumber(discountVal);
                totalValue = totalPrice - discountVal;
            } else if (disFormat == 'b_p') {
                var discount = precentCalc(totalPrice, discountVal);
                totalValue = totalPrice - discount;
                disco = accounting.formatNumber(discount);
            }

            //tax
            var Inpercentage = precentCalc(totalValue, vatVal);
            totalValue = totalValue + Inpercentage;
            taxo = accounting.formatNumber(Inpercentage);
        }
    } else if (tax_status == 'inclusive') {
        if (disFormat == '%' || disFormat == 'flat') {
            //tax
            var Inpercentage = (totalPrice * vatVal) / (100 + vatVal);
            totalValue = totalPrice;
            taxo = accounting.formatNumber(Inpercentage);
            if (disFormat == 'flat') {
                disco = accounting.formatNumber(discountVal);
                totalValue = totalValue - discountVal;
            } else if (disFormat == '%') {
                var discount = precentCalc(totalValue, discountVal);
                totalValue = totalValue - discount;
                disco = accounting.formatNumber(discount);
            }
        } else {
//before tax
            if (disFormat == 'bflat') {
                disco = accounting.formatNumber(discountVal);
                totalValue = totalPrice - discountVal;
            } else if (disFormat == 'b_p') {
                var discount = precentCalc(totalPrice, discountVal);
                totalValue = totalPrice - discount;
                disco = accounting.formatNumber(discount);
            }
            //tax
            var Inpercentage = (totalPrice * vatVal) / (100 + vatVal);
            totalValue = totalValue;
            taxo = accounting.formatNumber(Inpercentage);
        }
    } else {
        taxo = 0;
        if (disFormat == '%' || disFormat == 'flat') {
            if (disFormat == 'flat') {
                disco = accounting.formatNumber(discountVal);
                totalValue = totalPrice - discountVal;
            } else if (disFormat == '%') {
                var discount = precentCalc(totalPrice, discountVal);
                totalValue = totalPrice - discount;
                disco = accounting.formatNumber(discount);
            }

        } else {
//before tax
            if (disFormat == 'bflat') {
                disco = accounting.formatNumber(discountVal);
                totalValue = totalPrice - discountVal;
            } else if (disFormat == 'b_p') {
                var discount = precentCalc(totalPrice, discountVal);
                totalValue = totalPrice - discount;
                disco = accounting.formatNumber(discount);
            }
        }
    }
    //alert(Math.ceil(totalValue));
    totalValue = Math.ceil(totalValue);
    var marginal_product_type=$("#marginal_product_type"+numb).val()
    $("#result-" + numb).html(accounting.formatNumber(totalValue));
    if(marginal_product_type==2)
    {
     taxo = '0.00';
    }
    $("#taxa-" + numb).val(taxo);
    $("#texttaxa-" + numb).text(taxo);
    $("#disca-" + numb).val(disco);
    $("#total-" + numb).val(accounting.formatNumber(totalValue));
    samanYog();
};
var changeTaxFormat = function (getSelectv) {

    if (getSelectv == 'yes') {
        var tformat = $('#taxformat option:selected').data('tformat');
        var trate = $('#taxformat option:selected').data('trate');
        $("#tax_status").val(tformat);
        $("#tax_format").val('%');
    } else if (getSelectv == 'inclusive') {
        var tformat = $('#taxformat option:selected').data('tformat');
        var trate = $('#taxformat option:selected').data('trate');
        $("#tax_status").val(tformat);
        $("#tax_format").val('incl');

    } else {
        $("#tax_status").val('no');
        $("#tax_format").val('off');

    }
    var discount_handle = $("#discountFormat").val();
    var tax_handle = $("#tax_format").val();
    formatRest(tax_handle, discount_handle, trate);
}

var changeDiscountFormat = function (getSelectv) {
    if (getSelectv != '0') {
        $(".disCol").show();
        $("#discount_handle").val('yes');
        $("#discount_format").val(getSelectv);
    } else {
        $("#discount_format").val(getSelectv);
        $(".disCol").hide();
        $("#discount_handle").val('no');
    }
    var tax_status = $("#tax_format").val();
    formatRest(tax_status, getSelectv);
}

function formatRest(taxFormat, disFormat, trate = '') {
    var amntArray = [];
    var idArray = [];
    $('.amnt').each(function () {
        var v = accounting.unformat($(this).val(), accounting.settings.number.decimal);
        var id_e = $(this).attr('id');
        id_e = id_e.split("-");
        idArray.push(id_e[1]);
        amntArray.push(v);
    });
    var prcArray = [];
    $('.prc').each(function () {
        var v = accounting.unformat($(this).val(), accounting.settings.number.decimal);
        prcArray.push(v);
    });
    var vatArray = [];
    $('.vat').each(function () {
        if (trate) {
            var v = accounting.unformat(trate, accounting.settings.number.decimal);
            $(this).val(v);
        } else {
            var v = accounting.unformat($(this).val(), accounting.settings.number.decimal);
        }
        vatArray.push(v);
    });

    var discountArray = [];
    $('.discount').each(function () {
        var v = accounting.unformat($(this).val(), accounting.settings.number.decimal);
        discountArray.push(v);
    });

    var taxr = 0;
    var discsr = 0;
    for (var i = 0; i < idArray.length; i++) {
        var x = idArray[i];
        amtVal = amntArray[i];
        prcVal = prcArray[i];
        vatVal = vatArray[i];
        discountVal = discountArray[i];
        var result = amtVal * prcVal;
        if (vatVal == '') {
            vatVal = 0;
        }
        if (discountVal == '') {
            discountVal = 0;
        }
        if (taxFormat == '%') {
            if (disFormat == '%' || disFormat == 'flat') {
                var Inpercentage = precentCalc(result, vatVal);
                var result = result + Inpercentage;
                taxr = taxr + Inpercentage;
                $("#texttaxa-" + x).html(accounting.formatNumber(Inpercentage));
                $("#taxa-" + x).val(accounting.formatNumber(Inpercentage));

                if (disFormat == '%') {
                    var Inpercentage = precentCalc(result, discountVal);
                    result = result - Inpercentage;
                    $("#disca-" + x).val(accounting.formatNumber(Inpercentage));
                    discsr = discsr + Inpercentage;
                } else if (disFormat == 'flat') {
                    result = parseFloat(result) - parseFloat(discountVal);
                    $("#disca-" + x).val(accounting.formatNumber(discountVal));
                    discsr += discountVal;
                }
            } else {
                if (disFormat == 'b_p') {
                    var Inpercentage = precentCalc(result, discountVal);
                    result = result - Inpercentage;
                    $("#disca-" + x).val(accounting.formatNumber(Inpercentage));
                    discsr = discsr + Inpercentage;
                } else if (disFormat == 'bflat') {
                    result = result - discountVal;
                    $("#disca-" + x).val(accounting.formatNumber(discountVal));
                    discsr += discountVal;
                }

                var Inpercentage = precentCalc(result, vatVal);
                result = result + Inpercentage;
                taxr = taxr + Inpercentage;
                $("#texttaxa-" + x).html(accounting.formatNumber(Inpercentage));
                $("#taxa-" + x).val(accounting.formatNumber(Inpercentage));

            }
        } else if (taxFormat == 'incl') {

            if (disFormat == '%' || disFormat == 'flat') {


                var Inpercentage = (result * vatVal) / (100 + vatVal);

                taxr = taxr + Inpercentage;
                $("#texttaxa-" + x).html(accounting.formatNumber(Inpercentage));
                $("#taxa-" + x).val(accounting.formatNumber(Inpercentage));

                if (disFormat == '%') {
                    var Inpercentage = precentCalc(result, discountVal);
                    result = result - Inpercentage;
                    $("#disca-" + x).val(accounting.formatNumber(Inpercentage));
                    discsr = discsr + Inpercentage;
                } else if (disFormat == 'flat') {
                    result = result - discountVal;
                    $("#disca-" + x).val(accounting.formatNumber(discountVal));
                    discsr += discountVal;
                }
            } else {
                if (disFormat == 'b_p') {
                    var Inpercentage = precentCalc(result, discountVal);
                    result = result - Inpercentage;
                    $("#disca-" + x).val(accounting.formatNumber(Inpercentage));
                    discsr = discsr + Inpercentage;
                } else if (disFormat == 'bflat') {
                    result = result - discountVal;
                    $("#disca-" + x).val(accounting.formatNumber(discountVal));
                    discsr += discountVal;
                }

                var Inpercentage = (result * vatVal) / (100 + vatVal);
                taxr = taxr + Inpercentage;
                $("#texttaxa-" + x).html(accounting.formatNumber(Inpercentage));
                $("#taxa-" + x).val(accounting.formatNumber(Inpercentage));

            }
        } else {

            if (disFormat == '%' || disFormat == 'flat') {

                var result = accounting.unformat($("#amount-" + x).val(), accounting.settings.number.decimal) * accounting.unformat($("#price-" + x).val(), accounting.settings.number.decimal);
                $("#texttaxa-" + x).html('Off');
                $("#taxa-" + x).val(0);
                taxr += 0;

                if (disFormat == '%') {
                    var Inpercentage = precentCalc(result, discountVal);
                    result = result - Inpercentage;
                    $("#disca-" + x).val(accounting.formatNumber(Inpercentage));
                    discsr = discsr + Inpercentage;
                } else if (disFormat == 'flat') {
                    var result = result - discountVal;
                    $("#disca-" + x).val(accounting.formatNumber(discountVal));
                    discsr += discountVal;
                }
            } else {
                if (disFormat == 'b_p') {
                    var Inpercentage = precentCalc(result, discountVal);
                    result = result - Inpercentage;
                    $("#disca-" + x).val(accounting.formatNumber(Inpercentage));
                    discsr = discsr + Inpercentage;
                } else if (disFormat == 'bflat') {
                    result = result - discountVal;
                    $("#disca-" + x).val(accounting.formatNumber(discountVal));
                    discsr += discountVal;
                }
                $("#texttaxa-" + x).html('Off');
                $("#taxa-" + x).val(0);
                taxr += 0;
            }
        }

        $("#total-" + x).val(accounting.formatNumber(result));
        $("#result-" + x).html(accounting.formatNumber(result));


    }
    var sum = accounting.formatNumber(samanYog());
    $("#subttlid").html(sum);
    $("#taxr").html(accounting.formatNumber(taxr));
    $("#discs").html(accounting.formatNumber(discsr));
    billUpyog();
}
//remove productrow

$('#saman-row').on('click', '.removeProd', function () {

    var pidd = $(this).closest('tr').find('.pdIn').val();
    var pqty = $(this).closest('tr').find('.amnt').val();
    pqty = pidd + '-' + pqty;
    $('<input>').attr({
        type: 'hidden',
        id: 'restock',
        name: 'restock[]',
        value: pqty
    }).appendTo('form');
    $(this).closest('tr').remove();
    $('#d' + $(this).closest('tr').find('.pdIn').attr('id')).closest('tr').remove();
    $('.amnt').each(function (index) {
        rowTotal(index);
        billUpyog();
    });

    return false;
});


$('#po_type').change(function(){
    var po = $('#po_type').val();

    

//if(po=='0')
//{

$('#assetproduct-0').autocomplete({

    source: function (request, response) {
        
        $.ajax({
            url: baseurl + 'search_products/' + billtype,
            dataType: "json",
            method: 'post',
            data: 'name_startsWith=' + request.term + '&type=product_list&row_num=1&wid=' + $("#s_warehouses option:selected").val() + '&' + d_csrf,
            success: function (data) { 

                response($.map(data, function (item) {
                    var product_d = item[0];
                    return {
                        label: product_d,
                        value: product_d,
                        data: item
                    };
                }));
            }
        });
    },
    autoFocus: true,
    minLength: 0,
    select: function (event, ui) {
        var t_r = ui.item.data[3];
        if ($("#taxformat option:selected").attr('data-trate')) {

            t_r = $("#taxformat option:selected").attr('data-trate');
        }
        var discount = ui.item.data[4];
        var custom_discount = $('#custom_discount').val();
        if (custom_discount > 0) discount = deciFormat(custom_discount);
        $('#amount-0').val(1);
        $('#price-0').val(ui.item.data[1]);
        $('#pid-0').val(ui.item.data[2]);
        $('#vat-0').val(t_r);
        $('#discount-0').val(discount);
        $('#dpid-0').val(ui.item.data[5]);
        $('#unit-0').val(ui.item.data[6]);
        $('#hsn-0').val(ui.item.data[7]);
        $('#alert-0').val(ui.item.data[8]);
        $('#serial-0').val(ui.item.data[10]);
        rowTotal(0);

        billUpyog();


    }
});
//}
});


$('#productname-0').autocomplete({

    source: function (request, response) {
    
        $.ajax({
            url: baseurl + 'search_products/' + billtype,
            dataType: "json",
            method: 'post',
            data: 'name_startsWith=' + request.term + '&type=product_list&row_num=1&wid=' + $("#s_warehouses option:selected").val() + '&' + d_csrf,
            success: function (data) { 
                response($.map(data, function (item) {
                    var product_d = item[0];
                    return {
                        label: product_d,
                        value: product_d,
                        data: item
                    };
                }));
            }
        });
    },
    autoFocus: true,
    minLength: 0,
    select: function (event, ui) {
        var t_r = ui.item.data[3];
        if ($("#taxformat option:selected").attr('data-trate')) {

            t_r = $("#taxformat option:selected").attr('data-trate');
        }
        var discount = ui.item.data[4];
        var custom_discount = $('#custom_discount').val();
        if (custom_discount > 0) discount = deciFormat(custom_discount);
        $('#amount-0').val(1);
        $('#price-0').val(ui.item.data[1]);
        $('#pid-0').val(ui.item.data[2]);
        $('#vat-0').val(t_r);
        $('#discount-0').val(discount);
        $('#dpid-0').val(ui.item.data[5]);
        $('#unit-0').val(ui.item.data[6]);
        $('#hsn-0').val(ui.item.data[7]);
        $('#alert-0').val(ui.item.data[8]);
        $('#serial-0').val(ui.item.data[10]);
        rowTotal(0);

        billUpyog();


    }
});


$('.asset_product').autocomplete({

    source: function (request, response) {
    
        $.ajax({
            url: baseurl + 'search_products/' + billtype,
            dataType: "json",
            method: 'post',
            data: 'name_startsWith=' + request.term + '&type=product_list&row_num=1&wid=' + $("#s_warehouses option:selected").val() + '&' + d_csrf,
            success: function (data) { 
                       
                response($.map(data, function (item) {
                    var product_d = item[0];
                    return {
                        label: product_d,
                        value: product_d,
                        data: item
                    };
                }));
            }
        });
    },
    autoFocus: true,
    minLength: 0,
    select: function (event, ui) {
        var t_r = ui.item.data[3];
        if ($("#taxformat option:selected").attr('data-trate')) {

            t_r = $("#taxformat option:selected").attr('data-trate');
        }
        var ct = $(".asset_product").attr('data-trate');
        
        var discount = ui.item.data[4];
        var custom_discount = $('#custom_discount').val();
        if (custom_discount > 0) discount = deciFormat(custom_discount);
        $('#amount-0').val(1);
        $('#price-0').val(ui.item.data[1]);
        $('#pid-0').val(ui.item.data[2]);
        $('#vat-0').val(t_r);
        $('#discount-0').val(discount);
        $('#dpid-0').val(ui.item.data[5]);
        $('#unit-0').val(ui.item.data[6]);
        $('#hsn-0').val(ui.item.data[7]);
        $('#alert-0').val(ui.item.data[8]);
        $('#serial-0').val(ui.item.data[10]);
        rowTotal(0);

        billUpyog();


    }
});




$("#serialno").change(function()
{
    var serial = $('#serialno').val();
        
    if($('#product_name-0').val()=='')
    {
    

        $.ajax({
            url: baseurl + 'search_products/' + billtype,
            dataType: "json",
            method: 'post',
            data: 'name_startsWith=' + serial + '&type=product_list&row_num=1&wid=' + $("#s_warehouses option:selected").val() + '&' + d_csrf,
            success: function (data) { 
               console.log(data);

         if(data[0]!=null)
         {
        var t_r = data[3];
         
       
        
        var discount = data[4];
        var custom_discount = $('#custom_discount').val();
        if (custom_discount > 0) discount = deciFormat(custom_discount);
        $('#product_name-0').val(data[0]);
        $('#amount-0').val(1);
        $('#price-0').val(data[1]);
        $('#pid-0').val(data[2]);
        $('#vat-0').val(t_r);
        $('#discount-0').val(discount);
        $('#dpid-0').val(data[5]);
        $('#unit-0').val(data[6]);
        $('#hsn-0').val(data[7]);
        $('#alert-0').val(data[8]);
        $('#serialNo-0').val(data[10]);
        $('#serial_id-0').val(data[10]);



        rowTotal(0);

        billUpyog();
        serial = $('#serialno').val('');

        $('#cnt').val('1');

         }
     }

        });
}

else
{     

     $.ajax({
            url: baseurl + 'search_products/' + billtype,
            dataType: "json",
            method: 'post',
            data: 'name_startsWith=' + serial + '&type=product_list&row_num=1&wid=' + $("#s_warehouses option:selected").val() + '&' + d_csrf,
            success: function (data) { 
               console.log(data[3]);
        var t_r = data[3];
         
        if(data[0]!=null && $('#product_name-0').val()!='' && $('#cnt').val()==1)
        {
        

       var cvalue = parseInt($('#ganak').val()) + 1;
      
      
    var nxt = parseInt(cvalue);
    $('#ganak').val(nxt);
    var functionNum = "'" + cvalue + "'";
    count = $('#saman-row div').length;
    
    var row = '<tr><td><input type="text" class="form-control" name="product_name[]" placeholder="Enter Product name or Code" id="product_name-' + cvalue + '"></td><td><input type="text" class="form-control req amnt" name="product_qty[]" id="amount-' + cvalue + '" onkeypress="return isNumber(event)" onkeyup="rowTotal(' + functionNum + '), billUpyog()" autocomplete="off" value="1"  inputmode="numeric"><input type="hidden" id="alert-' + cvalue + '" value=""  name="alert[]"> </td> <td><input type="text" class="form-control req prc" name="product_price[]" id="price-' + cvalue + '" onkeypress="return isNumber(event)" onkeyup="rowTotal(' + functionNum + '), billUpyog()" autocomplete="off" inputmode="numeric"></td><td> <input type="text" class="form-control vat" value="0" name="product_tax[]" id="vat-' + cvalue + '" onkeypress="return isNumber(event)" onkeyup="rowTotal(' + functionNum + '), billUpyog()" autocomplete="off" inputmode="numeric"></td> <td id="texttaxa-' + cvalue + '" class="text-center">0</td><td><input type="text" class="form-control discount" name="serial_no11[]" readonly onkeypress="return isNumber(event)" id="serialNo-' + cvalue + '" onkeyup="rowTotal(' + functionNum + '), billUpyog()" autocomplete="off"></td> <td><input type="text" class="form-control discount" name="product_discount[]" onkeypress="return isNumber(event)" id="discount-' + cvalue + '" onkeyup="rowTotal(' + functionNum + '), billUpyog()" autocomplete="off"></td> <td><span class="currenty">' + currency + '</span> <strong><span class=\'ttlText\' id="result-' + cvalue + '">0</span></strong></td> <td class="text-center"><button type="button" data-rowid="' + cvalue + '" class="btn btn-danger removeProd" title="Remove" > <i class="fa fa-minus-square"></i> </button> </td><input type="hidden" name="taxa[]" id="taxa-' + cvalue + '" value="0"><input type="hidden" name="disca[]" id="disca-' + cvalue + '" value="0"><input type="hidden" class="ttInput" name="product_subtotal[]" id="total-' + cvalue + '" value="0"> <input type="hidden" class="pdIn" name="pid[]" id="pid-' + cvalue + '" value="0"> <input type="hidden" name="unit[]" id="unit-' + cvalue + '" value=""> <input type="hidden" name="hsn[]" id="hsn-' + cvalue + '" value=""> <input type="hidden" name="serial_no[]" id="serial_id-' + cvalue + '" value=""> </tr><tr><td colspan="8"><textarea class="form-control"  id="dpid-' + cvalue + '" name="product_description[]" placeholder="Enter Product description" autocomplete="off"></textarea><br></td></tr>';
     //ajax request
    // $('#saman-row').append(data);
    $('tr.last-item-row').before(row);

           row = cvalue;

        var t_r = data[3];
        var discount = data[4];
        var custom_discount = $('#custom_discount').val();
        if (custom_discount > 0) discount = deciFormat(custom_discount);
        $('#product_name-'+cvalue).val(data[0]);
        $('#amount-'+cvalue).val(1);
        $('#price-'+cvalue).val(data[1]);
        $('#pid-'+cvalue).val(data[2]);
        $('#vat-'+cvalue).val(t_r);
        $('#discount-'+cvalue).val(discount);
        $('#dpid-'+cvalue).val(data[5]);
        $('#unit-'+cvalue).val(data[6]);
        $('#hsn-'+cvalue).val(data[7]);
        $('#alert-'+cvalue).val(data[8]);
        $('#serialNo-'+cvalue).val(data[10]);
        $('#serial_id-'+cvalue).val(data[10]);


        
        numb = cvalue;
        var result;
    var page = '';
    var totalValue = 0;
    var amountVal = accounting.unformat($("#amount-" + numb).val(), accounting.settings.number.decimal);
    var priceVal = accounting.unformat($("#price-" + numb).val(), accounting.settings.number.decimal);
    var discountVal = accounting.unformat($("#discount-" + numb).val(), accounting.settings.number.decimal);
    var vatVal = accounting.unformat($("#vat-" + numb).val(), accounting.settings.number.decimal);
    var taxo = 0;
    var disco = 0;
    var totalPrice = amountVal.toFixed(two_fixed) * priceVal;   
    var tax_status = $("#taxformat option:selected").val();
    var disFormat = $("#discount_format").val();
    if ($("#inv_page").val() == 'new_i' && formInputGet("#pid", numb) > 0) {
        var alertVal = accounting.unformat($("#alert-" + numb).val(), accounting.settings.number.decimal);
        if (alertVal <= +amountVal) {
            var aqt = alertVal-amountVal;
            alert('Low Stock! ' + accounting.formatNumber(aqt));
        }
    }
    //tax after bill
    if (tax_status == 'yes') {
        if (disFormat == '%' || disFormat == 'flat') {
            //tax
            var Inpercentage = precentCalc(totalPrice, vatVal);
            totalValue = totalPrice + Inpercentage;
            taxo = accounting.formatNumber(Inpercentage);
            if (disFormat == 'flat') {
                disco = accounting.formatNumber(discountVal);
                totalValue = totalValue - discountVal;
            } else if (disFormat == '%') {
                var discount = precentCalc(totalValue, discountVal);
                totalValue = totalValue - discount;
                disco = accounting.formatNumber(discount);
            }
        } else {
//before tax
            if (disFormat == 'bflat') {
                disco = accounting.formatNumber(discountVal);
                totalValue = totalPrice - discountVal;
            } else if (disFormat == 'b_p') {
                var discount = precentCalc(totalPrice, discountVal);
                totalValue = totalPrice - discount;
                disco = accounting.formatNumber(discount);
            }

            //tax
            var Inpercentage = precentCalc(totalValue, vatVal);
            totalValue = totalValue + Inpercentage;
            taxo = accounting.formatNumber(Inpercentage);
        }
    } else if (tax_status == 'inclusive') {
        if (disFormat == '%' || disFormat == 'flat') {
            //tax
            var Inpercentage = (totalPrice * vatVal) / (100 + vatVal);
            totalValue = totalPrice;
            taxo = accounting.formatNumber(Inpercentage);
            if (disFormat == 'flat') {
                disco = accounting.formatNumber(discountVal);
                totalValue = totalValue - discountVal;
            } else if (disFormat == '%') {
                var discount = precentCalc(totalValue, discountVal);
                totalValue = totalValue - discount;
                disco = accounting.formatNumber(discount);
            }
        } else {
//before tax
            if (disFormat == 'bflat') {
                disco = accounting.formatNumber(discountVal);
                totalValue = totalPrice - discountVal;
            } else if (disFormat == 'b_p') {
                var discount = precentCalc(totalPrice, discountVal);
                totalValue = totalPrice - discount;
                disco = accounting.formatNumber(discount);
            }
            //tax
            var Inpercentage = (totalPrice * vatVal) / (100 + vatVal);
            totalValue = totalValue;
            taxo = accounting.formatNumber(Inpercentage);
        }
    } else {
        taxo = 0;
        if (disFormat == '%' || disFormat == 'flat') {
            if (disFormat == 'flat') {
                disco = accounting.formatNumber(discountVal);
                totalValue = totalPrice - discountVal;
            } else if (disFormat == '%') {
                var discount = precentCalc(totalPrice, discountVal);
                totalValue = totalPrice - discount;
                disco = accounting.formatNumber(discount);
            }

        } else {
//before tax
            if (disFormat == 'bflat') {
                disco = accounting.formatNumber(discountVal);
                totalValue = totalPrice - discountVal;
            } else if (disFormat == 'b_p') {
                var discount = precentCalc(totalPrice, discountVal);
                totalValue = totalPrice - discount;
                disco = accounting.formatNumber(discount);
            }
        }
    }
    //alert(Math.ceil(totalValue));
    totalValue = Math.ceil(totalValue);
    $("#result-" + numb).html(accounting.formatNumber(totalValue));
    $("#taxa-" + numb).val(taxo);
    $("#texttaxa-" + numb).text(taxo);
    $("#disca-" + numb).val(disco);
    $("#total-" + numb).val(accounting.formatNumber(totalValue));
    samanYog();
         

        ///rowTotal(0);

        billUpyog();
        serial = $('#serialno').val('');
          }
    


    

                
            }
        });


}


});


$("#product_search").change(function()
{
    var serial = $('#product_search').val();
        
    if($('#product_name-0').val()=='')
    {
    

        $.ajax({
            url: baseurl + 'search_products/' + billtype,
            dataType: "json",
            method: 'post',
            data: 'name_startsWith=' + serial + '&type=product_list&row_num=1&wid=' + $("#s_warehouses option:selected").val() + '&' + d_csrf,
            success: function (data) { 
               console.log(data);

         if(data[0]!=null)
         {
        var t_r = data[3];
         
       
        
        var discount = data[4];
        var custom_discount = $('#custom_discount').val();
        if (custom_discount > 0) discount = deciFormat(custom_discount);
        $('#product_name-0').val(data[0]);
        $('#amount-0').val(1);
        $('#actual_price-0').val(data[12]);
        $('#price-0').val(data[1]);
        $('#pid-0').val(data[2]);
        $('#vat-0').val(t_r);
        $('#discount-0').val(discount);
        $('#dpid-0').val(data[5]);
        $('#unit-0').val(data[6]);
        $('#hsn-0').val(data[7]);
        $('#alert-0').val(data[8]);
        $('#serialNo-0').val(data[10]);
        $('#serial_id-0').val(data[10]);



        rowTotal(0);

        billUpyog();
        serial = $('#product_search').val('');

        $('#cnt').val('1');

         }
     }

        });
}

else
{     

     $.ajax({
            url: baseurl + 'search_products/' + billtype,
            dataType: "json",
            method: 'post',
            data: 'name_startsWith=' + serial + '&type=product_list&row_num=1&wid=' + $("#s_warehouses option:selected").val() + '&' + d_csrf,
            success: function (data) { 
               console.log(data[3]);
        var t_r = data[3];
         
        if(data[0]!=null && $('#product_name-0').val()!='' && $('#cnt').val()==1)
        {
        

       var cvalue = parseInt($('#ganak').val()) + 1;
      
      
    var nxt = parseInt(cvalue);
    $('#ganak').val(nxt);
    var functionNum = "'" + cvalue + "'";
    count = $('#saman-row div').length;
    
    var row = '<tr><td><input type="text" class="form-control" name="product_name[]" placeholder="Enter Product name or Code" id="product_name-' + cvalue + '"></td><td><input type="text" class="form-control req amnt" name="product_qty[]" id="amount-' + cvalue + '" onkeypress="return isNumber(event)" onkeyup="rowTotal(' + functionNum + '), billUpyog()" autocomplete="off" value="1"  inputmode="numeric"><input type="hidden" id="alert-' + cvalue + '" value=""  name="alert[]"> </td><td><input type="text" class="form-control req amnt" name="actual_price[]" id="actual_price-' + cvalue + '" onkeypress="return isNumber(event)" onkeyup="rowTotal(' + functionNum + '), billUpyog()" autocomplete="off" value="1"  inputmode="numeric"></td> <td><input type="text" class="form-control req prc" name="product_price[]" id="price-' + cvalue + '" onkeypress="return isNumber(event)" onkeyup="rowTotal(' + functionNum + '), billUpyog()" autocomplete="off" inputmode="numeric"></td><td> <input type="text" class="form-control vat" value="0" name="product_tax[]" id="vat-' + cvalue + '" onkeypress="return isNumber(event)" onkeyup="rowTotal(' + functionNum + '), billUpyog()" autocomplete="off" inputmode="numeric"></td> <td id="texttaxa-' + cvalue + '" class="text-center">0</td><td><input type="text" class="form-control discount" name="serial_no[]" readonly onkeypress="return isNumber(event)" id="serialNo-' + cvalue + '" onkeyup="rowTotal(' + functionNum + '), billUpyog()" autocomplete="off"></td> <td><input type="text" class="form-control discount" name="product_discount[]" onkeypress="return isNumber(event)" id="discount-' + cvalue + '" onkeyup="rowTotal(' + functionNum + '), billUpyog()" autocomplete="off"></td> <td><span class="currenty">' + currency + '</span> <strong><span class=\'ttlText\' id="result-' + cvalue + '">0</span></strong></td> <td class="text-center"><button type="button" data-rowid="' + cvalue + '" class="btn btn-danger removeProd" title="Remove" > <i class="fa fa-minus-square"></i> </button> </td><input type="hidden" name="taxa[]" id="taxa-' + cvalue + '" value="0"><input type="hidden" name="disca[]" id="disca-' + cvalue + '" value="0"><input type="hidden" class="ttInput" name="product_subtotal[]" id="total-' + cvalue + '" value="0"> <input type="hidden" class="pdIn" name="pid[]" id="pid-' + cvalue + '" value="0"> <input type="hidden" name="unit[]" id="unit-' + cvalue + '" value=""> <input type="hidden" name="hsn[]" id="hsn-' + cvalue + '" value=""> <input type="hidden" name="serial_no[]" id="serial_id-' + cvalue + '" value=""> </tr><tr><td colspan="8"><textarea class="form-control"  id="dpid-' + cvalue + '" name="product_description[]" placeholder="Enter Product description" autocomplete="off"></textarea><br></td></tr>';
     //ajax request
    // $('#saman-row').append(data);
    $('tr.last-item-row').before(row);

           row = cvalue;

        var t_r = data[3];
        var discount = data[4];
        var custom_discount = $('#custom_discount').val();
        if (custom_discount > 0) discount = deciFormat(custom_discount);
        $('#product_name-'+cvalue).val(data[0]);
        $('#amount-'+cvalue).val(1);
        $('#actual_price-'+cvalue).val(data[12]);
        $('#price-'+cvalue).val(data[1]);
        $('#pid-'+cvalue).val(data[2]);
        $('#vat-'+cvalue).val(t_r);
        $('#discount-'+cvalue).val(discount);
        $('#dpid-'+cvalue).val(data[5]);
        $('#unit-'+cvalue).val(data[6]);
        $('#hsn-'+cvalue).val(data[7]);
        $('#alert-'+cvalue).val(data[8]);
        $('#serialNo-'+cvalue).val(data[10]);
        $('#serial_id-'+cvalue).val(data[10]);


        
        numb = cvalue;
        var result;
    var page = '';
    var totalValue = 0;
    var amountVal = accounting.unformat($("#price-" + numb).val(), accounting.settings.number.decimal);
    var priceVal = accounting.unformat($("#price-" + numb).val(), accounting.settings.number.decimal);
    var discountVal = accounting.unformat($("#discount-" + numb).val(), accounting.settings.number.decimal);
    var vatVal = accounting.unformat($("#vat-" + numb).val(), accounting.settings.number.decimal);
    var taxo = 0;
    var disco = 0;
    //var totalPrice = amountVal.toFixed(two_fixed) * priceVal;
    var totalPrice = amountVal.toFixed(two_fixed);
    
    var tax_status = $("#taxformat option:selected").val();
    var disFormat = $("#discount_format").val();
    if ($("#inv_page").val() == 'new_i' && formInputGet("#pid", numb) > 0) {
        var alertVal = accounting.unformat($("#alert-" + numb).val(), accounting.settings.number.decimal);
        if (alertVal <= +amountVal) {
            var aqt = alertVal-amountVal;
            alert('Low Stock! ' + accounting.formatNumber(aqt));
        }
    }
    //tax after bill
    if (tax_status == 'yes') {
        if (disFormat == '%' || disFormat == 'flat') {
            //tax
            var Inpercentage = precentCalc(totalPrice, vatVal);

            totalValue = totalPrice + Inpercentage;
            taxo = accounting.formatNumber(Inpercentage);
            if (disFormat == 'flat') {
                disco = accounting.formatNumber(discountVal);
                totalValue = totalValue - discountVal;
            } else if (disFormat == '%') {
                var discount = precentCalc(totalValue, discountVal);
                totalValue = totalValue - discount;
                disco = accounting.formatNumber(discount);
            }
        } else {
//before tax
            
            if (disFormat == 'bflat') {
                disco = accounting.formatNumber(discountVal);
                totalValue = totalPrice - discountVal;
                
            } else if (disFormat == 'b_p') {
                var discount = precentCalc(totalPrice, discountVal);
                totalValue = totalPrice - discount;
                disco = accounting.formatNumber(discount);
            }

            //tax

            var Inpercentage = precentCalc(totalValue, vatVal);
            totalValue = totalValue + Inpercentage;
            taxo = accounting.formatNumber(Inpercentage);
            
        }
    } else if (tax_status == 'inclusive') {
        if (disFormat == '%' || disFormat == 'flat') {
            //tax
            var Inpercentage = (totalPrice * vatVal) / (100 + vatVal);
            totalValue = totalPrice;
            taxo = accounting.formatNumber(Inpercentage);
            if (disFormat == 'flat') {
                disco = accounting.formatNumber(discountVal);
                totalValue = totalValue - discountVal;
            } else if (disFormat == '%') {
                var discount = precentCalc(totalValue, discountVal);
                totalValue = totalValue - discount;
                disco = accounting.formatNumber(discount);
            }
        } else {
//before tax
            if (disFormat == 'bflat') {
                disco = accounting.formatNumber(discountVal);
                totalValue = totalPrice - discountVal;
            } else if (disFormat == 'b_p') {
                var discount = precentCalc(totalPrice, discountVal);
                totalValue = totalPrice - discount;
                disco = accounting.formatNumber(discount);
            }
            //tax
            var Inpercentage = (totalPrice * vatVal) / (100 + vatVal);
            totalValue = totalValue;
            taxo = accounting.formatNumber(Inpercentage);
        }
    } else {
        taxo = 0;
        if (disFormat == '%' || disFormat == 'flat') {
            if (disFormat == 'flat') {
                disco = accounting.formatNumber(discountVal);
                totalValue = totalPrice - discountVal;
            } else if (disFormat == '%') {
                var discount = precentCalc(totalPrice, discountVal);
                totalValue = totalPrice - discount;
                disco = accounting.formatNumber(discount);
            }

        } else {
//before tax
            if (disFormat == 'bflat') {
                disco = accounting.formatNumber(discountVal);
                totalValue = totalPrice - discountVal;
            } else if (disFormat == 'b_p') {
                var discount = precentCalc(totalPrice, discountVal);
                totalValue = totalPrice - discount;
                disco = accounting.formatNumber(discount);
            }
        }
    }
    //alert(Math.ceil(totalValue));
    totalValue = Math.ceil(totalValue);
    $("#result-" + numb).html(accounting.formatNumber(totalValue));
    $("#taxa-" + numb).val(taxo);
    $("#texttaxa-" + numb).text(taxo);
    $("#disca-" + numb).val(disco);
    $("#total-" + numb).val(accounting.formatNumber(totalValue));
    samanYog();
         

        ///rowTotal(0);

        billUpyog();
        serial = $('#product_search').val('');
          } 
            }
        });
}
});

$("#zobox_sales_serialno").change(function()
{
    var serial = $('#zobox_sales_serialno').val();
        
    if($('#product_name-0').val()=='')
    {
    

        $.ajax({
            url: baseurl + 'search_products/' + billtype,
            dataType: "json",
            method: 'post',
            data: 'name_startsWith=' + serial + '&type=product_list&row_num=1&wid=' + $("#s_warehouses option:selected").val() + '&' + d_csrf,
            success: function (data) { 
               console.log(data);

         if(data[0]!=null)
         {
        var t_r = data[3];
         
       
        
        var discount = data[4];
        var custom_discount = $('#custom_discount').val();
        if (custom_discount > 0) discount = deciFormat(custom_discount);
        $('#product_name-0').val(data[0]);
        $('#amount-0').val(1);
        $('#actual_price-0').val(data[12]);
        $('#price-0').val(data[1]);
        $('#pid-0').val(data[2]);
        $('#vat-0').val(t_r);
        $('#discount-0').val(discount);
        $('#dpid-0').val(data[5]);
        $('#unit-0').val(data[6]);
        $('#hsn-0').val(data[7]);
        $('#alert-0').val(data[8]);
        $('#serialNo-0').val(data[10]);
        $('#serial_id-0').val(data[10]);



        rowTotal(0);

        billUpyog();
        serial = $('#serialno').val('');

        $('#cnt').val('1');

         }
     }

        });
}

else
{     

     $.ajax({
            url: baseurl + 'search_products/' + billtype,
            dataType: "json",
            method: 'post',
            data: 'name_startsWith=' + serial + '&type=product_list&row_num=1&wid=' + $("#s_warehouses option:selected").val() + '&' + d_csrf,
            success: function (data) { 
               console.log(data[3]);
        var t_r = data[3];
         
        if(data[0]!=null && $('#product_name-0').val()!='' && $('#cnt').val()==1)
        {
        

       var cvalue = parseInt($('#ganak').val()) + 1;
      
      
    var nxt = parseInt(cvalue);
    $('#ganak').val(nxt);
    var functionNum = "'" + cvalue + "'";
    count = $('#saman-row div').length;
    
    var row = '<tr><td><input type="text" class="form-control" name="product_name[]" placeholder="Enter Product name or Code" id="product_name-' + cvalue + '"></td><td><input type="text" class="form-control req amnt" name="product_qty[]" id="amount-' + cvalue + '" onkeypress="return isNumber(event)" onkeyup="rowTotal(' + functionNum + '), billUpyog()" autocomplete="off" value="1"  inputmode="numeric"><input type="hidden" id="alert-' + cvalue + '" value=""  name="alert[]"> </td><td><input type="text" class="form-control req amnt" name="actual_price[]" id="actual_price-' + cvalue + '" onkeypress="return isNumber(event)" onkeyup="rowTotal(' + functionNum + '), billUpyog()" autocomplete="off" value="1"  inputmode="numeric"></td> <td><input type="text" class="form-control req prc" name="product_price[]" id="price-' + cvalue + '" onkeypress="return isNumber(event)" onkeyup="rowTotal(' + functionNum + '), billUpyog()" autocomplete="off" inputmode="numeric"></td><td> <input type="text" class="form-control vat" value="0" name="product_tax[]" id="vat-' + cvalue + '" onkeypress="return isNumber(event)" onkeyup="rowTotal(' + functionNum + '), billUpyog()" autocomplete="off" inputmode="numeric"></td> <td id="texttaxa-' + cvalue + '" class="text-center">0</td><td><input type="text" class="form-control discount" name="serial_no[]" readonly onkeypress="return isNumber(event)" id="serialNo-' + cvalue + '" onkeyup="rowTotal(' + functionNum + '), billUpyog()" autocomplete="off"></td> <td><input type="text" class="form-control discount" name="product_discount[]" onkeypress="return isNumber(event)" id="discount-' + cvalue + '" onkeyup="rowTotal(' + functionNum + '), billUpyog()" autocomplete="off"></td> <td><span class="currenty">' + currency + '</span> <strong><span class=\'ttlText\' id="result-' + cvalue + '">0</span></strong></td> <td class="text-center"><button type="button" data-rowid="' + cvalue + '" class="btn btn-danger removeProd" title="Remove" > <i class="fa fa-minus-square"></i> </button> </td><input type="hidden" name="taxa[]" id="taxa-' + cvalue + '" value="0"><input type="hidden" name="disca[]" id="disca-' + cvalue + '" value="0"><input type="hidden" class="ttInput" name="product_subtotal[]" id="total-' + cvalue + '" value="0"> <input type="hidden" class="pdIn" name="pid[]" id="pid-' + cvalue + '" value="0"> <input type="hidden" name="unit[]" id="unit-' + cvalue + '" value=""> <input type="hidden" name="hsn[]" id="hsn-' + cvalue + '" value=""> <input type="hidden" name="serial_no[]" id="serial_id-' + cvalue + '" value=""> </tr><tr><td colspan="8"><textarea class="form-control"  id="dpid-' + cvalue + '" name="product_description[]" placeholder="Enter Product description" autocomplete="off"></textarea><br></td></tr>';
     //ajax request
    // $('#saman-row').append(data);
    $('tr.last-item-row').before(row);

           row = cvalue;

        var t_r = data[3];
        var discount = data[4];
        var custom_discount = $('#custom_discount').val();
        if (custom_discount > 0) discount = deciFormat(custom_discount);
        $('#product_name-'+cvalue).val(data[0]);
        $('#amount-'+cvalue).val(1);
        $('#actual_price-'+cvalue).val(data[12]);
        $('#price-'+cvalue).val(data[1]);
        $('#pid-'+cvalue).val(data[2]);
        $('#vat-'+cvalue).val(t_r);
        $('#discount-'+cvalue).val(discount);
        $('#dpid-'+cvalue).val(data[5]);
        $('#unit-'+cvalue).val(data[6]);
        $('#hsn-'+cvalue).val(data[7]);
        $('#alert-'+cvalue).val(data[8]);
        $('#serialNo-'+cvalue).val(data[10]);
        $('#serial_id-'+cvalue).val(data[10]);


        
        numb = cvalue;
        var result;
    var page = '';
    var totalValue = 0;
    var amountVal = accounting.unformat($("#price-" + numb).val(), accounting.settings.number.decimal);
    var priceVal = accounting.unformat($("#price-" + numb).val(), accounting.settings.number.decimal);
    var discountVal = accounting.unformat($("#discount-" + numb).val(), accounting.settings.number.decimal);
    var vatVal = accounting.unformat($("#vat-" + numb).val(), accounting.settings.number.decimal);
    var taxo = 0;
    var disco = 0;
    //var totalPrice = amountVal.toFixed(two_fixed) * priceVal;
    var totalPrice = amountVal.toFixed(two_fixed);
    
    var tax_status = $("#taxformat option:selected").val();
    var disFormat = $("#discount_format").val();
    if ($("#inv_page").val() == 'new_i' && formInputGet("#pid", numb) > 0) {
        var alertVal = accounting.unformat($("#alert-" + numb).val(), accounting.settings.number.decimal);
        if (alertVal <= +amountVal) {
            var aqt = alertVal-amountVal;
            alert('Low Stock! ' + accounting.formatNumber(aqt));
        }
    }
    //tax after bill
    if (tax_status == 'yes') {
        if (disFormat == '%' || disFormat == 'flat') {
            //tax
            var Inpercentage = precentCalc(totalPrice, vatVal);

            totalValue = totalPrice + Inpercentage;
            taxo = accounting.formatNumber(Inpercentage);
            if (disFormat == 'flat') {
                disco = accounting.formatNumber(discountVal);
                totalValue = totalValue - discountVal;
            } else if (disFormat == '%') {
                var discount = precentCalc(totalValue, discountVal);
                totalValue = totalValue - discount;
                disco = accounting.formatNumber(discount);
            }
        } else {
//before tax
            
            if (disFormat == 'bflat') {
                disco = accounting.formatNumber(discountVal);
                totalValue = totalPrice - discountVal;
                
            } else if (disFormat == 'b_p') {
                var discount = precentCalc(totalPrice, discountVal);
                totalValue = totalPrice - discount;
                disco = accounting.formatNumber(discount);
            }

            //tax

            var Inpercentage = precentCalc(totalValue, vatVal);
            totalValue = totalValue + Inpercentage;
            taxo = accounting.formatNumber(Inpercentage);
            
        }
    } else if (tax_status == 'inclusive') {
        if (disFormat == '%' || disFormat == 'flat') {
            //tax
            var Inpercentage = (totalPrice * vatVal) / (100 + vatVal);
            totalValue = totalPrice;
            taxo = accounting.formatNumber(Inpercentage);
            if (disFormat == 'flat') {
                disco = accounting.formatNumber(discountVal);
                totalValue = totalValue - discountVal;
            } else if (disFormat == '%') {
                var discount = precentCalc(totalValue, discountVal);
                totalValue = totalValue - discount;
                disco = accounting.formatNumber(discount);
            }
        } else {
//before tax
            if (disFormat == 'bflat') {
                disco = accounting.formatNumber(discountVal);
                totalValue = totalPrice - discountVal;
            } else if (disFormat == 'b_p') {
                var discount = precentCalc(totalPrice, discountVal);
                totalValue = totalPrice - discount;
                disco = accounting.formatNumber(discount);
            }
            //tax
            var Inpercentage = (totalPrice * vatVal) / (100 + vatVal);
            totalValue = totalValue;
            taxo = accounting.formatNumber(Inpercentage);
        }
    } else {
        taxo = 0;
        if (disFormat == '%' || disFormat == 'flat') {
            if (disFormat == 'flat') {
                disco = accounting.formatNumber(discountVal);
                totalValue = totalPrice - discountVal;
            } else if (disFormat == '%') {
                var discount = precentCalc(totalPrice, discountVal);
                totalValue = totalPrice - discount;
                disco = accounting.formatNumber(discount);
            }

        } else {
//before tax
            if (disFormat == 'bflat') {
                disco = accounting.formatNumber(discountVal);
                totalValue = totalPrice - discountVal;
            } else if (disFormat == 'b_p') {
                var discount = precentCalc(totalPrice, discountVal);
                totalValue = totalPrice - discount;
                disco = accounting.formatNumber(discount);
            }
        }
    }
    //alert(Math.ceil(totalValue));
    totalValue = Math.ceil(totalValue);
    $("#result-" + numb).html(accounting.formatNumber(totalValue));
    $("#taxa-" + numb).val(taxo);
    $("#texttaxa-" + numb).text(taxo);
    $("#disca-" + numb).val(disco);
    $("#total-" + numb).val(accounting.formatNumber(totalValue));
    samanYog();
         

        ///rowTotal(0);

        billUpyog();
        serial = $('#zobox_sales_serialno').val('');
          }
    


    

                
            }
        });


}


});
/*
$(document).on('click', ".select_pos_item", function (e) {
    var pid = $(this).attr('data-pid');
    var stock = accounting.unformat($(this).attr('data-stock'), accounting.settings.number.decimal);
    //alert(stock);
    var flag = true;
    var discount = $(this).attr('data-discount');
    var marginal_gst = $(this).attr('data-margin_gst_price');
    var marginal_product_type = $(this).attr('data-product_type');
    var data_imei_no = $(this).attr('data-imei_no');
    //var mobile_serial = $(this).attr('data-serial');
    var custom_discount= accounting.unformat($('#custom_discount').val(), accounting.settings.number.decimal);
     if (custom_discount > 0) discount = accounting.formatNumber(custom_discount);
      var data_name = $(this).attr('data-name');
      var data_pcode = $(this).attr('data-pcode');
      var data_stock = $(this).attr('data-stock');
      var data_price = $(this).attr('data-price');
      var data_pid = $(this).attr('data-pid');
      var data_unit = $(this).attr('data-unit');
         /*
        }
       $('.pdIn').each(function () {
        if (pid == $(this).val()) {
            var pi = $(this).attr('id');
            var arr = pi.split('-');
            pi = arr[1];
            $('#discount-' + pi).val(discount);
            var stotal = accounting.unformat($('#amount-' + pi).val(), accounting.settings.number.decimal) + 1;
            if (stotal <= stock) {
                $('#amount-' + pi).val(accounting.formatNumber(stotal));
                $('#search_bar').val('').focus();
            } else {
                $('#stock_alert').modal('toggle');
            }
            rowTotal(pi);
            billUpyog();
            $('#amount-' + pi).focus();
            flag = false;
        }
    });
    */
    /*
    var t_r = $(this).attr('data-tax');
    if ($("#taxformat option:selected").attr('data-trate')) {
        var t_r = $("#taxformat option:selected").attr('data-trate');
    }
    if (flag) {
        var ganak = $('#ganak').val();
        var cvalue = parseInt(ganak);
        var functionNum = "'" + cvalue + "'";
        var mobile_serial;
       $.ajax({
            url: baseurl + 'pos_invoices/getSerialPos',
            //dataType: "json",
            method: 'post',
            data: 'pid=' + pid + '&type=pos&row_num=' + cvalue + '&wid=' + $("#s_warehouses").val() + '&' + d_csrf,
            success: function (data) {
                //console.log(data);
                    count = $('#saman-row div').length;
                    var str = data.split(',');
                    $('#imei_no-' + str[1]).val(str[0]);
                    $('#imei2-' + str[1]).val(str[0]);
        if(str[0]=='')
         {
            $('#stock_alert').modal('toggle');
             return false;
         }
         var data = '<tr id="ppid-' + cvalue + '" class="mb-1"><td colspan="7" ><input type="hidden" name="imei2[]" id="imei2-' + cvalue + '" value="'+ str[0] +'"><input type="text" class="form-control text-center p-mobile" name="product_name[]" placeholder="Enter Product name or Code" id="productname-' + cvalue + '" value="' + data_name + '-' + data_pcode + '"><input type="hidden" id="alert-' + cvalue + '" value="' + data_stock + '"  name="alert[]"></td></tr><tr><td><input type="text" inputmode="numeric" class="form-control p-mobile p-width req amnt" name="product_qty[]" readonly id="amount-' + cvalue + '" onkeypress="return isNumber(event)" onkeyup="rowTotal(' + functionNum + '), billUpyog()" autocomplete="off" value="1" ></td> <td><input type="text" class="form-control p-width p-mobile req prc" readonly name="product_price[]"  inputmode="numeric" id="price-' + cvalue + '" onkeypress="return isNumber(event)" onkeyup="rowTotal(' + functionNum + '), billUpyog()" autocomplete="off"  value="' + data_price + '"></td><td> <input type="text" class="form-control p-mobile p-width vat" inputmode="numeric" name="product_tax[]" readonly id="vat-' + cvalue + '" onkeypress="return isNumber(event)" onkeyup="rowTotal(' + functionNum + '), billUpyog()" autocomplete="off"  value="' + t_r + '"></td>  <td><input type="text" class="form-control p-width p-mobile discount pos_w" name="product_discount[]" readonly inputmode="numeric" onkeypress="return isNumber(event)" id="discount-' + cvalue + '" onkeyup="rowTotal(' + functionNum + '), billUpyog()" autocomplete="off"  value="' + discount + '" inputmode="numeric"></td> <td><span class="currenty">' + currency + '</span> <strong><span class=\'ttlText\' id="result-' + cvalue + '">0</span></strong></td><td><input type="text" name="imei[]" id="imei_no-' + cvalue + '" class="form-control p-width p-mobile req prc" value="'+str[0]+'" readonly></td> <td class="text-center"><button type="button" data-rowid="' + cvalue + '" class="btn btn-danger removeItem" title="Remove" > <i class="fa fa-minus-square"></i> </button> </td><input type="hidden"  name="marginal_gst_price[]" id="marginal_gst_price' + cvalue + '" value="' + marginal_gst + '"><input type="hidden" id="marginal_product_type' + cvalue + '" value="'+ marginal_product_type + '" name="marginal_product_type[]"><input type="hidden" name="taxa[]" id="taxa-' + cvalue + '" value="0"><input type="hidden" name="disca[]" id="disca-' + cvalue + '" value="0"><input type="hidden" class="ttInput" name="product_subtotal[]" id="total-' + cvalue + '" value="0"> <input type="hidden" class="pdIn" name="pid[]" id="pid-' + cvalue + '" value="' + data_pid + '"> <input type="hidden" name="unit[]" id="unit-' + cvalue + '" value="' + data_unit + '"> <input type="hidden" name="hsn[]" id="hsn-' + cvalue + '" value="' + data_pcode + '"> <input type="hidden" name="serial[]" id="serial-' + cvalue + '" value="' + str[0] + '"></tr>';
         $('#saman-row').append(data);
        $('#pos_items').append(data);
        rowTotal(cvalue);
        billUpyog();
        $('#ganak').val(cvalue + 1);
        $('#amount-' + cvalue).focus();
            }
        });
        //ajax request
    }
});
*/

$(document).on('click', ".select_pos_item", function (e) {
    var pid = $(this).attr('data-pid');
    var stock = accounting.unformat($(this).attr('data-stock'), accounting.settings.number.decimal);
    //alert(stock);
    var flag = true;
    var discount = $(this).attr('data-discount');
    var marginal_gst = $(this).attr('data-margin_gst_price');
    var marginal_product_type = $(this).attr('data-product_type');
    var data_imei_no = $(this).attr('data-imei_no');
    
    var total_price = $(this).attr("data-price_with_margin");
    //var mobile_serial = $(this).attr('data-serial');
    var custom_discount= accounting.unformat($('#custom_discount').val(), accounting.settings.number.decimal);
     if (custom_discount > 0) discount = accounting.formatNumber(custom_discount);
      var data_name = $(this).attr('data-name');
      var data_pcode = $(this).attr('data-pcode');
      var data_stock = $(this).attr('data-stock');
      var data_price = $(this).attr('data-price');

      var data_pid = $(this).attr('data-pid');
      var data_unit = $(this).attr('data-unit');
         /*
        }
       $('.pdIn').each(function () {
        if (pid == $(this).val()) {
            var pi = $(this).attr('id');
            var arr = pi.split('-');
            pi = arr[1];
            $('#discount-' + pi).val(discount);
            var stotal = accounting.unformat($('#amount-' + pi).val(), accounting.settings.number.decimal) + 1;
            if (stotal <= stock) {
                $('#amount-' + pi).val(accounting.formatNumber(stotal));
                $('#search_bar').val('').focus();
            } else {
                $('#stock_alert').modal('toggle');
            }
            rowTotal(pi);
            billUpyog();
            $('#amount-' + pi).focus();
            flag = false;
        }
    });
    */
    var t_r = $(this).attr('data-tax');
    if ($("#taxformat option:selected").attr('data-trate')) {
        var t_r = $("#taxformat option:selected").attr('data-trate');
    }
    if (flag) {
        var ganak = $('#ganak').val();
        var cvalue = parseInt(ganak);
        var functionNum = "'" + cvalue + "'";
        var mobile_serial;
       $.ajax({
            url: baseurl + 'pos_invoices/getSerialPos',
            //dataType: "json",
            method: 'post',
            data: 'pid=' + pid + '&type=pos&row_num=' + cvalue + '&wid=' + $("#s_warehouses").val() + '&' + d_csrf,
            success: function (data) {
                //console.log(data);
                    count = $('#saman-row div').length;
                    var str = data.split(',');
                    $('#imei_no-' + str[1]).val(str[0]);
                    $('#imei2-' + str[1]).val(str[0]);
        if(str[0]=='')
         {
            $('#stock_alert').modal('toggle');
             return false;
         }
         var data = '<tr id="ppid-' + cvalue + '" class="mb-1"><td colspan="7" ><input type="hidden" name="imei2[]" id="imei2-' + cvalue + '" value="'+ str[0] +'"><input type="text" class="form-control text-center p-mobile" name="product_name[]" placeholder="Enter Product name or Code" id="productname-' + cvalue + '" value="' + data_name + '-' + data_pcode + '"><input type="hidden" id="alert-' + cvalue + '" value="' + data_stock + '"  name="alert[]"></td></tr><tr><td><input type="text" inputmode="numeric" class="form-control p-mobile p-width req amnt" name="product_qty[]" readonly id="amount-' + cvalue + '" onkeypress="return isNumber(event)" onkeyup="rowTotal(' + functionNum + '), billUpyog()" autocomplete="off" value="1" ></td> <td><input type="text" class="form-control p-width p-mobile req prc" readonly name="product_price[]"  inputmode="numeric" id="ttl_price-' + cvalue + '" onkeypress="return isNumber(event)" onkeyup="rowTotal(' + functionNum + '), billUpyog()" autocomplete="off"  value="' + total_price + '"><input type="hidden" class="form-control p-width p-mobile req prc" readonly name="product_price[]"  inputmode="numeric" id="price-' + cvalue + '" onkeypress="return isNumber(event)" onkeyup="rowTotal(' + functionNum + '), billUpyog()" autocomplete="off"  value="' + data_price + '"></td><td> <input type="text" class="form-control p-mobile p-width vat" inputmode="numeric" name="product_tax[]" readonly id="vat-' + cvalue + '" onkeypress="return isNumber(event)" onkeyup="rowTotal(' + functionNum + '), billUpyog()" autocomplete="off"  value="' + t_r + '"></td>  <td><input type="text" class="form-control p-width p-mobile discount pos_w" name="product_discount[]" readonly inputmode="numeric" onkeypress="return isNumber(event)" id="discount-' + cvalue + '" onkeyup="rowTotal(' + functionNum + '), billUpyog()" autocomplete="off"  value="' + discount + '" inputmode="numeric"></td> <td><span class="currenty">' + currency + '</span> <strong><span class=\'ttlText\' id="result-' + cvalue + '">0</span></strong></td><td><input type="text" name="imei[]" id="imei_no-' + cvalue + '" class="form-control p-width p-mobile req prc" value="'+str[0]+'" readonly></td> <td class="text-center"><button type="button" data-rowid="' + cvalue + '" class="btn btn-danger removeItem" title="Remove" > <i class="fa fa-minus-square"></i> </button> </td><input type="hidden"  name="marginal_gst_price[]" id="marginal_gst_price' + cvalue + '" value="' + marginal_gst + '"><input type="hidden" id="marginal_product_type' + cvalue + '" value="'+ marginal_product_type + '" name="marginal_product_type[]"><input type="hidden" name="taxa[]" id="taxa-' + cvalue + '" value="0"><input type="hidden" name="disca[]" id="disca-' + cvalue + '" value="0"><input type="hidden" class="ttInput" name="product_subtotal[]" id="total-' + cvalue + '" value="0"> <input type="hidden" class="pdIn" name="pid[]" id="pid-' + cvalue + '" value="' + data_pid + '"> <input type="hidden" name="unit[]" id="unit-' + cvalue + '" value="' + data_unit + '"> <input type="hidden" name="hsn[]" id="hsn-' + cvalue + '" value="' + data_pcode + '"> <input type="hidden" name="serial[]" id="serial-' + cvalue + '" value="' + str[0] + '"></tr>';
         $('#saman-row').append(data);
        $('#pos_items').append(data);
        rowTotal(cvalue);
        billUpyog();
        $('#ganak').val(cvalue + 1);
        $('#amount-' + cvalue).focus();
            }
        });
        //ajax request
    }
});


$(document).on('click', ".v2_select_pos_item", function (e) {   
    var pid = $(this).attr('data-pid');
    var stock =  accounting.unformat($(this).attr('data-stock'), accounting.settings.number.decimal);

    var discount = $(this).attr('data-discount');
    var custom_discount = accounting.unformat($('#custom_discount').val(), accounting.settings.number.decimal);
    if (custom_discount > 0) discount = accounting.formatNumber(custom_discount);
    var flag = true;
    $('#v2_search_bar').val('');
    $('.pdIn').each(function () {

        if (pid == $(this).val()) {

            var pi = $(this).attr('id');
            var arr = pi.split('-');
            pi = arr[1];
            $('#discount-' + pi).val(discount);
            var stotal = accounting.unformat($('#amount-' + pi).val(), accounting.settings.number.decimal) + 1;

            if (stotal <= stock) {
                $('#amount-' + pi).val(accounting.formatNumber(stotal));
                $('#search_bar').val('').focus();
            } else {
                $('#stock_alert').modal('toggle');
            }
            rowTotal(pi);
            billUpyog();

            flag = false;
        }
    });
    var t_r = $(this).attr('data-tax');
    if ($("#taxformat option:selected").attr('data-trate')) {

        var t_r = $("#taxformat option:selected").attr('data-trate');
    }
    var sound = document.getElementById("beep");
    sound.play();
    if (flag) {
        var ganak = $('#ganak').val();
        var cvalue = parseInt(ganak);
        var functionNum = "'" + cvalue + "'";
        count = $('#saman-row div').length;
        //var data = ' <div class="row  m-0 pt-1 pb-1 border-bottom"  id="ppid-' + cvalue + '"> <div class="col-6 "> <span class="quantity"><input type="text" class="form-control req amnt display-inline mousetrap" name="product_qty[]" inputmode="numeric" id="amount-' + cvalue + '" onkeypress="return isNumber(event)" onkeyup="rowTotal(' + functionNum + '), billUpyog()" autocomplete="off" value="1" ><div class="quantity-nav"><div class="quantity-button quantity-up">+</div><div class="quantity-button quantity-down">-</div></div></span>' + $(this).attr('data-name') + '-' + $(this).attr('data-pcode') + '</div> <div class="col-3"> ' + $(this).attr('data-price') + ' </div> <div class="col-3"><strong><span class="ttlText" id="result-' + cvalue + '">0</span></strong><a data-rowid="' + cvalue + '" class="red removeItem" title="Remove"> <i class="fa fa-trash"></i> </a></div><input type="hidden" class="form-control text-center" name="product_name[]" id="productname-' + cvalue + '" value="' + $(this).attr('data-name') + '-' + $(this).attr('data-pcode') + '"><input type="hidden" id="alert-' + cvalue + '" value="' + $(this).attr('data-stock') + '"  name="alert[]"><input type="hidden" class="form-control req prc" name="product_price[]" id="price-' + cvalue + '" onkeypress="return isNumber(event)" onkeyup="rowTotal(' + functionNum + '), billUpyog()" autocomplete="off"  value="' + $(this).attr('data-price') + '" inputmode="numeric"> <input type="hidden" class="form-control vat" name="product_tax[]" id="vat-' + cvalue + '" onkeypress="return isNumber(event)" onkeyup="rowTotal(' + functionNum + '), billUpyog()" autocomplete="off"  value="' + t_r + '"><input type="hidden" class="form-control discount pos_w" name="product_discount[]" onkeypress="return isNumber(event)" id="discount-' + cvalue + '" onkeyup="rowTotal(' + functionNum + '), billUpyog()" autocomplete="off"  value="' + discount + '"><input type="hidden" name="taxa[]" id="taxa-' + cvalue + '" value="0"><input type="hidden" name="disca[]" id="disca-' + cvalue + '" value="0"><input type="hidden" class="ttInput" name="product_subtotal[]" id="total-' + cvalue + '" value="0"> <input type="hidden" class="pdIn" name="pid[]" id="pid-' + cvalue + '" value="' + $(this).attr('data-pid') + '"> <input type="hidden" name="unit[]" id="unit-' + cvalue + '" value="' + $(this).attr('data-unit') + '"><input type="hidden" name="hsn[]" id="hsn-' + cvalue + '" value="' + $(this).attr('data-pcode') + '"> <input type="hidden" name="serial[]" id="serial-' + cvalue + '" value="' + $(this).attr('data-serial') + '"></div>';
        //ajax request
        // $('#saman-row').append(data);
        $('#pos_items').append(data);
        rowTotal(cvalue);
        billUpyog();
        $('#ganak').val(cvalue + 1);
        $('#amount-' + cvalue).focus();
    }
});

$('#saman-pos2').on('click', '.removeItem', function () {
    var pidd = $(this).attr('data-rowid');
    var pqty = accounting.unformat($('#amount-' + pidd).val(), accounting.settings.number.decimal);
    var old_amnt = $('#amount_old-' + pidd).val();
    if (old_amnt) {
        pqty = pidd + '-' + pqty;
        $('<input>').attr({
            type: 'hidden',
            name: 'restock[]',
            value: pqty
        }).appendTo('form');
    }
    $('#ppid-' + pidd).remove();
    $('.amnt').each(function (index) {
        rowTotal(index);
    });
    billUpyog();
    return false;
});


$('#saman-row-pos').on('click', '.removeItem', function () {

    var pidd = $(this).closest('tr').find('.pdIn').val();
    var pqty = accounting.unformat($(this).closest('tr').find('.amnt').val(), accounting.settings.number.decimal);
    var old_amnt = accounting.unformat($(this).closest('tr').find('.old_amnt').val(), accounting.settings.number.decimal);
    if (old_amnt) {
        pqty = pidd + '-' + pqty;
        $('<input>').attr({
            type: 'hidden',
            name: 'restock[]',
            value: pqty
        }).appendTo('form');
    }
    $(this).closest('tr').remove();
    $('#d' + $(this).closest('tr').find('.pdIn').attr('id')).closest('tr').remove();
    $('#p' + $(this).closest('tr').find('.pdIn').attr('id')).remove();
    $('.amnt').each(function (index) {
        rowTotal(index);

    });
    billUpyog();

    return false;

});


$(document).on('click', ".quantity-up", function (e) {
    var spinner = $(this);
    var input = spinner.closest('.quantity').find('input[name="product_qty[]"]');
    var oldValue = accounting.unformat(input.val(), accounting.settings.number.decimal);

    var newVal = oldValue + 1;
    spinner.closest('.quantity').find('input[name="product_qty[]"]').val(accounting.formatNumber(newVal));
    spinner.closest('.quantity').find('input[name="product_qty[]"]').trigger("change");
    var id_arr = $(input).attr('id');
    id = id_arr.split("-");
    rowTotal(id[1]);
    billUpyog();
    return false;
});

$(document).on('click', ".quantity-down", function (e) {
    var spinner = $(this);
    var input = spinner.closest('.quantity').find('input[name="product_qty[]"]');
    var oldValue = accounting.unformat(input.val(), accounting.settings.number.decimal);
    var min = 1;
    if (oldValue <= min) {
        var newVal = oldValue;
    } else {
        var newVal = oldValue - 1;
    }
    spinner.closest('.quantity').find('input[name="product_qty[]"]').val(accounting.formatNumber(newVal));
    spinner.closest('.quantity').find('input[name="product_qty[]"]').trigger("change");
    var id_arr = $(input).attr('id');
    id = id_arr.split("-");
    rowTotal(id[1]);
    billUpyog();
    return false;
});



$('#invoice2_search').autocomplete({

    source: function (request, response) {
    
        $.ajax({
            url: baseurl + 'search_products/' + billtype,
            dataType: "json",
            method: 'post',
            data: 'name_startsWith=' + request.term + '&type=product_list&row_num=1&wid=' + $("#s_warehouses option:selected").val() + '&' + d_csrf,
            success: function (data) { 
                //console.log(data);      
                response($.map(data, function (item) {
                    var product_d = item[0];
                    return {
                        label: product_d,
                        value: product_d,
                        data: item
                    };
                }));
            }
        });
    },
    autoFocus: true,
    minLength: 0,
    select: function (event, ui) {
        var t_r = ui.item.data[3];
        if ($("#taxformat option:selected").attr('data-trate')) {

            t_r = $("#taxformat option:selected").attr('data-trate');
        }
        var discount = ui.item.data[4];
        var custom_discount = $('#custom_discount').val();
        if (custom_discount > 0) discount = deciFormat(custom_discount);
        $('#amount-0').val(1);
        $('#price-0').val(ui.item.data[1]);
        $('#pid-0').val(ui.item.data[2]);
        $('#vat-0').val(t_r);
        $('#discount-0').val(discount);
        $('#dpid-0').val(ui.item.data[5]);
        $('#unit-0').val(ui.item.data[6]);
        $('#hsn-0').val(ui.item.data[7]);
        $('#alert-0').val(ui.item.data[8]);
        $('#serial-0').val(ui.item.data[10]);
        rowTotal(0);

        billUpyog();


    }
});

$("#serial_nos").change(function()
{
    var serial = $('#serial_nos').val();
    //alert(billtype);
    if($('#b2b-0').val()=='')
    {
        //alert('if');
        $.ajax({
            url: baseurl + 'search_products/search_product_by_serialb2b',
            dataType: "json",
            method: 'post',
            data: 'name_startsWith=' + serial + '&type=product_list&row_num=1&wid=' + $("#s_warehouses").val() + '&' + d_csrf,
            //data: 'name_startsWith=' + serial + '&type=product_list&row_num=1&' + d_csrf,
            success: function (data) { 
               console.log(data);

         if(data[0]!=null)
         {
        var t_r = data[3];         
       
        
        var discount = data[4];
        var custom_discount = $('#custom_discount').val();
        if (custom_discount > 0) discount = deciFormat(custom_discount);
        
        //var purchase_price = ((data[1]*100)/(100+t_r));
        var purchase_price = ((data[1]*100)/((100+parseInt(t_r))));
        
        $('#b2b-0').val(data[0]);
        $('#amount-0').val(1);
        //$('#price-0').val(data[1]);
        $('#price-0').val(purchase_price);
        $('#pid-0').val(data[2]);
        $('#vat-0').val(t_r);
        $('#discount-0').val(discount);
        $('#dpid-0').val(data[5]);
        $('#unit-0').val(data[6]);
        $('#hsn-0').val(data[7]);
        $('#alert-0').val(data[8]);
        $('#serialNo-0').val(data[10]);
        $('#serial_id-0').val(data[10]);



        rowTotal(0);

        billUpyog();
        serial = $('#serialno').val('');

        $('#cnt').val('1');

         }
     }

        });
    }
    else
    {     
    //alert('else');
     $.ajax({
            url: baseurl + 'search_products/search_product_by_serialb2b',
            dataType: "json",
            method: 'post',
            data: 'name_startsWith=' + serial + '&type=product_list&row_num=1&wid=' + $("#s_warehouses").val() + '&' + d_csrf,
            //data: 'name_startsWith=' + serial + '&type=product_list&row_num=1&' + d_csrf,
            success: function (data) { 
               console.log(data);
        var t_r = data[3];
         
        //if(data[0]!=null && $('#productname-0').val()!='' && $('#cnt').val()==1)
        if(data[0]!=null && $('#b2b-0').val()!='')
        {
        

       var cvalue = parseInt($('#ganak').val()) + 1;
      
      
        var nxt = parseInt(cvalue);
        $('#ganak').val(nxt);
        var functionNum = "'" + cvalue + "'";
        count = $('#saman-row div').length;

        //var row = '<tr><td><input type="text" class="form-control" name="product_name[]" placeholder="Enter Product name or Code" id="productname-' + cvalue + '"></td><td><input type="text" class="form-control req amnt" name="product_qty[]" id="amount-' + cvalue + '" onkeypress="return isNumber(event)" onkeyup="rowTotal(' + functionNum + '), billUpyog()" autocomplete="off" value="1"  inputmode="numeric"><input type="hidden" id="alert-' + cvalue + '" value=""  name="alert[]"> </td> <td><input type="text" class="form-control req prc" name="product_price[]" id="price-' + cvalue + '" onkeypress="return isNumber(event)" onkeyup="rowTotal(' + functionNum + '), billUpyog()" autocomplete="off" inputmode="numeric"></td><td> <input type="text" class="form-control vat" value="0" name="product_tax[]" id="vat-' + cvalue + '" onkeypress="return isNumber(event)" onkeyup="rowTotal(' + functionNum + '), billUpyog()" autocomplete="off" inputmode="numeric"></td> <td id="texttaxa-' + cvalue + '" class="text-center">0</td><td><input type="text" class="form-control discount" name="serial_no11[]" readonly onkeypress="return isNumber(event)" id="serialNo-' + cvalue + '" onkeyup="rowTotal(' + functionNum + '), billUpyog()" autocomplete="off"></td> <td><input type="text" class="form-control discount" name="product_discount[]" onkeypress="return isNumber(event)" id="discount-' + cvalue + '" onkeyup="rowTotal(' + functionNum + '), billUpyog()" autocomplete="off"></td> <td><span class="currenty">' + currency + '</span> <strong><span class=\'ttlText\' id="result-' + cvalue + '">0</span></strong></td> <td class="text-center"><button type="button" data-rowid="' + cvalue + '" class="btn btn-danger removeProd" title="Remove" > <i class="fa fa-minus-square"></i> </button> </td><input type="hidden" name="taxa[]" id="taxa-' + cvalue + '" value="0"><input type="hidden" name="disca[]" id="disca-' + cvalue + '" value="0"><input type="hidden" class="ttInput" name="product_subtotal[]" id="total-' + cvalue + '" value="0"> <input type="hidden" class="pdIn" name="pid[]" id="pid-' + cvalue + '" value="0"> <input type="hidden" name="unit[]" id="unit-' + cvalue + '" value=""> <input type="hidden" name="hsn[]" id="hsn-' + cvalue + '" value=""> <input type="hidden" name="serial_no[]" id="serial_id-' + cvalue + '" value=""> </tr><tr><td colspan="8"><textarea class="form-control"  id="dpid-' + cvalue + '" name="product_description[]" placeholder="Enter Product description" autocomplete="off"></textarea><br></td></tr>';
        var row = '<tr><td><input type="text" class="form-control" name="product_name[]" placeholder="Enter Product name or Code" id="b2b-' + cvalue + '"></td><td><input type="text" class="form-control req amnt" name="product_qty[]" id="amount-' + cvalue + '" onkeypress="return isNumber(event)" onkeyup="rowTotal(' + functionNum + '), billUpyog()" autocomplete="off" value="1"  inputmode="numeric"><input type="hidden" id="alert-' + cvalue + '" value=""  name="alert[]"> </td> <td><input type="text" class="form-control req prc" readonly name="product_price[]" id="price-' + cvalue + '" onkeypress="return isNumber(event)" onkeyup="rowTotal(' + functionNum + '), billUpyog()" autocomplete="off" inputmode="numeric"></td><td> <input type="text" class="form-control vat" value="0" name="product_tax[]" readonly id="vat-' + cvalue + '" onkeypress="return isNumber(event)" onkeyup="rowTotal(' + functionNum + '), billUpyog()" autocomplete="off" inputmode="numeric"></td> <td id="texttaxa-' + cvalue + '" class="text-center">0</td> <td><input type="text" class="form-control discount" readonly name="product_discount[]" onkeypress="return isNumber(event)" id="discount-' + cvalue + '" onkeyup="rowTotal(' + functionNum + '), billUpyog()" autocomplete="off"></td> <td><span class="currenty">' + currency + '</span> <strong><span class=\'ttlText\' id="result-' + cvalue + '">0</span></strong></td> <td class="text-center"><button type="button" data-rowid="' + cvalue + '" class="btn btn-danger removeProd" title="Remove" > <i class="fa fa-minus-square"></i> </button> </td><input type="hidden" name="taxa[]" id="taxa-' + cvalue + '" value="0"><input type="hidden" name="disca[]" id="disca-' + cvalue + '" value="0"><input type="hidden" class="ttInput" name="product_subtotal[]" id="total-' + cvalue + '" value="0"> <input type="hidden" class="pdIn" name="pid[]" id="pid-' + cvalue + '" value="0"> <input type="hidden" name="unit[]" id="unit-' + cvalue + '" value=""> <input type="hidden" name="hsn[]" id="hsn-' + cvalue + '" value=""> <input type="hidden" name="serial_no[]" id="serial_id-' + cvalue + '" value=""> </tr><tr><td colspan="8"><textarea class="form-control"  id="dpid-' + cvalue + '" name="product_description[]" placeholder="Enter Product description" autocomplete="off"></textarea><br></td></tr>';
         //ajax request
         //$('#saman-row').append(row);
        $('tr.last-item-row').before(row);

           row = cvalue;

        var t_r = data[3];
        var discount = data[4];
        var custom_discount = $('#custom_discount').val();
        if (custom_discount > 0) discount = deciFormat(custom_discount);
        
        //var purchase_price = ((data[1]*100)/(100+t_r));
        var purchase_price = ((data[1]*100)/((100+parseInt(t_r))));
        
        $('#b2b-'+cvalue).val(data[0]);
        $('#amount-'+cvalue).val(1);
        //$('#price-'+cvalue).val(data[1]);
        $('#price-'+cvalue).val(purchase_price);
        $('#pid-'+cvalue).val(data[2]);
        $('#vat-'+cvalue).val(t_r);
        $('#discount-'+cvalue).val(discount);
        $('#dpid-'+cvalue).val(data[5]);
        $('#unit-'+cvalue).val(data[6]);
        $('#hsn-'+cvalue).val(data[7]);
        $('#alert-'+cvalue).val(data[8]);
        $('#serialNo-'+cvalue).val(data[10]);
        $('#serial_id-'+cvalue).val(data[10]);


        
        numb = cvalue;
        var result;
        var page = '';
        var totalValue = 0;
        var amountVal = accounting.unformat($("#amount-" + numb).val(), accounting.settings.number.decimal);
        var priceVal = accounting.unformat($("#price-" + numb).val(), accounting.settings.number.decimal);
        var discountVal = accounting.unformat($("#discount-" + numb).val(), accounting.settings.number.decimal);
        var vatVal = accounting.unformat($("#vat-" + numb).val(), accounting.settings.number.decimal);
        var taxo = 0;
        var disco = 0;
        var totalPrice = amountVal.toFixed(two_fixed) * priceVal;   
        var tax_status = $("#taxformat option:selected").val();
        var disFormat = $("#discount_format").val();
        if ($("#inv_page").val() == 'new_i' && formInputGet("#pid", numb) > 0) {
            var alertVal = accounting.unformat($("#alert-" + numb).val(), accounting.settings.number.decimal);
            if (alertVal <= +amountVal) {
                var aqt = alertVal-amountVal;
                alert('Low Stock! ' + accounting.formatNumber(aqt));
            }
        }
        //tax after bill
        if (tax_status == 'yes') {
            if (disFormat == '%' || disFormat == 'flat') {
                //tax
                var Inpercentage = precentCalc(totalPrice, vatVal);
                totalValue = totalPrice + Inpercentage;
                taxo = accounting.formatNumber(Inpercentage);
                if (disFormat == 'flat') {
                    disco = accounting.formatNumber(discountVal);
                    totalValue = totalValue - discountVal;
                } else if (disFormat == '%') {
                    var discount = precentCalc(totalValue, discountVal);
                    totalValue = totalValue - discount;
                    disco = accounting.formatNumber(discount);
                }
            } else {
    //before tax
                if (disFormat == 'bflat') {
                    disco = accounting.formatNumber(discountVal);
                    totalValue = totalPrice - discountVal;
                } else if (disFormat == 'b_p') {
                    var discount = precentCalc(totalPrice, discountVal);
                    totalValue = totalPrice - discount;
                    disco = accounting.formatNumber(discount);
                }

                //tax
                var Inpercentage = precentCalc(totalValue, vatVal);
                totalValue = totalValue + Inpercentage;
                taxo = accounting.formatNumber(Inpercentage);
            }
        } else if (tax_status == 'inclusive') {
            if (disFormat == '%' || disFormat == 'flat') {
                //tax
                var Inpercentage = (totalPrice * vatVal) / (100 + vatVal);
                totalValue = totalPrice;
                taxo = accounting.formatNumber(Inpercentage);
                if (disFormat == 'flat') {
                    disco = accounting.formatNumber(discountVal);
                    totalValue = totalValue - discountVal;
                } else if (disFormat == '%') {
                    var discount = precentCalc(totalValue, discountVal);
                    totalValue = totalValue - discount;
                    disco = accounting.formatNumber(discount);
                }
            } else {
    //before tax
                if (disFormat == 'bflat') {
                    disco = accounting.formatNumber(discountVal);
                    totalValue = totalPrice - discountVal;
                } else if (disFormat == 'b_p') {
                    var discount = precentCalc(totalPrice, discountVal);
                    totalValue = totalPrice - discount;
                    disco = accounting.formatNumber(discount);
                }
                //tax
                var Inpercentage = (totalPrice * vatVal) / (100 + vatVal);
                totalValue = totalValue;
                taxo = accounting.formatNumber(Inpercentage);
            }
        } else {
            taxo = 0;
            if (disFormat == '%' || disFormat == 'flat') {
                if (disFormat == 'flat') {
                    disco = accounting.formatNumber(discountVal);
                    totalValue = totalPrice - discountVal;
                } else if (disFormat == '%') {
                    var discount = precentCalc(totalPrice, discountVal);
                    totalValue = totalPrice - discount;
                    disco = accounting.formatNumber(discount);
                }

            } else {
    //before tax
                if (disFormat == 'bflat') {
                    disco = accounting.formatNumber(discountVal);
                    totalValue = totalPrice - discountVal;
                } else if (disFormat == 'b_p') {
                    var discount = precentCalc(totalPrice, discountVal);
                    totalValue = totalPrice - discount;
                    disco = accounting.formatNumber(discount);
                }
            }
        }
        //alert(Math.ceil(totalValue));
        totalValue = Math.ceil(totalValue);
        $("#result-" + numb).html(accounting.formatNumber(totalValue));
        $("#taxa-" + numb).val(taxo);
        $("#texttaxa-" + numb).text(taxo);
        $("#disca-" + numb).val(disco);
        $("#total-" + numb).val(accounting.formatNumber(totalValue));
        samanYog();
         

        ///rowTotal(0);

        billUpyog();
        serial = $('#serialno').val('');
          }                
           
           }
        });


}


});


$('#invoice2_searchb2b').autocomplete({ 
    source: function (request, response) {
    
        $.ajax({            
            url: baseurl + 'search_products/' + billtype,
            dataType: "json",
            method: 'post',
            //data: 'name_startsWith=' + request.term + '&type=product_list&row_num=' + row + '&wid=' + $("#s_warehouses option:selected").val() + '&' + d_csrf,
            data: 'name_startsWith=' + request.term + '&type=product_list&row_num=1&wid=' + $("#s_warehouses option:selected").val() + '&' + d_csrf,
            success: function (data) { 
                console.log(data);              
                response($.map(data, function (item) {
                    var product_d = item[0];
                    return {
                        label: product_d,
                        value: product_d,
                        data: item
                    };
                }));
            }
        });
    },
    autoFocus: true,
    minLength: 0,
    select: function (event, ui) {
        var t_r = ui.item.data[3];
        if ($("#taxformat option:selected").attr('data-trate')) {

            t_r = $("#taxformat option:selected").attr('data-trate');
        }
        var discount = ui.item.data[4];
        var custom_discount = $('#custom_discount').val();
        if (custom_discount > 0) discount = deciFormat(custom_discount);
        
        var purchase_price = ((ui.item.data[1]*100)/((100+parseInt(t_r))));
        
        $('#amount-0').val(1);
        //$('#price-0').val(ui.item.data[1]);
        $('#price-0').val(purchase_price);
        $('#pid-0').val(ui.item.data[2]);
        $('#vat-0').val(t_r);
        $('#discount-0').val(discount);
        $('#dpid-0').val(ui.item.data[5]);
        $('#unit-0').val(ui.item.data[6]);
        $('#hsn-0').val(ui.item.data[7]);
        $('#alert-0').val(ui.item.data[8]);
        $('#serial-0').val(ui.item.data[10]);
        rowTotal(0);

        billUpyog();


    }
});

$('#addproduct_b2b').on('click', function () {
    var cvalue = parseInt($('#ganak').val()) + 1;
    var nxt = parseInt(cvalue);
    $('#ganak').val(nxt);
    var functionNum = "'" + cvalue + "'";
    count = $('#saman-row div').length;

    
    
    var data = '<tr><td><input type="text" class="form-control" name="product_name[]" placeholder="Enter Product name or Code" id="b2b-' + cvalue + '"></td><td><input type="text" class="form-control req amnt" name="product_qty[]" id="amount-' + cvalue + '" onkeypress="return isNumber(event)" onkeyup="rowTotal(' + functionNum + '), billUpyog()" autocomplete="off" value="1"  inputmode="numeric"><input type="hidden" id="alert-' + cvalue + '" value=""  name="alert[]"> </td> <td><input type="text" class="form-control req prc" readonly name="product_price[]" id="price-' + cvalue + '" onkeypress="return isNumber(event)" onkeyup="rowTotal(' + functionNum + '), billUpyog()" autocomplete="off" inputmode="numeric"></td><td> <input type="text" readonly class="form-control vat" value="0" name="product_tax[]" id="vat-' + cvalue + '" onkeypress="return isNumber(event)" onkeyup="rowTotal(' + functionNum + '), billUpyog()" autocomplete="off" inputmode="numeric"></td> <td id="texttaxa-' + cvalue + '" class="text-center">0</td> <td><input type="text" class="form-control discount" readonly name="product_discount[]" onkeypress="return isNumber(event)" id="discount-' + cvalue + '" onkeyup="rowTotal(' + functionNum + '), billUpyog()" autocomplete="off"></td> <td><span class="currenty">' + currency + '</span> <strong><span class=\'ttlText\' id="result-' + cvalue + '">0</span></strong></td> <td class="text-center"><button type="button" data-rowid="' + cvalue + '" class="btn btn-danger removeProd" title="Remove" > <i class="fa fa-minus-square"></i> </button> </td><input type="hidden" name="taxa[]" id="taxa-' + cvalue + '" value="0"><input type="hidden" name="disca[]" id="disca-' + cvalue + '" value="0"><input type="hidden" class="ttInput" name="product_subtotal[]" id="total-' + cvalue + '" value="0"> <input type="hidden" class="pdIn" name="pid[]" id="pid-' + cvalue + '" value="0"> <input type="hidden" name="unit[]" id="unit-' + cvalue + '" value=""> <input type="hidden" name="hsn[]" id="hsn-' + cvalue + '" value=""> <input type="hidden" name="serial[]" id="serial-' + cvalue + '" value=""> </tr><tr><td colspan="8"><textarea class="form-control"  id="dpid-' + cvalue + '" name="product_description[]" placeholder="Enter Product description" autocomplete="off"></textarea><br></td></tr>';
     //ajax request
    // $('#saman-row').append(data);
    $('tr.last-item-row').before(data);

    row = cvalue;

    $('#b2b-' + cvalue).autocomplete({
        source: function (request, response) {
            $.ajax({
                url: baseurl + 'search_products/' + billtype,
                dataType: "json",
                method: 'post',
                data: 'name_startsWith=' + request.term + '&type=product_list&row_num=' + row + '&wid=' + $("#s_warehouses option:selected").val() + '&' + d_csrf,
                success: function (data) {
                    
                    response($.map(data, function (item) {
                        console.log(data);
                        var product_d = item[0];
                        return {
                            label: product_d,
                            value: product_d,
                            data: item
                        };
                    }));
                }
            });
        },
        autoFocus: true,
        minLength: 0,
        select: function (event, ui) {
            id_arr = $(this).attr('id');
            id = id_arr.split("-");
            var t_r = ui.item.data[3];
            if ($("#taxformat option:selected").attr('data-trate')) {

                t_r = $("#taxformat option:selected").attr('data-trate');
            }
            var discount = ui.item.data[4];
            var custom_discount = $('#custom_discount').val();
            if (custom_discount > 0) discount = deciFormat(custom_discount);
			
			var purchase_price = ((ui.item.data[1]*100)/((100+parseInt(t_r))));

            $('#amount-' + id[1]).val(1);
            $('#price-' + id[1]).val(purchase_price);
            $('#pid-' + id[1]).val(ui.item.data[2]);
            $('#vat-' + id[1]).val(t_r);
            $('#discount-' + id[1]).val(discount);
            $('#dpid-' + id[1]).val(ui.item.data[5]);
            $('#unit-' + id[1]).val(ui.item.data[6]);
            $('#hsn-' + id[1]).val(ui.item.data[7]);
            $('#alert-' + id[1]).val(ui.item.data[8]);
            $('#serial-' + id[1]).val(ui.item.data[10]);
            $('#serial_id-' + id[1]).val(ui.item.data[11]);
            rowTotal(cvalue);
            billUpyog();


        },
        create: function (e) {
            $(this).prev('.ui-helper-hidden-accessible').remove();
        }
    });

});


$('#b2b-0').autocomplete({

    source: function (request, response) {
    
        $.ajax({
            url: baseurl + 'search_products/' + billtype,
            dataType: "json",
            method: 'post',
            data: 'name_startsWith=' + request.term + '&type=product_list&row_num=1&wid=' + $("#s_warehouses option:selected").val() + '&' + d_csrf,
            success: function (data) { 
                response($.map(data, function (item) {
                    var product_d = item[0];
                    return {
                        label: product_d,
                        value: product_d,
                        data: item
                    };
                }));
            }
        });
    },
    autoFocus: true,
    minLength: 0,
    select: function (event, ui) {
        var t_r = ui.item.data[3];
        if ($("#taxformat option:selected").attr('data-trate')) {

            t_r = $("#taxformat option:selected").attr('data-trate');
        }
        var discount = ui.item.data[4];
        var custom_discount = $('#custom_discount').val();
        if (custom_discount > 0) discount = deciFormat(custom_discount);
		
		
		 /* var t_r = data[3];
        var discount = data[4];
        var custom_discount = $('#custom_discount').val();
        if (custom_discount > 0) discount = deciFormat(custom_discount); */
		
		//var purchase_price = ((data[1]*100)/(100+t_r));
		var purchase_price = ((ui.item.data[1]*100)/((100+parseInt(t_r))));
		
		
        $('#amount-0').val(1);
        //$('#price-0').val(ui.item.data[1]);
        $('#price-0').val(purchase_price);
        $('#pid-0').val(ui.item.data[2]);
        $('#vat-0').val(t_r);
        $('#discount-0').val(discount);
        $('#dpid-0').val(ui.item.data[5]);
        $('#unit-0').val(ui.item.data[6]);
        $('#hsn-0').val(ui.item.data[7]);
        $('#alert-0').val(ui.item.data[8]);
        $('#serial-0').val(ui.item.data[10]);
        rowTotal(0);

        billUpyog();


    }
});


$('#stock_return').autocomplete({	
    source: function (request, response) {
    
        $.ajax({			
            url: baseurl + 'search_products/' + billtype,
            dataType: "json",
            method: 'post',
			//data: 'name_startsWith=' + request.term + '&type=product_list&row_num=' + row + '&wid=' + $("#s_warehouses option:selected").val() + '&' + d_csrf,
            data: 'name_startsWith=' + request.term + '&type=product_list&row_num=1&wid=' + $("#s_warehouses option:selected").val() + '&' + d_csrf,
            success: function (data) { 
                console.log(data); 				
                response($.map(data, function (item) {
                    var product_d = item[0];
                    return {
                        label: product_d,
                        value: product_d,
                        data: item
                    };
                }));
            }
        });
    },
    autoFocus: true,
    minLength: 0,
    select: function (event, ui) {
        var t_r = ui.item.data[3];
        if ($("#taxformat option:selected").attr('data-trate')) {

            t_r = $("#taxformat option:selected").attr('data-trate');
        }
        var discount = ui.item.data[4];
        var custom_discount = $('#custom_discount').val();
        if (custom_discount > 0) discount = deciFormat(custom_discount);
		
		var purchase_price = ((ui.item.data[1]*100)/((100+parseInt(t_r))));
		
        $('#amount-0').val(1);
        //$('#price-0').val(ui.item.data[1]);
        $('#price-0').val(purchase_price);
        $('#pid-0').val(ui.item.data[2]);
        $('#vat-0').val(t_r);
        $('#discount-0').val(discount);
        $('#dpid-0').val(ui.item.data[5]);
        $('#unit-0').val(ui.item.data[6]);
        $('#hsn-0').val(ui.item.data[7]);
        $('#alert-0').val(ui.item.data[8]);
        $('#serial-0').val(ui.item.data[10]);
        rowTotal(0);
        billUpyog();
    }
});


$("#serial_no_stock_return").change(function()
{
	var serial = $('#serial_no_stock_return').val();
	//alert(serial);
    if($('#stock_return-0').val()=='')
    {
		//alert('if');
		$.ajax({
            url: baseurl + 'search_products/search_product_by_serialsr',
            dataType: "json",
            method: 'post',
            data: 'name_startsWith=' + serial + '&type=product_list&row_num=1&wid=' + $("#s_warehouses").val() + '&' + d_csrf,
            //data: 'name_startsWith=' + serial + '&type=product_list&row_num=1&' + d_csrf,
            success: function (data) { 
               console.log(data);

        if(data[0]!=null)
        {
        var t_r = data[3];         
       
        
        var discount = data[4];
        var custom_discount = $('#custom_discount').val();
        if (custom_discount > 0) discount = deciFormat(custom_discount);
		//alert(data[1]);
		//var purchase_price = ((data[1]*100)/(100+t_r));
		var purchase_price = ((data[1]*100)/((100+parseInt(t_r))));
		//alert(purchase_price);
        $('#stock_return-0').val(data[0]);
        $('#amount-0').val(1);
        //$('#price-0').val(data[1]);
        $('#price-0').val(purchase_price);
        $('#pid-0').val(data[2]);
        $('#vat-0').val(t_r);
        $('#discount-0').val(discount);
        $('#dpid-0').val(data[5]);
        $('#unit-0').val(data[6]);
        $('#hsn-0').val(data[7]);
        $('#alert-0').val(data[8]);
        $('#serialNo-0').val(data[10]);
        $('#serial_id-0').val(data[10]);



        rowTotal(0);

        billUpyog();
        serial = $('#serial_no_stock_return').val('');

        $('#cnt').val('1');

         }
     }

        });
	}
	else
	{     
	//alert('else');
     $.ajax({
            url: baseurl + 'search_products/search_product_by_serialsr',
            dataType: "json",
            method: 'post',
            data: 'name_startsWith=' + serial + '&type=product_list&row_num=1&wid=' + $("#s_warehouses").val() + '&' + d_csrf,
            //data: 'name_startsWith=' + serial + '&type=product_list&row_num=1&' + d_csrf,
            success: function (data) { 
               console.log(data);
        var t_r = data[3];
         
        //if(data[0]!=null && $('#productname-0').val()!='' && $('#cnt').val()==1)
        if(data[0]!=null && $('#productname-0').val()!='')
        {
        

       var cvalue = parseInt($('#ganak').val()) + 1;
      
      
		var nxt = parseInt(cvalue);
		$('#ganak').val(nxt);
		var functionNum = "'" + cvalue + "'";
		count = $('#saman-row div').length;

		//var row = '<tr><td><input type="text" class="form-control" name="product_name[]" placeholder="Enter Product name or Code" id="productname-' + cvalue + '"></td><td><input type="text" class="form-control req amnt" name="product_qty[]" id="amount-' + cvalue + '" onkeypress="return isNumber(event)" onkeyup="rowTotal(' + functionNum + '), billUpyog()" autocomplete="off" value="1"  inputmode="numeric"><input type="hidden" id="alert-' + cvalue + '" value=""  name="alert[]"> </td> <td><input type="text" class="form-control req prc" name="product_price[]" id="price-' + cvalue + '" onkeypress="return isNumber(event)" onkeyup="rowTotal(' + functionNum + '), billUpyog()" autocomplete="off" inputmode="numeric"></td><td> <input type="text" class="form-control vat" value="0" name="product_tax[]" id="vat-' + cvalue + '" onkeypress="return isNumber(event)" onkeyup="rowTotal(' + functionNum + '), billUpyog()" autocomplete="off" inputmode="numeric"></td> <td id="texttaxa-' + cvalue + '" class="text-center">0</td><td><input type="text" class="form-control discount" name="serial_no11[]" readonly onkeypress="return isNumber(event)" id="serialNo-' + cvalue + '" onkeyup="rowTotal(' + functionNum + '), billUpyog()" autocomplete="off"></td> <td><input type="text" class="form-control discount" name="product_discount[]" onkeypress="return isNumber(event)" id="discount-' + cvalue + '" onkeyup="rowTotal(' + functionNum + '), billUpyog()" autocomplete="off"></td> <td><span class="currenty">' + currency + '</span> <strong><span class=\'ttlText\' id="result-' + cvalue + '">0</span></strong></td> <td class="text-center"><button type="button" data-rowid="' + cvalue + '" class="btn btn-danger removeProd" title="Remove" > <i class="fa fa-minus-square"></i> </button> </td><input type="hidden" name="taxa[]" id="taxa-' + cvalue + '" value="0"><input type="hidden" name="disca[]" id="disca-' + cvalue + '" value="0"><input type="hidden" class="ttInput" name="product_subtotal[]" id="total-' + cvalue + '" value="0"> <input type="hidden" class="pdIn" name="pid[]" id="pid-' + cvalue + '" value="0"> <input type="hidden" name="unit[]" id="unit-' + cvalue + '" value=""> <input type="hidden" name="hsn[]" id="hsn-' + cvalue + '" value=""> <input type="hidden" name="serial_no[]" id="serial_id-' + cvalue + '" value=""> </tr><tr><td colspan="8"><textarea class="form-control"  id="dpid-' + cvalue + '" name="product_description[]" placeholder="Enter Product description" autocomplete="off"></textarea><br></td></tr>';
		var row = '<tr><td><input type="text" class="form-control" name="product_name[]" placeholder="Enter Product name or Code" id="stock_return-' + cvalue + '"></td><td><input type="text" class="form-control req amnt" name="product_qty[]" id="amount-' + cvalue + '" onkeypress="return isNumber(event)" onkeyup="rowTotal(' + functionNum + '), billUpyog()" autocomplete="off" value="1"  inputmode="numeric"><input type="hidden" id="alert-' + cvalue + '" value=""  name="alert[]"> </td> <td><input type="text" class="form-control req prc" readonly name="product_price[]" id="price-' + cvalue + '" onkeypress="return isNumber(event)" onkeyup="rowTotal(' + functionNum + '), billUpyog()" autocomplete="off" inputmode="numeric"></td><td> <input type="text" class="form-control vat" value="0" name="product_tax[]" readonly id="vat-' + cvalue + '" onkeypress="return isNumber(event)" onkeyup="rowTotal(' + functionNum + '), billUpyog()" autocomplete="off" inputmode="numeric"></td> <td id="texttaxa-' + cvalue + '" class="text-center">0</td> <td><input type="text" class="form-control discount" readonly name="product_discount[]" onkeypress="return isNumber(event)" id="discount-' + cvalue + '" onkeyup="rowTotal(' + functionNum + '), billUpyog()" autocomplete="off"></td> <td><span class="currenty">' + currency + '</span> <strong><span class=\'ttlText\' id="result-' + cvalue + '">0</span></strong></td> <td class="text-center"><button type="button" data-rowid="' + cvalue + '" class="btn btn-danger removeProd" title="Remove" > <i class="fa fa-minus-square"></i> </button> </td><input type="hidden" name="taxa[]" id="taxa-' + cvalue + '" value="0"><input type="hidden" name="disca[]" id="disca-' + cvalue + '" value="0"><input type="hidden" class="ttInput" name="product_subtotal[]" id="total-' + cvalue + '" value="0"> <input type="hidden" class="pdIn" name="pid[]" id="pid-' + cvalue + '" value="0"> <input type="hidden" name="unit[]" id="unit-' + cvalue + '" value=""> <input type="hidden" name="hsn[]" id="hsn-' + cvalue + '" value=""> <input type="hidden" name="serial_no[]" id="serial_id-' + cvalue + '" value=""> </tr><tr><td colspan="8"><textarea class="form-control"  id="dpid-' + cvalue + '" name="product_description[]" placeholder="Enter Product description" autocomplete="off"></textarea><br></td></tr>';
		 //ajax request
		 //$('#saman-row').append(row);
		$('tr.last-item-row').before(row);

           row = cvalue;

        var t_r = data[3];
        var discount = data[4];
        var custom_discount = $('#custom_discount').val();
        if (custom_discount > 0) discount = deciFormat(custom_discount);
		
		//var purchase_price = ((data[1]*100)/(100+t_r));
		var purchase_price = ((data[1]*100)/((100+parseInt(t_r))));
		
        $('#stock_return-'+cvalue).val(data[0]);
        $('#amount-'+cvalue).val(1);
        //$('#price-'+cvalue).val(data[1]);
        $('#price-'+cvalue).val(purchase_price);
        $('#pid-'+cvalue).val(data[2]);
        $('#vat-'+cvalue).val(t_r);
        $('#discount-'+cvalue).val(discount);
        $('#dpid-'+cvalue).val(data[5]);
        $('#unit-'+cvalue).val(data[6]);
        $('#hsn-'+cvalue).val(data[7]);
        $('#alert-'+cvalue).val(data[8]);
        $('#serialNo-'+cvalue).val(data[10]);
        $('#serial_id-'+cvalue).val(data[10]);


        
        numb = cvalue;
        var result;
		var page = '';
		var totalValue = 0;
		var amountVal = accounting.unformat($("#amount-" + numb).val(), accounting.settings.number.decimal);
		var priceVal = accounting.unformat($("#price-" + numb).val(), accounting.settings.number.decimal);
		var discountVal = accounting.unformat($("#discount-" + numb).val(), accounting.settings.number.decimal);
		var vatVal = accounting.unformat($("#vat-" + numb).val(), accounting.settings.number.decimal);
		var taxo = 0;
		var disco = 0;
		var totalPrice = amountVal.toFixed(two_fixed) * priceVal;   
		var tax_status = $("#taxformat option:selected").val();
		var disFormat = $("#discount_format").val();
		if ($("#inv_page").val() == 'new_i' && formInputGet("#pid", numb) > 0) {
			var alertVal = accounting.unformat($("#alert-" + numb).val(), accounting.settings.number.decimal);
			if (alertVal <= +amountVal) {
				var aqt = alertVal-amountVal;
				alert('Low Stock! ' + accounting.formatNumber(aqt));
			}
		}
		//tax after bill
		if (tax_status == 'yes') {
			if (disFormat == '%' || disFormat == 'flat') {
				//tax
				var Inpercentage = precentCalc(totalPrice, vatVal);
				totalValue = totalPrice + Inpercentage;
				taxo = accounting.formatNumber(Inpercentage);
				if (disFormat == 'flat') {
					disco = accounting.formatNumber(discountVal);
					totalValue = totalValue - discountVal;
				} else if (disFormat == '%') {
					var discount = precentCalc(totalValue, discountVal);
					totalValue = totalValue - discount;
					disco = accounting.formatNumber(discount);
				}
			} else {
	//before tax
				if (disFormat == 'bflat') {
					disco = accounting.formatNumber(discountVal);
					totalValue = totalPrice - discountVal;
				} else if (disFormat == 'b_p') {
					var discount = precentCalc(totalPrice, discountVal);
					totalValue = totalPrice - discount;
					disco = accounting.formatNumber(discount);
				}

				//tax
				var Inpercentage = precentCalc(totalValue, vatVal);
				totalValue = totalValue + Inpercentage;
				taxo = accounting.formatNumber(Inpercentage);
			}
		} else if (tax_status == 'inclusive') {
			if (disFormat == '%' || disFormat == 'flat') {
				//tax
				var Inpercentage = (totalPrice * vatVal) / (100 + vatVal);
				totalValue = totalPrice;
				taxo = accounting.formatNumber(Inpercentage);
				if (disFormat == 'flat') {
					disco = accounting.formatNumber(discountVal);
					totalValue = totalValue - discountVal;
				} else if (disFormat == '%') {
					var discount = precentCalc(totalValue, discountVal);
					totalValue = totalValue - discount;
					disco = accounting.formatNumber(discount);
				}
			} else {
	//before tax
				if (disFormat == 'bflat') {
					disco = accounting.formatNumber(discountVal);
					totalValue = totalPrice - discountVal;
				} else if (disFormat == 'b_p') {
					var discount = precentCalc(totalPrice, discountVal);
					totalValue = totalPrice - discount;
					disco = accounting.formatNumber(discount);
				}
				//tax
				var Inpercentage = (totalPrice * vatVal) / (100 + vatVal);
				totalValue = totalValue;
				taxo = accounting.formatNumber(Inpercentage);
			}
		} else {
			taxo = 0;
			if (disFormat == '%' || disFormat == 'flat') {
				if (disFormat == 'flat') {
					disco = accounting.formatNumber(discountVal);
					totalValue = totalPrice - discountVal;
				} else if (disFormat == '%') {
					var discount = precentCalc(totalPrice, discountVal);
					totalValue = totalPrice - discount;
					disco = accounting.formatNumber(discount);
				}

			} else {
	//before tax
				if (disFormat == 'bflat') {
					disco = accounting.formatNumber(discountVal);
					totalValue = totalPrice - discountVal;
				} else if (disFormat == 'b_p') {
					var discount = precentCalc(totalPrice, discountVal);
					totalValue = totalPrice - discount;
					disco = accounting.formatNumber(discount);
				}
			}
		}
		//alert(Math.ceil(totalValue));
		totalValue = Math.ceil(totalValue);
		$("#result-" + numb).html(accounting.formatNumber(totalValue));
		$("#taxa-" + numb).val(taxo);
		$("#texttaxa-" + numb).text(taxo);
		$("#disca-" + numb).val(disco);
		$("#total-" + numb).val(accounting.formatNumber(totalValue));
		samanYog();
         

        ///rowTotal(0);
        billUpyog();
        serial = $('#serial_no_stock_return').val('');
          }                
           
		   }
        });
}
});



$('#addproduct_stock_return').on('click', function () {
    var cvalue = parseInt($('#ganak').val()) + 1;
    var nxt = parseInt(cvalue);
    $('#ganak').val(nxt);
    var functionNum = "'" + cvalue + "'";
    count = $('#saman-row div').length;

    
    
    var data = '<tr><td><input type="text" class="form-control" name="product_name[]" placeholder="Enter Product name or Code" id="stock_return-' + cvalue + '"></td><td><input type="text" class="form-control req amnt" name="product_qty[]" id="amount-' + cvalue + '" onkeypress="return isNumber(event)" onkeyup="rowTotal(' + functionNum + '), billUpyog()" autocomplete="off" value="1"  inputmode="numeric"><input type="hidden" id="alert-' + cvalue + '" value=""  name="alert[]"> </td> <td><input type="text" class="form-control req prc" readonly name="product_price[]" id="price-' + cvalue + '" onkeypress="return isNumber(event)" onkeyup="rowTotal(' + functionNum + '), billUpyog()" autocomplete="off" inputmode="numeric"></td><td> <input type="text" class="form-control vat" value="0" name="product_tax[]" readonly id="vat-' + cvalue + '" onkeypress="return isNumber(event)" onkeyup="rowTotal(' + functionNum + '), billUpyog()" autocomplete="off" inputmode="numeric"></td> <td id="texttaxa-' + cvalue + '" class="text-center">0</td> <td><input type="text" class="form-control discount" readonly name="product_discount[]" onkeypress="return isNumber(event)" id="discount-' + cvalue + '" onkeyup="rowTotal(' + functionNum + '), billUpyog()" autocomplete="off"></td> <td><span class="currenty">' + currency + '</span> <strong><span class=\'ttlText\' id="result-' + cvalue + '">0</span></strong></td> <td class="text-center"><button type="button" data-rowid="' + cvalue + '" class="btn btn-danger removeProd" title="Remove" > <i class="fa fa-minus-square"></i> </button> </td><input type="hidden" name="taxa[]" id="taxa-' + cvalue + '" value="0"><input type="hidden" name="disca[]" id="disca-' + cvalue + '" value="0"><input type="hidden" class="ttInput" name="product_subtotal[]" id="total-' + cvalue + '" value="0"> <input type="hidden" class="pdIn" name="pid[]" id="pid-' + cvalue + '" value="0"> <input type="hidden" name="unit[]" id="unit-' + cvalue + '" value=""> <input type="hidden" name="hsn[]" id="hsn-' + cvalue + '" value=""> <input type="hidden" name="serial[]" id="serial-' + cvalue + '" value=""> </tr><tr><td colspan="8"><textarea class="form-control"  id="dpid-' + cvalue + '" name="product_description[]" placeholder="Enter Product description" autocomplete="off"></textarea><br></td></tr>';
     //ajax request
    // $('#saman-row').append(data);
    $('tr.last-item-row').before(data);

    row = cvalue;

    $('#stock_return-' + cvalue).autocomplete({
        source: function (request, response) {
            $.ajax({
                url: baseurl + 'search_products/' + billtype,
                dataType: "json",
                method: 'post',
                data: 'name_startsWith=' + request.term + '&type=product_list&row_num=' + row + '&wid=' + $("#s_warehouses option:selected").val() + '&' + d_csrf,
                success: function (data) {
                    
                    response($.map(data, function (item) {
                        console.log(data);
                        var product_d = item[0];
                        return {
                            label: product_d,
                            value: product_d,
                            data: item
                        };
                    }));
                }
            });
        },
        autoFocus: true,
        minLength: 0,
        select: function (event, ui) {
            id_arr = $(this).attr('id');
            id = id_arr.split("-");
            var t_r = ui.item.data[3];
            if ($("#taxformat option:selected").attr('data-trate')) {

                t_r = $("#taxformat option:selected").attr('data-trate');
            }
            var discount = ui.item.data[4];
            var custom_discount = $('#custom_discount').val();
            if (custom_discount > 0) discount = deciFormat(custom_discount);
			
			var purchase_price = ((ui.item.data[1]*100)/((100+parseInt(t_r))));

            $('#amount-' + id[1]).val(1);
            $('#price-' + id[1]).val(purchase_price);
            $('#pid-' + id[1]).val(ui.item.data[2]);
            $('#vat-' + id[1]).val(t_r);
            $('#discount-' + id[1]).val(discount);
            $('#dpid-' + id[1]).val(ui.item.data[5]);
            $('#unit-' + id[1]).val(ui.item.data[6]);
            $('#hsn-' + id[1]).val(ui.item.data[7]);
            $('#alert-' + id[1]).val(ui.item.data[8]);
            $('#serial-' + id[1]).val(ui.item.data[10]);
            $('#serial_id-' + id[1]).val(ui.item.data[11]);
            rowTotal(cvalue);
            billUpyog();


        },
        create: function (e) {
            $(this).prev('.ui-helper-hidden-accessible').remove();
        }
    });

});


$('#stock_return-0').autocomplete({

    source: function (request, response) {
    
        $.ajax({
            url: baseurl + 'search_products/' + billtype,
            dataType: "json",
            method: 'post',
            data: 'name_startsWith=' + request.term + '&type=product_list&row_num=1&wid=' + $("#s_warehouses option:selected").val() + '&' + d_csrf,
            success: function (data) { 
                response($.map(data, function (item) {
                    var product_d = item[0];
                    return {
                        label: product_d,
                        value: product_d,
                        data: item
                    };
                }));
            }
        });
    },
    autoFocus: true,
    minLength: 0,
    select: function (event, ui) {
        var t_r = ui.item.data[3];
        if ($("#taxformat option:selected").attr('data-trate')) {

            t_r = $("#taxformat option:selected").attr('data-trate');
        }		
        var discount = ui.item.data[4];
        var custom_discount = $('#custom_discount').val();
        if (custom_discount > 0) discount = deciFormat(custom_discount);
		
		
		 /* var t_r = data[3];
        var discount = data[4];
        var custom_discount = $('#custom_discount').val();
        if (custom_discount > 0) discount = deciFormat(custom_discount); */
		
		//var purchase_price = ((data[1]*100)/(100+t_r));
		var purchase_price = ((ui.item.data[1]*100)/((100+parseInt(t_r))));
		
		
        $('#amount-0').val(1);
        //$('#price-0').val(ui.item.data[1]);
        $('#price-0').val(purchase_price);
        $('#pid-0').val(ui.item.data[2]);
        $('#vat-0').val(t_r);
        $('#discount-0').val(discount);
        $('#dpid-0').val(ui.item.data[5]);
        $('#unit-0').val(ui.item.data[6]);
        $('#hsn-0').val(ui.item.data[7]);
        $('#alert-0').val(ui.item.data[8]);
        $('#serial-0').val(ui.item.data[10]);
        rowTotal(0);

        billUpyog();
    }
});











$('#sale_lrp').autocomplete({	
    source: function (request, response) {
    
        $.ajax({			
            url: baseurl + 'search_products/' + billtype,
            dataType: "json",
            method: 'post',
			//data: 'name_startsWith=' + request.term + '&type=product_list&row_num=' + row + '&wid=' + $("#s_warehouses option:selected").val() + '&' + d_csrf,
            data: 'name_startsWith=' + request.term + '&type=product_list&row_num=1&wid=' + $("#s_warehouses option:selected").val() + '&' + d_csrf,
            success: function (data) { 
                console.log(data); 				
                response($.map(data, function (item) {
                    var product_d = item[0];
                    return {
                        label: product_d,
                        value: product_d,
                        data: item
                    };
                }));
            }
        });
    },
    autoFocus: true,
    minLength: 0,
    select: function (event, ui) {
        var t_r = ui.item.data[3];
        if ($("#taxformat option:selected").attr('data-trate')) {

            t_r = $("#taxformat option:selected").attr('data-trate');
        }
        var discount = ui.item.data[4];
        var custom_discount = $('#custom_discount').val();
        if (custom_discount > 0) discount = deciFormat(custom_discount);
		
		var purchase_price = ((ui.item.data[1]*100)/((100+parseInt(t_r))));
		
        $('#amount-0').val(1);
        //$('#price-0').val(ui.item.data[1]);
        $('#price-0').val(purchase_price);
        $('#pid-0').val(ui.item.data[2]);
        //$('#vat-0').val(t_r);
        $('#vat-0').val(0);
        $('#discount-0').val(discount);
        $('#dpid-0').val(ui.item.data[5]);
        $('#unit-0').val(ui.item.data[6]);
        $('#hsn-0').val(ui.item.data[7]);
        $('#alert-0').val(ui.item.data[8]);
        $('#serial-0').val(ui.item.data[10]);
        rowTotal(0);
        billUpyog();
    }
});


$("#serial_no_lrp").change(function()
{
	var serial = $('#serial_no_lrp').val();
	//alert(serial);
    if($('#sale_lrp-0').val()=='')
    {
		//alert('if');
		$.ajax({
            url: baseurl + 'search_products/search_product_lrp',
            dataType: "json",
            method: 'post',
            data: 'name_startsWith=' + serial + '&type=product_list&row_num=1&wid=' + $("#s_warehouses").val() + '&' + d_csrf,
            //data: 'name_startsWith=' + serial + '&type=product_list&row_num=1&' + d_csrf,
            success: function (data) {
               console.log(data);
				if(data[0]!=null)
				{
				var t_r = data[3];         
			   
				
				var discount = data[4];
				var custom_discount = $('#custom_discount').val();
				if (custom_discount > 0) discount = deciFormat(custom_discount);
				//alert(data[1]);
				//var purchase_price = ((data[1]*100)/(100+t_r));
				var purchase_price = ((data[1]*100)/((100+parseInt(t_r))));
				//alert(purchase_price);
				$('#sale_lrp-0').val(data[0]);
				$('#amount-0').val(1);
				//$('#price-0').val(data[1]);
				$('#price-0').val(purchase_price);
				$('#pid-0').val(data[2]);
				//$('#vat-0').val(t_r);
				$('#vat-0').val(0);
				$('#discount-0').val(discount);
				$('#dpid-0').val(data[5]);
				$('#unit-0').val(data[6]);
				$('#hsn-0').val(data[7]);
				$('#alert-0').val(data[8]);
				$('#serialNo-0').val(data[10]);
				$('#serial_id-0').val(data[10]);



				rowTotal(0);

				billUpyog();
				serial = $('#serial_no_lrp').val('');

				$('#cnt').val('1');

				}
			}
        });
	}
	else
	{     
	//alert('else');
     $.ajax({
            url: baseurl + 'search_products/search_product_lrp',
            dataType: "json",
            method: 'post',
            data: 'name_startsWith=' + serial + '&type=product_list&row_num=1&wid=' + $("#s_warehouses").val() + '&' + d_csrf,
            //data: 'name_startsWith=' + serial + '&type=product_list&row_num=1&' + d_csrf,
            success: function (data) { 
               console.log(data);
        var t_r = data[3];
         
        //if(data[0]!=null && $('#productname-0').val()!='' && $('#cnt').val()==1)
        if(data[0]!=null && $('#sale_lrp-0').val()!='')
        {
        

       var cvalue = parseInt($('#ganak').val()) + 1;
      
      
		var nxt = parseInt(cvalue);
		$('#ganak').val(nxt);
		var functionNum = "'" + cvalue + "'";
		count = $('#saman-row div').length;

		//var row = '<tr><td><input type="text" class="form-control" name="product_name[]" placeholder="Enter Product name or Code" id="productname-' + cvalue + '"></td><td><input type="text" class="form-control req amnt" name="product_qty[]" id="amount-' + cvalue + '" onkeypress="return isNumber(event)" onkeyup="rowTotal(' + functionNum + '), billUpyog()" autocomplete="off" value="1"  inputmode="numeric"><input type="hidden" id="alert-' + cvalue + '" value=""  name="alert[]"> </td> <td><input type="text" class="form-control req prc" name="product_price[]" id="price-' + cvalue + '" onkeypress="return isNumber(event)" onkeyup="rowTotal(' + functionNum + '), billUpyog()" autocomplete="off" inputmode="numeric"></td><td> <input type="text" class="form-control vat" value="0" name="product_tax[]" id="vat-' + cvalue + '" onkeypress="return isNumber(event)" onkeyup="rowTotal(' + functionNum + '), billUpyog()" autocomplete="off" inputmode="numeric"></td> <td id="texttaxa-' + cvalue + '" class="text-center">0</td><td><input type="text" class="form-control discount" name="serial_no11[]" readonly onkeypress="return isNumber(event)" id="serialNo-' + cvalue + '" onkeyup="rowTotal(' + functionNum + '), billUpyog()" autocomplete="off"></td> <td><input type="text" class="form-control discount" name="product_discount[]" onkeypress="return isNumber(event)" id="discount-' + cvalue + '" onkeyup="rowTotal(' + functionNum + '), billUpyog()" autocomplete="off"></td> <td><span class="currenty">' + currency + '</span> <strong><span class=\'ttlText\' id="result-' + cvalue + '">0</span></strong></td> <td class="text-center"><button type="button" data-rowid="' + cvalue + '" class="btn btn-danger removeProd" title="Remove" > <i class="fa fa-minus-square"></i> </button> </td><input type="hidden" name="taxa[]" id="taxa-' + cvalue + '" value="0"><input type="hidden" name="disca[]" id="disca-' + cvalue + '" value="0"><input type="hidden" class="ttInput" name="product_subtotal[]" id="total-' + cvalue + '" value="0"> <input type="hidden" class="pdIn" name="pid[]" id="pid-' + cvalue + '" value="0"> <input type="hidden" name="unit[]" id="unit-' + cvalue + '" value=""> <input type="hidden" name="hsn[]" id="hsn-' + cvalue + '" value=""> <input type="hidden" name="serial_no[]" id="serial_id-' + cvalue + '" value=""> </tr><tr><td colspan="8"><textarea class="form-control"  id="dpid-' + cvalue + '" name="product_description[]" placeholder="Enter Product description" autocomplete="off"></textarea><br></td></tr>';
		var row = '<tr><td><input type="text" class="form-control" name="product_name[]" placeholder="Enter Product name or Code" id="sale_lrp-' + cvalue + '"></td><td><input type="text" class="form-control req amnt" name="product_qty[]" id="amount-' + cvalue + '" onkeypress="return isNumber(event)" onkeyup="rowTotal(' + functionNum + '), billUpyog()" autocomplete="off" value="1"  inputmode="numeric"><input type="hidden" id="alert-' + cvalue + '" value=""  name="alert[]"> </td> <td><input type="text" class="form-control req prc" readonly name="product_price[]" id="price-' + cvalue + '" onkeypress="return isNumber(event)" onkeyup="rowTotal(' + functionNum + '), billUpyog()" autocomplete="off" inputmode="numeric"></td><td> <input type="text" class="form-control vat" value="0" name="product_tax[]" readonly id="vat-' + cvalue + '" onkeypress="return isNumber(event)" onkeyup="rowTotal(' + functionNum + '), billUpyog()" autocomplete="off" inputmode="numeric"></td> <td id="texttaxa-' + cvalue + '" class="text-center">0</td> <td><input type="text" class="form-control discount" readonly name="product_discount[]" onkeypress="return isNumber(event)" id="discount-' + cvalue + '" onkeyup="rowTotal(' + functionNum + '), billUpyog()" autocomplete="off"></td> <td><span class="currenty">' + currency + '</span> <strong><span class=\'ttlText\' id="result-' + cvalue + '">0</span></strong></td> <td class="text-center"><button type="button" data-rowid="' + cvalue + '" class="btn btn-danger removeProd" title="Remove" > <i class="fa fa-minus-square"></i> </button> </td><input type="hidden" name="taxa[]" id="taxa-' + cvalue + '" value="0"><input type="hidden" name="disca[]" id="disca-' + cvalue + '" value="0"><input type="hidden" class="ttInput" name="product_subtotal[]" id="total-' + cvalue + '" value="0"> <input type="hidden" class="pdIn" name="pid[]" id="pid-' + cvalue + '" value="0"> <input type="hidden" name="unit[]" id="unit-' + cvalue + '" value=""> <input type="hidden" name="hsn[]" id="hsn-' + cvalue + '" value=""> <input type="hidden" name="serial_no[]" id="serial_id-' + cvalue + '" value=""> </tr><tr><td colspan="8"><textarea class="form-control"  id="dpid-' + cvalue + '" name="product_description[]" placeholder="Enter Product description" autocomplete="off"></textarea><br></td></tr>';
		 //ajax request
		 //$('#saman-row').append(row);
		$('tr.last-item-row').before(row);

           row = cvalue;

        var t_r = data[3];
        var discount = data[4];
        var custom_discount = $('#custom_discount').val();
        if (custom_discount > 0) discount = deciFormat(custom_discount);
		
		//var purchase_price = ((data[1]*100)/(100+t_r));
		var purchase_price = ((data[1]*100)/((100+parseInt(t_r))));
		//alert(purchase_price);
		
        $('#sale_lrp-'+cvalue).val(data[0]);
        $('#amount-'+cvalue).val(1);
        //$('#price-'+cvalue).val(data[1]);
        $('#price-'+cvalue).val(purchase_price);
        $('#pid-'+cvalue).val(data[2]);
        //$('#vat-'+cvalue).val(t_r);
        $('#vat-'+cvalue).val(0);
        $('#discount-'+cvalue).val(discount);
        $('#dpid-'+cvalue).val(data[5]);
        $('#unit-'+cvalue).val(data[6]);
        $('#hsn-'+cvalue).val(data[7]);
        $('#alert-'+cvalue).val(data[8]);
        $('#serialNo-'+cvalue).val(data[10]);
        $('#serial_id-'+cvalue).val(data[10]);


        
        numb = cvalue;
        var result;
		var page = '';
		var totalValue = 0;
		var amountVal = accounting.unformat($("#amount-" + numb).val(), accounting.settings.number.decimal);
		var priceVal = accounting.unformat($("#price-" + numb).val(), accounting.settings.number.decimal);
		var discountVal = accounting.unformat($("#discount-" + numb).val(), accounting.settings.number.decimal);
		var vatVal = accounting.unformat($("#vat-" + numb).val(), accounting.settings.number.decimal);
		var taxo = 0;
		var disco = 0;
		var totalPrice = amountVal.toFixed(two_fixed) * priceVal;   
		var tax_status = $("#taxformat option:selected").val();
		var disFormat = $("#discount_format").val();
		if ($("#inv_page").val() == 'new_i' && formInputGet("#pid", numb) > 0) {
			var alertVal = accounting.unformat($("#alert-" + numb).val(), accounting.settings.number.decimal);
			if (alertVal <= +amountVal) {
				var aqt = alertVal-amountVal;
				alert('Low Stock! ' + accounting.formatNumber(aqt));
			}
		}
		//tax after bill
		if (tax_status == 'yes') {
			if (disFormat == '%' || disFormat == 'flat') {
				//tax
				var Inpercentage = precentCalc(totalPrice, vatVal);
				totalValue = totalPrice + Inpercentage;
				taxo = accounting.formatNumber(Inpercentage);
				if (disFormat == 'flat') {
					disco = accounting.formatNumber(discountVal);
					totalValue = totalValue - discountVal;
				} else if (disFormat == '%') {
					var discount = precentCalc(totalValue, discountVal);
					totalValue = totalValue - discount;
					disco = accounting.formatNumber(discount);
				}
			} else {
	//before tax
				if (disFormat == 'bflat') {
					disco = accounting.formatNumber(discountVal);
					totalValue = totalPrice - discountVal;
				} else if (disFormat == 'b_p') {
					var discount = precentCalc(totalPrice, discountVal);
					totalValue = totalPrice - discount;
					disco = accounting.formatNumber(discount);
				}

				//tax
				var Inpercentage = precentCalc(totalValue, vatVal);
				totalValue = totalValue + Inpercentage;
				taxo = accounting.formatNumber(Inpercentage);
			}
		} else if (tax_status == 'inclusive') {
			if (disFormat == '%' || disFormat == 'flat') {
				//tax
				var Inpercentage = (totalPrice * vatVal) / (100 + vatVal);
				totalValue = totalPrice;
				taxo = accounting.formatNumber(Inpercentage);
				if (disFormat == 'flat') {
					disco = accounting.formatNumber(discountVal);
					totalValue = totalValue - discountVal;
				} else if (disFormat == '%') {
					var discount = precentCalc(totalValue, discountVal);
					totalValue = totalValue - discount;
					disco = accounting.formatNumber(discount);
				}
			} else {
			//before tax
				if (disFormat == 'bflat') {
					disco = accounting.formatNumber(discountVal);
					totalValue = totalPrice - discountVal;
				} else if (disFormat == 'b_p') {
					var discount = precentCalc(totalPrice, discountVal);
					totalValue = totalPrice - discount;
					disco = accounting.formatNumber(discount);
				}
				//tax
				var Inpercentage = (totalPrice * vatVal) / (100 + vatVal);
				totalValue = totalValue;
				taxo = accounting.formatNumber(Inpercentage);
			}
		} else {
			taxo = 0;
			if (disFormat == '%' || disFormat == 'flat') {
				if (disFormat == 'flat') {
					disco = accounting.formatNumber(discountVal);
					totalValue = totalPrice - discountVal;
				} else if (disFormat == '%') {
					var discount = precentCalc(totalPrice, discountVal);
					totalValue = totalPrice - discount;
					disco = accounting.formatNumber(discount);
				}

			} else {
			//before tax
				if (disFormat == 'bflat') {
					disco = accounting.formatNumber(discountVal);
					totalValue = totalPrice - discountVal;
				} else if (disFormat == 'b_p') {
					var discount = precentCalc(totalPrice, discountVal);
					totalValue = totalPrice - discount;
					disco = accounting.formatNumber(discount);
				}
			}
		}
		//alert(Math.ceil(totalValue));
		totalValue = Math.ceil(totalValue);
		$("#result-" + numb).html(accounting.formatNumber(totalValue));
		$("#taxa-" + numb).val(taxo);
		$("#texttaxa-" + numb).text(taxo);
		$("#disca-" + numb).val(disco);
		$("#total-" + numb).val(accounting.formatNumber(totalValue));
		samanYog();
         

        ///rowTotal(0);
        billUpyog();
        serial = $('#serial_no_lrp').val('');
          }                
           
		   }
        });
}
});



$('#addproduct_sale_lrp').on('click', function () {
    var cvalue = parseInt($('#ganak').val()) + 1;
    var nxt = parseInt(cvalue);
    $('#ganak').val(nxt);
    var functionNum = "'" + cvalue + "'";
    count = $('#saman-row div').length;    
    
    var data = '<tr><td><input type="text" class="form-control" name="product_name[]" placeholder="Enter Product name or Code" id="sale_lrp-' + cvalue + '"></td><td><input type="text" class="form-control req amnt" name="product_qty[]" id="amount-' + cvalue + '" onkeypress="return isNumber(event)" onkeyup="rowTotal(' + functionNum + '), billUpyog()" autocomplete="off" value="1"  inputmode="numeric"><input type="hidden" id="alert-' + cvalue + '" value=""  name="alert[]"> </td> <td><input type="text" class="form-control req prc" readonly name="product_price[]" id="price-' + cvalue + '" onkeypress="return isNumber(event)" onkeyup="rowTotal(' + functionNum + '), billUpyog()" autocomplete="off" inputmode="numeric"></td><td> <input type="text" class="form-control vat" value="0" name="product_tax[]" readonly id="vat-' + cvalue + '" onkeypress="return isNumber(event)" onkeyup="rowTotal(' + functionNum + '), billUpyog()" autocomplete="off" inputmode="numeric"></td> <td id="texttaxa-' + cvalue + '" class="text-center">0</td> <td><input type="text" class="form-control discount" readonly name="product_discount[]" onkeypress="return isNumber(event)" id="discount-' + cvalue + '" onkeyup="rowTotal(' + functionNum + '), billUpyog()" autocomplete="off"></td> <td><span class="currenty">' + currency + '</span> <strong><span class=\'ttlText\' id="result-' + cvalue + '">0</span></strong></td> <td class="text-center"><button type="button" data-rowid="' + cvalue + '" class="btn btn-danger removeProd" title="Remove" > <i class="fa fa-minus-square"></i> </button> </td><input type="hidden" name="taxa[]" id="taxa-' + cvalue + '" value="0"><input type="hidden" name="disca[]" id="disca-' + cvalue + '" value="0"><input type="hidden" class="ttInput" name="product_subtotal[]" id="total-' + cvalue + '" value="0"> <input type="hidden" class="pdIn" name="pid[]" id="pid-' + cvalue + '" value="0"> <input type="hidden" name="unit[]" id="unit-' + cvalue + '" value=""> <input type="hidden" name="hsn[]" id="hsn-' + cvalue + '" value=""> <input type="hidden" name="serial[]" id="serial-' + cvalue + '" value=""> </tr><tr><td colspan="8"><textarea class="form-control"  id="dpid-' + cvalue + '" name="product_description[]" placeholder="Enter Product description" autocomplete="off"></textarea><br></td></tr>';
     //ajax request
    // $('#saman-row').append(data);
    $('tr.last-item-row').before(data);

    row = cvalue;

    $('#sale_lrp-' + cvalue).autocomplete({
        source: function (request, response) {
            $.ajax({
                url: baseurl + 'search_products/' + billtype,
                dataType: "json",
                method: 'post',
                data: 'name_startsWith=' + request.term + '&type=product_list&row_num=' + row + '&wid=' + $("#s_warehouses option:selected").val() + '&' + d_csrf,
                success: function (data) {
                    
                    response($.map(data, function (item) {
                        console.log(data);
                        var product_d = item[0];
                        return {
                            label: product_d,
                            value: product_d,
                            data: item
                        };
                    }));
                }
            });
        },
        autoFocus: true,
        minLength: 0,
        select: function (event, ui) {
            id_arr = $(this).attr('id');
            id = id_arr.split("-");
            var t_r = ui.item.data[3];
            if ($("#taxformat option:selected").attr('data-trate')) {

                t_r = $("#taxformat option:selected").attr('data-trate');
            }
            var discount = ui.item.data[4];
            var custom_discount = $('#custom_discount').val();
            if (custom_discount > 0) discount = deciFormat(custom_discount);
			
			var purchase_price = ((ui.item.data[1]*100)/((100+parseInt(t_r))));

            $('#amount-' + id[1]).val(1);
            $('#price-' + id[1]).val(purchase_price);
            $('#pid-' + id[1]).val(ui.item.data[2]);
            //$('#vat-' + id[1]).val(t_r);
            $('#vat-' + id[1]).val(0);
            $('#discount-' + id[1]).val(discount);
            $('#dpid-' + id[1]).val(ui.item.data[5]);
            $('#unit-' + id[1]).val(ui.item.data[6]);
            $('#hsn-' + id[1]).val(ui.item.data[7]);
            $('#alert-' + id[1]).val(ui.item.data[8]);
            $('#serial-' + id[1]).val(ui.item.data[10]);
            $('#serial_id-' + id[1]).val(ui.item.data[11]);
            rowTotal(cvalue);
            billUpyog();


        },
        create: function (e) {
            $(this).prev('.ui-helper-hidden-accessible').remove();
        }
    });

});


$('#sale_lrp-0').autocomplete({

    source: function (request, response) {
    
        $.ajax({
            url: baseurl + 'search_products/' + billtype,
            dataType: "json",
            method: 'post',
            data: 'name_startsWith=' + request.term + '&type=product_list&row_num=1&wid=' + $("#s_warehouses option:selected").val() + '&' + d_csrf,
            success: function (data) { 
                response($.map(data, function (item) {
                    var product_d = item[0];
                    return {
                        label: product_d,
                        value: product_d,
                        data: item
                    };
                }));
            }
        });
    },
    autoFocus: true,
    minLength: 0,
    select: function (event, ui) {
        var t_r = ui.item.data[3];
        if ($("#taxformat option:selected").attr('data-trate')) {

            t_r = $("#taxformat option:selected").attr('data-trate');
        }		
        var discount = ui.item.data[4];
        var custom_discount = $('#custom_discount').val();
        if (custom_discount > 0) discount = deciFormat(custom_discount);
		
		
		 /* var t_r = data[3];
        var discount = data[4];
        var custom_discount = $('#custom_discount').val();
        if (custom_discount > 0) discount = deciFormat(custom_discount); */
		
		//var purchase_price = ((data[1]*100)/(100+t_r));
		var purchase_price = ((ui.item.data[1]*100)/((100+parseInt(t_r))));
		
		
        $('#amount-0').val(1);
        //$('#price-0').val(ui.item.data[1]);
        $('#price-0').val(purchase_price);
        $('#pid-0').val(ui.item.data[2]);
        //$('#vat-0').val(t_r);
        $('#vat-0').val(0);
        $('#discount-0').val(discount);
        $('#dpid-0').val(ui.item.data[5]);
        $('#unit-0').val(ui.item.data[6]);
        $('#hsn-0').val(ui.item.data[7]);
        $('#alert-0').val(ui.item.data[8]);
        $('#serial-0').val(ui.item.data[10]);
        rowTotal(0);

        billUpyog();
    }
});


$('#sparepart_sale-0').autocomplete({

    source: function (request, response) {
    
        $.ajax({
            url: baseurl + 'search_products/' + billtype,
            dataType: "json",
            method: 'post',
            data: 'name_startsWith=' + request.term + '&type=product_list&row_num=1&wid=' + $("#s_warehouses option:selected").val() + '&' + d_csrf,
            success: function (data) { 
				//console.log(data);
                response($.map(data, function (item) {
                    var product_d = item[0];
                    return {
                        label: product_d,
                        value: product_d,
                        data: item
                    };
                }));
            }
        });
    },
    autoFocus: true,
    minLength: 0,
    select: function (event, ui) {
        var t_r = ui.item.data[3];
        if ($("#taxformat option:selected").attr('data-trate')) {

            t_r = $("#taxformat option:selected").attr('data-trate');
        }       
        var discount = ui.item.data[4];
        var custom_discount = $('#custom_discount').val();
        if (custom_discount > 0) discount = deciFormat(custom_discount);
        
        
         /* var t_r = data[3];
        var discount = data[4];
        var custom_discount = $('#custom_discount').val();
        if (custom_discount > 0) discount = deciFormat(custom_discount); */
        
        //var purchase_price = ((data[1]*100)/(100+t_r));
        var purchase_price = ((ui.item.data[1]*100)/((100+parseInt(t_r))));
        
        
        $('#amount-0').val(1);
        //$('#price-0').val(ui.item.data[1]);
        $('#price-0').val(purchase_price);
        $('#pid-0').val(ui.item.data[2]);
        $('#vat-0').val(t_r);
        $('#discount-0').val(discount);
        $('#dpid-0').val(ui.item.data[5]);
        $('#unit-0').val(ui.item.data[6]);
        $('#hsn-0').val(ui.item.data[7]);
        $('#alert-0').val(ui.item.data[8]);
        $('#serial-0').val(ui.item.data[10]);
        rowTotal(0);

        billUpyog();
    }
});


$('#addproduct_sparepart_sale').on('click', function () {
    var cvalue = parseInt($('#ganak').val()) + 1;
    var nxt = parseInt(cvalue);
    $('#ganak').val(nxt);
    var functionNum = "'" + cvalue + "'";
    count = $('#saman-row div').length;
    var data = '<tr><td><input type="text" class="form-control" name="product_name[]" placeholder="Enter Product name or Code" id="stock_return-' + cvalue + '"></td><td><input type="text" class="form-control req amnt" name="product_qty[]" id="amount-' + cvalue + '" onkeypress="return isNumber(event)" onkeyup="rowTotal(' + functionNum + '), billUpyog()" autocomplete="off" value="1"  inputmode="numeric"><input type="hidden" id="alert-' + cvalue + '" value=""  name="alert[]"> </td> <td><input type="text" class="form-control req prc" readonly name="product_price[]" id="price-' + cvalue + '" onkeypress="return isNumber(event)" onkeyup="rowTotal(' + functionNum + '), billUpyog()" autocomplete="off" inputmode="numeric"></td><td> <input type="text" class="form-control vat" value="0" name="product_tax[]" readonly id="vat-' + cvalue + '" onkeypress="return isNumber(event)" onkeyup="rowTotal(' + functionNum + '), billUpyog()" autocomplete="off" inputmode="numeric"></td> <td id="texttaxa-' + cvalue + '" class="text-center">0</td> <td><input type="text" class="form-control discount" readonly name="product_discount[]" onkeypress="return isNumber(event)" id="discount-' + cvalue + '" onkeyup="rowTotal(' + functionNum + '), billUpyog()" autocomplete="off"></td> <td><span class="currenty">' + currency + '</span> <strong><span class=\'ttlText\' id="result-' + cvalue + '">0</span></strong></td> <td class="text-center"><button type="button" data-rowid="' + cvalue + '" class="btn btn-danger removeProd" title="Remove" > <i class="fa fa-minus-square"></i> </button> </td><input type="hidden" name="taxa[]" id="taxa-' + cvalue + '" value="0"><input type="hidden" name="disca[]" id="disca-' + cvalue + '" value="0"><input type="hidden" class="ttInput" name="product_subtotal[]" id="total-' + cvalue + '" value="0"> <input type="hidden" class="pdIn" name="pid[]" id="pid-' + cvalue + '" value="0"> <input type="hidden" name="unit[]" id="unit-' + cvalue + '" value=""> <input type="hidden" name="hsn[]" id="hsn-' + cvalue + '" value=""> <input type="hidden" name="serial[]" id="serial-' + cvalue + '" value=""> </tr><tr><td colspan="8"><textarea class="form-control"  id="dpid-' + cvalue + '" name="product_description[]" placeholder="Enter Product description" autocomplete="off"></textarea><br></td></tr>';
     //ajax request
    // $('#saman-row').append(data);
    $('tr.last-item-row').before(data);
    row = cvalue;
    $('#stock_return-' + cvalue).autocomplete({
        source: function (request, response) {
            $.ajax({
                url: baseurl + 'search_products/' + billtype,
                dataType: "json",
                method: 'post',
                data: 'name_startsWith=' + request.term + '&type=product_list&row_num=' + row + '&wid=' + $("#s_warehouses option:selected").val() + '&' + d_csrf,
                success: function (data) {
                    response($.map(data, function (item) {
                        console.log(data);
                        var product_d = item[0];
                        return {
                            label: product_d,
                            value: product_d,
                            data: item
                        };
                    }));
                }
            });
        },
        autoFocus: true,
        minLength: 0,
        select: function (event, ui) {
            id_arr = $(this).attr('id');
            id = id_arr.split("-");
            var t_r = ui.item.data[3];
            if ($("#taxformat option:selected").attr('data-trate')) {
                t_r = $("#taxformat option:selected").attr('data-trate');
            }
            var discount = ui.item.data[4];
            var custom_discount = $('#custom_discount').val();
            if (custom_discount > 0) discount = deciFormat(custom_discount);
            var purchase_price = ((ui.item.data[1]*100)/((100+parseInt(t_r))));
            $('#amount-' + id[1]).val(1);
            $('#price-' + id[1]).val(purchase_price);
            $('#pid-' + id[1]).val(ui.item.data[2]);
            $('#vat-' + id[1]).val(t_r);
            $('#discount-' + id[1]).val(discount);
            $('#dpid-' + id[1]).val(ui.item.data[5]);
            $('#unit-' + id[1]).val(ui.item.data[6]);
            $('#hsn-' + id[1]).val(ui.item.data[7]);
            $('#alert-' + id[1]).val(ui.item.data[8]);
            $('#serial-' + id[1]).val(ui.item.data[10]);
            $('#serial_id-' + id[1]).val(ui.item.data[11]);
            rowTotal(cvalue);
            billUpyog();
        },
        create: function (e) {
            $(this).prev('.ui-helper-hidden-accessible').remove();
        }
    });
});







