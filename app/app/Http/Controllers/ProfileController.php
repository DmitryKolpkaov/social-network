<?php

namespace App\Http\Controllers;

use App\Models\Status;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Mockery\Exception;

class ProfileController extends Controller
{
    public function getProfile($username)
    {
        $user = User::where('username', $username)->first();

        if(!$user){
            abort(404);
        }

        $statuses = $user->statuses()
            ->notReply()
            ->get();

        return view('profile.index', [
            'user'=> $user,
            'statuses' => $statuses,
            'authUserIsFriend'=> Auth::user()->isFriendWith($user)
        ]);
    }

    public function getEdit()
    {
        return view('profile.edit');
    }

    public function postEdit(Request $request)
    {
        $this->validate($request, [
            'first_name'=> 'alpha|max:50',
            'last_name'=> 'alpha|sometimes|nullable|max:50',
            'location'=> 'max:50'
        ]);

        Auth::user()->update([
            'first_name'=> $request->input('first_name'),
            'last_name'=> $request->input('last_name') ? $request->input('last_name') : '',
            'location'=> $request->input('location') ? $request->input('location') : ''
        ]);

        return redirect()
            ->route('profile.edit')
            ->with('info', 'Обновление прошло успешно!');
    }

    /**
     * Загружаем avatar
     *
     * @param Request $request
     * @param $username
     * @return RedirectResponse
     */
    public function postUploadAvatar(Request $request, $username)
    {
        $user = User::where('username', $username)->first();

        if(!Auth::user()->id === $user->id){
            return redirect()->route('home');
        }

        if($request->hasFile('avatar')){

            $user->clearAvatars($user->id);

            $avatar = $request->file('avatar');
            $filename = time() . '.' . $avatar->getClientOriginalExtension();

            #Типы загружаемых avatar
            if (!in_array($avatar->getMimeType(),[
                'image/jpeg',
                'image/jpg',
                'image/png',
                'image/webp'
            ])){
                throw new Exception('File type is\'t allowed');
            }


            copy($avatar->getPath().'/'.$avatar->getFilename(), public_path($user->getAvatarsPath($user->id)).$filename);

            #Заносим avatar в бд
            $user = Auth::user();
            $user->avatar = $filename;
            $user->save();

        }
        return redirect()->back();

    }
}
