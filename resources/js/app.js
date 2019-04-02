$(document).ready(function(){
    $('#add_product').click(function() {
        var index = $('#tbl_products tbody tr').length + 1;
        var row = $('#prod-1').html().replace(/-1/g, '-' + index).replace('d-none', 'd-block');
        $('#tbl_products').append('<tr id="prod-' + index + '"></tr>');
        $('#prod-' + index).html(row).find('td:first-child').html(index);
        resetValues(index);
    });
    $('.btn-delete-product').on('click', deleteProductRow);
    
    $('#add_payment_type').click(function(){
        var index = $('#tbl_payment_type tbody tr').length + 1;
        var row = $('#ptype-1').html().replace(/-1/g, '-' + index).replace('d-none', 'd-block');;
        $('#tbl_payment_type').append('<tr id="ptype-' + index + '"></tr>');
        $('#ptype-' + index).html(row).find('td:first-child').html(index);
        $('#payment_type-' + index).val('');
        $('#amount-' + index).val('');
        $('#delete_payment_type-' + index).on('click', deletePtypeRow);
    });
    $('.btn-delete-ptype').on('click', deletePtypeRow);
    
    $('#product-1').on('change', getProductDetails);
    $('.quantity, .unit_price').on('keyup change', calcTotalPrice);
    $('#tax_percent').on('keyup change', calcGrandTotal);
});

function getProductDetails(){
    var idArr = (this.id).split('-');
    jQuery.ajax({
        url: '/product/' + $('#product-' + idArr[1]).val(),
        method: 'get',
        success: function(result) {
            $('#quantity-' + idArr[1]).val(1);
            $('#unit_price-' + idArr[1]).val(result.price);
            calcTotalPrice();
        }
    });
}

function calcTotalPrice() {
    $('#tbl_products tbody tr').each(function(i, element) {
        var quantity = $(this).find('.quantity').val();
        var unit_price = $(this).find('.unit_price').val();
        var total_price = quantity * unit_price;
        $(this).find('.total_price').val(total_price.toFixed(2));
        calcGrandTotal();
    });
}

function resetValues(index) {
    $('#product-' + index).val('');
    $('#quantity-' + index).val('');
    $('#unit_price-' + index).val('');
    $('#product-' + index).on('change', getProductDetails);
    $('#delete_product-' + index).on('click', deleteProductRow);
    $('.quantity, .unit_price').on('keyup change', calcTotalPrice);
    calcTotalPrice();
}

function deleteProductRow() {
    var idArr = (this.id).split('-');
    $("#prod-" + idArr[1]).remove();
    $('#tbl_products tbody tr').each(function(i) {
        $(this).find('td:first-child').html(i + 1);
    });
    calcTotalPrice();
}

function deletePtypeRow() {
    var idArr = (this.id).split('-');
    $("#ptype-" + idArr[1]).remove();
    $('#tbl_payment_type tbody tr').each(function(i) {
        $(this).find('td:first-child').html(i + 1);
    });
}

function calcGrandTotal() {
    var total = 0;
    $('.total_price').each(function() {
        total += parseInt($(this).val());
    });
    $('#sub_total').val(total.toFixed(2));

    var tax_amount = total / 100 * $('#tax_percent').val();
    $('#tax_amount').val(tax_amount.toFixed(2));
    $('#grand_total').val((tax_amount + total).toFixed(2));
}