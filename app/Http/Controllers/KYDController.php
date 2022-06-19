<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\KnowYourDisease;

class KYDController extends Controller
{
    //
    public function create(Request $request){
        $kyd = new KnowYourDisease();
        $kyd->created_by_user_id = $request->input("created_by_user_id");
        $kyd->problem = $request->input("problem");
        $kyd->age = $request->input("age");
        $kyd->gender = $request->input("gender");
        $kyd->preffered_contact_method = $request->input("preffered_contact_method");
        $kyd->save();
        return response($kyd, 201);
    }
}
