const form = document.getElementById("form");
const search = document.getElementById("search");
const result = document.getElementById("result");
gapi.load("client", loadClient);

function loadClient() {
  gapi.client.setApiKey("AIzaSyCXd8-DzhjLSwKvOTPJzFJkZHiKvsPNAJs");
  return gapi.client
    .load("https://www.googleapis.com/discovery/v1/apis/youtube/v3/rest")
    .then(
      function () {
        console.log("GAPI client loaded for API");
      },
      function (err) {
        console.error("Error loading GAPI client for API", err);
      }
    );
}

const apiURL = "https://api.lyrics.ovh";

form.addEventListener("submit", (e) => {
  e.preventDefault();
  searchValue = search.value.trim();

  if (!searchValue) {
    alert("There is nothing to search");
  } else {
    searchSong(searchValue);
  }
});

const searchOnKeyUp = () => {
  searchValue = search.value.trim();
  searchSong(searchValue);
};

async function searchSong(searchValue) {
  const searchResult = await fetch(`${apiURL}/suggest/${searchValue}`);
  const data = await searchResult.json();

  showData(data);
}

function showData(data) {
  result.innerHTML = `
   
    <ul class="song-list">
      ${data.data
        .map(
          (song) => `<li>
                    <div>
                        <strong>${song.artist.name}</strong> -${song.title} 
                    </div>
                    <span data-artist="${song.artist.name}" data-songtitle="${song.title}"> get lyrics</span>
                </li>`
        )
        .join("")}
    </ul>
  `;
  document.getElementById("video").innerHTML = "";
}

result.addEventListener("click", (e) => {
  const clickedElement = e.target;

  if (clickedElement.tagName === "SPAN") {
    const artist = clickedElement.getAttribute("data-artist");
    const songTitle = clickedElement.getAttribute("data-songtitle");

    getLyrics(artist, songTitle);
  }
});

async function getLyrics(artist, songTitle) {
  const res = await fetch(`${apiURL}/v1/${artist}/${songTitle}`);

  const data = await res.json();
  const lyrics = data.lyrics.replace(/(\r\n|\r|\n)/g, "<br>");
  result.innerHTML = ` 
    <h4 style="margin-bottom:30px;"><strong>${artist}</strong> - ${songTitle}</h4><ul>
    <div data-artist="${artist}" data-songtitle="${songTitle}"> get lyrics</div>
    <p style="margin-top:20px;">${lyrics}</p>
`;
}

result.addEventListener("click", (e) => {
  const clickedElement = e.target;

  if (clickedElement.tagName === "DIV") {
    const artist = clickedElement.getAttribute("data-artist");
    const songTitle = clickedElement.getAttribute("data-songtitle");

    execute(artist, songTitle);
  }
});

const execute = (artist, songTitle) => {
  var pageToken = "";

  var arr_search = {
    part: "snippet",
    type: "video",
    order: "relevance",
    maxResults: 1,
    q: songTitle + artist,
  };

  if (pageToken != "") {
    arr_search.pageToken = pageToken;
  }

  return gapi.client.youtube.search.list(arr_search).then(
    function (response) {
      const listItems = response.result.items;
      if (listItems) {
        let output = `<h4 style="margin-bottom:30px;"><strong>${artist}</strong> - ${songTitle}</h4><ul>`;

        listItems.forEach((item) => {
          const videoId = item.id.videoId;
          const videoTitle = item.snippet.title;
          output += `
                    <li><a data-fancybox href="https://www.youtube.com/watch?v=${videoId}"><img src="http://i3.ytimg.com/vi/${videoId}/hqdefault.jpg" /></li>
                `;
        });
        output += "</ul>";

        document.getElementById("video").innerHTML = output;
      }
    },
    function (err) {
      console.error("Execute error", err);
    }
  );
};
