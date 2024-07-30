document.addEventListener("DOMContentLoaded", function () {
  window.addToCart = function (productId) {
    console.log("Adding product with ID:", productId);
    fetch("products.json")
      .then((response) => response.json())
      .then((products) => {
        console.log("Fetched products:", products);
        const product = products.find((p) => p.id === productId);
        console.log("Found product:", product);
        if (product) {
          let cart = JSON.parse(localStorage.getItem("cart")) || [];
          const existingProduct = cart.find((p) => p.id === productId);
          if (existingProduct) {
            // If product already exists in the cart, increment its quantity
            existingProduct.quantity += 1;
          } else {
            // If product does not exist in the cart, add it with quantity initialized to 1
            product.quantity = 1;
            cart.push(product);
          }
          localStorage.setItem("cart", JSON.stringify(cart)); // Update the cart in localStorage
          console.log("Product added to cart:", product);
          renderCart(); // Render the updated cart
        } else {
          console.error("Product not found with ID:", productId);
        }
      })
      .catch((error) => {
        console.error("Error fetching products:", error);
      });
  };

  window.updateQuantity = function (productId, newQuantity) {
    console.log(
      "Updating quantity for product ID:",
      productId,
      "New quantity:",
      newQuantity
    );

    // Check if productId is a valid number
    if (isNaN(productId)) {
      console.error("Invalid productId:", productId);
      return;
    }

    let cart = JSON.parse(localStorage.getItem("cart")) || [];
    console.log("Cart contents:", cart);

    // Find the index of the product in the cart
    const index = cart.findIndex((p) => parseInt(p.id) === parseInt(productId));

    console.log("Index of product in cart:", index);

    // Check if the product exists in the cart
    if (index !== -1) {
      const product = cart[index];
      console.log("Found product in cart:", product);

      // Ensure newQuantity is a valid number and greater than or equal to 1
      if (!isNaN(newQuantity) && parseInt(newQuantity) >= 1) {
        product.quantity = parseInt(newQuantity);
        localStorage.setItem("cart", JSON.stringify(cart));
        console.log("Quantity updated in local storage");
        renderCart(); // Render the updated cart
        // updateSubtotal(); // Update subtotal if needed
      } else {
        console.error("Invalid quantity value:", newQuantity);
      }
    } else {
      console.error("Product not found in cart with ID:", productId);
    }
  };

  window.removeFromCart = function (productId) {
    console.log("Removing product with ID:", productId);
    let cart = JSON.parse(localStorage.getItem("cart")) || [];

    // Find the index of the product in the cart
    const index = cart.findIndex((p) => parseInt(p.id) === parseInt(productId));

    // Check if the product exists in the cart
    if (index !== -1) {
      // Remove the product from the cart array
      cart.splice(index, 1);
      localStorage.setItem("cart", JSON.stringify(cart));
      console.log("Product removed from cart.");
      renderCart(); // Render the updated cart
    } else {
      console.error("Product not found in cart with ID:", productId);
    }
  };

  // Define function to calculate cart count
  function calculateCartCount() {
    const cart = JSON.parse(localStorage.getItem("cart")) || [];
    const uniqueProductIds = new Set(); // Use a Set to store unique product IDs

    // Add each product ID to the set
    cart.forEach((product) => {
      if (product && product.id !== undefined) {
        uniqueProductIds.add(product.id);
      }
    });

    // The size of the set is the number of unique products
    const cartCount = uniqueProductIds.size;

    // Store the cart count in localStorage
    localStorage.setItem("cartcount", cartCount);

    return cartCount;
  }

  // Define function to render the cart
  function renderCart() {
    const cart = JSON.parse(localStorage.getItem("cart")) || [];
    const cartElement = document.getElementById("cart");
    const subtotalElement = document.getElementById("subtotal");
    const cartCountElement = document.getElementById("cartCount");

    if (cartElement && subtotalElement && cartCountElement) {
      let cartHtml = "";
      let subtotal = 0;
      let cartCount = 0;

      cart.forEach((product) => {
        if (
          product &&
          product.id &&
          product.image &&
          product.name &&
          product.price &&
          product.quantity !== undefined
        ) {
          cartHtml += `
                        <tr>
                            <td><i onclick="removeFromCart(${
                              product.id
                            })" class="uil uil-times-circle"></i></td>
                            <td><img src="${product.image}" alt="${
            product.name
          }" class="product-image"></td>
                            <td>${product.name}</td>
                            <td>${product.price.toFixed(2)}</td>
                            <td><input type="number" value="${
                              product.quantity
                            }" min="1" max="10" onchange="updateQuantity(${
            product.id
          }, this.value)"></td>
                            <td class="total-cost">${(
                              product.price * product.quantity
                            ).toFixed(2)}</td>
                        </tr>
                    `;
          subtotal += product.price * product.quantity;
          cartCount += product.quantity;
        } else {
          console.error("Invalid product object:", product);
        }
      });

      cartElement.innerHTML = cartHtml;
      subtotalElement.innerText = subtotal.toFixed(2);
      cartCountElement.innerText = calculateCartCount();
    } else {
      console.error(
        "Cart element, subtotal element, or cart count element not found"
      );
    }
  }

  fetch("products.json")
    .then((response) => response.json())
    .then((products) => {
      console.log("Fetched products:", products);
      generateTableRows(products);
      renderCart();
    })
    .catch((error) => {
      console.error("Error fetching products:", error);
    });

  function generateTableRows(products) {
    const tbody = document.querySelector("tbody");

    // Check if tbody element exists
    if (tbody) {
      tbody.innerHTML = "";

      products.forEach((product) => {
        const row = document.createElement("tr");
        row.innerHTML = `
                    <td><a href="#" onclick="removeFromCart(${
                      product.id
                    })"><i class="uil uil-times-circle"></i></a></td>
                    <td><img src="${product.image}" alt="${
          product.name
        }" class="product-image"></td>
                    <td>${product.name}</td>
                    <td>${product.price.toFixed(2)}</td>
                    <td><input type="number" value="${
                      product.quantity
                    }" min="1" max="10" onchange="updateQuantity(${
          product.id
        }, this.value)"></td>
                    <td>${(product.price * product.quantity).toFixed(2)}</td>
                `;
        tbody.appendChild(row);
      });
    } else {
      console.error("tbody element not found");
    }
  }

  function calculateSubtotal() {
    const cart = JSON.parse(localStorage.getItem("cart")) || [];
    let subtotal = 0;
    cart.forEach((product) => {
      subtotal += product.price * product.quantity;
    });
    return subtotal;
  }

  document
    .querySelector("#chekout")
    .addEventListener("click", function (event) {
      event.preventDefault(); // Prevent the default form submission behavior

      // Your code for button click event
      const subtotal = calculateSubtotal();
      const formHTML = `
            <form id="delivery-form">
                <h3>Delivery Address Information</h3>
                <div>
                    <label for="fullname">Full Name:</label>
                    <input type="text" id="fullname" name="fullname">
                </div>
                <div>
                    <label for="mobile">Mobile Number:</label>
                    <input type="text" id="mobile" name="mobile">
                </div>
                <div>
                    <label for="email">Email:</label>
                    <input type="text" id="email" name="email">
                </div>
                <div>
                    <label for="address">Address:</label>
                    <input type="text" id="address" name="address">
                </div>
                <div>
                    <label for="city">City:</label>
                    <input type="text" id="city" name="city">
                </div>
                <div>
                    <label for="zipcode">Zip Code:</label>
                    <input type="text" id="zipcode" name="zipcode">
                </div>
                <div>
                    <label for="subtotal">Subtotal:</label>
                    <input type="text" id="subtotal" name="subtotal" value="${subtotal.toFixed(
                      2
                    )}" disabled>
                </div>
                <button type="submit" class="btn-normal">Submit</button>
            </form>
        `;
      document.querySelector(".frm").innerHTML = formHTML;

      function showAlert(message) {
        const popup = document.createElement("div");
        popup.className = "popupup";
        popup.textContent = message;
        document.body.appendChild(popup);

        // Remove the popup after some time (e.g., 3 seconds)
        setTimeout(() => {
          popup.remove();
        }, 3000);
      }

      // Handle form submission
      document
        .getElementById("delivery-form")
        .addEventListener("submit", function (event) {
          event.preventDefault();

          // Regex patterns for validation
          const namePattern = /^[a-zA-Z\s]+$/;
          const mobilePattern = /^\d{10}$/;
          const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
          const zipcodePattern = /^\d{6}$/;

          // Retrieve input field values
          const fullname = document.getElementById("fullname").value.trim();
          const mobile = document.getElementById("mobile").value.trim();
          const email = document.getElementById("email").value.trim();
          const address = document.getElementById("address").value.trim();
          const city = document.getElementById("city").value.trim();
          const zipcode = document.getElementById("zipcode").value.trim();
          const subtotal = parseFloat(
            document.getElementById("subtotal").value
          );

          // Validate Full Name
          if (!fullname.match(namePattern)) {
            showAlert("Please enter a valid full name.");
            return;
          }

          // Validate Mobile Number
          if (!mobile.match(mobilePattern)) {
            showAlert("Please enter a valid mobile number.");
            return;
          }

          // Validate Email
          if (!email.match(emailPattern)) {
            showAlert("Please enter a valid email address.");
            return;
          }

          // Validate Zip Code
          if (!zipcode.match(zipcodePattern)) {
            showAlert("Please enter a valid zip code.");
            return;
          }

          // If all fields are valid, proceed with form submission
          localStorage.clear();
          showAlert("Order placed");

          // Scroll to the top of the page after a short delay
          setTimeout(function () {
            window.scrollTo({
              top: 0,
              behavior: "smooth",
            });
            // Reload the page after another short delay
            setTimeout(function () {
              window.location.reload();
            }, 500); // Reload after 500 milliseconds (0.5 seconds)
          }, 1500); // Scroll after 1500 milliseconds (1.5 seconds)
          // Additional actions after form submission
        });
    });
});
