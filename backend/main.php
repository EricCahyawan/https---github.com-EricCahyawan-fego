<?php
    require "../classes/categories.php";
    require "../classes/productsclass.php";
?>
<?php
                            if(count($_POST) > 0 && isset($_POST['editcategorysubmit'])){
                                    $editcategoryradio = $_POST['editcategoryoptions'];
                                    $editcategoryname = $_POST['editcategoryname'];
                                    $editcategorydescription = $_POST['editcategorydescription'];
                                    $rowcounteditcategoryname = categories :: get_category_name_by_name_rowcount($editcategoryradio); 
                                    if($rowcounteditcategoryname > 0){
                                        $editcategoryfile = $_FILES['editcategoryimage'];
                                        $editcategoryfilename = $editcategoryfile['name'];
                                        $editcategoryfiletmpname = $editcategoryfile['tmp_name'];
                                        $editcategoryfilesize = $editcategoryfile['size'];
                                        $editcategoryfileerror = $editcategoryfile['error'];
                                        $editcategoryfileext = explode('.', $editcategoryfilename);
                                        $editcategoryfileactualext = strtolower(end($editcategoryfileext));
                                        $allowed = ['jpg', 'jpeg', 'png', 'pdf'];
                                        if(in_array($editcategoryfileactualext, $allowed)){
                                            if($editcategoryfileerror === 0){
                                                if($editcategoryfilesize < 10000000){
                                                    for($i = 1; ; $i++){
                                                        $editcategoryfilefinalname = uniqid("", true) . "." . $editcategoryfileactualext;
                                                        $rowcounteditcategoryfilefinalname = categories :: get_category_src_by_src($editcategoryfilefinalname);
                                                        if($rowcounteditcategoryfilefinalname === 0){
                                                            break;
                                                        }
                                                    }
                                                    $editcategoryfiledestination = "../backend/categoryuploads/" . $editcategoryfilefinalname;
                                                    move_uploaded_file($editcategoryfiletmpname, $editcategoryfiledestination);
                                                    categories :: edit_category($editcategoryname, $editcategorydescription, $editcategoryfilefinalname, $editcategoryradio);
                                                    echo "<script>
                                                        window.alert('The new version of {$editcategoryradio} has been uploaded.');
                                                        window.location.href = 'main.php';
                                                        </script>
                                                    ";
                                                }
                                                else{
                                                    echo "<script>window.alert('The uploaded file must not exceed 10mb!');</script>";
                                                }
                                            }
                                            else{
                                                echo "<script>window.alert('There was an error!');</script>";
                                            }
                                        }
                                        else{
                                            echo "<script>window.alert('This type of file cant be uploaded!');</script>";
                                        }
                                    }
                                    else{
                                        echo "<script>window.alert('Please select a different name for your category!');</script>";
                                    }
                            }
                        ?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>main</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <style>
        #welcometextcontainer {
            flex: 30%;
        }

        #welcometext {
            font-size: 60px;
            text-align: center; 
        }

        body {
            background-color: #3cdbf0;
            margin: 0;
        }

        #tengah {
            margin:0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            flex-wrap:nowrap;
        }

        #listfitur {
            flex: 70%;
            display: flex;
            flex-direction:row;
            flex-wrap: wrap;
            justify-content: center;
        }

        .buttonlistfitur {
            flex:25%;
            max-height: 5cm;
            max-width: 5cm;
            min-width: 3cm;
            min-height: 3cm;
            border-radius: 50%;
            background-color: #1a8c9d;
            border: none;
            box-shadow: 3px 3px 5px #191818;
            transition: transform 0.2s ease-in-out;
            margin:0.4cm;
        }

        .buttonlistfitur:hover {
            transform: translateY(-5px);
        }

        .buttonlistfitur:active {
            background-color: #0f6b7e;
        }
        img{
            margin:5px
        }
    </style>
  </head>
  <body id="body">
    <div id="tengah">
        <div class="container" id="welcometextcontainer">
            <h1 id="welcometext">WELCOME ADMIN</h1> 
        </div>
        <div class="container" id="listfitur">
            <button class="buttonlistfitur" id="addcategory" style="flex: 25%;" data-bs-toggle="modal" data-bs-target="#addcategorymodal">
                <img src="../assets/addcategory.png" alt="addcategory" style="height: 3.1cm; margin-top: 0.5cm;">
                <p><b>Add Category</b></p>
            </button>
            <button class="buttonlistfitur" id="deletecategory" style="flex: 25%;" data-bs-toggle="modal" data-bs-target="#editcategorymodal">
                <img src="../assets/deletecategory.png" alt="deletecategory" style="height: 3.3cm; margin-top: 0.5cm">
                <p><b>Edit Category</b></p> <!--edit sudah termasuk delete di dalamnya-->
            </button>
            <button class="buttonlistfitur" id="addproduct" style="flex: 25%;" data-bs-toggle="modal" data-bs-target="#addproductmodal">
                <img src="../assets/addproduct.png" alt="addproduct" style="height: 3.8cm;">
                <p><b>Add Product</b></p>
            </button>
            <button class="buttonlistfitur" id="deleteproduct" style="flex: 25%;">
                <img src="../assets/deleteproduct.png" alt="deleteproduct" style="height: 3.8cm;" data-bs-toggle="modal" data-bs-target="#editproductmodal">
                <p><b>Edit Product</b></p>
            </button>
        </div>
        <!--Modal add category-->
        <div class="modal fade" id="addcategorymodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <form id="addcategoryform" action="main.php" method="post" enctype="multipart/form-data">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel"><b>Add Category</b></h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label style="font-weight:600;">Name</label>
                                    <input type="text" class="form-control" name="categoryname" placeholder="Name" required>
                                </div>
                                <br>
                                <div class="form-group col-md-6">
                                    <label style="font-weight:600;">Description</label>
                                    <textarea name="categorydescription" id="" cols="30" rows="10" required></textarea>
                                </div>
                                <br>
                            </div>
                            <div class="form-group">
                                <label style="font-weight:600;">Image</label>
                                <input type="file" class="form-control" name="categoryimage" required>
                            </div>
                            <br>
                        </div>
                        <div class="modal-footer">
                            <button type="button" id="addcategoryclearbtn" class="btn btn-secondary">Clear All</button>
                            <button type="submit" class="btn btn-primary" data-bs-dismiss="modal" id="categorysubmit" name="categorysubmit" disabled>Submit</button>
                        </div>
                        <?php
                            if(count($_POST) > 0 && isset($_POST['categorysubmit'])){
                                    $categoryname = $_POST['categoryname'];
                                    $categorydescription = $_POST['categorydescription'];
                                    $rowcountcategoryname = categories :: get_category_name_by_name_rowcount($categoryname); 
                                    if($rowcountcategoryname === 0){
                                        $categoryfile = $_FILES['categoryimage'];
                                        $categoryfilename = $categoryfile['name'];
                                        $categoryfiletmpname = $categoryfile['tmp_name'];
                                        $categoryfilesize = $categoryfile['size'];
                                        $categoryfileerror = $categoryfile['error'];
                                        $categoryfileext = explode('.', $categoryfilename);
                                        $categoryfileactualext = strtolower(end($categoryfileext));
                                        $allowed = ['jpg', 'jpeg', 'png', 'pdf'];
                                        if(in_array($categoryfileactualext, $allowed)){
                                            if($categoryfileerror === 0){
                                                if($categoryfilesize < 10000000){
                                                    for($i = 1; ; $i++){
                                                        $categoryfilefinalname = uniqid("", true) . "." . $categoryfileactualext;
                                                        $rowcountcategoryfilefinalname = categories :: get_category_src_by_src($categoryfilefinalname);
                                                        if($rowcountcategoryfilefinalname === 0){
                                                            break;
                                                        }
                                                    }
                                                    $categoryfiledestination = "../backend/categoryuploads/" . $categoryfilefinalname;
                                                    move_uploaded_file($categoryfiletmpname, $categoryfiledestination);
                                                    categories :: add_category($categoryname, $categorydescription, $categoryfilefinalname);
                                                    echo "<script>window.alert('{$categoryname} has been uploaded!');</script>";
                                                }
                                                else{
                                                    echo "<script>window.alert('The uploaded file must not exceed 10mb!');</script>";
                                                }
                                            }
                                            else{
                                                echo "<script>window.alert('There was an error!');</script>";
                                            }
                                        }
                                        else{
                                            echo "<script>window.alert('This type of file cant be uploaded!');</script>";
                                        }
                                    }
                                    else{
                                        echo "<script>window.alert('Please select a different name for your new category!');</script>";
                                    }
                            }
                        ?>
                    </form>
                </div>
            </div>
        </div>
        <!--Modal edit category-->
        <div class="modal fade" id="editcategorymodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <form id="editcategoryform" action="main.php" method="post" enctype="multipart/form-data">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel"><b>Edit Category</b></h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="form-row">
                                <div class="form-group">
                                    <label style="font-weight:600;">Select Category</label>
                                    <div class="d-flex flex-wrap">
                                        <?php
                                            $allcategories = categories::get_allcategory();
                                            foreach ($allcategories as $category) {
                                                $namakategori = $category['namakategori'];
                                                echo "<div class='form-check me-3 mb-3'>";
                                                echo "<input class='form-check-input' type='radio' name='editcategoryoptions' id='editCategoryOption_{$namakategori}' value='{$namakategori}' required>";
                                                echo "<label class='form-check-label'>{$namakategori}</label>";
                                                echo "</div>";
                                            }
                                        ?>
                                    </div>
                                </div>
                                <br>
                                <div class="form-group col-md-6">
                                    <label style="font-weight:600;">Name</label>
                                    <input type="text" class="form-control" name="editcategoryname" placeholder="Name" required>
                                </div>
                                <br>
                                <div class="form-group col-md-6">
                                    <label style="font-weight:600;">Description</label>
                                    <textarea name="editcategorydescription" id="" cols="30" rows="10" required></textarea>
                                </div>
                                <br>
                            </div>
                            <div class="form-group">
                                <label style="font-weight:600;">Image</label>
                                <input type="file" class="form-control" name="editcategoryimage" required>
                            </div>
                            <br>
                        </div>
                        <div class="modal-footer">
                            <a href="#" id="editcategorydelete" style="color:red; text-decoration:none;">Delete Category</a>
                            <button type="button" id="editcategoryclearbtn" class="btn btn-secondary">Clear All</button>
                            <button type="submit" class="btn btn-primary" data-bs-dismiss="modal" id="editcategorysubmit" name="editcategorysubmit" disabled>Submit</button>
                        </div>
                        <script>
                            let editcategorydelete = document.querySelector("#editcategorydelete");
                            let editcategoryoptions;

                            editcategorydelete.addEventListener("click", () => {
                                const selectedRadio = document.querySelector('input[name="editcategoryoptions"]:checked');
                                if (selectedRadio) {
                                    editcategoryoptions = selectedRadio.value;
                                    function get_request_deletecategory() {
                                    	var xhttp = new XMLHttpRequest();
                                    	xhttp.onreadystatechange = function() {
                                    		if (this.readyState == 4 && this.status == 200) {
                                    			window.alert(editcategoryoptions +' has been deleted!');
                                                window.location.href="main.php";
                                    		}
                                    	};
                                    	xhttp.open("GET", "../ajax/mainajax.php?q=deletecategory&t="+editcategoryoptions, true);
                                    	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                                    	xhttp.send();
                                    }
                                    get_request_deletecategory();
                                } else {
                                    window.alert("Please select a category before deleting.");
                                }
                            });
                            let editcategoryoptions2;
                            // Function to update input fields based on selected category
                            function updateEditCategoryFields(categoryData) {
                                document.querySelector("input[name='editcategoryname']").value = categoryData.namakategori;
                                document.querySelector("textarea[name='editcategorydescription']").value = categoryData.keterangankategori;
                                // You may need to handle image update separately if needed
                            }

                            // Event listener for radio button changes
                            document.querySelectorAll("input[name='editcategoryoptions']").forEach(function (radio) {
                                radio.addEventListener("change", function () {
                                    editcategoryoptions2 = this.value;

                                    // Use AJAX to get category details based on the selected radio button
                                    var xhttp = new XMLHttpRequest();
                                    xhttp.onreadystatechange = function () {
                                        if (this.readyState == 4 && this.status == 200) {
                                            var categoryData = JSON.parse(this.responseText);
                                            updateEditCategoryFields(categoryData);
                                        }
                                    };
                                    xhttp.open("GET", "../ajax/mainajax.php?q=getcategorydetails&t=" + editcategoryoptions2, true);
                                    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                                    xhttp.send();
                                });
                            });
                        </script>
                    </form>
                </div>
            </div>
        </div>
        <!--Modal add product-->
        <div class="modal fade" id="addproductmodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <form id="addproductform" action="main.php" method="post" enctype="multipart/form-data">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel"><b>Add Product</b></h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label style="font-weight:600;">Name</label>
                                    <input type="text" class="form-control" name="productname" placeholder="Name" required>
                                </div>
                                <br>
                                <div class="form-group col-md-6">
                                    <label style="font-weight:600;">Description</label>
                                    <textarea name="productdescription" id="productdescription" cols="30" rows="10" required></textarea>
                                </div>
                                <br>
                            </div>
                            <div class="form-group">
                                <label style="font-weight:600;">Image</label>
                                <input type="file" class="form-control" name="productimage" required>
                            </div>
                            <br>
                            <div class="form-group">
                                <label style="font-weight:600;">Category</label>
                                <div class="d-flex flex-wrap">
                                    <?php
                                        foreach ($allcategories as $category) {
                                            $namakategori = $category['namakategori'];
                                            echo "<div class='form-check me-3 mb-3'>";
                                            echo "<input class='form-check-input' type='radio' name='addproductcategoryoptions' value='{$namakategori}' required>";
                                            echo "<label class='form-check-label'>{$namakategori}</label>";
                                            echo "</div>";
                                        }
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" id="addproductclearbtn" class="btn btn-secondary">Clear All</button>
                            <button type="submit" class="btn btn-primary" data-bs-dismiss="modal" name="productsubmit" id="productsubmit" disabled>Submit</button>
                        </div>
                        <?php
                            if(count($_POST) > 0 && isset($_POST['productsubmit'])){
                                $productname = $_POST['productname'];
                                $productdescription = $_POST['productdescription'];
                                $productcategory = $_POST['addproductcategoryoptions'];
                                $rowcountproductname = products :: get_product_name_by_name_rowcount($productname);
                                if($rowcountproductname === 0){
                                    $productfile = $_FILES['productimage'];
                                    $productfilename = $productfile['name'];
                                    $productfiletmpname = $productfile['tmp_name'];
                                    $productfilesize = $productfile['size'];
                                    $productfileerror = $productfile['error'];
                                    $productfileext = explode('.', $productfilename);
                                    $productfileactualext = strtolower(end($productfileext));
                                    $allowed = ['jpg', 'jpeg', 'png', 'pdf'];
                                    if(in_array($productfileactualext, $allowed)){
                                        if($productfileerror === 0){
                                            if($productfilesize < 10000000){
                                                for($i = 1; ; $i++){
                                                    $productfilefinalname = uniqid("", true) . "." . $productfileactualext;
                                                    $rowcountproductfilefinalname = products :: get_product_src_by_src_rowcount($productfilefinalname);
                                                    if($rowcountproductfilefinalname === 0){
                                                        break;
                                                    }
                                                }
                                                $productfiledestination = "../backend/productuploads/" . $productfilefinalname;
                                                move_uploaded_file($productfiletmpname, $productfiledestination);
                                                products :: add_product($productname, $productdescription, $productfilefinalname, $productcategory);
                                                echo "<script>window.alert('{$productname} has been uploaded.');</script>";
                                            }
                                            else{
                                                echo "<script>window.alert('The uploaded file must not exceed 10mb!');</script>";
                                            }
                                        }
                                        else{
                                            echo "<script>window.alert('There was an error!');</script>";
                                        }
                                    }
                                    else{
                                        echo "<script>window.alert('This type of file can't be uploaded!');</script>";
                                    }
                                }
                                else{
                                    echo "<script>window.alert('Please select a different name for your new product!');</script>";
                                }
                            }
                        ?>
                    </form>
                </div>
            </div>
        </div>
        <!--Modal edit product-->
        <div class="modal fade" id="editproductmodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <form id="editproductform" action="main.php" method="post" enctype="multipart/form-data">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel"><b>Edit Product</b></h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="form-row">
                                <div class="form-group">
                                    <label style="font-weight:600;">Select Product</label>
                                    <div class="d-flex flex-wrap">
                                        <?php
                                            $allcategories = products :: get_all_products();
                                            foreach ($allcategories as $product) {
                                                $namaproduk = $product['namaproduk'];
                                                echo "<div class='form-check me-3 mb-3'>";
                                                echo "<input class='form-check-input' type='radio' name='editproductoptions' id='editproductoptions{$namaproduk}' value='{$namaproduk}' required>";
                                                echo "<label class='form-check-label'>{$namaproduk}</label>";
                                                echo "</div>";
                                            }
                                        ?>
                                    </div>
                                </div>
                                <br>
                                <div class="form-group col-md-6">
                                    <label style="font-weight:600;">Name</label>
                                    <input type="text" class="form-control" name="editproductname" placeholder="Name" required>
                                </div>
                                <br>
                                <div class="form-group col-md-6">
                                    <label style="font-weight:600;">Description</label>
                                    <textarea name="editproductdescription" id="" cols="30" rows="10" required></textarea>
                                </div>
                                <br>
                            </div>
                            <div class="form-group">
                                <label style="font-weight:600;">Image</label>
                                <input type="file" class="form-control" name="editproductimage" required>
                            </div>
                            <br>
                        </div>
                        <div class="modal-footer">
                            <a href="#" id="editproductdelete" style="color:red; text-decoration:none;">Delete Product</a>
                            <button type="button" id="editproductclearbtn" class="btn btn-secondary">Clear All</button>
                            <button type="submit" class="btn btn-primary" data-bs-dismiss="modal" id="editproductsubmit" name="editproductsubmit" disabled>Submit</button>
                        </div>
                        <script>
                            let editproductdelete = document.querySelector("#editproductdelete");
                            let editproductoptions;

                            editproductdelete.addEventListener("click", () => {
                                const editproductselectedRadio = document.querySelector('input[name="editproductoptions"]:checked');
                                if (editproductselectedRadio) {
                                    editproductoptions = editproductselectedRadio.value;
                                    function get_request_deleteproduct() {
                                    	var xhttp = new XMLHttpRequest();
                                    	xhttp.onreadystatechange = function() {
                                    		if (this.readyState == 4 && this.status == 200) {
                                    			window.alert(editproductoptions +' has been deleted!');
                                                window.location.href="main.php";
                                    		}
                                    	};
                                    	xhttp.open("GET", "../ajax/mainajax.php?q=deleteproduct&t="+editproductoptions, true);
                                    	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                                    	xhttp.send();
                                    }
                                    get_request_deleteproduct();
                                } else {
                                    window.alert("Please select a product before deleting.");
                                }
                            });
                            let editproductoptions2;
                            // Function to update input fields based on selected product
                            function updateEditProductFields(productData) {
                                const firstProduct = productData[0];
                                document.querySelector("input[name='editproductname']").value = firstProduct.namaproduk;
                                document.querySelector("textarea[name='editproductdescription']").value = firstProduct.keteranganproduk;
                            }

                            // Event listener for edit product radio button changes
                            document.querySelectorAll("input[name='editproductoptions']").forEach(function (radio) {
                                radio.addEventListener("change", function () {
                                    editproductoptions2 = this.value;

                                    // Use AJAX to get product details based on the selected radio button
                                    var xhttp2 = new XMLHttpRequest();
                                    xhttp2.onreadystatechange = function () {
                                        if (this.readyState == 4 && this.status == 200) {
                                            var productData = JSON.parse(this.responseText);
                                            updateEditProductFields(productData);
                                        }
                                    };
                                    xhttp2.open("GET", "../ajax/mainajax.php?q=getproductdetails&t=" + editproductoptions2, true);
                                    xhttp2.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                                    xhttp2.send();
                                });
                            });
                        </script>
                    </form>
                </div>
            </div>
        </div>
        <?php
            if(count($_POST) > 0 && isset($_POST['editproductsubmit'])){
                $editproductradio = $_POST['editproductoptions'];
                $editproductname = $_POST['editproductname'];
                $editproductdescription = $_POST['editproductdescription'];
                $rowcounteditproductname = products :: get_product_name_by_name_rowcount($editproductname);
                if($rowcounteditproductname === 0){
                    $editproductfile = $_FILES['editproductimage'];
                    $editproductfilename = $editproductfile['name'];
                    $editproductfiletmpname = $editproductfile['tmp_name'];
                    $editproductfilesize = $editproductfile['size'];
                    $editproductfileerror = $editproductfile['error'];
                    $editproductfileext = explode('.', $editproductfilename);
                    $editproductfileactualext = strtolower(end($editproductfileext));
                    $allowed = ['jpg', 'jpeg', 'png', 'pdf'];
                    if(in_array($editproductfileactualext, $allowed)){
                        if($editproductfileerror === 0){
                            if($editproductfilesize < 10000000){
                                for($i = 1; ; $i++){
                                    $editproductfilefinalname = uniqid("", true) . "." . $editproductfileactualext;
                                    $rowcounteditproductfilefinalname = products :: get_product_src_by_src_rowcount($editproductfilefinalname);
                                    if($rowcounteditproductfilefinalname === 0){
                                        break;
                                    }
                                }
                                $editproductfiledestination = "../backend/productuploads/" . $editproductfilefinalname;
                                move_uploaded_file($editproductfiletmpname, $editproductfiledestination);
                                products :: edit_product($editproductname, $editproductdescription, $editproductfilefinalname, $editproductradio);
                                echo "<script>
                                    window.alert('The new version of {$editproductradio} has been uploaded.');
                                    window.location.href = 'main.php';
                                    </script>
                                ";
                            }
                            else{
                                echo "<script>window.alert('The uploaded file must not exceed 10mb!');</script>";
                            }
                        }
                        else{
                            echo "<script>window.alert('There was an error!');</script>";
                        }
                    }
                    else{
                        echo "<script>window.alert('This type of file cant be uploaded!');</script>";
                    }
                }
                else{
                    echo "<script>window.alert('Please select a different name for your product!');</script>";
                }
        }
    ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
  </body>
