// Fonction pour filtrer les artistes
function filterArtists() {
  const query = document.getElementById("search-bar").value;
  console.log("Recherche pour : ", query);

  const resultList = document.getElementById("result-list");
  resultList.innerHTML = "";

  let url = "search_artistes.php";
  if (query.length > 0) {
    url += `?query=${query}`;
  }

  fetch(url)
    .then((response) => response.json())
    .then((data) => {
      console.log("Données reçues : ", data);

      data.forEach((artist) => {
        const li = document.createElement("li");
        li.classList.add("card");
        li.innerHTML = ` 
          <h3>${artist.artist_mb}</h3>
          <p><strong>Auditeurs:</strong> ${artist.listeners_lastfm}</p>
          ${
            artist.spotify
              ? `<a href="${artist.spotify}" target="_blank" class="button">Voir sur Spotify</a>`
              : "<p><em>Pas de lien Spotify disponible</em></p>"
          }
        `;
        resultList.appendChild(li);
      });
    })
    .catch((error) => {
      console.error("Erreur lors de la récupération des artistes:", error);
    });
}

document.getElementById("search-bar").addEventListener("input", filterArtists);
