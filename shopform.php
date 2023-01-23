<head>
</head>

<form method="post" action="">
  <a>Mekambe</a>
  <input type="hidden" name="product_id" value="1">
  <input type="hidden" name="product_name" value="Product 1">
  <input type="hidden" name="product_price" value="50">
  <label for="product_qty">Ilość:</label>
  <input type="number" name="product_qty" value="1">
  <input type="submit" name="add_to_cart" value="Dodaj do koszyka">
  <a>Muransky</a>
  <input type="hidden" name="product_id" value="2">
  <input type="hidden" name="product_name" value="Product 2">
  <input type="hidden" name="product_price" value="50">
  <label for="product_qty">Ilość:</label>
  <input type="number" name="product_qty" value="1">
  <input type="submit" name="add_to_cart" value="Dodaj do koszyka">
 
<div class="cart-slider">
  <h2>Zawartość koszyka</h2>
  <table>
    <tr>
      <th>Nazwa produktu</th>
      <th>Cena</th>
      <th>Ilość</th>
    </tr>
    <?php
      include 'shop.php';
    ?>
  </table>
  <a href="checkout.php" class="checkout-btn">Przejdź do kasy</a>
</div>


</form>
