<?php
    require "../classes/categories.php";
    require "../classes/products.php";
?>
<?php
    if ($_SERVER["REQUEST_METHOD"] == "GET" && $_GET["q"] == "deletecategory") {
        $categoryImageFilename = categories :: get_category_src_by_name($_GET['t']);
        $productImageFilename = products :: get_product_src_by_category($_GET['t']);
        categories::delete_category_by_name($_GET['t']);
        products::delete_product_by_categoryname($_GET['t']);
    
        if (!empty($categoryImageFilename['srckategori'])) {
            $categoryImagePath = "../backend/categoryuploads/" . $categoryImageFilename['srckategori'];
            if (file_exists($categoryImagePath)) {
                unlink($categoryImagePath);
            }
        }
        foreach ($productImageFilename as $product) {
            if (!empty($product['srcproduk'])) {
                $productImagePath = "../backend/productuploads/" . $product['srcproduk'];
                if (file_exists($productImagePath)) {
                    unlink($productImagePath);
                }
            }
        }
    }
    
    if ($_SERVER["REQUEST_METHOD"] == "GET" && $_GET["q"] == "deleteproduct") {
        $productImageFilename = products :: get_product_src_by_name($_GET['t']);
        products::delete_product_by_productname($_GET['t']);
        
        if (!empty($productImageFilename['srcproduk'])) {
            $productImagePath = "../backend/productuploads/" . $productImageFilename['srcproduk'];
            if (file_exists($productImagePath)) {
                unlink($productImagePath);
            }
        }
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
