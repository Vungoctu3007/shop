function updateProduct() {
    var productId = $('#productId').val();
    var productName = $('#productNameUpdate').val();
    var productRam = $('#ramUpdate').val();
    var productRom = $('#romUpdate').val();
    var productBattery = $('#batteryUpdate').val();
    var productScreen = $('#screenUpdate').val();
    var madeIn = $('#madeInUpdate').val();
    var yearProduce = $('#yearProduceUpdate').val();
    var timeInsurance = $('#timeInsuranceUpdate').val();
    var price = $('#priceUpdate').val();

    $.ajax({
        type: "POST",
        url: `http://localhost/shop/Product_Admin/update`,
        data: {
            product_id: productId,
            product_name: productName,
            product_ram: productRam,
            product_rom: productRom,
            product_battery: productBattery,
            product_screen: productScreen,
            product_made_in: madeIn,
            product_year_produce: yearProduce,
            product_time_insurance: timeInsurance,
            product_price: price
        },
        success: function (response) {
            console.log($page);
            var data = JSON.parse(response);
            if (data.status === 'success') {
                alert("Successfully");
                $('#formUpdateProduct').removeClass('show'); // Remove the 'show' class
                $('body').removeClass('modal-open'); // Remove the class that shows the modal backdrop
                $('.modal-backdrop').remove();
                $('#formUpdateProduct').css('display', 'none');
                location.reload();
                
            }
            else {
                alert(data.message);
            }
        },
        error: function (xhr, status, error) {
            console.error(xhr.responseText);
        }

    });
}
