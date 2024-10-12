<section class="newsletter">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6 col-lg-8">
                <div class="newstext">
                    <h4>Sign Up For Newsletters!</h4>
                    <p>Get E-Mail updates about our Latest Products and <span>special offers</span>.</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="n-form d-flex"> <!-- Add a class for flex -->
                    <form action="include/newsletter.php" method="POST" class="d-flex"> <!-- Flex on the form -->
                        <input type="text" name="email" placeholder="Your E-Mail Address..." required>
                        <button type="submit" class="btn-normal">Sign Up</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<style>
    .n-form {
    display: flex; /* Use flexbox for alignment */
    justify-content: space-between; /* Space out elements */
}

.n-form input {
    flex: 1; /* Allow input to grow and fill available space */
    margin-right: 10px; /* Add some space between input and button */
}

.n-form button {
    /* Optional: Add styles for the button */
    padding: 10px 20px; /* Adjust button size */
}

</style>