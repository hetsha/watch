// Function to show popup message
function showPopupMessage(message) {
  const popup = document.createElement("div");
  popup.className = "popup";
  popup.textContent = message;
  document.body.appendChild(popup);

  // Remove the popup after some time (e.g., 3 seconds)
  setTimeout(() => {
    popup.remove();
  }, 1000);
}

document.addEventListener("DOMContentLoaded", function () {
  // Fetch products from JSON file
  fetch("products.json")
    .then((response) => response.json())
    .then((products) => {
      const productContainer = document.getElementById("row");

      // Initialize an empty string to store the HTML for all products
      let productsHTML = "";

      // Loop through each product and generate HTML
      products.forEach((product) => {
        productsHTML += `
                    <div class="col-md-6 col-lg-4">
                        <div class="product-item discount">
                            <div class="product-item-inner">
                                <span class="discount">-${
                                  product.discount
                                }%</span>
                                    <figure class="img-box">
                                        <img src="${product.image}" alt="${
          product.name
        }">
                                    </figure>
                                <div class="details">
                                    <span class="cat"><i class="uil uil-tag-alt"></i> ${
                                      product.category
                                    }</span>
                                    <a href="singleproduct.php?id=${
                                      product.id
                                    }" class="link"> <!-- Updated link to singleproduct.php -->
                                        <h5 class="title">${product.name}</h5>
                                    </a>
                                    <div class="star">
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star-half-stroke"></i>
                                        <h4><span class="old-prc">${product.oldPrice.toFixed(
                                          2
                                        )} &#8360;</span>${product.price.toFixed(
          2
        )}&#8360;</h4>
                                    </div>
                                    <a class="go-to-cart" onclick="addToCart(${
                                      product.id
                                    })"><i class="uil uil-shopping-bag shopping-cart cart"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
      });

      // Insert the generated HTML into the container element
      productContainer.innerHTML = productsHTML;
    })
    .catch((error) => console.error("Error fetching products:", error));

  window.addToCart = function (productId) {
    console.log("Adding product with ID:", productId);
    fetch("products.json")
      .then((response) => response.json())
      .then((products) => {
        console.log("Fetched products:", products);
        const product = products.find((p) => parseInt(p.id) === productId);
        console.log("Found product:", product);
        if (product) {
          let cart = JSON.parse(localStorage.getItem("cart")) || [];

          // Check if the product is already in the cart
          const existingProductIndex = cart.findIndex(
            (p) => parseInt(p.id) === productId
          );
          if (existingProductIndex !== -1) {
            console.log(
              "Product already exists in cart. Incrementing quantity."
            );
            cart[existingProductIndex].quantity += 1;
          } else {
            console.log("Product added to cart.");
            product.quantity = 1;
            cart.push(product);
          }

          localStorage.setItem("cart", JSON.stringify(cart));

          // Show popup message
          showPopupMessage("Item added to cart");
        } else {
          console.error("Product not found with ID:", productId);
        }
      })
      .catch((error) => {
        console.error("Error fetching products:", error);
      });
  };
});

document.addEventListener("DOMContentLoaded", function () {
  // Fetch products from JSON file
  fetch("products.json")
    .then((response) => response.json())
    .then((products) => {
      const productList = document.getElementById("product-list");

      // Loop through each product and generate HTML
      products.forEach((product) => {
        const productItem = document.createElement("div");
        productItem.classList.add("product-item");

        // Create a link to the singleproduct.php page with product ID as a query parameter
        const productLink = document.createElement("a");
        productLink.href = `singleproduct.php?id=${product.id}`;
        productLink.textContent = product.name;

        productItem.appendChild(productLink);
        productList.appendChild(productItem);
      });
    })
    .catch((error) => console.error("Error fetching products:", error));
});
