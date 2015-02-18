<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

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

        return view('notices.create');
    }
}
