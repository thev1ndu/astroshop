<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:admin_login.php');
};

if(isset($_POST['add_product'])){

   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $price = $_POST['price'];
   $price = filter_var($price, FILTER_SANITIZE_STRING);
   $details = $_POST['details'];
   $details = filter_var($details, FILTER_SANITIZE_STRING);

   $image_01 = $_FILES['image_01']['name'];
   $image_01 = filter_var($image_01, FILTER_SANITIZE_STRING);
   $image_size_01 = $_FILES['image_01']['size'];
   $image_tmp_name_01 = $_FILES['image_01']['tmp_name'];
   $image_folder_01 = '../uploaded_img/'.$image_01;

   $image_02 = $_FILES['image_02']['name'];
   $image_02 = filter_var($image_02, FILTER_SANITIZE_STRING);
   $image_size_02 = $_FILES['image_02']['size'];
   $image_tmp_name_02 = $_FILES['image_02']['tmp_name'];
   $image_folder_02 = '../uploaded_img/'.$image_02;

   $image_03 = $_FILES['image_03']['name'];
   $image_03 = filter_var($image_03, FILTER_SANITIZE_STRING);
   $image_size_03 = $_FILES['image_03']['size'];
   $image_tmp_name_03 = $_FILES['image_03']['tmp_name'];
   $image_folder_03 = '../uploaded_img/'.$image_03;

   $select_products = $conn->prepare("SELECT * FROM `products` WHERE name = ?");
   $select_products->execute([$name]);

   if($select_products->rowCount() > 0){
      // $message[] = 'product name already exist!';
   }else{

      $insert_products = $conn->prepare("INSERT INTO `products`(name, details, price, image_01, image_02, image_03) VALUES(?,?,?,?,?,?)");
      $insert_products->execute([$name, $details, $price, $image_01, $image_02, $image_03]);

      if($insert_products){
         if($image_size_01 > 2000000 OR $image_size_02 > 2000000 OR $image_size_03 > 2000000){
            // $message[] = 'image size is too large!';
         }else{
            move_uploaded_file($image_tmp_name_01, $image_folder_01);
            move_uploaded_file($image_tmp_name_02, $image_folder_02);
            move_uploaded_file($image_tmp_name_03, $image_folder_03);
            // $message[] = 'new product added!';
         }

      }

   }  

};

