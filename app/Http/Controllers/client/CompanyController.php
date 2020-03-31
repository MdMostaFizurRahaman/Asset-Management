<?php

namespace App\Http\Controllers\client;

use App\ClientCompany;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class CompanyController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:web');
    }

    public function index($subdomain, Request $request)
    {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['client-companies-read'])) {
            $companies = ClientCompany::where('client_id', Auth::user()->client_id);

            if ($request->get('title')) {
                $companies->where('title', 'LIKE', '%' . $request->get('title') . '%');
            }

            $companies = $companies->orderBy('title', 'ASC')->paginate(50);
            return view('client.companies.index', compact('companies', 'subdomain'));
        } else {
            return view('error.client-unauthorised', compact('subdomain'));
        }
    }

    public function create($subdomain)
    {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['client-companies-create'])) {
            return view('client.companies.create', compact('subdomain'));
        } else {
            return view('error.client-unauthorised', compact('subdomain'));
        }
    }

    public function store($subdomain, Request $request)
    {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['client-companies-create'])) {
            $messages = [
                'title.required' => 'Company Title is required.',
                'title.unique' => 'Company Title already exist.',
            ];

            $this->validate($request, [
                'title' => [
                    'required',
                    Rule::unique('client_companies')->where('client_id', Auth::user()->client_id)->whereNull('deleted_at'),
                ],
            ], $messages);

            $input = $request->all();

            $input['user_id'] = Auth::user()->id;
            $input['client_id'] = Auth::user()->client_id;

            ClientCompany::create($input);

            Session::flash('success', 'The Company has been created');

            return redirect()->route('client.companies.index', $subdomain);
        } else {
            return view('error.client-unauthorised', compact('subdomain'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($subdomain, $id)
    {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['client-companies-update'])) {
            $company = ClientCompany::find($id);
            return view('client.companies.edit', compact('company', 'subdomain'));
        } else {
            return view('error.client-unauthorised', compact('subdomain'));
        }
    }

    /**
     * Update a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function update($subdomain, Request $request, $id)
    {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['client-companies-update'])) {
            $rules = [
                'title' => [
                    'required',
                    Rule::unique('client_companies')->where('client_id', Auth::user()->client_id)->whereNull('deleted_at')->ignore($id),
                ],
            ];

            $messages = [
                'title.required' => 'Company Title is required.',
                'title.unique' => 'Company Title already exist.',
            ];

            $this->validate($request, $rules, $messages);

            $input = $request->all();
            $input['user_id'] = Auth::user()->id;

            if (!$request->has('status')) {
                $input['status'] = 0;
            }

            $company = ClientCompany::find($id);
            $company->update($input);

            Session::flash('success', 'The Company has been updated');

            return redirect()->route('client.companies.index', $subdomain);
        } else {
            return view('error.client-unauthorised', compact('subdomain'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($subdomain, $id)
    {
        if (Auth::user()->hasRole('admin') || Auth::user()->can(['client-companies-delete'])) {
            $company = ClientCompany::find($id);

            $company->update([
                'user_id' => Auth::user()->id,
            ]);

            $company->delete();

            Session::flash('success', 'The Company has been deleted');

            return redirect()->route('client.companies.index', $subdomain);
        } else {
            return view('error.client-unauthorised', compact('subdomain'));
        }
    }

}
