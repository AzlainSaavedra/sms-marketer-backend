<?php

use App\Models\carros;
use App\Repositories\carrosRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class carrosRepositoryTest extends TestCase
{
    use MakecarrosTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var carrosRepository
     */
    protected $carrosRepo;

    public function setUp()
    {
        parent::setUp();
        $this->carrosRepo = App::make(carrosRepository::class);
    }

    /**
     * @test create
     */
    public function testCreatecarros()
    {
        $carros = $this->fakecarrosData();
        $createdcarros = $this->carrosRepo->create($carros);
        $createdcarros = $createdcarros->toArray();
        $this->assertArrayHasKey('id', $createdcarros);
        $this->assertNotNull($createdcarros['id'], 'Created carros must have id specified');
        $this->assertNotNull(carros::find($createdcarros['id']), 'carros with given id must be in DB');
        $this->assertModelData($carros, $createdcarros);
    }

    /**
     * @test read
     */
    public function testReadcarros()
    {
        $carros = $this->makecarros();
        $dbcarros = $this->carrosRepo->find($carros->id);
        $dbcarros = $dbcarros->toArray();
        $this->assertModelData($carros->toArray(), $dbcarros);
    }

    /**
     * @test update
     */
    public function testUpdatecarros()
    {
        $carros = $this->makecarros();
        $fakecarros = $this->fakecarrosData();
        $updatedcarros = $this->carrosRepo->update($fakecarros, $carros->id);
        $this->assertModelData($fakecarros, $updatedcarros->toArray());
        $dbcarros = $this->carrosRepo->find($carros->id);
        $this->assertModelData($fakecarros, $dbcarros->toArray());
    }

    /**
     * @test delete
     */
    public function testDeletecarros()
    {
        $carros = $this->makecarros();
        $resp = $this->carrosRepo->delete($carros->id);
        $this->assertTrue($resp);
        $this->assertNull(carros::find($carros->id), 'carros should not exist in DB');
    }
}
