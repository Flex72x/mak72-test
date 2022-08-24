<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Tarif;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function getTarifsServices(Request $request, $user_id, $service_id) {
        $user = User::find($user_id);
        $service = Service::find($service_id);

        if(!$service || !$user || $user->ID != $service->user_id) {
            return response()->json([
                'result'=>'error'
            ], 404);
        }

        $tarifs = $service->tarifs;
        $firstTarif = $tarifs->first();


        $data = [];
        foreach ($tarifs as $tarif) {
            $data[] = [
                'ID' => $tarif->ID,
                'title' => $tarif->title,
                'price' => $tarif->price,
                'pay_period' => $tarif->pay_period,
                'new_payday'=> Carbon::today()->addMonths($tarif->pay_period)->getTimestamp().'+'.Carbon::today()->utcOffset(),
                'speed'=>$tarif->speed,
            ];
        }

        return response()->json([
            'result'=>'ok',
            'tarifs'=>[
                'title'=>$firstTarif->title,
                'link'=>$firstTarif->link,
                'speed'=>$firstTarif->speed,
                'tarifs'=>[
                    $data
                ]
            ]
        ]);
    }

    public function putTarifService(Request $request, $user_id, $service_id) {
        $service = Service::where('ID', $service_id)->first();
        $tarif = Tarif::find($request->tarif_id);
        $user = User::find($user_id);

        if(!$service || !$tarif || !$user) {
            return response()->json([
               'result'=>'error',
            ], 404);
        }

        Tarif::create([
           'title'=>$tarif->title,
           'price'=>$tarif->price,
            'link'=>$tarif->link,
            'speed'=>$tarif->speed,
            'pay_period'=>$tarif->pay_period,
            'tarif_group_id'=>$service->tarif_id,
        ]);

        return response()->json([
           'result'=>'ok',
        ]);
    }
}
