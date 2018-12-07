<?php

namespace App\Http\Controllers\Sign;

use App\Components\Sign\Models\Sign;
use App\Components\Sign\Repositories\SignsRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SignsController extends SignController
{
    /** @var  SignsRepository */
    private $signsRepository;

    public function __construct(SignsRepository $signsRepo)
    {
        $this->signsRepository = $signsRepo;
    }

    /**
     * Display a listing of the signs.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $signs = Sign::search($request->keword ?? '')
            ->paginate($request->per_page ?? 10);
        $signs->load('user');

        return $this->sendResponseOk($signs,"list signs ok.");
    }

    /**
     * Show the form for creating a new signs.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('signs.create');
    }

    /**
     * Store a newly created signs in storage.
     *
     * @param int $id
     * @param Request $request
     *
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        $validate = validator($request->all(),[
            'company' => 'required',
            'day' => 'required',
            'phone' => 'required',
            'email' => 'required',
        ]);

        $userId = Auth::id();

        $request->request->add([ 'mb_id' => $userId ]);

        if($validate->fails()) return $this->sendResponseBadRequest($validate->errors()->first());

        /** @var Sign $sign */
        $sign = $this->signsRepository->create($request->all());

        if(!$sign) return $this->sendResponseBadRequest("Failed create.");

        return $this->sendResponseCreated($sign);
    }

    /**
     * Display the specified signs.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $sign = $this->signsRepository->find($id);

        if(!$sign) return $this->sendResponseNotFound();

        return $this->sendResponseOk($sign);
    }

    /**
     * Show the form for editing the specified signs.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $signs = $this->signsRepository->findWithoutFail($id);

        if (empty($signs)) {

            return redirect(route('signs.index'));
        }

        return view('signs.edit')->with('signs', $signs);
    }

    /**
     * Update the specified signs in storage.
     *
     * @param  int $id
     * @param Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function update($id, Request $request)
    {
        $validate = validator($request->all(),[
            'company' => 'required',
            'day' => 'required',
            'phone' => 'required',
            'email' => 'required',
        ]);

        if($validate->fails()) return $this->sendResponseBadRequest($validate->errors()->first());

        $updated = $this->signsRepository->update($id,$request->all());

        if(!$updated) return $this->sendResponseBadRequest("Failed update.");

        return $this->sendResponseUpdated();
    }

    /**
     * Remove the specified signs from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // do not delete self

        $User = \Auth::user();

        If(!$User->isSuperUser()) return $this->sendResponseForbidden();

        try {
            $this->signsRepository->delete($id);
        } catch (\Exception $e) {
            return $this->sendResponseBadRequest("Failed to delete");
        }

        return $this->sendResponseDeleted();
    }

}
