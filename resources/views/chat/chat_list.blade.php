@extends('layouts.chat')

@section('title', 'Chats')

@section('content')
<div class="container-fluid" style="height: calc(100vh - 56px);">
    <div class="row h-100">

        <!-- ================= SIDEBAR ================= -->
        <div class="col-4 col-md-3 p-0 bg-dark border-end border-secondary d-flex flex-column">

            <div class="d-flex justify-content-between align-items-center p-3 border-bottom border-secondary text-white">
                <strong>Chats</strong>

                <button class="btn btn-sm btn-outline-light" data-bs-toggle="modal" data-bs-target="#newChatModal">
                    +
                </button>
            </div>


            <div class="flex-grow-1 overflow-auto">
                @foreach ($conversations as $conversation)
                @php
                $sidebarUser = $conversation->otherUser(auth()->user());
                $isActive = optional($currentConversation)->id === $conversation->id;
                @endphp

                <a href="{{ route('chat_list', ['conversation' => $conversation->id]) }}" class="d-flex align-items-center p-3 text-decoration-none
                                        {{ $isActive ? 'bg-secondary' : 'chat-item' }}">

                    <img src="{{ $sidebarUser->profile_photo
                    ? asset('storage/' . $sidebarUser->profile_photo)
                    : asset('default-avatar.png') }}" class="rounded-circle me-3" width="45" height="45">


                    <div class="text-white">
                        <strong>{{ $sidebarUser->name }}</strong><br>
                        <small class="text-white">
                            {{ optional($conversation->lastMessage)->content ?? 'Sin mensajes' }}
                        </small>
                    </div>
                </a>
                @endforeach

            </div>
        </div>

        <!-- ================= CHAT AREA ================= -->
        <div class="col-8 col-md-9 p-0 d-flex flex-column bg-black h-100">

            @if($currentConversation)

            <!-- HEADER -->
            <div class="p-3 border-bottom border-secondary d-flex align-items-center text-white">
                <img src="{{ $otherUser->profile_photo
                ? asset('storage/' . $otherUser->profile_photo)
                : asset('default-avatar.png') }}" class="rounded-circle me-2" width="40" height="40">

                <strong>{{ $otherUser->name }}</strong>
            </div>

            <!-- MENSAJES -->
            <div class="flex-grow-1 p-3 overflow-auto" style="min-height: 0;" id="messages">

                @foreach ($currentConversation->messages as $message)

                @if ($message->user_id === auth()->id())
                <!-- MENSAJE ENVIADO -->
                <div class="d-flex justify-content-end mb-3">
                    <div class="me-2 text-end">
                        <div class="bg-success text-white p-2 rounded">
                            {{ $message->content }}
                        </div>
                    </div>

                    <img src="{{ $message->user->profile_photo
                                ? asset('storage/' . $message->user->profile_photo)
                                : asset('default-avatar.png') }}" class="rounded-circle me-2" width="35" height="35">

                </div>
                @else
                <!-- MENSAJE RECIBIDO -->
                <div class="d-flex justify-content-start mb-3">
                    <img src="{{ $message->user->profile_photo
                                ? asset('storage/' . $message->user->profile_photo)
                                : asset('default-avatar.png') }}" class="rounded-circle me-2" width="35" height="35">

                    <div class="bg-secondary text-white p-2 rounded">
                        {{ $message->content }}
                    </div>
                </div>
                @endif

                @endforeach

            </div>

            <!-- INPUT -->
            <div class="p-3 border-top border-secondary">
                <form id="message-form" class="d-flex gap-2" action="{{ route('messages.store', $currentConversation->id) }}" method="POST">
                    @csrf
                    <input id="message-input" name="content" class="form-control bg-dark text-white border-secondary"
                        placeholder="Escribe un mensaje..." autocomplete="off">
                    <button class="btn btn-success" type="submit">Enviar</button>
                </form>
            </div>

            @else
            <!-- PANTALLA VACÍA -->
            <div class="d-flex flex-column justify-content-center align-items-center h-100 text-muted">
                <h4>Selecciona un chat</h4>
                <p>Empieza una conversación</p>
            </div>
            @endisset

            <div class="modal fade" id="newChatModal" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content bg-dark text-light">

                        <div class="modal-header border-secondary">
                            <h5 class="modal-title">Nuevo chat</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                        </div>

                        <form method="POST" action="{{ route('chat.start') }}">
                            @csrf

                            <div class="modal-body">
                                <label class="form-label">Nombre del usuario</label>
                                <input type="text" name="username" class="form-control" placeholder="Ex: Juan" required>
                            </div>

                            <div class="modal-footer border-secondary">
                                <button type="submit" class="btn btn-success">
                                    Crear chat
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@if ($currentConversation)
<script>
document.addEventListener('DOMContentLoaded', () => {
    const conversationId = {{ $currentConversation->id }};
    const messagesContainer = document.getElementById('messages');
    const form = document.getElementById('message-form');
    const input = document.getElementById('message-input');

    window.Echo.private(`conversation.${conversationId}`)
        .listen('.message.sent', (e) => {
            console.log('Mensaje recibido', e.message);
            const message = e.message;

            if (message.user_id === {{ auth()->id() }}) return;

            const div = document.createElement('div');
            div.classList.add('d-flex', 'justify-content-start', 'mb-3');
            div.innerHTML = `
                <img src="${message.user.profile_photo_url}" class="rounded-circle me-2" width="35" height="35">

                <div class="bg-secondary text-white p-2 rounded">
                    ${message.content}
                </div>
            `;
            messagesContainer.appendChild(div);
            messagesContainer.scrollTop = messagesContainer.scrollHeight;
        });

    //Envío AJAX
    form.addEventListener('submit', async (e) => {
        e.preventDefault();

        const content = input.value.trim();
        if (!content) return;

        const response = await fetch(form.action, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ content })
        });

        const data = await response.json();
        const message = data.message;

        //Mensaje propio (instantáneo)
        const div = document.createElement('div');
        div.classList.add('d-flex', 'justify-content-end', 'mb-3');
        div.innerHTML = `
            <div class="me-2 text-end">
                <div class="bg-success text-white p-2 rounded">
                    ${message.content}
                </div>
            </div>

            <img src="${message.user.profile_photo_url}" class="rounded-circle me-2" width="35" height="35">
        `;
        messagesContainer.appendChild(div);
        messagesContainer.scrollTop = messagesContainer.scrollHeight;

        input.value = '';
    });
});
</script>
@endif
@endsection