<script src="https://kit.fontawesome.com/4a82e10df4.js" crossorigin="anonymous"></script>
<link rel="stylesheet" href="../CSS/styles.css">



<!-- Navigation Bar -->
<header class="header">
    <div class="flex">

      <!-- Title -->
      <a href="home.php" class="logo">Fatoora</a>

<!-- _______________________________________________________________________ -->

      <!-- user pages link -->
      <nav class="navbar">
        <!-- Navigation Bar Unordered List -->
        <ul class="navbar-ul">
          <!-- Navigation Bar List Items -->
          <li class="navbar-li" ><a href='Home.php'>Home</a></li>
          <li class="navbar-li" ><a href='Scan.php'>Scan</a></li>
          <li class="navbar-li" ><a href='Receipts.php'>Receipts</a></li>
          <li class="navbar-li" ><a href='Contact.php'>Contact Us</a></li>
        </ul>
      </nav>

<!-- _______________________________________________________________________ -->

      <div class="icons">
        <!-- logged in account menu icon -->
        <div id="user-btn" class="fas fa-user"></div>
        <!-- responsive menu icon -->
        <div id="menu-btn" class="fas fa-bars"></div>

      </div>

<!-- _______________________________________________________________________ -->

      <!-- logged in account menu -->
      <div class="account">
        <p>Name: <span><!--php--></span></p>
        <p>Email: <span><!--php--></span></p>

        <p class="account-options"><a href='Profile.php'>Edit Account</a> | <a href="Logout.php">Log out</a></p>

      </div>

<!-- _______________________________________________________________________ -->
    </div>
</header>

<script src="../Script/nav.js" type="text/javascript"></script>
