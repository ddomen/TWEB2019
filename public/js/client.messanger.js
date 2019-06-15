$(document).ready(()=>{
    let visible = false;
    $icon = $('#app-messanger-toggle');
    $chat = $('.app-messanger-chat');
    $chat_container = $chat.find('.app-messanger-chat-container');
    $chat_text = $chat.find('textarea');
    $chat_send = $chat.find('button');

    $icon.click(()=>{
        visible = !visible;
        if(visible){ $icon.removeClass('fa-comment-dots').addClass('fa-times-circle active') }
        else{ $icon.addClass('fa-comment-dots').removeClass('fa-times-circle active') }
        $chat.toggle(200);
        $chat_container.scrollTop(10000);
    })
    $chat_send.click(()=>{
        var txt = $chat_text.val().trim();
        if(txt){
            $msg = $('<p>');
            $msg.addClass('app-messanger-message').addClass('app-messanger-message-outgoing');
            $msg.text(txt);
    
            $chat_container.append($msg);
            $chat_container.scrollTop(10000);
            $chat_text.val('');
        }
    })
    $chat_text.on('keydown', (e)=>{
        if(e.which == 13){
            $chat_send.click();
            e.preventDefault();
        }
    });
})