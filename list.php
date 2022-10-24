<?php require "connect.php"; 
    $name=isset($_POST["name"])?$_POST["name"]:"";
    $price=isset($_POST["price"])?$_POST["price"]:"";
    $quantity=isset($_POST["quantity"])?$_POST["quantity"]:"";
    
    session_start(); 
    //to update product in database
    if(isset($_POST["id"])&& strlen($name)>0 && strlen($price)>0 && strlen($quantity)>0){
        $stmt=$pdo->prepare("
            UPDATE products SET name= :name , price= :price , quantity= :quantity
            WHERE id=".$_POST["id"]);
        $stmt->execute(array(
            ":name"=>$_POST["name"],
            ":price"=>$_POST["price"],
            ":quantity"=>$_POST["quantity"]
        ));
        $_SESSION["message"]="the product updated successfully";
    }
    //to insert product into database  
    elseif(strlen($name)>0 && strlen($price)>0 && strlen($quantity)>0){
        $stmt=$pdo->prepare("INSERT INTO products(name,price,quantity) VALUES (:name,:price,:quantity)");
        $stmt->execute(array(
            ":name"=>$_POST["name"],
            ":price"=>$_POST["price"],
            ":quantity"=>$_POST["quantity"]
        ));
        $_SESSION["message"]="the product inserted successfully";
        
    }elseif(isset($_SERVER["HTTP_REFERER"])&&isset($_POST["name"])&&isset($_POST["price"])&&isset($_POST["quantity"])){
        header("location: ". $_SERVER["HTTP_REFERER"]);
        $_SESSION["error"]="please enter data to be inserted";
    }
    if(isset($_GET["id"])){
        $stmt=$pdo->query("DELETE FROM products WHERE id=".$_GET["id"]);
        $_SESSION["delete_success"]="the item deleted successfully";
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>products</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</head>
<body>
    <div class="w-50 ms-5 text-center">
        <h3 class="m-4">products list</h3>
        <?php
            if(isset($_SESSION["message"])){
                echo "<p class='alert alert-success'>".$_SESSION["message"]."</p>";
                unset($_SESSION["message"]);    
            }
            if(isset($_SESSION["delete_success"])){
                echo "<p class='alert alert-success'>".$_SESSION["delete_success"]."</p>";
                unset($_SESSION["delete_success"]);
            }
        ?>
        <table class="table table-striped">
            <thead>
                <tr>
                <th scope="col">ID</th>
                <th scope="col">Name</th>
                <th scope="col">Price</th>
                <th scope="col">Quantity</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    $stmt=$pdo->query("SELECT * FROM products");
                    while($row=$stmt->fetch(PDO::FETCH_ASSOC)):
                 ?>
                 <tr>
                    <td><?= $row["id"] ?></td>
                    <td><?= $row["name"] ?></td>
                    <td><?= $row["price"] ?></td>
                    <td><?= $row["quantity"] ?></td>
                    <td><a href="list.php?id=<?= $row["id"]; ?>" class="btn btn-danger">Delete</a></td>
                    <td>
                        <a 
                         href="form.php?id=<?= $row["id"] ?>&name=<?= $row["name"] ?>&price=<?= $row["price"] ?>&quantity=<?= $row["quantity"] ?>"
                         class="btn btn-primary">Update</a>
                    </td>
                 </tr>
                 <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>