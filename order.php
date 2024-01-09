<?php
  $currentPage = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FEGO</title>
    <link rel="stylesheet" href="order.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>
    <script src="https://kit.fontawesome.com/ae360af17e.js" crossorigin="anonymous"></script>
    <link
      rel="stylesheet"
      href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;800&display=swap"
    />
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <style>
      #btn-admin {
        border: none;
        background-color: transparent;
        margin-top:7px;
        text-align: left;
        padding-left: 0;
      }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-sm fixed-top" id="navbar">
        <div class="container-fluid">
          <a class="navbar-brand" href="../homepage/homepage.php"><img src="../homepage/asset-homepage/logo bli n go 2 1.png" alt="logo" style="height: 1cm;"></a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mynavbar">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="mynavbar">
            <ul class="navbar-nav me-auto"></ul>
            <form class="d-flex">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                      <a class="nav-link" href="index.php" <?php if($currentPage == "index.php"){echo "style='color:black; font-weight:bold'";}?>>Home</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="products.php" <?php if($currentPage == "products.php"){echo "style='color:black; font-weight:bold'";}?>>Products</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="order.php" <?php if($currentPage == "order.php"){echo "style='color:black; font-weight:bold'";}?>>Order</a>
                    </li>
                    <li class="nav-item">
                      <button class="btn text-secondary">Admin</button>
                    </li>
                </ul>
            </form>
          </div>
        </div>
    </nav>

    
</body>
</html>
