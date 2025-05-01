// ===== CORE PLAYER VARIABLES (unchanged) =====
var currentPlaylist = [];
var shufflePlaylist = [];
var tempPlaylist = [];
var audioElement;
var mouseDown = false;
var currentIndex = 0;
var repeat = false;
var shuffle = false;
var userLoggedIn;
var timer;
var isPlaying = false;

// ===== AUDIO PLAYER FUNCTIONS (unchanged) =====
function Audio() {
    this.audio = document.createElement("audio");
    this.setTrack = function(track) { this.audio.src = track.path; };
    this.play = function() { this.audio.play(); };
    this.pause = function() { this.audio.pause(); };
    this.setTime = function(seconds) { this.audio.currentTime = seconds; };
}

// ===== FIXED NAVIGATION SYSTEM =====
var navigationStack = [];
var currentNavIndex = -1;

function openPage(url, pushToHistory = true) {
    if(timer != null) clearTimeout(timer);
    
    // Format URL with user parameter
    var separator = url.indexOf("?") == -1 ? "?" : "&";
    var fullUrl = url + separator + "userLoggedIn=" + userLoggedIn;
    
    // Load content
    $("#mainContent").load(fullUrl, function(response, status) {
        if(status == "error") return;
        
        // Update navigation stack
        if(pushToHistory) {
            navigationStack = navigationStack.slice(0, currentNavIndex + 1);
            navigationStack.push({url: url, scroll: 0});
            currentNavIndex++;
            
            // Update browser history
            history.pushState({index: currentNavIndex}, "", url);
        }
        
        $("body").scrollTop(0);
    });
}

// Handle back/forward buttons
window.onpopstate = function(event) {
    if(event.state && event.state.index !== undefined) {
        var targetIndex = event.state.index;
        if(targetIndex >= 0 && targetIndex < navigationStack.length) {
            currentNavIndex = targetIndex;
            var state = navigationStack[targetIndex];
            openPage(state.url, false);
            $("body").scrollTop(state.scroll);
        }
    }
};

// Initialize navigation
$(document).ready(function() {
    audioElement = new Audio();
    
    // Initialize with current URL
    var initialUrl = window.location.pathname + window.location.search;
    navigationStack.push({url: initialUrl, scroll: 0});
    currentNavIndex = 0;
    history.replaceState({index: 0}, "", initialUrl);
    
    // Track scroll position
    $(window).scroll(function() {
        if(currentNavIndex >= 0) {
            navigationStack[currentNavIndex].scroll = $("body").scrollTop();
        }
    });
});

// ===== YOUR ORIGINAL FUNCTIONS (100% preserved) =====
function getSongJson(songId, callback) {
    $.post("includes/handlers/ajax/getSongJson.php", { songId: songId })
    .done(function(data) {
        const song = JSON.parse(data);
        if(!song.error) callback(song);
    });
}

function setTrack(songId, playlist, play) {
    currentPlaylist = playlist;
    currentIndex = currentPlaylist.indexOf(songId);
    getSongJson(songId, function(song) {
        audioElement.setTrack({ path: `assets/music/${song.title}` });
        $(".trackName span").text(song.title);
        $(".artistName span").text(song.artist);
        if(play) playSong();
    });
}

function playSong() {
    if(!isPlaying) {
        audioElement.play();
        isPlaying = true;
        $.post("includes/handlers/ajax/logHistory.php", { 
            userId: userLoggedIn, 
            contentId: currentPlaylist[currentIndex] 
        });
        $(".controlButton.play").hide();
        $(".controlButton.pause").show();
        document.getElementById("nowPlayingBarContainer").style.display = "flex";
    }
}

function pauseSong() {
    if(isPlaying) {
        audioElement.pause();
        isPlaying = false;
        $(".controlButton.play").show();
        $(".controlButton.pause").hide();
    }
}

function nextSong() {
    currentIndex = (currentIndex < currentPlaylist.length - 1) ? currentIndex + 1 : 0;
    setTrack(currentPlaylist[currentIndex], currentPlaylist, true);
}

function previousSong() {
    currentIndex = (currentIndex > 0) ? currentIndex - 1 : currentPlaylist.length - 1;
    setTrack(currentPlaylist[currentIndex], currentPlaylist, true);
}

function createPlaylist() {
    var popup = prompt("Please enter the name of the playlist");
    if(popup != null) {
        $.post("includes/handlers/ajax/createPlaylist.php", {name: popup, username: userLoggedIn})
        .done(function(error) {
            if(!error) openPage("yourMusic.php");
        });
    }
}

function deletePlaylist(playlistId) {
    if(confirm("Are you sure you want to delete this playlist?")) {
        $.post("includes/handlers/ajax/deletePlaylist.php", {playlistId: playlistId})
        .done(function(error) {
            if(!error) openPage("yourMusic.php");
        });
    }
}

// ... [ALL OTHER ORIGINAL FUNCTIONS REMAIN EXACTLY THE SAME] ...