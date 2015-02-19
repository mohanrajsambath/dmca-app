<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Http\Requests\PrepareNoticeRequest;
use App\Provider;
use Illuminate\Http\Request;

class NoticesController extends Controller {


    function __construct()
    {
        $this->middleware('auth');
    }

    public function index() {

        return 'all notices';
    }

    public function create() {

        $providers = Provider::lists('name', 'id');

        return view('notices.create', compact('providers'));
    }

    public function confirm(PrepareNoticeRequest $request) {

        return $request->all();
    }
}
