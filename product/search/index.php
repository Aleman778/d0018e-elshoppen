<?php

  session_start();
  include("../../modules/mysql.php");
  
  $searchterm = htmlspecialchars($_REQUEST['searchterm']);
  $db = new MySQL();
  $sql = "SELECT id, name, price, image_ref From PRODUCTS WHERE name LIKE :query AND removed='0';";
  $stmt = $db->prepare($sql);
  $stmt->execute(array("query" => "%$searchterm%"));
  $items = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
<title>Sökresultat för: <?php echo $searchterm ?> - Elshoppen</title>
  <!-- Include basic libraries -->
  <?php include("../../modules/bootstrap_css.php"); ?>
</head>
<body>
  <?php include("../../header.php"); ?>

  <div id="main" class="container">
  
    <h1>Din sökning "<?php echo $searchterm; ?>" gav "<?php echo count($items); ?>" träff<?php if(count($items) != 1) echo "ar"; ?>.</h1>
    <div class="row">
      <?php
        foreach ($items as $item) {
          include("../../modules/item_card.php");
        }
      ?>
    </div>
  </div>

  <?php include("../../footer.php"); ?>

  <!-- Include jQuery, popper and bootstrap  -->
  <?php include("../../modules/bootstrap_js.php"); ?>

  <!-- fix footer position -->
  <script src="../../footer.js"></script>

</body>
</html>
