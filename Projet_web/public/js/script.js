// fonction general de test il suffit de mettre l'url qu'on souhaite
function getanswerJSON(balise, url){
	var request = new XMLHttpRequest();

	request.open('GET', url);

	request.setRequestHeader('Content-Type', 'application/json');
	request.setRequestHeader('trakt-api-version', '2');
	request.setRequestHeader('trakt-api-key', '7f64fc2ceef5b70439a9736df3b9b9310eddd6c57ecb55743d178bc1300a40c6');

	request.onreadystatechange = function () {
	  if (this.readyState === 4) {
		document.getElementById(balise).innerHTML=syntaxHighlight(JSON.parse(this.responseText));
	  }
	};

	request.send();
}

function getPopularShow(balise, url, verification){
	if (verification){
		var request = new XMLHttpRequest();
		
		request.open('GET', url);

		request.setRequestHeader('Content-Type', 'application/json');
		request.setRequestHeader('trakt-api-version', '2');
		request.setRequestHeader('trakt-api-key', '7f64fc2ceef5b70439a9736df3b9b9310eddd6c57ecb55743d178bc1300a40c6');

		request.onreadystatechange = function () {
		  if (this.readyState === 4) {
		  	var lengthObject = JSON.parse(this.responseText).length;
		  	for(var i=0; i<lengthObject; i++){
		   		document.getElementById(balise).innerHTML+='<p>'+JSON.parse(this.responseText)[i]['title']+' - '+JSON.parse(this.responseText)[i]['year']+'</p>';
		  		document.getElementById(balise).innerHTML+='<input id="'+JSON.parse(this.responseText)[i]['ids']['slug']+'" type="button" value="Voir la série" onclick="afficherSerie(event)">';
		  		//printPoster(JSON.parse(this.responseText)[i]['ids']['imdb'], balise);
		  	}
		  }
		};

		request.send();
	}
}

// to get title or year (element) pour un show (id)
function getShow(balise, id, element){
	var request = new XMLHttpRequest();
	var url = 'https://api.trakt.tv/shows/'+id;
	request.open('GET', url);

	request.setRequestHeader('Content-Type', 'application/json');
	request.setRequestHeader('trakt-api-version', '2');
	request.setRequestHeader('trakt-api-key', '7f64fc2ceef5b70439a9736df3b9b9310eddd6c57ecb55743d178bc1300a40c6');

	request.onreadystatechange = function () {
	  if (this.readyState === 4) {
		document.getElementById(balise).innerHTML=JSON.parse(this.responseText)[element];
	  }
	};
	request.send();
}

// get all seasons pour un show (id)
function getSeasons(balise, id){
	var request = new XMLHttpRequest();
	var url = 'https://api.trakt.tv/shows/'+id+'/seasons';
	request.open('GET', url);

	request.setRequestHeader('Content-Type', 'application/json');
	request.setRequestHeader('trakt-api-version', '2');
	request.setRequestHeader('trakt-api-key', '7f64fc2ceef5b70439a9736df3b9b9310eddd6c57ecb55743d178bc1300a40c6');

	request.onreadystatechange = function () {
	  if (this.readyState === 4) {
	  	var lengthObject = JSON.parse(this.responseText).length;
	  	for(var i=0; i<lengthObject; i++){
	  		document.getElementById(balise).innerHTML+='<p>'+JSON.parse(this.responseText)[i]['number']+'</p>';
	  	}
		
	  }
	};
	request.send();
}

// Affiche la liste des tous les épisode (numéro et nom) d'une saison (idSeason) d'une série (idShow)
function getEpisodeTitle(balise, idShow, idSeason){
	var request = new XMLHttpRequest();
	var url = 'https://api.trakt.tv/shows/'+idShow+'/seasons/'+idSeason;

	request.open('GET', url);

	request.setRequestHeader('Content-Type', 'application/json');
	request.setRequestHeader('trakt-api-version', '2');
	request.setRequestHeader('trakt-api-key', '7f64fc2ceef5b70439a9736df3b9b9310eddd6c57ecb55743d178bc1300a40c6');

	request.onreadystatechange = function () {
	  if (this.readyState === 4) {
	  	var lengthObject = JSON.parse(this.responseText).length;
	  	for(var i=0; i<lengthObject; i++){
	   		document.getElementById(balise).innerHTML+='<p>'+JSON.parse(this.responseText)[i]['number']+' - '+JSON.parse(this.responseText)[i]['title']+'</p>';
	  	}
	  }
	};

	request.send();
}

