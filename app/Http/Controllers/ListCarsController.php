<?php

namespace App\Http\Controllers;
use App\Models\Cars;
use Illuminate\Http\Request;

class ListCarsController extends Controller
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

    public function showListCars () {
        return response() ->json(Cars::all()) ;
    }
    public function showCars ($id) {
        return response() ->json(Cars::find($id)) ;
    }

    public function update ($id, Request $request) {
        $car =Cars::find($id)->toArray() ;
        $user = Cars::where('user_id', $request->get('user_id'))->first();
        if ($request->toArray()['status'] == 'confirm' || $request->get('status') == 'check' && empty($car['user_id']) && !in_array( $request->get('user_id'), $car)) {
            $car = Cars::findOrFail($id);
            $car -> fill(['user_id' => $request->get('user_id')])->save();
            $user->fill(['user_id' => NULL]);
            $user->save();
            return response()-> json($car, 200);
        }
        else {
            return response('auto tied to user', 404);
        }
    }
    public function delete ($id) {
        Cars::findOrFail($id)->delete();
        return response('Delete success', 200);
    }
}
