<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User; 
use App\Profiles;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\storage;
use Illuminate\Support\Facades\File;
class ProfilesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $profile = Profiles::where('user_id',Auth::id())->first(); 
        return response()->json($profile,200);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $profile = Profiles::where('user_id',Auth::id())->first();       
        $profile->update($request->all());
        
        /*return response()->json($profile, 201);
        $profile = Profiles::find(Auth::id());
        $id = Auth::user()->id;
        if(Profiles::where('user_id', $id )->exists()){
            return response()->json(['error'=>'Duplicated'], 401);  
        }
        else{
            $profile->user_id = $id;
        }
        $profile->name = $request->input('name');
        $profile->birth_day = $request->input('birth_day');
        $profile->gender = $request->input('gender');
        $profile->phone = $request->input('phone');
        $profile->address = $request->input('address');*/

        /*$ImgFileStr = $request->input('avatarImg');    // ImgFile phải được mã hóa
        $ImgName =$request->input('nameImg');
        $uploadPath ="uploads/".$ImgName.".jpg";
        
        if (!empty($ImgFileStr))
        {
            file_put_contents($uploadPath, base64_decode($ImgFileStr));
        }
        $photoURL=url($uploadPath);
        $profile->avatar=$photoURL;
        $profile->save();
        return response()->json($photoURL,201);*/

        if($request->hasFile('avatarImg'))
        {
            $fileName = $request->file('avatarImg')->getClientOriginalName();
            $path = $request->file('avatarImg')->move(public_path('upload/'),$fileName);
            $photoURL = url('upload/'.$fileName); 
            $profile->avatar = $photoURL;
        }
        if($request->hasFile('wallpaperImg'))
        {
            $fileName = $request->file('wallpaperImg')->getClientOriginalName();
            $path = $request->file('wallpaperImg')->move(public_path('upload/'),$fileName);
            $photoURL = url('upload/'.$fileName); 
            $profile->wallpaper = $photoURL;
        }
        $profile->save();
        return response()->json($profile,201);
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $profiles = Profiles::find($id);
        if(is_null($profiles))
        {
            return response()->json(['message' => 'Not Found!'],404);
        }
        return response()->json($profiles,200);
        /*$profile = Profiles::find($id);
        if(is_null($profile))
        {
            return response()->json(['message' => 'Not Found!'],404);
        }
        return response()->json($profile,200);*/
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
