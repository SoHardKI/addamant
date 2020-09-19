<?php

namespace App\Http\Controllers;

use App\Services\ReaderService\Classes\XlsxReader;
use App\Tire;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class TireController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tires = Tire::where(['manual_distribution' => 0])->get();
        $manualDistributionTires = Tire::where(['manual_distribution' => 1])->get();

        return view('tires.index', compact('tires', 'manualDistributionTires'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('tires.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->input(),
            [
                'width' => 'int',
                'profile' => 'int',
                'diameter' => 'string',
                'load_index' => 'int',
                'speed_index' => 'string',
                'count' => 'int',
                'price' => 'int',
                'tire_model_id' => 'int',
                'manufacturer_id' => 'int'
            ]
        );

        if ($validator->fails()) {
            return back()->withInput($request->input())->withErrors($validator->getMessageBag()->getMessages());
        }

        Tire::create($request->input());

        return redirect()->route('tires.index');
    }

    /**
     * @param Tire $tire
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Tire $tire)
    {
        return view('tires.edit', compact('tire'));
    }

    /**
     * @param Request $request
     * @param Tire $tire
     */
    public function update(Request $request, Tire $tire)
    {
        $validator = Validator::make(
            $request->input(),
            [
                'width' => 'int',
                'profile' => 'int',
                'diameter' => 'string',
                'load_index' => 'int',
                'speed_index' => 'string',
                'count' => 'int',
                'price' => 'int',
                'tire_model_id' => 'int',
                'manufacturer_id' => 'int'
            ]
        );

        if ($validator->fails()) {
            return back()->withInput($request->input())->withErrors($validator->getMessageBag()->getMessages());
        }

        $tire->update($request->input());

        return redirect()->route('tires.index');
    }

    /**
     * @param Tire $tire
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(Tire $tire)
    {
        $tire->delete();

        return redirect()->route('tires.index');
    }

    /**
     * Загрузка файла
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function uploadFromFile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
        ]);

        if ($request->file) {
            $validator = Validator::make($request->all(), [
                'file' => 'required|mimes:csv,xlx,xlsx|max:100',
            ]);
        }

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->getMessageBag()->getMessages()]);
        }

        $file = $request->file('file');
        $service = new XlsxReader($request->name, $file->path());
        $service->readFile($file->path());

        return response()->json(['success' => 'Файл загружен.']);
    }

    /**
     * Метод получения прогресса обработки файла
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getProgress(Request $request)
    {
        $progress = 0;
        if (File::exists(storage_path() . "/app/public/$request->name")) {
            $progress = File::get(storage_path() . "/app/public/$request->name");
            if ($progress == 100) {
                Storage::disk('public')->delete($request->name);
            }
        }

        return response()->json(['progress' => $progress]);
    }
}
