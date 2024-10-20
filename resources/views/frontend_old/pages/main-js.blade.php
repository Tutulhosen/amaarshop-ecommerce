<script>
    $('#account-btn').on('click', function () {
        $('.login-float').toggle()
    });

    $('#header-top-menu-btn').on('click', function () {
        $('.header-top-menu-m').toggle()
    });

    $('#cat_menu_mobile_btn').on('click', function () {
        $('.cat_menu_m').toggle()
    });

    $('#search_mobile_btn').on('click', function () {
        $('.search-form-m').toggle()
    });

    $('.search_btnclose').on('click', function () {
        $('.search-form-m').toggle()
    });
</script>

<script>
    document.querySelectorAll('.carousel-item').forEach(item => {
    item.addEventListener('mousemove', function(e) {
        const img = this.querySelector('img');
        const rect = this.getBoundingClientRect();
        const x = e.clientX - rect.left;  // Get the horizontal coordinate
        const y = e.clientY - rect.top;   // Get the vertical coordinate

        // Calculate the position of the image
        const xPercent = x / rect.width * 100;
        const yPercent = y / rect.height * 100;

        // Move the image
        img.style.transformOrigin = `${xPercent}% ${yPercent}%`;
    });

    item.addEventListener('mouseleave', function() {
        const img = this.querySelector('img');
        img.style.transformOrigin = 'center center';  // Reset the transform origin
    });
});

</script>
    

<script>

    $(document).ready(function () {
        $(".owl-carousel").owlCarousel({
            margin: 15,
            loop: true,
            dots: false,
            autoplay: true,
            autoplayTimeout: 6000,
            autoplayHoverPause: true,
            responsiveClass: true,
            responsive: {
                0: {
                    items: 3,
                    nav: true
                },
                600: {
                    items: 3,
                    nav: false
                },
                1000: {
                    items: 6,
                    nav: true,
                    loop: false
                }
            }
        });

        $('.owl-nav').remove();

        

    });

    $(document).on('click', '.quick_view', function(e) {
        
        e.preventDefault(); // Prevent the default link behavior

        var productId = $(this).data('id'); // Get the product ID from the data attribute
    
        // Make an AJAX request to fetch the product details
        $.ajax({
            url: '{{ route("frontend.single.product.quick_view") }}', // Use the named route in the AJAX call
            method: 'POST',
            data: {
                _token: "{{ csrf_token() }}", 
                 product_id: productId 
                },
            success: function(response) {
             
                $('#quickViewModal .modal-body').html(response);
                $('#quickViewModal').modal({
                    backdrop: 'static',
                    keyboard: false
                });
                $('#quickViewModal').modal('show'); 
            },
          
        });
    });


    toastr.options = {
        "closeButton": true,  // Enables the close (X) button
        "progressBar": true,  // Optional: Adds a progress bar to the notification
        "positionClass": "toast-top-right",  // Optional: Adjusts the position of the notification
        "timeOut": "5000",    // Time after which the notification automatically disappears
        "extendedTimeOut": "2000",  // Time to wait for a user action before the notification disappears
    };
</script>




<script>
    // Get price value from the hidden input
    var productPrice = parseFloat(document.getElementById('product_price_value').value);
    
    // Function to update the total amount
    function updateTotalAmount() {
        var qty = parseInt(document.getElementById('qty').value);
        var productPrice = parseInt(document.getElementById('product_price_value').value);
        var total = productPrice * qty;
        document.getElementById('total_price').innerText = total;
        document.getElementById('total_amount').value = total; // Update hidden input
    }

    // Increment quantity
    document.getElementById('qty_plus').addEventListener('click', function () {
        var qty = parseInt(document.getElementById('qty').value);
        qty++;
        document.getElementById('qty').value = qty;
        updateTotalAmount(); // Update total
    });

    // Decrement quantity
    document.getElementById('qty_minus').addEventListener('click', function () {
        var qty = parseInt(document.getElementById('qty').value);
        if (qty > 1) {
            qty--;
            document.getElementById('qty').value = qty;
            updateTotalAmount(); // Update total
        }
    });
</script>
<script>
    // Get elements
    const openPopupBtn = document.getElementById('openPopupBtn');
    const popupForm = document.getElementById('popupForm');
    const closePopupBtn = document.getElementById('closePopupBtn');
    const loginForm = document.getElementById('loginForm');
    const registerForm = document.getElementById('registerForm');
    const showRegisterForm = document.getElementById('showRegisterForm');
    const showLoginForm = document.getElementById('showLoginForm');

    // Open the popup when the button is clicked
    openPopupBtn.addEventListener('click', () => {
        popupForm.style.display = 'flex';
    });

    // Close the popup when the close button is clicked
    closePopupBtn.addEventListener('click', () => {
        popupForm.style.display = 'none';
    });

    // Close the popup if user clicks outside the form
    window.addEventListener('click', (e) => {
        if (e.target === popupForm) {
            popupForm.style.display = 'none';
        }
    });

    // Show the registration form and hide the login form
    showRegisterForm.addEventListener('click', () => {
        loginForm.style.display = 'none';
        registerForm.style.display = 'block';
    });

    // Show the login form and hide the registration form
    showLoginForm.addEventListener('click', () => {
        registerForm.style.display = 'none';
        loginForm.style.display = 'block';
    });
