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
        $previousData = "";
        $nextData = "";
        $date = request()->query('date', ''); 

        if ($date != ""){

            try {
                if(!Auth::user()){
                    abort(404);
                }
                
                $formattedDate = Carbon::createFromFormat('d-m-Y', $date)->format('Y-m-d');
            } catch (\Throwable $th) {
                abort(404);
            } 
            
            $activities = Activity::where("user_id", Auth::user()->id)->whereDate("created_at", $formattedDate)->get();

            if(count($activities) < 1){
                abort(404);
            }
            

        } elseif (Auth::user()){
            $activities = Activity::where("user_id", Auth::user()->id)->whereDate("created_at", Carbon::today())->get();
        }


        if(Auth::user()){
            $timeNow = count($activities) < 1 ? Carbon::today() : $activities->first()->created_at;


            // GET PREVIOUS DATE DATA 
            $latestPreviousDate = Activity::where("user_id", Auth::user()->id)
            ->whereDate("created_at", "<", $timeNow)
            ->orderBy("created_at", "desc")
            ->value("created_at");
        
            $previousData = Activity::where("user_id", Auth::user()->id)
                ->whereDate("created_at", $latestPreviousDate)
                ->get(); 


            // GET NEXT DATE DATA 
            $latestNextDate = Activity::where("user_id", Auth::user()->id)
            ->whereDate("created_at", ">", $timeNow)
            ->orderBy("created_at", "asc")
            ->value("created_at");


            $nextData = Activity::where("user_id", Auth::user()->id)
            ->whereDate("created_at", $latestNextDate)
            ->get();


            if ($nextData->isEmpty() && $activities->isNotEmpty() && $activities->first()->created_at->format("d-m-Y") != Carbon::now()->format("d-m-Y")) {
                $nextData = collect([
                    (object) [
                        "created_at" => Carbon::now(),
                    ]
                ]);
            }

        }


        return view("index", compact('activities', 'previousData', 'nextData'));
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
        if($activity->user_id != Auth::user()->id || $activity->completed_at || $activity->created_at->format("d-m-Y") != Carbon::now()->format("d-m-Y")){
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
