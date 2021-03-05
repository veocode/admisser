<?php

namespace App\Http\Controllers;

use App\Models\StudentProfile;
use Illuminate\Http\Request;

class StudentProfileController extends Controller
{

    public function index()
    {
        $sort = request()->get('sort', 'id');
        $order = request()->get('order', 'desc');

        $profiles = StudentProfile::orderBy($sort, $order); //where('type', 11);

        $f = request()->get('f');
        if (!empty($f)){
            $schema = StudentProfile::getFieldsSchema();
            foreach($f as $field=>$value){
                if (is_null($value)) { continue; }
                if (is_string($schema[$field])) {
                    $profiles = $profiles->where($field, 'LIKE', "%$value%");
                } else {
                    $profiles = $profiles->where($field, $value);
                }
            }
        }

        $profiles = $profiles->paginate(20);

        $links = $profiles->appends(['sort' => $sort, 'order' => $order])->links();

        return view('profiles', compact('profiles', 'links', 'sort', 'order'));
    }

    public function create(Request $request)
    {
        $profile = new StudentProfile();

        $profile->fill([
            'type' => $request->get('type'),
            'gender' => 'm'
        ]);

        return view('forms/student_profile', [
            'action' => 'create',
            'profile' => $profile
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'phone' => 'required',
            'type' => 'required|in:9,11',
            'gender' => 'required|in:m,f',
        ]);

        StudentProfile::create($request->all());

        return redirect()->route('homepage')->with('success', 'Анкета успешно отправлена. Ожидайте звонка.');
    }

    public function show(StudentProfile $studentProfile)
    {
        return view('profile', [
            'profile' => $studentProfile,
            'fields' => StudentProfile::getFieldsSchema()
        ]);
    }

    public function edit(StudentProfile $studentProfile)
    {
        return view('forms/student_profile', [
            'action' => 'edit',
            'profile' => $studentProfile
        ]);
    }

    public function update(Request $request, StudentProfile $studentProfile)
    {
        $request->validate([
            'name' => 'required',
            'type' => 'required|in:9,11',
            'gender' => 'required|in:m,f',
        ]);

        $studentProfile->update($request->all());

        return redirect()->route('dashboard')->with('success', 'Анкета #'.$studentProfile->id.' успешно изменена');
    }

    public function destroy(StudentProfile $studentProfile)
    {
        $studentProfile->delete();
        return redirect()->back()->with('success', 'Анкета успешно удалена');
    }
}
