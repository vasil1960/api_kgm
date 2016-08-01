<?php

namespace App\Http\Controllers;


use App\Kgm;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;



class SearchController extends Controller
{

    public function all(Request $request)
    {
//        $kgms = Kgm::all()->take(5);
//        dd($request->seria);

        $kgms = Kgm::join('u_names','u_names.ID','=','u_kgm.NamesID')
                   ->join('u_address','u_address.NamesID','=','u_names.ID')
                   ->join('regions.PopulatedPlaces','regions.PopulatedPlaces.ID','=','u_address.Grad')
                   ->where([
                       ['SeriaKGM', $request->seria],
                       ['strNumberKGM','LIKE', '%'. $request->number . '%']
                   ])
                   ->take(100)->get();

//     dd($kgms);

        if( ! $kgms)
        {
            return Response::json([
                'error'=> [
                    'message'=>'Няма такава марка'
                ]
            ], 404);
        }

        return Response::json([
            'records'=> $this->transformCollection($kgms)
        ], 200);

    }

    public function byId(Request $request)
    {

//        $kgms = Kgm::find($request->kgm_id);

        $kgms = Kgm::find($request->kgm_id)
                   ->join('u_names','u_names.ID','=','u_kgm.NamesID')
                   ->join('u_address','u_address.NamesID','=','u_names.ID')
                   ->join('regions.PopulatedPlaces','regions.PopulatedPlaces.ID','=','u_address.Grad')
//                   ->where('ID', $request->kgm_id)
//                   ->where('strNumberKGM', $number)
                   ->get();

//        dd($kgms);

        if( ! $kgms)
        {
            return Response::json([
                'error'=> [
                    'message'=>'Няма такава марка'
                ]
            ], 404);
        }

        return Response::json([
            'records'=> $this->transform($kgms)
        ], 200);
    }

//    public function byname($ime, $familia)
//    {
//        $kgms = Kgm::join('u_names','u_names.ID','=','u_kgm.NamesID')
//            ->join('u_address','u_address.NamesID','=','u_names.ID')
//            ->join('regions.PopulatedPlaces','regions.PopulatedPlaces.ID','=','u_address.Grad')
//            ->where([
//                ['Ime', 'LIKE', $ime .'%'],
//                ['Familia', 'LIKE' , $familia .'%']
//            ])
////            ->where('Familia', 'LIKE' , $familia .'%')
//            ->first();
//
////        dd($kgms);
//
//        if( ! $kgms)
//        {
//            return Response::json([
//                'error'=> [
//                    'message'=>'Няма такава марка'
//                ]
//            ], 404);
//        }
//
//        return Response::json([
//            'recotds'=> $this->transform($kgms)
//        ], 200);
//    }
    private function transformCollection($kgms)
    {
        return array_map([$this ,'transform'],$kgms->toArray());
    }


    private function transform($kgms)
    {
        return [

            'kgm_id'    => $kgms['ID'],
            'udo_kgm_id'=> $kgms['UdoKgmID'],
            'names_id'  => $kgms['NamesID'],
            'ime'       => $kgms['Ime'],
            'prezime'   => $kgms['Prezime'],
            'familia'   => $kgms['Familia'],
            'seria'     => $kgms['SeriaKGM'],
            'number'    => $kgms['strNumberKGM'],
            'grad'      => $kgms['PolpulatedPlace'],
            'obshtina'  => $kgms['Municipality'],
            'oblast'    => $kgms['Region'],
            'email'     => $kgms['Email'],
            'phone'     => $kgms['Phone'],
            'egn'       => $kgms['EGN_EIK'],
            'address'   => $kgms['AddressP'],
            'active'    => (boolean) $kgms['Active'],
        ];
    }
}
