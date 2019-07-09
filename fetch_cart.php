<?php

session_start();
$total_price = 0;
$total_item = 0;
$output = '
<div class="table-responsive" id="order_table">
 <table class="table table-bordered table-striped">
  <tr>  
            <th width="40%">Proizvod</th>  
            <th width="10%">Količina (u litrama)</th>  
            <th width="20%">Cijena</th>  
            <th width="15%">Ukupno</th>  
            <th width="5%"></th>  
        </tr>
';
if(!empty($_SESSION["shopping_cart"]))
{
 foreach($_SESSION["shopping_cart"] as $keys => $values)
 {
  $output .= '
  <tr>
   <td>'.$values["product_name"].'</td>
   <td>'.$values["product_quantity"].'</td>
   <td align="right">'.$values["product_price"].' HRK</td>
   <td align="right">'.number_format($values["product_quantity"] * $values["product_price"], 2).' HRK</td>
   <td><button name="delete" class="btn btn-danger btn-xs delete" id="'. $values["product_id"].'">Remove</button></td>
  </tr>
  ';
  $total_price = $total_price + ($values["product_quantity"] * $values["product_price"]);
 }
 $output .= '
 <tr>  
        <td colspan="3" align="right">Ukupno</td>  
        <td align="right">'.number_format($total_price, 2).' HRK</td>  
        <td></td>  
    </tr>
 ';
}
else
{
 $output .= '
    <tr>
     <td colspan="5" align="center">
      Košarica je prazna!
     </td>
    </tr>
    ';
}
$output .= '</table></div>';

echo $output;
//echo '<pre>';
//print_r($_SESSION["shopping_cart"]);
//echo '</pre>';

?>