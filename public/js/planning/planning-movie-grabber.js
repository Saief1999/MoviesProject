function showResult(searchText)
{
    if (searchText.length!==0)
    {axios.get("https://api.themoviedb.org/3/search/movie?api_key=98325a9d3ed3ec225e41ccc4d360c817&language=en-US&query=" + searchText)
        .then(function (response) {
            let movies = response.data.results;
            let output = ``;
            $.each(movies, (index, movie) => {
                output+=`<a>${movie.title}</a><br/>`
            });
            if (output.length===0) output+="nothing Found" ;
            $('#livesearch').html(output);
        })
        .catch(function (error) {
            console.log(error);
        });}
    else  $('#livesearch').html(``);
}

function getMovies(searchText,page=1){
    //make request to api using axios
    // Make a request for a user with a given ID
    axios.get("https://api.themoviedb.org/3/search/movie?api_key=98325a9d3ed3ec225e41ccc4d360c817&language=en-US&page=+"+page+"&query=" + searchText)
        .then(function (response) {
            let movies = response.data.results;
            let nbpages =response.data.total_pages ;
            console.log(movies);
            let output = '';
            $.each(movies, (index, movie) => {
                let poster= (movie.poster_path!=null)?"https://image.tmdb.org/t/p/w500"+movie.poster_path:"/images/altImageMovie/notfoundLast.png" ;
                output+=`
          <div class="col-sm-3">
            <div class="well text-center">
              <img src="${poster}" alt="image">
              <h5>${movie.title}</h5>
              <a onclick="movieSelected('${movie.id}')" class="btn btn-primary" href="movie">Movie Details</a>
            </div>
          </div>
        `;
            });

            output+=`
        <div class="container row">
         <nav aria-label="Page navigation ">
        <ul class="pagination">`;

            let customClass="" ;
            for(let i=1 ; i<=nbpages ;i++)
            {
                customClass="page-item"+((i==page)? " active":"");
                output+=`<li class="${customClass}"><a class="page-link" onclick="pageSelected('${searchText}', '${i}')" href="movies" >${i}</a></li>`
            }
            output+=`</ul></div>` ;
            $('#movies').html(output);
        })
        .catch(function (error) {
            console.log(error);
        });
}