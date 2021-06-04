<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Label;

class LabelController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Label::class, 'label');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $labels = Label::orderBy('id', 'asc')->paginate();
        return view('labels.index', compact('labels'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $label = new Label();
        return view('labels.create', compact('label'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|unique:labels',
            'description' => 'nullable|string'
        ], $messages = [
            'unique' => __('The label name has already been taken'),
        ]);

        $label = new Label();
        $label->fill($data);
        $label->save();
        flash(__('Label has been added successfully'))->success();
        return redirect()->route('labels.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Label  $label
     * @return \Illuminate\View\View
     */
    public function edit(Label $label)
    {
        return view('labels.edit', compact('label'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Label  $label
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Label $label)
    {
        $data = $request->validate([
            'name' => 'required|unique:labels,name,' . $label->id,
            'description' => 'nullable|string'
        ], $messages = [
            'unique' => __('The label name has already been taken'),
        ]);

        $label->fill($data);
        $label->save();
        flash(__('Label has been updated successfully'))->success();
        return redirect()->route('labels.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Label  $label
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Label $label)
    {
        if ($label->tasks()->exists()) {
            flash(__('Failed to delete label'))->error();
        } else {
            $label->delete();
            flash(__('Label has been deleted successfully'))->success();
        }
        return redirect()->route('labels.index');
    }
}