</script>
<script>
    @if(Session::has('success'))
        toastr.success("{{ Session::get('success') }}");
    @endif

    @if(Session::has('error'))
        toastr.error("{{ Session::get('error') }}");
    @endif

    @if($errors->any())
        @foreach ($errors->all() as $error)
            toastr.error("{{ $error }}");
        @endforeach
    @endif
</script>

<script>
    
    $(document).ready(function () {
        

        // Handle the click event of the Add to Cart button
        $('.add_cart_btn').click(function (e) {
            e.preventDefault();
            // Get the product details
            var productId = $('#product_id').val();
            
            var qty = $('#qty').val();
            var price = $('#product_price_value').val();

            // Send AJAX request to add product to cart
            $.ajax({
                url: '{{ route("cart.add") }}',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    product_id: productId,
                    qty: qty,
                    price: price
                },
                success: function (response) {
                    if (response.already_in_cart) {
                        // Toaster alert if the product is already in the cart
                        toastr.info('This product is already in your cart!', 'Info');
                    } else if (response.success) {
                        // Get the updated cart count from the response
                        cartCount = response.cart_count;
                        
                        // Save updated count to localStorage
                        localStorage.setItem('cartCount', cartCount);
                        
                        // Update the cart count display
                        $('#cart-count').text(cartCount);
                        
                        // Show the cart count badge only if count is greater than 0
                        if (cartCount > 0) {
                            $('#cart-count').show();
                        } else {
                            $('#cart-count').hide();
                        }

                        // Toaster alert for successfully adding to cart
                        toastr.success('Product added to cart!', 'Success');
                    }
                },
                error: function (error) {
                    // Toaster alert for any errors
                    toastr.error('Something went wrong. Please try again.', 'Error');
                    console.log(error);
                }
            });
        });

        $('.add_cart_btn_direct').click(function (e) {
            e.preventDefault();
            
            // Get the product details
            var productId = $(this).data('id');
            var qty = $(this).data('qnt');
            var price = $(this).data('price');
            
            // Send AJAX request to add product to cart
            $.ajax({
                url: '{{ route("cart.add") }}',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    product_id: productId,
                    qty: qty,
                    price: price
                },
                success: function (response) {
                    if (response.already_in_cart) {
                        // Toaster alert if the product is already in the cart
                        toastr.info('This product is already in your cart!', 'Info');
                    } else if (response.success) {
                        // Get the updated cart count from the response
                        cartCount = response.cart_count;
                        
                        // Save updated count to localStorage
                        localStorage.setItem('cartCount', cartCount);
                        
                        // Update the cart count display
                        $('#cart-count').text(cartCount);
                        
                        // Show the cart count badge only if count is greater than 0
                        if (cartCount > 0) {
                            $('#cart-count').show();
                        } else {
                            $('#cart-count').hide();
                        }

                        // Toaster alert for successfully adding to cart
                        toastr.success('Product added to cart!', 'Success');
                    }
                },
                error: function (error) {
                    // Toaster alert for any errors
                    toastr.error('Something went wrong. Please try again.', 'Error');
                    console.log(error);
                }
            });
        });

    });



</script>

<script>
    
    $(document).ready(function() {
        $('#searchForm').on('submit', function(e) {
            e.preventDefault(); // Prevent default form submission
            
            var query = $('#searchQuery').val().trim();
            var category = $('#category').val();
            // alert(query);
            // Check if the query is not empty or category is selected
            if (query.length > 0 || category) {
                // Redirect to search results page with query and category as parameters
                window.location.href = '{{ route("search.results") }}?query=' + encodeURIComponent(query) + '&category=' + category;
            } else {
                // If no input is provided, stay on the current page
                alert('Please enter a search query or select a category.');
            }
        });
    });



</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        fetch('{{ route('cart.count') }}')
            .then(response => response.json())
            .then(data => {
                document.getElementById('cart-count').textContent = data.count;
            })
            .catch(error => console.error('Error:', error));
    });
</script>
<script>
    function updateCartCount() {
        fetch('{{ route('cart.count') }}')
            .then(response => response.json())
            .then(data => {
                document.getElementById('cart-count').textContent = data.count;
            })
            .catch(error => console.error('Error:', error));
    }

    
    document.addEventListener('DOMContentLoaded', updateCartCount);

    
</script>

