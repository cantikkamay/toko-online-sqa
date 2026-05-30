<?php

use PHPUnit\Framework\TestCase;
use App\Checkout;

require_once __DIR__ . '/../src/Checkout.php';

class CheckoutTest extends TestCase
{
    private $seedFile =
        __DIR__ . '/../data/products_seed.json';

    private $testFile =
        __DIR__ . '/../data/products_test.json';

    private $orderFile =
        __DIR__ . '/../data/orders_test.json';

    private $checkout;

    // CT Stage: reset data sebelum test
    protected function setUp(): void
    {
        copy(
            $this->seedFile,
            $this->testFile
        );

        file_put_contents(
            $this->orderFile,
            json_encode([])
        );

        $this->checkout = new Checkout(
            $this->testFile,
            $this->orderFile
        );
    }

    // Integration Test
    public function testCheckoutReducesStock()
    {
        $keranjang = [
            'PRD-002' => 1
        ];

        $this->checkout->prosesCheckout(
            'test@mail.com',
            'Jl. Sudirman',
            $keranjang
        );

        $products = json_decode(
            file_get_contents(
                $this->testFile
            ),
            true
        );

        $this->assertEquals(
            4,
            $products['PRD-002']['stok']
        );
    }

    // hapus file sampah sesudah test
    protected function tearDown(): void
    {
        if (file_exists($this->testFile)) {
            unlink($this->testFile);
        }

        if (file_exists($this->orderFile)) {
            unlink($this->orderFile);
        }
    }
}