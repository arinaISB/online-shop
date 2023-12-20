<div class="container">
    <h3>Catalog</h3>
    <div class="card-deck">
        <?php foreach ($products as $product): ?>
        <div class="card text-center">
            <a href="#">
                <div class="card-header">
                    Hit!
                </div>
                <img class="card-img-top" src="<?php echo $product['link']; ?>" alt="Card image">
                <div class="card-body">
                    <p class="card-text text-muted"><?php echo $product['name']; ?></p>
                    <!--<a href="#"><h5 class="card-title">Very long item name</h5></a>-->
                    <div class="card-footer">
                        <?php echo $product['price']; ?> ₽
                    </div>
                </div>
            </a>
        </div>
        <?php endforeach; ?>
    </div>
</div>
<div class="logout ">
    <form action="/logout" method="post">
        <button type="submit">Log out</button>
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
</style>