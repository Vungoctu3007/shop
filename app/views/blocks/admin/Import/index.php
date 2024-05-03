<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>

<div class="container-fluid">
    <div class="row">
        <div class="col-2 ">
            <span>Phiếu Nhập Hàng</span>
        </div>
        <div class="col-10">
            <div class="d-flex align-items-center justify-content-between">
                <nav class="search w-50">
                    <div class="d-flex">
                        <input onkeyup="searchByEmployee()" id="search" class="form-control me-2" type="search" placeholder="Tìm Kiếm" aria-label="Search" />
                    </div>
                </nav>
                <div class="d-flex">
                    <div class="dropdown ">
                        <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Thao Tác
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">Xuất Excel</a></li>
                            <li><a class="dropdown-item" href="#">Xuất DPF</a></li>
                        </ul>
                    </div>

                    <a href="<?php echo _WEB_ROOT; ?>/ImportController/ImportGoodReceipt" class="ms-2 btn btn-success">
                        Nhập Hàng
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-2 d-flex">
            <div>
                <label for="start">Từ:</label>
                <input onchange="searchByDate()" class="w-100 border-0" type="date" id="startDate" name="trip-start" value="2024-04-20" min="2018-01-01" max="2030-12-31" />
            </div>
            <div class="ms-4"><label for="start">Đến:</label>
                <input onchange="searchByDate()" class="w-100 border-0" type="date" id="endDate" name="trip-start" value="2024-04-20" min="2018-01-01" max="2030-12-31" />
            </div>
        </div>
        <div class="col-8"></div>
        <div class="col-2">
            <nav aria-label="Page navigation example ">
                <ul class="pagination d-flex justify-content-center ">
                    <li class="page-item">
                        <a onclick="load_prev_page()" class="page-link  text-dark fs-3" href="#" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>
                    <li class="page-item">
                        <span class="page-link text-dark fw-semibold"> <span id="current_page" class="text-primary"></span>/<span id="total_pages"></span></span>
                    </li>
                    <li class="page-item">
                        <a onclick="load_next_page()" class="page-link  text-dark fs-3" href="#" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
    <div class="row">

        <div class="col-12">
            <div id="id"></div>
            <table id="load_data" class="table table-striped">
                <thead>
                    <tr>
                        <th> <input type="checkbox" id="huey" name="drone" value="huey" checked /></th>
                        <th>Mã Nhập Hàng</th>
                        <th>Ngày Nhập</th>
                        <th>Nhà Cung Cấp</th>
                        <th>Tổng Tiền</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>


        </div>
    </div>
</div>
<!-- modal detail -->
<div class="modal fade" id="modal_detail" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Thông Tin Phiếu Nhập</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="container">
                <div class="row ">
                    <div class="col-2">
                        <span>Mã nhập hàng:</span>
                    </div>
                    <div class="col-2">
                        <input type="number" step="" value="" id="detail_good_id" name="detail_good_id" disabled class=" border-0 border-bottom border-dark text-center w-100">
                    </div>
                    <div class="col-2">
                        <span>Ngày nhập:</span>
                    </div>
                    <div class="col-4">
                        <input type="" step="" max="10" value="" id="detail_good_date " name="detail_good_date" disabled class=" border-0 border-bottom border-dark text-center w-50">
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-2">
                        <span>Người tạo:</span>
                    </div>
                    <div class="col-2">
                        <input type="" step="" max="10" value="" id="detail_person" name="detail_person" disabled class=" border-0 border-bottom border-dark text-center w-100">
                    </div>
                </div>
                <div class="row mt-2">
                    <div style="height: 300px;  overflow: auto" class="container">
                        <table id="load_data_detail_good" class="table table-striped ">
                            <thead>
                                <div style=" max-height: 100%; overflow: auto;">
                                    <tr>
                                        <th>Mã sản phẩm</th>
                                        <th>Tên sản phẩm</th>
                                        <th>số lượng</th>
                                        <th>Đơn giá</th>
                                        <th>Thành tiền</th>
                                    </tr>
                                </div>

                            </thead>
                            <tbody style="overflow: auto;">

                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-8"></div>
                    <div class="col-4">
                        <div class="row">
                            <div class="col-5">
                                <span>Tổng số lượng:</span>
                            </div>
                            <div class="col-5">
                                <span id="total_quantity"></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-5">
                                <span >Tổng mặt hàng:</span>
                            </div>
                            <div class="col-5">
                                <span id="total_product"></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-5">
                                <span>Tổng Tiền:</span>
                            </div>
                            <div class="col-5">
                                <span id="total_good"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                <button type="button" onclick="" class="btn btn-primary">Xuất file</button>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        load_data();
    });
