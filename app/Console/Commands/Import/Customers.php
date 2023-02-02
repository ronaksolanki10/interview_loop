<?php

namespace App\Console\Commands\Import;

use App\Interfaces\Customer as CustomerInterface;
use App\Interfaces\ImportLog as ImportLogrInterface;
use Illuminate\Console\Command;

class Customers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:customers';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import customers from the URL (CSV) into database';
    
    private CustomerInterface $customer;
    private ImportLogrInterface $importLog;
    const USERNAME = 'loop';
    const PASSWORD = 'backend_dev';

    public function __construct(CustomerInterface $customer, ImportLogrInterface $importLog)
    {
        $this->customer = $customer;
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
        $csv = fopen('https://'.self::USERNAME.':'.self::PASSWORD.'@backend-developer.view.agentur-loop.com/customers.csv', 'r');
        $i = 0;
        $successImport = 0;
        $failedImport = 0;
        while (($row = fgetcsv($csv, 0, ',')) !== false) {
            if ($i == 0) {
                $i++;
                continue;
            }
            $isExists = $this->customer->findByEmail($row[2]);
            if (!empty($isExists)) {
                $failedImport++;
                $i++;
                continue;
            }
            $getDate = explode(',', $row[4]);
            $this->customer->create([
                'job_title' => $row[1],
                'email' => $row[2],
                'name' => $row[3],
                'registered_since' => date('Y-m-d', strtotime($getDate[1].' '.$getDate[2])),
                'phone' => $row[5],
            ]);
            $successImport++;
            $i++;
        }
        $this->importLog->create([
            'type' => 'customers',
            'success_import_count' => $successImport,
            'fail_import_count' => $failedImport
        ]);
        fclose($csv);
    }
}
