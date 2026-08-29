<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| NovaDrop — Routes
|--------------------------------------------------------------------------
| Modules: storefront, admin, products, cart, checkout, payments,
|          orders, customers, shipping, suppliers, importer, fulfillment
|--------------------------------------------------------------------------
*/

$route['default_controller'] = 'storefront/home';
$route['404_override']       = 'storefront/errors/page_404';
$route['translate_uri_dashes'] = FALSE;

// ─── Dev only: routing self-test ────────────────────────────
$route['dev/route-test'] = 'dev/route_test/index';

// ─── Storefront ─────────────────────────────────────────────
$route['']                                          = 'storefront/home/index';
$route['lookbook']                                  = 'storefront/home/index';
$route['curated']                                   = 'storefront/home/index';
$route['shop']                                      = 'storefront/shop/index';
$route['boutique']                                  = 'storefront/shop/index';
$route['gallery']                                   = 'storefront/shop/index';
$route['collections']                               = 'storefront/collections/index';
$route['collections/(:any)']                        = 'storefront/shop/collection/$1';
$route['shop/(:any)']                               = 'storefront/shop/collection/$1';
$route['products/(:any)']                           = 'storefront/products/detail/$1';
$route['product/(:any)']                            = 'storefront/products/detail/$1';
$route['tracking']                                  = 'storefront/pages/tracking';
$route['shipping']                                  = 'storefront/pages/shipping';
$route['logistics']                                 = 'storefront/pages/shipping';
$route['provenance']                                = 'storefront/pages/provenance';
$route['terms']                                     = 'storefront/pages/terms';
$route['manifesto']                                 = 'storefront/pages/manifesto';
$route['sustainability']                             = 'storefront/pages/manifesto';
$route['stylist']                                   = 'storefront/pages/stylist';
$route['search']                                    = 'storefront/search/index';

// ─── Cart ───────────────────────────────────────────────────
$route['cart']                                      = 'cart/index/view';
$route['cart/items']                                = 'cart/index/items';
$route['cart/add']                                  = 'cart/index/add';
$route['cart/update']                               = 'cart/index/update';
$route['cart/remove']                               = 'cart/index/remove';
$route['cart/apply_discount']                       = 'cart/index/apply_discount';
$route['cart/apply-discount']                       = 'cart/index/apply_discount';

// ─── Checkout ───────────────────────────────────────────────
$route['checkout']                                  = 'checkout/index/start';
$route['checkout/shipping']                         = 'checkout/index/shipping';
$route['checkout/payment']                          = 'checkout/index/payment';
$route['checkout/confirm']                          = 'checkout/index/confirm';
$route['checkout/success/(:num)']                   = 'checkout/index/success/$1';
$route['checkout/failed']                           = 'checkout/index/failed';

// ─── Payments & Webhooks ─────────────────────────────────────
$route['payments/razorpay/init']                    = 'payments/razorpay/init';
$route['payments/razorpay/verify']                  = 'payments/razorpay/verify';
$route['payments/webhook/razorpay']                 = 'payments/razorpay/webhook';
$route['payments/stripe/init']                      = 'payments/stripe/init';
$route['payments/stripe/verify']                    = 'payments/stripe/verify';
$route['payments/webhook/stripe']                   = 'payments/stripe/webhook';
$route['payments/cod/place']                        = 'payments/cod/place';

// ─── Customer Account ────────────────────────────────────────
$route['account/login']                               = 'customers/auth/login';
$route['account/send-otp']                            = 'customers/auth/send_otp';
$route['account/verify-otp']                          = 'customers/auth/verify_otp';
$route['account/google']                            = 'customers/auth/google_login';
$route['account/google/callback']                   = 'customers/auth/google_callback';
$route['account/register']                          = 'customers/auth/register';
$route['account/logout']                            = 'customers/auth/logout';
$route['account/forgot-password']                   = 'customers/auth/forgot_password';
$route['account/reset-password/(:any)']             = 'customers/auth/reset_password/$1';
$route['account']                                   = 'customers/account/dashboard';
$route['account/orders']                            = 'customers/account/orders';
$route['account/orders/(:num)']                     = 'customers/account/order_detail/$1';
$route['account/wishlist']                          = 'customers/account/wishlist';
$route['account/addresses']                         = 'customers/account/addresses';
$route['account/profile']                           = 'customers/account/profile';

// ─── Admin (Unified Modern UI) ──────────────────────────────
$route['admin']                                     = 'admin/dashboard/index';
$route['admin/login']                               = 'admin/auth/login';
$route['admin/logout']                              = 'admin/auth/logout';
$route['admin/auth/(:any)']                         = 'admin/auth/$1';
$route['admin/dashboard']                           = 'admin/dashboard/index';
$route['admin/dashboard/(:any)']                    = 'admin/dashboard/$1';

$route['admin/products']                            = 'admin/products/index';
$route['admin/products/create']                     = 'admin/products/create';
$route['admin/products/edit/(:num)']                = 'admin/products/edit/$1';
$route['admin/products/delete/(:num)']              = 'admin/products/delete/$1';
$route['admin/products/(:any)']                     = 'admin/products/$1';
$route['admin/products/(:any)/(:any)']              = 'admin/products/$1/$2';

$route['admin/customers']                           = 'admin/customers/index';
$route['admin/customers/create']                    = 'admin/customers/create';
$route['admin/customers/edit/(:num)']               = 'admin/customers/edit/$1';
$route['admin/customers/delete/(:num)']             = 'admin/customers/delete/$1';
$route['admin/customers/(:any)']                    = 'admin/customers/$1';
$route['admin/customers/(:any)/(:any)']             = 'admin/customers/$1/$2';

