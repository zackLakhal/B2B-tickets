<?php

namespace App\Http\Controllers;

use App\Clientuser;
use App\Nstuser;
use Illuminate\Support\Facades\Validator;

use Illuminate\Http\Request;
use App\Role;
use Illuminate\Support\Facades\Auth;

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

    public function active_index()
    {
        Auth::guard('nst')->check() ? $auth = Nstuser::find(Auth::guard('nst')->user()->id) : $auth = Clientuser::find(Auth::guard('client')->user()->id);
        $roles = null;
        switch ($auth->role_id) {

            case 1:
                $roles = Role::where([['id', '<>', 6], ['id', '<>', 1]])->get();
                break;
            case 2:
                $roles = Role::where('id', '=', 2)->get();

                break;
            case 4:
                $roles = Role::where('id', '=', 5)->get();

                break;
            default:
                $roles = Role::where('id', '<>', 6)->get();
                break;
        }

        return response()->json($roles);
    }

    public function deleted()
    {

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
        $validator = Validator::make($request->all(), [

            'value' => 'required|unique:roles',
        ]);


        if ($validator->fails()) {

            return response()->json(['error' => $validator->errors(), 'inputs' => $request->all()]);
        }

        $role = new Role();
        $role->value = $request->value;
        $role->save();
        $check;
        $count = Role::all()->count();
        if (is_null($role)) {
            $check = "faile";
        } else {
            $check = "done";
        }

        $objet =  [
            'check' => $check,
            'count' => $count - 1,
            'role' => $role,
            'inputs' => $request->all()
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
    public function edit(Request $request, $edit, $id)
    {




        $done = false;
        if ($edit == "delete") {
            $role = Role::find($id);
            $role->delete();
            $done = true;
        }
        if ($edit == "restore") {
            $role = Role::onlyTrashed()
                ->where('id', $id)
                ->first();
            $role->restore();
            $done = true;
        }
        if ($edit == "edit") {
            $validator = Validator::make($request->all(), [

                'value' => 'required|unique:roles',
            ]);


            if ($validator->fails()) {

                return response()->json(['error' => $validator->errors(), 'inputs' => $request->all()]);
            }

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
        if (!$done) {
            $check = "faile";
        } else {
            $check = "done";
        }

        $objet =  [
            'check' => $check,
            'role' => $role,
            'inputs' => $request->all()
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
