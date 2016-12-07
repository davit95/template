<?php

namespace App\Http\Controllers;

use App\Datatable;
use App\Http\Requests;
use Illuminate\Http\Request;
use Datatables;

class EditableDataTablesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return view('admin.examples.editable_table');
    }

    public function data()
    {
        $tables = Datatable::get(['id','username', 'fullname','points','notes']);

        return Datatables::of($tables)
            ->add_column('edit', '<a class="edit" href="javascript:;">Edit</a>')
            ->add_column('delete', '<a class="delete" href="#" data-target="#deleteConfirmModal" data-toggle="modal">Delete</a>')
            ->make(true);
    }

    public function store(Request $request)
    {
        if($request->ajax()) {
            Datatable::create($request->except('_token'));
        }
    }

    public function update(Request $request, $id)
    {
        $table = Datatable::find($id);

        $table->update($request->except('_token'));
        return $table->id;

    }

    public function destroy($id)
    {
        $row=Datatable::find($id);
        $row->delete();
        return $row->id;
    }
}
