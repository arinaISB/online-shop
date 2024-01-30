<div class="container">
    <h3>Catalog</h3>
    <div class="card-deck">
        <?php foreach ($products as $product): ?>
        <div class="card text-center">
                <img class="card-img-top" src="<?php echo $product->getLink(); ?>" alt="Card image">
                <div class="card-body">
                    <p class="card-text text-muted"><?php echo $product->getName(); ?></p>
                    <div class="card-footer">
                        <?php echo $product->getPrice(); ?> ₽
                    </div>
                    <div class="add">
                        <form action="/edit-quantity-product" method="POST">
                            <input type="hidden" name="product_id" value="<?=$product->getId();?>">
                            <button type="submit" name="action" value="minus">--</button>
                        </form>

                        <form action="/edit-quantity-product" method="POST">
                            <input type="hidden" name="product_id" value="<?=$product->getId();?>">
                            <button type="submit" name="action" value="add">++</button>
                        </form>

                        <label>
                            <input type="text" name="quantity" value="<?=$quantitiesOfEachProductInTheCart[$product->getId()] ?? 0;?>" size="1" readonly/>
                        </label>
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
    <a href="/cart" class="cart">
        <span class="count">1</span>
        <i class="material-icons">shopping_cart</i>
    </a>
</div>
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
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
        position: relative;
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


    .cart {
        position: absolute;
        top: 10px;
        right: 20px;
        display: block;
        width: 28px;
        height: 28px;
        height: auto;
        overflow: hidden;
        cursor: pointer;
    }

    .cart:hover {
        opacity: 0.8;
    }

    .cart .material-icons {
        position: relative;
        top: 4px;
        z-index: 1;
        font-size: 24px;
        color: #131212;
    }

    .cart .count {
        position: absolute;
        top: 0;
        right: 0;
        z-index: 2;
        font-size: 11px;
        border-radius: 50%;
        background: #53ef7d;
        width: 16px;
        height: 16px;
        line-height: 16px;
        display: block;
        text-align: center;
        color: white;
        font-family: 'Roboto', sans-serif;
        font-weight: bold;
    }
</style>