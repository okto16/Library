<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Transaction;
use Illuminate\Http\Request;

class Membercontroller extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if (auth()->user()->hasRole('petugas')){
            if ($request->ajax()) {
                if ($request->gender) {
                    $datas = Member::where('gender', $request->gender)->get();
            } else {
                $datas = Member::all();
            }
            
            $datatables = datatables()->of($datas)->addIndexColumn();
            return $datatables->make(true);
        }
        return view('admin.member.index');
    }else{
                return abort(403);
            }
    }

    public function api()
    {
        $members = Member::all();
        $datatables = datatables()->of($members)
            ->addColumn('date', function ($members) {
                return convert_date($members->created_at);
            })->addIndexColumn();
        return $datatables->make(true);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.member.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => ['required', 'string', 'max:255'],
            'gender' => ['required'],
            'phone_number' => ['required'],
            'email' => ['required'],
            'address' => ['required'],
        ]);
        Member::create($request->all());
        return redirect('members');
    }

    /**
     * Display the specified resource.
     */
    public function show(Member $member)
    {
        return view('admin.member.show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Member $member)
    {
        return view('admin.member.edit', compact('member'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Member $member)
    {
        $this->validate($request, [
            'name' => ['required', 'string', 'max:255'],
            'gender' => ['required'],
            'phone_number' => ['required'],
            'email' => ['required', 'unique:members,email,' . $member->id],
            'address' => ['required'],
        ]);
        $member->update($request->all());
        return redirect('members');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Member $member)
    {
        $member->delete();
        return redirect('members');
    }
}
