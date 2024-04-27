let currentPage = 1;
let total_page = 0;

$(function() {
    load_data(currentPage);
});

function load_next_page() {
    currentPage++;
    if (currentPage > total_page) {
        currentPage = total_page;
    }
    load_data(currentPage);
}

function load_prev_page() {
    currentPage--;
    if (currentPage < 1) {
        currentPage = 1;
    }
    load_data(currentPage);
}

function load_data(page) {
    $.ajax({
        url: `http://localhost/shop/Product_Admin/loadData?page=${page}`,
        method: "GET",
        success: function(data) {
            create_table(data.data);
            total_page = data.total_page;
            updatePagination();
        }
    });
}

function updatePagination() {
    $('#current_page').text(currentPage);
    $('#total_pages').text(total_page);
    $('#pagination').empty();
    for (let i = 1; i <= total_page; i++) {
        $('#pagination').append(`<li class="page-item"><a class="page-link" href="#" onclick="load_data(${i})">${i}</a></li>`);
    }
}

function create_table(data) {
    $('#contentDataProduct').empty();
    
    if (Array.isArray(data)) {
        data.forEach(item => {
            $('#contentDataProduct').append(`
                <tr>
                    <td><img src='../public/assets/clients/img/${item.product_image}' alt='Product Image' style='width:130px; height:auto'></td>
                    <td>${item.category_name}</td>
                    <td>${item.product_name}</td>
                    <td>${item.stock || item.quantity}</td>
                    <td>${item.made_in || item.product_made_in}</td>
                    <td>${item.year_produce || item.product_year_produce}</td>
                    <td>${item.time_insurance || item.product_time_insurance}</td>
                    <td>${item.price || item.product_price}</td>
                    <td>
                        <button class='btn btn-primary me-1 mb-3 w-100 mt-3' data-bs-toggle='modal' data-bs-target='#formDetailProduct' onclick='openDetailModal(${item.id || item.product_id})'>Detail</button>
                        <button class='btn btn-primary me-1 mb-3 w-100 mt-3' data-bs-toggle='modal' data-bs-target='#formUpdateProduct' onclick='openUpdateModal(${item.id || item.product_id})'>Update</button>
                    </td>
                </tr>
            `);
        });
    } else {
        console.error('Data is not an array');
    }
}
