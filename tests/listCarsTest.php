
<?php

class listCarsTest extends TestCase
{
    /**
     * /cars [GET]
     */
    public function testShouldReturnAllCars(){
        $this->get("/api/listCars", []);
        $this->seeStatusCode(200);
        $this->seeJsonStructure([
            '*' => [
                    'brand',
                    'model',
                    'VIN',
                    'color',
                    'transmission',
                    'created_at',
                    'updated_at',
                    'user_id'
            ]
        ]);

    }

    /**
     * /cars/id [GET]
     */
    public function testShouldReturnCars(){
        $this->get("/api/listCars/2", []);
        $this->seeStatusCode(200);
        $this->seeJsonStructure([
                    'id',
                    'brand',
                    'model',
                    'VIN',
                    'color',
                    'transmission',
                    'created_at',
                    'updated_at',
                    'user_id'
        ]);

    }
    /**
     * /cars/id [PUT]
     */
    public function testShouldUpdateCars(){
        $parameters = [
            'status' => 'check',
            'user_id' => '2'
        ];

        $this->put("/api/listCars/1", $parameters, []);
        $this->seeStatusCode(200);
    }
}
