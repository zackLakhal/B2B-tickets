<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Role;
class RoleController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Role::withTrashed()->get();
        return response()->json($roles);

    }

    public function active_index(){

        $roles = Role::all();
        return response()->json($roles);
    }

    public function deleted(){

        $roles = Role::onlyTrashed();
        return response()->json($roles);
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $role = new Role();
        $role->value = $request->value;
        $role->save();
        $check;
        $count = Role::all()->count();
        if (is_null($role)) {
            $check = "faile";
        }else{
            $check = "done";
        }
       
        $objet =  [
            'check' => $check,
            'count' => $count -1,
            'role' => $role
        ];
        return response()->json($objet);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request,$edit,$id)
    {


        

        $done = false;
        if ($edit == "delete") {
            $role = Role::find($id); 
            $role->delete();
            $done = true;
        } 
        if($edit == "restore") {
            $role = Role::onlyTrashed()
                        ->where('id', $id)
                        ->first() ; 
            $role->restore();
            $done = true;

        }
        if($edit == "edit") {
            $role = Role::withTrashed()
                        ->where('id', $id)
                        ->first();
            $role->value = $request->value;
            $role->save();
            $done = true;

        }

        $role = Role::withTrashed()
                    ->where('id', $id)
                    ->first();
        
    $check;
        if ( !$done) {
            $check = "faile";
        }else{
            $check = "done";
        }
       
        $objet =  [
            'check' => $check,
            'role' => $role
        ];
        return response()->json($objet);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $role)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        //
    }
}
