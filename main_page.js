$(document).ready(function(){
  $(".post-tab").click(function(){
    var type = $(this).data("type");

    $.ajax({
      url: "handler.php",
      type: "get",
      data: {action: 'load_posts', type: type},
      success: function(data){
        $("#post-container").html(data);
      }
    });
  });
  // Trigger click event on first tab
  $(".post-tab:first").trigger("click");
});