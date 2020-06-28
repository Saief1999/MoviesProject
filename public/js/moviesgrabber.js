$(document).ready(() => {
  $("#searchForm").on('submit', (e) => {
    e.preventDefault();
    let searchText = $("#searchText").val();
    getMovies(searchText);
  });
});

function getMovies(searchText){
  //make request to api using axios
  // Make a request for a user with a given ID
  axios.get("https://api.themoviedb.org/3/search/movie?api_key=98325a9d3ed3ec225e41ccc4d360c817&language=en-US&query=" + searchText)
    .then(function (response) {
      let movies = response.data.results;
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
      $('#movies').html(output);
    })
    .catch(function (error) {
      console.log(error);
    });
}

function movieSelected(id){
  sessionStorage.setItem('movieId', id);
  window.location = 'movie';
  return false;
}

function getMovie(){
  let movieId = sessionStorage.getItem('movieId');
  // Make a request for a user with a given ID
  axios.get("https://api.themoviedb.org/3/movie/" + movieId + "?api_key=98325a9d3ed3ec225e41ccc4d360c817")
    .then(function (response) {
    let movie = response.data;
/*    console.log(movie) ;*/
        let poster= (movie.poster_path!=null)?"https://image.tmdb.org/t/p/w500"+movie.poster_path:"/images/altImageMovie/notfoundLast.png" ;

        let genres = "" ;
        for(i=0 ; i<movie.genres.length;i++)
        {genres=genres+movie.genres[i].name +
            ((i==movie.genres.length-1)? " .":" , "); }

        let production_companies ="";
        for(i=0 ; i<movie.production_companies.length;i++)
        {production_companies=production_companies+movie.production_companies[i].name+" "
            +((i==movie.production_companies.length-1)? " .":" , "); }

        let output = `
        <div class="row">
          <div class="col-md-4">
            <img src="${poster}" class="thumbnail" alt="image">
          </div>
          <div class="col-md-8">
            <h2>${movie.title}</h2>
            <ul class="list-group">
              <li class="list-group-item"><strong>Genre:</strong> ${genres}</li>
              <li class="list-group-item"><strong>Released:</strong> ${movie.release_date}</li>
              <li class="list-group-item"><strong>Rated:</strong> ${movie.vote_average}</li>
              <li class="list-group-item"><strong>Runtime:</strong> ${movie.runtime} min.</li>
              <li class="list-group-item"><strong>Production Companies:</strong> ${production_companies}</li>
            </ul>
          </div>
        </div>
        <div class="row">
          <div class="well">
            <h3>Plot</h3>
            ${movie.overview}
            <hr>
            <a href="http://imdb.com/title/${movie.imdb_id}" target="_blank" class="btn btn-primary">View IMDB</a>
            <a href="movies" class="btn btn-default">Go Back To Search</a>
          </div>
        </div>
    `;
    $('#movie').html(output);
    })
    .catch(function (error) {
      console.log(error);
    });
}
