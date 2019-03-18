$(document).ready(function(){
    $(".turn-button").click(clickTurnButton);
});
function clickTurnButton(){
    var thisButton = $(this);
    var gid = $(this).attr("data-gid");
    var url = "turn.php";
    var data = {
        g:gid.replace("g",""),
        token:$(this).attr("data-token")
    };
    $.ajax({
        url:url,
        data:data,
        method:"GET",
        dataType:"json"
    }).done(function(rp){
        if(rp.status==1){
            $("#rp-panel").html("SUCCESS: New token is "+rp.token);
            thisButton.attr("data-token",rp.token);
        }else if(rp.status==0){
            $("#rp-panel").html("ERROR: "+rp.msg);
        }else if(rp.status==2){
            $("#rp-panel").html("Cube was reset. The initial token is needed.");
        }else{
            $("#rp-panel").html("Unknown Status");
        }
    });
}