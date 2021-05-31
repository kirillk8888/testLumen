
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
     * /cars/id [PUT]
     */
    public function testShouldUpdateUser(){
        $parameters = [
            'car_id' => '2',
            "dateStart" => "2027-07-10 01:00:00",
            "dateEnd" => "2027-10-14 02:00:00"
        ];
        $this->put("/api/listUser/1", $parameters, []);
        $this->seeStatusCode(200);
    }
}