</script>
<script>
    let currentPage = 1
    let total_page = 0

    function create_table(data) {
        $('#load_data tbody').empty();
        data.forEach(item => {
            $('#load_data tbody').append(`
              <tr>
               
                <td>${item.good_receipt_id}</td>
                <td>${item.date_good_receipt}</td>
                <td>${item.supplier_id}</td>
                <td>${item.total}</td>
              
                <td>
                    <button onclick="detail('${item.good_receipt_id}')" class="btn">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
                            <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8M1.173 8a13 13 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5s3.879 1.168 5.168 2.457A13 13 0 0 1 14.828 8q-.086.13-.195.288c-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5s-3.879-1.168-5.168-2.457A13 13 0 0 1 1.172 8z"/>
                            <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5M4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0"/>
                        </svg>
                    </button>
                </td>
              </tr>
            
            `)
        })
    }

    function load_data() {
        $.ajax({
            url: `http://localhost/php/shop/ImportController/getAll?page=${currentPage}`,
            method: "GET",
            page: {
                currentPage
            },
            success: function(data) {
                create_table(data.data)
                total_page = data.total_page
                updatePagination();
            }
        });
    }

    function updatePagination() {
        $('#current_page').text(currentPage);
        $('#total_pages').text(total_page);
    }

    function load_next_page() {
        currentPage++;
        if (currentPage > total_page) {
            currentPage = 1
        }
        load_data();
    }

    function load_prev_page() {
        currentPage--;
        if (currentPage < 1) {
            currentPage = 1
        }
        load_data();
    }

    function debounce(callback, delay) {
        let timer;
        return (...args) => {
            clearTimeout(timer);
            timer = setTimeout(() => {
                callback(...args);
            }, delay);
        }
    }

    const debounceSearch = debounce(search, 1000);

    function searchByEmployee() {

        $.ajax({
            url: `http://localhost/php/shop/ImportController/searchGoodReceipt`,
            method: 'POST',
            data: {
                searchInput: $('#search').val(),
            },
            success: function(data) {
                create_table(data.data);
            }
        })
    }

    function searchByDate() {
        $.ajax({
            url: 'http://localhost/php/shop/ImportController/searchGoodReceiptByDate',
            method: 'POST',
            data: {
                startDate: $('#startDate').val(),
                endDate: $('#endDate').val()
            },
            success: function(data) {
                create_table(data.data);
            }
        })

    }



    // $('#modal_detail').modal('show');
    // document.querySelector('input[name="detail_good_id"]').value=data.good_receipt_id.toFixed(2)
    // document.querySelector('input[name="detail_good_date"]').value=data.date_good_receipt.toFixed(2)
    // document.querySelector('input[name="detail_person"]').value=data.employee_name.toFixed(2)
    function detail(id) {
        $.ajax({
            url: "http://localhost/php/shop/ImportController/getAllDetailGoodById",
            method: 'POST',
            data: {
                id: id
            },
            success: function(data) {
                // total_quantity
                //         total_good
                //         total_product
                console.log(data.data_good.mathang)
                console.log(data.data_good.total)
                console.log(data.data_good.quantity_sum)
                document.querySelector('input[name="detail_good_id"]').value = data.data_good.good_receipt_id
                document.querySelector('input[name="detail_good_date"]').value = data.data_good.date_good_receipt
                document.querySelector('input[name="detail_person"]').value = data.data_good.employee_name

                var totalValue = data.data_good.total;
                var formattedTotal = totalValue.toLocaleString('vi-VN');
                var totalWithUnits = formattedTotal + " VND";
                document.getElementById("total_quantity").innerText = data.data_good.quantity_sum;
                document.getElementById("total_good").innerText = totalWithUnits;
                document.getElementById("total_product").innerText = data.data_good.mathang;

                $('#modal_detail').modal('show');
                $('#load_data_detail_good tbody').empty();
                data.data.forEach(item => {
                    $('#load_data_detail_good tbody').append(`
                    <tr>
                        <td>${item.product_id}</td>
                        <td>${item.product_name}</td>
                        <td>${item.quantity}</td>
                        <td>${item.price}</td>
                        <td>${item.quantity*item.price}</td>
                    </tr>
                    `)
                })
            }
        })
    }
</script>