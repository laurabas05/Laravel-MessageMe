@extends('layouts.chat')

@section('title', 'Chats')

@section('content')
<div class="container-fluid vh-100">
    <div class="row h-100">

        <!-- ================= SIDEBAR ================= -->
        <div class="col-4 col-md-3 p-0 bg-dark border-end border-secondary d-flex flex-column">

            <div class="p-3 fw-bold text-white border-bottom border-secondary">
                Chats
            </div>

            <div class="flex-grow-1 overflow-auto">

                @foreach ($conversations as $conversation)
                @php
                $otherUser = $conversation->otherUser(auth()->user());
                $isActive = isset($currentConversation) && $currentConversation->id === $conversation->id;
                @endphp

                <a href="{{ route('chat.show', $conversation) }}" class="d-flex align-items-center p-3 text-decoration-none
                              {{ $isActive ? 'bg-secondary' : 'chat-item' }}">

                    <img src="{{ $otherUser->profile_photo
                                ? asset('storage/' . $otherUser->profile_photo)
                                : asset('default-avatar.png') }}" class="rounded-circle me-3" width="45" height="45">

                    <div class="text-white">
                        <strong>{{ $otherUser->name }}</strong><br>
                        <small class="text-muted">
                            {{ $conversation->lastMessage?->body ?? 'Sin mensajes aún' }}
                        </small>
                    </div>
                </a>
                @endforeach

            </div>
        </div>

        <!-- ================= CHAT AREA ================= -->
        <div class="col-8 col-md-9 p-0 d-flex flex-column bg-black">

            @isset($currentConversation)

            <!-- HEADER -->
            <div class="p-3 border-bottom border-secondary d-flex align-items-center text-white">
                <img src="{{ $otherUser->profile_photo
                            ? asset('storage/' . $otherUser->profile_photo)
                            : asset('default-avatar.png') }}" class="rounded-circle me-2" width="40" height="40">
                <strong>{{ $otherUser->name }}</strong>
            </div>

            <!-- MENSAJES -->
            <div class="flex-grow-1 p-3 overflow-auto">

                @foreach ($messages as $message)

                @if ($message->user_id === auth()->id())
                <!-- MENSAJE ENVIADO -->
                <div class="d-flex justify-content-end mb-3">
                    <div class="me-2 text-end">
                        <div class="bg-success text-white p-2 rounded">
                            {{ $message->body }}
                        </div>
                    </div>

                    <img src="{{ auth()->user()->profile_photo
                                        ? asset('storage/' . auth()->user()->profile_photo)
                                        : asset('default-avatar.png') }}" class="rounded-circle" width="35"
                        height="35">
                </div>
                @else
                <!-- MENSAJE RECIBIDO -->
                <div class="d-flex justify-content-start mb-3">
                    <img src="{{ $message->user->profile_photo
                                        ? asset('storage/' . $message->user->profile_photo)
                                        : asset('default-avatar.png') }}" class="rounded-circle me-2" width="35"
                        height="35">

                    <div class="bg-secondary text-white p-2 rounded">
                        {{ $message->body }}
                    </div>
                </div>
                @endif

                @endforeach

            </div>

            <!-- INPUT -->
            <div class="p-3 border-top border-secondary">
                <form method="POST" action="{{ route('messages.store', $currentConversation) }}" class="d-flex gap-2">
                    @csrf
                    <input name="body" class="form-control bg-dark text-white border-secondary"
                        placeholder="Escribe un mensaje..." autocomplete="off">
                    <button class="btn btn-success">Enviar</button>
                </form>
            </div>

            @else
            <!-- PANTALLA VACÍA -->
            <div class="d-flex flex-column justify-content-center align-items-center h-100 text-muted">
                <h4>Selecciona un chat</h4>
                <p>Empieza una conversación</p>
            </div>
            @endisset

        </div>
    </div>
</div>
@endsection