<?php
session_start();
$base_url = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://" . $_SERVER['HTTP_HOST'] . "/Kelompok8/";
?>

<header>
  <nav>
    <div class="judul">
      <img src="<?php echo $base_url; ?>img/image-1.png" alt="">
      <p>CUMINFO</p>
    </div>
    <ul>
      <li><a href="<?php echo $base_url; ?>index.php">Home</a></li>
      <p>|</p>
      <li><a href="<?php echo $base_url; ?>pages/about.php">About</a></li>
      <p>|</p>
      <li><a href="<?php echo $base_url; ?>pages/contact.php">Contact</a></li>
      <p>|</p>
      <?php if (isset($_SESSION['username'])) : ?>
        <li>
          <a href="<?php echo $base_url; ?>logout.php" class="button">Logout</a>
        </li>
      <?php else : ?>
        <li><a href="<?php echo $base_url; ?>login.php" class="button">Login</a></li>
      <?php endif; ?>
    </ul>
  </nav>
</header>
