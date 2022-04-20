<?php

/**
 * @var $title string
 * @var $model CatalogProduct
 */

use App\Common\Models\Catalog\CatalogProduct;

$toLayout = [
    'title' => $title ?? '',
    'script' => _frontend('js/product.js'),
    'style' => _frontend('css/product.css'),
];

$galleries = $model->manyGalleryWithImages ?? [];
?>
@extends('frontend.layout',$toLayout)
@section('content')
    <main class="product-card unselectable">
        <div class="container-fluid inner mb-4">
            <div class="row">
                <div class="col-sm-8 content">
                    <div class="blog-posts classic-blog">
                        <div class="post">
                            <div class="fotorama"
                                 data-allowfullscreen="true"
                                 data-autoplay="5000"
                                 data-keyboard="true"
                                 data-arrows="true"
                                 data-click="false"
                                 data-swipe="true"
                                 data-nav="thumbs"
                                 data-fit="contain"
                                 data-width="100%"
                                 data-height="100vh"
                                 data-maxheight="700px"
                                 data-transition="slide"
                                 data-thumbwidth="100"
                                 data-thumbheight="50">
                                <?php foreach ($galleries as $gallery){ ?>
                                <?php foreach ($gallery->images as $image){ ?>
                                <a href="<?= $image->getImage() ?>"><img src="<?= $image->getImage() ?>" alt=""/></a>
                                <?php } ?>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
                <aside class="col-sm-4 sidebar lp30 sidebar__right">
                    <div class="padding-top-2x mt-2 hidden-md-up"></div>
                    <h2 class="mb-3"><?= $model->title ?></h2>
                    <span class="h3 d-block">Цена: <?= $model->price ?> ₽</span>
                    <p class="text-muted"><?= $model->description ?></p>
                    <div class="pt-1"><span class="text-medium">PROPERTY:</span> #21457832</div>
                    <div class="pt-1"><span class="text-medium">PROPERTY:</span> #21457832</div>
                    <div class="pt-1"><span class="text-medium">PROPERTY:</span> #21457832</div>
                    <div class="pt-1 mb-4"><span class="text-medium">PROPERTY:</span> #21457832</div>
                    <hr class="mb-4">
                    <div class="row">
                        <div class="col-sm-12 align-items-end">
                            <button
                                class="btn btn-outline-success float-right"
                                data-js-catalog-product-id="<?= $model->id ?>">
                                Добавить в корзину
                            </button>
                            <button type="button" class="btn btn-outline-secondary float-right mr-1">Избранное</button>
                        </div>
                    </div>
                </aside>
            </div>
        </div>
        <div class="product__tabs">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="nav-link active" id="description-tab" data-toggle="tab" href="#description"
                       role="tab" aria-controls="home" aria-selected="true">Description</a>
                </li>

                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="wood-tab" data-toggle="tab" href="#wood" role="tab"
                       aria-controls="profile" aria-selected="false">Wood Characteristics</a>
                </li>

                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="care-tab" data-toggle="tab" href="#care" role="tab"
                       aria-controls="contact" aria-selected="false">Care & Food Safety</a>
                </li>

                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="shipping-tab" data-toggle="tab" href="#shipping" role="tab"
                       aria-controls="contact" aria-selected="false">Shipping</a>
                </li>

                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="shop-tab" data-toggle="tab" href="#shop" role="tab"
                       aria-controls="contact" aria-selected="false">Shop Policies</a>
                </li>

                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="secure-tab" data-toggle="tab" href="#secure" role="tab"
                       aria-controls="contact" aria-selected="false">Secure Payment</a>
                </li>
            </ul>

            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="description" role="tabpanel"
                     aria-labelledby="home-tab">
                    <h3 class="product__subtitle">Description</h3>

                    <p class="product__description">
                        So now and then, I create items without a distinct function because they
                        could fulfill many, many different roles. As a wedding ring bearer or a
                        luxury bonbon stand… or as a very stylish platter to keep your day jewelry
                        while sleeping. It’s a modest and fascinating little piece, which feels like
                        a little treasure keeper… depending on what is meaningful to you or the
                        lucky person who’s going to receive this as a gift.
                    </p>
                </div>

                <div class="tab-pane fade" id="wood" role="tabpanel" aria-labelledby="profile-tab">
                    <h3 class="product__subtitle">Wood Characteristics</h3>

                    <p class="product__description">
                        The very interesting thing about wood is not only its diversity in grain,
                        color, fragrance & patterns….but as well, it can carry countless traces of
                        its life on the planet. Note that in all of my items can be visible traces
                        of those characteristics. Those typical traces can be for example;
                    </p>
                </div>

                <div class="tab-pane fade" id="care" role="tabpanel" aria-labelledby="profile-tab">
                    <h3 class="product__subtitle">Care & Food Safety</h3>

                    <p class="product__description">
                        Hand-wash your handmade wooden boards after each use with mild soap and warm
                        water. Wipe by hand and allow it to dry upstanding & separately from other
                        boards. Most important, never allow your board in a dishwasher or standing
                        water…your beautiful board can split or crack under those conditions. White
                        vinegar or lemon can be used to disinfect and remove smelly odors.
                    </p>
                </div>

                <div class="tab-pane fade" id="shipping" role="tabpanel" aria-labelledby="profile-tab">
                    <h3 class="product__subtitle">Shipping</h3>

                    <p class="product__description">
                        Congratulations!
                        Today, you have chosen for a true unique and handmade little slice of happiness!
                        You can be very positive about the fact that I’ve spend a lot of time, pleasure
                        and dedication on this product. Therefore, it deserves a correct & reliable
                        sending. Below you can read how the item will find its way to your homestead;
                    </p>
                </div>

                <div class="tab-pane fade" id="shop" role="tabpanel" aria-labelledby="profile-tab">
                    <h3 class="product__subtitle">Shop Policies</h3>

                    <p class="product__description">
                        Dear Customer,

                        For me, it’s very important that you are pleased with your purchase. If, for any
                        reason, you are not are happy with your purchase after receiving it, please
                        contact me and I will make sure we will resolve this inconvenience as soon as
                        possible!

                        Please note, in case of a delay or problem with the delivery or a lost package
                        because of a malfunction of the postal service, I’m asking you to be patient…
                        thankfully, these things happen not very often but it’s still possible. Please,
                        allow to wait 2 months from the shipping date. If your package still didn’t
                        arrive by then, I will make you a full refund. In the unlikely case that you, as
                        a customer, provided me the wrong shipping address, I’ll refund you the original
                        purchase price MINUS the shipping fee as soon as the package arrived back to me.

                        I accept returns if you contact me within 14 days after having received your
                        package. The order has to be shipped back in the original box (or an equivalent
                        quality) with track & trace, signature required, insurance and within 21 days
                        after you have received it. Please contact me before sending the item back, I
                        would like to know the reason for your return. Refund will only take place after
                        I’ve received your returned item(s). Please note that, unless the package did
                        arrive to you broken or damaged, that you as a customer, are responsible for the
                        return shipping fees.

                        Friendly greetings,
                        Michael Vermeij
                    </p>
                </div>

                <div class="tab-pane fade" id="secure" role="tabpanel" aria-labelledby="profile-tab">
                    <h3 class="product__subtitle">Secure Payment</h3>

                    <p class="product__description">
                        When purchasing from Michael Vermeij Handcrafted Design, credit card and order
                        data are encrypted and secured through an SSL-certificate, recognizable on the
                        green padlock in your web browser. SSL Certificates are small data files that
                        digitally bind a cryptographic key to an organization’s details. When installed
                        on a web server, it activates the padlock and the https protocol and allows
                        secure connections from a web server to a browser. SSL certificates are used to
                        secure credit card transactions, data transfers and logins, and is becoming the
                        norm when purchasing online.
                    </p>
                </div>
            </div>
        </div>
    </main>
@endsection
