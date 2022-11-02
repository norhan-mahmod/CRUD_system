<?php
$server="localhost";
$dbname="makeup_store";
$usernam="root";
$password="";
$pdo=new PDO("mysql:host=$server;dbname=$dbname",$usernam,$password);


function show_products(){ 
    global $pdo;
    $stmt=$pdo->query("SELECT p.id, p.name, p.price, p.quantity, p.category_id , c.name AS category_name
                        FROM products AS p, categories AS c 
                        WHERE p.category_id=c.id
    ");
    while($row=$stmt->fetch(PDO::FETCH_ASSOC)): ?>
        <tr>
            <td><?= $row["id"] ?></td>
            <td><?= $row["name"] ?></td>
            <td><?= $row["price"] ?></td>
            <td><?= $row["quantity"] ?></td>
            <td><?= $row["category_name"] ?></td>
            <td><a href="list.php?id=<?= $row["id"]; ?>" class="btn btn-danger">Delete</a></td>
            <td>
                <a 
                href="form.php?id=<?= $row["id"] ?>&name=<?= $row["name"] ?>&price=<?= $row["price"] ?>&quantity=<?= $row["quantity"] ?>&category=<?= $row["category_id"] ?>" class="btn btn-primary">Update</a>
            </td>
        </tr>
 <?php endwhile;
}

function update_product(){
    global $pdo;
    $stmt=$pdo->prepare("
        UPDATE products SET name= :name , price= :price , quantity= :quantity , category_id= :category
        WHERE id=".$_POST["id"]);
    $stmt->execute(array(
        ":name"=>$_POST["name"],
        ":price"=>$_POST["price"],
        ":quantity"=>$_POST["quantity"],
        ":category"=>$_POST["category"]
    ));
    $_SESSION["message"]="the product updated successfully";
}

function insert_product(){
    global $pdo;
    $stmt=$pdo->prepare("INSERT INTO products(name,price,quantity,category_id) VALUES (:name,:price,:quantity,:category_id)");
        $stmt->execute(array(
            ":name"=>$_POST["name"],
            ":price"=>$_POST["price"],
            ":quantity"=>$_POST["quantity"],
            ":category_id"=>$_POST["category"]
        ));
    $_SESSION["message"]="the product inserted successfully";
}

function delete_product(){
    global $pdo;
    $stmt=$pdo->query("DELETE FROM products WHERE id=".$_GET["id"]);
}

function select_all_categories(){
    global $pdo;
    $stmt=$pdo->query("SELECT * FROM categories");
    while($row=$stmt->fetch(PDO::FETCH_ASSOC)): ?>
        <option value="<?= $row["id"] ?>" <?= isset($_GET["category"])&&$row["id"]==$_GET["category"]? "selected" : ""?> >
            <?= $row["name"] ?>
        </option>
    <?php endwhile;
}

