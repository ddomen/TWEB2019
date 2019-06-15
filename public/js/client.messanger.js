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
            var $msg = addMessage($chat_container, txt, true);
            $chat_text.val('');
            sendMessage(txt, $msg);
        }
    })
    $chat_text.on('keydown', (e)=>{
        if(e.which == 13){
            $chat_send.click();
            e.preventDefault();
        }
    });


    messagePolling($chat_container);
});

function addMessage($container, txt, outgoing){
    var $msg = $('<p>');
    $msg.addClass('app-messanger-message')
        .addClass( outgoing ? 'app-messanger-message-outgoing' : 'app-messanger-message-incoming');
    $msg.text(txt);

    $container.append($msg);
    $container.scrollTop(10000);

    return $msg;
}

function sendMessage(text, $msg){
    $.ajax({
        type: 'POST',
        url: window.location.href.replace(/ZendProject\/public\/.*/, 'ZendProject/public/api/sendmessage'),
        data: { testo: text },
        dataType: 'json',
        success: function(res){ if(!res.ok){ $msg.addClass('app-messanger-message-error'); } },
        error: function(){ $msg.addClass('app-messanger-message-error'); }
    })
}


function messagePolling($container){
    $.ajax({
        type: "GET",
        url: window.location.href.replace(/ZendProject\/public\/.*/, 'ZendProject/public/api/checkmessages'),
        success: function (response) {
            $container.empty();
            for(var message of response){ addMessage($container, message.Testo, message.Inviato); }
            setTimeout(()=>{ messagePolling($container); }, 5000);
        },
        error:()=>{ setTimeout(()=>{ messagePolling($container); }, 2000); }
    });

}