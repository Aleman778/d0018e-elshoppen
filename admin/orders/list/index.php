<?php 
    $root = $_SERVER['DOCUMENT_ROOT'];
    include("$root/admin/access.php");

    $editAccess = checkAccess("/admin/products/edit/index.php");
    $deleteAccess = checkAccess("/admin/products/list/delete.php");
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Admin - Beställningar</title>
        <?php include("$root/modules/bootstrap_css.php"); ?>
        <link rel="stylesheet" href="/admin/style.css">
    </head>
    <body>
        <?php include("$root/admin/header.php"); ?>
        <div id="wrapper" class="row">
            <div id="sidebar-div" class="col-sm">
                <?php include("$root/admin/sidebar.php"); ?>
            </div>
            <div id="content-div" class="col-sm p-4">
                <?php if (array_key_exists("del", $_GET)) { ?>
                    <?php if ($_GET["del"] == "success") { ?>
                        <div class="alert alert-success" role="alert">
                            The Order was successfully removed from the database!
                        </div>
                    <?php } ?>
                    <?php if ($_GET["del"] == "error") { ?>
                        <div class="alert alert-danger" role="alert">
                            The order failed to be removed from the database! Error message:<br>
                            <?php echo $_GET["msg"]; ?>
                        </div>
                    <?php } ?>
                <?php } ?>
                <?php if (array_key_exists("edit", $_GET)) { ?>
                    <?php if ($_GET["edit"] == "success") { ?>
                        <div class="alert alert-success" role="alert">
                            The order was successfully updated in the database!
                        </div>
                    <?php } ?>
                    <?php if ($_GET["edit"] == "error") { ?>
                        <div class="alert alert-danger" role="alert">
                            The order failed to be updated in the database! Error message:<br>
                            <?php echo $_GET["msg"]; ?>
                        </div>
                    <?php } ?>
                <?php } ?>
                <h3>Orders</h3>
                <?php
                    include("$root/modules/mysql.php");
                    $db = new MySQL();
                    $sql = "SELECT id, customer_id, time, handled, email
                            FROM ORDERS ORDER BY time DESC";
                    $items = $db->fetchAll($sql);
                ?>
                <table class="table" style=" border-bottom: 1px solid #dee2e6;">
                    <thead class="thead">
                        <tr>
                            <th scope="col" style="border: none;">Beställning</th>
                            <th scope="col" style="border: none;">Konto ID</th>
                            <th scope="col" style="border: none;">Order ID</th>
                            <th scope="col" style="border: none;">Datum och Tid</th>
                            <th scope="col" style="border: none;">Hanterad</th>
                            <?php if ($editAccess or $deleteAccess) { ?>
                                <th scope="col" style="border: none;">Åtgärder</th>
                            <?php } ?>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach($items as $item) { ?>
                        
                        <tr>
                            <td>
                                <div class="row">
                                    <div class="col-sm" style="max-width: 12rem; height: 8rem; overflow: hidden; text-align:center">
                                    <img src="<?php echo get_gravatar($item["email"], 38); ?>" class="rounded-circle" width="38" height="38">
                                    </div>
                                </div>
                            </td><td style="text-align: center;" class="cid">
                                <?php echo $item["customer_id"]; ?>
                            </td>
                            <td style="text-align: center;" class="oid">
                                <?php echo $item["id"] ?> 
                            </td>
                            <td style="text-align: center;" class="time">
                                <?php echo $item["time"] ?> 
                            </td>
                            <td style="text-align: center;" class="handled">
                                <?php if($item["handled"] == 1) { echo "Hanterad";} else { echo "Inte hanterad";}; ?> 
                            </td>
                            <?php if ($editAccess or $deleteAccess) { ?>
                                <td>
                                    <?php if ($editAccess) { ?>
                                        <a href="/admin/orders/edit/index.php?oid=<?php echo $item["id"]; ?>" class="btn-edit"><img src="/images/icons/edit.svg"></a>
                                    <?php } ?>
                                    <?php if ($deleteAccess) { ?>
                                        <a href="#" class="btn-delete" data-toggle="modal" data-target="#deleteProduct<?php echo $item["id"]; ?>"><img src="/images/icons/delete.svg"></a> 
                                    <?php } ?>
                                </td>
                            <?php } ?>
                        </tr>
                        

                        <!-- Modal -->
                        <?php if ($deleteAccess) { ?>
                            <div class="modal fade" id="deleteProduct<?php echo $item["id"]; ?>" tabindex="-1" role="dialog" aria-labelledby="deleteProductModal<?php echo $item["id"]; ?>" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="deleteProductModal<?php echo $item["id"]; ?>">Är du säker på att du vill radera ordern?</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-md">
                                                    <h5 class="mb-1"><b>Order id: </b><?php echo $item["id"]; ?></h5>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <a href="#" type="button" class="btn btn-secondary" data-dismiss="modal">Avbryt</button>
                                            <a href="delete.php?oid=<?php echo $item["id"]; ?>" type="button" class="btn btn-danger">Radera</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    <?php } ?>
                </table>
                
            </div>
        </div>

        <?php include("$root/modules/bootstrap_js.php"); ?>

        <!-- Run basic admin script -->
        <script src="/admin/basic.js"></script>
    </body>
</html>
