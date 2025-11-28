@extends('layouts.app')

@section('content')

<h2 class="mb-4">Dashboard General</h2>

<div class="row">

    <!-- TARJETAS -->
    <div class="col-md-4 mb-3">
        <div class="card shadow-sm p-4 text-center">
            <i class="bi bi-folder2-open" style="font-size:40px;color:#0d6efd;"></i>
            <h5>Áreas Registradas</h5>
            <h2>{{ $areas }}</h2>
        </div>
    </div>

    <div class="col-md-4 mb-3">
        <div class="card shadow-sm p-4 text-center">
            <i class="bi bi-briefcase-fill" style="font-size:40px;color:#198754;"></i>
            <h5>Cargos Registrados</h5>
            <h2>{{ $cargos }}</h2>
        </div>
    </div>

    <div class="col-md-4 mb-3">
        <div class="card shadow-sm p-4 text-center">
            <i class="bi bi-people-fill" style="font-size:40px;color:#dc3545;"></i>
            <h5>Empleados Registrados</h5>
            <h2>{{ $empleados }}</h2>
        </div>
    </div>

</div>


{{-- GRÁFICA DE EMPLEADOS POR ÁREA --}}
<div class="card shadow-sm p-4 mb-4">
    <h4 class="mb-3"><i class="bi bi-bar-chart-fill"></i> Empleados por Área</h4>
    <canvas id="empleadosAreaChart"></canvas>
</div>


{{-- TABLA DE ÚLTIMOS EMPLEADOS --}}
<div class="card shadow-sm p-4">
    <h4 class="mb-3"><i class="bi bi-person-lines-fill"></i> Últimos Empleados Registrados</h4>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>DNI</th>
                <th>Nombre</th>
                <th>Área</th>
                <th>Cargo</th>
                <th>Ingreso</th>
            </tr>
        </thead>
        <tbody>
            @foreach($ultimosEmpleados as $emp)
            <tr>
                <td>{{ $emp->dni }}</td>
                <td>{{ $emp->nombres }} {{ $emp->apellidos }}</td>
                <td>{{ $emp->area->nombre }}</td>
                <td>{{ $emp->cargo->nombre }}</td>
                <td>{{ $emp->fecha_ingreso }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>


{{-- JS para gráfica --}}
<script>
    const ctx = document.getElementById('empleadosAreaChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: [
                @foreach($empleadosPorArea as $a)
                    "{{ $a->nombre }}",
                @endforeach
            ],
            datasets: [{
                label: 'Empleados',
                data: [
                    @foreach($empleadosPorArea as $a)
                        {{ $a->empleados_count }},
                    @endforeach
                ],
                backgroundColor: '#0d6efd'
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: { beginAtZero: true }
            }
        }
    });
</script>

@endsection
