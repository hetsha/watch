<?php
  $currentPage = basename($_SERVER['REQUEST_URI']);
  $pages = array(
    'index.php' => 'Home',
    'products.php' => 'Products',
    'blog.php' => 'Pages',
    'about.php' => 'Pages',
    'contact.php' => 'Pages',
    'login.php' => 'login/signup',
    'sign.php' => 'login/signup',
    'logout.php' => 'login/signup'
  );
?>