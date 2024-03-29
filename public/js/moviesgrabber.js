$(document).ready(() => {
    if (sessionStorage.getItem('page')==null)
        {$("#searchForm").on('submit', (e) => {
            e.preventDefault();
            let searchText= $("#searchText").val();
                getMovies(searchText);
          });}
    else
    {
        let searchText =sessionStorage.getItem('searchText');
        $("#searchText").val(searchText);
        let selectedPage=sessionStorage.getItem('page');
        getMovies(searchText,selectedPage);
        sessionStorage.clear() ;
    }

});

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
                <div>
                    <img src="${poster}" alt="image">
                    <a onclick="movieSelected('${movie.id}')" class="buttonx" href="movie"><strong>Movie Details</strong></a>
                 </div>
              <h5>${movie.title}</h5>
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

function pageSelected(searchText,page)
{
    sessionStorage.setItem('page',page) ;
    sessionStorage.setItem('searchText',searchText);
    window.location='page' ;
    return false ;
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
    console.log(movie) ;
        let poster= (movie.poster_path!=null)?"https://image.tmdb.org/t/p/w500"+movie.poster_path:"/images/altImageMovie/notfoundLast.png" ;

        let genres = "" ;
        for(i=0 ; i<movie.genres.length;i++)
        {genres=genres+movie.genres[i].name +
            ((i==movie.genres.length-1)? "":" , "); }

        let production_companies ="";
        for(i=0 ; i<movie.production_companies.length;i++)
        {production_companies=production_companies+movie.production_companies[i].name+" "
            +((i==movie.production_companies.length-1)? "":" , "); }

        let output = `
        <div class="wrapper">
	<div class="main_card">
		<div class="card_left">
			<div class="card_datails">
				<h1>${movie.title}</h1>
				<p class="disc">${movie.overview}</p>
				<hr>
				<p><strong>Release date : </strong>${movie.release_date}</p>
				<p><strong>Genres : </strong>${genres} </p>
				<p><strong>Runtime : </strong>${movie.runtime} min.</p>
				<a href="http://imdb.com/title/${movie.imdb_id}" target="_blank">Read More on IMDB</a>
			</div>
		</div>
		<div class="card_right">
			<div class="img_container">
				<img src="${poster}" alt="">
				</div>
			</div>
		</div>
	</div>



    `;
    $('#movie').html(output);
    })
    .catch(function (error) {
      console.log(error);
    });
}
