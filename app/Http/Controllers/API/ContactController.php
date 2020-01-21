<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Contact;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ContactController extends Controller
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
        // $contacts = Contacts::where('iduser', Auth::user()->id)->get();
        // return Contact::latest()->paginate(10);
        return Contact::where('iduser', '=', Auth::user()->id)->orderBy('created_at', 'desc')->paginate(10);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = auth('api')->user();

        $this->validate($request, [
            'name' => 'required|string|max:200',
            'email' => 'required|string|email|max:200|unique:users',
            'phone' => 'required|numeric|min:5',
            'photo' => 'required|string',
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

        return Contact::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'phone' => $request['phone'],
            'photo' => $request['photo'],
            'iduser' => Auth::user()->id,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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
        $user = Contact::findOrFail($id);

        $this->validate($request, [
            'name' => 'required|string|max:200',
            'email' => 'required|string|email|max:200|unique:users,email,'.$user->id,
            'phone' => 'required|numeric|min:5',
            'photo' => 'required|string',
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
        $user = Contact::findOrFail($id);
        $user->delete();
        return ['message' => 'Contato excluído'];
        
    }
}
