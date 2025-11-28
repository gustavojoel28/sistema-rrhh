@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Editar Empleado</h1>

    <form action="{{ route('empleados.update', $empleado) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="row">

            <div class="col-md-6 mb-3">
                <label>DNI</label>
                <input type="text" name="dni" value="{{ $empleado->dni }}" class="form-control" required>
            </div>

            <div class="col-md-6 mb-3">
                <label>Nombres</label>
                <input type="text" name="nombres" value="{{ $empleado->nombres }}" class="form-control" required>
            </div>

            <div class="col-md-6 mb-3">
                <label>Apellidos</label>
                <input type="text" name="apellidos" value="{{ $empleado->apellidos }}" class="form-control" required>
            </div>

            <div class="col-md-6 mb-3">
                <label>Correo</label>
                <input type="email" name="correo" value="{{ $empleado->correo }}" class="form-control">
            </div>

            <div class="col-md-6 mb-3">
                <label>Teléfono</label>
                <input type="text" name="telefono" value="{{ $empleado->telefono }}" class="form-control">
            </div>

            <div class="col-md-6 mb-3">
                <label>Fecha de Nacimie
