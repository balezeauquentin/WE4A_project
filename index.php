
<?php 
$pageTitle = 'Home';
require 'assets/phptools/template_top.php'; ?>

<!-- Tab navigation -->
<ul class="nav nav-tabs justify-content-center" id="pills-tab" role="tablist">
  <li class="nav-item">
    <button class="nav-link active post-tab post-tab-default" id="all-post" aria-current="page" data-type="all" data-bs-toggle="pill">Tous les posts</button>
  </li>
  <li class="nav-item">
    <button class="nav-link post-tab" data-type="liked" data-bs-toggle="pill">Les tendances</button>
  </li>
  <li class="nav-item">
    <button class="nav-link post-tab" data-type="following" data-bs-toggle="pill">Posts des abo</button>
  </li>
</ul>

<div id ="post-container">
  
</div>

<?php require 'assets/phptools/template_bot.php';?>