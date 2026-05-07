<x-layout>
    <x-slot:title>{{ $group->name }} | CampusConnect</x-slot:title>

    <main class="pt-20 bg-[#fdfdfd] h-screen box-border overflow-hidden antialiased">
        <div class="h-full flex flex-col md:flex-row">
            <aside class="w-full md:w-80 lg:w-96 bg-white border-b md:border-b-0 md:border-r border-gray-200 flex-shrink-0 flex flex-col max-h-56 md:max-h-none">
                <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between gap-3">
                    <div>
                        <p class="text-xs font-bold uppercase text-slate-400">Community</p>
                        <h1 class="text-xl font-black text-[#003366]">Groups</h1>
                    </div>
                    <a href="{{ route('community') }}" class="text-sm font-semibold text-blue-600 hover:text-blue-800">Browse</a>
                </div>

                <nav class="flex-1 overflow-y-auto p-3 space-y-2">
                    @foreach($groups as $communityGroup)
                        <a
                            href="{{ route('community.group', $communityGroup->id) }}"
                            class="block rounded-lg border px-4 py-3 transition-colors {{ $communityGroup->id === $group->id ? 'border-blue-200 bg-blue-50' : 'border-transparent hover:bg-slate-50' }}"
                        >
                            <div class="flex items-start justify-between gap-3">
                                <div class="min-w-0">
                                    <p class="font-bold text-sm {{ $communityGroup->id === $group->id ? 'text-blue-800' : 'text-slate-800' }}">{{ $communityGroup->name }}</p>
                                    <p class="text-xs text-slate-500 truncate">{{ $communityGroup->description }}</p>
                                </div>
                                <span class="text-xs font-semibold text-slate-400 flex-shrink-0">{{ $communityGroup->messages_count }}</span>
                            </div>
                        </a>
                    @endforeach
                </nav>
            </aside>

            <section class="flex-1 min-w-0 h-full flex flex-col bg-white">
                <header class="px-5 md:px-8 py-4 border-b border-gray-100 flex-shrink-0">
                    <h2 class="text-2xl md:text-3xl font-black text-[#003366] tracking-tight">{{ $group->name }}</h2>
                    <p class="text-sm md:text-base text-slate-500 truncate">{{ $group->description }}</p>
                </header>

                <div id="messages-container" class="flex-1 min-h-0 overflow-y-auto space-y-4 bg-gray-50 px-5 md:px-8 py-6">
                    @forelse($messages as $message)
                        <div class="flex items-start gap-3" data-message-id="{{ $message->id }}">
                            <div class="w-10 h-10 rounded-full flex items-center justify-center text-white font-bold flex-shrink-0" style="background-color: var(--avatar-color-{{ strtoupper(substr($message->user->username, 0, 1)) }});">
                                {{ substr($message->user->username, 0, 1) }}
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center gap-2">
                                    <p class="font-semibold text-gray-800">{{ $message->user->username }}</p>
                                    <p class="text-xs text-gray-400">{{ $message->created_at->format('M d, H:i') }}</p>
                                </div>
                                <p class="text-gray-600 break-words">{{ $message->message }}</p>
                            </div>
                        </div>
                    @empty
                        <p class="text-center text-gray-400 py-4">No messages yet. Start the conversation!</p>
                    @endforelse
                </div>

                <div class="border-t border-gray-200 bg-white px-5 md:px-8 py-4 flex-shrink-0">
                    <form id="message-form" onsubmit="return sendMessage(event)" action="{{ route('community.message.send', $group->id) }}" method="POST" class="flex gap-2">
                        @csrf
                        <input
                            type="text"
                            id="message-input"
                            name="message"
                            placeholder="Type your message..."
                            class="flex-1 min-w-0 px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                            maxlength="1000"
                            autocomplete="off"
                        >
                        <button
                            type="submit"
                            class="bg-blue-600 text-white px-5 md:px-7 py-3 rounded-lg hover:bg-blue-700 transition-colors font-medium flex-shrink-0"
                        >
                            Send
                        </button>
                    </form>
                </div>
            </section>
        </div>
    </main>

    @push('scripts')
    <style>
        :root {
            --avatar-color-A: #EF4444;
            --avatar-color-B: #12bb1a;
            --avatar-color-C: #EAB308;
            --avatar-color-D: #22C55E;
            --avatar-color-E: #10B981;
            --avatar-color-F: #14B8A6;
            --avatar-color-G: #06B6D4;
            --avatar-color-H: #0EA5E9;
            --avatar-color-I: #3B82F6;
            --avatar-color-J: #6366F1;
            --avatar-color-K: #8B5CF6;
            --avatar-color-L: #D946EF;
            --avatar-color-M: #EC4899;
            --avatar-color-N: #F43F5E;
            --avatar-color-O: #EA580C;
            --avatar-color-P: #B45309;
            --avatar-color-Q: #92400E;
            --avatar-color-R: #7C2D12;
            --avatar-color-S: #7C2D12;
            --avatar-color-T: #1E40AF;
            --avatar-color-U: #1E3A8A;
            --avatar-color-V: #1F2937;
            --avatar-color-W: #111827;
            --avatar-color-X: #EF4444;
            --avatar-color-Y: #F97316;
            --avatar-color-Z: #EAB308;
            --avatar-color-0: #3B82F6;
            --avatar-color-1: #8B5CF6;
            --avatar-color-2: #D946EF;
            --avatar-color-3: #EC4899;
            --avatar-color-4: #F43F5E;
            --avatar-color-5: #EF4444;
            --avatar-color-6: #F97316;
            --avatar-color-7: #EAB308;
            --avatar-color-8: #22C55E;
            --avatar-color-9: #10B981;
        }
    </style>
    <script>
        const groupId = {{ $group->id }};
        const userId = {{ Auth::id() }};
        const username = @json(Auth::user()->username);
        let lastMessageId = {{ $messages->max('id') ?? 0 }};
        let isFetchingMessages = false;

        function sendMessage(event) {
            event.preventDefault();

            const messageInput = document.getElementById('message-input');
            const message = messageInput.value.trim();

            if (!message) return false;

            const form = document.getElementById('message-form');
            const submitButton = form.querySelector('button[type="submit"]');
            const tokenElement = form.querySelector('input[name="_token"]');

            if (!tokenElement) {
                console.error('CSRF token not found');
                alert('Security token missing. Please refresh the page.');
                return false;
            }

            submitButton.disabled = true;
            submitButton.textContent = 'Sending...';

            fetch(`/community/group/${groupId}/message`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': tokenElement.value,
                    'Accept': 'application/json',
                },
                body: JSON.stringify({ message: message })
            })
            .then(response => {
                if (!response.ok) {
                    return response.json().then(err => {
                        throw new Error(err.message || `HTTP error! status: ${response.status}`);
                    }).catch(() => {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    });
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    messageInput.value = '';
                    messageInput.focus();
                    addMessageToUI(data.message);
                } else {
                    alert('Failed to send message: ' + (data.error || 'Unknown error'));
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error sending message: ' + error.message);
            })
            .finally(() => {
                submitButton.disabled = false;
                submitButton.textContent = 'Send';
            });

            return false;
        }

        function addMessageToUI(message) {
            const container = document.getElementById('messages-container');
            const emptyMessage = container.querySelector('p.text-center');

            if (emptyMessage) {
                emptyMessage.remove();
            }

            if (document.querySelector(`[data-message-id="${message.id}"]`)) {
                return;
            }

            lastMessageId = Math.max(lastMessageId, Number(message.id));

            const messageDiv = document.createElement('div');
            messageDiv.className = 'flex items-start gap-3';
            messageDiv.setAttribute('data-message-id', message.id);

            const timeStr = new Date(message.created_at).toLocaleString('en-US', {
                month: 'short',
                day: 'numeric',
                hour: '2-digit',
                minute: '2-digit',
                hour12: false
            });

            const avatarLetter = message.user.username.charAt(0).toUpperCase();

            messageDiv.innerHTML = `
                <div class="w-10 h-10 rounded-full flex items-center justify-center text-white font-bold flex-shrink-0" style="background-color: var(--avatar-color-${avatarLetter});">
                    ${escapeHtml(avatarLetter)}
                </div>
                <div class="flex-1 min-w-0">
                    <div class="flex items-center gap-2">
                        <p class="font-semibold text-gray-800">${escapeHtml(message.user.username)}</p>
                        <p class="text-xs text-gray-400">${timeStr}</p>
                    </div>
                    <p class="text-gray-600 break-words">${escapeHtml(message.message)}</p>
                </div>
            `;

            container.appendChild(messageDiv);
            container.scrollTop = container.scrollHeight;
        }

        function escapeHtml(text) {
            const div = document.createElement('div');
            div.textContent = text;
            return div.innerHTML;
        }

        function fetchNewMessages() {
            if (isFetchingMessages || document.hidden) {
                return;
            }

            isFetchingMessages = true;

            fetch(`/community/group/${groupId}/messages?after_id=${lastMessageId}`, {
                headers: {
                    'Accept': 'application/json',
                },
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }

                return response.json();
            })
            .then(data => {
                data.messages
                    .filter(message => Number(message.id) > lastMessageId)
                    .forEach(addMessageToUI);
            })
            .catch(error => {
                console.error('Error fetching messages:', error);
            })
            .finally(() => {
                isFetchingMessages = false;
            });
        }

        setInterval(fetchNewMessages, 2000);

        document.addEventListener('visibilitychange', () => {
            if (!document.hidden) {
                fetchNewMessages();
            }
        });

        window.addEventListener('load', () => {
            const container = document.getElementById('messages-container');
            setTimeout(() => {
                container.scrollTop = container.scrollHeight;
            }, 100);
        });
    </script>
    @endpush
</x-layout>
