<?php

use App\Http\Controllers\FashionController;
use App\Http\Controllers\ManufacturingController;
use App\Http\Controllers\SupplyChainController;
use Illuminate\Support\Facades\Route;

Route::get('/', [FashionController::class, 'index'])->name('home');
Route::get('/fashion/create', [FashionController::class, 'create'])->name('fashion.create');
Route::post('/fashion', [FashionController::class, 'store'])->name('fashion.store');
Route::get('/fashion/{fashion}', [FashionController::class, 'show'])->name('fashion.show');
Route::get('/fashion/edit/{fashion}', [FashionController::class, 'edit'])->name('fashion.edit');
Route::put('/fashion/{fashion}', [FashionController::class, 'update'])->name('fashion.update');
Route::get('/fashion/delete/{fashion}', [FashionController::class, 'destroy'])->name('fashion.destroy');

Route::get('/supply-chain/create', [SupplyChainController::class, 'create'])->name('supply-chain.create');
Route::post('/supply-chain', [SupplyChainController::class, 'store'])->name('supply-chain.store');
Route::get('/supply-chain/{supplyChain}', [SupplyChainController::class, 'show'])->name('supply-chain.show');
Route::get('/supply-chain/edit/{supplyChain}', [SupplyChainController::class, 'edit'])->name('supply-chain.edit');
Route::put('/supply-chain/{supplyChain}', [SupplyChainController::class, 'update'])->name('supply-chain.update');
Route::get('/supply-chain/delete/{supplyChain}', [SupplyChainController::class, 'destroy'])->name('supply-chain.destroy');

Route::get('/manufacturing/create', [ManufacturingController::class, 'create'])->name('manufacturing.create');
Route::post('/manufacturing', [ManufacturingController::class, 'store'])->name('manufacturing.store');
Route::get('/manufacturing/{manufacturing}', [ManufacturingController::class, 'show'])->name('manufacturing.show');
Route::get('/manufacturing/edit/{manufacturing}', [ManufacturingController::class, 'edit'])->name('manufacturing.edit');
Route::put('/manufacturing/{manufacturing}', [ManufacturingController::class, 'update'])->name('manufacturing.update');
Route::get('/manufacturing/delete/{manufacturing}', [ManufacturingController::class, 'destroy'])->name('manufacturing.destroy');
