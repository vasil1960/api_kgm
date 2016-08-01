<?php

namespace App\Http\Controllers;
use App\Kgm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class SearchController extends Controller
{
    public function marks(Request $request)
    {
        $kgms = Kgm::join('u_names','u_names.ID','=','u_kgm.NamesID')
                   ->join('u_address','u_address.NamesID','=','u_names.ID')
                   ->join('regions.PopulatedPlaces','regions.PopulatedPlaces.ID','=','u_address.Grad')
                   ->where([
                       ['SeriaKGM', $request->seria],
                       ['strNumberKGM','LIKE', '%'. $request->number . '%']
                   ])
                   ->take(100)->get();

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

    public function name(Request $request)
    {
        $kgms = Kgm::join('u_names','u_names.ID','=','u_kgm.NamesID')
                   ->join('u_address','u_address.NamesID','=','u_names.ID')
                   ->join('regions.PopulatedPlaces','regions.PopulatedPlaces.ID','=','u_address.Grad')
                   ->where('u_names.ID', $request->names_id)
                   ->first();

        if( ! $kgms)
        {
            return Response::json([
                'error'=> [
                    'message'=>'Няма такова име'
                ]
            ], 404);
        }

        return Response::json([
            'records'=> $this->transform($kgms)
        ], 200);
    }

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
