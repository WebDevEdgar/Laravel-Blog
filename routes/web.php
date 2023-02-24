<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['namespace' => 'App\Http\Controllers\Main'], function () {
    Route::get('/', 'IndexController')->name('main.index');
});
Route::group(['namespace' => 'App\Http\Controllers\Category', 'prefix' => 'categories'], function () {
    Route::get('/', 'IndexController')->name('category.index');
    Route::group(['namespace' => 'Posts', 'prefix' => '{category}/posts'], function(){
        Route::get('/', 'IndexController')->name('category.post.index');
    });
});
Route::group(['namespace' => 'App\Http\Controllers\Posts', 'prefix' => 'posts'], function () {
    Route::get('/', 'IndexController')->name('post.index');
    Route::get('/{post}', 'ShowController')->name('post.show');
    Route::group(['namespace'=> 'Comment', 'prefix'=>'{post}/comment'], function(){
        Route::post('/', 'StoreController')->name('post.comment.store');
    });
    Route::group(['namespace' => 'Like', 'prefix' => '{post}/likes'], function(){
         Route::post('/', 'StoreController')->name('post.like.store');
    });
});
Route::middleware(['auth', 'verified'])->group(function(){
    Route::group(['namespace'=>'App\Http\Controllers\Personal', 'prefix'=>'personal'], function(){
        Route::group(['namespace' => 'Main'], function(){
            Route::get('/',  'IndexController')->name('personal.index');
        });
        Route::group(['namespace' => 'Liked', 'prefix' => 'liked'], function(){
            Route::get('/',  'IndexController')->name('personal.liked.index');
            Route::delete('/{post}',  'DeleteController')->name('personal.liked.delete');
        });
        Route::group(['namespace' => 'Comments', 'prefix' => 'comments'], function(){
            Route::get('/',  'IndexController')->name('personal.comment.index');
            Route::get('/{comment}/edit',  'EditController')->name('personal.comment.edit');
            Route::patch('/{comment}',  'UpdateController')->name('personal.comment.update');
            Route::delete('/{comment}',  'DeleteController')->name('personal.comment.delete');
        });
    });
});
Route::middleware(['auth', 'admin', 'verified'])->group(function(){
    Route::group(['namespace' => 'App\Http\Controllers\Admin', 'prefix' => 'admin'],function (){
        Route::group(['namespace'=>'Main'], function (){
            Route::get('/', 'IndexController')->name('admin.main');
        });
        Route::group(['namespace' => 'Category', 'prefix'=>'categories'], function(){
            Route::get('/', 'IndexController')->name('admin.category.index');
            Route::get('/create', 'CreateController')->name('admin.category.create');
            Route::post('/', 'StoreController')->name('admin.category.store');
            Route::get('/{category}', 'ShowController')->name('admin.category.show');
            Route::get('/{category}/edit', 'EditController')->name('admin.category.edit');
            Route::patch('/{category}/edit', 'UpdateController')->name('admin.category.edit');
            Route::delete('/{category}', 'DeleteController')->name('admin.category.delete');
        });

        Route::group(['namespace' => 'Tag', 'prefix'=>'tags'], function(){
            Route::get('/', 'IndexController')->name('admin.tag.index');
            Route::get('/create', 'CreateController')->name('admin.tag.create');
            Route::post('/', 'StoreController')->name('admin.tag.store');
            Route::get('/{tag}', 'ShowController')->name('admin.tag.show');
            Route::get('/{tag}/edit', 'EditController')->name('admin.tag.edit');
            Route::patch('/{tag}/edit', 'UpdateController')->name('admin.tag.edit');
            Route::delete('/{tag}', 'DeleteController')->name('admin.tag.delete');
        });

        Route::group(['namespace' => 'Post', 'prefix'=>'posts'], function(){
            Route::get('/', 'IndexController')->name('admin.post.index');
            Route::get('/create', 'CreateController')->name('admin.post.create');
            Route::post('/', 'StoreController')->name('admin.post.store');
            Route::get('/{post}', 'ShowController')->name('admin.post.show');
            Route::get('/{post}/edit', 'EditController')->name('admin.post.edit');
            Route::patch('/{post}/edit', 'UpdateController')->name('admin.post.edit');
            Route::delete('/{post}', 'DeleteController')->name('admin.post.delete');
        });

        Route::group(['namespace' => 'User', 'prefix'=>'users'], function(){
            Route::get('/', 'IndexController')->name('admin.user.index');
            Route::get('/create', 'CreateController')->name('admin.user.create');
            Route::post('/', 'StoreController')->name('admin.user.store');
            Route::get('/{user}', 'ShowController')->name('admin.user.show');
            Route::get('/{user}/edit', 'EditController')->name('admin.user.edit');
            Route::patch('/{user}/edit', 'UpdateController')->name('admin.user.edit');
            Route::delete('/{user}', 'DeleteController')->name('admin.user.delete');
        });
    });
});
Auth::routes(['verify'=>true]);