@extends('layouts.app')

@section('content')
<div class="container-fluid vh-100">
    <div class="row h-100">

        <!-- Sidebar -->
        <div class="col-4 border-end p-3">
            <h5>Chats</h5>

            <ul class="list-group">
                <li class="list-group-item active">
                    Laura
                </li>
                <li class="list-group-item">
                    Juan
                </li>
            </ul>
        </div>

        <!-- Chat -->
        <div class="col-8 d-flex flex-column">

            <!-- Header -->
            <div class="border-bottom p-3">
                <strong>Laura</strong>
            </div>

            <!-- Messages -->
            <div class="flex-grow-1 p-3 overflow-auto">
                <div class="mb-2">
                    <span class="badge bg-secondary">Hola 👋</span>
                </div>
                <div class="mb-2 text-end">
                    <span class="badge bg-primary">Qué tal?</span>
                </div>
            </div>

            <!-- Input -->
            <div class="border-top p-3">
                <form>
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Escribe un mensaje">
                        <button class="btn btn-success">Enviar</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
@endsection
