<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Chi Tiết Sản Phẩm Trong Hóa Đơn</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f4;
        }

        .product-details {
            background-color: #fff;
            padding: 15px;
            border-radius: 5px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            max-width: 300px;
            margin: 20px auto;
        }

        .product-details h3 {
            color: #333;
            text-align: center;
        }

        .product-details dl {
            padding: 0;
            margin: 0;
        }

        .product-details dt {
            background: #f0ad4e;
            color: white;
            padding: 5px;
            margin-top: 10px;
        }

        .product-details dd {
            padding: 5px;
            margin: 0;
            border-bottom: 1px solid #eee;
        }

        .btn-close {
            display: block;
            width: 100px;
            margin: 20px auto;
            text-align: center;
            padding: 10px;
            background-color: #d9534f;
            color: white;
            border: none;
            border-radius: 5px;
            text-decoration: none;
        }

        .btn-close:hover {
            background-color: #c9302c;
        }
    </style>
</head>
<body>
    
    <div class="product-details">
        <h3>Chi Tiết Sản Phẩm</h3>
        <?php if (isset($product_details) && !empty($product_details)): ?>
            <dl>
                <?php foreach ($product_details as $detail): ?>
                    <dt>ID Sản Phẩm</dt>
                    <dd><?= htmlspecialchars($detail['product_id']) ?></dd>
                    <dt>Tên Sản Phẩm</dt>
                    <dd><?= htmlspecialchars($detail['product_name']) ?></dd>
                    <dt>Giá Sản Phẩm</dt>
                    <dd><?= htmlspecialchars($detail['product_price']) ?></dd>
                    <dt>RAM</dt>
                    <dd><?= htmlspecialchars($detail['product_ram']) ?></dd>
                    <dt>ROM</dt>
                    <dd><?= htmlspecialchars($detail['product_rom']) ?></dd>
                    <dt>Màn Hình</dt>
                    <dd><?= htmlspecialchars($detail['product_screen']) ?></dd>
                <?php endforeach; ?>
            </dl>
        <?php else: ?>
            <p>Không có thông tin chi tiết sản phẩm cho hóa đơn này.</p>
        <?php endif; ?>
        <a href="<?= _WEB_ROOT ?>/bill" class="btn-close">Đóng</a>

    </div>
    
</body>
</html>
