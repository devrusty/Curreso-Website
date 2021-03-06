<?php
include "../../../includes/header.php";
include "../includes/search.php";

include "../../../includes/inc/dbh.inc.php";

if (!isset($_GET["id"])) {
    header("LOCATION: /pages/shop/home.php");
}

if (isset($_GET["error"])) {
    if ($_GET["error"] == "insufficientFunds") {
        echo '<script>alert("You have insufficient funds.")</script>';
    }
}
?>

<div class="shop-itempg-container">
    <?php
    $sql = "SELECT * FROM `items` WHERE `itemsId` = " . $_GET["id"];
    $result = mysqli_query($conn, $sql);
    $pcall = mysqli_num_rows($result);

    if ($pcall > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<h3>' . $row["itemsName"] . '</h3><br/>';
            echo '<p class="item-price-display">Price: BX$' . abbreviateNumber($row["itemsPrice"]) . '</p>';
            echo '<p class="item-value-display">Value: BX$' . abbreviateNumber($row["itemsValue"]) . '</p>';
            echo '<img src="/images/coin.png">';
        }
    } else {
        header("LOCATION: /pages/error.php?error=404");
    }
    ?>

    <form <?php echo 'action="/includes/inc/shop/purchase.inc.php?id="' . $_GET["id"] ?> method="POST">
        <input name="id" type="id" disabled>

        <?php
        $onSalePHP = "SELECT `onSale` FROM `items` WHERE `itemsId` = " . $_GET["id"];
        $onSaleResult = mysqli_query($conn, $onSalePHP);
        $onSalepcall = mysqli_num_rows($onSaleResult);

        if ($onSalepcall > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                if ($row["onSale"] = 1) {
                    echo '<button class="btn-medium" name="purchase" type="purchase">Purchase</button>';
                } else {
                    echo '<button class="btn-medium">This item is not for sale.</button>';
                }
            }
        }
        ?>
    </form>
</div>

<?php
include "../../../includes/footer.php";
?>
