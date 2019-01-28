<ul class="pcoded-item pcoded-left-item">
    <li id="dashboard_li" class="">
        <a href="{{ route('dashboard') }}">
            <span class="pcoded-micon"><i class="fa fa-home"></i><b>D</b></span>
            <span class="pcoded-mtext" data-i18n="nav.chat.main">Inicio</span>
            <span class="pcoded-mcaret"></span>
        </a>
    </li>

    <li  id="students_li" class="pcoded-hasmenu {{ explode('.', $view_name)[0]=='students' ? 'active pcoded-trigger' : '' }}">
        <a href="javascript:void(0)">
            <span class="pcoded-micon"><i class="fas fa-user-graduate"></i><b>A</b></span>
            <span class="pcoded-mtext" data-i18n="nav.social.main">Alumnos</span>
            <span class="pcoded-mcaret"></span>
        </a>
        <ul class="pcoded-submenu">
            <li class="{{ Route::currentRouteNamed('students.list') ? 'active' : '' }}">
                <a href="{{ route('students.list') }}">
                    <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                    <span class="pcoded-mtext" data-i18n="nav.social.fb-wall">Listado de Alumnos</span>
                    <span class="pcoded-mcaret"></span>
                </a>
            </li>
            <li class="{{ Route::currentRouteNamed('students.create') ? 'active' : '' }}">
                <a href="{{ route('students.create') }}">
                    <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                    <span class="pcoded-mtext" data-i18n="nav.social.messages">Agregar Alumno</span>
                    <span class="pcoded-mcaret"></span>
                </a>
            </li>
            <li class="{{ explode('.', $view_name)[0]=='imports.list' ? 'active pcoded-trigger' : '' }}">
                <a href="{{ route('imports.list',['type'=>'students']) }}">
                    <span class="pcoded-micon" style="background-color:#13a57c;"><i class="fas fa-file-import"></i><b>T</b></span>
                    <span class="pcoded-mtext" data-i18n="nav.task.main">Importar Alumnos</span>
                    <span class="pcoded-mcaret"></span>
                </a>
            </li>
        </ul>
    </li>
    <li class="pcoded-hasmenu {{ explode('.', $view_name)[0]=='tutors' ? 'active pcoded-trigger' : '' }}">
        <a href="javascript:void(0)">
            <span class="pcoded-micon"><i class="fas fa-user"></i><b>T</b></span>
            <span class="pcoded-mtext" data-i18n="nav.task.main">Tutores</span>
            <span class="pcoded-mcaret"></span>
        </a>
        <ul class="pcoded-submenu">
            <li class="{{ Route::currentRouteNamed('tutors.list') ? 'active' : '' }}">
                <a href="{{ route('tutors.list') }}">
                    <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                    <span class="pcoded-mtext" data-i18n="nav.task.task-list">Listar Tutores</span>
                    <span class="pcoded-mcaret"></span>
                </a>
            </li>
            <li class="{{ Route::currentRouteNamed('tutors.create') ? 'active' : '' }}">
                <a href="{{ route('tutors.create') }}">
                    <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                    <span class="pcoded-mtext" data-i18n="nav.task.task-board">Agregar Tutor</span>
                    <span class="pcoded-mcaret"></span>
                </a>
            </li>
            <li class="{{ Route::currentRouteNamed('teachers.list') ? 'active' : '' }}">
                <a href="{{ route('teachers.list') }}">
                    <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                    <span class="pcoded-mtext" data-i18n="nav.task.task-board">Listado de Profesores</span>
                    <span class="pcoded-mcaret"></span>
                </a>
            </li>
            <li class="{{ Route::currentRouteNamed('teachers.create') ? 'active' : '' }}">
                <a href="{{ route('teachers.create') }}">
                    <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                    <span class="pcoded-mtext" data-i18n="nav.task.task-board">Agregar Profesor</span>
                    <span class="pcoded-mcaret"></span>
                </a>
            </li>
            <li class="{{ explode('.', $view_name)[0]=='imports.list' ? 'active pcoded-trigger' : '' }}">
                <a href="{{ route('imports.list',['type'=>'tutors']) }}">
                    <span class="pcoded-micon" style="background-color:#13a57c;"><i class="fas fa-file-import"></i><b>T</b></span>
                    <span class="pcoded-mtext" data-i18n="nav.task.main">Importar Tutores y Profesores</span>
                    <span class="pcoded-mcaret"></span>
                </a>
            </li>
        </ul>
    </li>
    <li class="pcoded-hasmenu {{ explode('.', $view_name)[0]=='careers' ? 'active pcoded-trigger' : '' }}">
        <a href="javascript:void(0)">
            <span class="pcoded-micon"><i class="fa fa-cubes"></i><b>C</b></span>
            <span class="pcoded-mtext" data-i18n="nav.to-do.main">Carreras</span>
            <span class="pcoded-mcaret"></span>
        </a>
        <ul class="pcoded-submenu">
            <li class="{{ Route::currentRouteNamed('careers.list') ? 'active' : '' }}">
                <a href="{{ route('careers.list') }}">
                    <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                    <span class="pcoded-mtext" data-i18n="nav.to-do.todo">Listado de Carreras</span>
                    <span class="pcoded-mcaret"></span>
                </a>
            </li>
            <li class="{{ Route::currentRouteNamed('careers.create') ? 'active' : '' }}">
                <a href="{{ route('careers.create') }}" data-i18n="nav.to-do.notes">
                    <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                    <span class="pcoded-mtext">Agregar Carrera</span>
                    <span class="pcoded-mcaret"></span>
                </a>
            </li>
            <li class="{{ explode('.', $view_name)[0]=='imports.list' ? 'active pcoded-trigger' : '' }}">
                <a href="{{ route('imports.list',['type'=>'careers']) }}">
                    <span class="pcoded-micon" style="background-color:#13a57c;"><i class="fas fa-file-import"></i><b>T</b></span>
                    <span class="pcoded-mtext" data-i18n="nav.task.main">Importar Carreras</span>
                    <span class="pcoded-mcaret"></span>
                </a>
            </li>
        </ul>
    </li>
    <li class="pcoded-hasmenu {{ explode('.', $view_name)[0]=='users' ? 'active pcoded-trigger' : '' }}">
        <a href="javascript:void(0)">
            <span class="pcoded-micon"><i class="fa fa-users"></i><b>U</b></span>
            <span class="pcoded-mtext" data-i18n="nav.gallery.main">Usuarios</span>
            <span class="pcoded-mcaret"></span>
        </a>
        <ul class="pcoded-submenu">
            <li class="{{ Route::currentRouteNamed('users.list') ? 'active' : '' }}">
                <a href="{{ route('users.list') }}">
                    <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                    <span class="pcoded-mtext" data-i18n="nav.gallery.gallery-grid">Listado de Usuarios</span>
                    <span class="pcoded-mcaret"></span>
                </a>
            </li>
            <li class="{{ Route::currentRouteNamed('users.create') ? 'active' : '' }}">
                <a href="{{ route('users.create') }}">
                    <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                    <span class="pcoded-mtext" data-i18n="nav.gallery.masonry-gallery">Agregar Usuarios</span>
                    <span class="pcoded-mcaret"></span>
                </a>
            </li>
            <li class="{{ explode('.', $view_name)[0]=='imports.list' ? 'active pcoded-trigger' : '' }}">
                <a href="{{ route('imports.list',['type'=>'users']) }}">
                    <span class="pcoded-micon" style="background-color:#13a57c;"><i class="fas fa-file-import"></i><b>T</b></span>
                    <span class="pcoded-mtext" data-i18n="nav.task.main">Importar Usuarios</span>
                    <span class="pcoded-mcaret"></span>
                </a>
            </li>
        </ul>
    </li>
    <li class="pcoded-hasmenu {{ explode('.', $view_name)[0]=='tutorias' ? 'active pcoded-trigger' : '' }}">
        <a href="javascript:void(0)">
            <span class="pcoded-micon"><i class="fa fa-briefcase"></i><b>T</b></span>
            <span class="pcoded-mtext" data-i18n="nav.search.main">Empresas</span>
            <span class="pcoded-mcaret"></span>
        </a>
        <ul class="pcoded-submenu">
            <li class="{{ Route::currentRouteNamed('tutorias.list') ? 'active' : '' }}">
                <a href="{{ route('tutorias.list') }}">
                    <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                    <span class="pcoded-mtext" data-i18n="nav.search.simple-search">X</span>
                    <span class="pcoded-mcaret"></span>
                </a>
            </li>
            
        </ul>
    </li>
    <li class="pcoded-hasmenu {{ explode('.', $view_name)[0]=='asesorias' ? 'active pcoded-trigger' : '' }}">
        <a href="javascript:void(0)">
            <span class="pcoded-micon"><i class="fa fa-server"></i><b>AS</b></span>
            <span class="pcoded-mtext" data-i18n="nav.job-search.main">Sectores</span>
            <span class="pcoded-mcaret"></span>
        </a>
        <ul class="pcoded-submenu">
          <li class="{{ Route::currentRouteNamed('asesorias.list') ? 'active' : '' }}">
              <a href="{{ route('asesorias.list') }}">
                    <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                    <span class="pcoded-mtext" data-i18n="nav.job-search.card-view">Listado de Asesorías</span>
                    <span class="pcoded-mcaret"></span>
                </a>
            </li>
            <li class="{{ Route::currentRouteNamed('asesorias.create') ? 'active' : '' }}">
                <a href="{{ route('asesorias.create') }}">
                    <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                    <span class="pcoded-mtext" data-i18n="nav.job-search.job-detailed">Agregar Asesoría</span>
                    <span class="pcoded-mcaret"></span>
                </a>
            </li>
        </ul>
    </li>
    <li class="pcoded-hasmenu {{ explode('.', $view_name)[0]=='schedule' ? 'active pcoded-trigger' : '' }}">
        <a href="javascript:void(0)">
            <span class="pcoded-micon" style="background-color:darkcyan;"><i class="fas fa-star"></i><b>AG</b></span>
            <span class="pcoded-mtext" data-i18n="nav.job-search.main">Competencias</span>
            <span class="pcoded-mcaret"></span>
        </a>
        <ul class="pcoded-submenu">
            <li class="{{ Route::currentRouteNamed('schedule.tutoria.list') ? 'active' : '' }}">
                <a href="{{ route('schedule.tutoria.list') }}">
                    <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                    <span class="pcoded-mtext" data-i18n="nav.job-search.job-detailed">Citas Agendadas Tutoría</span>
                    <span class="pcoded-mcaret"></span>
                </a>
            </li>
            <li class="{{ Route::currentRouteNamed('schedule.tutoria.create') ? 'active' : '' }}">
                <a href="{{ route('schedule.tutoria.create') }}">
                    <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                    <span class="pcoded-mtext" data-i18n="nav.job-search.job-detailed">Agendar Cita Tutoría</span>
                    <span class="pcoded-mcaret"></span>
                </a>
            </li>
            <li class="{{ Route::currentRouteNamed('schedule.asesoria.list') ? 'active' : '' }}">
                <a href="{{ route('schedule.asesoria.list') }}">
                    <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                    <span class="pcoded-mtext" data-i18n="nav.job-search.job-detailed">Citas Agendadas Asesoría</span>
                    <span class="pcoded-mcaret"></span>
                </a>
            </li>
            <li class="{{ Route::currentRouteNamed('schedule.asesoria.create') ? 'active' : '' }}">
                <a href="{{ route('schedule.asesoria.create') }}">
                    <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                    <span class="pcoded-mtext" data-i18n="nav.job-search.job-detailed">Agendar Cita Asesoría</span>
                    <span class="pcoded-mcaret"></span>
                </a>
            </li>
        </ul>
    </li>
    <li class="pcoded-hasmenu {{ explode('.', $view_name)[0]=='assignations' ? 'active pcoded-trigger' : '' }}">
        <a href="javascript:void(0)">
            <span class="pcoded-micon" style="background-color:firebrick;"><i class="fa fa-tag"></i><b>T</b></span>
            <span class="pcoded-mtext" data-i18n="nav.task.main">Habilidades</span>
            <span class="pcoded-mcaret"></span>
        </a>
        <ul class="pcoded-submenu">
            <li class="{{ Route::currentRouteNamed('assignations.list') ? 'active' : '' }}">
                <a href="{{ route('assignations.list') }}">
                    <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                    <span class="pcoded-mtext" data-i18n="nav.social.messages">Lista de Tutorados</span>
                    <span class="pcoded-mcaret"></span>
                </a>
            </li>
            <li class="{{ Route::currentRouteNamed('assignations.create') ? 'active' : '' }}">
                <a href="{{ route('assignations.create') }}">
                    <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                    <span class="pcoded-mtext" data-i18n="nav.social.messages">Asignación de Tutor</span>
                    <span class="pcoded-mcaret"></span>
                </a>
            </li>
            <li class="{{ explode('.', $view_name)[0]=='imports.list' ? 'active pcoded-trigger' : '' }}">
                <a href="{{ route('imports.list',['type'=>'asignation']) }}">
                    <span class="pcoded-micon" style="background-color:#13a57c;"><i class="fas fa-file-import"></i><b>T</b></span>
                    <span class="pcoded-mtext" data-i18n="nav.task.main">Importar Asignación</span>
                    <span class="pcoded-mcaret"></span>
                </a>
            </li>
        </ul>
    </li>
    <li class="pcoded-hasmenu {{ explode('.', $view_name)[0]=='assignations' ? 'active pcoded-trigger' : '' }}">
            <a href="javascript:void(0)">
                <span class="pcoded-micon" style="background-color:#5e1287;"><i class="fa fa-trophy"></i><b>T</b></span>
                <span class="pcoded-mtext" data-i18n="nav.task.main">Medallas</span>
                <span class="pcoded-mcaret"></span>
            </a>
            <ul class="pcoded-submenu">
                <li class="{{ Route::currentRouteNamed('assignations.list') ? 'active' : '' }}">
                    <a href="{{ route('assignations.list') }}">
                        <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                        <span class="pcoded-mtext" data-i18n="nav.social.messages">Lista de Tutorados</span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                </li>
                <li class="{{ Route::currentRouteNamed('assignations.create') ? 'active' : '' }}">
                    <a href="{{ route('assignations.create') }}">
                        <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                        <span class="pcoded-mtext" data-i18n="nav.social.messages">Asignación de Tutor</span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                </li>
                <li class="{{ explode('.', $view_name)[0]=='imports.list' ? 'active pcoded-trigger' : '' }}">
                    <a href="{{ route('imports.list',['type'=>'asignation']) }}">
                        <span class="pcoded-micon" style="background-color:#13a57c;"><i class="fas fa-file-import"></i><b>T</b></span>
                        <span class="pcoded-mtext" data-i18n="nav.task.main">Importar Asignación</span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                </li>
            </ul>
        </li>
    <li class="pcoded-hasmenu {{ explode('.', $view_name)[0]=='reports' ? 'active pcoded-trigger' : '' }}">
        <a href="javascript:void(0)">
            <span class="pcoded-micon" style="background-color:gray;"><i class="fa fa-download"></i><b>T</b></span>
            <span class="pcoded-mtext" data-i18n="nav.task.main">Reportes</span>
            <span class="pcoded-mcaret"></span>
        </a>
        <ul class="pcoded-submenu">
            <li class="{{ Route::currentRouteNamed('reports.tutorias') ? 'active' : '' }}">
                <a href="{{ route('reports.tutorias') }}">
                    <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                    <span class="pcoded-mtext" data-i18n="nav.social.messages">Reportes de Tutorías</span>
                    <span class="pcoded-mcaret"></span>
                </a>
            </li>
            <li class="{{ Route::currentRouteNamed('reports.jtg_tutorias') ? 'active' : '' }}">
                <a href="{{ route('reports.jtg_tutorias') }}">
                    <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                    <span class="pcoded-mtext" data-i18n="nav.social.messages">Reportes de Tutorías JTG</span>
                    <span class="pcoded-mcaret"></span>
                </a>
            </li>
            <li class="{{ Route::currentRouteNamed('reports.asesorias') ? 'active' : '' }}">
                <a href="{{ route('reports.asesorias') }}">
                    <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                    <span class="pcoded-mtext" data-i18n="nav.social.messages">Reportes de Asesorías</span>
                    <span class="pcoded-mcaret"></span>
                </a>
            </li>
            <li class="{{ Route::currentRouteNamed('reports.analytics') ? 'active' : '' }}">
                <a href="{{ route('reports.analytics') }}">
                    <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                    <span class="pcoded-mtext" data-i18n="nav.social.messages">Graficas de Información de Tutorías y Asesorías</span>
                    <span class="pcoded-mcaret"></span>
                </a>
            </li>
        </ul>
    </li>
    
    <li class="{{ explode('.', $view_name)[0]=='imports.list' ? 'active pcoded-trigger' : '' }}">
        <a href="{{ route('imports.list') }}">
            <span class="pcoded-micon" style="background-color:#13a57c;"><i class="fas fa-file-import"></i><b>T</b></span>
            <span class="pcoded-mtext" data-i18n="nav.task.main">Importar</span>
            <span class="pcoded-mcaret"></span>
        </a>
    </li>
    <li class="{{ Route::currentRouteNamed('log.sessionlist') ? 'active' : '' }}">
        <a href="{{ route('log.sessionlist') }}">
            <span class="pcoded-micon" style="background-color:#fc6100;"><i class="icofont icofont-sign-in"></i><b>HS</b></span>
            <span class="pcoded-mtext" data-i18n="nav.job-search.main">Historial de Sesiones</span>
            <!--<span class="pcoded-badge label label-danger">NEW</span>-->
            <span class="pcoded-mcaret"></span>
        </a>
    </li>
    
</ul>
</div>
</nav>
<div class="pcoded-content">
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                @yield('body')
            </div>
        </div>
    </div>
</div>
