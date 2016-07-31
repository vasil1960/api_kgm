<?php

namespace App\Http\Controllers;


use App\Kgm;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;



class SearchController extends Controller
{

    public function allkgm()
    {
//        $kgms = Kgm::all()->take(5);

        $kgms = Kgm::join('u_names','u_names.ID','=','u_kgm.NamesID')
                   ->join('u_address','u_address.NamesID','=','u_names.ID')
                   ->join('regions.PopulatedPlaces','regions.PopulatedPlaces.ID','=','u_address.Grad')
                   ->take(20)->get();

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
            'data'=> $this->transform($kgms)
        ], 200);

    }



    public function bynumb($seria, $number)
    {
        $kgms = Kgm::where('SeriaKGM', $seria)
                   ->where('strNumberKGM', $number)
                   ->first();

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
            'data'=> $this->transform($kgms)
        ], 200);
    }

    private function transform($kgms)
    {
        return array_map(function($kgms)
        {
            return [
                'ime'      => $kgms['Ime'],
                'prezime'  => $kgms['Prezime'],
                'familia'  => $kgms['Familia'],
                'seria'    => $kgms['SeriaKGM'],
                'number'   => $kgms['strNumberKGM'],
                'grad'     => $kgms['PolpulatedPlace'],
                'obshtina' => $kgms['Municipality'],
                'oblast'   => $kgms['Region'],
                'email'    => $kgms['Email'],
                'phone   ' => $kgms['Phone'],
                'egn'      => $kgms['EGN_EIK'],
                'address'  => $kgms['AddressP'],

            ];
        },$kgms->toArray());
    }
}
