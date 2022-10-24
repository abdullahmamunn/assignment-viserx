<?php
namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Teacher;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    public function index()
    {
        return view('teacher');
    }

    public function getData()
    {
        $data = Teacher::latest()->get();
        return response()->json($data,200);
    }

    public function createTeacher(Request $request)
    {
        $request->validate([
           'name' => 'required',
           'position' => 'required',
           'phone' => 'required',
        ]);
         $create = new Teacher();
         $create->name = $request->name;
         $create->position = $request->position;
         $create->phone = $request->phone;
         $create->save();
         return response()->json($create,200);
    }

    public function editTeacher($id)
    {
        $edit = Teacher::findOrFail($id);
        return response()->json($edit,200);
    }

    public function updateTeacher(Request $request,$id)
    {
        $request->validate([
            'name' => 'required',
            'position' => 'required',
            'phone' => 'required',
        ]);
        $update_teacher = Teacher::findOrFail($id);
        $update_teacher->name = $request->name;
        $update_teacher->position = $request->position;
        $update_teacher->phone = $request->phone;
        $update_teacher->save();

        return response()->json($update_teacher,200);
    }

    public function deleteTeacher($id)
    {
        $delete = Teacher::destroy($id);
        return response()->json($delete,200);
    }
}


?>
