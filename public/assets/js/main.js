$(document).ready(function () {

    getMessage();

    let urlBase = "http://127.0.0.1:8000/api/";

    $("#sendMessage").click(function () {

        /*
          Params
         */
        let email = $("#email").val()
        let id = $("#id").val()
        let msgTo = $("#msgTo").val()
        let idUSerTo = $("#idUSerTo").val()
        let idChat = $("#idChat").val()
        let nivel = $("#nivel").val()

        let textMessage = $("#textMessage").val();


        let $template = $(".template");
        let user1Img = $template.find('.userImage').attr('data-user1');
        let user2Img = $template.find('.userImage').attr('data-user2');


        let $newMsgHtml = $template.clone();

        if (nivel == "pa") {

            $newMsgHtml.attr('class', 'container ');
            $newMsgHtml.find('.userImage').attr('src', user1Img);
            $newMsgHtml.find('.userImage').attr('class', 'userImage');
            $newMsgHtml.find('.message').html(textMessage);

        } else {
            $newMsgHtml.attr('class', 'container darker');
            $newMsgHtml.find('.userImage').attr('src', user2Img);
            $newMsgHtml.find('.userImage').attr('class', 'userImage right');
            $newMsgHtml.find('.message').html(textMessage);
        }


        $newMsgHtml.removeClass('template');

        let $messages = $('.messages');


        console.log(textMessage);

        let formData = {
            email: email,
            msgTo: msgTo,
            messageText: textMessage,
            idUSerTo: parseInt(idUSerTo),
            messageDate: '2019-08-01',
            user: '/api/users/' + id,
            idChat: parseInt(idChat)
        }

        $.ajax({
            url: urlBase + "chat_messages",
            type: 'post',
            data: JSON.stringify(formData),
            contentType: "application/json",
            beforeSend: function () {
                $(".messages").append("<div class='sendingMessage'> ENVIANDO...</div>");
            }
        })
            .done(function (msg) {
                $("#textMessage").val("");
                $(".sendingMessage").remove();
                $messages.append($newMsgHtml);

                console.log(msg);
            })

            .fail(function (jqXHR, textStatus, msg) {
                alert(msg);
            });
    });


});

function getMessage() {

    let urlBase = "http://127.0.0.1:8000/api/";
    let $messages = $('.messages');

    $.ajax({
        url: urlBase + "chat_messages",
        type: 'get',
        data: {
            idChat: 99
        },
        contentType: "application/json",
        beforeSend: function (request) {
            request.setRequestHeader("accept", 'application/json');
            $(".messages").append("<div class='sendingMessage'> Aguarde...</div>");
        },
    })
        .done(function (msg) {
            $(".sendingMessage").remove();
            console.log((msg));
            $.each((msg), function (key, value) {

                let textMessage = value.messageText;

                let $template = $(".template");
                let user1Img = $template.find('.userImage').attr('data-user1');
                let user2Img = $template.find('.userImage').attr('data-user2');

                let $newMsgHtml = $template.clone();

                $newMsgHtml.find('.message').html(textMessage);

                if (value.email === 'wlad.fral@gmail.com') {
                    $newMsgHtml.attr('class', 'container darker');
                    $newMsgHtml.find('.userImage').attr('src', user2Img);
                    $newMsgHtml.find('.userImage').attr('class', 'userImage right');
                } else {
                    $newMsgHtml.find('.userImage').attr('src', user1Img);
                }
                $newMsgHtml.removeClass('template');

                $(".load").remove();
                $messages.append($newMsgHtml);
            });

        })

        .fail(function (jqXHR, textStatus, msg) {
            alert(msg);
        });


}