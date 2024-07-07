<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use App\Models\Boarding;
use Illuminate\Support\Str;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\Admin\ValidateBoardingRequest;
use App\Models\User;

class BoardingController extends Controller
{
   
    public function index(): View
    {
        abort_if(Gate::denies('Boarding_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        if(auth()->user()->roles()->where('title', 'agent')->count() > 0) {
            $properties = Boarding::where('user_id', auth()->id())->get();
        }else {
            $properties = Boarding::all();
        }

        return view('admin.properties.index', compact('properties'));
    }

    public function create(): View
    {
        abort_if(Gate::denies('Boarding_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        
        $categories = Category::get();

        return view('admin.properties.create', compact('categories'));
    }

    public function store(ValidateBoardingRequest $request): RedirectResponse
    {
        abort_if(Gate::denies('Boarding_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $slug = Str::slug($request->name, '-');
        
        $Boarding = Boarding::create($request->validated() + ['slug' => $slug, 'user_id' => auth()->id()]);

        return redirect()->route('admin.properties.edit', $Boarding->id)->with([
            'message' => 'successfully created !',
            'alert-type' => 'success'
        ]);
    }

    public function show(Boarding $Boarding): View
    {
        abort_if(Gate::denies('Boarding_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.properties.show', compact('Boarding'));
    }

    public function edit(Boarding $Boarding): View
    {
         abort_if(Gate::denies('Boarding_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
         if($Boarding->agent->name != auth()->user()->name && auth()->user()->roles()->where('title', 'agent')->count() > 0){
            abort(403);
         }
         $categories = Category::get();

        return view('admin.properties.edit', compact('Boarding', 'categories'));
    }

    public function update(ValidatePropertyRequest $request, Boarding $Boarding): RedirectResponse
    {
        abort_if(Gate::denies('Boarding_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
       
        $slug = Str::slug($request->name, '-');

        $Boarding->update($request->validated() + ['slug' => $slug,'user_id' => auth()->id()]);

        return redirect()->route('admin.properties.index')->with([
            'message' => 'successfully updated !',
            'alert-type' => 'info'
        ]);
    }

    public function destroy(Boarding $Boarding): RedirectResponse
    {
        abort_if(Gate::denies('Boarding_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        if($Boarding->agent->name != auth()->user()->name){
            abort(403);
         }

        $Boarding->delete();

        return back()->with([
            'message' => 'successfully deleted !',
            'alert-type' => 'danger'
        ]);
    }
}
