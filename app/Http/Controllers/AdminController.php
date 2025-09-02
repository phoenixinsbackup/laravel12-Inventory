<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;

class AdminController extends Controller
{
    public function AdminLogout(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }

    public function AdminProfile()
    {
        $id=Auth::user()->id;
        $profileData=User::find($id);
        return view('admin.admin_profile',compact('profileData'));

    }

    public function ProfileStore(Request $request)
    {
        $id=Auth::user()->id;
        $data=User::find($id);

        $data->name=$request->name;
        $data->email=$request->email;
        $data->phone=$request->phone;
        $data->address=$request->address;

        $oldPhotoPath=$data->photo;

        if($request->hasFile('photo'))
        {
            $file=$request->file('photo');
            $filename=time().'.'.$file->getClientOriginalExtension();
            $file->move(public_path('upload/user_images'),$filename);
            $data->photo=$filename;

            if($oldPhotoPath && $oldPhotoPath !==$filename)
            {
                $this->deleteOldImage($oldPhotoPath);
            }
        }

        $data->save();

        $notification=array('message'=>'Profile updated successfully','alert-type'=>'success');

        return redirect()->back()->with($notification);
        

    }


    private function deleteOldImage(string $oldPhotoPath ):void{
        $fullpath=public_path('upload/user_images/'.$oldPhotoPath);
        if(file_exists($fullpath))
        {
            unlink($fullpath);
        }
    }


    public function AdminPasswordUpdate(Request $request)
    {

    }
        
    



}
