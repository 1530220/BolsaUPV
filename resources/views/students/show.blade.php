@extends('layouts.app')

@section('title',"SIITA - Detalles del Alumno: {$student->university_id}")

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
					<i class="icofont icofont-eye-alt bg-c-pink"></i>
					<div class="d-inline">
						<h4 style="text-transform: none;">Detalles del Alumno con la Matricula: {{ $student->university_id }} </h4>
						<span style="text-transform: none;">Mostrando todos los detalles del alumno seleccionado.</span>
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
						<li class="breadcrumb-item"><a href="{{ route('students.list') }}">Alumnos</a>
						</li>
						<li class="breadcrumb-item">Detalles de Alumno
						</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
	<!-- Page-header end -->

	<!-- Page body start -->
	<div class="page-body">
		<div class="row">
			<div class="col-sm-12">
				<!-- Basic Form Inputs card start -->
				<div class="card">
					<div class="card-block">
						<h4 class="sub-title">Información General</h4>
						<div class="page-body">
							<div class="row">
								<div class="col-md-12 col-xl-12 ">
									<div class="card-block user-detail-card">
										@if($student->deleted==1)
											<div class="alert alert-danger icons-alert">
												<p><strong>Usuario Eliminado</strong></p>
												<p> Este usuario esta actualmente eliminado, restaurelo para que pueda hacer uso de el en el sistema.</p>
											</div>
										@endif
										<div class="row">
											<div class="col-sm-3">
												<center>
													<img id="modal_img" src='{{ asset($student->image)}}' alt="{{ $student->first_name }} {{ $student->last_name }} {{ $student->second_last_name }}" class="img-fluid p-b-10 rounded" style="width:100%;max-width:300px">
													<div id="modal_show_img" class="modal">
														<span class="close">&times;</span>
														<img class="modal-content" id="img_content">
														<div id="caption"></div>
													</div>
													<div class="contact-icon">
														@if($student->deleted==0)
															@if (Auth::user()->type == 1 || Auth::user()->type == 2)
																<form id="form" name="form" action="{{ route('students.destroy', ['id' => $student->user_id])}}" method="POST">
																	{{ csrf_field() }}
																	{{ method_field('DELETE') }}
																	<a style="color:white" onclick="returnURL('{{ url()->previous() }}')"><button type="button" class="btn btn-default" data-toggle="tooltip" data-placement="bottom" title="Regresar"><i class="icofont icofont-arrow-left m-0"></i></button></a>
																	<a href="{{ route('students.edit', ['matricula' => $student->user_id]) }}"><button type="button" class="btn btn-default" data-toggle="tooltip" data-placement="bottom" title="Editar"><i class="icofont icofont-edit m-0"></i></button></a>
																	<button onclick="archiveFunction()" class="btn btn-default" data-toggle="tooltip" data-placement="bottom" type="submit" title="Eliminar"><span class="icofont icofont-ui-delete"></span></button>
																	<a href="{{ route('assignations.reassignation', ['id' => $student->user_id]) }}"><button type="button" class="btn btn-default" data-toggle="tooltip" data-placement="bottom" title="Cambiar Tutor Asignado"><i class="fas fa-exchange-alt"></i></i></button></a>
																</form>
															@else
																<a style="color:white" onclick="returnURL('{{ url()->previous() }}')"><button type="button" class="btn btn-default" data-toggle="tooltip" data-placement="bottom" title="Regresar"><i class="icofont icofont-arrow-left m-0"></i>Regresar</button></a>
															@endif
														@else
															@if (Auth::user()->type == 1 || Auth::user()->type == 2)
																<form id="form" name="form" action="{{ route('students.restore', ['id' => $student->user_id]) }}" method="POST">
																	{{ csrf_field() }}

																	<a style="color:white" onclick="returnURL('{{ url()->previous() }}')"><button type="button" class="btn btn-default" data-toggle="tooltip" data-placement="bottom" title="Regresar"><i class="icofont icofont-arrow-left m-0"></i></button></a>
																	<a href="{{ route('students.edit', ['matricula' => $student->user_id]) }}"><button type="button" class="btn btn-default" data-toggle="tooltip" data-placement="bottom" title="Editar"><i class="icofont icofont-edit m-0"></i></button></a>
																	<button onclick="restoreFunction()" class="btn btn-default" data-toggle="tooltip" data-placement="bottom" type="submit" title="Restaurar"><span class="fas fa-reply"></span></button>
																</form>
															@else
																<a style="color:white; " onclick="returnURL('{{ url()->previous() }}')"><button type="button" class="btn btn-default" data-toggle="tooltip" data-placement="bottom" title="Regresar"><i class="icofont icofont-arrow-left m-0"></i>Regresar</span></button></a>
															@endif
														@endif
													</div>
												</center>
											</div>
											<div class="col-sm-9 user-detail">
												<div class="row">
													<div class="col-sm-4">
														<h6 class="f-w-400 m-b-30"><i class="icofont icofont-id-card"></i>Matrícula :</h6>
													</div>
													<div class="col-sm-8">
														<h6 class="m-b-30"><strong>{{ $student->university_id }}</strong></h6>
													</div>
												</div>
												<div class="row">
													<div class="col-sm-4">
														<h6 class="f-w-400 m-b-30"><i class="icofont icofont-ui-user"></i>Nombre :</h6>
													</div>
													<div class="col-sm-8">
														<h6 class="m-b-30">{{ $student->first_name }} {{ $student->last_name }} {{ $student->second_last_name }}</h6>
													</div>
												</div>
												<div class="row">
													<div class="col-sm-4">
														<h6 class="f-w-400 m-b-30"><i class="icofont icofont-cube"></i>Carrera :</h6>
													</div>
													<div class="col-sm-8">
														@if($student->name=='Sin Asignar')
															<h6 class="m-b-30" style="color:red">{{ $student->name }}</h6>
														@else
															<h6 class="m-b-30">{{ $student->name }}</h6>
														@endif
													</div>
												</div>
												<div class="row">
													<div class="col-sm-4">
														<h6 class="f-w-400 m-b-30"><i class="icofont icofont-chart-bar-graph"></i>Situación Académica :</h6>
													</div>
													@if ($student->academic_situation == 0)
														<div class="col-sm-8">
															<h6 class="m-b-30">Regular</h6>
														</div>
													@else
														<div class="col-sm-8">
															<h6 class="m-b-30" style="color:red">Especial</h6>
														</div>
													@endif
												</div>
												<div class="row">
													<div class="col-sm-4">
														<h6 class="f-w-400 m-b-30"><i class="icofont icofont-ui-email"></i>Email :</h6>
													</div>
													<div class="col-sm-8">
														<h6 class="m-b-30">{{ $student->email }}</h6>
													</div>
												</div>
												<div class="row">
													<div class="col-sm-4">
														<h6 class="f-w-400 m-b-30"><i class="icofont icofont-users-alt-5"></i>Tutor :</h6>
													</div>
													<div class="col-sm-8">
														@if (Auth::user()->type == 4 || Auth::user()->type == 5)
															<h6 class="m-b-30">{{ $student->title }} {{ $student->tutorFirstName }} {{ $student->tutorLastName }} {{ $student->tutorSecondName }}</h6>
														@else
															<a href="{{ route('tutors.show', ['id' => $student->tutor_university_id]) }}"><h6 class="m-b-30">{{ $student->title }} {{ $student->tutorFirstName }} {{ $student->tutorLastName }} {{ $student->tutorSecondName }}</h6></a>
														@endif
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
