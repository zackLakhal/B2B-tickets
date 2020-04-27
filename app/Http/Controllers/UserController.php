<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Clientuser;
use App\Nstuser;
use App\Client;

class UserController extends Controller
{
    public function nst_index()
    {
        $users = Nstuser::withTrashed()->get();
        $roles = array();
        foreach ($users as $user) {
            $roles[] = $user->role;
        }
        $objet =  [
            'users' => $users,
            'roles' => $roles,

        ];
        return response()->json($objet);
    }

    public function nst_edit(Request $request, $edit, $id)
    {

        $done = false;
        if ($edit == "delete") {
            $user = Nstuser::find($id);
            $user->delete();
            $done = true;
        }
        if ($edit == "restore") {
            $user = Nstuser::onlyTrashed()
                ->where('id', $id)
                ->first();
            $user->restore();
            $done = true;
        }
        if ($edit == "edit") {

            $user = Nstuser::withTrashed()
                ->where('id', $id)
                ->first();

            $validator = null;

            if ($request->filled('email') && $request->email == $user->email) {
                $validator = Validator::make($request->all(), [

                    'email' => 'required',
                    'role' => 'required|gt:0',
                    'nom' => 'required',
                    'prenom' => 'required',
                    'tel' => 'required',
                ]);
            } else {
                $validator = Validator::make($request->all(), [

                    'email' => 'required|unique:nstusers',
                    'role' => 'required|gt:0',
                    'nom' => 'required',
                    'prenom' => 'required',
                    'tel' => 'required',
                ]);
            }

            if ($validator->fails()) {

                return response()->json(['error' => $validator->errors(),'inputs' => $request->all()]);
            }


            $temp = explode("@", $request->email);
            $user->name = $temp[0];
            $user->email = $request->email;
            $user->role_id = $request->role;
            $user->nom = $request->nom;
            $user->prénom = $request->prenom;
            $user->tel = $request->tel;
            $user->save();


            if ($request->filled('adress')) {
                $user->adress = $request->adress;
            }


            if ($request->file('avatar')) {
                $file = $request->file('avatar');
                $image = time() . '.' . $file->getClientOriginalExtension();
                $path = $request->file('avatar')->storeAs(
                    'avatars',
                    $user->id . "_" . $image
                );
                $user->photo = $path;
                $user->save();
            } else {
                $user->photo = "avatars/placeholder.jpg";
                $user->save();
            }

            $done = true;
        }

        $user = Nstuser::withTrashed()
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
            'user' => $user,
            'role' => $user->role,
            'inputs' => $request->all()
        ];
        return response()->json($objet);
    }

    public function nst_store(Request $request)
    {

        $validator = Validator::make($request->all(), [

            'email' => 'required|unique:nstusers',
            'password' => 'required|min:8',
            'role' => 'required|gt:0',
            'nom' => 'required',
            'prenom' => 'required',
            'tel' => 'required',
        ]);


        if ($validator->fails()) {

            return response()->json(['error' => $validator->errors(),'inputs' => $request->all()]);
        }

        $user = new Nstuser();
        $temp = explode("@", $request->email);
        $user->name = $temp[0];
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->role_id = $request->role;
        $user->nom = $request->nom;
        $user->prénom = $request->prenom;
        $user->tel = $request->tel;
        $user->save();

        if ($request->filled('adress')) {
            $user->adress = $request->adress;
        }


        if ($request->file('avatar')) {
            $file = $request->file('avatar');
            $image = time() . '.' . $file->getClientOriginalExtension();
            $path = $request->file('avatar')->storeAs(
                'avatars',
                $user->id . "_" . $image
            );
            $user->photo = $path;
            $user->save();
        } else {
            $user->photo = "avatars/placeholder.jpg";
            $user->save();
        }

        $check;
        $count = Nstuser::all()->count();
        if (is_null($user)) {
            $check = "faile";
        } else {
            $check = "done";
        }

        $objet =  [
            'check' => $check,
            'count' => $count - 1,
            'user' => $user,
            'role' => $user->role,
            'inputs' => $request->all()
        ];
        return response()->json($objet);
    }

    // staff client

    public function client_index()
    {
        $users = Clientuser::withTrashed()->get();
        $roles = array();
        $clients = array();
        foreach ($users as $user) {
            $roles[] = $user->role;
            $clients[] = Client::withTrashed()
                ->where('id', $user->created_by)
                ->first();
        }

        $objet =  [
            'users' => $users,
            'roles' => $roles,
            'clients' => $clients

        ];
        return response()->json($objet);
    }

    public function my_users_departement($id_c)
    {
        $users = Clientuser::where([
            ['created_by', '=', $id_c],
            ['is_affected', "=", false],
            ['role_id', '=', 5],
        ])
            ->get();
        $roles = array();

        foreach ($users as $user) {
            $roles[] = $user->role;
        }

        $objet =  [
            'users' => $users,
            'roles' => $roles
        ];
        return response()->json($objet);
    }

    public function my_users_agence($id_c)
    {
        $users = Clientuser::where([
            ['created_by', '=', $id_c],
            ['is_affected', "=", false],
            ['role_id', '=', 6],
        ])
            ->get();
        $roles = array();

        foreach ($users as $user) {
            $roles[] = $user->role;
        }

        $objet =  [
            'users' => $users,
            'roles' => $roles
        ];
        return response()->json($objet);
    }

    public function client_edit(Request $request, $edit, $id)
    {

        $done = false;
        if ($edit == "delete") {
            $user = Clientuser::find($id);
            $user->delete();
            $done = true;
        }
        if ($edit == "restore") {
            $user = Clientuser::onlyTrashed()
                ->where('id', $id)
                ->first();
            $user->restore();
            $done = true;
        }
        if ($edit == "edit") {
            $user = Clientuser::withTrashed()
                ->where('id', $id)
                ->first();
            $validator = null;

            if ($request->filled('email') && $request->email == $user->email) {
                $validator = Validator::make($request->all(), [

                    'email' => 'required',
                    'role' => 'required|gt:0',
                    'created_by' => 'required|gt:0',
                    'nom' => 'required',
                    'prenom' => 'required',
                    'tel' => 'required',
                ]);
            } else {
                $validator = Validator::make($request->all(), [

                    'email' => 'required|unique:clientusers',
                    'role' => 'required|gt:0',
                    'created_by' => 'required|gt:0',
                    'nom' => 'required',
                    'prenom' => 'required',
                    'tel' => 'required',
                ]);
            }

            if ($validator->fails()) {

                return response()->json(['error' => $validator->errors(),'inputs' => $request->all()]);
            }


            $temp = explode("@", $request->email);
            $user->name = $temp[0];
            $user->email = $request->email;
            $user->role_id = $request->role;
            $user->created_by = $request->created_by;
            $user->tel = $request->tel;
            $user->prénom = $request->prenom;
            $user->nom = $request->nom;

            $user->save();

            if ($request->filled('adress')) {
                $user->adress = $request->adress;
            }


            if ($request->file('avatar')) {
                $file = $request->file('avatar');
                $image = time() . '.' . $file->getClientOriginalExtension();
                $path = $request->file('avatar')->storeAs(
                    'avatars',
                    $user->id . "_" . $image
                );
                $user->photo = $path;
                $user->save();
            } else {
                $user->photo = "avatars/placeholder.jpg";
                $user->save();
            }
            $done = true;
        }

        $user = Clientuser::withTrashed()
            ->where('id', $id)
            ->first();
        $client =  Client::withTrashed()
            ->where('id', $user->created_by)
            ->first();

        $check;
        if (!$done) {
            $check = "faile";
        } else {
            $check = "done";
        }

        $objet =  [
            'check' => $check,
            'user' => $user,
            'role' => $user->role,
            'client' => $client,
            'inputs' => $request->all()
        ];
        return response()->json($objet);
    }

    public function client_store(Request $request)
    {
        $validator = Validator::make($request->all(), [

            'email' => 'required|unique:clientusers',
            'password' => 'required|min:8',
            'role' => 'required|gt:0',
            'created_by' => 'required|gt:0',
            'nom' => 'required',
            'prenom' => 'required',
            'tel' => 'required',
        ]);


        if ($validator->fails()) {

            return response()->json(['error' => $validator->errors(),'inputs' => $request->all()]);
        }

        $user = new Clientuser();
        $temp = explode("@", $request->email);
        $user->name = $temp[0];
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->role_id = $request->role;
        $user->created_by = $request->created_by;
        $user->tel = $request->tel;
        $user->prénom = $request->prenom;
        $user->nom = $request->nom;
        $user->save();


        if ($request->filled('adress')) {
            $user->adress = $request->adress;
        }


        if ($request->file('avatar')) {
            $file = $request->file('avatar');
            $image = time() . '.' . $file->getClientOriginalExtension();
            $path = $request->file('avatar')->storeAs(
                'avatars',
                $user->id . "_" . $image
            );
            $user->photo = $path;
            $user->save();
        } else {
            $user->photo = "avatars/placeholder.jpg";
            $user->save();
        }


        $check;
        $count = Clientuser::all()->count();
        if (is_null($user)) {
            $check = "faile";
        } else {
            $check = "done";
        }
        $client =  Client::withTrashed()
            ->where('id', $user->created_by)
            ->first();

        $objet =  [
            'check' => $check,
            'count' => $count - 1,
            'user' => $user,
            'role' => $user->role,
            'client' => $client,
            'inputs' => $request->all()
        ];
        return response()->json($objet);
    }

    public function save_pass(Request $request)
    {
       
            $done = false;
            $user;
            if($request->type == "client"){
                $user = Clientuser::find($request->id);
            }else{
                $user = Nstuser::find($request->id);
            }
           
            $user->password = Hash::make($request->password);
            $user->save();
            $done = true;
        
        
        $client =  Client::withTrashed()
            ->where('id', $user->created_by)
            ->first();

        $check;
        if (!$done) {
            $check = "faile";
        } else {
            $check = "done";
        }

        $objet =  [
            'check' => $check,
            'user' => $user,
            'role' => $user->role,
            'client' => $client,
            'inputs' => $request->all()
        ];
        return response()->json($objet);
    }
}
