function insertPost(postInfo, element) {
    var username;

    if (postInfo.isbanned == 1 && postInfo.admin == 1) {
        username = postInfo.username + "<span class='ms-2 badge bg-danger'><i class='bi bi-person-fill-gear'></i></span> <span class='ms-1 badge bg-danger'>BANNED</i></span>";
    } else if (postInfo.isbanned == 1) {
        username = postInfo.username + "<span class='ms-2 badge bg-danger'>BANNED</i></span></a>";
    } else if (postInfo.admin == 1) {
        username = postInfo.username + "<span class='ms-2 badge bg-danger'><i class='bi bi-person-fill-gear'></i></span>";
    } else {
        username = postInfo.username;
    }

    var userId = document.body.dataset.userId;
    var response;

    if (userId) {
        response = `<div class='d-flex ms-2'>
        <a href='#' id='likeButton' data-post-id='${postInfo.id}' class='ms-5 me-5 text-dark text-decoration-none'> <i class="like bi bi-heart"></i> <span class="like-count">${postInfo.like_count}</span></a>
        <a href='#' id='responseButton' class='text-dark text-decoration-none' data-bs-toggle='modal' data-bs-target='#modalRespons' data-post-id='${postInfo.id}' onclick="openModalWithPost(this)"> <i class="bi bi-chat-left-text"></i> ${postInfo.comment_count}
        </a>
      </div>`;
    } else {
        response = `<div class='d-flex ms-2'>
        <a href='#' class='ms-5 me-5 text-dark text-decoration-none' data-bs-target='#modalLogin'> <i class="like bi bi-heart"></i> <span class="like-count">${postInfo.like_count}</span></a>
        <a href='#' class='text-dark text-decoration-none' data-bs-toggle='modal' data-bs-target='#modalLogin'> <i class="bi bi-chat-left-text"></i> ${postInfo.comment_count}
        </a>
      </div>`;
    }
    
    var adminSettings;
    if(sessionStorage.getItem('admin') == 1){
        adminSettings = `<div class="dropdown ms-auto">
                            <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class='bi bi-gear'></i>
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <li><a class="dropdown-item" onclick='setAdminModal("warning",${postInfo.id})' data-bs-toggle='modal' data-bs-target='#modalAdmin'>Send a warning to a user</a></li>
                                <li><a class="dropdown-item" onclick='setAdminModal("sensitive",${postInfo.id})' data-bs-toggle='modal' data-bs-target='#modalAdmin'>Mark the post as sensitive</a></li>
                                <li><a class="dropdown-item" onclick='setAdminModal("delete",${postInfo.id})' data-bs-toggle='modal' data-bs-target='#modalAdmin'>Delete post</a></li>
                            </ul>
                        </div>`;
    } else {
        adminSettings = '';
    }

    var sensitive;
    if(postInfo.is_sensitive == 1){
        sensitive = `<div class="text-decoration-none text-danger">
                        This post has been marked as sensitive
                    </div>`;
    } else {
        sensitive = '';
    }
        


    var html = `
        <div class='border-top mt-2 pt-2' data-post-id='${postInfo.id}'> 
            <div class='d-flex'>
                <div class='d-flex'>
                    <a href='/WE4A_project/profile.php?username=${postInfo.username}'>
                    <div class='rounded-1 mt-1 ms-2' style='width: 40px; height: 40px; background: url("${postInfo.profile_picture_path}") no-repeat center center; background-size: cover;'></div>
                    </a>
                    </div>
                    <a class='text-decoration-none' href='/posts.php?id=${postInfo.id}'>
                        <div class='ms-2 mb-2'>
                        ${sensitive}
                            <a href='/WE4A_project/profile.php?username=${postInfo.username}' class='link-dark link-offset-1 link-offset-1-hover link-underline link-underline-opacity-0 link-underline-opacity-75-hover'><strong>${username}</strong></a>
                            <div class="text-muted mt mb-2">${postInfo.date}</div>
                            <div>${postInfo.content}</div>
                        </div>
                    </a>
                    ${adminSettings}
                </div>
            </div>
            ${response}
        </div>
            `;


    element.innerHTML = element.innerHTML + html;
}


