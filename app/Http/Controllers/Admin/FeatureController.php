<?php

namespace App\Http\Controllers\Admin;

use App\Models\Feature;
use App\Models\Boarding;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\Admin\ValidateFeatureRequest;

class FeatureController extends Controller
{
    public function store(ValidateFeatureRequest $request,Boarding $Boarding ): RedirectResponse
    {
        $Boarding->features()->create($request->validated());

        return redirect()->route('admin.properties.edit', $Boarding->id)->with([
            'message' => 'successfully created !',
            'alert-type' => 'success'
        ]);
    }

    public function edit(Boarding $Boarding, Feature $feature): View
    {
        abort_if(Gate::denies('Boarding_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        if($Boarding->agent->name != auth()->user()->name && auth()->user()->roles()->where('title', 'agent')->count() > 0){
            abort(403);
         }
         
        return view('admin.features.edit', compact('feature', 'Boarding'));
    }

    public function update(ValidateFeatureRequest $request,Boarding $Boarding, Feature $feature): RedirectResponse
    {
        $Boarding->features()->update($request->validated());

        return redirect()->route('admin.properties.edit', $Boarding->id)->with([
            'message' => 'successfully updated !',
            'alert-type' => 'info'
        ]);
    }

    public function destroy(Boarding $Boarding,Feature $feature): RedirectResponse
    {
        abort_if(Gate::denies('Boarding_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        if($Boarding->agent->name != auth()->user()->name && auth()->user()->roles()->where('title', 'agent')->count() > 0){
            abort(403);
         }

        $feature->delete();

        return back()->with([
            'message' => 'successfully deleted !',
            'alert-type' => 'danger'
        ]);
    }
}
