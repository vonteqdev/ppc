<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DataTables\UsersDataTable;
use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Http\Resources\UsersResource;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class UsersController extends Controller
{
    public function index(UsersDataTable $dataTable){
        return $dataTable->render('users.index');
    }

    public function create(){
        return view('users.create');
    }

    public function store(UserRequest $request){
        $user = User::create($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'User created successfully',
            'data' => new UsersResource($user)
        ], 201);
    }

    public function show(User $user){
        return view('users.show', compact('user'));
    }

    public function update(Request $request, User $user){
        $validator = Validator::make($request->all(),[
            'first_name' => 'required|string|max:255|user_name_validators|no_letters_user_name_validator',
            'last_name' => 'required|string|max:255|user_name_validators|no_letters_user_name_validator',
            'email' => 'required|string|email:rfc,dns|max:255|unique:users,email,'.$user->id,
            'password' => ($request->password)?'required|string|min:8|max:255':'',
            'password_confirmation' => ($request->password)?'required|string|min:8|max:255|same:password':''
        ]);
        if($validator->fails()) return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        $user->last_name = $request->last_name;
        $user->first_name = $request->first_name;
        $user->email = $request->email;
        if($request->password) $user->password = Hash::make($request->password);
        $user->type_id = $request->type_id;
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'User updated successfully',
            'data' => new UsersResource($user)
        ], 200);
    }

    public function destroy(User $user){
        if($user->id == auth()->user()->id){
            return response()->json([
                'success' => false,
                'message' => 'You can not delete yourself',
                'data' => (object)[]
            ], 400);
        }
        $user->delete();
        return response()->json([
            'success' => true,
            'message' => 'User deleted successfully',
            'data' => (object)[]
        ], 200);
    }
}
