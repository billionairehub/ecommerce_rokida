<!DOCTYPE html>
<html>
<body>

<form action="{{ route('buy-pro') }}" method="POST">
  <label for="fname">Product name:</label><br>
  <input type="text" id="pro_name" name="pro_name" value=""><br><br>
  <label for="lname">Price:</label><br>
  <input type="text" id="price" name="price" value=""><br><br>
  <label for="lname">Promotional_price:</label><br>
  <input type="text" id="promotional_price" name="promotional_price" value=""><br><br>
  <label for="lname">Id Product:</label><br>
  <input type="text" id="id" name="id" value=""><br><br>
  <label for="lname">Id Shop:</label><br>
  <input type="text" id="shop_id" name="shop_id" value=""><br><br>
  <label for="lname">Classify:</label><br>
  <input type="text" id="classify" name="classify" value=""><br><br>
  <label for="lname">Quantity:</label><br>
  <input type="text" id="quantity" name="quantity" value=""><br><br>
  <input type="submit" value="Submit">
</form> 


<!-- <form action="{{ route('order-confirmation') }}" method="POST">
  <label for="fname">amount:</label><br>
  <input type="text" id="amount" name="amount" value=""><br><br>
  <label for="lname">total_bill:</label><br>
  <input type="text" id="total_bill" name="total_bill" value=""><br><br>
  <label for="lname">Promotional_price:</label><br>
  <input type="text" id="promotional_price" name="promotional_price" value=""><br><br>
  <label for="lname">order_code:</label><br>
  <input type="text" id="order_code" name="order_code" value=""><br><br>
  <label for="lname">type_ship_id:</label><br>
  <input type="text" id="type_ship_id" name="type_ship_id" value=""><br><br>
  <label for="lname">fees_ship:</label><br>
  <input type="text" id="fees_ship" name="fees_ship" value=""><br><br>

  <label for="lname">voucher:</label><br>
  <input type="text" id="voucher" name="voucher" value=""><br><br>
  <label for="lname">ship_address:</label><br>
  <input type="text" id="ship_address" name="ship_address" value=""><br><br>
  <label for="lname">phone:</label><br>
  <input type="text" id="phone" name="phone" value=""><br><br>
  <label for="lname">email:</label><br>
  <input type="text" id="email" name="email" value=""><br><br>
  
  <input type="submit" value="Submit">
</form>  -->

</body>
</html>
