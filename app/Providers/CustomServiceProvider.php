<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Interfaces\Customer as CustomerInterface;
use App\Interfaces\Product as ProductInterface;
use App\Interfaces\ImportLog as ImportLogInterface;
use App\Interfaces\Services\Order as OrderServiceInterface;
use App\Models\Customer;
use App\Models\ImportLog;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;
use App\Repositories\Customer as CustomerRepository;
use App\Repositories\Product as ProductRepository;
use App\Repositories\Order as OrderRepository;
use App\Repositories\ImportLog as ImportLogRepository;
use App\Repositories\OrderProduct as OrderProductRepository;
use App\Services\Order as OrderService;

class CustomServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        app()->bind(CustomerInterface::class, function() {
            return new CustomerRepository(new Customer());
        });
        app()->bind(ImportLogInterface::class, function() {
            return new ImportLogRepository(new ImportLog());
        });
        app()->bind(ProductInterface::class, function() {
            return new ProductRepository(new Product());
        });
        app()->bind(ServicesOrder::class, function() {
            return new OrderRepository(new Order());
        });
        app()->bind(OrderServiceInterface::class, function() {
            return new OrderService(new OrderRepository(new Order()), new OrderProductRepository(new OrderProduct()));
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
