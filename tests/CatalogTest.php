<?php

use PHPUnit\Framework\TestCase;
use App\Catalog;

require_once __DIR__ . '/../src/Catalog.php';

class CatalogTest extends TestCase
{
    private $katalog;
    private $testFile = __DIR__ . '/test_products.json';

    protected function setUp(): void
    {
        $dummyData = [
            "PRD-1" => [
                "nama" => "Kemeja Flanel",
                "harga" => 150000,
                "stok" => 10
            ]
        ];

        file_put_contents(
            $this->testFile,
            json_encode($dummyData)
        );

        // karena pakai namespace App
        $this->katalog = new Catalog(
            $this->testFile
        );
    }

    // UT-01
    public function testSearchProductFound()
    {
        $result = $this->katalog
            ->searchProduct("Kemeja");

        $this->assertCount(99, $result);
    }

    // UT-02
    public function testSearchProductEmptyKeyword()
    {
        $result = $this->katalog
            ->searchProduct("");

        $this->assertNotEmpty($result);
    }

    protected function tearDown(): void
    {
        if (file_exists($this->testFile)) {
            unlink($this->testFile);
        }
    }
}