<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ActivityController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->input('perPage', 10);
        $activities = Activity::with('user')->orderBy('created_at', 'desc')->paginate($perPage);
        $activities->each(function ($activity) {
            $activity->start_date = Carbon::parse($activity->start_date)->format('d-m-Y');
            $activity->end_date = Carbon::parse($activity->end_date)->format('d-m-Y');
        });
        return view("activity.index", compact('activities', 'perPage'));
    }

    public function create()
    {
        $activity = new Activity();
        return view("activity.create", compact('activity'));
    }

    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|unique:activities,name|string|max:100',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'description' => 'nullable|string|max:150',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        Activity::create([
            'name' => $request->name,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'description' => $request->description,
            'user_id' => Auth::id(),
        ]);

        return redirect("/activities")->with('success', __('word.activity.alert.store'));
    }

    public function edit(string $activity_uuid)
    {
        $activity = Activity::where('activity_uuid', $activity_uuid)->firstOrFail();

        return view("activity.edit", compact('activity'));
    }

    public function update(Request $request, string $activity_uuid)
    {
        $activity = Activity::where('activity_uuid', $activity_uuid)->firstOrFail();
        $rules = [
            'name' => 'required|string|max:100|unique:activities,name,' . $activity->activity_uuid . ',activity_uuid',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'description' => 'nullable|string|max:150',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $activity->update([
            'name' => $request->name,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'description' => $request->description,
        ]);
        return redirect("/activities")->with('success', __('word.activity.alert.update'));
    }

    public function destroy(string $activity_uuid)
    {
        try {
            $activity = Activity::where('activity_uuid', $activity_uuid)->first();
            if ($activity) {
                $activity->delete();
                return response()->json([
                    'type' => 'success',
                    'title' => __('word.general.success'),
                    'msg' => __('word.activity.delete_success'),
                    'redirect' => route('activities.index')
                ], 200);
            } else {
                return response()->json([
                    'type' => 'error',
                    'title' => __('word.general.error'),
                    'msg' => __('word.general.not_found'),
                ], 404);
            }
        } catch (\Exception $e) {
            return response()->json([
                'type' => 'error',
                'title' => __('word.general.error'),
                'msg' => __('word.general.bad_request'),
            ], 500);
        }
    }
    public function disable(string $activity_uuid)
    {
        $activity = Activity::where('activity_uuid', $activity_uuid)->firstOrFail();
        $activity->update([
            'status' => false,
        ]);
        return redirect("/activities")->with('success', __('word.activity.alert.disable'));
    }
    public function enable(string $activity_uuid)
    {
        $activity = Activity::where('activity_uuid', $activity_uuid)->firstOrFail();
        $activity->update([
            'status' => true,
        ]);
        return redirect("/activities")->with('success', __('word.activity.alert.enable'));
    }
}
