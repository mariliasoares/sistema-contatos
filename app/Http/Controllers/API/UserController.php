<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('auth:api');
    }


    public function index()
    {
        return User::latest()->paginate(10);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:200',
            'email' => 'required|string|email|max:200|unique:users',
            'password' => 'required|string|min:8'
        ]);

        return User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'type' => $request['type'],
            'password' => Hash::make($request['password']),
        ]);
    }

    public function profile() {
        return auth('api')->user();
    }

    public function updateProfile(Request $request) {
        $user = auth('api')->user();

        $this->validate($request, [
            'name' => 'required|string|max:200',
            'email' => 'required|string|email|max:200|unique:users,email,'.$user->id,
            'password' => 'sometimes|required|min:8'
        ]);

        $currentPhoto = $user->photo;
        if($request->photo != $currentPhoto) {
            //going to take only the extension of the file
            // $extension = explode('/', explode(':', substr($request->photo, 0, strpos($request->photo, ';')))[1])[1];
            $name = time().'.' . explode('/', explode(':', substr($request->photo, 0, strpos($request->photo, ';')))[1])[1];
            //dont need to import cause I use slash here
            \Image::make($request->photo)->save(public_path('img/profile/').$name);
            $request->merge(['photo' => $name]);
        }

        if(!empty($request->password)) {
            $request->merge(['password' => Hash::make($request['password'])]);
        }

        $user->update($request->all());
        return ['message' => "Success"];
    }
    

    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $this->validate($request, [
            'name' => 'required|string|max:200',
            'email' => 'required|string|email|max:200|unique:users,email,'.$user->id,
            'password' => 'sometimes|min:8'
        ]);

        $user->update($request->all());
        return ['message' => 'Editado os dados do usuário'];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        //delete
        $user->delete();
        //redirect
        return ['message' => 'Usuário excluído'];
    }
}
