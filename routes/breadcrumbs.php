<?php

use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;

Breadcrumbs::for('home', function (BreadcrumbTrail $trail) {
    $trail->push('Home', route('home'));
});

Breadcrumbs::for('login', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Sign In', route('login'));
});


Breadcrumbs::for('register', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Sign Up', route('register'));
});

Breadcrumbs::for('password.request', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Forgot Password', route('password.request'));
});

Breadcrumbs::for('password.reset', function (BreadcrumbTrail $trail)  {
    $trail->parent('home');
    $trail->push('Reset Password', route('password.reset'));
});

Breadcrumbs::for('dashboard', function (BreadcrumbTrail $trail)  {
    $trail->parent('home');
    $trail->push('Dashboard', route('dashboard'));
});

Breadcrumbs::for('profile', function (BreadcrumbTrail $trail)  {
    $trail->parent('dashboard');
    $trail->push('Profile', route('frontend.profile'));
});

Breadcrumbs::for('contact', function (BreadcrumbTrail $trail)  {
    $trail->parent('home');
    $trail->push('Contact', route('contact'));
});

Breadcrumbs::for('about-us', function (BreadcrumbTrail $trail)  {
    $trail->parent('home');
    $trail->push('About Us', route('about-us'));
});

Breadcrumbs::for('faq', function (BreadcrumbTrail $trail)  {
    $trail->parent('home');
    $trail->push('FAQ', route('faq'));
});

Breadcrumbs::for('auctions', function (BreadcrumbTrail $trail, $category = null, $categoryTitle = null)  {
    $trail->parent('home');
    if ($category) {
        $trail->push($categoryTitle, route('auctionsByCategory', ['category' => $category]));
    } else {
        $trail->push('Auctions', route('auctions'));
    }
});

Breadcrumbs::for('quotations', function (BreadcrumbTrail $trail, $category = null, $categoryTitle = null)  {
    $trail->parent('home');
    if ($category) {
        $trail->push($categoryTitle, route('auctionsByCategory', ['category' => $category]));
    } else {
        $trail->push('Quotations', route('quotations'));
    }
});

Breadcrumbs::for('auction', function (BreadcrumbTrail $trail, $slug, $title) {
    $trail->parent('home');
    $trail->push($title, route('auction', ['slug' => $slug]));
});

Breadcrumbs::for('auction-product', function (BreadcrumbTrail $trail, $slug, $auctionTitle, $catalogueSlug, $productId, $productTitle) {
    $trail->parent('auction', $slug, $auctionTitle);
    $trail->push($productTitle, route('auction-product', ['slug' => $slug, 'catalogue_slug' => $catalogueSlug, 'id' => $productId]));
});

Breadcrumbs::for('my-auctions', function (BreadcrumbTrail $trail, $status = null) {
    $trail->parent('home');
    $trail->push('My Auctions', route('frontend.my-auctions', ['status' => $status]));
});

Breadcrumbs::for('frontend.edit-auction', function (BreadcrumbTrail $trail, $id) {
    $trail->parent('my-auctions');
    $trail->push('Edit Auction', route('frontend.edit-auction', ['id' => $id]));
});

Breadcrumbs::for('my-auctions-products', function (BreadcrumbTrail $trail, $slug, $auctionTitle) {
    $trail->parent('my-auctions');
    $trail->push($auctionTitle, route('my-auction-products', ['slug' => $slug ]));
});

Breadcrumbs::for('my-auctions-product-bids', function (BreadcrumbTrail $trail, $slug, $id, $auctionTitle, $productTitle) {
    $trail->parent('my-auctions-products', $slug, $auctionTitle);
    $trail->push($productTitle, route('my-auction-product-bids', ['slug' => $slug, 'id' => $id]));
});

Breadcrumbs::for('my-auctions-product-bid', function (BreadcrumbTrail $trail, $slug, $id, $auctionTitle, $productTitle, $bidId) {
    $trail->parent('my-auctions-product-bids', $slug, $id, $auctionTitle, $productTitle);
    $trail->push(__('Bid') . ' #' . $bidId, route('my-auction-product-bid', ['slug' => $slug, 'id' => $id, 'bid_id' => $bidId]));
});

Breadcrumbs::for('favorites', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Favorites', route('frontend.dashboard.favorites'));
});


