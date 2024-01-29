<div class="container">
    <h3>Catalog</h3>
    <div class="card-deck">
        <?php foreach ($products as $product): ?>
        <div class="card text-center">
                <!--<div class="card-header">
                    Hit!
                </div> -->
                <img class="card-img-top" src="<?php echo $product->getLink(); ?>" alt="Card image">
                <div class="card-body">
                    <p class="card-text text-muted"><?php echo $product->getName(); ?></p>
                    <!--<a href="#"><h5 class="card-title">Very long item name</h5></a>-->
                    <div class="card-footer">
                        <?php echo $product->getPrice(); ?> ₽
                    </div>
                    <div class="add">
                        <form action="/add-product" method="POST">
                            <input type="hidden" name="product_id" value="<?php echo $product->getId(); ?>">
                            <label style="color: red"><?php echo $errors['add_product'] ?? ''; ?></label>
                            <label>
                                <input type="number" name="quantity" value="1" min="1">
<!--                                <input type="submit" name="minus" value="--"/>-->
<!--                                <input type="text" name="sum" value="--><?php //=$sum;?><!--" size="1"/>-->
<!--                                <input type="submit" name="add" value="++"/>-->
                                <label style="color: red"><?php echo $errors['quantity'] ?? ''; ?></label>
                            </label>
                            <input type="submit" name="add_to_cart" value="Add to cart">
                        </form>
                    </div>
                </div>
        </div>
        <?php endforeach; ?>
    </div>
    <div class="placeOrder">
        <form action="/placeOrder" method="post">
            <a href="/placeOrder" class="checkout-button">Place order</a>
        </form>
    </div>
    <div class="cart">
        <form action="/cart" method="post">
            <a href="/cart" class="checkout-button">Cart</a>
        </form>
    </div>
</div>
<div class="logout">
    <form action="/logout" method="post">
        <button type="submit" class="logout-button">Log out</button>
    </form>
</div>

<style>
    body {
        font-style: sans-serif;
    }

    .container {
        padding: 20px;
    }

    .card-text {
        margin-bottom: 10px;
        text-align: center;
    }

    .card-footer {
        text-align: center;
        margin-top: 10px;
    }

    a {
        text-decoration: none;
    }

    .card-header a {
        color: inherit;
    }

    .card-header a:hover {
        text-decoration: underline;
    }

    .card-img-top {
        width: 100%;
        height: auto;
        object-fit: cover;
    }

    a:hover {
        text-decoration: none;
    }

    h3 {
        line-height: 3em;
    }

    .card {
        max-width: 16rem;
    }

    .card:hover {
        box-shadow: 1px 2px 10px lightgray;
        transition: 0.2s;
    }

    .card-header {
        font-size: 13px;
        color: gray;
        background-color: white;
    }

    .text-muted {
        font-size: 11px;
    }

    .card-footer{
        font-weight: bold;
        font-size: 18px;
        background-color: white;
    }

    .logout {
        text-align: left;
        margin-top: 20px;
    }

    .logout-button {
        background-color: #04aa6d;
        color: white;
        border: none;
        padding: 10px 20px;
        font-size: 16px;
        border-radius: 4px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .logout-button:hover {
        background-color: #53ef7d;
    }

    .checkout-button {
        display: inline-block;
        background-color: #04aa6d;
        color: white;
        border: none;
        padding: 10px 20px;
        font-size: 16px;
        border-radius: 4px;
        cursor: pointer;
        transition: background-color 0.3s ease;
        text-decoration: none;
    }

    .checkout-button:hover {
        background-color: #53ef7d;
    }

    .add-more-button {
        display: none;
    }
</style>