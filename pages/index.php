<?php
  $currentPage = basename($_SERVER['PHP_SELF']);
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <style>
      .navlink{
        text-decoration: none;
        color: grey;
        padding:0.5cm;
      }
      #navbar{
        position: absolute;
        background-color:cyan;
      }
    </style>
  </head>
  <body style="margin:0cm">
    <header>
        <div id="navbar" class="container-fluid text-center">
            <div class="row" style="background-color:brown">
                <div class="col-4" style="padding:1cm; background-color:pink">FEGO</div>
                <div class="col-2"><!--GAP--></div>
                <div class="col-6" style="padding:1cm; background-color:green">
                    <a href="pages\index.html" class="navlink col-sm-2" <?php if($currentPage == "index.php"){echo "style='color:black; font-weight:bold'";}?>>
                        Home
                    </a>
                    <a href="pages\products.html" class="navlink col-sm-2" <?php if($currentPage == "products.php"){echo "style='color:black; font-weight:bold'";}?>">
                        Products
                    </a>
                    <a href="pages\order.html" class="navlink col-sm-2" <?php if($currentPage == "order.php"){echo "style='color:black; font-weight:bold'";}?>">
                        Order
                    </a>
                    <span class="col-sm-6"><!--GAP--></span>
                </div>
            </div>
        </div>
    </header>
    <section>

    </section>
    <footer>

    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
  </body>
</html>