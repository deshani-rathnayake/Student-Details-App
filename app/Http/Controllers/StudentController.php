<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Mod;

class StudentController extends Controller
{
    // Method to display all students
    public function index()
    {
        $students = Student::all();
        return view('students.index', compact('students'));
    }

    // Method to create a new student
    public function createStudent(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'age' => 'required|numeric',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'status' => 'required|in:active,inactive',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->messages()->all());
        }

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName(); // Adding timestamp to avoid filename conflicts
            $image->move(public_path('images'), $imageName);

            Student::create([
                'name' => $request->name,
                'image_name' => $imageName,
                'age' => $request->age,
                'status' => $request->status,
            ]);
        }

        return redirect("/dashboard")->with('success', 'Student Added successfully.');
    }

    // Method to update an existing student
    public function updateStudent(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'age' => 'required|numeric',
            'status' => 'required|in:active,inactive',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->messages()->all());
        }

        $student = Student::find($id);

        $student->name = $request->name;
        $student->age = $request->age;
        $student->status = $request->status;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName(); // Adding timestamp to avoid filename conflicts
            $image->move(public_path('images'), $imageName);

            $student->image_name = $imageName;
        }

        $student->save();
        return redirect("/dashboard")->with('success', 'Student Updated successfully.');
    }
}
