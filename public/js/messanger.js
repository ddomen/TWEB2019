$(document).ready(()=>{
    $icon = $('.app-messanger-icon');
    $chat = $('.app-messanger-chat');

    $chat.hide();

    $icon.click(()=>{
        $chat.toggle(200);
    })
})