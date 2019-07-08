<?php
session_start();
$product_ids=array();
//session_destroy();

/*provjera jel add to cart stisnut*/
if(filter_input(INPUT_POST,'add_to_cart')){
    if(isset($_SESSION['shopping_cart'])){//brojanje koliko je elemenata u kosarici
        $count=count($_SESSION['shopping_cart']);
        $product_ids=array_column($_SESSION['shopping_cart'],'id');

        if(!in_array(filter_input(INPUT_GET,'id'),$product_ids)){
            $_SESSION['shopping_cart'][$count]=array(
                'id' => filter_input(INPUT_GET,'id'),//hvatanje elementa kosarice po ID-u kad se stisne dodaj u kosaricu
                'name'=> filter_input(INPUT_POST,'name'),
                'price'=> filter_input(INPUT_POST,'price'),
                'quantity'=> filter_input(INPUT_POST,'quantity')
            );
        }
        else{
            //provjera i povezivanje itog id-a proizvoda kojem se dodaje kolicina
            for($i=0;$i<count($product_ids);$i++){//dodavanje kolicine na postojeci proizvod u polju
                if($product_ids[$i]==filter_input(INPUT_GET,'id')){
                    $_SESSION['shopping_cart'][$i]['quantity']+=filter_input(INPUT_POST,'quantity');
                }
            }
        }

    }
    else{//ako ne postoji shopping cart, kreiraj prvi proizvod s kljucem 0, kreiranje polja iz podataka iz baze
        $_SESSION['shopping_cart'][0]=array
        (
            'id' => filter_input(INPUT_GET,'id'),//hvatanje elementa kosarice po ID-u kad se stisne dodaj u kosaricu
            'name'=> filter_input(INPUT_POST,'name'),
            'price'=> filter_input(INPUT_POST,'price'),
            'quantity'=> filter_input(INPUT_POST,'quantity')
        );

    }
}
if(filter_input(INPUT_GET,'action')=='delete'){//trazenje id-a proizvoda koji se brise
    foreach($_SESSION['shopping_cart'] as $key => $product){
        if($product['id']==filter_input(INPUT_GET,'id')) {
            unset($_SESSION['shopping_cart'][$key]);
        }
    }
    //resetiranje kljjuceva polja
    $_SESSION['shopping_cart']=array_values($_SESSION['shopping_cart']);
}
pre_r($_SESSION);
function pre_r($array){
    echo '<pre>';
    print_r($array);
    echo '</pre>';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link href="jquery.bxslider.css" rel="stylesheet" type="text/css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Source+Sans+Pro:400italic,600italic,700italic,200,300,400,600,700,900">
    <link rel="stylesheet" href="styles.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <title>Ponuda vina</title>
</head>
<body>
    <h1 style=" margin: 0em 0 0em 0;
	font-weight: 600;
	font-family: 'Titillium Web', sans-serif;
	position: relative;  
	font-size: 36px;
	line-height: 40px;
	padding: 15px 15px 15px 15%;
	color: #9DDBA1;
	box-shadow: 
		inset 0 0 0 1px rgba(53,86,129, 0.4), 
		inset 0 0 5px rgba(53,86,129, 0.5),
		inset -285px 0 35px white;
	border-radius: 0 10px 0 10px;
    background: #fff url(galerija/nice.jpg) center left;
    background: #fff url(galerija/nice.jpg) center right;">Ponuda vina</h1>
    <nav style=" display: flex;
    justify-content: space-around;
    align-items:center;
    min-height: 6vh;
    background:#76E482;
    font-family: sans-serif;">
        <div class="logo">
               <h4>OPG Ćuić</h4>
        </div>
        <ul class="nav-links">
            <li><a href="index.php">Početna</a></li>
            <li><a href="gallery.php">Galerija</a></li>
            <li><a href="wineoffer.php">Ponuda Vina</a></li>
        </ul>
        <div class="burger">
            <div class="linija1"></div>
            <div class="linija2"></div>
            <div class="linija3"></div>
        </div>
    </nav>

    <!--slider-->
    <div id=slider>
        <ul class="bxslider">
            <img src="vina/bijelipinot1.jpg" alt="">
            <img src="vina/grapes.jpg" alt="">
            <img src="vina/grasevina1.jpg" alt="">
            <img src="vina/wine.jpg" alt="">
            <img src="vina/a1.jpg" alt="">
        </ul>
    </div>

    &nbsp;
    <div class="container">
    <?php
    $connect=mysqli_connect("localhost","root","root","product");
    $query="SELECT * FROM tbl_product ORDER BY id ASC";
    $result=mysqli_query($connect,$query);

    if($result):
        if(mysqli_num_rows($result)>0):
            while($product=mysqli_fetch_assoc($result)):
               /* print_r($product);*/
            ?>
            <div class="col-sm-4 col-md-3">
                <form method="post" action="wineoffer.php?action=add&id=<?php echo $product['id'];?>">
                    <div class="products">
                        <img src="<?php echo $product['image']; ?>" class="img-responsive">
                        <h4 class="text-info"><?php echo $product['name']; ?></h4>
                        <h4><?php echo $product['price'];?> HRK / 1 litra</h4>
                        <input type="text" name="quantity" class="form-control" value="1">
                        <input type="hidden" name="name" value="<?php $product['name'];?>">
                        <input type="hidden" name="price" value="<?php $product['price'];?>">
                        <input type="submit" name="add_to_cart" style="margin-top:5px"class="btn btn-info" value="Dodaj u Košaricu">
                    </div>
                </form>
            </div>
            <?php
            endwhile;
        endif;
    endif;
    ?>
    <div style="clear:both"></div>
    <br />
    <div class="table-responsive">
        <table class="table">
            <tr><th colspan="5"><h3>Detalji Narudžbe</h3></th></tr>
            <tr>
                <th width="40%">Ime proizvoda</th>
                <th width="10%">Količina</th>
                <th width="20%">Cijena</th>
                <th width="15%">Ukupno</th>
                <th width="5%">Akcija</th>
                </th>
            </tr>
            <?php
            if(!empty($_SESSION['shopping_cart'])):

                $total=0;

                foreach($_SESSION['shopping_cart'] as $key=>$product):
            ?>
            <tr>
                <td><?php echo $product['name']?></td>
                <td><?php echo $product['quantity']?></td>
                <td><?php echo $product['price']?></td>
                <td><?php echo number_format($product['quantity']*$product['price'],2);?></td>
                <td>
                    <a href="wineoffer.php?action=delete&id=<?php echo $product['id'];?>">
                    <div class="btn-danger">Ukloni</div>
                    </a>
                        
                </td>
            </tr>
            <?php
                $total=$total+($product['quantity']*$product['price']);
                endforeach;
            ?>
            <tr>
                <td colspan="3" ;align="right">Ukupno</td>
                <td align="right">HRK <?php echo number_format($total,2);?></td>
                <td></td>
            </tr>
            <tr>
                <td colspan="5">
                    <?php
                    if(isset($_SESSION['shopping_cart'])):
                    if(count($_SESSION['shopping_cart'])>0):
                    ?>
                    <a href="#" class="button">Checkout</a>
                    <?php endif; endif;?>
                </td>
            </tr>
            <?php
            endif;
            ?>
        </table>
    </div> 
    </div>  
    <script src="http://code.jquery.com/jquery-2.2.4.js" integrity="sha256-iT6Q9iMJYuQiMWNd9lDyBUStIq/8PuOW33aOqmvFpqI=" crossorigin="anonymous"></script>
    <script src="js/jquery.bxslider.min.js"></script>
    <script src="js/app.js"></script>
    <script src="js/my.js"></script>
    
</body>
</html>