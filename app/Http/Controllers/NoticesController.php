<?php

namespace App\Http\Controllers;

use App\Notice;
use App\Provider;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\PrepareNoticeRequest;

class NoticesController extends Controller
{
    /**
     *
     */
    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');
    }

    //
    /**
     * @return string
     */
    public function index()
    {
        $notices =  $this->user->notices()->where('content_removed', 0)->latest()->get();

        return view('pages.notices.index',compact('notices'));
    }

    /**
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $providers = Provider::lists('name', 'id');

        return view('pages.notices.create', compact('providers'));
    }

    public function confirm(PrepareNoticeRequest $request)
    {
        $data = $request->all() + [
                'name' => $this->user->name,
                'email' => $this->user->email
            ];

        session()->flash('dmca', $data);

        $template = view()->file(app_path('Http/Templates/dmca.blade.php'), $data);

        return view('pages.notices.confirm',compact('template'));

    }

    public function store(Request $request)
    {
        $notice = $this->createNotice($request);

        \Mail::queue('emails.dmca', compact('notice'), function($message) use ($notice){
            $message->from($notice->getOwnerEmail())
                ->to($notice->getRecipientEmail())
                ->subject('DMCA Notice');
        });

        flash()->overlay('Συγχαρητήρια', 'This notice has been added successfully.');

        return redirect('notices');

    }

    public function update($notice_id, Request $request){
        $is_removed = $request->has('content_removed');

        Notice::findOrFail($notice_id)->update(['content_removed'=> $is_removed]);

    }

    /**
     * @param Request $request
     */
    private function createNotice(Request $request)
    {
        $data = session()->get('dmca');

        $notices = Notice::open($data)
            ->useTemplates($request->input('template'));

        $notices = $this->user->notices()->save($notices);

        return $notices;
    }
}
