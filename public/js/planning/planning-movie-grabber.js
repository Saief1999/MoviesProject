$(document).ready(function(){

    let att = document.createAttribute("tmdbLink");

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
       let imdb=$(this).find(".imdb_link").text() ;
        axios.get('https://api.themoviedb.org/3/movie/'+link+'?api_key=98325a9d3ed3ec225e41ccc4d360c817&language=en-US')
            .then(function (response) {
                let  movie=response.data;
                let plot = movie.overview ;
                let imdb=movie.imdb_id ;

                $("#tmdb_link_id").val(link);
                $("#tmdb_plot").html(plot) ;
                $("#imdb_link_id").val(imdb) ;
            })
            .catch(function (error) {
                    console.log(error);
                });

        clearSearch()
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

    });



