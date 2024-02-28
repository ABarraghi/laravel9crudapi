<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{
    public function index(){
        $students = Student::all();

        if($students->count()>0){
            $data = [
                'status' => 200,
                'students' => $students
            ];
            return response() -> json($data, 200);
        }
        else{
            $data = [
                'status' => 404,
                'message' => 'No students found'
            ];
            return response() -> json($data, 404);
        }
    }

    public function store(Request $request){

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:191',
            'course' => 'required|string|max:191',
            'email' => 'required|email|max:191',
            'phone' => 'required|digits:10'
        ]);

        if($validator->fails()){
            $data = [
                'status' => 422,
                'message' => 'Validation error',
                'errors' => $validator->messages()
            ];
            return response() -> json($data, 422);
        }
        else {

            $student = Student::create([
                'name' => $request->name,
                'course' => $request->course,
                'email' => $request->email,
                'phone' => $request->phone
            ]);

            if($student){
                return response() -> json([
                    'status' => 201,
                    'message' => 'Student created successfully'
                ], 201);
            } 
            else {
                return response() -> json([
                    'status' => 500,
                    'message' => 'Something Went Wrong!'
                ], 500);
            }
        }
    }

    public function show($id){
        $student = Student::find($id);

        if($student){
            return response() -> json([
                'status' => 200,
                'student' => $student
            ], 200);
        }
        else{
            return response() -> json([
                'status' => 404,
                'message' => 'Student not found'
            ], 404);
        }
    }

    public function edit($id){
        $student = Student::find($id);

        if($student){
            return response() -> json([
                'status' => 200,
                'student' => $student
            ], 200);
        }
        else{
            return response() -> json([
                'status' => 404,
                'message' => 'Student not found'
            ], 404);
        }
    }

    public function update(Request $request, int $id){

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:191',
            'course' => 'required|string|max:191',
            'email' => 'required|email|max:191',
            'phone' => 'required|digits:10'
        ]);

        if($validator->fails()){
            $data = [
                'status' => 422,
                'message' => 'Validation error',
                'errors' => $validator->messages()
            ];
            return response() -> json($data, 422);
        }
        else {

            $student = Student::find($id);

            if($student){

                $student -> update([
                    'name' => $request->name,
                    'course' => $request->course,
                    'email' => $request->email,
                    'phone' => $request->phone
                ]);

                return response() -> json([
                    'status' => 201,
                    'message' => 'Student updated successfully'
                ], 201);
            } 
            else {
                return response() -> json([
                    'status' => 404,
                    'message' => 'No Such Student Found!'
                ], 404);
            }
        }
    }

    public function destroy($id){
        $student = Student::find($id);

        if($student){
            $student -> delete();
            return response() -> json([
                'status' => 200,
                'message' => 'Student deleted successfully'
            ], 200);
        }
        else{
            return response() -> json([
                'status' => 404,
                'message' => 'Student not found'
            ], 404);
        }
    }
}
