(function() {
  function initMainPlayerLike() {
    const likeBtn = document.getElementById('likeBtn');
    if (!likeBtn) return;
    let currentTrackId = null;
    const updateCurrentTrack = () => {
      const select = document.getElementById('trackSelect');
      if (select) {
        currentTrackId = parseInt(select.value, 10);
        updateLikeBtnState();
      }
    };
    
    const updateLikeBtnState = () => {
      if (currentTrackId !== null) {
        const isLiked = isTrackLiked(currentTrackId);
        if (isLiked) {
          likeBtn.textContent = '♥ Liked';
          likeBtn.style.color = '#ff4d6d';
          likeBtn.classList.add('liked');
        } else {
          likeBtn.textContent = '♡ Like';
          likeBtn.style.color = 'var(--muted)';
          likeBtn.classList.remove('liked');
        }
      }
    };
    
    likeBtn.addEventListener('click', () => {
      if (currentTrackId !== null) {
        toggleLike(currentTrackId);
        updateLikeBtnState();
        likeBtn.style.transform = 'scale(1.2)';
        setTimeout(() => { likeBtn.style.transform = 'scale(1)'; }, 150);
      }
    });
    const trackSelect = document.getElementById('trackSelect');
    if (trackSelect) {
      trackSelect.addEventListener('change', updateCurrentTrack);
    }
    
    updateCurrentTrack();
  }
  function initBottomPlayerLike() {
    const likeBtnMini = document.getElementById('likeBtnMini');
    if (!likeBtnMini) return;
    
    likeBtnMini.addEventListener('click', (e) => {
      e.stopPropagation();
      const trackId = parseInt(likeBtnMini.dataset.trackId || '0', 10);
      toggleLike(trackId);
      updateMiniLikeBtn(trackId);
      likeBtnMini.style.transform = 'scale(1.2)';
      setTimeout(() => { likeBtnMini.style.transform = 'scale(1)'; }, 150);
    });
  }
  function updateMiniLikeBtn(trackId) {
    const likeBtnMini = document.getElementById('likeBtnMini');
    if (!likeBtnMini) return;
    
    if (isTrackLiked(trackId)) {
      likeBtnMini.classList.add('liked');
      likeBtnMini.textContent = '♥';
    } else {
      likeBtnMini.classList.remove('liked');
      likeBtnMini.textContent = '♡';
    }
  }
  function isTrackLiked(trackId) {
    const likes = JSON.parse(localStorage.getItem('smartMusicLikes') || '[]');
    return likes.includes(trackId);
  }
  function toggleLike(trackId) {
    const likes = JSON.parse(localStorage.getItem('smartMusicLikes') || '[]');
    const index = likes.indexOf(trackId);
    
    if (index > -1) {
      likes.splice(index, 1);
    } else {
      likes.push(trackId);
    }
    
    localStorage.setItem('smartMusicLikes', JSON.stringify(likes));
    updateAllLikeButtons(trackId);
    document.dispatchEvent(new CustomEvent('likeStatusChanged', { 
      detail: { trackId, isLiked: index === -1 } 
    }));
  }
  function updateAllLikeButtons(trackId) {
    const isLiked = isTrackLiked(trackId);
    const mainLikeBtn = document.getElementById('likeBtn');
    if (mainLikeBtn && parseInt(document.getElementById('trackSelect')?.value || '0') === trackId) {
      if (isLiked) {
        mainLikeBtn.textContent = '♥ Liked';
        mainLikeBtn.style.color = '#ff4d6d';
        mainLikeBtn.classList.add('liked');
      } else {
        mainLikeBtn.textContent = '♡ Like';
        mainLikeBtn.style.color = 'var(--muted)';
        mainLikeBtn.classList.remove('liked');
      }
    }
    const miniLikeBtn = document.getElementById('likeBtnMini');
    if (miniLikeBtn && parseInt(miniLikeBtn.dataset.trackId || '0') === trackId) {
      if (isLiked) {
        miniLikeBtn.classList.add('liked');
        miniLikeBtn.textContent = '♥';
      } else {
        miniLikeBtn.classList.remove('liked');
        miniLikeBtn.textContent = '♡';
      }
    }
    document.querySelectorAll(`.song-card-like-btn[data-track-id="${trackId}"]`).forEach(btn => {
      if (isLiked) {
        btn.classList.add('liked');
        btn.textContent = '♥';
      } else {
        btn.classList.remove('liked');
        btn.textContent = '♡';
      }
    });
  }
  window.smartMusicLikes = {
    isTrackLiked,
    toggleLike,
    updateMiniLikeBtn
  };
  document.addEventListener('DOMContentLoaded', () => {
    initMainPlayerLike();
    initBottomPlayerLike();
  });
  
})();
