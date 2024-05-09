
function insertNotif(notifInfo,element) {

    var html = `
                <tr>
                <td>${notifInfo.id}</td>
                <td>${notifInfo.type}</td>
                <td>${notifInfo.content}</td>
                <td>${notifInfo.created_at}</td>
                <td>
                <button class='btn btn-danger btn-sm delete-btn' data-notif-id='${notifInfo.id}'>Delete</button>
                </td>
                </tr>
    `;

    element.innerHTML = element.innerHTML + html;
}

function insertNoNotif (element) {

    var html = `
    <div class="">
    No notification
    </div>
    `
    element.innerHTML = element.innerHTML + html;
}

$(document).ready(function () {
    $(".delete-btn").click(function () {
        var notifId = $(this).data('notif-id');

        // Envoyer une requête AJAX pour supprimer la notification
        $.ajax({
            url: 'assets/phptools/notificationManager.php',
            method: 'POST',
            data: { id: notifId },
            success: function (response) {
                // Actualiser la page après la suppression
                location.reload();
            },
            error: function (xhr, status, error) {
                alert('Une erreur est survenue lors de la suppression de la notification.');
                console.error(error);
            }
        });
    });
});

// $(document).ready(function () {
//     var userId = document.body.dataset.userId;
//     setInterval(function () {
//         $.ajax({
//             url: 'assets/phptools/notificationManager.php',
//             method: 'GET',
//             data: {
//                 getNotifications: true,
//                 userId: userId
//             },
//             success: function (response) {
//                 // Assuming the server returns the number of new notifications
//                 var newNotifications = parseInt(response);
//                 if (newNotifications > 0) {
//                     // Update the notifications badge
//                     $('#notification-badge').text(newNotifications);
//                 }
//             },
//         });
//     }, 360000); // Check every 5 min
// });

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
            if (notifications.length > 0) {
                var notifications = JSON.parse(notifications);
                for (notif of notifications) {
                    var element = document.querySelector('#notif-container');
                    console.log(notif);
                    insertNotif(notif, element);
                }
            } else {
                var element = document.querySelector('#no-notif-container');
                insertNoNotif(element);
            }

        },
    });
});
