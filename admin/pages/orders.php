<?php
require_once('../includes/cdn.php');
require_once('../admin/includes/navbar.php');
require_once('../admin/includes/isLoggedIn.php');
require_once('../config/database.php');

$sql = "select * from orders";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $orders = [];
    while ($row = $result->fetch_assoc()) {
        $orders[] = $row;
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All orders</title>
</head>
<body>
    <?php if (isset($_SESSION['flash'])): ?>
        <div class="alert alert-<?php echo ($_SESSION['flash']['status'] === 'failed') ? 'danger' : $_SESSION['flash']['status']?> alert-dismissible fade show" role="alert">
            <?php echo $_SESSION['flash']['message']; unset($_SESSION['flash']) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Name</th>
                        <th scope="col">Mobile Number</th>
                        <th scope="col">Total Price</th>
                        <th scope="col">Status</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (isset($orders)): ?>
                        <?php foreach($orders as $order): ?>
                            <tr>
                                <th scope="row"><?php echo $order['id']; ?></th>
                                <th scope="row"><?php echo $order['customer_name']; ?></th>
                                <th scope="row"><?php echo $order['mobile_number']; ?></th>
                                <th scope="row"><?php echo $order['total_price']; ?></th>
                                <th scope="row"><span class="badge text-bg-secondary"><?php echo $order['status']; ?></span></th>
                                <th scope="row">
                                    <div class="d-flex flex-wrap gap-2">
                                        <a class="btn btn-success mb-2" href="/admin/orders/<?php echo $order['id']; ?>">
                                        <i class="fa-solid fa-eye"></i>
                                        </a>
                                        <button data-order-id="<?php echo $order['id']; ?>" class="deleteButton btn btn-danger mb-2" data-bs-toggle="modal" data-bs-target="#deleteModal">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </div>
                                </th>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>

<!-- Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Delete order</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <h5>Are you sure to delete this order?</h5>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="finalDeleteButton btn btn-danger">Delete</button>
      </div>
    </div>
  </div>
</div>
<script>
    $(document).ready(function() {
        var orderId;
       
        const deleteOrder = (orderId) => {
            console.log('/admin/orders/delete/'+orderId);
            $.ajax({
                url : '/admin/orders/delete/'+orderId,
                type : 'POST',
                data : {
                    'order_id' : orderId
                },
                success : (response) => {
                    window.location.href = '/admin/orders';
                }

            });
        }

        $('.deleteButton').off('click').click(function() {
            orderId = $(this).data('order-id');
            console.log(orderId);
        });

        $('.finalDeleteButton').off('click').click(function() {
            deleteOrder(orderId);
        });
    });

    
</script>
</body>
</html>