<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Http\Requests\PrepareNoticeRequest;
use App\Notice;
use App\Provider;
use Auth;
use Debugbar;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Mail;

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

        session()->put('dmca', $data);

        $template = $this->compileDmcaTemplate($data, $auth);

        return view('notices.confirm', compact('template'));
    }

    public function store(Request $request) {

        $notice = $this->createNotice($request);

        Mail::queue('emails.dmca', compact('notice'), function($message) use ($notice) {
            $message->from($notice->getOwnerEmail())
                    ->to($notice->getRecipientEmail())
                    ->subject('DMCA Notice');
        });

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
        $notice = session()->get('dmca') + ['template' => $request->input('template')];

        $notice = Auth::user()->notices()->create($notice);

        return $notice;
    }
}
