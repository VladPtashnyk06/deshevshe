<?php

use App\Http\Controllers\Admin\CommentController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MeestController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
/* =================================== */
/*             NovaPoshta              */
/* =================================== */
Route::post('/cities', [\App\Http\Controllers\DeliveryController::class, 'getCities'])->name('cities');
Route::post('/branches', [\App\Http\Controllers\DeliveryController::class, 'getBranches'])->name('branches');

/* =================================== */
/*                Meest                */
/* =================================== */
Route::post('/meest/branches', [MeestController::class, 'getBranches']);
Route::post('/meest/cities', [MeestController::class, 'getCities']);

/* =================================== */
/*             UkrPoshta               */
/* =================================== */
Route::get('/ukr/cities', [\App\Http\Controllers\UkrPoshtaController::class, 'getCities'])->name('ukr.cities');
Route::get('/ukr/branches', [\App\Http\Controllers\UkrPoshtaController::class, 'getBranches'])->name('ukr.branches');

/* =================================== */
/*                 Site                */
/* =================================== */
Route::controller(\App\Http\Controllers\Site\GeneralController::class)->group(function () {
    Route::get('/', 'index')->name('site.index');
    Route::get('/catalog', 'catalog')->name('site.catalog.index');
    Route::get('/catalog/show/{category}', 'show')->name('site.catalog.show');
});
Route::controller(\App\Http\Controllers\CurrencyController::class)->group(function () {
    Route::post('/change-currency', 'changeCurrency')->name('change-currency');
});
Route::group(['prefix' => 'product'], function () {
    Route::controller(\App\Http\Controllers\Site\ProductController::class)->group(function () {
        Route::get('/show-one-product/{product}', 'showOneProduct')->name('site.product.showOneProduct');
        Route::get('/viewed-products', 'recentlyViewedProducts')->name('site.product.recentlyViewedProducts');
        Route::get('/rec-products', 'recProducts')->name('site.product.recProducts');
        Route::get('/new-products', 'newProducts')->name('site.product.newProducts');
        Route::get('/get-sizes/{product_id}', 'getSizes')->name('site.product.getSizes');
        Route::get('/get-product/{product_id}', 'getProduct')->name('site.product.getProduct');
        Route::get('/likedProduct/{product}', 'likedProduct')->name('site.product.likedProduct');
        Route::get('/unlinkedProduct/{product}', 'unlinkedProduct')->name('site.product.unlinkedProduct');
        Route::get('/likedProducts', 'likedProducts')->name('site.product.likedProducts');
        Route::get('/promotionalProducts', 'promotionalProducts')->name('site.product.promotionalProducts');
    });
    Route::controller(\App\Http\Controllers\Site\ProductCommentController::class)->group(function () {
        Route::post('/comment/store', 'store')->name('site.product.comment.store');
    });
});
Route::group(['prefix' => 'blog'], function () {
    Route::controller(\App\Http\Controllers\Site\BlogController::class)->group(function () {
       Route::get('/', 'index')->name('site.blog.index');
       Route::get('/show/{blog}', 'show')->name('site.blog.show');
    });
    Route::controller(\App\Http\Controllers\Site\BlogCommentController::class)->group(function () {
       Route::post('/comment/create', 'commentStore')->name('site.blog.commentStore');
    });
});
Route::group(['prefix' => 'order'], function () {
    Route::controller(\App\Http\Controllers\Site\OrderController::class)->group(function () {
        Route::get('/all-my-orders', 'index')->name('site.order.index');
        Route::get('/create', 'create')->name('site.order.create');
        Route::post('/store', 'store')->name('site.order.store');
        Route::get('/oneOrder/{order}', 'oneOrder')->name('site.order.oneOrder');
        Route::get('/thank-you', 'thankYou')->name('site.order.thankYou');
        Route::post('/update/one-order/{order}', 'updateOneOrder')->name('site.order.updateOneOrder');
    });
});
Route::controller(\App\Http\Controllers\Site\CartController::class)->group(function () {
    Route::get('/cart', 'cartList')->name('cart');
    Route::post('/cart-add', 'addToCart')->name('cart.store');
    Route::patch('/cart-update', 'updateCart')->name('cart.update');
    Route::delete('/cart-remove', 'removeCart')->name('cart.remove');
});
Route::controller(\App\Http\Controllers\Site\CommentController::class)->group(function () {
   Route::get('/all-comments', 'index')->name('site.comment.index');
});

