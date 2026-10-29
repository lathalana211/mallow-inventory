
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Store Billing - New Order</title>

    <!-- Bootstrap CSS -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <style>
        body {
            background: #f4f6f9;
            font-family: Arial, sans-serif;
            color: #263445;
        }

        .billing-container {
            max-width: 1150px;
            margin: 35px auto;
            padding: 0 18px;
        }

        .page-header {
            background: #1e293b;
            color: white;
            padding: 18px 22px;
            border-radius: 8px;
            margin-bottom: 25px;
        }

        .page-header h4 {
            margin: 0;
            font-size: 21px;
            font-weight: 600;
        }

        .section-title {
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 12px;
        }

        .form-control,
        .form-select {
            border-color: #cbd5e1;
            min-height: 40px;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.12);
        }

        .billing-table {
            background: white;
            border: 1px solid #cbd5e1;
            border-radius: 7px;
            overflow: hidden;
        }

        .billing-table th {
            background: #e2e8f0;
            font-size: 13px;
            white-space: nowrap;
        }

        .billing-table td {
            vertical-align: middle;
            font-size: 14px;
        }

        .low-stock-card {
            background: #fffbeb;
            border: 1px solid #f4bd55;
            border-radius: 7px;
            padding: 17px;
            min-height: 200px;
        }

        .low-stock-card h6 {
            color: #92400e;
            font-weight: 700;
        }

        .low-stock-card ul {
            padding-left: 18px;
            margin-bottom: 0;
        }

        .low-stock-card li {
            color: #78350f;
            font-size: 13px;
            margin-bottom: 10px;
        }

        .payment-card {
            background: white;
            border: 1px solid #cbd5e1;
            border-radius: 7px;
            padding: 20px;
        }

        .payment-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 13px;
            font-size: 14px;
        }

        .grand-total {
            border-top: 1px dashed #cbd5e1;
            padding-top: 14px;
            font-size: 18px;
            font-weight: 700;
        }

        .btn-add {
            background: #337ab7;
            color: white;
        }

        .btn-add:hover {
            background: #286090;
            color: white;
        }

        .btn-generate {
            background: #15803d;
            color: white;
            min-height: 44px;
            font-weight: 600;
        }

        .btn-generate:hover {
            background: #166534;
            color: white;
        }

        @media (max-width: 767px) {
            .billing-container {
                margin-top: 15px;
            }

            .page-header h4 {
                font-size: 18px;
            }

            .billing-table {
                overflow-x: auto;
            }
        }

        #low-stock-list {
    max-height: 210px;
    overflow-y: auto;
    overflow-x: hidden;
    padding-right: 8px;
}

#low-stock-list::-webkit-scrollbar {
    width: 6px;
}

#low-stock-list::-webkit-scrollbar-thumb {
    background: #b8b8b8;
    border-radius: 10px;
}

#low-stock-list::-webkit-scrollbar-track {
    background: #f1f1f1;
}
    </style>
</head>

<body>

