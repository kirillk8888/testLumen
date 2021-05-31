<?php

namespace App\Http\Controllers;
use App\Models\Cars;
use App\Models\UsedCars;
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
    public function update ($id, Request $request) {
        //проверяем даты использования по таблице
        $dateStart = $request->get('dateStart');

        //если не задали дату начала, то ставим текущую
        if (!$dateStart || $dateStart == '') {
            $dateStart = date("Y-m-d H:i:s");
        }
        $dateEnd = $request->get('dateEnd');
        $countUsedCar =  UsedCars::where('car_id', $id) -> where(function ($query) use ($dateStart, $dateEnd) {
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
        $car = Cars::findOrFail($id);
        if ($request->toArray()['status'] == 'confirm' || $request->get('status') == 'check' && empty($car['user_id']) && $car['user_id'] == NULL) {
            //проверяем, привязан ли уже к авто юзер
            $user = Cars::where('user_id', $request->get('user_id'))->first();
            //если привязан, то вначале убираем привязку
            if ($user) {
                $user->fill(['user_id' => NULL])->save();
            }
            //а затем привязываем авто к юзеру
            $usedCars = new UsedCars;
            $usedCars->fill(array(
                'dataStart'  => $dateStart,
                'dataEnd' => $dateEnd,
                'user_id'   => $request->get('user_id'),
                'car_id'   => $id
            ))->save();
            $car -> fill(['user_id' => $request->get('user_id')])->save();
            return response()-> json($car, 200);
        }
        else {
            return response(['Error'=> 'Auto tied to user'], 404); //если авто уже привязано к пользователю
        }

    }
}