</html>
<script>
    
    // let btn_addcategory = document.querySelector("#addcategory");
    // let body = document.querySelector("#body");
    // function get_request_addcategory() {
	// 	var xhttp = new XMLHttpRequest();
	// 	xhttp.onreadystatechange = function() {
	// 		if (this.readyState == 4 && this.status == 200) {
	// 			body.innerHTML = this.responseText;
	// 		}
	// 	};
	// 	xhttp.open("GET", "../ajax/mainajax.php?q=addcategory", true);
	// 	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	// 	xhttp.send();
	// }

    // if(btn_addcategory)
    // {
    //     btn_addcategory.addEventListener("click", ()=>{
    //         get_request_addcategory();
    //     });
    // }
    //-------------------------CLEAR ALL BUTTON-------------------------
    document.querySelector('#addcategoryclearbtn').addEventListener("click", () => {
        document.querySelector('#addcategoryform').reset();
    });
    document.querySelector('#editcategoryclearbtn').addEventListener("click", () => {
        document.querySelector('#editcategoryform').reset();
    });
    document.querySelector('#addproductclearbtn').addEventListener("click", () => {
        document.querySelector('#addproductform').reset();
    });
    //-------------------------CLEAR ALL BUTTON-------------------------

    //-------------------------ALL FIELDS MUST BE FILLED IN-------------------------
    const addcategoryform = document.getElementById('addcategoryform');
    const categorysubmit = document.getElementById('categorysubmit');
    addcategoryform.addEventListener('input', function() {
        if (addcategoryform.checkValidity()) {
            categorysubmit.removeAttribute('disabled');
        } else {
            categorysubmit.setAttribute('disabled', 'true');
        }
    });
    const editcategoryform = document.getElementById('editcategoryform');
    const editcategorysubmit = document.getElementById('editcategorysubmit');
    editcategoryform.addEventListener('input', function() {
        if (editcategoryform.checkValidity()) {
            editcategorysubmit.removeAttribute('disabled');
        } else {
            editcategorysubmit.setAttribute('disabled', 'true');
        }
    });
    const addproductform = document.getElementById('addproductform');
    const productsubmit = document.getElementById('productsubmit');
    addproductform.addEventListener('input', function() {
        if (addproductform.checkValidity()) {
            productsubmit.removeAttribute('disabled');
        } else {
            productsubmit.setAttribute('disabled', 'true');
        }
    });
    const editproductform = document.getElementById('editproductform');
    const editproductsubmit = document.getElementById('editproductsubmit');
    editproductform.addEventListener('input', function() {
        if (editproductform.checkValidity()) {
            editproductsubmit.removeAttribute('disabled');
        } else {
            editproductsubmit.setAttribute('disabled', 'true');
        }
    });
    //-------------------------ALL FIELDS MUST BE FILLED IN-------------------------

    //-------------------------CLEAR BUTTON DISABLE OTHER BUTTON-------------------------
    document.querySelector('#editcategoryclearbtn').addEventListener("click", () => {
        document.querySelector('#editcategoryform').reset();
        const editCategorySubmit = document.getElementById('editcategorysubmit');
        editCategorySubmit.setAttribute('disabled', 'true');
    });
    document.querySelector('#addcategoryclearbtn').addEventListener("click", () => {
        document.querySelector('#addcategoryform').reset();
        const categorysubmit = document.getElementById('categorysubmit');
        categorysubmit.setAttribute('disabled', 'true');
    });
    document.querySelector('#addproductclearbtn').addEventListener("click", () => {
        document.querySelector('#addproductform').reset();
        const productsubmit = document.getElementById('productsubmit');
        productsubmit.setAttribute('disabled', 'true');
    });
    document.querySelector('#editproductclearbtn').addEventListener("click", () => {
        document.querySelector('#editproductform').reset();
        const editproductsubmit = document.getElementById('editproductsubmit');
        editproductsubmit.setAttribute('disabled', 'true');
    });
    //-------------------------CLEAR BUTTON DISABLE OTHER BUTTON-------------------------
</script>