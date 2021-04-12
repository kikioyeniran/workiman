@extends('account.layouts.app')

@section('page_styles')
    <style>
        .select2.select2-container.select2-container--default {
            width: 100% !important;
        }

        .dollar-before::before {
            content: '$';
        }

        .no-contest-container {
            padding: 50px 20px;
            flex-direction: column;
            align-items: center;
            display: flex;
            color: black;
        }

        .no-contest-container i {
            font-size: 40px;
            margin-bottom: 30px;
        }

        .browse-contests-card {
            background-color: white;
            box-shadow: 3px 3px 15px 1px rgba(0, 0, 0, 0.15) !important;
            border-radius: 5px;
        }

        .browse-contests-card-left img {
            max-height: 200px;
        }

    </style>
@endsection

@section('page_content')
    <div class="dashboard-headline margin-bottom-20">
        <h3>Messages</h3>
        {{-- <span>We are glad to see you again!</span> --}}

        <nav id="breadcrumbs" class="dark">
            <ul>
                <li><a href="#">Home</a></li>
                <li>Messages</li>
            </ul>
        </nav>
    </div>

    <div class="messages-container margin-top-0">

        <div class="messages-container-inner">

            <!-- Messages -->
            <div class="messages-inbox">
                <div class="messages-headline d-none">
                    <div class="input-with-icon">
                        <input id="autocomplete-input" type="text" placeholder="Search">
                        <i class="icon-material-outline-search"></i>
                    </div>
                </div>

                <ul class="conversations-list"></ul>
            </div>
            <!-- Messages / End -->

            <!-- Message Content -->
            <div class="message-content">

                <div class="messages-headline">
                    <h4 class="active-conversation-user-name"></h4>
                    {{-- <a href="#" class="message-action"><i class="icon-feather-trash-2"></i> Delete Conversation</a> --}}
                </div>

                <!-- Message Content Inner -->
                <div class="message-content-inner" style="height: 60vh">

                    <!-- Time Sign -->
                    {{-- <div class="message-time-sign">
                        <span>28 June, 2018</span>
                    </div> --}}

                    {{-- <div class="message-bubble">
                        <div class="message-bubble-inner">
                            <div class="message-avatar"><img src="images/user-avatar-small-02.jpg" alt="" /></div>
                            <div class="message-text">
                                <p>Great. If you need any further clarification let me know. 👍</p>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>

                    <div class="message-bubble me">
                        <div class="message-bubble-inner">
                            <div class="message-avatar"><img src="images/user-avatar-small-01.jpg" alt="" /></div>
                            <div class="message-text">
                                <p>Ok, I will. 😉</p>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>

                    <!-- Time Sign -->
                    <div class="message-time-sign">
                        <span>Yesterday</span>
                    </div>

                    <div class="message-bubble me">
                        <div class="message-bubble-inner">
                            <div class="message-avatar"><img src="images/user-avatar-small-01.jpg" alt="" /></div>
                            <div class="message-text">
                                <p>Hi Sindy, I just wanted to let you know that project is finished and I'm waiting for your
                                    approval.</p>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>

                    <div class="message-bubble">
                        <div class="message-bubble-inner">
                            <div class="message-avatar"><img src="images/user-avatar-small-02.jpg" alt="" /></div>
                            <div class="message-text">
                                <p>Hi Tom! Hate to break it to you, but I'm actually on vacation 🌴 until Sunday so I can't
                                    check it now. 😎</p>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>

                    <div class="message-bubble me">
                        <div class="message-bubble-inner">
                            <div class="message-avatar"><img src="images/user-avatar-small-01.jpg" alt="" /></div>
                            <div class="message-text">
                                <p>Ok, no problem. But don't forget about last payment. 🙂</p>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>

                    <div class="message-bubble">
                        <div class="message-bubble-inner">
                            <div class="message-avatar"><img src="images/user-avatar-small-02.jpg" alt="" /></div>
                            <div class="message-text">
                                <!-- Typing Indicator -->
                                <div class="typing-indicator">
                                    <span></span>
                                    <span></span>
                                    <span></span>
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div> --}}
                </div>
                <!-- Message Content Inner / End -->

                <!-- Reply Area -->
                <div class="message-reply">
                    <textarea name="new_message" data-user="{{ $user_2 }}" cols="1" rows="1"
                        placeholder="Your Message" data-autoresize></textarea>
                    <button name="send_new_message" class="button ripple-effect">Send</button>
                </div>

            </div>
            <!-- Message Content -->

        </div>
    </div>


@endsection

