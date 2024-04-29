<div class='border-top mt-2 pt-2'> 
    <div class='d-flex'>
        <div>
            <a href='/profile.php?username=<?php echo $post['username']; ?>'>
                <div class='rounded-1 mt-1 ms-2' style='width: 40px; height: 40px; background: url("<?php echo $profile_data['profile_picture_path']; ?>") no-repeat center center; background-size: cover;'></div>
            </a>
        </div>
        <a href='/profile.php?post=<?php echo $post['id']; ?>'>
            <div class='ms-2 mb-2'>
                <a href='/profile.php?username=<?php echo $post['username']; ?>' class='link-dark link-offset-1 link-offset-1-hover link-underline link-underline-opacity-0 link-underline-opacity-75-hover'><strong><?php echo $profile_data['username']; ?></strong></a><br>
                <?php echo $post['content']; ?>
            </div>
        </a>
    </div>
    <div class='d-flex'>
        <a href='#' class='ms-5 me-5 text-dark text-decoration-none'> <i class="bi bi-heart"></i> <?php echo $post['like_count'] ?></a>
        <!-- Togle the modal of template top cuz it's the same one. --> 
        <a href='#' class='me-5  text-dark text-decoration-none'><i class="bi bi-arrow-repeat"></i></a>
        <a href='#' class=' text-dark text-decoration-none' data-bs-toggle='modal' data-bs-target='#modalPost'><i class="bi bi-chat-left-text"></i></a>
    </div>
</div>
