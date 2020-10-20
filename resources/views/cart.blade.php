<!DOCTYPE html>
<html>
<body>

<form action="{{ route('buy-pro') }}" method="POST">
  <label for="fname">Product name:</label><br>
  <input type="text" id="pro_name" name="pro_name" value=""><br>
  <label for="lname">Price:</label><br>
  <input type="text" id="price" name="price" value=""><br><br>
  <label for="lname">Classify Product:</label><br>
  <input type="text" id="classify" name="classify" value=""><br><br>
  <label for="lname">Quantity:</label><br>
  <input type="text" id="quantity" name="quantity" value=""><br><br>
  <input type="submit" value="Submit">
</form> 

</body>
</html>
