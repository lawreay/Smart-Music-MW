// Extended song list with metadata
const allTracks = [
  { id: 0, src: "Halsey_-_Without_Me(128k).m4a", type: "audio/mp4", song: "Without Me", artist: "Halsey", art: "LAWREAY TECH Logo Design.png" },
  { id: 1, src: "Nasty_C_-_See_Me_Now__Remix__feat._MAETA(128k).m4a", type: "audio/mp4", song: "See Me Now (Remix)", artist: "Nasty C feat. MAETA", art: "LAWREAY TECH Logo Design.png" },
  { id: 2, src: "Malinga_-_Chete_ft._Zeze_Kingston__Official_Music_Video_(128k).m4a", type: "audio/mp4", song: "Chete ft. Zeze Kingston", artist: "Malinga", art: "LAWREAY TECH Logo Design.png" },
  { id: 3, src: "POP_SMOKE_-_WHAT_YOU_KNOW_BOUT_LOVE__Official_Video_(128k).m4a", type: "audio/mp4", song: "WHAT YOU KNOW BOUT LOVE", artist: "Pop Smoke", art: "LAWREAY TECH Logo Design.png" },
  { id: 4, src: "Halsey_-_Without_Me(128k).m4a", type: "audio/mp4", song: "Eastside", artist: "Benny Blanco", art: "LAWREAY TECH Logo Design.png" },
  { id: 5, src: "Nasty_C_-_See_Me_Now__Remix__feat._MAETA(128k).m4a", type: "audio/mp4", song: "Good As Hell", artist: "Lizzo", art: "LAWREAY TECH Logo Design.png" },
  { id: 6, src: "Malinga_-_Chete_ft._Zeze_Kingston__Official_Music_Video_(128k).m4a", type: "audio/mp4", song: "Levitating", artist: "Dua Lipa", art: "LAWREAY TECH Logo Design.png" },
  { id: 7, src: "POP_SMOKE_-_WHAT_YOU_KNOW_BOUT_LOVE__Official_Video_(128k).m4a", type: "audio/mp4", song: "Blinding Lights", artist: "The Weeknd", art: "LAWREAY TECH Logo Design.png" }
];

let filteredTracks = [...allTracks];

// Intersection Observer for lazy loading
const observerOptions = {
  root: null,
  rootMargin: '50px',
  threshold: 0.01
};

const imageObserver = new IntersectionObserver((entries) => {
  entries.forEach(entry => {
    if (entry.isIntersecting) {
      const img = entry.target;
      const src = img.dataset.src;
      if (src) {
        img.src = src;
        img.classList.remove('skeleton');
        imageObserver.unobserve(img);
      }
    }
  });
}, observerOptions);

// Search functionality
function initializeSearch() {
  const searchInput = document.getElementById('searchInput');
  const clearSearchBtn = document.getElementById('clearSearch');
  
  if (!searchInput) return;
  
  searchInput.addEventListener('input', (e) => {
    const query = e.target.value.toLowerCase().trim();
    
    if (query.length > 0) {
      clearSearchBtn.style.display = 'block';
      filteredTracks = allTracks.filter(track => 
        track.song.toLowerCase().includes(query) || 
        track.artist.toLowerCase().includes(query)
      );
    } else {
      clearSearchBtn.style.display = 'none';
      filteredTracks = [...allTracks];
    }
    
    renderSongCards();
  });
  
  clearSearchBtn.addEventListener('click', () => {
    searchInput.value = '';
    clearSearchBtn.style.display = 'none';
    filteredTracks = [...allTracks];
    renderSongCards();
  });
}

// Create song cards and populate the grid
function renderSongCards() {
  const songsGrid = document.getElementById('songsGrid');
  if (!songsGrid) return;
  
  songsGrid.innerHTML = '';
  
  if (filteredTracks.length === 0) {
    songsGrid.innerHTML = '<div style="grid-column: 1/-1; text-align: center; padding: 20px; color: var(--muted);">No tracks found</div>';
    return;
  }
  
  filteredTracks.forEach((track, index) => {
    const card = document.createElement('div');
    card.className = 'song-card';
    card.style.animationDelay = `${index * 0.08}s`;
    
    const isLiked = isTrackLiked(track.id);
    
    card.innerHTML = `
      <img 
        class="song-card-img skeleton" 
        data-src="${track.art}" 
        src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='200' height='200'%3E%3Crect fill='%230f1720' width='200' height='200'/%3E%3C/svg%3E"
        alt="${track.song}"
      >
      <div class="song-card-title">${track.song}</div>
      <div class="song-card-artist">${track.artist}</div>
      <div style="display:flex; gap:6px;">
        <button class="song-card-like-btn ${isLiked ? 'liked' : ''}" data-track-id="${track.id}" title="Like">♡</button>
        <button class="song-card-btn" data-track-id="${track.id}" style="flex:1;">▶ Play</button>
      </div>
    `;
    
    // Observe image for lazy loading
    const img = card.querySelector('.song-card-img');
    imageObserver.observe(img);
    
    // Like button handler
    const likeBtn = card.querySelector('.song-card-like-btn');
    likeBtn.addEventListener('click', (e) => {
      e.stopPropagation();
      toggleLike(track.id, likeBtn);
    });
    
    // Play button handler
    const playBtn = card.querySelector('.song-card-btn');
    playBtn.addEventListener('click', (e) => {
      e.preventDefault();
      playTrackFromCard(track);
      updateActiveCard(card);
    });
    
    songsGrid.appendChild(card);
  });
}

