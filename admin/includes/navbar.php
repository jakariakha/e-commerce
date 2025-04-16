<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Panel</title>
</head>
<body>
  <div class="card">
    <div class="card-body p-2">
      <div class="d-flex align-items-center">
        <i class="fa-solid fa-bars fs-3 me-3" data-bs-toggle="offcanvas" data-bs-target="#sideModal" aria-controls="sideModal" role="button"></i>
        <span class="fs-4 d-none d-sm-inline">Admin Panel</span>
      </div>
    </div>
  </div>

  <div class="offcanvas offcanvas-start" tabindex="-1" id="sideModal" aria-labelledby="sideModalLabel" style="width: 13rem">
    <div class="offcanvas-header border-bottom">
      <h5 class="offcanvas-title" id="sideModalLabel">Admin Panel</h5>
      <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body p-0">
      <ul class="nav flex-column">
        <li class="nav-item">
          <a class="nav-link text-dark px-3 py-2" href="/admin/dashboard">
            <i class="fas fa-tachometer-alt fa-fw me-2"></i>
            Dashboard
          </a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link text-dark dropdown-toggle px-3 py-2" data-bs-toggle="dropdown">
          <i class="fa-solid fa-box"></i>
            Products
          </a>
          <ul class="dropdown-menu">
            <li>
              <a class="dropdown-item text-dark" href="/admin/products">
                All products
              </a>
            </li>
            <li>
              <a class="dropdown-item text-dark" href="/admin/products/create">
                Create products
              </a>
            </li>
          </ul>
        </li>
        <li class="nav-item">
          <a class="nav-link text-dark px-3 py-2" href="/admin/customers">
            <i class="fas fa-users fa-fw me-2"></i>
            Customers
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-dark px-3 py-2" href="/admin/orders">
            <i class="fa-solid fa-truck-fast"></i>
            Orders
          </a>
        </li>
        <?php if ($_SESSION['logged_in']): ?>
          <li class="nav-item">
            <a class="nav-link text-dark px-3 py-2" href="/admin/logout">
              <i class="fas fa-sign-out-alt fa-fw me-2"></i>
              Log out
            </a>
          </li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</body>
</html>