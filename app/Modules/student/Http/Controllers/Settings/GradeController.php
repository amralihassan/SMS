<?php

namespace Student\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use Student\Http\Requests\GradeRequest;
use Student\Models\Settings\Grade;
use Student\Models\Settings\Operations\GradeOp;
use Student\Models\Settings\Operations\StageOp;

class GradeController extends Controller
{
    public function __construct()
    {
        // $this->middleware('permission:view-grade', ['only' => ['index']]);
        // $this->middleware('permission:add-grade', ['only' => ['create', 'store']]);
        // $this->middleware('permission:edit-grade', ['only' => ['edit', 'update']]);
        // $this->middleware('permission:delete-grade', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $data = GradeOp::_fetchAll();
            return $this->dataTable($data);
        }
        return view('student::settings.grades.index');
    }

    private function dataTable($data)
    {
        return datatables($data)
            ->addIndexColumn()
            ->addColumn('action', function ($data) {
                return '<a class="btn btn-warning btn-sm" href="' . route('grades.edit', $data->id) . '">
                        <i class="la la-edit"></i>
                    </a>';
            })
            ->addColumn('grade_name', function ($data) {
                return $data->grade_name;
            })
            ->addColumn('stage_name', function ($data) {
                return $data->stage_name;
            })
            ->addColumn('check', function ($data) {
                return '<label class="pos-rel">
                                <input type="checkbox" class="ace" name="id[]" value="' . $data->id . '" />
                                <span class="lbl"></span>
                            </label>';
            })
            ->rawColumns(['action', 'check', 'grade_name', 'stage_name'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $grade = new Grade();
        $stages = StageOp::_fetchAll();
        return view('student::settings.grades.create', compact('grade', 'stages'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(GradeRequest $request)
    {
        GradeOp::_store($request);
        toastr()->success(trans('local.saved_success'));
        return redirect()->route('grades.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $grade = GradeOp::_fetchById($id);
        $stages = StageOp::_fetchAll();
        return view('student::settings.grades.edit', compact('grade', 'stages'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(GradeRequest $request, $id)
    {
        GradeOp::_update($request, $id);
        toastr()->success(trans('local.updated_success'));
        return redirect()->route('grades.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        if (request()->ajax()) {
            if (request()->has('id')) {
                $status = GradeOp::_destroy(request('id'));
            }
        }
        return response(['status' => $status]);
    }
}
