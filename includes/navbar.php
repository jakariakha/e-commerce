<html>
  <style>
    #shoppingCartMobile i {
      font-size: 30px;
    }

    #shoppingCartDesktop i {
      font-size: 30px;
    }
    </style>
<body>
<nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container-fluid">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <?php if (!isset($_SESSION['checkout_page'])): ?>
    <div id="shoppingCartMobile" class="d-flex justify-content-center justify-content-md-end ms-auto d-lg-none">
      <div class="p-2">
        <i class="fa-solid fa-cart-shopping position-relative fs-3" data-bs-toggle="offcanvas" data-bs-target="#sideModal" aria-controls="sideModal" style="font-size: clamp(1rem, 2vw, 1.5rem); cursor: pointer;">
          <span class="cartCount position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.6em; min-width: 1.2em;">
              0
          </span>
        </i>
      </div>
    </div>
    <?php endif; ?>
    <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="/">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="/login">Login</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="/register">Register</a>
        </li>
      </ul>
      <?php if (!isset($_SESSION['checkout_page']) && ($_SERVER['REQUEST_URI'] !== '/register')): ?>
      <div id="shoppingCartDesktop" class="d-flex d-none d-lg-block ms-auto">
        <div class="p-2">
          <i class="fa-solid fa-cart-shopping position-relative" data-bs-toggle="offcanvas" data-bs-target="#sideModal" aria-controls="sideModal" style="font-size: clamp(1rem, 2vw, 1.5rem); cursor: pointer;">
            <span class="cartCount position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.6em; min-width: 1.2em;">
                0
            </span>
          </i>
        </div>
      </div>
      <?php endif; ?>
    </div>
  </div>
</nav>
 <!-- Side Modal (Offcanvas) -->
 <div class="offcanvas offcanvas-end" tabindex="-1" id="sideModal" aria-labelledby="sideModalLabel">
    <div class="offcanvas-header">
      <h5 id="sideModalLabel">Shopping Cart</h5>
      <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body d-flex justify-content-center items-center">
      <ul class="cartList"></ul>
      <p class="cartEmptyText">Your cart is empty.</p>
    </div>
    <div class="d-flex flex-column flex-sm-row justify-content-center align-items-center mb-4">
      <p class="totalAmount mb-2 mb-sm-0 d-none"></p> 
      <a class="checkoutButton btn btn-outline-primary ms-sm-3 d-none" href="/checkout">Proceed to checkout</a>
    </div>
  </div>
</body>
</html>
