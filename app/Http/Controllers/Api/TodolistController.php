<?php

namespace App\Http\Controllers\Api;

use Exception;
use App\Models\Todolist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Resources\TodlistResource;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;


class TodolistController extends Controller
{

     use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {


        // return response()->json([
        //     'data' => $todolist,
        //     'message' => 'Data is successfully'
        // ],200);

        try {
            //   $todolist = Todolist::latest()->where->('user_id',auth()->user()->id)->get();

             $todolist = Todolist::where('user_id', auth()->user()->id)
                            ->latest()
                            ->get();

               return TodlistResource::collection($todolist);
        } catch (Exception $error) {


            Log::error('Data Failed '. $error->getMessage());

              return response()->json([
                'message' => 'Data failed to show',
                'cause'  => $error->getMessage()
            ],500);
        }


    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', Todolist::class);

        $data = $request->validate([
            'title' => 'required|min:3|max:255',
            'desc' => 'required|min:3|max:255',
            'is_done' => 'required|in:1,0'
        ]);

        try {
            $data['user_id'] = auth()->user()->id;
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

        $this->authorize('view', $data);

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
        $todolist =  Todolist::find($id);

        $this->authorize('update',$todolist);

        $data = $request->validate([
            'title' => 'required|min:3|max:255',
            'desc' => 'required|min:3|max:255',
            'is_done' => 'required|in:1,0'
        ]);


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

        $this->authorize('delete', $todolist);
        
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
