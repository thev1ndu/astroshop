<?php
include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:admin_login.php');
}

if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   $delete_user = $conn->prepare("DELETE FROM `users` WHERE id = ?");
   $delete_user->execute([$delete_id]);
   $delete_orders = $conn->prepare("DELETE FROM `orders` WHERE user_id = ?");
   $delete_orders->execute([$delete_id]);
   $delete_messages = $conn->prepare("DELETE FROM `messages` WHERE user_id = ?");
   $delete_messages->execute([$delete_id]);
   $delete_cart = $conn->prepare("DELETE FROM `cart` WHERE user_id = ?");
   $delete_cart->execute([$delete_id]);
   $delete_wishlist = $conn->prepare("DELETE FROM `wishlist` WHERE user_id = ?");
   $delete_wishlist->execute([$delete_id]);
   header('location:users.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>AstroShop | Users</title>

   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
   <!-- Font Awesome -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
   <style>
      body {
         font-family: Arial, sans-serif;
         background-color: #f4f4f4;
      }

      .accounts {
         padding: 30px;
         background-color: #fff;
         border-radius: 8px;
         box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
         margin-top: 20px;
      }

      .heading {
         font-size: 24px;
         text-align: center;
         margin-bottom: 20px;
         color: #333;
      }

      .table th, .table td {
         padding: 12px;
         text-align: center;
      }

      .table th {
         background-color: #007bff;
         color: white;
      }

      .table tr {
         border-bottom: 1px solid #ddd;
      }

      .delete-btn {
         padding: 8px 16px;
         background-color: #f44336;
         color: white;
         border-radius: 5px;
         font-size: 14px;
         text-decoration: none;
         cursor: pointer;
      }

      .delete-btn:hover {
         background-color: #d32f2f;
      }

      .empty {
         font-size: 16px;
         color: #888;
         text-align: center;
         padding: 20px;
      }
   </style>
</head>
<body>

<?php include '../components/admin_header.php'; ?>

<section class="accounts">

<h1 class="heading"><b>MANAGE USERS</b></h1>

   <div class="container">

      <!-- Table Section -->
      <div class="table-responsive">
         <table class="table table-striped table-bordered table-sm w-100">
            <thead>
               <tr>
                  <th scope="col">#ID</th>
                  <th scope="col">Username</th>
                  <th scope="col">Email</th>
                  <th scope="col">Action</th>
               </tr>
            </thead>
            <tbody>
               <?php
               $select_accounts = $conn->prepare("SELECT * FROM `users`");
               $select_accounts->execute();
               if($select_accounts->rowCount() > 0){
                  while($fetch_accounts = $select_accounts->fetch(PDO::FETCH_ASSOC)){   
               ?>
                  <tr>
                     <th scope="row"><?= $fetch_accounts['id']; ?></th>
                     <td><?= $fetch_accounts['name']; ?></td>
                     <td><?= $fetch_accounts['email']; ?></td>
                     <td>
                        <a href="users.php?delete=<?= $fetch_accounts['id']; ?>" 
                           onclick="return confirm('Are you sure you want to delete this user and all related data?')" 
                           class="delete-btn">Delete</a>
                     </td>
                  </tr>
               <?php
                  }
               } else {
                  echo '<tr><td colspan="4" class="empty">No accounts available!</td></tr>';
               }
               ?>
            </tbody>
         </table>
      </div>

   </div>

</section>

<script src="../js/admin_script.js"></script>

</body>
</html>