// Play track from song card
function playTrackFromCard(track) {
  const audio = document.getElementById('audio');
  const songName = document.getElementById('songName');
  const artistName = document.getElementById('artistName');
  const artwork = document.getElementById('artwork');
  const downloadBtn = document.getElementById('downloadBtn');
  const playPause = document.getElementById('playPause');
  const select = document.getElementById('trackSelect');
  
  // Update bottom player
  updateBottomPlayer(track);
  
  if (audio && songName && artistName && artwork) {
    audio.pause();
    audio.src = track.src;
    audio.type = track.type;
    audio.load();
    
    songName.textContent = track.song;
    artistName.textContent = track.artist;
    artwork.src = track.art;
    
    if (downloadBtn) downloadBtn.href = track.src;
    if (select) select.value = String(track.id);
    
    // Play with smooth transition
    audio.play().catch(() => {});
    
    if (playPause) {
      playPause.textContent = '⏸';
      playPause.setAttribute('aria-pressed', 'true');
    }
  }
}

// Update bottom player
function updateBottomPlayer(track) {
  const bottomSongName = document.getElementById('bottomSongName');
  const bottomArtistName = document.getElementById('bottomArtistName');
  const bottomArt = document.getElementById('bottomArt');
  const likeBtnMini = document.getElementById('likeBtnMini');
  
  if (bottomSongName) bottomSongName.textContent = track.song;
  if (bottomArtistName) bottomArtistName.textContent = track.artist;
  if (bottomArt) bottomArt.src = track.art;
  
  // Update like button state
  if (likeBtnMini) {
    likeBtnMini.dataset.trackId = track.id;
    if (isTrackLiked(track.id)) {
      likeBtnMini.classList.add('liked');
      likeBtnMini.textContent = '♥';
    } else {
      likeBtnMini.classList.remove('liked');
      likeBtnMini.textContent = '♡';
    }
  }
}

// Update active card styling
function updateActiveCard(activeCard) {
  document.querySelectorAll('.song-card').forEach(card => {
    card.classList.remove('active');
  });
  if (activeCard) {
    activeCard.classList.add('active');
  }
}

// Like tracking functions
function isTrackLiked(trackId) {
  const likes = JSON.parse(localStorage.getItem('smartMusicLikes') || '[]');
  return likes.includes(trackId);
}

function toggleLike(trackId, button) {
  const likes = JSON.parse(localStorage.getItem('smartMusicLikes') || '[]');
  const index = likes.indexOf(trackId);
  
  if (index > -1) {
    likes.splice(index, 1);
    if (button) {
      button.classList.remove('liked');
      button.textContent = '♡';
    }
  } else {
    likes.push(trackId);
    if (button) {
      button.classList.add('liked');
      button.textContent = '♥';
    }
  }
  
  localStorage.setItem('smartMusicLikes', JSON.stringify(likes));
  
  // Update all like buttons for this track
  document.querySelectorAll(`[data-track-id="${trackId}"]`).forEach(btn => {
    if (btn.classList.contains('song-card-like-btn') || btn.classList.contains('like-btn-mini')) {
      if (index > -1) {
        btn.classList.remove('liked');
        btn.textContent = '♡';
      } else {
        btn.classList.add('liked');
        btn.textContent = '♥';
      }
    }
  });
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', () => {
  renderSongCards();
  initializeSearch();
  
  // Listen for track changes and update active card
  const trackSelect = document.getElementById('trackSelect');
  if (trackSelect) {
    trackSelect.addEventListener('change', () => {
      const trackId = parseInt(trackSelect.value, 10);
      const cards = document.querySelectorAll('.song-card');
      if (cards[trackId]) {
        updateActiveCard(cards[trackId]);
      }
    });
  }
});

// Export for use in player.js
if (typeof module !== 'undefined' && module.exports) {
  module.exports = { allTracks, playTrackFromCard, renderSongCards, isTrackLiked, toggleLike };
}
