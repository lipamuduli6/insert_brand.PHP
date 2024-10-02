<?php
include('includes/connect.php');
include('functions/common_function.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-commerce website details</title>
    <!-- Bootstrap CSS link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!-- Font Awesome link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Custom CSS link -->
    <link rel="stylesheet" href="style.css">
    <style>
        .card img {
            width: 90%;
            height: 240px;
            object-fit: contain;
        }
        .card {
            margin-bottom: 20px;
        }
        .logo {
            max-width: 100px; /* Adjust the size as needed */
            height: auto;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <div class="container-fluid p-0">
        <nav class="navbar navbar-expand-lg navbar-light bg-info">
            <div class="container-fluid">
                <a class="navbar-brand" href="index.php">
                    <img src="./img/food10.avif" alt="Logo" class="logo">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="index.php">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="display_all.php">Products</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="./users_area/user_login.php">Register</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Contact</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="cart.php"><i class="fa-solid fa-cart-shopping"></i><sup><?php cart_item();?></sup></a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <!-- calling cart function -->
        <?php cart(); ?>

        <!-- second child -->
        <nav class="navbar navbar-expand-lg navbar-dark bg-secondary">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link" href="#">Welcome Guest</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Login</a>
                </li>
            </ul>
        </nav>

        <!-- third child -->
        <div class="bg-light">
            <h3 class="text-center">Hidden Store</h3>
            <p class="text-center">Communication is at the heart of e-commerce and community</p>
        </div>

        <!-- Fourth child table -->
        <div class="container">
            <div class="row">
                <form action="" method="post">
                    <table class="table table-bordered text-center">
                       
                            <!-- PHP code to display dynamic data -->
                            <?php
                            $get_ip_add = getIPAddress();
                            $total_price = 0;
                            $cart_query = "SELECT * FROM `cart_details` WHERE ip_address = '$get_ip_add'";
                            $result= mysqli_query($con, $cart_query);
                            $result_count=mysqli_num_rows($result);
                            if($result_count>0){
                                echo " <thead>
                            <tr>
                                <th>Product Title</th>
                                <th>Product Image</th>
                                <th>Quantity</th>
                                <th>Total Price</th>
                                <th>Remove</th>
                                <th colspan='2'>Operation</th>
                            </tr>
                        </thead>
                        <tbody>";

                           

                            while($row = mysqli_fetch_array($result)) {
                                $product_id = $row['product_id'];
                                $quantity = $row['quantity'];
                                $select_products = "SELECT * FROM `products` WHERE product_id = $product_id";
                                $result_products = mysqli_query($con, $select_products);

                                while($row_product_price = mysqli_fetch_array($result_products)) {
                                    $product_price = $row_product_price['product_price'];
                                    $product_title = $row_product_price['product_title'];
                                    $product_image1 = $row_product_price['product_image1'];
                                    $total_price += $product_price * $quantity;
                                    ?>
                                    <tr>
                                        <td><?php echo $product_title; ?></td>
                                        <td><img src="./img/<?php echo $product_image1; ?>" alt="" class="cart_img" style="max-width: 100px;"></td>
                                        <td><input type="number" name="qty[<?php echo $product_id; ?>]" value="<?php echo $quantity; ?>" min="1" class="form-input w-50"></td>
                                        <td><?php echo $product_price * $quantity; ?>/-</td>
                                        <td><input type="checkbox" name="removeitem[]" value="<?php echo $product_id; ?>"></td>
                                        <td>
                                            <input type="submit" value="Update Cart" class="bg-info px-3 py-2 border-0 mx-3" name="update_cart">
                                            <input type="submit" value="Remove Cart" class="bg-info px-3 py-2 border-0 mx-3" name="remove_cart">
                                        </td>
                                    </tr>
                                    <?php
                                }
                            } }
                            else{
                                echo "<h2 class='text-center text-danger'>Cart is empty</h2>";
                            }
                            ?>
                        </tbody>
                    </table>

                    <!-- Subtotal -->
                    <div class="d-flex mb-5">
                        <?php
                        $get_ip_add = getIPAddress();
                        
                        $cart_query = "SELECT * FROM `cart_details` WHERE ip_address = '$get_ip_add'";
                        $result= mysqli_query($con, $cart_query);
                        $result_count=mysqli_num_rows($result);
                        if($result_count>0){
                            echo "
                        <h4 class='px-3'>Subtotal: <strong class='text-info' id='subtotal'>$total_price/-</strong></h4>
                        <a href='index.php'><button type='button' class='bg-info px-3 py-2 border-0 mx-3'>Continue Shopping</button></a>
                        <button type='button' class='bg-secondary p-3 py-2 border-0 text-light'><a href='../users_area/checkout.php' class='text-light text-decoration-none'>Checkout</button>";
                        }else{
                            echo "<a href='index.php'><button type='button' class='bg-info px-3 py-2 border-0 mx-3'>Continue Shopping</button></a>";
                        }
                     ?>
                    </div>
                </form>
            </div>
        </div>

        <!-- PHP functions for cart operations -->
        <?php
        function update_cart() {
            global $con;
            if(isset($_POST['update_cart'])) {
                foreach($_POST['qty'] as $product_id => $quantity) {
                    $get_ip_add = getIPAddress();
                    $update_cart = "UPDATE `cart_details` SET quantity = $quantity WHERE ip_address = '$get_ip_add' AND product_id = $product_id";
                    mysqli_query($con, $update_cart);
                }
                echo "<script>window.open('cart.php', '_self')</script>";
            }
        }

        function remove_cart_item() {
            global $con;
            if (isset($_POST['remove_cart'])) {
                if (isset($_POST['removeitem'])) {
                    foreach ($_POST['removeitem'] as $remove_id) {
                        $stmt = $con->prepare("DELETE FROM `cart_details` WHERE product_id = ?");
                        $stmt->bind_param("i", $remove_id);
                        $stmt->execute();
                        $stmt->close();
                    }
                    echo "<script>window.open('cart.php','_self')</script>";
                }
            }
        }

        update_cart();
        remove_cart_item();
        ?>

        <!-- Last child -->
        <!-- Include footer -->
        <?php include("./includes/footer.php"); ?>
        
        <!-- Bootstrap JS link -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    </div>
</body>
</html>
