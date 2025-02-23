<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IndexController extends Controller
{
    function index() {

        $activities = "";

        if(Auth::user()){
            $activities = Activity::where("user_id", Auth::user()->id)->whereDate("created_at", Carbon::today())->get();
        }

        return view("index", compact('activities'));
    }

    function store(Request $request) {
        $request->validate([
            'name' => 'required|max:250|string'
        ]);

        $activity = new Activity();
        $activity->user_id = Auth::user()->id;
        $activity->name = $request->name;
        $activity->save();

        return redirect("/")->with("success", "Aktivitas baru yey!");

    }

    function handleCompleted($id) {
        $activity = Activity::findOrFail($id);
        if($activity->user_id != Auth::user()->id || $activity->completed_at){
            abort(404);
        }

        $activity->completed_at = Carbon::now();
        $activity->save();

        return redirect("/")->with("success", "Aktivitas selesai ~");
    }


    function destroy($id) {
        $activity = Activity::findOrFail($id);
        if($activity->user_id != Auth::user()->id){
            abort(404);
        }

        $activity->delete();

        return redirect("/")->with("success", "Aktivitas dihapus ~");
    }
}
