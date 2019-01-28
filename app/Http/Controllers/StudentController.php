<?php

namespace App\Http\Controllers;

use Alert;
use App\User;
use App\Career;
use App\Student;
use App\Teacher;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Helpers\DeleteHelper;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class StudentController extends Controller
{
    /**
     * Mostrando una lista con todos los alumnos registrados.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tutor = DB::table('users')
            ->select("users.title","users.first_name","users.last_name","users.second_last_name")
            ->where('users.id','=',Auth::user()->id)
            ->first();

        $students = DB::table('students')
            ->join('users', 'students.user_id', '=', 'users.id')
            ->join('careers', 'careers.id', '=', 'students.career_id')
            ->join('users as tutors', 'students.tutor_user_id', '=', 'tutors.id')
            ->select(
                'users.first_name as userFirstName',
                'users.last_name as userLastName',
                'users.second_last_name as userSecondName',
                'students.*',
                'careers.name as careerName',
                'careers.abbreviation as careerAbbreviation',
                'careers.id as career_id',
                'users.university_id as university_id',
                'users.id as id',
                'users.image_url as image',
                'users.deleted as deleted',
                'tutors.university_id as tutorUniversityId',
                'tutors.title as title',
                'tutors.first_name as tutorFirstName',
                'tutors.last_name as tutorLastName',
                'tutors.second_last_name as tutorSecondName'
            );

        if (Auth::user()->type==1) {
            $students=$students->get();
        } elseif(Auth::user()->type==2){
            $students=$students->where('users.deleted','=','0')->get();
        }else {
            $students=$students->where('students.tutor_user_id', '=', Auth::user()->id)->get();
        }

        return view('students.list')
            ->with('students', $students)
            ->with('tutor', $tutor)
            ->with('title', 'Listado de Alumnos');
    }

    /**
     * Mostrar los detalles del alumno solicitado.
     *
     * @param  integer  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //Consulta para traer los detalles de un alumno
        $student = DB::table('students')
            ->join('users', 'students.user_id', '=', 'users.id')
            ->join('users as tutors', 'students.tutor_user_id', '=', 'tutors.id')
            ->join('careers', 'students.career_id', '=', 'careers.id')
            ->select(
                'careers.*',
                'students.*',
                'users.first_name',
                'users.last_name',
                'users.second_last_name',
                'users.email',
                'users.university_id',
                'users.id as user_id',
                'users.image_url as image',
                'tutors.title as title',
                'tutors.first_name as tutorFirstName',
                'tutors.last_name as tutorLastName',
                'tutors.second_last_name as tutorSecondName',
                'users.image_url as image',
                'users.university_id as user_university_id',
                'tutors.university_id as tutor_university_id'
            )
            ->where('users.university_id', '=', $id)
            ->first();

        //Retorna a la vista de detalles de alumno
        return view('students.show', compact('student'));
    }

    /**
     * Creando un nuevo alumno.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //Consulta para traer todas los tutores registrados
        $tutors = DB::table('teachers')
            ->join('users', 'users.id', '=', 'teachers.user_id')
            ->select('users.*', 'users.id as num_employee')
            ->where('users.type', '=', 5)
            ->where('users.deleted', '=', 0)
            ->get();

        //Consulta para traer todas las carreras registradas
        $careers = Career::all()->where('id', '!=', '4294967295')->where('deleted', '=', 0);

        return view('students.create', compact('tutors', 'careers'));
    }

    /**
     * Almacenando un nuevo alumno en la base de datos
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Validaciones requeridas para el almacenamiento de un alumno
        $data = request()->validate([
          'id' => 'required|max:4294967294|min:1|numeric',
          'matricula' => 'required|min:1|max:matricula|numeric',
          'name' => 'required|max:60',
          'last_name' => 'required|max:60',
          'username' => 'required|max:128',
          'password' => 'required|max:128',
          'username' => 'required|max:128',
          'career_id' => 'required',
          'tutor_user_id' => 'required',
        ], [
          'id.required' => ' * Este campo es obligatorio.',
          'id.max' => ' * El valor máximo de este campo es 4294967294.',
          'id.min' => ' * El valor mínimo de este campo es 1.',
          'id.numeric' => ' * Este campo es de tipo numérico.',
          'matricula.required' => ' * Este campo es obligatorio.',
          'matricula.max' => ' * El valor máximo de este campo es 4294967294.',
          'matricula.min' => ' * El valor mínimo de este campo es 1.',
          'matricula.numeric' => ' * Este campo es de tipo numérico.',
          'name.required' => ' * Este campo es obligatorio.',
          'name.max' => ' * Este campo debe contener sólo 60 caracteres.',
          'last_name.required' => ' * Este campo es obligatorio.',
          'last_name.max' => ' * Este campo debe contener sólo 60 caracteres.',
          'username.required' => ' * Este campo es obligatorio.',
          'username.max' => ' * Este campo debe contener sólo 128 caracteres.',
          'password.required' => ' * Este campo es obligatorio.',
          'password.max' => ' * Este campo debe contener sólo 128 caracteres.',
          'career_id.required' => ' * Este campo es obligatorio.',
          'tutor_user_id.required' => ' * Este campo es obligatorio.',
        ]);

        //Insercion de un usuario con la informacion del estudiante, se registra en la tabla de usuarios
        $user = new User;
        $user->id = Input::get('id');
        $user->university_id = Input::get('matricula');
        $user->first_name = Input::get('name');
        $user->last_name = Input::get('last_name');
        $user->second_last_name = Input::get('second_last_name');
        $user->username = Input::get('username');
        $user->password = bcrypt(Input::get('password'));
        $user->email = Input::get('username')."@upv.edu.mx";
        $user->type = 3;

        $image = Input::file('image');
        //Si se ingreso una imagen a guardar, entonces la guarda en storage en la carpeta de students
        if ($image!=null) {
            //Almacenando la imagen del alumno
            $path=$request->file('image')->store('/public/students');
            $user->image_url = 'storage/students/'.$request->file('image')->hashName();
        }

        //Guardando nuevo alumno
        $user->save();

        //Id universitario del alumno
        $university_id = Input::get('matricula');
        //Consulta para obtener el user_id del usuario, el cual sera necesario para la insercion del estudiante
        $user_id = DB::select("SELECT id FROM users WHERE university_id = $university_id");

        //Insercion de un estudiante a partir de la insercion de un usuario
        $student = new Student;
        $student->academic_situation = Input::get('academic_situation');
        $student->career_id = Input::get('career_id');
        $student->tutor_user_id = Input::get('tutor_user_id');
        $student->user_id = $user_id[0]->id;

        if ($user->save() && $student->save()) {
            Alert::success('Exitosamente', 'Alumno Registrado');
            insertToLog(Auth::user()->id, 'added', Input::get('id'), "alumno");

            return redirect()->route('students.list');
        } else {
            Alert::error('No se registro el alumno', 'Error');

            return redirect()->route('students.list');
        }
    }

    /**
     * Mostrar los detalles de un usuario para su edicion en el form.
     *
     * @param  \App\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function edit(Student $student)
    {
        //Consulta para traer todas los tutores registrados
        $tutors = DB::table('teachers')
            ->join('users', 'users.id', '=', 'teachers.user_id')
            ->select(
                'users.*',
                'users.id as num_employee'
            )
            ->where('users.type', '=', 5)
            ->where('users.deleted', '=', 0)
            ->get();

        //Consulta para traer los datos faltantes de la tabla de users
        $user = DB::select("SELECT * FROM users INNER JOIN students on users.id = $student->user_id")[0];

        //Consulta para traer todas las carreras registradas
        $careers = Career::all()->where('id', '!=', '4294967295')->where('deleted', '=', 0);

        return view('students.edit', ['students' => $student], compact('tutors', 'careers', 'user', 'student'));
    }

    /**
     * Actualizar el usuario mandado en la base de datos.
     *
     * @param  \App\Student  $student
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Student $student, Request $request)
    {
        //Validaciones para la actualizacion de un usuario
        $data = request()->validate([
            'university_id' => 'required|min:1|max:university_id|numeric',
            'name' => 'required|max:60',
            'last_name' => 'required|max:60',
            'username' => 'required|max:128',
        ], [
            'university_id.required' => ' * Este campo es obligatorio.',
            'university_id.max' => ' * El valor máximo de este campo es 4294967294.',
            'university_id.min' => ' * El valor mínimo de este campo es 1.',
            'university_id.numeric' => ' * Este campo es de tipo numérico.',
            'name.required' => ' * Este campo es obligatorio.',
            'name.max' => ' * Este campo debe contener sólo 60 caracteres.',
            'last_name.required' => ' * Este campo es obligatorio.',
            'last_name.max' => ' * Este campo debe contener sólo 60 caracteres.',
            'username.required' => ' * Este campo es obligatorio.',
            'username.max' => ' * Este campo debe contener sólo 128 caracteres.',
        ]);

        //Atributos para actualizar registro en la tabla de usuarios
        $user_id = Input::get('user_id');

        $university_id = Input::get('university_id');

        $image = Input::file('image');
        $image2 = Input::get('image_2');

        $first_name = Input::get('name');
        $last_name = Input::get('last_name');
        $second_last_name = Input::get('second_last_name');
        $email = Input::get('username')."@upv.edu.mx";
        $username = Input::get('username');

        //Atributos para actualizar registro en la tabla de students
        $student->academic_situation = Input::get('academic_situation');
        $student->career_id = Input::get('career_id');
        $student->tutor_user_id = Input::get('tutor_user_id');
        //$student->user_id = $user_id;
        $student->update();

        //Si el estudiante cambia la contraseña, se actualiza, es caso contrario se queda como estaba guardada
        if (Input::get('password') != null) {
            $password = bcrypt(Input::get('password'));
            DB::update('UPDATE users SET password = ? WHERE id = ?', [$password, $user_id]);
        }

        //Actualizar foto, elimina la anterior
        if ($image!=null) {
            if ($image2!='storage/no_image.png') {
                unlink(public_path()."/".$image2);
            }
            $path=Input::file('image')->store('/public/students');
            $image_url = 'storage/students/'.Input::file('image')->hashName();
            DB::update('UPDATE users SET image_url = ? WHERE id = ?', [$image_url, $user_id]);
        }

        //Condicion para actualizar el registro de la tabla de usuarios cuando ya se haya realizado el update a la tabla de students
        if ($student->update()) {
            DB::update('UPDATE users SET university_id = ?, first_name = ?, last_name = ?, second_last_name = ?, email = ?, username = ? WHERE id = ?', [$university_id, $first_name, $last_name, $second_last_name, $email, $username, $user_id]);
            Alert::success('Exitosamente', 'Alumno Modificado');
            insertToLog(Auth::user()->id, 'updated', Input::get('user_id'), "alumno");

            return redirect()->route('students.list');
        } else {
            Alert::error('No se modifico el alumno', 'Error');

            return redirect()->route('students.list');
        }
    }

    /**
     * Eliminar(de manera logica) el alumno.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Student $student)
    {
        //Eliminando el alumno de manera logica y todo lo que este relacionado con el
        if (DeleteHelper::instance()->onCascadeLogicalDelete('users', 'id', $student->user_id));
        Alert::success('Exitosamente', 'Alumno Eliminado');
        insertToLog(Auth::user()->id, 'deleted', $student->user_id, "alumno");

        return redirect()->route('students.list');
    }

    /**
     * Restaurar(de manera logica) el alumno.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function restore(Request $request)
    {
        //Restaurando de manera logica el alumno.
        if (DeleteHelper::instance()->restoreLogicalDelete('users', 'id', $request->id));
        Alert::success('Exitosamente', 'Alumno Restaurado');

        insertToLog(Auth::user()->id, 'recover', $request->id, "alumno");

        return redirect()->route('students.list');
    }
}
