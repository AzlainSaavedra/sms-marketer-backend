<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class carrosApiTest extends TestCase
{
    use MakecarrosTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreatecarros()
    {
        $carros = $this->fakecarrosData();
        $this->json('POST', '/api/v1/carros', $carros);

        $this->assertApiResponse($carros);
    }

    /**
     * @test
     */
    public function testReadcarros()
    {
        $carros = $this->makecarros();
        $this->json('GET', '/api/v1/carros/'.$carros->id);

        $this->assertApiResponse($carros->toArray());
    }

    /**
     * @test
     */
    public function testUpdatecarros()
    {
        $carros = $this->makecarros();
        $editedcarros = $this->fakecarrosData();

        $this->json('PUT', '/api/v1/carros/'.$carros->id, $editedcarros);

        $this->assertApiResponse($editedcarros);
    }

    /**
     * @test
     */
    public function testDeletecarros()
    {
        $carros = $this->makecarros();
        $this->json('DELETE', '/api/v1/carros/'.$carros->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/carros/'.$carros->id);

        $this->assertResponseStatus(404);
    }
}
