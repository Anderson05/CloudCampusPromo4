<?php

namespace App\Tests;

use PHPUnit\Framework\TestCase;

class ProductTest extends TestCase
{
    public function testStatutPositif(): void
    {
        $product = new Product("ProduitTest", 4);
        $this->assertTrue($product->getStatus() > 0, "Statut produit positif");
    }
}
