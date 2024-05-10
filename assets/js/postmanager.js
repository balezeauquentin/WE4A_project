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

    var html = `
        <div class='border-top mt-2 pt-2' data-post-id='${postInfo.id}'> 
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
                </a>
            </div>
            <div class='d-flex ms-2'>
              <a href="#" id='likeButton' class='ms-5 me-5 text-dark text-decoration-none'> <i class="bi bi-heart"></i> ${postInfo.like_count}</a>
              <a href="#" id='responseButton' class='text-dark text-decoration-none' data-bs-toggle='modal' data-bs-target='#modalRespons' data-post-id='${postInfo.id}' onclick="openModalWithPost(this)"> <i class="bi bi-chat-left-text"></i> ${postInfo.comment_count}
              </a>
            </div>`;


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
                if (response.error) {
                    $('#responseError').text(response.message);
                } else if (response.success) {
                    $('#success-message-p').text(response.message);
                    setTimeout(function () {
                        location.reload();
                    }, 1000);
                }
            }
        });
    });
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


$(document).ready(function () {
    let token;
    var profileId = document.body.dataset.profileId;

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
        $('#posts-container').on('scroll', function () {
            if ($(this).scrollTop() + $(this).innerHeight() >= $(this)[0].scrollHeight) {
                RandomPost(token);
            }
        });
    }
    if (window.location.pathname == '/WE4A_project/posts.php') {
        var postId = document.body.dataset.postId;
        var element = document.querySelector('#posts-container');
        $.ajax({
            url: "assets/phptools/postmanager.php",
            type: 'GET',
            data: {
                getPostById: true,
                postId: postId
            },
            success: function (response) {
                var responses = JSON.parse(response);
                insertPost(responses, element);
            }
        });
    }

});

