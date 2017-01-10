<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Asset;

class AssetController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $assets = Asset::oldest('created_at')->paginate(20);
        $assets = count($assets) ? $assets : null;
        return view('asset.index', compact('assets'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Asset $asset)
    {

        unlink(public_path($asset->path));
        $asset->delete();

        return redirect()->action('AssetController@index')->with([
            'message' => trans('asset.flash_message.delete'),
            'status' => 'success'
        ]);
    }
}
