<?php
session_start();

// Sprawdzanie, czy koszyk już istnieje
if(!isset($_SESSION['cart'])){
    $_SESSION['cart'] = array();
}

// Dodawanie produktu do koszyka
if(isset($_POST['add_to_cart'])){
    $product_id = $_POST['product_id'];
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $product_qty = $_POST['product_qty'];

    // Sprawdzanie, czy produkt już znajduje się w koszyku
    $index = -1;
    for($i=0; $i<count($_SESSION['cart']); $i++){
        if($_SESSION['cart'][$i]['product_id'] == $product_id){
            $index = $i;
            break;
        }
    }

    // Jeśli produkt już znajduje się w koszyku, to zwiększ jego ilość
    if($index != -1){
        $_SESSION['cart'][$index]['product_qty'] += $product_qty;
    }
    // W przeciwnym razie, dodaj produkt do koszyka
    else{
        $product = array(
            'product_id' => $product_id,
            'product_name' => $product_name,
            'product_price' => $product_price,
            'product_qty' => $product_qty
        );
        array_push($_SESSION['cart'], $product);
    }
}

// Usuwanie produktu z koszyka
if(isset($_GET['action']) && $_GET['action'] =='remove'){
    $product_id = $_GET['product_id'];
    for($i=0; $i<count($_SESSION['cart']); $i++){
    if($_SESSION['cart'][$i]['product_id'] == $product_id){
    unset($_SESSION['cart'][$i]);
    break;
    }
    }
    $_SESSION['cart'] = array_values($_SESSION['cart']);
    }
    
    // Zmiana ilości produktu w koszyku
    if(isset($_POST['update_cart'])){
    $product_id = $_POST['product_id'];
    $product_qty = $_POST['product_qty'];
    for($i=0; $i<count($_SESSION['cart']); $i++){
    if($_SESSION['cart'][$i]['product_id'] == $product_id){
    $_SESSION['cart'][$i]['product_qty'] = $product_qty;
    break;
    }
    }
    }
    
    // Pobieranie zawartości koszyka
    $cart = $_SESSION['cart'];
    
    // Wyświetlanie zawartości koszyka
    echo "<table>";
    echo "<tr>";
    echo "<th>Nazwa produktu</th>";
    echo "<th>Cena</th>";
    echo "<th>Ilość</th>";
    echo "<th>Cena całkowita</th>";
    echo "<th>Akcja</th>";
    echo "</tr>";
    $total = 0;
    foreach($cart as $product){
    $subtotal = $product['product_qty'] * $product['product_price'];
    $total += $subtotal;
    echo "<tr>";
    echo "<td>".$product['product_name']."</td>";
    echo "<td>".$product['product_price']."</td>";
    echo "<td>
    <form method='post' action='shop.php'>
    <input type='hidden' name='product_id' value='".$product['product_id']."'>
    <input type='number' name='product_qty' value='".$product['product_qty']."'>
    <input type='submit' name='update_cart' value='Zaktualizuj'>
    </form>
    </td>";
    echo "<td>".$subtotal."</td>";
    echo "<td>
    <a href='shopform.php?action=remove&product_id=".$product['product_id']."'>Usuń</a>
    </td>";
    echo "</tr>";
}
    echo "<tr>";
    echo "<td colspan='3'></td>";
    echo "<td>".$total."</td>";
    echo "<td></td>";
    echo "</tr>";
    echo "</table>";

?>
