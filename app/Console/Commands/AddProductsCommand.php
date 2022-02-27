<?php

namespace App\Console\Commands;

use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Console\Command;
use Illuminate\Http\File;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Console\Input\InputOption;

class AddProductsCommand extends Command
{

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * The console Command Signature
     * 
     * @var string
     */
    protected $signature = 'add:product {filepath}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Add New products To The Database";

    /**
     * Handle The Command Execution
     */
    public function handle()
    {
        $filePath = $this->argument('filepath');

        try {
            $file = fopen($filePath, 'r');
            $this->addProducts($file, config('add-products.HEADERS', []));
        } catch (\Exception $e) {
            dd($e->getMessage());
            return $this->error('Unable to process your request! Please Try Again');
        }
    }

    /**
     * Function to Add Products to Database
     * 
     * @param $file
     * @param array $csvHeaders
     * 
     * @return void
     */
    private function addProducts($file, $csvHeaders)
    {
        $headers = fgetcsv($file);

        $csvHeaderPositon = [];

        foreach ($csvHeaders as $row) {
            $index = array_search($row, $headers);
            $csvHeaderPositon[$row] = $index;
        }

        while (!feof($file)) {
            $row = fgetcsv($file);

            if ($row) {
                $data = [];
                foreach ($csvHeaderPositon as $key => $value) {
                    $data[$key] = $row[$value];
                }

                DB::transaction(function () use ($data) {
                    $product = Product::firstOrNew(['name' => $data['Name']]);
                    $product->price = $data['Price'];
                    $product->description = $data['Description'];

                    $product->save();


                    $productImage = ProductImage::firstOrNew(['product_id' => $product->id, 'image_name' => $data['Image Name']]);
                    $productImage->product_id = $product->id;

                    $productImage->save();
                });
            }
        }
        fclose($file);
        $this->info("Products Added Succesfully");
    }
}
