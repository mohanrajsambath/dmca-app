<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Http\Requests\PrepareNoticeRequest;
use App\Provider;
use Illuminate\Contracts\Auth\Guard;
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

    public function confirm(PrepareNoticeRequest $request, Guard $auth) {

        $data = $request->all();

        $template = $this->compileDmcaTemplate($data, $auth);

        session()->flash('dmca', $data);

        return view('notices.confirm', compact('template'));
    }

    public function store() {

        $data = session()->get('dmca');

        return $data;
    }

    /**
     * @param $data
     * @param Guard $auth
     * @return mixed
     */
    private function compileDmcaTemplate($data, Guard $auth)
    {
        $data = $data + [
                    'name' => $auth->user()->name,
                    'email' => $auth->user()->email,
                ];

        return view()->file(app_path('Http/Templates/dmca.blade.php'), $data);
    }
}