function insertPostInModal(postInfo, element) {
    var username;

    if (postInfo.isbanned == 1 && postInfo.admin == 1) {
        username = postInfo.username + "<span class='ms-2 badge bg-danger'><i class='bi bi-person-fill-gear'></i></span> <span class='ms-1 badge bg-danger'>BANNED</i></span>";
    } else if (postInfo.isbanned == 1) {
        username = postInfo.username + "<span class='ms-2 badge bg-danger'>BANNED</i></span></a>";
    } else if (postInfo.admin == 1) {
        username = postInfo.username + "<span class='ms-2 badge bg-danger'><i class='bi bi-person-fill-gear'></i></span>";
    } else {
        username = postInfo.username;
    }

    var html = `
            <div class='d-flex'>
                <div class='d-flex'>
                <a href='/WE4A_project/profile.php?username=${postInfo.username}'>
                    <div class='rounded-1 mt-1 ms-2' style='width: 40px; height: 40px; background: url("${postInfo.profile_picture_path}") no-repeat center center; background-size: cover;'></div>
                        </a>
                    </div>
                    <a href='/profile.php?post=${postInfo.id}'>
                    <div class='ms-2 mb-2'>
                        <a href='/WE4A_project/profile.php?username=${postInfo.username}' class='link-dark link-offset-1 link-offset-1-hover link-underline link-underline-opacity-0 link-underline-opacity-75-hover'><strong>${username}</strong></a><div class="text-muted mt mb-2">${postInfo.date}</div>
                        <div>${postInfo.content}</div>
                    </div>
                </a>`;

    element.innerHTML = element.innerHTML + html;
}

function openModalWithPost(clickedButton) {
    const userId = document.body.dataset.userId;
    const clickedPostId = clickedButton.dataset.postId;
    const modalPostContent = document.getElementById('modalPostContent');
    $.ajax({
        url: "assets/phptools/postmanager.php",
        type: 'GET',
        data: {
            getPostById: true,
            postId: clickedPostId
        },
        success: function (response) {
            var responses = JSON.parse(response);
            insertPostInModal(responses, modalPostContent);
        }
    });

    $('#responseForm').submit(function (e) {
        e.preventDefault();
        var formData = new FormData(this);
        formData.append('userId', userId);
        formData.append('parentId', clickedPostId);
        formData.append('responseToPost', true);
        $.ajax({
            type: 'POST',
            url: '/WE4A_project/assets/phptools/postmanager.php',
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                response = JSON.parse(response);
                if (response.error) {
                    $('#responseError').text(response.message);
                } else if (response.success) {
                    $('#responseSuccess').text(response.message);
                    setTimeout(function () {
                        location.reload();
                    }, 1000);
                }
            }
        });
    });
}


function RandomPost(token) {
    start = $('#posts-container .post').length;
    $.ajax({
        url: "assets/phptools/postmanager.php",
        type: 'GET',
        data: {
            getRandomPost: true,
            token: token,
            start: start
        },
        success: function (response) {
            var responses = JSON.parse(response);
            for (rep of responses) {
                var element = document.querySelector('#posts-container');
                insertPost(rep, element);
            }

        }
    });
}

function PostByUser(profileId) {
    start = $('#posts-container .post').length;
    $.ajax({
        url: "assets/phptools/postmanager.php",
        type: 'GET',
        data: {
            getPostByUser: true,
            userId: profileId,
        },
        success: function (response) {
            var responses = JSON.parse(response);
            if (responses.error) {
                var element = document.querySelector('#posts-container');
                element.innerHTML = "<div class='text-center'>No post yet</div>";
            } else {
                for (rep of responses) {
                    var element = document.querySelector('#posts-container');
                    insertPost(rep, element);
                }
            }

        }
    });
}



