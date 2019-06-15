var ADMIN_MESSAGES = [],
    ADMIN_RUBRICA = {},
    ADMIN_CURRENT_TARGET = null;
$(document).ready(()=>{
    let visible = false;
    $icon = $('#app-messanger-toggle');
    $chat = $('.app-messanger-chat');
    $chat_container = $chat.find('.app-messanger-chat-container');
    $chat_text = $chat.find('textarea');
    $chat_send = $chat.find('button');
    $chat_title = $chat.find('.app-messanger-talking');
    $chat_rubrica = $chat.find('.app-messanger-chat-senders');
    $chat.addClass('app-messanger-admin');
    $chat_title.text('Messaggi');

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


    messagePolling($chat_container, $chat_rubrica);
});

function showMessages($container){
    if(ADMIN_CURRENT_TARGET){
        var messages = ADMIN_MESSAGES.filter(x => x.Mittente == ADMIN_CURRENT_TARGET || x.Destinatario == ADMIN_CURRENT_TARGET)
        $container.empty();
        for(var message of messages){ addMessage($container, message.Testo, message.Inviato); }
    }
}

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
    if(ADMIN_CURRENT_TARGET){
        $.ajax({
            type: 'POST',
            url: window.location.href.replace(/ZendProject\/public\/.*/, 'ZendProject/public/api/sendmessage'),
            data: { testo: text, destinatario: ADMIN_CURRENT_TARGET },
            dataType: 'json',
            success: function(res){ if(!res.ok){ $msg.addClass('app-messanger-message-error'); } },
            error: function(){ $msg.addClass('app-messanger-message-error'); }
        })
    }
}


function messagePolling($container, $rubrica){
    $.ajax({
        type: "GET",
        url: window.location.href.replace(/ZendProject\/public\/.*/, 'ZendProject/public/api/checkmessages'),
        success: function (response) {
            ADMIN_MESSAGES = response;
            setMessageRubrica(response, $container, $rubrica);
            showMessages($container);
            setTimeout(()=>{ messagePolling($container, $rubrica); }, 5000);
        },
        error:()=>{ setTimeout(()=>{ messagePolling($container, $rubrica); }, 2000); }
    });

}

function setMessageRubrica(response, $container, $rubrica){
    ADMIN_RUBRICA = {};
    $rubrica.empty();
    for(const message of response){ ADMIN_RUBRICA[message.Inviato ? message.Destinatario : message.Mittente] = message.Utente; }
    for(const rid in ADMIN_RUBRICA){
        const $elem = $('<div>').addClass('app-messanger-rubrica-elemento').text(ADMIN_RUBRICA[rid])
        if(ADMIN_CURRENT_TARGET == rid){ $elem.addClass('active'); }
        $elem.click(()=>{
            ADMIN_CURRENT_TARGET = rid;
            $('.app-messanger-talking').text(ADMIN_RUBRICA[ADMIN_CURRENT_TARGET]);
            $rubrica.children().removeClass('active')
            $elem.addClass('active');
            showMessages($container);
        })
        $rubrica.append($elem);
    }

}