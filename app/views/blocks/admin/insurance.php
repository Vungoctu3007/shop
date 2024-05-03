<div class="col-auto d-flex mb-5 justify-content-around" >
    <div class="d-flex">
        <input style="width: 300px; margin-right: 10px;" type="text" class="form-control" placeholder="Search Insurance"
            aria-label="Search Insurance" aria-describedby="search-insurance-icon" id="search-insurance-input"
            onkeyup="searchInsurance()">
        <div class="input-group-append">
            <button class="btn btn-danger" onclick="searchInsurance()">Search</button>
        </div>
    </div>
    <div > <!-- Chuyển nút "Create" ra ngoài cùng bên lề phải -->
        <button class="btn btn-primary" onclick="createInsurance()">Create</button>
    </div>
</div>




<div class="container" id="allInsurance">
    <table class="table table-striped text-center">
        <thead>
            <tr>
                <th>Insurance ID</th>
                <th>Order ID</th>
                <th>Employee's Name</th>
                <th>Customer's Name</th>
                <th>Product Seri</th>
                <th>Equipment Replacement</th>
                <th>Cost</th>
                <th>Status Insurance</th>
                <th>Operations</th>
            </tr>
        </thead>
        <tbody id="contentDataInsurance">
        </tbody>
    </table>
</div>