function PostById(postId) {
    var postId = document.body.dataset.postId;
    var element = document.querySelector('#posts-container');
    start = $('#posts-container .post').length;
    $.ajax({
        url: "assets/phptools/postmanager.php",
        type: 'GET',
        data: {
            getPostById: true,
            postId: postId
        },
        success: function (response) {
            var responses = JSON.parse(response);
            if (responses.error) {
                var element = document.querySelector('#posts-container');
                element.innerHTML = "<div class='text-center'>No post yet</div>";
            } else {
                for (rep of responses) {
                    var element = document.querySelector('#posts-container');
                    insertPost(rep, element);
                }
            }

        }
    });
}

function setAdminModal(type, postId) {
    if (type === 'warning') {
        $('#modalAdminLabel').text("Send a warning to a user");
        $('#notif-message').val('You have received a warning from an administrator');
        $('#admin-action-type').val('warning');
        $('#admin-post-control-id').val(postId);
    } else if (type === 'sensitive') {
        $('#modalAdminLabel').text("Mark post as sensitive");
        $('#notif-message').val('This message has been marked as sensitive by an administrator : #' + postId);
        $('#admin-action-type').val('is_sensitive');
        $('#admin-post-control-id').val(postId);
    } else if (type === 'delete') {
        $('#modalAdminLabel').text("Delete post");
        $('#notif-message').val('This message has been deleted by an administrator : #' + postId);
        $('#admin-action-type').val('delete');
        $('#admin-post-control-id').val(postId);
    }
}


$(document).ready(function () {
    let userId = document.body.dataset.userId;
    let profileId = document.body.dataset.profileId;
    let token;
    if (sessionStorage.getItem('token')) {
        token = sessionStorage.getItem('token');
    } else {
        token = Math.floor(Math.random() * 1000);
        sessionStorage.setItem('token', token);
    }

    if (window.location.pathname == '/WE4A_project/profile.php') {
        PostByUser(profileId);
    }
    if (window.location.pathname == '/WE4A_project/index.php') {
        RandomPost(token);
        $('#posts-container .post').on('scroll', function () {
            if ($(this).scrollTop() + $(this).innerHeight() >= $(this)[0].scrollHeight) {
                RandomPost(token);
            }
        });
    }
    if (window.location.pathname == '/WE4A_project/posts.php') {
       PostById();
    }
    $(document).on('click', '#likeButton', function(e) {
        e.preventDefault();
        var postId = $(this).data('post-id'); 
        var likeCountElement = $(this).find('.like-count');
        var likeCount = parseInt(likeCountElement.text()) || 0;
        $.ajax({
            type: 'POST',
            url: '/WE4A_project/assets/phptools/postmanager.php',
            data: {
                likePost: true,
                userId: userId,
                postId: postId
            },
            success: function (response) {
                responses = JSON.parse(response);
                if (responses.like) {
                    $(`[data-post-id='${postId}'] .like`).removeClass('bi-heart').addClass('bi-heart-fill text-danger');
                    likeCountElement.text(likeCount + 1);
                } else if (responses.unlike) {
                    $(`[data-post-id='${postId}'] .like`).removeClass('bi-heart-fill text-danger').addClass('bi-heart');
                    likeCountElement.text(likeCount - 1);
                }
            }
        });
    });

});

$(document).ready(function() {
    $('.dropdown-item').on('click', function(e) {
        e.preventDefault();
        var action = $(this).text();

        switch(action) {
            case 'Send a warning to a user':
                console.log('send warning');
                $.ajax({
                    type: 'POST',
                    url: '/WE4A_project/assets/phptools/postmanager.php',
                    data: {
                        sendWarning: true,
                        userId: userId,
                        postId: postId
                    },
                    success: function(response) {
                        responses = JSON.parse(response);
                        if(responses.success) {

                        }
                    }
                });
                break;
            case 'Mark the post as sensitive':

                break;
            case 'Delete post':

                break;
        }
    });
});