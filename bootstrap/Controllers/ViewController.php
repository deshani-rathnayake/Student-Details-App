<?php

namespace App\Http\Controllers;
use App\Models\StudentModel;

use Illuminate\Http\Request;

class ViewController extends Controller
{
    public function viewDashboard()
    {
        $students = StudentModel::all();
        return view('dashboard', ['students' =>$students]);
    }
    public function AddStudent(){
        return view('add-stuent');
    }

    public function ViewStudent($id){
        $student = StudentModel::find($id);
        return view('view-student', ['students' =>$student]);
    }

    public function DeleteStudent($id){
        $student = StudentModel::find($id)->delete();
        return redirect()->back()->with('success', 'Student Delete successfully.');
    }

    public function EditStudent($id){
        $student = StudentModel::find($id);
        return view('edit-student', ['students' =>$student]);
    }




  
}