if(isset($_GET['delete'])){

   $delete_id = $_GET['delete'];
   $delete_product_image = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
   $delete_product_image->execute([$delete_id]);
   $fetch_delete_image = $delete_product_image->fetch(PDO::FETCH_ASSOC);
   unlink('../uploaded_img/'.$fetch_delete_image['image_01']);
   unlink('../uploaded_img/'.$fetch_delete_image['image_02']);
   unlink('../uploaded_img/'.$fetch_delete_image['image_03']);
   $delete_product = $conn->prepare("DELETE FROM `products` WHERE id = ?");
   $delete_product->execute([$delete_id]);
   $delete_cart = $conn->prepare("DELETE FROM `cart` WHERE pid = ?");
   $delete_cart->execute([$delete_id]);
   $delete_wishlist = $conn->prepare("DELETE FROM `wishlist` WHERE pid = ?");
   $delete_wishlist->execute([$delete_id]);
   header('location:products.php');
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>AstroShop | Products</title>

   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</head>
<body>

<?php include '../components/admin_header.php'; ?>

<section class="add-products p-4 bg-light rounded shadow-sm">

   <h1 class="heading text-center mb-4" style="font-size: 24px;">ADD PRODUCT</h1>

   <form action="" method="post" enctype="multipart/form-data">

      <div class="row mb-3">
         <div class="col-md-6">
            <label for="name" class="form-label">Product Name <span class="text-danger">*</span></label>
            <input type="text" id="name" name="name" class="form-control" placeholder="Enter product name" required>
         </div>
         <div class="col-md-6">
            <label for="price" class="form-label">Product Price <span class="text-danger">*</span></label>
            <input type="number" id="price" name="price" class="form-control" placeholder="Enter product price" required>
         </div>
      </div>

      <div class="row mb-3">
         <div class="col-md-4">
            <label for="image_01" class="form-label">Image 01 <span class="text-danger">*</span></label>
            <input type="file" id="image_01" name="image_01" class="form-control" accept="image/jpg, image/jpeg, image/png, image/webp" required>
         </div>
         <div class="col-md-4">
            <label for="image_02" class="form-label">Image 02 <span class="text-danger">*</span></label>
            <input type="file" id="image_02" name="image_02" class="form-control" accept="image/jpg, image/jpeg, image/png, image/webp" required>
         </div>
         <div class="col-md-4">
            <label for="image_03" class="form-label">Image 03 <span class="text-danger">*</span></label>
            <input type="file" id="image_03" name="image_03" class="form-control" accept="image/jpg, image/jpeg, image/png, image/webp" required>
         </div>
      </div>

      <div class="mb-3">
         <label for="details" class="form-label">Product Description <span class="text-danger">*</span></label>
         <textarea id="details" name="details" class="form-control" placeholder="Enter product details" required maxlength="500" rows="4"></textarea>
      </div>

      <button type="submit" name="add_product" class="btn btn-primary w-100 py-2">
         <i class="fas fa-plus-circle me-2"></i> Add Product
      </button>

   </form>

</section>


<section class="show-products" style="padding: clamp(1rem, 3vw, 2rem); margin-top: 2rem; background-color: #ffffff; border-radius: 16px; box-shadow: 0 4px 24px rgba(0,0,0,0.06);">

   <h1 class="heading" style="font-size: clamp(1.25rem, 4vw, 1.75rem); font-weight: 700; text-align: center; margin-bottom: 2rem; color: #2b3445; letter-spacing: -0.5px;">LIST OF PRODUCTS</h1>

   <div class="table-responsive" style="overflow-x: auto; -webkit-overflow-scrolling: touch;">
      <table style="width: 100%; min-width: 600px; border-collapse: separate; border-spacing: 0; background-color: #ffffff;">
         <thead>
            <tr style="background: linear-gradient(145deg, #0d6efd, #0b5ed7); color: white;">
               <th style="padding: clamp(0.75rem, 2vw, 1rem) clamp(0.75rem, 2vw, 1.5rem); text-align: left; font-weight: 600; font-size: clamp(0.85rem, 2vw, 0.95rem); border-top-left-radius: 12px; white-space: nowrap;">Product Image</th>
               <th style="padding: clamp(0.75rem, 2vw, 1rem) clamp(0.75rem, 2vw, 1.5rem); text-align: left; font-weight: 600; font-size: clamp(0.85rem, 2vw, 0.95rem); white-space: nowrap;">Product Name</th>
               <th style="padding: clamp(0.75rem, 2vw, 1rem) clamp(0.75rem, 2vw, 1.5rem); text-align: left; font-weight: 600; font-size: clamp(0.85rem, 2vw, 0.95rem); white-space: nowrap;">Price</th>
               <th style="padding: clamp(0.75rem, 2vw, 1rem) clamp(0.75rem, 2vw, 1.5rem); text-align: left; font-weight: 600; font-size: clamp(0.85rem, 2vw, 0.95rem); border-top-right-radius: 12px; white-space: nowrap;">Actions</th>
            </tr>
         </thead>
         <tbody>
         <?php
            $select_products = $conn->prepare("SELECT * FROM `products`");
            $select_products->execute();
            if($select_products->rowCount() > 0){
               while($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)){ 
         ?>
            <tr style="border-bottom: 1px solid #e9ecef; transition: all 0.2s ease;">
               <td style="padding: clamp(0.75rem, 2vw, 1rem) clamp(0.75rem, 2vw, 1.5rem);">
                  <div style="width: clamp(50px, 10vw, 60px); height: clamp(50px, 10vw, 60px); border-radius: 10px; overflow: hidden; background-color: #f8f9fa;">
                     <img src="../uploaded_img/<?= $fetch_products['image_01']; ?>" alt="" style="width: 100%; height: 100%; object-fit: cover;">
                  </div>
               </td>
               <td style="padding: clamp(0.75rem, 2vw, 1rem) clamp(0.75rem, 2vw, 1.5rem); font-weight: 500; color: #2b3445;">
                  <div style="max-width: 200px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                     <?= $fetch_products['name']; ?>
                  </div>
               </td>
               <td style="padding: clamp(0.75rem, 2vw, 1rem) clamp(0.75rem, 2vw, 1.5rem);">
                  <span style="background-color: #e8f3ff; color: #0d6efd; padding: 0.5rem 1rem; border-radius: 6px; font-weight: 500; display: inline-block; white-space: nowrap;">
                     $<?= $fetch_products['price']; ?>
                  </span>
               </td>
               <td style="padding: clamp(0.75rem, 2vw, 1rem) clamp(0.75rem, 2vw, 1.5rem);">
                  <div style="display: flex; gap: 0.75rem; flex-wrap: wrap;">
                     <a href="update-product.php?update=<?= $fetch_products['id']; ?>" 
                        style="background-color: #fff8ee; color: #ff9800; padding: 0.5rem 1rem; text-decoration: none; 
                               border-radius: 6px; font-size: clamp(0.8rem, 2vw, 0.9rem); font-weight: 500; border: 1px solid #ffe5c0; 
                               transition: all 0.2s ease; white-space: nowrap; display: inline-block;">Update</a>
                     <a href="products.php?delete=<?= $fetch_products['id']; ?>" 
                        onclick="return confirm('Delete this product?');" 
                        style="background-color: #ffeeee; color: #dc3545; padding: 0.5rem 1rem; text-decoration: none; 
                               border-radius: 6px; font-size: clamp(0.8rem, 2vw, 0.9rem); font-weight: 500; border: 1px solid #ffd5d5; 
                               transition: all 0.2s ease; white-space: nowrap; display: inline-block;">Delete</a>
                  </div>
               </td>
            </tr>
         <?php
               }
            }else{
               echo '<tr><td colspan="5" style="padding: clamp(1.5rem, 4vw, 2rem); text-align: center; color: #6c757d;">
                  <div style="display: flex; flex-direction: column; align-items: center; gap: 1rem;">
                     <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color: #dee2e6;">
                        <path d="M21 8a2 2 0 0 1-2 2h-2v2h2a2 2 0 0 1 2 2v2a2 2 0 0 1-2 2h-2v-2h2v-2h-2v-2h2V8h-2V6h2a2 2 0 0 1 2 2zM3 8a2 2 0 0 0 2 2h2v2H5a2 2 0 0 0-2 2v2a2 2 0 0 0 2 2h2v-2H5v-2h2v-2H5V8h2V6H5a2 2 0 0 0-2 2z"/>
                        <rect x="8" y="6" width="8" height="12"/>
                     </svg>
                     No products added yet!
                  </div>
               </td></tr>';
            }
         ?>
         </tbody>
      </table>
   </div>

</section>

<script src="https://kit.fontawesome.com/a076d05399.js"></script>
<script>
   // Bootstrap 5 form validation
   (function () {
      'use strict'
      var forms = document.querySelectorAll('.needs-validation')
      Array.prototype.slice.call(forms)
         .forEach(function (form) {
            form.addEventListener('submit', function (event) {
               if (!form.checkValidity()) {
                  event.preventDefault()
                  event.stopPropagation()
               }
               form.classList.add('was-validated')
            }, false)
         })
   })()
</script>









<script src="../js/admin_script.js"></script>
   
</body>
</html>