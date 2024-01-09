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
        button{
            height: 5cm;
            width: 5cm;
            border-radius: 50%;
            margin: 1cm;
            background-color: #1a8c9d;
            border: none;
            box-shadow: 3px 3px 5px #191818;
            transition: transform 0.2s ease-in-out;
        }
        button:hover{
            transform: translateY(-5px);
        }
        button:active{
            background-color: #0f6b7e;
        }
    </style>
  </head>
  <body id="body">
    <div id="tengah">
        <h1 style="font-size: 60px;">WELCOME ADMIN</h1> <!--"ADMIN" diganti dengan $_SESSION['usernameadmin']-->
        <hr>
        <div id="listfitur">
            <button id="addcategory" style="flex: 25%;">
                <img src="../assets/addcategory.png" alt="addcategory" style="height: 3.1cm; margin-top: 0.5cm;">
                <p><b>Add Category</b></p>
            </button>
            <button id="deletecategory" style="flex: 25%;">
                <img src="../assets/deletecategory.png" alt="deletecategory" style="height: 3.3cm;">
                <b>Delete Category</b>
            </button>
            <button id="addproduct" style="flex: 25%;">
                <img src="../assets/addproduct.png" alt="addproduct" style="height: 3.8cm;">
                <b>Add Product</b>
            </button>
            <button id="deleteproduct" style="flex: 25%;">
                <img src="../assets/deleteproduct.png" alt="deleteproduct" style="height: 3.8cm;">
                <b>Delete Product</b>
            </button>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
  </body>
</html>
<script>
    let btn_addcategory = document.querySelector("#addcategory");
    let body = document.querySelector("#body");
    function get_request_addcategory() {
		var xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				body.innerHTML = this.responseText;
			}
		};
		xhttp.open("GET", "../ajax/mainajax.php?q=addcategory", true);
		xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		xhttp.send();
	}

    if(btn_addcategory)
    {
        btn_addcategory.addEventListener("click", ()=>{
            get_request_addcategory();
        });
    }
</script>