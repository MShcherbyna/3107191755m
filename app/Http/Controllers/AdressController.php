<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Validator;
use App\Adress;

class AdressController extends Controller
{
    private $settingRules = [
        'name'    => 'required',
        'area' => 'required',
        'city'    => 'required',
    ];

    /**
     * Get all adresse from DB
     * @return string
    */
    public function index()
    {
        $adresses = Adress::orderBy('name')->get();

        if (!count($adresses)) {
            return response()->json(['success'=>false], 202);
        }

        // $sorted = array_values(Arr::sort($adresses, function ($value) {
        //     return $value['name'];
        // }));

        return response()->json(['success'=>true, 'data'=>$adresses], 200);
    }

    /**
     * Add new adress to DB
     * @param Request $request
     * @return string
    */
    public function create(Request $request)
    {
        $requestData = $request->all();
        $validator   = Validator::make($requestData, $this->settingRules);

        if ($validator->fails()) {
            $errors = $validator->errors();
            return response()->json(['success'=>false, 'data'=>$errors->all()], 202);
        }

        $insertData = [
            'name' =>$requestData['name'],
            'street' => $requestData['street'] ? $requestData['street'] : '',
            'house_number' => $requestData['house_number'] ? $requestData['house_number'] : '',
            'additional_information' => $requestData['additional_information'] ? $requestData['additional_information'] : '',
            'city' => $requestData['city'],
            'area' => $requestData['area'],
        ];

        try {
            Adress::create($insertData);
        } catch (Exception $e) {
            return response()->json(['success'=>false, 'data'=>$e->getMessage()], 500);
        }

        return response()->json(['success'=>true], 200);
    }

    /**
     * Add new adress to DB
     * @param int $id
     * @return string
    */
    public function remove(int $id)
    {
        $adress = Adress::find($id);

        try {
            if($adress){
                $adress->delete();
            }
        } catch (Exception $e) {
            return response()->json(['success'=>false, 'data'=>$e->getMessage()], 500);
        }

        return response()->json(['success'=>true], 200);
    }

}
