$(document).ready(function() {
    $(".btns_more").click(function() {
        var elem = $(".btns_more").text();
        if (elem == " See More ") {
            //Stuff to do when btn is in the read more state
            $(".btns_more").text("See Less");
            $("#more-Details").slideDown();
        } else {
            //Stuff to do when btn is in the read less state
            $(".btns_more").text(" See More ");
            $("#more-Details").slideUp();
        }
    });
});