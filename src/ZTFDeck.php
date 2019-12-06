<?php
ini_set( 'display_errors', 0 );
?>
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js">
<!--<![endif]-->

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>YuGiOh Cards</title>
  <meta name="description" content="YuGiOh card lister">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
    integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="../CSS/Style.css">

</head>

<body>
  <div class="outer">
    <div class="inner">
      <form method="post" action="">
        <input type="text" name="CARD" required placeholder="Card name or ID ">
      </form>
    </div>
  </div>

  <div class="grid-container">

    <?php
    //? by default the list will be filled by EXODIA set of cards , it was a personal pref/approach
    //? but the list will be updated once a new card is searched O B V I O U S L Y lol
    $name="exodia";
    if(isset($_POST['CARD'])){
    $name=rawurlencode($_POST['CARD']);}
       
        $json_string =    file_get_contents("https://db.ygoprodeck.com/api/v5/cardinfo.php?fname=".$name);
        $parsed_json = json_decode($json_string, true);
      //? tbh this should never occure but for good mesures i implemented it
        if(!isset($parsed_json) && $_POST['search']){
            echo '<script language="javascript">';
            echo 'alert("Wait what ? this should never happen !!")';
            echo '</script>';
        }//? in case the string inserted in the search bar wasn't correct or doens't exist in the api's db
        else if(!isset($parsed_json)){
          echo '<script language="javascript">';
          echo 'alert("The card does not exist ! please make sure you typed the right card name")';
          echo '</script>';
        }
        else{
        $att="";

        foreach($parsed_json as $X ){ 
            
?>
    <div class="grid-item">
      <ul class="list-group">
        <li class="list-group-item mylist"><img src="<?php echo $X['card_images'][0]['image_url'] ?>" width="250"
            height="365"></li>
        <li class="list-group-item mylist"><?php echo  $X['name'];?></li>
        <li class="list-group-item mylist">
          <?php if(isset($X['level'])){ echo $X['level'];echo " ";
                echo "<img src='https://ygoprodeck.com/wp-content/uploads/2017/01/level.png' width='20' height='20'>";}else{echo 'This card has no level';} ?>
        </li>
        <li class="list-group-item mylist">
          <?php if(isset($X['attribute'])){ echo $X['attribute'];}else{echo 'This card has no attribute';} ?></li>
        <li class="list-group-item mylist"><?php echo  $X['race']; ?></li>
        <li class="list-group-item mylist"><?php echo  $X['type']; ?></li>
        <li class="list-group-item mylist">
          <button type="button" class="btn btn-primary" data-toggle="modal"
            data-target="#exampleModal<?php echo  $X['id']; ?>">
            More Detail...
          </button>
        </li>
      </ul>
    </div>
    <!-- Modal where details about the card is displayed -->
    
    <div class="modal fade" id="exampleModal<?php echo  $X['id']; ?>" tabindex="-1" role="dialog"
      aria-labelledby="exampleModalLabel" aria-hidden="true" style=" color:black;">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel"><?php echo  $X['name'];?></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <img src="<?php echo $X['card_images'][0]['image_url'] ?>" width="250" height="365"><br>
            <?php echo  $X['desc']; ?>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary btn-lg btn-block" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>
    <?php }}?>
  </div>
</body>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
  integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
  integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
  integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

</html>