///* =================================== */
///*             Operator                */
///* =================================== */\
Route::middleware('auth.operator')->group(function () {
    Route::group(['prefix' => 'operator'], function () {
        Route::group(['prefix' => 'orders'], function () {
            Route::controller(\App\Http\Controllers\Admin\OrderController::class)->group(function () {
                Route::get('/', 'index')->name('operator.order.index');
                Route::post('/update-order-status/{id}', 'updateStatusAndOperator')->name('operator.order.updateOrderStatus');
                Route::get('/user-orders/{user}', 'showUserOrders')->name('operator.order.showUserOrders');
                Route::get('/edit-first/{order}', 'editFirst')->name('operator.order.editFirst');
                Route::post('/edit-first/update/{order}', 'updateFirst')->name('operator.order.updateFirst');
                Route::get('/edit-second/{order}', 'editSecond')->name('operator.order.editSecond');
                Route::post('/edit-second/update/{order}', 'updateSecond')->name('operator.order.updateSecond');
                Route::get('/edit-third/{order}', 'editThird')->name('operator.order.editThird');
                Route::post('/edit-third/update/{order}', 'updateThird')->name('operator.order.updateThird');
                Route::get('/edit-fourth/{order}', 'editFourth')->name('operator.order.editFourth');
                Route::post('/edit-fourth/update/{order}', 'updateFourth')->name('operator.order.updateFourth');
                Route::post('/update/{order}', 'update')->name('operator.order.update');
                Route::get('/small-edit/{order}', 'smallEdit')->name('operator.order.small-edit');
                Route::post('/small-edit/update/{order}', 'smallUpdate')->name('operator.order.smallUpdate');
                Route::get('/add-additional-product/update', 'getProductsByCode')->name('operator.order.addAdditionalProduct');
                Route::delete('/order-detail/delete/{order_detail}', 'orderDetailDestroy')->name('operator.order_detail.destroy');
            });
        });
    });
});

