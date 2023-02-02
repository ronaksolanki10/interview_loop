<?php

namespace App\Console\Commands\Import;

use App\Interfaces\Product as ProductInterface;
use App\Interfaces\ImportLog as ImportLogrInterface;
use Illuminate\Console\Command;

class Products extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:products';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import products from the URL (CSV) into database';

    private ProductInterface $product;
    private ImportLogrInterface $importLog;
    const USERNAME = 'loop';
    const PASSWORD = 'backend_dev';

    public function __construct(ProductInterface $customer, ImportLogrInterface $importLog)
    {
        $this->product = $customer;
        $this->importLog = $importLog;
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $csv = fopen('https://'.self::USERNAME.':'.self::PASSWORD.'@backend-developer.view.agentur-loop.com/products.csv', 'r');
        $i = 0;
        $successImport = 0;
        $failedImport = 0;
        while (($row = fgetcsv($csv, 0, ',')) !== false) {
            if ($i == 0) {
                $i++;
                continue;
            }
            $this->product->create([
                'name' => $row[1],
                'price' => $row[2],
            ]);
            $successImport++;
            $i++;
        }
        $this->importLog->create([
            'type' => 'products',
            'success_import_count' => $successImport,
            'fail_import_count' => $failedImport
        ]);
        fclose($csv);
    }
}
