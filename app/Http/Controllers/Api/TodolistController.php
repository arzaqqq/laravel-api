<?php

namespace App\Http\Controllers\Api;

use Exception;
use App\Models\Todolist;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\TodlistResource;

class TodolistController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $todolist = Todolist::latest()->get();

        // return response()->json([
        //     'data' => $todolist,
        //     'message' => 'Data is successfully'
        // ],200);

        return TodlistResource::collection($todolist);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|min:3|max:255',
            'desc' => 'required|min:3|max:255',
            'is_done' => 'required|in:1,0'
        ]);

        try {
            $todolist = Todolist::create($data);

            return response()->json([
                'message' => 'Data created successfully',
                'data' => new TodlistResource(($todolist))
            ],201);

        } catch (Exception) {
            return response()->json([
                'message' => 'Data failed'
            ],500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = Todolist::find($id);

        if($data == null){
            return response()->json([
                'message' => 'Data is not found'
            ],404);
        }

        return new TodlistResource(($data));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            'title' => 'required|min:3|max:255',
            'desc' => 'required|min:3|max:255',
            'is_done' => 'required|in:1,0'
        ]);

        $todolist =  Todolist::find($id);

        if($todolist == null){
            return response()->json([
                'message' => 'todolist is failed to update'
            ],404);
        }

        try {
            $todolist->update($data);

            return response()->json([
                'message' => 'Data created successfully',
                'data' => new TodlistResource(($todolist))
            ],201);

        } catch (Exception) {
            return response()->json([
                'message' => 'Data failed'
            ],500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $todolist = Todolist::find($id);

        if($todolist == null){
            return response()->json([
                'message' => 'data is not found'
            ],404);
        }
        try {
            $todolist->delete();

            return response()->json([
                'message' => 'data is successfullly delete'
            ],200);
        } catch (Exception) {
                return response()->json([
                    'message' => 'destroy is failed'
                ],400);
        }


    }
}
