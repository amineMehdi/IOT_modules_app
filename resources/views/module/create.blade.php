@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row mb-5">
            <h1 class="fs-1 text-center">{{ _('Create a new IOT Module') }}</h1>
        </div>
        <div class="row justify-content-center">
            <div class="col-6">
                <div class="card shadow">
                    <div class="card-header">
                        {{ _('New Module') }}
                    </div>
                    <div class="card-body px-5 py-3">
                        <form action="/module" method="POST">
                            @csrf
                            <div class="form-group mb-3">
                                <label for="name">{{ _('Name') }}</label>
                                <input type="text" class="form-control mt-1" name="name" placeholder="Name">
                            </div>
                            <div class="form-group mb-3">
                                <label for="description">{{ _('Description') }}</label>
                                <input type="text" class="form-control mt-1" name="description"
                                    placeholder="Description">
                            </div>
                            <div class="form-group mb-3">
                                <label for="temperature">
                                    {{ _('Temperature') }}
                                </label>
                                <div class="input-group mt-1">
                                    <input type="number" class="form-control" name="temperature"
                                        placeholder="Temperature">
                                    <span class="input-group-text">°C</span>
                                </div>
                            </div>
                            <div class="form-group mb-3">
                                <label for="speed">{{ _("Speed")}}</label>
                                <input type="number" class="form-control" name="speed" placeholder="Speed">
                            </div>
                            <div class="form-group mb-3">
                                <label for="type">{{ _('Type') }}</label>
                                <select class="form-select mt-1" name="type">
                                    <option  value="other" selected>{{_("Open this select menu to select type")}}</option>
                                    <option value="lpwan">LPWANs</option>
                                    <option value="cellular">Cellular</option>
                                    <option value="zigbee">Zigbee and Other Mesh Protocols</option>
                                    <option value="bluetooth">Bluetooth and BLE</option>
                                    <option value="wifi">Wi-Fi</option>
                                    <option value="rfid">RFID</option>
                                </select>
                            </div>
                            <div class="form-check form-switch mb-3 fs-5">
                                <input class="form-check-input" role="swich" type="checkbox" name="online" checked>
                                <label class="form-check-label" for="online">{{ _('Active') }}</label>
                            </div>
                            <div class="d-flex justify-content-center">
                                <button type="submit" class="btn btn-primary fs-5">{{ _('Create') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
