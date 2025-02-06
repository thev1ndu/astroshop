<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:admin_login.php');
}

if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   $delete_message = $conn->prepare("DELETE FROM `messages` WHERE id = ?");
   $delete_message->execute([$delete_id]);
   header('location:messages.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>AstroShop | Messages</title>

   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
   <!-- Font Awesome -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

   <style>
      .contacts {
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

      .table-blue th {
         background-color: #007bff;
         color: white;
      }
   </style>
</head>
<body>

<?php include '../components/admin_header.php'; ?>

<section class="contacts">

<h1 class="heading">MESSAGES</h1>

<?php
   // Fetch messages from the database
   $select_messages = $conn->prepare("SELECT * FROM `messages`");
   $select_messages->execute();
   if($select_messages->rowCount() > 0){
?>

   <table class="table table-striped">
      <thead class="table-blue">
         <tr>
            <th scope="col">#</th>
            <th scope="col">Name</th>
            <th scope="col">Email</th>
            <th scope="col">Number</th>
            <th scope="col">Message</th>
            <th scope="col">Action</th>
         </tr>
      </thead>
      <tbody>
         <?php
         $row_number = 1;
         while($fetch_message = $select_messages->fetch(PDO::FETCH_ASSOC)){
         ?>
         <tr>
            <th scope="row"><?= $row_number++; ?></th>
            <td><?= $fetch_message['name']; ?></td>
            <td><?= $fetch_message['email']; ?></td>
            <td><?= $fetch_message['number']; ?></td>
            <td><?= $fetch_message['message']; ?></td>
            <td><a href="messages.php?delete=<?= $fetch_message['id']; ?>" onclick="return confirm('Are you sure you want to delete this message?');" class="delete-btn">Delete</a></td>
         </tr>
         <?php
         }
         ?>
      </tbody>
   </table>

<?php
   } else {
      echo '<p class="empty">You have no messages.</p>';
   }
?>

</section>

<script src="../js/admin_script.js"></script>

</body>
</html>
