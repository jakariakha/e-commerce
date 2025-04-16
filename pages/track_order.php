<?php
require_once('../includes/cdn.php');
require_once('../includes/navbar.php');

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Track order</title>
</head>
<body>
<div class="d-flex flex-column justify-content-center align-items-center mt-2">
        <h1 class="d-flex">Track Order</h1>
        <div class="card" style="width: 25rem">
            <div class="card-body">
                <form id="trackOrderForm">
                    <input type="hidden" id="cartItems" name="cartItems">
                    <div class="alert alert-danger alert-dismissible fade show d-none" role="alert">
                        <p>Invaild Order ID or Mobile Number</p>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <div class="mb-3">
                        <label for="number" class="form-label">Order ID</label>
                        <input type="number" class="form-control" id="orderId" name="orderId" placeholder="Enter your order ID">
                        <p class="orderIdAlert text-danger d-none">Order ID is required.</p>
                    </div>
                    <div class="mb-3">
                        <label for="mobile-number" class="form-label">Mobile Number</label>
                        <input type="number" class="form-control" id="mobileNumber" name="mobileNumber" minlength="11" maxlength="11" placeholder="Enter mobile number used during ordering">
                        <p class="mobileNumberAlert text-danger d-none">Mobile number is required.</p>
                    </div>
                    <div class="mb-3 d-flex justify-content-center items-center">
                        <button id="submitButton" class="btn btn-primary w-50">Track order</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

<?php if (isset($_SESSION['flash'])): ?>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <!-- Order Confirmation Card -->
                <div class="card">
                    <div class="card-header text-center">
                        <h3>Order Details</h3>
                    </div>
                    <div class="card-body">
                        <!-- Order Summary -->
                        <div class="mb-4">
                            <h5>Order ID: <?php echo $_SESSION['flash'][0]['id']; ?></h5>
                            <p><strong>Order Status:</strong> <span class="badge bg-secondary"><?php echo $_SESSION['flash'][0]['status']; ?></span></p>
                            <p><strong>Date:</strong><?php echo date('d-m-Y', strtotime($_SESSION['flash'][0]['ordered_at'])); ?></p>
                        </div>

                        <!-- Product List -->
                        <h5 class="mt-4">Products Ordered:</h5>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Product</th>
                                    <th scope="col">Quantity</th>
                                    <th scope="col">Price</th>
                                    <th scope="col">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (isset($_SESSION['flash'])): ?>
                                    <?php foreach($_SESSION['flash'] as $product): ?>
                                    <tr>
                                        <td><?php echo $product['name']; ?></td>
                                        <td><?php echo $product['quantity']; ?></td>
                                        <td>৳<?php echo $product['price']; ?></td>
                                        <td>৳<?php echo $product['price']*$product['quantity']; ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>

                        <!-- Total Amount -->
                        <div class="d-flex justify-content-between mt-4">
                            <h5>Total Amount:</h5>
                            <h5>৳<?php echo $_SESSION['flash'][0]['total_price']; ?></h5>
                        </div>

                        <!-- Address Section -->
                        <div class="mt-4">
                            <h5>Shipping Address:</h5>
                            <p><?php echo $_SESSION['flash'][0]['shipping_address']; unset($_SESSION['flash']); ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>

    <script>
        $(document).ready(function () {
            const trackOrder = (orderId, mobileNumber) => {
                $.ajax({
                    url : '/get-order-details',
                    type : 'POST',
                    data : {
                        'order_id' : orderId,
                        'mobile_number' : mobileNumber
                    },
                    success : (response) => {
                        $('#trackOrderForm')[0].reset();
                        console.log(response);
                        const checkStatus = JSON.parse(response);
                        if (checkStatus.status === 'success') {
                            window.location.href = '/track-order';
                        }
                        if (checkStatus.status === 'failed') {
                            $('.alert').removeClass('d-none');
                        }
                    }

                });
            }

            $('#submitButton').on('click', function (e) {
                e.preventDefault();
                let orderId, mobileNumber;
                orderId = $('#orderId').val();
                mobileNumber = $('#mobileNumber').val();

                if (!orderId){
                    $('.orderIdAlert').removeClass('d-none');
                }
                if (!mobileNumber) {
                    $('.mobileNumberAlert').removeClass('d-none');
                }

                if (orderId && mobileNumber) {
                    trackOrder(orderId, mobileNumber);
                }
            });

            $('#orderId').on('input', function () {
                $('.orderIdAlert').addClass('d-none')
            });

            $('#mobileNumber').on('input', function () {
                $('.mobileNumberAlert').addClass('d-none')
            });

           

        });
    </script>
</body>
</html>