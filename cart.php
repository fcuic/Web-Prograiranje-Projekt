<?php
$connect=mysqli_connect("localhost","root","root","product");
$query="SELECT * FROM tbl_product ORDER BY id ASC";
$result=mysqli_query($connect,$query);

if($result){
    if(mysqli_num_rows($result)>0){
        while($product=mysqli_fetch_assoc($result)){
            print_r($product);
        }
    }
}

?>