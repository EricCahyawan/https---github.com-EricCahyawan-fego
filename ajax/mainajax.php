<?php
    require "../classes/categories.php";
    require "../classes/products.php";
?>
<?php
    if($_SERVER["REQUEST_METHOD"] == "GET" && $_GET["q"] == "deletecategory"){
        categories :: delete_category_by_name($_GET['t']);
        products :: delete_product_by_categoryname($_GET['t']);
    }
    if($_SERVER["REQUEST_METHOD"] == "GET" && $_GET["q"] == "deleteproduct"){
        products ::delete_product_by_productname($_GET['t']);
    }
    if ($_GET['q'] == 'getcategorydetails') {
        $categoryName = $_GET['t'];
        $categoryDetails = categories :: get_category_by_name($categoryName);
        echo json_encode($categoryDetails);
        exit;
    }
    if ($_GET['q'] == 'getproductdetails') {
        $productName = $_GET['t'];
        $productDetails = products :: get_product_by_name($productName);
        echo json_encode($productDetails);
        exit;
    }
    if ($_GET['q'] == 'getallcategories') {
        $categoryName = $_GET['t'];
        $categoryDetails = categories :: get_category_by_name($categoryName);
        echo json_encode($categoryDetails);
        exit;
    }
?>