///* =================================== */
///*                 Admin                */
///* =================================== */
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::group(['prefix' => 'admin'], function () {
        Route::middleware('auth.admin')->group(function () {
            Route::group(['prefix' => 'users'], function () {
                Route::controller(\App\Http\Controllers\Admin\UserController::class)->group(function () {
                    Route::get('/', 'index')->name('user.index');
                    Route::get('/edit/{user}', 'edit')->name('user.edit');
                    Route::post('/update/{user}', 'update')->name('user.update');
                    Route::delete('/delete/{user}', 'destroy')->name('user.destroy');
                });
            });
            Route::group(['prefix' => 'orders'], function () {
                Route::controller(\App\Http\Controllers\Admin\OrderController::class)->group(function () {
                    Route::get('/', 'index')->name('order.index');
                    Route::get('/edit/{order}', 'edit')->name('order.edit');
                    Route::post('/update/{order}', 'update')->name('order.update');
                    Route::delete('/delete/{order}', 'destroy')->name('order.destroy');
                });
            });
            Route::group(['prefix' => 'product'], function () {
                Route::controller(\App\Http\Controllers\Admin\ProductController::class)->group(function () {
                    Route::get('/', 'index')->name('product.index');
                    Route::get('/create', 'create')->name('product.create');
                    Route::post('/store', 'store')->name('product.store');
                    Route::get('/edit/{product}', 'edit')->name('product.edit');
                    Route::post('/update/{product}', 'update')->name('product.update');
                    Route::delete('/delete-media/{media}', 'destroyMedia')->name('product.destroyMedia');
                    Route::delete('/delete/{product}', 'destroy')->name('product.destroy');
                    Route::delete('/delete-product-variant/{productVariant}', 'destroyProductVariant')->name('product.destroyProductVariant');
                });
                Route::group(['prefix' => 'color'], function () {
                    Route::controller(\App\Http\Controllers\Admin\ColorController::class)->group(function () {
                        Route::get('/', 'index')->name('color.index');
                        Route::get('/create', 'create')->name('color.create');
                        Route::post('/store', 'store')->name('color.store');
                        Route::get('/edit/{color}', 'edit')->name('color.edit');
                        Route::post('/update/{color}', 'update')->name('color.update');
                        Route::delete('/delete/{color}', 'destroy')->name('color.destroy');
                    });
                });
                Route::group(['prefix' => 'package'], function () {
                    Route::controller(\App\Http\Controllers\Admin\PackageController::class)->group(function () {
                        Route::get('/', 'index')->name('package.index');
                        Route::get('/create', 'create')->name('package.create');
                        Route::post('/store', 'store')->name('package.store');
                        Route::get('/edit/{package}', 'edit')->name('package.edit');
                        Route::post('/update/{package}', 'update')->name('package.update');
                        Route::delete('/delete/{package}', 'destroy')->name('package.destroy');
                    });
                });
                Route::group(['prefix' => 'material'], function () {
                    Route::controller(\App\Http\Controllers\Admin\MaterialController::class)->group(function () {
                        Route::get('/', 'index')->name('material.index');
                        Route::get('/create', 'create')->name('material.create');
                        Route::post('/store', 'store')->name('material.store');
                        Route::get('/edit/{material}', 'edit')->name('material.edit');
                        Route::post('/update/{material}', 'update')->name('material.update');
                        Route::delete('/delete/{material}', 'destroy')->name('material.destroy');
                    });
                });
                Route::group(['prefix' => 'characteristic'], function () {
                    Route::controller(\App\Http\Controllers\Admin\CharacteristicController::class)->group(function () {
                        Route::get('/', 'index')->name('characteristic.index');
                        Route::get('/create', 'create')->name('characteristic.create');
                        Route::post('/store', 'store')->name('characteristic.store');
                        Route::get('/edit/{characteristic}', 'edit')->name('characteristic.edit');
                        Route::post('/update/{characteristic}', 'update')->name('characteristic.update');
                        Route::delete('/delete/{characteristic}', 'destroy')->name('characteristic.destroy');
                    });
                });
                Route::group(['prefix' => 'size'], function () {
                    Route::controller(\App\Http\Controllers\Admin\SizeController::class)->group(function () {
                        Route::get('/', 'index')->name('size.index');
                        Route::get('/create', 'create')->name('size.create');
                        Route::post('/store', 'store')->name('size.store');
                        Route::get('/edit/{size}', 'edit')->name('size.edit');
                        Route::post('/update/{size}', 'update')->name('size.update');
                        Route::delete('/delete/{size}', 'destroy')->name('size.destroy');
                    });
                });
                Route::group(['prefix' => 'product_status'], function () {
                    Route::controller(\App\Http\Controllers\Admin\StatusController::class)->group(function () {
                        Route::get('/', 'index')->name('status.index');
                        Route::get('/create', 'create')->name('status.create');
                        Route::post('/store', 'store')->name('status.store');
                        Route::get('/edit/{status}', 'edit')->name('status.edit');
                        Route::post('/update/{status}', 'update')->name('status.update');
                        Route::delete('/delete/{status}', 'destroy')->name('status.destroy');
                    });
                });
                Route::group(['prefix' => 'producer'], function () {
                    Route::controller(\App\Http\Controllers\Admin\ProducerController::class)->group(function () {
                        Route::get('/', 'index')->name('producer.index');
                        Route::get('/create', 'create')->name('producer.create');
                        Route::post('/store', 'store')->name('producer.store');
                        Route::get('/edit/{producer}', 'edit')->name('producer.edit');
                        Route::post('/update/{producer}', 'update')->name('producer.update');
                        Route::delete('/delete/{producer}', 'destroy')->name('producer.destroy');
                    });
                });
                Route::group(['prefix' => 'category'], function () {
                    Route::controller(\App\Http\Controllers\Admin\CategoryController::class)->group(function () {
                        Route::get('/', 'index')->name('category.index');
                        Route::get('/create', 'create')->name('category.create');
                        Route::get('/create-sub-category/{category}', 'createSubCategory')->name('category.createSubCategory');
                        Route::post('/store', 'store')->name('category.store');
                        Route::get('/edit/{category}', 'edit')->name('category.edit');
                        Route::put('/update/{category}', 'update')->name('category.update');
                        Route::delete('/delete/{category}', 'destroy')->name('category.destroy');
                    });
                });
                Route::group(['prefix' => 'blog'], function () {
                    Route::controller(\App\Http\Controllers\Admin\BlogController::class)->group(function () {
                        Route::get('/', 'index')->name('blog.index');
                        Route::get('/create', 'create')->name('blog.create');
                        Route::post('/store', 'store')->name('blog.store');
                        Route::get('/edit/{blog}', 'edit')->name('blog.edit');
                        Route::get('/show-comments/{blog}', 'showComments')->name('blog.showComments');
                        Route::post('/update/{blog}', 'update')->name('blog.update');
                        Route::delete('/delete/{blog}', 'destroy')->name('blog.destroy');
                    });
                    Route::controller(\App\Http\Controllers\Admin\BlogCommentController::class)->group(function () {
                        Route::get('/create-answer/{blog_comment}', 'commentAnswerCreate')->name('blog.commentAnswerCreate');
                        Route::post('/store-answer', 'commentAnswerStore')->name('blog.commentAnswerStore');
                        Route::delete('/delete-comment/{blog_comment}', 'destroyComment')->name('blog.destroyComment');
                    });
                });
                Route::controller(\App\Http\Controllers\Admin\PromotionalController::class)->group(function () {
                    Route::get('/promotional', 'index')->name('promotional.index');
                    Route::get('/promotional/create', 'create')->name('promotional.create');
                    Route::post('/promotional/store', 'store')->name('promotional.store');
                    Route::get('/promotional/edit/{product}', 'edit')->name('promotional.edit');
                    Route::post('/promotional/update/{product}', 'update')->name('promotional.update');
                    Route::delete('/promotional/delete/{product}', 'destroy')->name('promotional.delete');
                });
                Route::controller(\App\Http\Controllers\Admin\ProductCommentController::class)->group(function () {
                    Route::get('/comments/{product}', 'index')->name('product.comments');
                    Route::get('/comments/create/{product_comment}', 'create')->name('product.comments.create');
                    Route::post('/comments/store', 'store')->name('product.comment.store');
                    Route::delete('/comment/delete/{product_comment}', 'destroy')->name('product.comment.delete');
                });
            });
            Route::controller(CommentController::class)->group(function () {
                Route::prefix('comments')->group(function () {
                    Route::get('/', 'index')->name('comment.index');
                    Route::get('/create', 'create')->name('comment.create');
                    Route::post('/store', 'store')->name('comment.store');
                    Route::get('/edit/{comment}', 'edit')->name('comment.edit');
                    Route::post('/update/{comment}', 'update')->name('comment.update');
                    Route::delete('/delete/{comment}', 'destroy')->name('comment.destroy');
                });
            });
            Route::controller(\App\Http\Controllers\Admin\PromoCodeController::class)->group(function () {
                Route::prefix('promocodes')->group(function () {
                    Route::get('/', 'index')->name('promoCode.index');
                    Route::get('/create', 'create')->name('promoCode.create');
                    Route::post('/store', 'store')->name('promoCode.store');
                    Route::get('/edit/{promoCode}', 'edit')->name('promoCode.edit');
                    Route::post('/update/{promoCode}', 'update')->name('promoCode.update');
                    Route::delete('/delete/{promoCode}', 'destroy')->name('promoCode.destroy');
                });
            });
        });
    });
});

require __DIR__.'/auth.php';