@section('page_scripts')
    <script>
        // $('#registerFreelancerModal').modal('show')
        const conversations_list = $('ul.conversations-list')
        const conversation_messages_container = $(".message-content-inner")
        const user = JSON.parse(`{!! $user !!}`)
        let conversations = JSON.parse(`{!! $conversations !!}`)
        console.log(conversations[0])
        // alert(`{!! $user_2 !!}`)
        let conversation_user // = `{!! $user_2 !!}` != null ? JSON.parse(`{!! $user_2 !!}`) : null
        const new_message = $('textarea[name=new_message]')
        const send_new_message_btn = $('button[name=send_new_message]')

        send_new_message_btn.on('click', function() {
            let message = new_message.val().trim()

            if (message != '' && conversation_user) {
                // Send message
                loading_container.show()
                let payload = {
                    message: message,
                    content_type: 'text',
                    user_id: conversation_user.id,
                    _token
                }
                fetch(`{{ route('account.conversations.send-message') }}`, {
                        method: 'post',
                        headers: {
                            'Accept': 'application/json',
                            'Content-type': 'application/json'
                        },
                        body: JSON.stringify(payload)
                    }).then(async response => {
                        let data = await response.json()
                        switch (response.status) {
                            case 200:
                                return data
                                break;
                            default:
                                throw new Error(data.message)
                                break;
                        }
                    })
                    .then(async responseJson => {
                        Snackbar.show({
                            text: responseJson.message,
                            pos: 'top-center',
                            showAction: false,
                            actionText: "Dismiss",
                            duration: 5000,
                            textColor: '#fff',
                            backgroundColor: 'green'
                        });

                        loading_container.hide();
                        new_message.val('')

                        // Refresh Active Conversation
                        conversations = responseJson.conversations
                        setActiveConversation(conversation_user)
                    })
                    .catch(error => {
                        console.log("Error occurred: ", error);
                        Snackbar.show({
                            text: `Error occurred, please try again`,
                            pos: 'top-center',
                            showAction: false,
                            actionText: "Dismiss",
                            duration: 5000,
                            textColor: '#fff',
                            backgroundColor: '#721c24'
                        });
                    })
            } else {
                console.log("Convo User: ", conversation_user)
            }
        })

        $(document).ready(function() {
            // Set active conversation
            conversation_user = new_message.data('user')
            setActiveConversation(conversation_user)
        });

        function setConversationAsActive(conversation_index) {
            console.log(conversation_index)
            let convo = conversations[conversation_index]
            console.log(convo)
            conversation_user = convo.user_1_id == user.id ? convo.user_2 : convo.user_1
            // conversation_user
            setActiveConversation(conversation_user)
        }

        function setActiveConversation(active_conversation_user) {
            conversation_user = active_conversation_user

            conversations_list.html('')
            conversation_messages_container.html('')

            conversations.sort((a, b) => b.last_message.created_at < a.last_message.created_at ? -1 : 1).map((
                conversation, index) => {
                // console.log(JSON.stringify(conversation))
                let other_user = conversation.user_1_id == user.id ? conversation.user_2 : conversation.user_1
                conversations_list.append(
                    `<li class="${conversation_user.id == conversation.user_1_id || conversation_user.id == conversation.user_2_id ? 'active-message' : ''}"><a onclick="setConversationAsActive(${index})"><div class="message-avatar"><img src="${webRoot + (other_user.avatar ? `storage/avatars/${other_user.avatar}` : `_home/images/user-avatar-big-02.jpg`)}" alt="" /></div><div class="message-by"><div class="message-by-headline"><h5>${other_user.display_name}</h5><span>${conversation.last_message.created_at_diff}</span></div><p>${conversation.last_message.content}</p></div></a></li>`
                )
            })

            if (active_conversation_user == null || active_conversation_user == '') {
                $('.message-reply').hide()
                return
            } else {
                $('.message-reply').show()
            }

            $('.active-conversation-user-name').text(active_conversation_user.display_name)

            console.log(active_conversation_user)

            let active_conversation_index = conversations.findIndex(conversation => {
                return conversation.user_1_id == active_conversation_user.id || conversation.user_2_id ==
                    active_conversation_user
                    .id
            })

            console.log(active_conversation_index)

            if (active_conversation_index > -1) {
                let active_conversation = conversations[active_conversation_index]
                // Append messages from conversation
                active_conversation.messages.sort((a, b) => b.created_at < a.created_at ? 1 : -1).map(message => {
                    conversation_messages_container.append(
                        `<div class="message-bubble ${user.id == message.user_id ? 'me' : ''}"><div class="message-bubble-inner"><div class="message-avatar"><img src="${webRoot + (message.user.avatar ? `storage/avatars/${message.user.avatar}` : `_home/images/user-avatar-big-02.jpg`)}" alt="" /></div><div class="message-text"><p>${message.content}</p></div></div><div class="clearfix"></div></div>`
                    )
                })
            }

            conversation_messages_container.animate({
                scrollTop: conversation_messages_container[0].scrollHeight
            }, 1000);
        }

    </script>
@endsection
