function insertPostParent(postInfo, element) {
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
                                <li><a class="dropdown-item" data-bs-target=''>Send a warning to a user</a></li>
                                <li><a class="dropdown-item" data-bs-target=''>Mark the post as sensitive</a></li>
                                <li><a class="dropdown-item" data-bs-target=''>Delete post</a></li>
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
                    <a href='profile.php?username=${postInfo.username}'>
                    <div class='rounded-1 mt-1 ms-2' style='width: 40px; height: 40px; background: url("${postInfo.profile_picture_path}") no-repeat center center; background-size: cover;'></div>
                    </a>
                    </div>
                    <a class='text-decoration-none' href='/posts.php?id=${postInfo.id}'>
                        <div class='ms-2 mb-2'>
                        ${sensitive}
                            <a href='profile.php?username=${postInfo.username}' class='link-dark link-offset-1 link-offset-1-hover link-underline link-underline-opacity-0 link-underline-opacity-75-hover'><strong>${username}</strong></a>
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
                                <li><a class="dropdown-item" data-bs-target=''>Send a warning to a user</a></li>
                                <li><a class="dropdown-item" data-bs-target=''>Mark the post as sensitive</a></li>
                                <li><a class="dropdown-item" data-bs-target=''>Delete post</a></li>
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
                    <a href='profile.php?username=${postInfo.username}'>
                    <div class='rounded-1 mt-1 ms-2' style='width: 40px; height: 40px; background: url("${postInfo.profile_picture_path}") no-repeat center center; background-size: cover;'></div>
                    </a>
                    </div>
                    <a class='text-decoration-none' href='/posts.php?id=${postInfo.id}'>
                        <div class='ms-2 mb-2'>
                        ${sensitive}
                            <a href='profile.php?username=${postInfo.username}' class='link-dark link-offset-1 link-offset-1-hover link-underline link-underline-opacity-0 link-underline-opacity-75-hover'><strong>${username}</strong></a>
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




$(document).ready(function () {
    var postId = document.body.dataset.postId;
    $.ajax({
        url: "assets/phptools/postmanager.php",
        type: 'GET',
        data: {
            getPostById: true,
            postId: postId
        },
        success: function (response) {
            var responses = JSON.parse(response);
            for (rep of responses) {
                if (rep.id_parent == 0) {
                    var element = document.querySelector('#post-parent-container');
                    insertPostParent(rep, element);

                } else {
                    var element = document.querySelector('#comments-container');
                    insertPost(rep, element);
                }

            }

        }
    });
});