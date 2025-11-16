<?php

namespace App\Http\Controllers\Api;

use App\Models\Student;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $student = Student::all();

        return response()->json([
            'status' => 'data is successfull',
            'data' =>$student,
        ]);
    }
    /**
     * Store a newly created resource in storage.
     */
      public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
           'name' => 'required|string|max:255',
           'username' => 'required|string|unique:students,username',
           'email' => 'required|email:rfc,dns|unique:students,email',
           'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }

        $validated = $validator->validated();
        $validated['password'] = bcrypt($validated['password']);

        $student = Student::create($validated);

        return response()->json([
            'message' => 'student created successfully',
            'data' => $student,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
         $student = Student::findOrFail($id);

        return response()->json([
            'status' => 'data is successfull finding',
            'data' =>$student,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
         $validator = Validator::make($request->all(), [
           'name' => 'required|string|max:255',
           'username' => 'required|string|unique:students,username',
           'email' => 'required|email:rfc,dns|unique:students,email',
           'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }

        $validated = $validator->validated();
        $validated['password'] = bcrypt($validated['password']);

        $student = Student::findOrFail($id);
        $student->update($request->all());

        return response()->json([
            'message' => 'student created successfully',
            'data' => $student,
        ], 201);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $student = Student::findOrFail($id);

        $student->delete();

        return response()->json([
           'status' => 'data sucessfully deleted',
           'data' => 'delete',
        ]);
    }
}
