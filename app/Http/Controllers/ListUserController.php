<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Cars;
use Illuminate\Support\Arr;

use Illuminate\Http\Request;

class ListUserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    //
    public function showListUser () {
        $car = Cars::all()->toArray();
        $users = User::with('cars','cars.user')->get();
        return response() ->json($users) ;
    }
    public function update ($id, Request $request) {

        $cars = Cars::where('user_id', $id)->first();

        if ($cars) {
            $cars->fill(['user_id' => NULL]);
            $cars->save();
        }

        $car_id = $request->get('car_id');
        $cars = Cars::find($car_id);
        if ($cars) {
            $cars->fill(['user_id' => $id]);
            $cars->save();
        }
        else {
            return response()-> json(['Error'=> 'Id not found'], 404);
        }
        return response()-> json($cars, 200);
    }

}