<div class="billing-container">

    <!-- Page Header -->
    <div class="page-header">
        <h4>Store Billing — New Order</h4>
        <small class="text-light">Order & Inventory Management</small>
    </div>

    <!-- Customer Section -->
    <div class="mb-4">
        <h6 class="section-title">Customer</h6>

        <div class="row g-3">
            <div class="col-md-4">
                <label for="customerEmail" class="form-label">
                    Email
                </label>
                <input
                    type="email"
                    id="customerEmail"
                    class="form-control"
                    placeholder="e.g. customer@example.com"
                    name="customer_email"
                >
            </div>

            <div class="col-md-4">
                <label for="customerName" class="form-label">
                    Name
                </label>
                <input
                    type="text"
                    id="customerName"
                    class="form-control"
                    placeholder="Customer name"
                    name="customer_name"

                >
            </div>
        </div>
    </div>

    <!-- Products and Low Stock -->
    <div class="row g-4">

        <div class="col-lg-8">
            <h6 class="section-title">Products</h6>

            <div class="billing-table">
                <table class="table table-bordered mb-0">
                    <thead>
                        <tr>
                            <th style="width: 45%;">Product</th>
                            <th style="width: 15%;">Qty</th>
                            <th style="width: 18%;">Price</th>
                            <th style="width: 22%;">Line Total</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr>
                            <td colspan="4" class="text-center text-muted py-4">
                                Products will appear here.
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="text-end mt-3">
                <button type="button" class="btn btn-add btn-sm">
                    + Add Product
                </button>
            </div>
        </div>

        <!-- Low Stock Alert -->
        <div class="col-lg-4">
            <div class="low-stock-card">
                <h6>⚠ Low Stock Alert</h6>
                <div id="low-stock-list">
                    <p class="text-muted mb-0">Loading low-stock products...</p>
                </div>
            </div>
        </div>

    </div>

    <!-- Payment Section -->
    <div class="mt-4">
        <h6 class="section-title">Payment</h6>

        <div class="row g-4">
            <div class="col-lg-5">
                <div class="payment-card">

                    <div class="payment-row">
                        <span>Subtotal</span>
                        <span id="subtotal-value">₹0.00</span>
                    </div>

                    <div class="payment-row">
                        <span>Tax</span>
                        <span id="tax-value">₹0.00</span>
                    </div>

                    <div class="payment-row grand-total">
                        <span>Grand Total</span>
                        <span id="grand-total-value">₹0.00</span>
                    </div>

                    <div class="mt-3">
                        <label for="amountGiven" class="form-label">
                            Amount Given by Customer
                        </label>

                        <input
                            type="number"
                             id="amount-given"
                            class="form-control"
                            min="0"
                            step="0.01"
                            placeholder="Enter amount"
                        >
                    </div>

                    <div class="payment-row mt-3 mb-0" >
                        <span>Balance to Return</span>
                        <span id="balance-return">₹0.00</span>
                    </div>

                </div>
            </div>

            <div class="col-lg-3">
                <button
                    type="button"
                    class="btn btn-generate w-100"
                    id="generate-bill"
                >
                    Generate Bill
                </button>

                <small class="text-muted d-block mt-2">
                    Creates the order and updates inventory.
                </small>
            </div>
        </div>
    </div>

</div>

