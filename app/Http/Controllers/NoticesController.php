<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Http\Requests\PrepareNoticeRequest;
use App\Notice;
use App\Provider;
use Auth;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;

class NoticesController extends Controller {


    function __construct()
    {
        $this->middleware('auth');
    }

    public function index() {

        return Auth::user()->notices;
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

    public function store(Request $request) {

        $this->createNotice($request);

        return redirect('notices');
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

    /**
     * @param Request $request
     */
    private function createNotice(Request $request)
    {
        $data = session()->get('dmca');

        $notice = Notice::open($data)->useTemplate($request->input('template'));

        Auth::user()->notices()->save($notice);
    }
}
