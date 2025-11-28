@extends('layouts.app')

@section('content')

<h3><i class="bi bi-calendar-check"></i> Registro de Asistencias</h3>

@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

@if(session('error'))
<div class="alert alert-danger">{{ session('error') }}</div>
@endif

<div class="card p-3 mb-4">
    <form action="{{ route('asistencias.entrada') }}" method="POST" class="d-inline">
        @csrf
        <label>Empleado:</label>
        <select name="empleado_id" class="form-control d-inline w-25" required>
            @foreach(\App\Models\Empleado::all() as $empleado)
                <option value="{{ $empleado->id }}">{{ $empleado->nombres }} {{ $empleado->apellidos }}</option>
            @endforeach
        </select>
        <button class="btn btn-success mt-2"><i class="bi bi-box-arrow-in-right"></i> Marcar Entrada</button>
    </form>

    <form action="{{ route('asistencias.salida') }}" method="POST" class="d-inline ms-3">
        @csrf
        <select name="empleado_id" class="form-control d-inline w-25" required>
            @foreach(\App\Models\Empleado::all() as $empleado)
                <option value="{{ $empleado->id }}">{{ $empleado->nombres }} {{ $empleado->apellidos }}</option>
            @endforeach
        </select>
        <button class="btn btn-danger mt-2"><i class="bi bi-box-arrow-right"></i> Marcar Salida</button>
    </form>
</div>

<div class="card p-3">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Empleado</th>
                <th>Fecha</th>
                <th>Entrada</th>
                <th>Salida</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            @foreach($asistencias as $a)
            <tr>
                <td>{{ $a->empleado->nombres }} {{ $a->empleado->apellidos }}</td>
                <td>{{ $a->fecha }}</td>
                <td>{{ $a->hora_entrada }}</td>
                <td>{{ $a->hora_salida ?? '-' }}</td>
                <td>
                    @if($a->estado == 'Presente')
                        <span class="badge bg-success">Presente</span>
                    @elseif($a->estado == 'Tardanza')
                        <span class="badge bg-warning text-dark">Tardanza</span>
                    @else
                        <span class="badge bg-danger">Falta</span>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{ $asistencias->links() }}
</div>

@endsection
