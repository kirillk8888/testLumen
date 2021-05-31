<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Cars;
use App\Models\UsedCars;
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
        $car_id = $request->get('car_id');
        $dateStart = $request->get('dateStart');

        //если не задали дату начала, то ставим текущую
        if (!$dateStart || $dateStart == '') {
            $dateStart = date("Y-m-d H:i:s");
        }
        $dateEnd = $request->get('dateEnd');
        $car_id = $request->get('car_id');
        $cars = Cars::find($car_id);
        if ($cars) {
            $usedCars = new UsedCars;
            //проверяем даты использования по таблице
            $countUsedCar =  UsedCars::where('car_id', $car_id) -> where(function ($query) use ($dateStart, $dateEnd) {
                $query->where(function ($q) use ($dateStart, $dateEnd) {
                    $q->where('dataStart', '>=', $dateStart)
                        ->where('dataStart', '<', $dateEnd);

                })->orWhere(function ($q) use ($dateStart, $dateEnd) {
                    $q->where('dataStart', '<=', $dateStart)
                        ->where('dataEnd', '>', $dateEnd);

                })->orWhere(function ($q) use ($dateStart, $dateEnd) {
                    $q->where('dataEnd', '>', $dateStart)
                        ->where('dataEnd', '<=', $dateEnd);

                })->orWhere(function ($q) use ($dateStart, $dateEnd) {
                    $q->where('dataStart', '>=', $dateStart)
                        ->where('dataEnd', '<=', $dateEnd);
                });

            })->count();
            if ($countUsedCar != 0) {
                return response()-> json(['Error'=> 'Error date'], 200);
            }
            //если не найдено полей в диапазоне дат:
            $carsUser = Cars::where('user_id', $id)->first();
            if ($carsUser) {
                $carsUser->fill(['user_id' => NULL]);
                $carsUser->save();
            }
            //заполняем таблицу использования авто
            $usedCars->fill(array(
                'dataStart'  => $dateStart,
                'dataEnd' => $dateEnd,
                'user_id'   => $id,
                'car_id'   => $car_id
            ))->save();
            //обновляем поле user_id в таблице авто
            $cars->fill(['user_id' => $id])->save();
            return response()-> json($cars, 200);
        }
        else {
            return response()-> json(['Error'=> 'Id not found'], 404);
        }

    }
}
