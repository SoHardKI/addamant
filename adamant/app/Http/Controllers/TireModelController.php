<?php

namespace App\Http\Controllers;

use App\TireModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TireModelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('tire-models.index', ['tire_models' => TireModel::all()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('tire-models.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->input(),
            [
                'name' => 'string|required',
            ]
        );

        if ($validator->fails()) {
            return back()->withInput($request->input())->withErrors($validator->getMessageBag()->getMessages());
        }

        TireModel::create($request->input());

        return redirect()->route('tire-models.index');
    }

    /**
     * @param TireModel $tire_model
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(TireModel $tire_model)
    {
        return view('tire-models.edit', compact('tire_model'));
    }

    /**
     * @param Request $request
     * @param TireModel $tireModel
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, TireModel $tireModel)
    {
        $validator = Validator::make(
            $request->input(),
            [
                'name' => 'string|required',
            ]
        );

        if ($validator->fails()) {
            return back()->withInput($request->input())->withErrors($validator->getMessageBag()->getMessages());
        }

        $tireModel->update($request->input());

        return redirect()->route('tire-models.index');
    }

    /**
     * @param TireModel $tireModel
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(TireModel $tireModel)
    {
        $tireModel->delete();

        return redirect()->route('tire-models.index');
    }
}
