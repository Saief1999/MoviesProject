$(document).ready(function(){

    $(".cd-schedule__event").each(function () {
        loadPoster(this);
    });


    $('#search').keyup(function()
    {   showResult($(this).val()) ;
     }).focus(function() {
        showResult($(this).val()) ;
    }).blur(function () {
        clearSearch();
    }) ;

    $('#result').on('mousedown', 'li', function () {

        let title=($(this).find(".movie_title").text()) ;
        $('#search').val(title);
       let link=$(this).find(".tmdb_link").text() ;
        axios.get('https://api.themoviedb.org/3/movie/'+link+'?api_key=98325a9d3ed3ec225e41ccc4d360c817&language=en-US')
            .then(function (response) {
                let  movie=response.data;
                let plot = movie.overview ;
                let imdb=movie.imdb_id ;
                let genres = "" ;
                for(let i=0 ; i<movie.genres.length;i++)
                {genres=genres+movie.genres[i].name+" " ;}

                $("#tmdb_link_id").val(link);
                $("#tmdb_plot").html(plot) ;
                $("#imdb_link_id").val(imdb) ;
                $("#genres").val(genres) ;
            })
            .catch(function (error) {
                    console.log(error);
                });

        clearSearch()
    });

    $("#js-add").on("click",function (e) {
        e.preventDefault();

        const pageURL = $(location).attr("href");
        const planningId = pageURL.substring(pageURL.lastIndexOf("/")+1,pageURL.length) ;

        const sTime = $("#starting_time").val();
        const eTime = $("#ending_time").val() ;
        const day = $("#date_choice").val();
        const tmdb = $("#tmdb_link_id").val() ;
        const name =$("#search").val() ;

        axios.post('/regowner/planning/'+planningId+'/addmovie',{
           sTime : sTime,
           eTime : eTime ,
           day   :  day ,
           search: name ,
           plot  :  $("#tmdb_plot").val() ,
           link  : tmdb ,
           imdb  : $("#imdb_link_id").val(),
           genres :$("#genres").val()
        })
            .then( response => {
                let data = response.data ;
                const id = data.id ;
                const pos = data.position ;
                console.log(pos) ;

                let output= `<li class="cd-schedule__event">
                         <a data-start="${sTime}" data-end="${eTime}" data-content="showplot/${id}" data-event="event-1"
                        id="${tmdb}"  href="#">
                        <em class="cd-schedule__name">${name}</em></a></li>`
                if (pos!=1)
                {
                let prevElement=$("."+day+" >ul li:nth-child("+(pos-1)+")");
                prevElement.after(
                    output
                );}
                else
                {
                    let ulElement=$("."+day+" >ul");
                    ulElement.html(output) ;
                }


                //Delete loaded state , var "schedule" is saved at the start of main.js
                Util.removeClass(schedule.element, 'js-schedule-loaded');
                //refresh the whole thing
                schedule.initSchedule();


                loadPoster($("."+day+">ul li:nth-child("+(pos)+")"));

                let resultElement=$("#js-result" ) ;
                resultElement.removeClass() ;
                resultElement.addClass("alert alert-success mt-2");
                resultElement.text(response.data.message) ;
            })
            .catch(error => {
                let resultElement=$("#js-result" ) ;
                resultElement.removeClass();
                resultElement.attr("class","alert alert-danger mt-2")
                resultElement.text(error.response.data.message) ;
            })
    });


    function showResult(searchText) {
        if (searchText.length !== 0) {
            axios.get("https://api.themoviedb.org/3/search/movie?api_key=98325a9d3ed3ec225e41ccc4d360c817&language=en-US&query=" + searchText)
                .then(function (response) {
                    let movies = response.data.results;
                    let output = ``;
                    $.each(movies, (index, movie) => {
                        let poster = (movie.poster_path != null) ? "https://image.tmdb.org/t/p/w500" + movie.poster_path : "/images/altImageMovie/notfoundLast.png";
                        output += '<li class="list-group-item list-group-item-action"><img src="' + poster + '" height="80" width="40" class="img-thumbnail" alt="movie"/>'+
                            '<span class="movie_title"> '+ movie.title +'</span><span class="tmdb_link">'+movie.id+'</li>';
                    });
                    $('#result').html(output);
                })
                .catch(function (error) {
                    console.log(error);
                });
        } else clearSearch()}


    function clearSearch() {
        $('#result').html(``)
    }


    function loadPoster(el)
    {
        let link=$(el).find("a") ;
        let id=link.attr("id");
        axios.get('https://api.themoviedb.org/3/movie/'+id+'?api_key=98325a9d3ed3ec225e41ccc4d360c817&language=en-US')
            .then(function (response) {
                let movie=response.data;
                let poster= (movie.poster_path!=null)?"https://image.tmdb.org/t/p/w500"+movie.poster_path:"/images/altImageMovie/notfoundLast.png" ;
                link.css({"background-image":"url('"+poster+"')", "background-size": "100% 380px"});

            } )
            .catch(function (error) {
                console.log(error);
            });
    }

    });
