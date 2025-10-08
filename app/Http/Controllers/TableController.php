<?php

namespace App\Http\Controllers;

use App\Models\History;
use App\Models\Table;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TableController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tables = Table::orderBy('table_number')->paginate(10);
        return view('tables.index', compact('tables'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Table $table)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Table $table)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Table $table)
    {
        $rules = [
            'seats' => 'nullable',
            'status' => 'nullable|in:available,unavailable',
            'location' => 'nullable|in:indoor,outdoor,vip',
        ];
        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()){
            return back()->withInput()->withErrors($validator);
        }
        if($table->seats != $request->seats){
            $table->seats = $request->seats;
            History::create([
                'user_id' => Auth::id(),
                'action' => 'update',
                'table_name' => 'tables',
                'record_id' => $table->id,
                'description' => 'Table '.$table->table_number.' seats updated to '.$table->seats,
            ]);
        }
        if($table->status != $request->status){
            $table->status = $request->status;
            History::create([
                'user_id' => Auth::id(),
                'action' => 'update',
                'table_name' => 'tables',
                'record_id' => $table->id,
                'description' => 'Table '.$table->table_number.' status updated to '.$table->status,
            ]);
        }
        if($table->location != $request->location){
            History::create([
                'user_id' => Auth::id(),
                'action' => 'update',
                'table_name' => 'tables',
                'record_id' => $table->id,
                'description' => 'Table '.$table->table_number.' location updated to '.$table->location,
            ]);
            $table->location = $request->location;
        }
        $table->save();
        return redirect()->route('tables.index')->with('success', 'Table '.$table->table_number.' updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Table $table)
    {
        //
    }
}
