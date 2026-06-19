<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\PlanController;
use App\Http\Controllers\User\UserDashboardController;
use App\Http\Controllers\User\MembershipController;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\User\PaymentController;
use App\Http\Controllers\FrontController;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Support\Facades\Route;

// Frontend
Route::get('/', [FrontController::class, 'index'])->name('home');
Route::get('/nosotros', [FrontController::class, 'about'])->name('about');
Route::get('/planes', [FrontController::class, 'plans'])->name('plans');
Route::get('/planes/{plan}', [FrontController::class, 'planShow'])->name('plans.show');
Route::get('/contacto', [FrontController::class, 'contact'])->name('contact');

// Auth
Route::name('auth.')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.store');

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/registro', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/registro', [AuthController::class, 'register'])->name('register.store');
});

Route::prefix('user')->name('user.')->middleware(['protected', 'checkRole:user'])->group(function () {
    Route::get('/', [UserDashboardController::class, 'index'])->name('dashboard');
    Route::get('/membresia', [MembershipController::class, 'index'])->name('membership.index');
    Route::get('/membresia/activar', [MembershipController::class, 'create'])->name('membership.create');
    Route::post('/membresia/activar', [MembershipController::class, 'store'])->name('membership.store');
    Route::get('/membresia/editar', [MembershipController::class, 'edit'])->name('membership.edit');
    Route::put('/membresia/editar', [MembershipController::class, 'update'])->name('membership.update');
    Route::post('/membresia/cancelar', [MembershipController::class, 'cancel'])->name('membership.cancel');
    //Route::delete('/membresia/cancelar', [MembershipController::class, 'destroy'])->name('membership.destroy');


    Route::get('/pagos', [PaymentController::class, 'index'])->name('payment.index');
    Route::post('/pagos/pagar', [PaymentController::class, 'checkout'])->name('payment.checkout');
    // url que devuelve mercadopago en el success
    // modificar los datos del query con los del pago para probar
    //?collection_id=137547050148&collection_status=approved&payment_id=137547050148&status=approved&external_reference=ORDEN_1&payment_type=credit_card&merchant_order_id=36350926316&preference_id=1342150711-9a93a505-f18d-48db-af01-a304322f26a1&site_id=MLA&processing_mode=aggregator&merchant_account_id=null
    Route::get('/pagos/pago-aprobado', [PaymentController::class, 'success'])->name('payment.success');
    Route::get('/pagos/pago-rechazado', [PaymentController::class, 'failure'])->name('payment.failure');
    Route::get('/pagos/pago-pendiente', [PaymentController::class, 'pending'])->name('payment.failure');

    Route::get('/perfil/editar', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/perfil/editar', [ProfileController::class, 'update'])->name('profile.update');

    //Route::put('/membresia/editar', [UserMembershipController::class, 'membershipUpdate'])->name('membership.update');

});

// Admin
Route::prefix('admin')->name('admin.')->middleware(['protected', 'checkRole:admin'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/usuarios', [UserController::class, 'index'])->name('users.index');
    Route::post('/usuarios', [UserController::class, 'store'])->name('users.store');
    Route::get('/usuarios/{user}', [UserController::class, 'show'])->name('users.show');
    Route::get('/usuarios/{user}/editar', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/usuarios/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/usuarios/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    Route::delete('/usuarios/{user}/membresia/{plan}', [UserController::class, 'removeMembership'])->name('users.removeMembership');


    //categorias
    Route::get('/categorias', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('/categorias/nueva', [CategoryController::class, 'create'])->name('categories.create');
    Route::post('/categorias', [CategoryController::class, 'store'])->name('categories.store');
    Route::get('/categorias/{category}', [CategoryController::class, 'show'])->name('categories.show');
    Route::get('/categorias/{category}/editar', [CategoryController::class, 'edit'])->name('categories.edit');
    Route::put('/categorias/{category}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categorias/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');

    Route::get('/planes', [PlanController::class, 'index'])->name('plans.index');
    Route::get('/planes/nuevo', [PlanController::class, 'create'])->name('plans.create');
    Route::post('/planes', [PlanController::class, 'store'])->name('plans.store');
    Route::get('/planes/{plan}', [PlanController::class, 'show'])->name('plans.show');
    Route::get('/planes/{plan}/editar', [PlanController::class, 'edit'])->name('plans.edit');
    Route::put('/planes/{plan}', [PlanController::class, 'update'])->name('plans.update');
    Route::delete('/planes/{plan}', [PlanController::class, 'destroy'])->name('plans.destroy');

    // ordenes
    Route::get('/ordenes', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/ordenes/{order}', [OrderController::class, 'show'])->name('orders.show');

});
