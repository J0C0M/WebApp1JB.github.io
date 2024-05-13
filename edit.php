<?php 
$id = "";
$name = "";
$discription = "";
$price = "";

include("conn.php");

$id = "";
$name = "";
$discription = "";
$price = "";

$errorMessage = "";
$successMessage = "";

if ( $_SERVER[ 'REQUEST_METHOD' ] == 'GET' ) {
    if ( !isset($_GET["id"]) ) {
        header("Location: admin.php");
        exit;
    }   

    $id = $_GET["id"];

    $sql = "SELECT * FROM menukaart WHERE id=$id";
    $stmt = $pdo->query($sql);
    $menukaart = $stmt->fetch();

    if (!$menukaart) {
        header("Location: admin.php");     
        exit;   
    }

    $name = $menukaart["name"];
    $discription = $menukaart["discription"];
    $price = $menukaart["price"];
    
}
else {
    $id = $_POST["id"];
    $name = $_POST["name"];
    $discription =  $_POST["discription"];
    $price =  $_POST["price"];

    do {
        if ( empty($id) || empty($name) || empty($discription) || empty($price) ) {
            $errorMessage = "All the fields are required";
            break;
        }

        $sql = "UPDATE menukaart " .
        "SET name=  '$name',  discription = '$discription', price = '$price' " . 
        "WHERE id = $id";

        $stmt = $pdo->query($sql);

        if (!$stmt) {
            $errorMessage = "Invalid query: " . $pdo->error;
            break;
        } 

        $successMessage = "Client updated correctly";

        header("Location: admin.php");
        exit;

    } while (true);
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>da shop</title>
    <link rel="stylesheet" href="css/pannenkoeken.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <div class="container my-5">
        <h2>Edit Item</h2>

        <?php 
        if ( !empty($errorMessage)) {
            echo "
            <div>
                <strong>$errorMessage</strong>
                <button type='button' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>
            ";
        }
        ?>

        <form class="form" method="post">
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <div>
                <label>Name</label>
                <div>
                    <input type="text" name="name" value="<?php echo $name; ?>">
                </div>
            </div>
            <div>
                <label>Omschrijving</label>
                <div>
                    <input type="text" name="omschrijving" value="<?php echo $discription; ?>">
                </div>
            </div>
            <div>
                <label>Prijs</label>
                <div>
                    <input type="text" name="prijs" value="<?php echo $price; ?>">
                </div>
            </div>

            <?php 
            if ( !empty($successMessage)) {
                echo "
                <div role='alert'>
                <strong>$successMessage</strong>
                <button type='button' ></button>
            </div>
                ";
            }
            ?>

            <div>
                <div>
                    <button type="text" name="omschrijving" value="">Submit</button>
                </div>
                <div>
                    <a class="btn" href="admin.php" role="button">Cancel</a>
                </div>
            </div>
        </form>
    </div>    
</body>
</html>