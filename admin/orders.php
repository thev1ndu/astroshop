<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:admin_login.php');
}

if(isset($_POST['update_payment'])){
   $order_id = $_POST['order_id'];
   $payment_status = $_POST['payment_status'];
   $payment_status = filter_var($payment_status, FILTER_SANITIZE_STRING);
   $update_payment = $conn->prepare("UPDATE `orders` SET payment_status = ? WHERE id = ?");
   $update_payment->execute([$payment_status, $order_id]);
   $message[] = 'Payment status updated!';
}

if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   $delete_order = $conn->prepare("DELETE FROM `orders` WHERE id = ?");
   $delete_order->execute([$delete_id]);
   header('location:placed_orders.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>AstroShop | Orders</title>
   <style>
      .orders {
         padding: 30px 20px;
         background-color: #f9f9f9;
      }
      .heading {
         font-size: 24px;
         text-align: center;
         margin-bottom: 20px;
      }
      .table-responsive {
         margin-top: 20px;
      }
      .table {
         width: 100%;
         margin-bottom: 1rem;
         color: #212529;
         border-collapse: collapse;
      }
      .table-bordered {
         border: 1px solid #dee2e6;
      }
      .table-striped tbody tr:nth-child(odd) {
         background-color: #f2f2f2;
      }
      .table th, .table td {
         padding: 0.75rem;
         vertical-align: top;
         border-top: 1px solid #dee2e6;
      }
      .btn-group-sm .btn {
         padding: 0.25rem 0.5rem;
         font-size: 0.875rem;
         line-height: 1.5;
         border-radius: 0.2rem;
      }
      .btn-success {
         background-color: #28a745;
         border-color: #28a745;
      }
      .btn-danger {
         background-color: #dc3545;
         border-color: #dc3545;
      }
   </style>
   <!-- Bootstrap CSS -->
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
   <!-- Font Awesome -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
</head>
<body>

<?php include '../components/admin_header.php'; ?>

<section class="show-orders" style="padding: clamp(1rem, 3vw, 2rem); margin-top: 2rem; background-color: #ffffff; border-radius: 16px; box-shadow: 0 4px 24px rgba(0,0,0,0.06);">

   <h1 class="heading" style="font-size: clamp(1.25rem, 4vw, 1.75rem); font-weight: 700; text-align: center; margin-bottom: 2rem; color: #2b3445; letter-spacing: -0.5px;">PLACED ORDERS</h1>

   <div class="table-responsive" style="overflow-x: auto; -webkit-overflow-scrolling: touch;">
      <table style="width: 100%; border-collapse: separate; border-spacing: 0; background-color: #ffffff;">
                  <thead>
            <tr style="background: linear-gradient(145deg, #0d6efd, #0b5ed7); color: white;">
               <th style="padding: clamp(0.75rem, 2vw, 1rem) clamp(0.75rem, 2vw, 1.5rem); text-align: left; font-weight: 600; font-size: clamp(0.85rem, 2vw, 0.95rem); border-top-left-radius: 12px; white-space: nowrap;">Placed On</th>
               <th style="padding: clamp(0.75rem, 2vw, 1rem) clamp(0.75rem, 2vw, 1.5rem); text-align: left; font-weight: 600; font-size: clamp(0.85rem, 2vw, 0.95rem); white-space: nowrap;">Name</th>
               <th style="padding: clamp(0.75rem, 2vw, 1rem) clamp(0.75rem, 2vw, 1.5rem); text-align: left; font-weight: 600; font-size: clamp(0.85rem, 2vw, 0.95rem); white-space: nowrap;">Number</th>
               <th style="padding: clamp(0.75rem, 2vw, 1rem) clamp(0.75rem, 2vw, 1.5rem); text-align: left; font-weight: 600; font-size: clamp(0.85rem, 2vw, 0.95rem); white-space: nowrap;">Address</th>
               <th style="padding: clamp(0.75rem, 2vw, 1rem) clamp(0.75rem, 2vw, 1.5rem); text-align: left; font-weight: 600; font-size: clamp(0.85rem, 2vw, 0.95rem); white-space: nowrap;">Total Products</th>
               <th style="padding: clamp(0.75rem, 2vw, 1rem) clamp(0.75rem, 2vw, 1.5rem); text-align: left; font-weight: 600; font-size: clamp(0.85rem, 2vw, 0.95rem); white-space: nowrap;">Total Price</th>
               <th style="padding: clamp(0.75rem, 2vw, 1rem) clamp(0.75rem, 2vw, 1.5rem); text-align: left; font-weight: 600; font-size: clamp(0.85rem, 2vw, 0.95rem); white-space: nowrap;">Payment Method</th>
               <th style="padding: clamp(0.75rem, 2vw, 1rem) clamp(0.75rem, 2vw, 1.5rem); text-align: left; font-weight: 600; font-size: clamp(0.85rem, 2vw, 0.95rem); white-space: nowrap;">Payment Status</th>
               <th style="padding: clamp(0.75rem, 2vw, 1rem) clamp(0.75rem, 2vw, 1.5rem); text-align: left; font-weight: 600; font-size: clamp(0.85rem, 2vw, 0.95rem); border-top-right-radius: 12px; white-space: nowrap;">Actions</th>
            </tr>
         </thead>
         <tbody>
         <?php
            $select_orders = $conn->prepare("SELECT * FROM `orders`");
            $select_orders->execute();
            if($select_orders->rowCount() > 0){
               while($fetch_orders = $select_orders->fetch(PDO::FETCH_ASSOC)){
         ?>
            <tr style="border-bottom: 1px solid #e9ecef; transition: all 0.2s ease;">
               <td style="padding: clamp(0.75rem, 2vw, 1rem) clamp(0.75rem, 2vw, 1.5rem); color: #2b3445;"><?= $fetch_orders['placed_on']; ?></td>
               <td style="padding: clamp(0.75rem, 2vw, 1rem) clamp(0.75rem, 2vw, 1.5rem); color: #2b3445;"><?= $fetch_orders['name']; ?></td>
               <td style="padding: clamp(0.75rem, 2vw, 1rem) clamp(0.75rem, 2vw, 1.5rem); color: #2b3445;"><?= $fetch_orders['number']; ?></td>
               <td style="padding: clamp(0.75rem, 2vw, 1rem) clamp(0.75rem, 2vw, 1.5rem); color: #2b3445;">
                  <div style="max-width: 200px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                     <?= $fetch_orders['address']; ?>
                  </div>
               </td>
               <td style="padding: clamp(0.75rem, 2vw, 1rem) clamp(0.75rem, 2vw, 1.5rem); color: #2b3445;"><?= $fetch_orders['total_products']; ?></td>
               <td style="padding: clamp(0.75rem, 2vw, 1rem) clamp(0.75rem, 2vw, 1.5rem);">
                  <span style="background-color: #e8f3ff; color: #0d6efd; padding: 0.5rem 1rem; border-radius: 6px; font-weight: 500; display: inline-block; white-space: nowrap;">
                     $<?= $fetch_orders['total_price']; ?>
                  </span>
               </td>
               <td style="padding: clamp(0.75rem, 2vw, 1rem) clamp(0.75rem, 2vw, 1.5rem); color: #2b3445;"><?= $fetch_orders['method']; ?></td>
               <td style="padding: clamp(0.75rem, 2vw, 1rem) clamp(0.75rem, 2vw, 1.5rem);">
                  <form action="" method="post">
                     <input type="hidden" name="order_id" value="<?= $fetch_orders['id']; ?>">
                     <select name="payment_status" style="padding: 0.5rem; border: 1px solid #dee2e6; border-radius: 6px; background-color: #f8f9fa; color: #2b3445; font-size: 0.9rem; width: auto;">
                        <option selected disabled><?= $fetch_orders['payment_status']; ?></option>
                        <option value="pending">Pending</option>
                        <option value="completed">Completed</option>
                     </select>
               </td>
               <td style="padding: clamp(0.75rem, 2vw, 1rem) clamp(0.75rem, 2vw, 1.5rem);">
                  <div style="display: flex; gap: 0.75rem; flex-wrap: wrap;">
                     <input type="submit" value="Update" name="update_payment" 
                            style="background-color: #e8f5e9; color: #28a745; padding: 0.5rem 1rem; border: 1px solid #c8e6c9; 
                                   border-radius: 6px; font-size: clamp(0.8rem, 2vw, 0.9rem); font-weight: 500; 
                                   cursor: pointer; transition: all 0.2s ease;">
                     <a href="placed_orders.php?delete=<?= $fetch_orders['id']; ?>" 
                        onclick="return confirm('Delete this order?');" 
                        style="background-color: #ffeeee; color: #dc3545; padding: 0.5rem 1rem; text-decoration: none; 
                               border-radius: 6px; font-size: clamp(0.8rem, 2vw, 0.9rem); font-weight: 500; border: 1px solid #ffd5d5; 
                               transition: all 0.2s ease; white-space: nowrap; display: inline-block;">Delete</a>
                  </div>
                  </form>
               </td>
            </tr>
         <?php
               }
            }else{
               echo '<tr><td colspan="9" style="padding: clamp(1.5rem, 4vw, 2rem); text-align: center; color: #6c757d;">
                  <div style="display: flex; flex-direction: column; align-items: center; gap: 1rem;">
                     <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color: #dee2e6;">
                        <rect x="2" y="5" width="20" height="14" rx="2"/>
                        <line x1="2" y1="10" x2="22" y2="10"/>
                     </svg>
                     No orders placed yet!
                  </div>
               </td></tr>';
            }
         ?>
         </tbody>
      </table>
   </div>

</section>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="../js/admin_script.js"></script>

</body>
</html>
