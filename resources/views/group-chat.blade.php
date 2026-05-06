<x-layout>
    <x-slot:title>{{ $group->name }} | CampusConnect</x-slot:title>

    <main class="pt-28 pb-12 bg-[#fdfdfd] min-h-screen antialiased">
        <div class="max-w-[1600px] mx-auto px-6 md:px-12">
            <div class="mb-8">
                <a href="{{ route('community') }}" class="text-blue-600 hover:text-blue-800 mb-2 inline-block">&larr; Back to Community</a>
                <h1 class="text-4xl font-black text-[#003366] tracking-tight">{{ $group->name }}</h1>
                <p class="text-gray-600">{{ $group->description }}</p>
            </div>

            <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6 flex flex-col h-screen md:h-auto md:max-h-[600px]">
                <!-- Messages Container -->
                <div id="messages-container" class="flex-1 overflow-y-auto mb-4 space-y-4 bg-gray-50 p-4 rounded-lg">
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

                <!-- Message Input -->
                <div class="border-t pt-4">
                    <form id="message-form" onsubmit="return sendMessage(event)" action="{{ route('community.message.send', $group->id) }}" method="POST" class="flex gap-2">
                        @csrf
                        <input 
                            type="text" 
                            id="message-input"
                            name="message"
                            placeholder="Type your message..." 
                            class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                            maxlength="1000"
                        >
                        <button 
                            type="submit" 
                            class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition-colors font-medium"
                        >
                            Send
                        </button>
                    </form>
                </div>
            </div>
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
        function getAvatarColor(letter) {
            const key = `--avatar-color-${letter.toUpperCase()}`;
            return `var(${key})`;
        }
        const groupId = {{ $group->id }};
        const userId = {{ Auth::id() }};
        const username = @json(Auth::user()->username);
        let lastMessageId = {{ $messages->max('id') ?? 0 }};
        let isFetchingMessages = false;

        // Initialize Echo broadcasting if available
        if (window.Echo) {
            // Subscribe to the private channel for this group
            window.Echo.private(`community.group.${groupId}`)
                .listen('.message.sent', (data) => {
                    addMessageToUI(data.message);
                });
        }

        // Handle form submission with AJAX
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

            // Send message to server using AJAX
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
                console.log('Response status:', response.status);
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
                console.log('Success response:', data);
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

        // Add message to UI
        function addMessageToUI(message) {
            const container = document.getElementById('messages-container');
            
            // Check if this is the first message (no messages placeholder)
            const emptyMessage = container.querySelector('p.text-center');
            if (emptyMessage) {
                emptyMessage.remove();
            }

            // Check if message already exists (to prevent duplicates)
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

            messageDiv.innerHTML = `
                <div class="w-10 h-10 rounded-full flex items-center justify-center text-white font-bold flex-shrink-0" style="background-color: var(--avatar-color-${message.user.username.charAt(0).toUpperCase()});">
                    ${escapeHtml(message.user.username.charAt(0).toUpperCase())}
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
            // Auto-scroll to bottom
            container.scrollTop = container.scrollHeight;
        }

        // Escape HTML to prevent XSS
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

        // Scroll to bottom on page load
        window.addEventListener('load', () => {
            const container = document.getElementById('messages-container');
            setTimeout(() => {
                container.scrollTop = container.scrollHeight;
            }, 100);
        });
    </script>
    @endpush
</x-layout>
