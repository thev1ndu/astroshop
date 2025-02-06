<?php

include '../components/connect.php';

session_start();

if(isset($_POST['submit'])){

   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $pass = sha1($_POST['pass']);
   $pass = filter_var($pass, FILTER_SANITIZE_STRING);

   $select_admin = $conn->prepare("SELECT * FROM `admins` WHERE name = ? AND password = ?");
   $select_admin->execute([$name, $pass]);
   $row = $select_admin->fetch(PDO::FETCH_ASSOC);

   if($select_admin->rowCount() > 0){
      $_SESSION['admin_id'] = $row['id'];
      header('location:dashboard.php');
   }else{
      $message[] = 'incorrect username or password!';
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>AstroShop | Admin Login</title>

   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <style>
      body {
         background-color: #f0f2f5;
         display: flex;
         justify-content: center;
         align-items: center;
         height: 100vh;
         margin: 0;
      }

      .form-container {
         background: #fff;
         padding: 2rem;
         border-radius: 8px;
         box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
         width: 100%;
         max-width: 400px;
      }

      .form-container h3 {
         margin-bottom: 1rem;
         font-size: 1.5rem;
         text-align: center;
      }

      .form-container p {
         text-align: center;
         margin-bottom: 1.5rem;
         font-size: 0.875rem;
      }

      .form-container .box {
         margin-bottom: 1rem;
      }

      .form-container .btn {
         width: 100%;
      }

      .message {
         background-color: #f8d7da;
         color: #842029;
         padding: 0.75rem;
         border-radius: 5px;
         margin-bottom: 1rem;
         display: flex;
         justify-content: space-between;
         align-items: center;
      }

      .message i {
         cursor: pointer;
      }
   </style>
</head>
<body>

<?php
   if(isset($message)){
      foreach($message as $message){
         echo '
         <div class="message">
            <span>'.$message.'</span>
            <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
         </div>
         ';
      }
   }
?>

<section class="form-container">

   <form action="" method="post">
      <h3>Astro Shop Dashboard</h3>
      <p>Enter the username and password in order to login.</p>
      <input type="text" name="name" required placeholder="Enter your username" maxlength="20" class="form-control box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="password" name="pass" required placeholder="Enter your password" maxlength="20" class="form-control box" oninput="this.value = this.value.replace(/\s/g, '')">
      <button type="submit" class="btn btn-primary" name="submit">Login now</button>
   </form>

</section>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
