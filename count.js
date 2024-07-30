document.addEventListener('DOMContentLoaded', function() {
    const cartCount = localStorage.getItem('cartcount');
    console.log(cartCount); // Output: 6

    // Update the HTML element with the cart count
    var counts = document.getElementById("cartCount");
    counts.innerHTML = cartCount;
});
