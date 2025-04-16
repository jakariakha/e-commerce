<?php
require_once('../includes/cdn.php');
require_once('../admin/includes/navbar.php');
require_once('../admin/includes/isLoggedIn.php');
require_once('../config/database.php');

$sql = "select * from customers";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $customers = [];
    while ($row = $result->fetch_assoc()) {
        $customers[] = $row;
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All customers</title>
</head>
<body>
    <div class="p-2">
        <a class="btn btn-primary rounded-lg" href="/admin/customers/create">Create Customers</a>
    </div>
    
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
                        <th scope="col">Email</th>
                        <th scope="col">Role</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (isset($customers)): ?>
                        <?php foreach($customers as $customer): ?>
                            <tr>
                                <th scope="row"><?php echo $customer['id']; ?></th>
                                <th scope="row"><?php echo $customer['name']; ?></th>
                                <th scope="row"><?php echo $customer['email']; ?></th>
                                <th scope="row"><?php echo $customer['role']; ?></th>
                                <th scope="row">
                                    <div class="d-flex flex-wrap gap-2">
                                        <a class="btn btn-success mb-2" href="/admin/customers/edit/<?php echo $customer['id']; ?>">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </a>
                                        <button class="deleteButton btn btn-danger mb-2" data-customer-id="<?php echo $customer['id']; ?>" data-bs-toggle="modal" data-bs-target="#exampleModal">
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
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Delete customer</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <h5>Are you sure to delete this customer?</h5>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button id="finalDeleteButton" type="button" class="btn btn-danger">Delete</button>
      </div>
    </div>
  </div>
</div>
<script>
    $(document).ready(function() {
        var customerId;
        const deletecustomer = (customerId) => {
            console.log('/admin/customers/delete/'+customerId);
            $.ajax({
                url : '/admin/customers/delete/'+customerId,
                type : 'POST',
                data : {
                    'customer_id' : customerId
                },
                success : (response) => {
                    console.log(response);
                    window.location.href = '/admin/customers';
                }

            });
        }
        $('.deleteButton').off('click').click(function() {
            customerId = $(this).data('customer-id');
            console.log(customerId);
            //deletecustomer(customerId);
        });

        $('#finalDeleteButton').off('click').click(function() {
            deletecustomer(customerId);
        });
    });
</script>
</body>
</html>