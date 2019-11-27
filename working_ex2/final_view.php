<?php echo BOX_BEGIN; ?>
<h2>Your Order is Complete</h2>
<p>Thank you for your order (#<?php echo $_SESSION['order_id']; ?>). Please use this order number in any correspondence with us.</p>
<p>A charge of $<?php echo number_format($_SESSION['order_total']/100, 2); ?> will appear on your credit card when the order ships. All orders are processed on the next business day. You will be contacted in case of any delays.</p>
<p>An email confirmation has been sent to your email address. <a href=”receipt.php”>Click here </a>to create a printable receipt of your order.</p>
<?php echo BOX_END; ?>