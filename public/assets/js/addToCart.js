$(document).ready(function() {
    let cartCount = 0, totalAmount = 0, productId, existingItem, cartList = $('.cartList'), cartItems = JSON.parse(localStorage.getItem('cartItems')) || [];
    console.log(cartItems.length)
    if (cartItems.length) {
        cartCount = cartItems.length;
        $('.cartCount').text(cartItems.length);
        cartItems.forEach(productDetails => {totalAmount += parseInt(productDetails.price*productDetails.quantity);
            cartList.append(
                `<div class="card mb-3" style="width: 20rem;" data-product-id="${productDetails.product_id}">
                    <div class="card-body p-2 d-flex justify-content-between align-items-center">
                        <div class="flex-grow-1">
                            <h6 class="card-title mb-1 text-truncate">${productDetails.name}</h6>
                            <h6 class="productPrice card-subtitle text-muted" data-product-price="${productDetails.price}">৳${productDetails.price}</h6>
                        </div>
                        <div class="ms-3 d-flex align-items-center">
                            <button class="minusButton btn btn-sm btn-outline-secondary">−</button>
                            <span class="productQuantity mx-2">${productDetails.quantity}</span>
                            <button class="plusButton btn btn-sm btn-outline-secondary">+</button>
                            <button class="deleteButton btn btn-sm btn-danger ms-2">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>`
            )
        });

        $('.totalAmount').text('Total amount: '+totalAmount+' Taka');
    }

    const isCartEmpty = () => {
        if (0 < cartItems.length){
            $('.cartEmptyText').addClass('d-none');
            $('.totalAmount').removeClass('d-none');
            $('.checkoutButton').removeClass('d-none');         
        } else {
            $('.cartEmptyText').removeClass('d-none');
            $('.totalAmount').addClass('d-none');
            $('.checkoutButton').addClass('d-none');
        }
    }

    isCartEmpty();

    const updateCartCount = () => {
        cartCount += 1;
        $('.cartCount').text(cartCount);
    }
    
    $('.addToCart').off('click').click(function() {
        productId = $(this).data('product-id');
        getProductDetails(productId);
    });

    const getProductDetails = (productId) => {
        existingItem = cartItems.find(item => item.product_id === String(productId));
        if (existingItem) {
            return;
        }

        $.ajax({
            url: "/get-product-details",
            type: "POST",
            data: {
                'product_id' : productId
            },
            success: (response) => {
                const productDetails = JSON.parse(response);
                productDetails.quantity = 1;
                cartItems.push(productDetails);
                localStorage.setItem('cartItems', JSON.stringify(cartItems));

                updateCart(productDetails);
            }
        });
    }

    const updateCart = (productDetails) => {
        isCartEmpty();
        updateCartCount();
        updateTotalAmount(productDetails);
        cartList.append(
            `<div class="card mb-3" style="width: 20rem;" data-product-id="${productDetails.product_id}">
                <div class="card-body p-2 d-flex justify-content-between align-items-center">
                    <div class="flex-grow-1">
                        <h6 class="card-title mb-1 text-truncate">${productDetails.name}</h6>
                        <h6 class="productPrice card-subtitle text-muted" data-product-price="${productDetails.price}">৳${productDetails.price}</h6>
                    </div>
                    <div class="ms-3 d-flex align-items-center">
                        <button class="minusButton btn btn-sm btn-outline-secondary">−</button>
                        <span class="productQuantity mx-2">1</span>
                        <button class="plusButton btn btn-sm btn-outline-secondary">+</button>
                        <button class="deleteButton btn btn-sm btn-danger ms-2">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </div>
                </div>
            </div>`
        );
    }

    const updateTotalAmount = (productDetails) => {
        totalAmount += parseInt(productDetails.price);
        $('.totalAmount').text('Total amount: '+totalAmount+' Taka');
    }

    let productQuantity = 1;

    //increase product quantity
    cartList.on('click', '.plusButton', function() {
        updateProductQuantity(this, 1);
    });

    //decrease product quantity
    cartList.on('click', '.minusButton', function() {
        let currentProductQuantity = $(this).closest('.card').find('.productQuantity').text();
        if (currentProductQuantity === '1')return;
        totalAmount -= $(this).closest('.card').find('.productPrice').data('product-price');
        $('.totalAmount').text('Total amount: '+totalAmount+' Taka');
        updateProductQuantity(this, -1);
    });

    const updateProductQuantity = (button, value) => {
        let productQuantitySpan = $(button).closest('.card').find('.productQuantity');
        productQuantity = parseInt(productQuantitySpan.text());
        productId = $(button).closest('.card').data('product-id');
        const product = cartItems.find(product => product.product_id === String(productId));
        product.quantity += 1;
        localStorage.setItem('cartItems', JSON.stringify(cartItems));
        if (0 < value) {
            productQuantity += 1;
            totalAmount += $(button).closest('.card').find('.productPrice').data('product-price');
            $('.totalAmount').text('Total amount: '+totalAmount+' Taka');
        }
        if (0 > value && 1 < productQuantity)productQuantity -= 1;
        productQuantitySpan.text(productQuantity);
    }

    cartList.on('click', '.deleteButton', function() {
        totalAmount -= $(this).closest('.card').find('.productPrice').data('product-price');
        $('.totalAmount').text('Total amount: '+totalAmount+' Taka');

        $(this).closest('.card').remove();

        cartCount -= 1;
        $('.cartCount').text(cartCount);
        
        productId = $(this).closest('.card').data('product-id');
        cartItems = cartItems.filter(products => products.product_id !== String(productId));
        console.log(cartItems)
        localStorage.setItem('cartItems', JSON.stringify(cartItems));
        isCartEmpty();
    })

});