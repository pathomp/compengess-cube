var t = 180;
$(document).ready(function(){
    setInterval(function(){
       getCubeInfo(); 
    },300);
    setInterval(countdownSetup,1000);
});
function countdownSetup(){
    $("#countdown #timeleft").html(t);
    t = t-1;
    console.log(t);
    if(t<=-1){
        location.reload();
    }
}
function getCubeInfo(){
    var url = "ajax.php";
    var data = {
        cmd:"getstates",
        room:$("#maincontainer").attr("data-room"),
    };
    $.ajax({
        url:url,
        data:data,
        method:"POST",
        dataType:"json"
    }).done(function(rp){
        if(rp.status==0){
            console.log(rp.msg);
        }else{
            for(var gid in rp.data) {
                var cubeData = rp.data[gid];
                var cube = $(".grouppanel[data-gid=\""+gid+"\"]").find(".cube-inner");
                var panel = $(".grouppanel[data-gid=\""+gid+"\"]");
                if(cubeData.data.state==0){
                    cube.removeClass("turned");
                }else if(cubeData.data.state==1){
                    cube.addClass("turned");
                }else{
                    console.log("Unknown State");
                }
                if(cubeData.data.error==true){
                    panel.addClass("error");
                }else{
                    panel.removeClass("error");
                }
            }   
        }
    });
}
function turnCube(gid){
    var cube = $(".grouppanel[data-gid=\""+gid+"\"]").find(".cube-inner");
    if(cube.length>0){
        if(cube.hasClass("turned")){
            cube.removeClass("turned");
        }else{
            cube.addClass("turned");
        }
    }
}