<?php

include('database_connection.php');

$query = "SELECT * FROM tbl_product ORDER BY id DESC";

$statement = $connect->prepare($query);

if($statement->execute())
{
 $result = $statement->fetchAll();
 $output = '';
 foreach($result as $row)
 {
  $output .= '
  <div class="col-md-3" style="margin-top:12px;margin-bottom:12px;">  
            <div style="border:1px solid #ccc; border-radius:5px; padding:16px; height:300px;" align="center" id="product_'.$row["id"].'">
             <img src="'.$row["image"].'" class="img-responsive" /><br />
             <div class= "natpisi">
			 <h4 class="text-info">
                        <div class="checkbox">
                              <label><input type="checkbox" class="select_product" data-product_id="'.$row["id"].'" data-product_name="'.$row["name"].'" data-product_price="'.$row["price"] .'" value="">'.$row["name"].'</label>
                        </div>
                  </h4>
             <h4 class="text-danger">'.$row["price"] .' HRK / litra</h4>
			 </div>
            </div>
        </div>
  ';
 }
 echo $output;
}



?>
