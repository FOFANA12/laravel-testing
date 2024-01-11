<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\TodoRequest;
use App\Models\Todo;
use Illuminate\Http\Response;

class TodoController extends Controller
{
    private $messageSuccessCreated;
    private $messageSuccessUpdated;
    private $messageSuccessDeleted;

    public function __construct()
    {
        $this->messageSuccessCreated = __('todo.controller.message_success_created');
        $this->messageSuccessCreated = __('todo.controller.message_success_created');
        $this->messageSuccessUpdated = __('todo.controller.message_success_updated');
        $this->messageSuccessDeleted = __('todo.controller.message_success_deleted');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(['todos' => Todo::all()])->setStatusCode(Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\TodoRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TodoRequest $request)
    {
        $request->merge(
            [
                'completed' => filter_var($request->completed, FILTER_VALIDATE_BOOLEAN),
            ]
        );

        $todo = Todo::create($request->only([
            'title',
            'description',
            'completed',
        ]));

        return response()->json(['message' => $this->messageSuccessCreated, 'todo' => $todo])->setStatusCode(Response::HTTP_OK);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function show(Todo $todo)
    {
        return response()->json(['todo' => $todo])->setStatusCode(Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\TodoRequest  $request
     * @param  \App\Models\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function update(TodoRequest $request, Todo $todo)
    {
        $request->merge(
            [
                'completed' => filter_var($request->completed, FILTER_VALIDATE_BOOLEAN),
            ]
        );

        $todo->fill($request->only([
            'title',
            'description',
            'completed',
        ]));

        $todo->save();

        return response()->json(['message' => $this->messageSuccessUpdated, 'todo' => $todo])->setStatusCode(Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Todo $todo)
    {
        $todo->delete();

        return response()->json(['message' => $this->messageSuccessDeleted])->setStatusCode(Response::HTTP_OK);
    }
}
