@extends('layouts.app')

@section('scripts')
    @vite(['resources/js/index.js'])
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
@endsection
@section('content')
    <div class="container">
        <div class="row mb-5">
            <div class="col">
                <a href="/module/new">
                    <button class="btn btn-primary">
                        {{ _('New Module') }}
                    </button>
                </a>
            </div>
            <div class="col">
                <a href="/module/status/update">
                    <button class="btn btn-info  text-white">
                        {{ _('Update Status') }}
                    </button>
                </a>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-3 col-md-6 mb-4">
                <div
                    class="card  border border-top-0 border-bottom-0 border-end-0 border-start border-4 border-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="fs-6 fw-bold text-primary text-uppercase mb-1">
                                    {{ _('Total Modules') }}
                                </div>
                            </div>
                            <div class="fs-3 mb-0 fw-bold text-gray-800">
                                {{ count($modules) }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
                <div
                    class="card  border border-top-0 border-bottom-0 border-end-0 border-start border-4 border-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="fs-6 fw-bold text-success text-uppercase mb-1">
                                    {{ _('Total Functioning Time') }}
                                </div>
                            </div>
                            <div class="fs-3 mb-0 fw-bold text-gray-800">
                                {{ $totalTime }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div
                    class="card  border border-top-0 border-bottom-0 border-end-0 border-start border-4 border-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="fs-6 fw-bold text-info text-uppercase mb-1">
                                    {{ _('Functional Modules') }}
                                </div>
                            </div>
                            <div class="fs-3 mb-0 fw-bold text-gray-800">
                                {{ count(
                                    array_filter($modules->toArray(), function ($mod) {
                                        return $mod['functional'];
                                    }),
                                ) }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div
                    class="card  border border-top-0 border-bottom-0 border-end-0 border-start border-4 border-danger shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="fs-6 fw-bold text-danger text-uppercase mb-1">
                                    {{ _('Broken Modules') }}
                                </div>
                            </div>
                            <div class="fs-3 mb-0 fw-bold text-gray-800">
                                {{ count(
                                    array_filter($modules->toArray(), function ($mod) {
                                        return !$mod['functional'];
                                    }),
                                ) }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="row">
            <div class="col-8">
                <div class="row">
                    <div class="col">
                        <div class="card shadow mb-4">
                            <div class="card-header  text-primary fw-bold fs-4">
                                IOT Modules
                            </div>
                            <div class="card-body px-5 py-3">
                                <table class="table">
                                    <thead>
                                        <tr class="fs-5">
                                            <th>Name</th>
                                            <th>Type</th>
                                            <th>Temperature</th>
                                            <th>Speed</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($modules as $module)
                                            <tr class="module fs-4" data-moduleId="{{ $module->id }}"
                                                style="cursor: pointer;">
                                                <td>{{ $module->name }}</td>
                                                <td>{{ $module->type }} {{ $module->functionTime }}</td>
                                                <td>{{ $module->temperature }}</td>
                                                <td>{{ $module->speed }}</td>
                                                <td>{{ $module->online ? 'Online' : 'Offline' }}</td>
                                                <td>
                                                    <div class="d-flex  gap-3">
                                                        <a href="/module/{{ $module->id }}/edit">
                                                            <button class="btn btn-warning text-white">
                                                                {{ _('Edit') }}
                                                            </button>
                                                        </a>
                                                        <a>
                                                            <form action="{{ route('module.destroy', [$module->id]) }}"
                                                                method="POST">
                                                                @method('DELETE')
                                                                @csrf
                                                                <button type="submit" class="btn btn-secondary">
                                                                    {{ _('Delete') }}</button>
                                                            </form>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="card shadow">
                            <div class="card-header  text-primary fw-bold fs-4">
                                {{ _('Module Temperature') }}
                            </div>
                            <div class="card-body py-4" id="temperature">
                                <div class="d-none">
                                    <canvas id="temperatureChart"></canvas>
                                </div>
                                <div class="canvas-placeholder">
                                    <div class="row justify-content-center align-items">
                                        <div class="col-9">
                                            <div
                                                class="px-2 py-3 bg-danger fs-5 fw-bold text-white rounded text-center shadow-lg">
                                                <p>{{ _('No Module selected') }}</p>
                                                {{ _('Click a module to show data') }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="card shadow">
                            <div class="card-header  text-primary fw-bold fs-4">
                                {{ _('Module Speed') }}
                            </div>
                            <div class="card-body py-4" id="speed">
                                <div class="d-none">
                                    <canvas id="speedChart"></canvas>
                                </div>
                                <div class="canvas-placeholder">
                                    <div class="row justify-content-center align-items">
                                        <div class="col-9">
                                            <div
                                                class="px-2 py-3 bg-danger fs-5 fw-bold text-white rounded text-center shadow-lg">
                                                <p>{{ _('No Module selected') }}</p>
                                                {{ _('Click a module to show data') }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-4">
                <div class="row mb-4">
                    <div class="col">
                        <div class="card shadow">
                            <div class="card-header text-primary fw-bold fs-4">
                                Stats
                            </div>
                            <div class="card-body d-flex flex-column gap-3 px-4 module-info">
                                <div class="container fs-5 d-none">
                                    <div class="row border-bottom py-3 fw-bold text-dark">
                                        <div class="col g-0">
                                            Description :
                                        </div>
                                        <div class="col d-flex justify-content-end" data-module-type = "description">
                                        </div>
                                    </div>
                                    <div class="row border-bottom py-3 fw-bold text-dark">
                                        <div class="col g-0 ">
                                            {{ _('Functionning Time') }} :
                                        </div>
                                        <div class="col d-flex justify-content-end" data-module-type = "functionTime">
                                        </div>
                                    </div>
                                    <div class="row py-3 fw-bold text-dark">
                                        <div class="col g-0">
                                            {{ _('Functional') }} :
                                        </div>
                                        <div class="col d-flex justify-content-end" data-module-type = "functional">

                                        </div>
                                    </div>
                                </div>
                                <div class="">
                                    <div class="row justify-content-center align-items">
                                        <div class="col-9">
                                            <div
                                                class="px-2 py-3 bg-danger fs-5 fw-bold text-white rounded text-center shadow-lg">
                                                <p>{{ _('No Module selected') }}</p>
                                                {{ _('Click a module to show module details') }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="card shadow">
                            <div class="card-header  text-primary fw-bold fs-4">
                                Stats
                            </div>
                            <div class="card-body">
                                <canvas id="pieChart" width="400" height="400"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <div class="row">

    </div>
    <div class="row">
        <div class="">
            {{ session('success') }}
        </div>
    </div>
    </div>
@endsection
