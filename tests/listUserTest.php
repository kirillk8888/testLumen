
<?php

class listUserTest extends TestCase
{
    /**
     * /cars [GET]
     */
    public function testShouldReturnAllUsers(){
        $this->get("/api/listUser", []);
        $this->seeStatusCode(200);
        $this->seeJsonStructure([
            '*' => [
                    'name',
                    'age',
            ]
        ]);

    }

    /**
     * /cars/id [GET]
     */
    public function testShouldReturnCars(){
        $this->get("/api/listUser/2", []);
        $this->seeStatusCode(200);
        $this->seeJsonStructure([
                    'name',
                    'age',
        ]);

    }
    /**
     * /cars/id [PUT]
     */
    public function testShouldUpdateUser(){
        $parameters = [
            'car_id' => '2'
        ];
        $this->put("/api/listUser/1", $parameters, []);
        $this->seeStatusCode(200);
    }
}
