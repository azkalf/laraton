<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Social;
use App\Education;
use App\Work;
use Auth;
use Image;
use Hash;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    public function change_skin(Request $request)
    {
        $user = Auth::User();
        $user->skin = $request->skin;
        if ($user->save()) {
            echo 'Tema berhasil diupdate.';
        } else {
            echo 'Tema gagal diupdate.';
        }
    }

    public function profile()
    {
        $profile = Auth::User();
        return view('config.profile', compact('profile'));
    }

    public function photo_profile(Request $request)
    {
        $user = Auth::User();
        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $destination = base_path().'/public/uploads/images/users/';
            $filename = 'photo_'.$user->name.'.'.$photo->getClientOriginalExtension();
            if ($photo->isValid()) {
                if (!empty($user->photo)) {
                    if (file_exists($destination.$user->photo)) {
                        unlink($destination.$user->photo);
                    }
                    if (file_exists($destination.'fit_'.$user->photo)) {
                        unlink($destination.'fit_'.$user->photo);
                    }
                }
                $photo->move($destination, $filename);
                // open file a image resource
                $img = Image::make($destination.$filename);

                // crop image
                $img->fit(100)->save($destination.'fit_'.$filename);
                $user->photo = $filename;
                $user->save();
                $data['photo'] = $filename;
                $data['message'] = 'photo berhasil diedit!';
                echo json_encode($data);
            } else {
                echo 'photo gagal diedit!';
            }
        }
    }

    public function poster_profile(Request $request)
    {
        $user = Auth::User();
        if ($request->hasFile('poster')) {
            $poster = $request->file('poster');
            $destination = base_path().'/public/uploads/images/posters/';
            $filename = 'poster_'.$user->name.'.'.$poster->getClientOriginalExtension();
            if ($poster->isValid()) {
                if (!empty($user->poster)) {
                    if (file_exists($destination.$user->poster)) {
                        unlink($destination.$user->poster);
                    }
                    if (file_exists($destination.'fit_'.$user->poster)) {
                        unlink($destination.'fit_'.$user->poster);
                    }
                }
                $poster->move($destination, $filename);
                // open file a image resource
                $img = Image::make($destination.$filename);

                // crop image
                $img->fit(300, 135, null, 'top')->save($destination.'fit_'.$filename);
                $user->poster = $filename;
                $user->save();
                $data['poster'] = $filename;
                $data['message'] = 'poster berhasil diedit!';
                echo json_encode($data);
            } else {
                echo 'poster gagal diedit!';
            }
        }
    }

    public function update_profile(Request $request)
    {
        $user = Auth::User();
        $column = $request->column;
        $user->$column = $request->value;
        if ($user->save()) {
            echo 'Data berhasil diupdate';
        } else {
            echo 'Data gagal diupdate';
        }
    }

    public function update_password(Request $request)
    {
        $user = Auth::User();
        if (Hash::check($request->old_password, $user->password)) {
            $user->password = Hash::make($request->new_password);
            if ($user->save()) {
                $data['success'] = true;
                $data['message'] = "Password berhasil diganti!";
            } else {
                $data['success'] = false;
                $data['message'] = "Password gagal diganti!";
            }
        } else {
            $data['success'] = false;
            $data['message'] = "Password lama ga sesuai!";
        }
        echo json_encode($data);
    }

    public function get_address(Request $request)
    {
        $village_id = $request->village_id;
        $data['paddress'] = paddress($village_id);
        $data['address'] = address($village_id);
        echo json_encode($data);
    }

    public function remove_photo(Request $request)
    {
        $user = Auth::User();
        $user->photo = null;
        $data['photo'] = Auth::User()->gender == 'm' ? 'ikhwan.png' : 'akhwat.png';
        if ($user->save()) {
            $data['message'] = 'Photo berhasil dihapus!';
        } else {
            $data['message'] = 'Photo gagal dihapus!';
        }
        echo json_encode($data);
    }

    public function remove_poster(Request $request)
    {
        $user = Auth::User();
        $user->poster = null;
        if ($user->save()) {
            echo 'Poster berhasil dihapus!';
        } else {
            echo 'Poster gagal dihapus!';
        }
    }

    public function get_social(Request $request)
    {
        $social = Social::find($request->id);
        echo json_encode($social);
    }

    public function update_social(Request $request)
    {
        $social = Social::find($request->id);
        $social->name = $request->name;
        $social->icon = $request->icon;
        $social->link = $request->link;
        $social->color = $request->color;
        if ($social->save()) {
            echo 'Data media sosial berhasil diupdate!';
        } else {
            echo 'Data media sosial gagal diupdate!';
        }
    }

    public function add_social(Request $request)
    {
        $social = new Social;
        $social->name = $request->name;
        $social->icon = $request->icon;
        $social->link = $request->link;
        $social->color = $request->color;
        $social->user_id = Auth::User()->id;
        if ($social->save()) {
            $data['id'] = $social->id;
            $data['message'] = 'Data media sosial berhasil disimpan!';
            echo json_encode($data);
        } else {
            echo 'Data media sosial gagal disimpan!';
        }
    }

    public function remove_social(Request $request)
    {
        $user = Auth::User();
        $social = Social::where('id', $request->id)->where('user_id', Auth::User()->id)->first();
        if ($social) {
            $social->delete();
            echo 'Data media sosial berhasil dihapus!';
        } else {
            echo 'Data media sosial gagal dihapus!';
        }
    }

    public function get_education(Request $request)
    {
        $education = Education::find($request->id);
        echo json_encode($education);
    }

    public function update_education(Request $request)
    {
        $education = Education::find($request->id);
        $education->name = $request->name;
        $education->level = $request->level;
        $education->majors = $request->majors;
        $education->place = $request->place;
        $education->year_in = $request->year_in;
        $education->year_out = $request->year_out;
        $education->current = $request->status;
        if ($education->save()) {
            $data['level'] = education_levels($education->level);
            $data['message'] = 'Data riwayat pendidikan berhasil diupdate!';
            echo json_encode($data);
        } else {
            echo 'data riwayat pendidikan gagal diupdate!';
        }
    }

    public function add_education(Request $request)
    {
        $education = new Education;
        $education->user_id = Auth::User()->id;
        $education->name = $request->name;
        $education->level = $request->level;
        $education->majors = $request->majors;
        $education->place = $request->place;
        $education->year_in = $request->year_in;
        $education->year_out = $request->year_out;
        $education->current = $request->status;
        if ($education->save()) {
            $data['id'] = $education->id;
            $data['level'] = education_levels($education->level);
            $data['message'] = 'Data riwayat pendidikan berhasil disimpan!';
            echo json_encode($data);
        } else {
            echo 'Data riwayat pendidikan gagal disimpan!';
        }
    }

    public function remove_education(Request $request)
    {
        $user = Auth::User();
        $education = Education::where('id', $request->id)->where('user_id', Auth::User()->id)->first();
        if ($education) {
            $education->delete();
            echo 'Data riwayat pendidikan berhasil dihapus!';
        } else {
            echo 'Data riwayat pendidikan gagal dihapus!';
        }
    }

    public function get_work(Request $request)
    {
        $work = Work::find($request->id);
        echo json_encode($work);
    }

    public function update_work(Request $request)
    {
        $work = Work::find($request->id);
        $work->name = $request->name;
        $work->position = $request->position;
        $work->office = $request->office;
        $work->place = $request->place;
        $work->year_in = $request->year_in;
        $work->year_out = $request->year_out;
        $work->current = $request->status;
        if ($work->save()) {
            echo 'Data riwayat pekerjaan berhasil diupdate!';
        } else {
            echo 'data riwayat pekerjaan gagal diupdate!';
        }
    }

    public function add_work(Request $request)
    {
        $work = new Work;
        $work->user_id = Auth::User()->id;
        $work->name = $request->name;
        $work->position = $request->position;
        $work->office = $request->office;
        $work->place = $request->place;
        $work->year_in = $request->year_in;
        $work->year_out = $request->year_out;
        $work->current = $request->status;
        if ($work->save()) {
            $data['id'] = $work->id;
            $data['message'] = 'Data riwayat pekerjaan berhasil disimpan!';
            echo json_encode($data);
        } else {
            echo 'Data riwayat pekerjaan gagal disimpan!';
        }
    }

    public function remove_work(Request $request)
    {
        $user = Auth::User();
        $work = Work::where('id', $request->id)->where('user_id', Auth::User()->id)->first();
        if ($work) {
            $work->delete();
            echo 'Data riwayat pekerjaan berhasil dihapus!';
        } else {
            echo 'Data riwayat pekerjaan gagal dihapus!';
        }
    }
}
