<div class="container" id="allProduct">
    <table class="table table-striped text-center">
        <thead>
            <tr>
                <th>Image</th>
                <th><?php echo ucfirst('Category Name'); ?></th>
                <th>Product Name</th>
                <th>Stock</th>
                <th>Made In</th>
                <th>Year Produce</th>
                <th>Time Insurance(Month)</th>
                <th>Price</th>
                <th>Operations</th>
            </tr>
        </thead>
        <tbody id="contentDataProduct">
            
        </tbody>
    </table>

    <!-- Pagination -->
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


<!-- Detail Modal -->
<div class="modal" id="formDetailProduct" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailModalLabel">Product Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="productDetails" class="text-center"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" loadProductTable()>Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Update Modal -->
<div class="modal" id="formUpdateProduct" tabindex="-1" aria-labelledby="updateProductModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateProductModalLabel">Update Product</h5>
            </div>
            <div class="modal-body">
                <div id="productUpdates" class="text-center"></div>
                <input type="hidden" id="productId">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-secondary" onclick="updateProduct()">Update</button>
            </div>
        </div>
    </div>
</div>
