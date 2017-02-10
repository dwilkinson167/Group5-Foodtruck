
<!DOCTYPE html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Food Truck</title>

    <link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.2/themes/dark-hive/jquery-ui.css" type="text/css" media="all" />

    <link rel="stylesheet" href="css/styles.css" type="text/css" media="all" />
    <link href="https://fonts.googleapis.com/css?family=Pangolin" rel="stylesheet">
    <style type="text/css">
    </style>
</head>

<body>



<div id="wrapper">
    <header>
        <img src="images/logo.JPG" alt="Logo" />
    </header>
    <nav>
        <ul>
            <li>
                Menu
            </li>
            <li>
                <a href="#">
                    About
                </a>
            </li>
            <li>
                <a href="#">
                    Contact
                </a>
            </li>
            <li>
                <a href="#">
                    Hours
                </a>
            </li>
        </ul>
    </nav>
    <aside>
        <div class="ui-widget">
            <h2 class="ui-widget ui-widget-header ui-corner-top">Cart Content</h2>
            <form id="cart_state" action="" method="post" class="ui-widget ui-widget-content ui-corner-bottom">
                <input type="hidden" value="cart" name="cart" />
                <fieldset class="cart-items">
                    <?php $cartItems = $cart->getAll(); ?>
                    <?php if ( ! empty($cartItems)): ?>
                        <?php foreach ($cartItems as $i => $item): ?>
                            <div class="field">
                                <label> <?php echo $item['item']->getCost() ?><?php echo $item['item']->getName(); ?></label>
                                <br />
                                <span> Amount: </span><input type="text"  class="ui-state-default amount-box" name="amount_<?php echo $i ?>" value="<?php echo $item['amount'] ?>" disabled="disabled" />
                                <label for="remove_product_<?php echo $i ?>">Remove from cart </label>
                                <input type="checkbox" name="remove_product[]" id="remove_product_<?php echo $i ?>" value="<?php echo $i ?>" />


                            </div>
                        <?php endforeach; ?>
                        <hr class="separator ui-state-disabled" />
                        <label>Total with tax</label>
                        <input type="text" disabled="disabled" class="ui-state-default" value="<?php echo $cart->getTotal(); ?>" />
                        <input type="submit" value="Remove checked" name="remove" />
                        <input type="submit" value="Empty cart" name="empty" />
                    <?php endif; ?>
                </fieldset>
            </form>
        </div>
    </aside>
    <!-- Here we start the menu in the main-->
    <main>
        <div class="ui-widget">
            <h2 class="ui-widget ui-widget-header ui-corner-top">Menu</h2>
            <form id="product_list" action="" method="post" class="ui-widget ui-widget-content ui-corner-bottom">
                <fieldset class="products">
                    <?php foreach ($products as $product): ?>
                        <div class="field">
                            <label for="product_<?php echo $product->id ?>"><?php echo $product->getName();  echo $product->getDescription() . ' - ', '$' . $product->getCost(); ?></label>
                            <input type="checkbox" id="product_<?php echo $product->id; ?>" name="product_check[]" value="<?php echo $product->id ?>" />
                        </div>
                    <?php endforeach; ?>
                    <hr class="separator ui-state-disabled" />
                    <input type="submit" value="Add to cart!" name="add" />
                </fieldset>
            </form>
        </div>


        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.2/jquery-ui.min.js"></script>
        <script type="text/javascript" src="js/default.js"></script>
    </main>


</div>
</body>
</html>