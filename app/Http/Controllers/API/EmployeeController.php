<?php

namespace App\Http\Controllers\API;

use App\Models\Employee;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(Employee::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|unique:employees,email',
            'phone' => 'required|unique:employees,phone',
            'address' => 'required',
            'salary' => 'required',
            'date_of_joining' => 'required',
            'photo' => 'required',
        ]);

        $position = strpos($request->photo, ';');
        $sub = substr($request->photo, 0, $position);
        $ext = explode('/', $sub)[1];
        $name = time() . '.' . $ext;
        $img = Image::make($request->photo)->resize(300, 300);
        $path = 'assets/img/employee/' . $name;
        $img->save($path);

        $employee = new Employee();
        $employee->name = $request->name;
        $employee->email = $request->email;
        $employee->address = $request->address;
        $employee->salary = $request->salary;
        $employee->phone = $request->phone;
        $employee->date_of_joining = $request->date_of_joining;
        $employee->photo = $name;
        $employee->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $employee = Employee::findOrFail($id);

        return response()->json($employee);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|unique:employees,email,' . $id,
            'phone' => 'required|unique:employees,phone,' . $id,
            'address' => 'required',
            'salary' => 'required',
            'date_of_joining' => 'required',
            'photo' => 'required',
        ]);

        $position = strpos($request->photo, ';');
        $sub = substr($request->photo, 0, $position);
        $ext = explode('/', $sub)[1];
        $name = time() . '.' . $ext;
        $img = Image::make($request->photo)->resize(300, 300);
        $path = 'assets/img/employee/' . $name;
        $img->save($path);

        $employee = Employee::findOrFail($id);

        unlink(public_path('assets/img/employee/' . $employee->photo));

        $employee->name = $request->name;
        $employee->email = $request->email;
        $employee->address = $request->address;
        $employee->salary = $request->salary;
        $employee->phone = $request->phone;
        $employee->date_of_joining = $request->date_of_joining;
        $employee->photo = $name;
        $employee->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $employee = Employee::findOrFail($id);

        if ($employee->photo) {
            unlink(public_path('assets/img/employee/' . $employee->photo));
        }

        $employee->delete();
    }
}