// Get l'id d'un show pour IMDB et appelle printPoster pour afficher l'image associer
function getPosterSeasonIMDB(balise, idShow){

	var idIMDB2;
	var request = new XMLHttpRequest();
	request.open('GET', 'https://api.trakt.tv/shows/'+idShow);

	request.setRequestHeader('Content-Type', 'application/json');
	request.setRequestHeader('trakt-api-version', '2');
	request.setRequestHeader('trakt-api-key', '7f64fc2ceef5b70439a9736df3b9b9310eddd6c57ecb55743d178bc1300a40c6');

	request.onreadystatechange = function () {
	  if (this.readyState === 4) {
		printPoster(JSON.parse(this.responseText)['ids']['imdb'], balise);
	  }
	};

	request.send();
}

// Affiche l'image grace à IMDB
// API key de IMDB pour les poster : &apikey=215947ec
function printPoster(idIMDB, balise){

	var request = new XMLHttpRequest();
	var url = 'http://www.omdbapi.com/?i='+idIMDB+'&apikey=215947ec';

	request.open('GET', url);

	request.onreadystatechange = function () {
	  if (this.readyState === 4) {
	  	document.getElementById(balise).innerHTML+='<img src="'+JSON.parse(this.responseText)['Poster']+'" alt="MDN">';
	  }
	};

	request.send();
}

// fonction de recherche par string
function researchResult(balise, url, verification){
	if (!verification){
		var request = new XMLHttpRequest();

		request.open('GET', url);

		request.setRequestHeader('Content-Type', 'application/json');
		request.setRequestHeader('trakt-api-version', '2');
		request.setRequestHeader('trakt-api-key', '7f64fc2ceef5b70439a9736df3b9b9310eddd6c57ecb55743d178bc1300a40c6');

		request.onreadystatechange = function () {
		  if (this.readyState === 4) {
		  	var lengthObject = JSON.parse(this.responseText).length;
		  	for(var i=0; i<lengthObject; i++){
		   		document.getElementById(balise).innerHTML+='<p>'+JSON.parse(this.responseText)[i]['show']['title']+' - '+JSON.parse(this.responseText)[i]['show']['year']+'</p>';
		   		console.log(JSON.parse(this.responseText)[i]['show']['ids']['slug']);
		  		document.getElementById(balise).innerHTML+='<input id="'+JSON.parse(this.responseText)[i]['show']['ids']['slug']+'" type="button" value="Voir la série" onclick="afficherSerie(event)">';
		  	}
		  }
		};

		request.send();
	}
}

function afficherSerie(event){
	document.location.href = "/serie/"+event.target.id;
	//document.location.href+="/saison/"+event.target.id;
}

// retourne le json
function syntaxHighlight(json) {
    if (typeof json != 'string') {
         json = JSON.stringify(json, undefined, 2);
    }
    json = json.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;');
    return json.replace(/("(\\u[a-zA-Z0-9]{4}|\\[^u]|[^\\"])*"(\s*:)?|\b(true|false|null)\b|-?\d+(?:\.\d*)?(?:[eE][+\-]?\d+)?)/g, function (match) {
        var cls = 'number';
        if (/^"/.test(match)) {
            if (/:$/.test(match)) {
                cls = 'key';
            } else {
                cls = 'string';
            }
        } else if (/true|false/.test(match)) {
            cls = 'boolean';
        } else if (/null/.test(match)) {
            cls = 'null';
        }
        return '<span class="' + cls + '">' + match + '</span>';
    });
}