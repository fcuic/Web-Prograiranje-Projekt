
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link href="jquery.bxslider.css" rel="stylesheet" type="text/css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
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
   <br />
   <h3 class="naslovkosarice"align="center" ><a href="#">Košarica</a></h3>
   <br />
   
   <div class="panel panel-default">
    <div class="panel-heading">
     <div class="row">
      <div class="col-md-6">Detalji</div>
      <div class="col-md-6" align="right">
       <button type="button" name="clear_cart" id="clear_cart" class="btn btn-warning btn-xs">Ukloni Sve</button>
      </div>
     </div>
    </div>
    <div class="panel-body" id="shopping_cart">

    </div>
   </div>

   <div class="panel panel-default">
    <div class="panel-heading">
     <div class="row">
      <div class="col-md-6">Naši Proizvodi</div>
      <div class="col-md-6" align="right">
       <button type="button" name="add_to_cart" id="add_to_cart" class="btn btn-success btn-xs">Dodaj u košaricu</button>
      </div>
     </div>
    </div>
    <div class="panel-body" id="display_item">

    </div>
   </div>
  </div>
    <script src="http://code.jquery.com/jquery-2.2.4.js" integrity="sha256-iT6Q9iMJYuQiMWNd9lDyBUStIq/8PuOW33aOqmvFpqI=" crossorigin="anonymous"></script>
    <script src="js/jquery.bxslider.min.js"></script>
    <script src="js/app.js"></script>
    <script src="js/my.js"></script>
    
</body>
</html>
<script>  
$(document).ready(function(){
 load_product();
 load_cart_data();
 function load_product()
 {
  $.ajax({
   url:"fetch_item.php",
   method:"POST",
   success:function(data)
   {
    $('#display_item').html(data);
   }
  });
 }

 function load_cart_data()
 {
  $.ajax({
   url:"fetch_cart.php",
   method:"POST",
   success:function(data)
   {
    $('#shopping_cart').html(data);
   }
  });
 }

 $(document).on('click', '.select_product', function(){
  var product_id = $(this).data('product_id');
  if($(this).prop('checked') == true)
  {
   $('#product_'+product_id).css('background-color', '#f1f1f1');
   $('#product_'+product_id).css('border-color', '#333');
  }
  else
  {
   $('#product_'+product_id).css('background-color', 'transparent');
   $('#product_'+product_id).css('border-color', '#ccc');
  }
 });

 $('#add_to_cart').click(function(){
  var product_id = [];
  var product_name = [];
  var product_price = [];
  var action = "add";
  $('.select_product').each(function(){
   if($(this).prop('checked') == true)
   {
    product_id.push($(this).data('product_id'));
    product_name.push($(this).data('product_name'));
    product_price.push($(this).data('product_price'));
   }
  });

  if(product_id.length > 0)
  {
   $.ajax({
    url:"action.php",
    method:"POST",
    data:{product_id:product_id, product_name:product_name, product_price:product_price, action:action},
    success:function(data)
    {
     $('.select_product').each(function(){
      if($(this).prop('checked') == true)
      {
       $(this).attr('checked', false);
       var temp_product_id = $(this).data('product_id');
       $('#product_'+temp_product_id).css('background-color', 'transparent');
       $('#product_'+temp_product_id).css('border-color', '#ccc');
      }
     });

     load_cart_data();
     alert("Dodano u košaricu!");
    }
   });
  }
  else
  {
   alert('Odaberite jedan proizvod!');
  }

 });

 $(document).on('click', '.delete', function(){
  var product_id = $(this).attr("id");
  var action = 'remove';
  if(confirm("Želite li ukloniti proizvod iz košarice?"))
  {
   $.ajax({
    url:"action.php",
    method:"POST",
    data:{product_id:product_id, action:action},
    success:function()
    {
     load_cart_data();
     alert("Uklonili ste proizvod!");
    }
   })
  }
  else
  {
   return false;
  }
 });

 $(document).on('click', '#clear_cart', function(){
  var action = 'empty';
  $.ajax({
   url:"action.php",
   method:"POST",
   data:{action:action},
   success:function()
   {
    load_cart_data();
    alert("Vaša košarica je očišćena!");
   }
  });
 });
    
});

</script>