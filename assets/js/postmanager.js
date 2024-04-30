function insertPost(postInfo, element) {

    let pictureHtml = "";
    if (post.picture) {
        pictureHtml = `<a href='${post.picture}'><img src='${post.picture}' class='rounded' width='400' height='320' style='object-fit: cover;'></a>`;
    }

    var html = `
    <div class='border-top mt-2 pt-2'> 
    <div class='d-flex'>
        <div>
            <a href='/profile.php?username=${postInfo}.username'>
                <div class='rounded-1 mt-1 ms-2' style='width: 40px; height: 40px; background: url("${postInfo}.profile_picture_path") no-repeat center center; background-size: cover;'></div>
            </a>
        </div>
        <a href='/profile.php?post=${postInfo}.id'>
            <div class='ms-2 mb-2'>
                <a href='/profile.php?username=${postInfo}.username' class='link-dark link-offset-1 link-offset-1-hover link-underline link-underline-opacity-0 link-underline-opacity-75-hover'><strong>${postInfo}.username</strong></a><br>
                ${postInfo}.content
            </div>
        </a>
    </div>
    <div class='d-flex'>
        <a href='#' class='ms-5 me-5 text-dark text-decoration-none'> <i class="bi bi-heart"></i> ${postInfo}.like_count</a>
        <a href='#' class=' text-dark text-decoration-none' data-bs-toggle='modal' data-bs-target='#modalPost'> <i class="bi bi-chat-left-text"></i></a>
        <a href='#' class='me-5 text-dark text-decoration-none'><i class="bi bi-arrow-repeat"></i></a>
    </div>
</div>`;

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
                console.log(rep);
                var element = document.querySelector('#posts-container');
                insertPost(rep, element);
            }
        }
    });
}

function PostByUser(){
    start = $('#posts-container .post').length;
    $.ajax({
        url: "assets/phptools/postmanager.php",
        type: 'GET',
        data: {
            getPostByUser: true,
            start: start,
        },
        success: function (response) {
            var responses = JSON.parse(response);
            for (rep of responses) {
                console.log(rep);
                var element = document.querySelector('#posts-container');
                insertPost(rep, element);
            }
        }
    });
}


$(document).ready(function () {
    let token;

    if (sessionStorage.getItem('token')) {
        token = sessionStorage.getItem('token');
    } else {
        token = Math.floor(Math.random() * 1000);
        sessionStorage.setItem('token', token);
    }

    if (window.location.pathname == '/WE4A_project/profile.php') {
        PostByUser();
    }
    if (window.location.pathname == '/WE4A_project/index.php') {
        RandomPost(token);  
        $('#posts-container').on('scroll', function () {
            if ($(this).scrollTop() + $(this).innerHeight() >= $(this)[0].scrollHeight) {
                RandomPost(token);
            }
        });
    }

});

