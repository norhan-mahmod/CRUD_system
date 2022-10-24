<!DOCTYPE html>
<html lang="en">
<head>
    <title>submit form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</head>
<body>
  <form action="list.php" method="post">
        <div class="w-50 text-center m-4">
            <h3 class="m-3">products form</h3>
                <?php 
                    session_start();
                    if(isset($_SESSION["error"])){
                        echo "<p class='alert alert-danger'>".$_SESSION["error"]."</p>";
                        unset($_SESSION["error"]);
                    }
                    $update=isset($_GET["id"])&&isset($_GET["name"])&&isset($_GET["price"])&&isset($_GET["quantity"]);
                ?>
            <!-- product name input -->
            <div class="mb-3 row">
                <label for="productname" class="col-sm-4 col-form-label">product name</label>
                <div class="col-sm-8">
                <input type="text" name="name" class="form-control" id="productname" value="<?= $update?$_GET["name"]:'' ?>">
                </div>
            </div>
            <!-- price input -->
            <div class="mb-3 row">
                <label for="productprice" class="col-sm-4 col-form-label">product price</label>
                <div class="col-sm-8">
                <input type="number" name="price" class="form-control" id="productprice" value="<?= $update?$_GET["price"]:'' ?>">
                </div>
            </div>
            <!-- quantity input -->
            <div class="mb-3 row">
                <label for="productquantity" class="col-sm-4 col-form-label">product quantity</label>
                <div class="col-sm-8">
                <input type="number" name="quantity" class="form-control" id="productquantity" value="<?= $update?$_GET["quantity"]:'' ?>">
                </div>
            </div>
            <?php if($update): ?> 
                <input class="d-none" name="id" value="<?= $_GET["id"] ?>">
            <?php endif; ?>
            <button type="submit" class="btn btn-primary">Save</button>
        </div>
  </form>
</body>
</html>