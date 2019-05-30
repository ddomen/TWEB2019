$(document).ready(()=>{
    $icon = $('.app-messanger-icon');
    $chat = $('.app-messanger-chat');
    $chat_container = $chat.find('.app-messanger-chat-container');
    $chat_text = $chat.find('textarea');
    $chat_send = $chat.find('button');

    $icon.click(()=>{
        $chat.toggle(200);
        $chat_container.scrollTop(10000);
    })
    $chat_send.click(()=>{
        $msg = $('<p>');
        $msg.addClass('app-messanger-message').addClass('app-messanger-message-outgoing');
        $msg.text($chat_text.val());

        $chat_container.append($msg);
        $chat_container.scrollTop(10000);
    })
})