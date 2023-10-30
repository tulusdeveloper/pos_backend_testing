<?php

namespace App\Http\Controllers;

use App\Models\TableNumber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TableNumberController extends Controller
{
    public function index()
    {
        $tableNumber = TableNumber::all();
        return response()->json($tableNumber);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'number' => 'required|unique:table_numbers,number|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $tableNumber = TableNumber::create([
            'number' => $request->input('number'),
        ]);

        return response()->json($tableNumber, 201);
    }

    public function show($id)
    {
        $tableNumber = TableNumber::find($id);

        if (!$tableNumber) {
            return response()->json('Table number not found', 404);
        }

        return response()->json($tableNumber);
    }

    public function update(Request $request, $id)
    {
        $tableNumber = TableNumber::find($id);

        if (!$tableNumber) {
            return response()->json('Table number not found', 404);
        }

        $validator = Validator::make($request->all(), [
            'number' => 'unique:table_numbers,number|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $tableNumber->update([
            'number' => $request->input('number'),
        ]);

        return response()->json($tableNumber, 200);
    }

    public function destroy($id)
    {
        $tableNumber = TableNumber::find($id);

        if (!$tableNumber) {
            return response()->json('Table number not found', 404);
        }

        $tableNumber->delete();

        return response()->json('Table number deleted successfully.', 204);
    }
}
