let domain = ".";
const body = document.querySelector("body"),
loader = document.querySelector(".loader"),
header = document.querySelector(".header"),
headerMain = document.querySelector(".header--main"),
nav = document.querySelector("nav.menu"),
modeToggle = document.querySelector(".dark-light"),
searchToggle = document.querySelector(".searchToggle"),
navOpen = document.querySelector(".open-nav"),
navClose = document.querySelector(".close-nav"),
navLogo = document.querySelector(".nav-logo"),
footerLogo = document.querySelector(".footer-logo"),
year = document.getElementById("year");
window.onscroll = () => {
    if (window.scrollY > 20) {
        header.classList.add("f-nav");
    } else {
        header.classList.remove("f-nav");
    }
};
window.onload = () => {
    if(window.location.href.includes("/")) {
        // domain = "..";
        let imgDir = document.querySelectorAll('img');
        imgDir.forEach(item => {
            if(item.getAttribute('src').indexOf('./assets/') < 1) {
                const nItem = item.getAttribute('src').replace('./assets', '../assets');
                item.src = nItem;
            }
        });
    }
    // Dark & Light Mode -> On Load
    let modeOnload = localStorage.getItem("mode");
    checkBgMode(modeOnload);
    // Welcome
    const welcome = document.querySelector(".welcome-alert"),
    welcomeCls = document.querySelector(".welcome");
    let welcomeOnload = localStorage.getItem("welcome");
    if(welcomeOnload && welcomeOnload == "d-none") {
        welcome.classList.add("d-none");
    }
    welcomeCls.addEventListener("click", e => {
        let touch = e.target;
        if(touch.classList.contains("welcome")) {
            setTimeout(() => {
                welcome.classList.add("d-none");
                localStorage.setItem("welcome", "d-none");
            }, 500);
        }
    });
}
const checkBgMode = (mode) => {
    if(mode) {
        switch(mode) {
            case 'light-mode':
                navLogo.src = `assets/img/light-logo.png`;
                footerLogo.src = `assets/img/light-logo.png`;
            break;
            case 'dark-mode':
                body.classList.add("dark");
                navLogo.src = `assets/img/dark-logo.png`;
                footerLogo.src = `assets/img/dark-logo.png`;
            break;
            default:
                return;
        }
    }
}
// Light & Dark mode, Real Time | Localstorage Changes
const modeLD = (() => {
    let httpRequest;
    modeToggle.addEventListener('click', makeRequest);
    function makeRequest() {
        httpRequest = new XMLHttpRequest();
        if (!httpRequest) {
            console.log('Cannot create an XMLHTTP instance');
            return false;
        }
        httpRequest.onreadystatechange = showContents;
        let path = window.location.pathname;
        let page = path.split("/").pop();
        httpRequest.open('GET', `${page}`);
        httpRequest.send();
    }
    function showContents() {
        if (httpRequest.readyState === XMLHttpRequest.DONE) {
            if (httpRequest.status === 200) {
                let mode = localStorage.getItem("mode");
                checkBgMode(mode);
            } else {
                console.log('There was a problem with the request.');
            }
        }
    }
})();
// dark and light mode
modeToggle.addEventListener("click", () => {
    body.classList.toggle("dark");
    modeToggle.classList.toggle("active");
    if(!window.location.host) window.location.href=window.location.href;
    if(!body.classList.contains("dark")) {
        localStorage.setItem("mode", "light-mode");
    } else {
        localStorage.setItem("mode", "dark-mode");
    }
});
// searchBox
searchToggle.addEventListener("click", () => {
    searchToggle.classList.toggle("active");
});
// Checkout
const checkOut = document.querySelector(".shopping-cart");
checkOut.onclick = () => {
    location.href = `${domain}/cart.html`;
};
// mobile nav
navOpen.addEventListener("click", () => {
    nav.classList.toggle("active");
});
// // Year
year.innerText = new Date().getFullYear();

$(document).ready(function () {
    // Animation when Add to Cart is clicked
    $('.cart-button').on('click', function (event) {
        event.preventDefault(); // Prevent default link behavior

        // Get the form related to the clicked button
        const form = $(this).closest('form');

        // Add bounce animation to the cart icon
        $(this).find('.cart-icon').addClass('clicked');

        // Simulate adding to cart without page reload (using AJAX)
        $.ajax({
            url: form.attr('action'),
            method: form.attr('method'),
            data: form.serialize(),
            success: function (response) {
                // Show popup confirmation
                showCartPopup();

                // Remove the bounce animation after animation ends
                setTimeout(() => {
                    $('.cart-icon').removeClass('clicked');
                }, 600);
            },
            error: function () {
                alert("There was an error adding the product to the cart.");
            }
        });
    });

    // Animation when View Details is clicked
    $('.view-details').on('click', function (event) {
        event.preventDefault(); // Prevent default link behavior

        // Animate the icon (optional: you can add different animation)
        $(this).addClass('clicked');
        window.location.href = $(this).attr('href');
    });

    // Function to show the popup
    function showCartPopup() {
        $('#overlay').fadeIn();
        $('#cartPopup').fadeIn();

        // Close the popup after 3 seconds
        setTimeout(function () {
            $('#overlay').fadeOut();
            $('#cartPopup').fadeOut();
        }, 3000);
    }

    // Close popup when clicking the close button
    $('#cartPopup button').on('click', function () {
        $('#overlay').fadeOut();
        $('#cartPopup').fadeOut();
    });
});
