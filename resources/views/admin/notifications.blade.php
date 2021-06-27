<div class="ps-cart">
    <a class="ps-cart__toggle" href="#">
        <span><i>20</i></span><i class="ps-icon-shopping-cart"></i>
    </a>
    <div class="ps-cart__listing">
        <div class="ps-cart__content">
        @foreach($notifications as $notification)
            <div class="ps-cart-item"><a class="ps-cart-item__close" href="#"></a>
                <div class="ps-cart-item__thumbnail"><a href="product-detail.html"></a><img src="" alt=""></div>
                <div class="ps-cart-item__content"><a class="ps-cart-item__title" href="product-detail.html"></a>
                    <p>
                    <span>Quantity:<i></i></span>
                    <span>Total:<i>${{$total}}</i></span>
                    </p>
                </div>
            </div>
        </div>
        @endforeach
        <div class="ps-cart__footer"><a class="ps-btn" href="cart.html">Check out<i class="ps-icon-arrow-left"></i></a></div>
    </div>
</div>