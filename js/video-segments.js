let player;
let stopTime = 0;
let checkInterval;

// Attendre que le DOM soit chargé
document.addEventListener("DOMContentLoaded", () => {
  const mainPlayerElement = document.getElementById('mainPlayer');

  if (!mainPlayerElement) {
    console.error("mainPlayer non trouvé !");
    return;
  }

  const videoId = mainPlayerElement.dataset.videoId;

  // Charger dynamiquement l'API YouTube si elle n'est pas encore là
  if (typeof YT === "undefined" || typeof YT.Player === "undefined") {
    let tag = document.createElement('script');
    tag.src = "https://www.youtube.com/iframe_api";
    let firstScriptTag = document.getElementsByTagName('script')[0];
    firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
  }

  // Stocker temporairement l'ID à utiliser dans la fonction globale
  window.youTubeVideoId = videoId;
});

// Cette fonction est appelée automatiquement par l'API YouTube une fois chargée
function onYouTubeIframeAPIReady() {
  const mainPlayerElement = document.getElementById('mainPlayer');
  const videoId = window.youTubeVideoId;

  player = new YT.Player('mainPlayer', {
    videoId: videoId,
    events: {
      'onReady': onPlayerReady,
      'onStateChange': onPlayerStateChange
    }
  });
}

function onPlayerReady(event) {
  console.log("Lecteur prêt");
}

function onPlayerStateChange(event) {
  if (event.data === YT.PlayerState.ENDED) {
    clearInterval(checkInterval);
  }
}

function playSegment(start, end) {
  stopTime = end;
  if (player && typeof player.loadVideoById === 'function') {
    player.loadVideoById({
      videoId: window.youTubeVideoId,
      startSeconds: start,
      endSeconds: end
    });

    clearInterval(checkInterval);
    checkInterval = setInterval(() => {
      if (player.getCurrentTime() >= stopTime) {
        player.pauseVideo();
        clearInterval(checkInterval);
      }
    }, 300);
  } else {
    console.error("Lecteur non prêt");
  }
}
