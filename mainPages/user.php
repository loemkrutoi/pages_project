<?php 

require_once('header.php');
session_start();

?>

<div class="container">
    <h1>Добро пожаловать, <?php echo $_SESSION['role'] . ' ' . $_SESSION['username'] ?></h1>
</div>