<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;


use App\Http\Controllers\PageController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\LoginController;

use App\Http\Controllers\TrashController;
use App\Http\Controllers\PathController;
use App\Models\Post;
use App\Models\User;
use App\Models\Book;



use Illuminate\Http\Request;
use App\Models\Author;


Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');
Route::post('/contact', [PageController::class, 'submit'])->name('contact.submit');

Route::resource('shop', BookController::class);

Route::get('/login', [AdminController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::get('/register', [AdminController::class, 'register'])->name('register');
Route::post('/register', [AdminController::class, 'store'])->name('register.store');

Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/');
})->name('logout');



// Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    
//     Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
//     Route::get('/role', [AdminController::class, 'roles'])->name('roles');
//     Route::post('/dashboard/{userId}', [AdminController::class, 'assignRole'])->name('admin.assignRole');
//     Route::resources(['books' => AdminController::class,]);

// });



Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard'); // Անունը՝ admin.dashboard
    Route::get('/role', [AdminController::class, 'roles'])->name('roles');           // Անունը՝ admin.roles
    
    Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::resource('books', AdminController::class);
    // Այս խմբի մեջ գտնվող բոլոր գործողությունները հասանելի կլինեն միայն ադմինին
});

    Route::middleware(['admin'])->group(function () {
        Route::get('/role', [AdminController::class, 'roles'])->name('roles');
        Route::post('/assign-role/{userId}', [AdminController::class, 'assignRole'])->name('assignRole');
    });
    Route::resources(['books' => AdminController::class]);
});

Route::get('/trash', [TrashController::class, 'index'])->name('trash');;
Route::get('/trash/restore/{id}', [TrashController::class, 'restore'])->name('trash.restore');
Route::get('/trash/restoreall', [TrashController::class, 'restoreAll'])->name('trash.restoreAll');

Route::get('/author/{author}', function (Author $author) {

    return view('static.author_books', compact('author'));
});


Route::get('/test-genres', function () {
    $selectedGenres = [1, 3, 5];

    $books = Book::whereHas('genres', function ($query) use ($selectedGenres) {
        $query->whereIn('genres.id', $selectedGenres);
    })->get();

    return $books;
});

Route::get('/expanded_search', [BookController::class, 'expandedSearch'])->name('books.search');