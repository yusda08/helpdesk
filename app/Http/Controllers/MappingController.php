<?php

namespace App\Http\Controllers;

use App\Helpers\HelperResponse;
use App\Models\UnitKerjaApik;
use App\Models\User;
use App\Models\UserMap;
use Illuminate\Http\Request;

class MappingController extends Controller
{
    public function index()
    {
        $get['users'] = User::where('level_id', '2')->get();
        return view('mapping.index', $get);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        try {
            $codes = $request->post('unit_kerja_kode');
            $units = UnitKerjaApik::whereIn('unit_kerja_kode', $codes)->get();
            $data = [];
            foreach ($units as $unit) {
                $dt['user_id'] = $request->post('user_id');
                $dt['unit_kerja_kode'] = $unit['unit_kerja_kode'];
                $dt['unit_kerja_nama'] = $unit['unit_kerja_nama'];
                $data[] = $dt;
            }
            UserMap::insert($data);
            $response = HelperResponse::getStatusTrue('Success');
        } catch (\Exception $exception) {
            $response = HelperResponse::getStatusFalse($exception->getMessage());
        }
        $this->setFlash($response['message'], $response['status']);
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
