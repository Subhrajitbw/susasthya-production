<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Appointment;

class AppointmentsController extends Controller
{
    //
    public function create(Request $request){
        $counts =  \App\Appointment::count();
        $count = $counts+1002;
        $year = date("Y");
        $patient_id = $count.$year;
        $this->appointment_id = $patient_id;
        $app = new Appointment();

        $app->appointment_date = $request->input('appointment_date');
        $app->appointment_time = $request->input('appointment_time');
        $app->created_by_user_id = $request->input('created_by_user_id');
        $app->user_id = $request->input('user_id');
        $app->doctor_id = $request->input('doctor_id');
        $app->appointment_id = $patient_id;
        $app->remarks = $request->input('remarks');
        $app->status = "option2";
        $app->save();

        return response($app, 201);
    }
}
