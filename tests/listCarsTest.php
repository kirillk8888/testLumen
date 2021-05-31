
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
     * /cars/id [PUT]
     */
    public function testShouldUpdateCars(){
        $parameters = [
            'status' => 'check',
            'user_id' => '2',
            "dateStart" => "2027-07-10 01:00:00",
            "dateEnd" => "2027-10-14 02:00:00"
        ];

        $this->put("/api/listCars/1", $parameters, []);
        $this->seeStatusCode(200);
    }
}
