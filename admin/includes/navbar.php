<html>
  <div class="card" style="height: 4rem">
    <div class="card-body">
      <div class="navbar" style="font-size: 30px">
        <i class="fa-solid fa-bars" data-bs-toggle="offcanvas" data-bs-target="#sideModal" aria-controls="sideModal"></i>
      </div>
    </div>
  </div>

  <div class="offcanvas offcanvas-start" tabindex="-1" id="sideModal" aria-labelledby="sideModalLabel">
    <div class="offcanvas-header">
      <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
      <div class="category mt-2">
        <ul class="flex-column nav" style="font-size: 18px">
          <li class="nav-item">
            <a class="nav-link text-black" href="/admin/dashboard">Dashboard</a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle text-black" data-bs-toggle="dropdown">Products</a>
            <ul class="dropdown-menu">
              <li>
                <a class="dropdown-item text-black" href="/admin/products">All products</a>
              </li>
              <li>
                <a class="dropdown-item text-black" href="/admin/products/create">Create products</a>
              </li>
            </ul>
          </li>
        </ul>
      </div>
  </div>
</html>