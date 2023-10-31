<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\TableOrder;

class TableOrderController extends Controller
{
    public function index()
    {
        $tableOrders = TableOrder::with('product')->get();

        // Now, you can access the product_name for each table order
        foreach ($tableOrders as $tableOrder) {
            $productName = $tableOrder->product->product_name;
            // Use $productName as needed
        }
        return response()->json($tableOrders, Response::HTTP_OK);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'table_number_id' => 'required|exists:table_numbers,id',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $tableOrder = TableOrder::create($validatedData);

        return response()->json($tableOrder, Response::HTTP_CREATED);
    }

    public function show(TableOrder $tableOrder) // Implicit Route Model Binding
    {
        return response()->json($tableOrder, Response::HTTP_OK);
    }

    public function update(Request $request, TableOrder $tableOrder)
    {
        $validatedData = $request->validate([
            'table_number_id' => 'exists:table_numbers,id',
            'product_id' => 'exists:products,id',
            'quantity' => 'integer|min:1'
        ]);

        $tableOrder->update($validatedData);

        return response()->json($tableOrder, Response::HTTP_OK);
    }

    public function destroy(TableOrder $tableOrder)
    {
        $tableOrder->delete();

        return response()->json(['message' => 'Table order deleted'], Response::HTTP_OK);
    }
}
