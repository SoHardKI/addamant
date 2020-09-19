<?php

namespace App\Http\Controllers;

use App\Manufacturer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ManufacturerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('manufacturers.index', ['manufacturers' => Manufacturer::all()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('manufacturers.create');
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

        Manufacturer::create($request->input());

        return redirect()->route('manufacturers.index');
    }

    /**
     * @param Manufacturer $manufacturer
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Manufacturer $manufacturer)
    {
        return view('manufacturers.edit', compact('manufacturer'));
    }

    /**
     * @param Request $request
     * @param Manufacturer $manufacturer
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Manufacturer $manufacturer)
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

        $manufacturer->update($request->input());

        return redirect()->route('manufacturers.index');
    }

    /**
     * @param Manufacturer $manufacturer
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(Manufacturer $manufacturer)
    {
        $manufacturer->delete();

        return redirect()->route('manufacturers.index');
    }
}
