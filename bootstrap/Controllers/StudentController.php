<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Models\StudentModel;
class StudentController extends Controller
{
    public function CreateStudent(Request $request){
        $validator = Validator::make( $request->all(), [
            'name' => 'required',
            'age' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'status' => 'required',
        ] );
    
        if ( $validator->fails() ) {
            return redirect()->back()->withErrors($validator->messages()->all());
        }
       
        if ($request->hasFile('image')) {
            $image = $request->file('image');
         
            $imagename=ImageUpload($image);

         
       
            StudentModel::create([
                'name'=> $request->name,
                'image_name'    => $imagename,
                'age'    => $request->age,
                'status'    => $request->status,
            ]);

          
        }
        return redirect("/dashboard")->with('success', 'Student Added successfully.');
    
    
    }

    public function UpdateStudent(Request $request,$id){
        $validator = Validator::make( $request->all(), [
            'name' => 'required',
            'age' => 'required',
          //  'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'status' => 'required',
        ] );
    
        if ( $validator->fails() ) {
            return redirect()->back()->withErrors($validator->messages()->all());
        }
       
        $student=StudentModel::find($id);

        $student->name=$request->name;
        $student->age=$request->age;
        $student->status=$request->status;

        if ($request->hasFile('image')) {
            $image = $request->file('image');

            $imagename=ImageUpload($image);
         
       
            $student->image_name=$imagename;
           

          
        }
        
        $student->save();
        return redirect("/dashboard")->with('success', 'Student Updated successfully.');

    
    
    }
    
}
