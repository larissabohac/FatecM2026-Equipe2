<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Controllers Públicos
|--------------------------------------------------------------------------
*/

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\PublicOrderController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ChatController;

/*
|--------------------------------------------------------------------------
| Controllers Admin
|--------------------------------------------------------------------------
*/


use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\StockController;
use App\Http\Controllers\Admin\SaleController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\PagamentoController;
use App\Http\Controllers\Admin\AdminChatController;

/*
|--------------------------------------------------------------------------
| ROTAS PÚBLICAS
|--------------------------------------------------------------------------
*/

// Página inicial
Route::get('/', [HomeController::class, 'index'])->name('home');

// CHAT
Route::post('/chat', [ChatController::class, 'send']);
Route::get('/chat/history', [ChatController::class,'history']);
Route::get('/admin/chat', [AdminChatController::class,'index']);

// Produtos
Route::get('/produtos', [ProductController::class, 'index'])->name('products.index');
Route::get('/produto/{slug}', [ProductController::class, 'show'])->name('products.show');

// Categoria
Route::get('/categoria/{slug}', [ProductController::class, 'category'])->name('category.products');

// Contato
Route::get('/contato', [ContactController::class, 'show'])->name('contact.show');
Route::post('/contato/enviar', [ContactController::class, 'send'])->name('contact.send');

// Carrinho (ATUALIZADO COM UPDATE)
Route::get('/carrinho', [CartController::class, 'index'])->name('cart.index');
Route::post('/carrinho/adicionar/{id}', [CartController::class, 'add'])->name('cart.add');
Route::delete('/carrinho/remover/{id}', [CartController::class, 'remove'])->name('cart.remove');
Route::patch('/carrinho/atualizar/{id}', [CartController::class, 'update'])->name('cart.update');
 /*
|--------------------------------------------------------------------------
| FLUXO DE PAGAMENTO EM PORTUGUÊS
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {
    // Tela de escolha de pagamento e resumo
    Route::get('/pagamento', [PagamentoController::class, 'index'])->name('pagamento.index');
    
    // Rota que faz a baixa no estoque e fecha o pedido
    Route::post('/pagamento/processar', [PagamentoController::class, 'processar'])->name('pagamento.processar');
    
    // Tela de agradecimento
    Route::get('/pagamento/concluido', [PagamentoController::class, 'sucesso'])->name('pagamento.sucesso');
});
/*
|--------------------------------------------------------------------------
| CHECKOUT
|--------------------------------------------------------------------------
*/

Route::post('/checkout', [CartController::class, 'checkout'])
    ->name('cart.checkout')
    ->middleware('auth');

Route::get('/pedido/sucesso/{order}', [CartController::class, 'success'])
    ->name('order.success')
    ->middleware('auth');

/*
|--------------------------------------------------------------------------
| PERFIL
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
    Route::get('/perfil', [ProfileController::class, 'index'])->name('profile');
    Route::post('/perfil', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/minha-conta', [ClientController::class, 'index'])->name('client.dashboard');
    Route::get('/meus-pedidos', [ClientController::class, 'orders'])->name('client.orders');
    Route::get('/meus-pedidos/{order}', [ClientController::class, 'show'])->name('client.orders.show');
});

/*
|--------------------------------------------------------------------------
| DASHBOARD
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', function () {
    if (auth()->user()->role === 'admin') {
        return redirect()->route('admin.dashboard');
    }
    return view('dashboard');
})->middleware('auth')->name('dashboard');

require __DIR__ . '/auth.php';

/* 
|--------------------------------------------------------------------------
| ADMIN
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // DASHBOARD
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // PRODUTOS
        Route::resource('/produtos', AdminProductController::class)
            ->parameters(['produtos' => 'product'])
            ->names('products');

        // PEDIDOS
        Route::get('/pedidos', [AdminOrderController::class, 'index'])->name('orders.index');
        Route::get('/pedidos/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
        Route::put('/pedidos/{order}/status', [AdminOrderController::class, 'updateStatus'])
            ->name('orders.updateStatus');
        Route::put('/pedidos/{order}/cancel', [AdminOrderController::class, 'cancel'])
            ->name('orders.cancel');

        // CLIENTES
        Route::get('/clientes', [CustomerController::class, 'index'])->name('customers.index');
        Route::get('/clientes/{user}', [CustomerController::class, 'show'])->name('customers.show');

        // ESTOQUE
        Route::get('/stock', [StockController::class, 'index'])->name('stock.index');
        Route::post('/stock/{id}/add', [StockController::class, 'add'])->name('stock.add');
        Route::post('/stock/{id}/remove', [StockController::class, 'remove'])->name('stock.remove');

        // VENDAS
        Route::get('/sales/create', [SaleController::class, 'create'])->name('sales.create');
        Route::post('/sales', [SaleController::class, 'store'])->name('sales.store');
        Route::get('/sales/{id}', [SaleController::class, 'show'])->name('sales.show');
        Route::get('/sales/report', [SaleController::class, 'report'])->name('sales.report');
        Route::get('/sales/pdf', [SaleController::class, 'exportPdf'])->name('sales.pdf');

        // CUPONS
        Route::get('/sales/{id}/receipt', [SaleController::class, 'receipt'])->name('sales.receipt');
        Route::get('/sales/{id}/delivery', [SaleController::class, 'delivery'])->name('sales.delivery');

        // BANNERS
        Route::get('/banners', [BannerController::class, 'index'])->name('banners.index');
        Route::get('/banners/create', [BannerController::class, 'create'])->name('banners.create');
        Route::post('/banners', [BannerController::class, 'store'])->name('banners.store');
        Route::delete('/banners/{banner}', [BannerController::class, 'destroy'])->name('banners.destroy');

        // CATEGORIAS
        Route::resource('categories', CategoryController::class)->names('categories');

        //CHATBOT
        Route::get('/chat',[AdminChatController::class, 'index'])->name('chat.index');
        Route::get('/chat', [AdminChatController::class,'index']);
        Route::get('/chat/messages/{id}', [AdminChatController::class,'messages']);
        Route::post('/chat/send', [AdminChatController::class,'send']);
        Route::get('/chat/unread', [AdminChatController::class,'unread']);
        Route::get('/admin/chat/unread', [AdminChatController::class,'unread']);
        Route::post('/chat', [ChatController::class,'send']);
        Route::get('/chat/history', [ChatController::class,'history']);

});