<script>
    let availableProducts = [];

    // Load products from Laravel API
    async function loadProducts() {
        try {
            const response = await fetch('/api/products');

            if (!response.ok) {
                throw new Error('Unable to load products');
            }

            const data = await response.json();
            availableProducts = data.products;

        } catch (error) {
            console.error(error);
            alert('Could not load products. Please check the API.');
        }
    }

    // Create one product row
    function addProductRow() {
        const tbody = document.querySelector('.billing-table tbody');

        // Remove the placeholder row
        if (
            tbody.children.length === 1 &&
            tbody.querySelector('td[colspan="4"]')
        ) {
            tbody.innerHTML = '';
        }

        const row = document.createElement('tr');

        const productOptions = availableProducts.map(product => {
            const disabled = product.stock_on_hand < 1 ? 'disabled' : '';

            return `
                <option value="${product.id}" ${disabled}>
                    ${product.name} (${product.code}) - Stock: ${product.stock_on_hand}
                </option>
            `;
        }).join('');

        row.innerHTML = `
            <td>
                <select class="form-select product-select">
                    <option value="">Select product</option>
                    ${productOptions}
                </select>
            </td>
            <td>
                <input
                    type="number"
                    class="form-control quantity-input"
                    value="1"
                    min="1"
                    step="1"
                >
            </td>
            <td class="price-cell">₹0.00</td>
            <td>
                <span class="line-total">₹0.00</span>
                <button
                    type="button"
                    class="btn btn-sm btn-outline-danger remove-product ms-1"
                    aria-label="Remove product"
                >×</button>
            </td>
        `;

        tbody.appendChild(row);

        row.querySelector('.product-select')
            .addEventListener('change', () => updateProductRow(row));

        row.querySelector('.quantity-input')
            .addEventListener('input', () => updateProductRow(row));

        row.querySelector('.remove-product')
            .addEventListener('click', () => {
                row.remove();

                if (tbody.children.length === 0) {
                    tbody.innerHTML = `
                        <tr>
                            <td colspan="4" class="text-center text-muted py-4">
                                No products added.
                            </td>
                        </tr>
                    `;
                }

                calculateTotals();
            });
    }

    // Update price and line total
    function updateProductRow(row) {
        const productId = row.querySelector('.product-select').value;
        const quantityInput = row.querySelector('.quantity-input');
        const product = availableProducts.find(
            item => String(item.id) === productId
        );

        if (!product) {
            row.querySelector('.price-cell').textContent = '₹0.00';
            row.querySelector('.line-total').textContent = '₹0.00';
            calculateTotals();
            return;
        }

        const quantity = Number(quantityInput.value);

        row.querySelector('.price-cell').textContent =
            '₹' + Number(product.price).toFixed(2);

        const lineTotal = Number(product.price) *
            (Number.isInteger(quantity) && quantity > 0 ? quantity : 0);

        row.querySelector('.line-total').textContent =
            '₹' + lineTotal.toFixed(2);

        calculateTotals();
    }

    // Calculate subtotal and tax for display
    function calculateTotals() {
        let subtotal = 0;
        let taxTotal = 0;

        document.querySelectorAll('.billing-table tbody tr').forEach(row => {
            const productId = row.querySelector('.product-select')?.value;
            const quantity = Number(
                row.querySelector('.quantity-input')?.value
            );

            const product = availableProducts.find(
                item => String(item.id) === productId
            );

            if (product && Number.isInteger(quantity) && quantity > 0) {
                const lineSubtotal = Number(product.price) * quantity;
                subtotal += lineSubtotal;
                taxTotal += lineSubtotal *
                    Number(product.tax_percentage) / 100;
            }
        });

        const formatCurrency = value =>
            '₹' + value.toFixed(2);

        const grandTotal = subtotal + taxTotal;
        const amountGiven = Number(
            document.getElementById('amount-given')?.value || 0
        );
        const balance = Math.max(0, amountGiven - grandTotal);

        document.getElementById('subtotal-value').textContent =
            formatCurrency(subtotal);

        document.getElementById('tax-value').textContent =
            formatCurrency(taxTotal);

        document.getElementById('grand-total-value').textContent =
            formatCurrency(grandTotal);

        document.getElementById('balance-return').textContent =
            formatCurrency(balance);
    }

    // Connect Add Product button
    document.querySelector('.btn-add').addEventListener('click', () => {
        if (availableProducts.length === 0) {
            alert('No products loaded yet. Please wait or reload the page.');
            return;
        }

        addProductRow();
    });



    async function loadLowStockProducts() {
    const container = document.getElementById('low-stock-list');

    try {
        const response = await fetch('/api/products/low-stock?threshold=10');

        if (!response.ok) {
            throw new Error('Unable to load low-stock products');
        }

        const data = await response.json();

        if (data.products.length === 0) {
            container.innerHTML =
                '<p class="text-success mb-0">All products have sufficient stock.</p>';
            return;
        }

        container.innerHTML = data.products.map(product => `
            <div class="border-bottom py-2">
                <div class="fw-semibold">${product.name}</div>
                <small class="text-muted">
                    Code: ${product.code}
                </small>
                <div class="text-danger small">
                    Stock remaining: ${product.stock_on_hand}
                </div>
            </div>
        `).join('');
    } catch (error) {
        container.innerHTML =
            '<p class="text-danger mb-0">Unable to load stock alerts.</p>';
    }
}

    // Load products when page opens
    document.addEventListener('DOMContentLoaded', () => {
    loadProducts();
    loadLowStockProducts();
});
document.getElementById('amount-given')
    ?.addEventListener('input', calculateTotals);


    // Generate Bill button click handler

    
document.getElementById('generate-bill').addEventListener('click', async function () {
    const customerName = document.querySelector('[name="customer_name"]')?.value.trim();
    const customerEmail = document.querySelector('[name="customer_email"]')?.value.trim();

    if (!customerName || !customerEmail) {
        alert('Please enter the customer name and email.');
        return;
    }

    const items = [];

    document.querySelectorAll('.billing-table tbody tr').forEach(row => {
        const productId = row.querySelector('.product-select')?.value;
        const quantity = Number(row.querySelector('.quantity-input')?.value);

        if (productId && Number.isInteger(quantity) && quantity > 0) {
            items.push({
                product_id: Number(productId),
                quantity: quantity
            });
        }
    });

    if (items.length === 0) {
        alert('Please add at least one product.');
        return;
    }

    try {
        const response = await fetch('/api/orders', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                customer: {
                    name: customerName,
                    email: customerEmail
                },
                items: items
            })
        });

        const data = await response.json();

        if (!response.ok) {
            const message = data.message || 'Could not create the order.';
            alert(message);
            return;
        }

        alert('Bill generated successfully! Order ID: ' + data.order.id);

        // Refresh products to show updated stock.
        await loadProducts();
        await loadLowStockProducts();

    } catch (error) {
        console.error(error);
        alert('Unable to connect to the server. Please try again.');
    }
});

</script>
</body>

</html>