$route['admin/users']                               = 'admin/users/index';
$route['admin/users/create']                        = 'admin/users/create';
$route['admin/users/edit/(:num)']                   = 'admin/users/edit/$1';
$route['admin/users/delete/(:num)']                 = 'admin/users/delete/$1';
$route['admin/users/(:any)']                        = 'admin/users/$1';
$route['admin/users/(:any)/(:any)']                 = 'admin/users/$1/$2';

$route['admin/vendors']                             = 'admin/vendors/index';
$route['admin/vendors/create']                      = 'admin/vendors/create';
$route['admin/vendors/edit/(:num)']                 = 'admin/vendors/edit/$1';
$route['admin/vendors/delete/(:num)']               = 'admin/vendors/delete/$1';
$route['admin/vendors/(:any)']                      = 'admin/vendors/$1';
$route['admin/vendors/(:any)/(:any)']               = 'admin/vendors/$1/$2';

$route['admin/orders']                              = 'admin/orders/index';
$route['admin/orders/detail/(:num)']                = 'admin/orders/detail/$1';
$route['admin/orders/(:any)']                       = 'admin/orders/$1';
$route['admin/orders/(:any)/(:any)']                = 'admin/orders/$1/$2';

$route['admin/finance']                             = 'admin/finance/index';
$route['admin/finance/(:any)']                      = 'admin/finance/$1';
$route['admin/payments']                            = 'admin/finance/index';
$route['admin/payments/(:any)']                     = 'admin/finance/$1';

$route['admin/marketing']                           = 'admin/marketing/index';
$route['admin/marketing/(:any)']                    = 'admin/marketing/$1';
$route['admin/marketing/(:any)/(:any)']             = 'admin/marketing/$1/$2';

$route['admin/promotions']                          = 'admin/promotions/index';
$route['admin/promotions/(:any)']                   = 'admin/promotions/$1';
$route['admin/promotions/(:any)/(:any)']            = 'admin/promotions/$1/$2';

$route['admin/loyalty']                             = 'admin/loyalty/index';
$route['admin/loyalty/(:any)']                      = 'admin/loyalty/$1';
$route['admin/loyalty/(:any)/(:any)']               = 'admin/loyalty/$1/$2';

$route['admin/ai_engine']                           = 'admin/aiengine/index';
$route['admin/ai_engine/(:any)']                    = 'admin/aiengine/$1';
$route['admin/ai_engine/(:any)/(:any)']             = 'admin/aiengine/$1/$2';
$route['admin/ai-engine']                           = 'admin/aiengine/index';
$route['admin/ai-engine/(:any)']                    = 'admin/aiengine/$1';
$route['admin/ai-engine/(:any)/(:any)']             = 'admin/aiengine/$1/$2';
$route['admin/ai']                                  = 'admin/aiengine/index';
$route['admin/ai/(:any)']                           = 'admin/aiengine/$1';

$route['admin/affiliates']                          = 'admin/affiliates/index';
$route['admin/affiliates/(:any)']                   = 'admin/affiliates/$1';
$route['admin/affiliates/(:any)/(:any)']            = 'admin/affiliates/$1/$2';

$route['admin/subscriptions']                       = 'admin/subscriptions/index';
$route['admin/subscriptions/(:any)']                = 'admin/subscriptions/$1';
$route['admin/subscriptions/(:any)/(:any)']         = 'admin/subscriptions/$1/$2';

$route['admin/cart_recovery']                       = 'admin/cartrecovery/index';
$route['admin/cart_recovery/(:any)']                = 'admin/cartrecovery/$1';
$route['admin/cart-recovery']                       = 'admin/cartrecovery/index';
$route['admin/cart-recovery/(:any)']                = 'admin/cartrecovery/$1';

$route['admin/analytics']                           = 'admin/analytics/index';
$route['admin/analytics/(:any)']                    = 'admin/analytics/$1';
$route['admin/reports']                             = 'admin/analytics/index';
$route['admin/reports/(:any)']                      = 'admin/analytics/$1';

$route['admin/whatsapp']                            = 'admin/whatsapp/index';
$route['admin/whatsapp/(:any)']                     = 'admin/whatsapp/$1';
$route['admin/tickets']                             = 'admin/whatsapp/index';
$route['admin/tickets/(:any)']                      = 'admin/whatsapp/$1';

$route['admin/audit']                               = 'admin/audit/index';
$route['admin/audit/(:any)']                        = 'admin/audit/$1';
$route['admin/activity']                            = 'admin/audit/index';
$route['admin/activity/(:any)']                     = 'admin/audit/$1';

$route['admin/settings']                            = 'admin/settings/index';
$route['admin/settings/(:any)']                     = 'admin/settings/$1';
$route['admin/settings/(:any)/(:any)']              = 'admin/settings/$1/$2';
$route['admin/appearance']                          = 'admin/settings/index';
$route['admin/appearance/(:any)']                   = 'admin/settings/$1';

// API (internal AJAX endpoints)
$route['api/v1/products/search']                    = 'api/products/search';
$route['api/v1/cart/count']                         = 'api/cart/count';
$route['api/v1/stock/check']                        = 'api/stock/check';
$route['api/v1/address/lookup/(:num)']              = 'api/address/lookup/$1';
