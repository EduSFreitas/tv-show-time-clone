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



//** --- A GARDER --- **//

//Est appelé à un nouveau caractère dans la barre de recherche
function majSearch(){
    //Envoie le contenu de search
    getSeriesRecherche(document.getElementById("searchInput").value);

}


//Recherche des séries (barre de recherche)
function getSeriesRecherche(recherche){

    var request = new XMLHttpRequest();
    var url = 'https://api.trakt.tv/search/show?query='+recherche;
    request.open('GET', url);

    request.setRequestHeader('Content-Type', 'application/json');
    request.setRequestHeader('trakt-api-version', '2');
    request.setRequestHeader('trakt-api-key', '7f64fc2ceef5b70439a9736df3b9b9310eddd6c57ecb55743d178bc1300a40c6');

    request.onreadystatechange = function () {
            if (this.readyState === 4) {
                reponse=JSON.parse(this.responseText);

                //Récupère le basepath (url de base), cachée dans un champs hidden
				var basepath=document.getElementById("searchInputBasePath").value;


                //Si la recherche ne renvoie rien, reste sur les résultats précédents
				if(reponse[0] && reponse[1] && reponse[2]){

                    //Vide les champs, renseigne le titre et la date. Assigne ensuite l'url ajoutée au basepath
                    document.getElementById("search"+1).innerHTML=reponse[0]['show']['title']+"</br><span id='search1Date'>"+reponse[0]['show']['year']+"</span>";
                    document.getElementById("search"+1).setAttribute('href', basepath+'/serie/'+reponse[0]['show']['ids']['slug']);

                    document.getElementById("search"+2).innerHTML=reponse[1]['show']['title']+"</br><span id='search2Date'>"+reponse[1]['show']['year']+"</span>";
                    document.getElementById("search"+2).setAttribute('href', basepath+'/serie/'+reponse[1]['show']['ids']['slug']);

                    document.getElementById("search"+3).innerHTML=reponse[2]['show']['title']+"</br><span id='search3Date'>"+reponse[2]['show']['year']+"</span>";
                    document.getElementById("search"+3).setAttribute('href', basepath+'/serie/'+reponse[2]['show']['ids']['slug']);

                    //todo: lien vers série

				}
            }
    };

    request.send();


}


function displaySearch(){
    document.getElementById("results").classList.remove("hidden");
}

//todo: Ne marche pas, à vérifier
function hideSearch(){
    // document.getElementById("results").classList.add("hidden");
}


function note(note){
    star2=document.getElementById("star2");
    star3=document.getElementById("star3");
    star4=document.getElementById("star4");
    star5=document.getElementById("star5");

    if(note>=2){star2.classList.add("checked")}
    if(note>=3){star3.classList.add("checked")}
    if(note>=4){star4.classList.add("checked")}
    if(note>=5){star5.classList.add("checked")}

    if(note<5){star5.classList.remove("checked")}
    if(note<4){star4.classList.remove("checked")}
    if(note<3){star3.classList.remove("checked")}
    if(note<2){star2.classList.remove("checked")}

}