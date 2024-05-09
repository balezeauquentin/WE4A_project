
function insertNotif(notifInfo, element) {
    if (notifInfo.type == 'like') {
        notifInfo.type = '<i class="bi bi-heart-fill text-danger fs-5 text-center"></i>';
    } else if (notifInfo.type == 'comment') {
        notifInfo.type = '<i class="bi bi-chat-left-fill text-info fs-5 text-center"></i>';
    } else if (notifInfo.type == 'follow') {
        notifInfo.type = '<i class="bi bi-person-fill text-success fs-5 text-center"></i>';
    }

    if (notifInfo.is_read == 0) {
        notifInfo.is_read = 'table-active';
    } else {
        notifInfo.is_read = '';
    }

    var html = `
                <tr class="${notifInfo.is_read}">
                <td></td>
                <td>${notifInfo.type}</td>
                <td>${notifInfo.content}</td>
                <td>${notifInfo.created_at}</td>
                <td>
                <button class='btn btn-danger btn-sm' id='delete-btn' data-notif-id='${notifInfo.id}'>Delete</button>
                </td>
                </tr>
    `;

    element.innerHTML = element.innerHTML + html;
}

function insertNoNotif(element) {

    var html = `

    <tr>
    <td></td>
    <td></td>
    <td>No notification yet</td>
    <td></td>
    <td></td>
    </tr>
    `
    element.innerHTML = element.innerHTML + html;
}


$(document).on('click', '#delete-btn', function () {
    var notifId = $(this).data('notif-id');
    $('#confirmModal').data('notif-id', notifId).modal('show');
});

$('#confirmDelete').click(function () {
    var notifId = $('#confirmModal').data('notif-id');
    $.ajax({
        url: 'assets/phptools/notificationManager.php',
        method: 'POST',
        data: { id_notification: notifId,
                deleteNotification: true
         },
        success: function (response) {
            location.reload();
        },
        error: function (xhr, status, error) {
            alert('Une erreur est survenue lors de la suppression de la notification.');
            console.error(error);
        }
    });
    $('#confirmModal').modal('hide');
});

//show notification
$(document).ready(function () {
    var userId = document.body.dataset.userId;
    $.ajax({
        url: 'assets/phptools/notificationManager.php',
        method: 'GET',
        data: {
            getNotifications: true,
            userId: userId
        },
        success: function (notifications) {
            var notifications = JSON.parse(notifications);
            if (notifications.error) {
                var element = document.querySelector('#notif-container');
                insertNoNotif(element);
            } else {
                for (notif of notifications) {
                    var element = document.querySelector('#notif-container');
                    console.log(notif);
                    insertNotif(notif, element);
                }
            }
        }
    });
});
