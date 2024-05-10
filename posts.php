<?php 

$pageTitle = 'Post';

require_once dirname(__FILE__) . '/assets/phptools/template_top.php';

?>

<body data-post-id="<?php echo $_GET['id']; ?>">

<div id ="post-parent-container">
  
</div>
<div class="border-top pt-2">
responses
</div>
<div id="comments-container">

</div>

<?php
require_once dirname(__FILE__) . '/assets/phptools/template_bot.php';
