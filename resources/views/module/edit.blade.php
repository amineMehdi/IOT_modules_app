@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row mb-5">
            <h1 class="fs-1 text-center">{{ _('Edit IOT Module') }}</h1>
        </div>
        <div class="row justify-content-center">
            <div class="col-6">
                <div class="card shadow ">
                    <div class="card-body">
                        <form action="/module/{{ $module->id }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="form-group mb-3">
                                <label for="name">{{ _('Name') }}</label>
                                <input type="text" class="form-control mt-1" id="name" name="name"
                                    placeholder="Name" value="{{ $module->name }}">
                            </div>
                            <div class="form-group mb-3">
                                <label for="description">{{ _('Description') }}</label>
                                <input type="text" class="form-control mt-1" id="description" name="description"
                                    placeholder="Description" value="{{ $module->description }}">
                            </div>
                            <div class="form-group mb-3">
                                <label for="temperature">
                                    {{ _('Temperature') }}
                                </label>
                                <div class="input-group mt-1">
                                    <input type="number" class="form-control" name="temperature"
                                        value="{{$module->temperature}}">
                                    <span class="input-group-text">°C</span>
                                </div>
                            </div>
                            <div class="form-group mb-3">
                                <label for="speed">{{ _("Speed")}}</label>
                                <input type="number" class="form-control" name="speed"
                                    value="{{$module->speed}}">
                            </div>
                            <div class="form-group mb-3">
                                <label for="type">{{ _('Type') }}</label>
                                <select class="form-select mt-1" name="type">
                                    <option value="lpwan" {{ $module->type === 'lpawn' ? 'selected' : null }}>LPWANs
                                    </option>
                                    <option value="cellular" {{ $module->type === 'cellular' ? 'selected' : null }}>Cellular
                                    </option>
                                    <option value="zigbee" {{ $module->type === 'zigbee' ? 'selected' : null }}>Zigbee and
                                        Other Mesh Protocols</option>
                                    <option value="bluetooth" {{ $module->type === 'bluetooth' ? 'selected' : null }}>
                                        Bluetooth and BLE</option>
                                    <option value="wifi" {{ $module->type === 'wifi' ? 'selected' : null }}>Wi-Fi</option>
                                    <option value="rfid" {{ $module->type === 'rfid' ? 'selected' : null }}>RFID</option>
                                    <option value="other" {{ $module->type === 'other' ? 'selected' : null }}>Other</option>
                                </select>
                            </div>
                            <div class="form-check form-switch mb-3 fs-5">
                                <input class="form-check-input" role="swich" type="checkbox" name="online" {{$module->online ? "checked" :  null}}>
                                <label class="form-check-label" for="online">{{ _('Active') }}</label>
                            </div>
                            <div class="d-flex justify-content-center">
                                <button type="submit" class="btn btn-primary fs-5">{{ _('Update') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
