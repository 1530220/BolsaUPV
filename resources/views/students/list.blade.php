@extends('layouts.app')

@section('title',"SIITA - Alumnos")

@switch(Auth::user()->type)
	@case(1)
		@section('body')
		@break
	@case(2)
		@section('bodyUsuario')
		@break
	@case(3)
		@section('bodyStudent')
		@break
	@case(4)
		@section('bodyTeacher')
		@break
	@case(5)
		@section('bodyTutor')
		@break
	@case(6)
		@section('bodyUserSalud')
		@break
	@case(7)
		@section('bodyUserPsicologia')
		@break
@endswitch

<!-- Main-body start -->
<div class="main-body">
	<!-- Page-header start -->
	<div class="page-header card">
		<div class="row align-items-end">
			<div class="col-lg-8">
				<div class="page-header-title">
					<i class="icofont icofont-table bg-c-pink"></i>
					<div class="d-inline">
						@switch(Auth::user()->type)
							@case(1)
							@case(2)
								<h4 style="text-transform: none;">Listado de Alumnos</h4>
								<span style="text-transform: none;">Lista de todos los alumnos que han sido registrados en el sistema.</span>
								@break
							@case(5)
								<h4 style="text-transform: none;">Listado de Tutorados del Profesor: {{ $tutor->title }} {{ $tutor->first_name }} {{ $tutor->last_name }} {{ $tutor->second_last_name }}</h4>
								<span style="text-transform: none;">Lista de todos los tutorados asignados.</span>
								@break
						@endswitch
					</div>
				</div>
			</div>
			<div class="col-lg-4">
				<div class="page-header-breadcrumb">
					<ul class="breadcrumb-title">
						<li class="breadcrumb-item">
							<a href="{{ route('dashboard') }}">
								<i class="icofont icofont-home"></i>
							</a>
						</li>
						<li class="breadcrumb-item">Alumnos
						</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
	<!-- Page-header end -->

	<!-- Page-body start -->
	<div class="page-body">
		<div class="row">
			<div class="col-sm-12">
				<!-- Zero config.table start -->
				<div class="card">
					<div class="card-block">
						<div class="dt-responsive table-responsive">
							<table id="custom_datatable" style="width:100%; max-width:50%" class="table table-striped table-bordered">
								@if ($students->isNotEmpty())
									<thead id="table_header">
										<tr>
											@if(Auth::user()->type==5)
												<th scope="col" style="width:5%;">Num.</th>
											@endif
											<th class="all" scope="col" style="width:5%;">Matrícula</th>
											<th scope="col" style="width:22%;">Nombre Completo</th>
											<th scope="col" style="width:13%;">Carrera</th>
											@switch(Auth::user()->type)
												@case(1)
												@case(2)
													<th scope="col" style="width:20%;">Tutor</th>
													@break;
											@endswitch
											<th title="Situación Academica" scope="col" style="width:15%;">S. Academica</th>
											<th class="all" scope="col" class="all" style="width:25%;">Acciones</th>
										</tr>
									</thead>
									<tbody>
										@php
											$num=0;
										@endphp
										@foreach ($students as $student)
											<tr>
												@if($student->deleted=='0')
													@if(Auth::user()->type==5)
														@php
															$num=$num+1;
														@endphp
														<td style="font-weight:bold">{{ $num }}</td>
													@endif
													<td style="font-weight:bold">{{ $student->university_id }}</td>
													<td>{{ $student->userFirstName }} {{ $student->userLastName }} {{ $student->userSecondName }}</td>
													@if($student->careerName=='Sin Asignar')
														<td style="color:red; font-weight:bold">{{ $student->careerName }}</td>
													@else
														<td title="{{ $student->careerName }}">{{ $student->careerAbbreviation }}</td>
													@endif
													@switch(Auth::user()->type)
														@case(1)
														@case(2)
															<td><a href="{{ route('tutors.show', ['id' => $student->tutorUniversityId]) }}">{{ $student->title }} {{ $student->tutorFirstName }} {{ $student->tutorLastName }} {{ $student->tutorSecondName }}</a></td>
															@break
													@endswitch
													@switch($student->academic_situation)
														@case(0)
															<td style="font-weight:bold">Regular</td>
														@break
														@case(1)
															<td style="color:red; font-weight:bold">Especial</td>
														@break
													@endswitch
												@else
													@if(Auth::user()->type==5)
														@php
															$num=$num+1;
														@endphp
														<td style="color:red; font-weight:bold">{{ $num }}</td>
													@endif
													<td style="color:red; font-weight:bold">{{ $student->university_id }}</td>
													<td style="color:red;">{{ $student->userFirstName }} {{ $student->userLastName }} {{ $student->userSecondName }}</td>
													<td style="color:red;">{{ $student->careerName }}</td>
													<td><a style="color:red;" href="{{ route('tutors.show', ['id' => $student->tutorUniversityId]) }}">{{ $student->title }} {{ $student->tutorFirstName }} {{ $student->tutorLastName }} {{ $student->tutorSecondName }}</a></td>
													@switch($student->academic_situation)
														@case(0)
															<td style="color:red; font-weight:bold">Regular</td>
														@break
														@case(1)
															<td style="color:red; font-weight:bold">Especial</td>
														@break
													@endswitch
												@endif
												<td>
													@if($student->deleted=='0')
														<form id="form" name="form" action="{{ route('students.destroy', ['id' => $student->id]) }}" method="POST">
															{{ csrf_field() }}
															{{ method_field('DELETE') }}
															<center>
																<a href="{{ route('students.show', ['id' => $student->university_id]) }}" class="btn btn-warning" title="Ver detalles del alumno con matricula {{ $student->university_id }}" style="margin: 3px;">
																	<span class="icofont icofont-eye-alt"></span></a>
																	@if (Auth::user()->type==1 || Auth::user()->type==2)
																				<a href="{{ route('students.edit', ['id' => $student->id]) }}" class="btn btn-primary" title="Editar alumno con matricula {{ $student->university_id }}" style="margin: 3px;"><span class="icofont icofont-ui-edit"></span></a>
																				<button type="submit" class="btn btn-danger" style="margin: 3px;" id="eliminar" name="eliminar" onclick="archiveFunction()" title="Eliminar alumno con matricula {{ $student->university_id }}"><span class="icofont icofont-ui-delete"></span></button>
																			</center>
																		</form>
																	@endif
													@else
														<form id="form" name="form" action="{{ route('students.restore', ['id' => $student->id]) }}" method="POST">
															{{ csrf_field() }}
															<center>
																<a href="{{ route('students.show', ['id' => $student->university_id]) }}" class="btn btn-warning" title="Ver detalles del alumno con matricula {{ $student->university_id }}" style="margin: 3px;">
																	<span class="icofont icofont-eye-alt"></span></a>
																	@if (Auth::user()->type==1 || Auth::user()->type==2)
																				<a href="{{ route('students.edit', ['id' => $student->id]) }}" class="btn btn-primary" title="Editar alumno con matricula {{ $student->university_id }}" style="margin: 3px;"><span class="icofont icofont-ui-edit"></span></a>
																				<button type="submit" class="btn btn-success" style="margin: 3px;" id="restaurar" name="restaurar" onclick="restoreFunction()" title="Restaurar alumno con matricula {{ $student->university_id }}"><span class="fas fa-reply"></span></a>
																			</center>
																		</form>
																	@endif
													@endif
												</td>
											</tr>
										@endforeach
									</tbody>
									<tfoot>
										<tr id="table_footer">
											@if(Auth::user()->type==5)
												<th style="padding-right: 2.8%" scope="col" style="width:5%;">Num.</th>
											@endif
											<th style="padding-right: 2.8%" scope="col" style="width:5%;">Matrícula</th>
											<th style="padding-right: 2.8%" scope="col" style="width:20%;">Nombre Completo</th>
											<th style="padding-right: 2.8%" scope="col" style="width:15%;">Carrera</th>
											@switch(Auth::user()->type)
												@case(1)
												@case(2)
													<th style="padding-right: 2.8%" scope="col" style="width:15%;">Tutor</th>
													@break
											@endswitch
											<th style="padding-right: 2.8%" scope="col" style="width:10%;">Situación Academica</th>
											<th style="padding-left: 1.5%" scope="col" style="width:0%;"></th>
										</tr>
									</tfoot>
								@else
									<center>
										<div class="alert alert-warning icons-alert">
											<strong>Atención</strong>
											<p>No hay ningun alumno registrado.</p>
										</div>
										<a href="{{ route('students.create') }}"><button class="btn btn-success" style="float:right;width:100%; min-width:150px"><i class="fa fa-user-plus"></i>Agregar Nuevo Alumno</button></a>;

									</center>
								@endif

							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection

@section('javascriptcode')
<script>
@if (Auth::user()->type==1 || Auth::user()->type==2)
	var button = '<a href="{{ route('students.create') }}"><button class="btn btn-success" style="float:right;width:100%; min-width:150px"><i class="fa fa-user-plus"></i>Agregar Alumno</button></a>';
	applyStyleToDatatable(button, 'Buscar en alumnos...',0,'desc');
@else
	var button = '';
	applyStyleToDatatable(button, 'Buscar en alumnos...',1,'asc');
@endif
</script>
@endsection
