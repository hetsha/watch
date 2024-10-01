// Example code for adding a new category
document.querySelector('#add-category-form').addEventListener('submit', function(event) {
    event.preventDefault();
    const name = document.querySelector('#name').value;
    const description = document.querySelector('#description').value;
    // Insert new category into database
    const query = 'INSERT INTO categories (name, description) VALUES (?, ?)';
    const statement = conn.prepare(query);
    const result = statement.execute(name, description);
    // Redirect to categories page
    window.location.href = 'categories.php';
});