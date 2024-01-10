<?php
    require "../classes/categories.php";
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>main</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <style>
        body {
            background-color: #3cdbf0;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
        }
        #tengah{
            width: 1000px; /* Adjust width as needed */
            height: 500px; /* Adjust height as needed */
            display: flex;
            flex-direction: column;
            flex-wrap: nowrap;
            align-items: center;
            justify-content: center;
        }
        #listfitur{
            display: flex;
            flex-direction: row;
            flex-wrap: nowrap;
            justify-content: center;
            align-items: center;
        }
        .buttonlistfitur{
            height: 5cm;
            width: 5cm;
            border-radius: 50%;
            margin: 1cm;
            background-color: #1a8c9d;
            border: none;
            box-shadow: 3px 3px 5px #191818;
            transition: transform 0.2s ease-in-out;
        }
        .buttonlistfitur:hover{
            transform: translateY(-5px);
        }
        .buttonlistfitur:active{
            background-color: #0f6b7e;
        }
    </style>
  </head>
  <body id="body">
    <div id="tengah">
        <h1 style="font-size: 60px;">WELCOME ADMIN</h1> <!--"ADMIN" diganti dengan $_SESSION['usernameadmin']-->
        <hr>
        <div id="listfitur">
            <button class="buttonlistfitur" id="addcategory" style="flex: 25%;" data-bs-toggle="modal" data-bs-target="#addcategorymodal">
                <img src="../assets/addcategory.png" alt="addcategory" style="height: 3.1cm; margin-top: 0.5cm;">
                <p><b>Add Category</b></p>
            </button>
            <button class="buttonlistfitur" id="deletecategory" style="flex: 25%;">
                <img src="../assets/deletecategory.png" alt="deletecategory" style="height: 3.3cm; margin-top: 0.5cm">
                <p><b>Edit Category</b></p> <!--edit sudah termasuk delete di dalamnya-->
            </button>
            <button class="buttonlistfitur" id="addproduct" style="flex: 25%;">
                <img src="../assets/addproduct.png" alt="addproduct" style="height: 3.8cm;">
                <p><b>Add Product</b></p>
            </button>
            <button class="buttonlistfitur" id="deleteproduct" style="flex: 25%;">
                <img src="../assets/deleteproduct.png" alt="deleteproduct" style="height: 3.8cm;">
                <p><b>Edit Product</b></p>
            </button>
        </div>
         <!--Modal add category-->
        <div class="modal fade" id="addcategorymodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <form action="main.php" method="post" enctype="multipart/form-data">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Add Category</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="inputEmail4">Name</label>
                                    <input type="text" class="form-control" name="categoryname" placeholder="Name">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="inputPassword4">Description</label>
                                    <input type="text" class="form-control" name="categorydescription" placeholder="Description">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputAddress">Image</label>
                                <input type="file" class="form-control" name="categoryimage">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Clear all</button>
                            <button type="submit" class="btn btn-primary" data-bs-dismiss="modal" name="categorysubmit">Submit</button>
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
                                                echo "<script>window.alert('Your file has been uploaded.');</script>";
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
                                    echo "<script>window.alert('Please select a different name for your new category!');</script>";
                                }
                            }
                        ?>
                    </form>
                </div>
            </div>
        </div>
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
</script>