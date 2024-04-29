save_product.addEventListener('click', function() {
    const loadDataBody = document.querySelector('#load_data tbody');
    const productIds = document.querySelectorAll('.product_id:checked');
    console.log('1,2,3')
    productIds.forEach((item, index) => {
        const productRow = item.closest('tr');
        const productId = productRow.querySelector('td:nth-child(2)').textContent;
        const productName = productRow.querySelector('td:nth-child(3)').textContent;
        const productCount = productRow.querySelector('td:nth-child(4)').textContent;
        const categoryId = productRow.querySelector('td:nth-child(5)').textContent;

        const existingProductRow = $('#load_data tbody').find(`td:contains(${productId})`).closest('tr');

        if (existingProductRow.length) {
            const existingQuantity = parseInt(existingProductRow.find('.quantity').val());
            existingProductRow.find('.quantity').val(existingQuantity + 1);
            updateTotal(existingProductRow[0]);
        } else {
            loadDataBody.innerHTML += `
                <tr>
                    <td>${productId}</td>
                    <td>${productName}</td>
                    <td>
                        <input type="button" value="-" class="button_quantity button_minus border icon-shape icon-sm mx-1 decrease-quantity">
                        <input type="number" step="1" value="1" class="quantity border-0 text-center w-50">
                        <input type="button" value="+" class="button_quantity button_plus border icon-shape icon-sm increase-quantity">
                    </td>
                    <td>
                        <input type="text" placeholder="seri bắt đầu" value="" name="seri_start" class="seri_start border-0 border-bottom border-danger text-center w-50">
                        <input type="text" placeholder="seri kết thúc" value="" name="seri_end" class="seri_end border-0 border-bottom border-danger text-center w-50">
                    </td>
                    <td>
                        <input type="number" step="0.01" max="10" value="" name="price" class="price border-0 border-bottom border-danger text-center w-100">
                    </td>
                    <td>
                        <input type="number" step="0.01" max="10" value="" name="total" class="total border-0 border-bottom border-danger text-center w-100" disabled>
                    </td>
                </tr>
            `;
        }
    });
});

// Add event listeners for dynamically created elements
document.addEventListener('click', function(event) {
    if (event.target.classList.contains('increase-quantity')) {
        const row = event.target.closest('tr');
        increaseQuantity(row);
    }
});

document.addEventListener('keyup', function(event) {
    if (event.target.classList.contains('price') || event.target.classList.contains('quantity')) {
        const row = event.target.closest('tr');
        updateTotal(row);
    }
});