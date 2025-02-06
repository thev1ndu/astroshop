<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:admin_login.php');
}

if(isset($_POST['update'])){

   $pid = $_POST['pid'];
   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $price = $_POST['price'];
   $price = filter_var($price, FILTER_SANITIZE_STRING);
   $details = $_POST['details'];
   $details = filter_var($details, FILTER_SANITIZE_STRING);

   $update_product = $conn->prepare("UPDATE `products` SET name = ?, price = ?, details = ? WHERE id = ?");
   $update_product->execute([$name, $price, $details, $pid]);

   $message[] = 'product updated successfully!';

   $old_image_01 = $_POST['old_image_01'];
   $image_01 = $_FILES['image_01']['name'];
   $image_01 = filter_var($image_01, FILTER_SANITIZE_STRING);
   $image_size_01 = $_FILES['image_01']['size'];
   $image_tmp_name_01 = $_FILES['image_01']['tmp_name'];
   $image_folder_01 = '../uploaded_img/'.$image_01;

   if(!empty($image_01)){
      if($image_size_01 > 2000000){
         $message[] = 'image size is too large!';
      }else{
         $update_image_01 = $conn->prepare("UPDATE `products` SET image_01 = ? WHERE id = ?");
         $update_image_01->execute([$image_01, $pid]);
         move_uploaded_file($image_tmp_name_01, $image_folder_01);
         unlink('../uploaded_img/'.$old_image_01);
         $message[] = 'image 01 updated successfully!';
      }
   }

   $old_image_02 = $_POST['old_image_02'];
   $image_02 = $_FILES['image_02']['name'];
   $image_02 = filter_var($image_02, FILTER_SANITIZE_STRING);
   $image_size_02 = $_FILES['image_02']['size'];
   $image_tmp_name_02 = $_FILES['image_02']['tmp_name'];
   $image_folder_02 = '../uploaded_img/'.$image_02;

   if(!empty($image_02)){
      if($image_size_02 > 2000000){
         $message[] = 'image size is too large!';
      }else{
         $update_image_02 = $conn->prepare("UPDATE `products` SET image_02 = ? WHERE id = ?");
         $update_image_02->execute([$image_02, $pid]);
         move_uploaded_file($image_tmp_name_02, $image_folder_02);
         unlink('../uploaded_img/'.$old_image_02);
         $message[] = 'image 02 updated successfully!';
      }
   }

   $old_image_03 = $_POST['old_image_03'];
   $image_03 = $_FILES['image_03']['name'];
   $image_03 = filter_var($image_03, FILTER_SANITIZE_STRING);
   $image_size_03 = $_FILES['image_03']['size'];
   $image_tmp_name_03 = $_FILES['image_03']['tmp_name'];
   $image_folder_03 = '../uploaded_img/'.$image_03;

   if(!empty($image_03)){
      if($image_size_03 > 2000000){
         $message[] = 'image size is too large!';
      }else{
         $update_image_03 = $conn->prepare("UPDATE `products` SET image_03 = ? WHERE id = ?");
         $update_image_03->execute([$image_03, $pid]);
         move_uploaded_file($image_tmp_name_03, $image_folder_03);
         unlink('../uploaded_img/'.$old_image_03);
         $message[] = 'image 03 updated successfully!';
      }
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>AstroShop | Update Product</title>

   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</head>
<body>

<?php include '../components/admin_header.php'; ?>

<?php
   // Check if the update request is made
   if (isset($_GET['update'])) {
      $update_id = $_GET['update'];
      // Fetch product details from the database
      $select_products = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
      $select_products->execute([$update_id]);

      if ($select_products->rowCount() > 0) {
         $fetch_products = $select_products->fetch(PDO::FETCH_ASSOC);
         
         // Handle form submission for updating product
         if (isset($_POST['add_product'])) {
            $name = $_POST['name'];
            $price = $_POST['price'];
            $details = $_POST['details'];

            // Handle image uploads
            $image_01 = $_FILES['image_01']['name'];
            $image_02 = $_FILES['image_02']['name'];
            $image_03 = $_FILES['image_03']['name'];

            $upload_dir = "../uploaded_img/";

            // For each image, check if a new file is uploaded, if so, move it to the upload directory
            if ($image_01) {
                move_uploaded_file($_FILES['image_01']['tmp_name'], $upload_dir . $image_01);
            } else {
                $image_01 = $fetch_products['image_01'];
            }

            if ($image_02) {
                move_uploaded_file($_FILES['image_02']['tmp_name'], $upload_dir . $image_02);
            } else {
                $image_02 = $fetch_products['image_02'];
            }

            if ($image_03) {
                move_uploaded_file($_FILES['image_03']['tmp_name'], $upload_dir . $image_03);
            } else {
                $image_03 = $fetch_products['image_03'];
            }

            // Update the product in the database
            $update_product = $conn->prepare("UPDATE `products` SET name = ?, price = ?, details = ?, image_01 = ?, image_02 = ?, image_03 = ? WHERE id = ?");
            $update_product->execute([$name, $price, $details, $image_01, $image_02, $image_03, $update_id]);

            // Check if the product was successfully updated
            if ($update_product) {
               echo "<p class='success'>Product updated successfully!</p>";
            } else {
               echo "<p class='error'>Failed to update product. Please try again.</p>";
            }
         }
      } else {
         echo '<p class="empty">No product found!</p>';
      }
   }
?>

<section class="add-products p-4 bg-light rounded shadow-sm">
   <h1 class="heading text-center mb-4" style="font-size: 24px;">UPDATE PRODUCT</h1>

   <form action="" method="post" enctype="multipart/form-data">
      <div class="row mb-3">
         <div class="col-md-6">
            <label for="name" class="form-label">Product Name <span class="text-danger">*</span></label>
            <input type="text" id="name" name="name" class="form-control" placeholder="Enter product name" required value="<?= $fetch_products['name']; ?>">
         </div>
         <div class="col-md-6">
            <label for="price" class="form-label">Product Price <span class="text-danger">*</span></label>
            <input type="number" id="price" name="price" class="form-control" placeholder="Enter product price" required value="<?= $fetch_products['price']; ?>">
         </div>
      </div>

      <div class="row mb-3">
         <div class="col-md-4">
            <label for="image_01" class="form-label">Image 01 <span class="text-danger">*</span></label>
            <input type="file" id="image_01" name="image_01" class="form-control" accept="image/jpg, image/jpeg, image/png, image/webp">
            <img src="../uploaded_img/<?= $fetch_products['image_01']; ?>" alt="Product Image 01" width="100">
         </div>
         <div class="col-md-4">
            <label for="image_02" class="form-label">Image 02 <span class="text-danger">*</span></label>
            <input type="file" id="image_02" name="image_02" class="form-control" accept="image/jpg, image/jpeg, image/png, image/webp">
            <img src="../uploaded_img/<?= $fetch_products['image_02']; ?>" alt="Product Image 02" width="100">
         </div>
         <div class="col-md-4">
            <label for="image_03" class="form-label">Image 03 <span class="text-danger">*</span></label>
            <input type="file" id="image_03" name="image_03" class="form-control" accept="image/jpg, image/jpeg, image/png, image/webp">
            <img src="../uploaded_img/<?= $fetch_products['image_03']; ?>" alt="Product Image 03" width="100">
         </div>
      </div>

      <div class="mb-3">
         <label for="details" class="form-label">Product Description <span class="text-danger">*</span></label>
         <textarea id="details" name="details" class="form-control" placeholder="Enter product details" required maxlength="500" rows="4"><?= $fetch_products['details']; ?></textarea>
      </div>

      <button type="submit" name="add_product" class="btn btn-primary w-100 py-2">
         <i class="fas fa-edit me-2"></i> Update Product
      </button>
   </form>
</section>









<script src="../js/admin_script.js"></script>
   
</body>
</html>