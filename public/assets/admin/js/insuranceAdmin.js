$(function () {
    load_data(currentPage)
});

function load_data(page) {
    $.ajax({
        url: `http://localhost/shop/Insurance_Admin/kiadData?page=${page}`,
        method: "GET",
        success: function (data) {
            create_table(data.data);
        }
    })
}

function create_table(data) {
    $('#contentDataInsurance').empty();

    if (Array.isArray(data)) {
        data.forEach(item => {
            $('#contentDataInsurance'), append(`
                <tr>
                    <td>${item.insurance_id}</td>
                    <td>${item.order_id}</td>
                    <td>${item.employee_name}</td>
                    <td>${item.customer_name}</td>
                    <td>${item.product_seri}</td>
                    <td>${item.equipment_replacement}</td>
                    <td>${item.cost}</td>
                    <td>${item.status_insurance}</td>
                    <td>
                        <button class='btn btn-primary me-1 mb-3 w-100 mt-3' data-bs-toggle='modal' data-bs-target='#formDetailInsurance' onclick='openDetailModal(${item.id || item.insurance_id})'>Detail</button>
                        <button class='btn btn-primary me-1 mb-3 w-100 mt-3' data-bs-toggle='modal' data-bs-target='#formUpdateInsurance' onclick='openUpdateModal(${item.id || item.insurance_id})'>Update</button>
                    </td>


                </tr>
            `)
        })
    }
}