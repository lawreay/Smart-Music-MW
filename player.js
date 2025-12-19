(function(){
  const audio = document.getElementById("audio"),
    playPause = document.getElementById("playPause"),
    progress = document.getElementById("progress"),
    progFill = document.getElementById("progFill"),
    timeDisplay = document.getElementById("timeDisplay"),
    volRange = document.getElementById("volRange"),
    muteBtn = document.getElementById("muteBtn"),
    prevBtn = document.getElementById("prevBtn"),
    nextBtn = document.getElementById("nextBtn"),
    select = document.getElementById("trackSelect"),
    songName = document.getElementById("songName"),
    artistName = document.getElementById("artistName"),
    artwork = document.getElementById("artwork"),
    downloadBtn = document.getElementById("downloadBtn"),
    fileLoader = document.getElementById("fileLoader");

  const playPauseMini = document.getElementById("playPauseMini"),
    nextBtnMini = document.getElementById("nextBtnMini"),
    bottomProgress = document.getElementById("bottomProgress"),
    bottomProgressFill = document.getElementById("bottomProgressFill"),
    bottomDownloadBtn = document.getElementById("bottomDownloadBtn");
  const tracks = [
    { src: "Halsey_-_Without_Me(128k).m4a", type: "audio/mp4", song: "Without Me", artist: "Halsey", art: "LAWREAY TECH Logo Design.png" },
    { src: "Nasty_C_-_See_Me_Now__Remix__feat._MAETA(128k).m4a", type: "audio/mp4", song: "See Me Now (Remix)", artist: "Nasty C feat. MAETA", art: "LAWREAY TECH Logo Design.png" },
    { src: "Malinga_-_Chete_ft._Zeze_Kingston__Official_Music_Video_(128k).m4a", type: "audio/mp4", song: "Chete ft. Zeze Kingston", artist: "Malinga", art: "LAWREAY TECH Logo Design.png" },
    { src: "POP_SMOKE_-_WHAT_YOU_KNOW_BOUT_LOVE__Official_Video_(128k).m4a", type: "audio/mp4", song: "WHAT YOU KNOW BOUT LOVE", artist: "Pop Smoke", art: "LAWREAY TECH Logo Design.png" }
  ];

  let index = 0;
  function fmt(t){ if(isNaN(t)) return "00:00"; t = Math.floor(t); const h = Math.floor(t/3600); const m = Math.floor((t%3600)/60); const s = t%60; return h>0? h+":"+String(m).padStart(2,'0')+":"+String(s).padStart(2,'0') : String(m).padStart(2,'0')+":"+String(s).padStart(2,'0'); }

  function loadTrack(i){ 
    index = (i + tracks.length) % tracks.length; 
    const t = tracks[index]; 
    audio.pause(); 
    audio.src = t.src; 
    audio.type = t.type; 
    audio.load(); 
    songName.textContent = t.song; 
    artistName.textContent = t.artist; 
    artwork.src = t.art; 
    downloadBtn.href = t.src;
    if (bottomDownloadBtn) bottomDownloadBtn.href = t.src; 
    select.value = String(index); 
    playPause.textContent = "▶"; 
    playPause.setAttribute("aria-pressed","false"); 
    progFill.style.width = "0%"; 
    timeDisplay.textContent = "00:00 / 00:00"; 
    
    updateBottomPlayerDisplay(t);
    updateActiveSongCard(index);
  }

  function updateBottomPlayerDisplay(track) {
    const bottomSongName = document.getElementById('bottomSongName');
    const bottomArtistName = document.getElementById('bottomArtistName');
    const bottomArt = document.getElementById('bottomArt');
    
    if (bottomSongName) bottomSongName.textContent = track.song;
    if (bottomArtistName) bottomArtistName.textContent = track.artist;
    if (bottomArt) bottomArt.src = track.art;
  }

  function updateActiveSongCard(trackId) {
    const cards = document.querySelectorAll('.song-card');
    cards.forEach((card, idx) => {
      if (idx === trackId) {
        card.classList.add('active');
      } else {
        card.classList.remove('active');
      }
    });
  }

  audio.addEventListener("loadedmetadata", ()=>{ timeDisplay.textContent = fmt(0) + " / " + fmt(audio.duration); });
  audio.addEventListener("timeupdate", ()=>{ 
    const pct = (audio.currentTime / audio.duration) * 100 || 0; 
    progFill.style.width = pct + "%"; 
    progress.setAttribute("aria-valuenow", Math.floor(pct)); 
    timeDisplay.textContent = fmt(audio.currentTime) + " / " + fmt(audio.duration);
    
    if (bottomProgressFill) {
      bottomProgressFill.style.width = pct + "%";
    }
  });

  playPause.addEventListener("click", ()=>{ 
    if(audio.paused){ 
      audio.play().catch(()=>{}); 
      playPause.textContent = "⏸"; 
      playPause.setAttribute("aria-pressed","true");
      if (playPauseMini) {
        playPauseMini.textContent = "⏸";
      }
    } else { 
      audio.pause(); 
      playPause.textContent = "▶"; 
      playPause.setAttribute("aria-pressed","false");
      if (playPauseMini) {
        playPauseMini.textContent = "▶";
      }
    } 
  });
  
  if (playPauseMini) {
    playPauseMini.addEventListener("click", () => {
      playPause.click();
    });
  }
  
  prevBtn.addEventListener("click", ()=>{ loadTrack(index - 1); audio.play().catch(()=>{}); playPause.textContent = "⏸"; playPause.setAttribute("aria-pressed","true"); if (playPauseMini) playPauseMini.textContent = "⏸"; });
  nextBtn.addEventListener("click", ()=>{ loadTrack(index + 1); audio.play().catch(()=>{}); playPause.textContent = "⏸"; playPause.setAttribute("aria-pressed","true"); if (playPauseMini) playPauseMini.textContent = "⏸"; });

  if (nextBtnMini) {
    nextBtnMini.addEventListener("click", () => {
      nextBtn.click();
    });
  }

  select.addEventListener("change", (e)=>{ loadTrack(parseInt(e.target.value,10)); audio.play().catch(()=>{}); playPause.textContent = "⏸"; playPause.setAttribute("aria-pressed","true"); if (playPauseMini) playPauseMini.textContent = "⏸"; });

  function seek(e){ 
    const rect = progress.getBoundingClientRect(); 
    const clientX = e.type.startsWith("touch") ? e.touches[0].clientX : e.clientX; 
    const x = clientX - rect.left; 
    const pct = Math.max(0, Math.min(1, x / rect.width)); 
    if(!isNaN(audio.duration)) audio.currentTime = pct * audio.duration; 
  }

  function seekBottom(e) {
    const rect = bottomProgress.getBoundingClientRect();
    const clientX = e.type.startsWith("touch") ? e.touches[0].clientX : e.clientX;
    const x = clientX - rect.left;
    const pct = Math.max(0, Math.min(1, x / rect.width));
    if (!isNaN(audio.duration)) audio.currentTime = pct * audio.duration;
  }

  progress.addEventListener("click", seek); 
  progress.addEventListener("touchstart", seek);
  
  if (bottomProgress) {
    bottomProgress.addEventListener("click", seekBottom);
    bottomProgress.addEventListener("touchstart", seekBottom);
  }

  volRange.addEventListener("input", (e)=>{ audio.volume = parseFloat(e.target.value); updateMute(); });
  muteBtn.addEventListener("click", ()=>{ audio.muted = !audio.muted; updateMute(); });
  function updateMute(){ muteBtn.textContent = audio.muted || audio.volume === 0 ? "🔇" : "🔊"; if(!audio.muted) volRange.value = audio.volume; }

  progress.addEventListener("keydown", (e)=>{ if(e.key === "ArrowLeft") audio.currentTime = Math.max(0, audio.currentTime - 5); if(e.key === "ArrowRight") audio.currentTime = Math.min(audio.duration, audio.currentTime + 5); });
  audio.addEventListener("ended", ()=>{ playPause.textContent = "▶"; playPause.setAttribute("aria-pressed","false"); if (playPauseMini) playPauseMini.textContent = "▶"; nextBtn.click(); });
  audio.volume = parseFloat(volRange.value); 
  updateMute(); 
  loadTrack(0);

  if(fileLoader){ fileLoader.addEventListener('change', (e)=>{
    const files = Array.from(e.target.files).filter(f=>f.type.startsWith('audio'));
    if(files.length===0) return;
    files.forEach((f)=>{
      const url = URL.createObjectURL(f);
      tracks.push({ src: url, type: f.type, song: f.name, artist: 'Local file', art: 'LAWREAY TECH Logo Design.png' });
      const opt = document.createElement('option'); 
      opt.value = String(tracks.length-1); 
      opt.textContent = f.name; 
      select.appendChild(opt);
    });
    const firstIndex = tracks.length - files.length;
    loadTrack(firstIndex);
    audio.play().catch(()=>{});
    playPause.textContent = "⏸"; 
    playPause.setAttribute("aria-pressed","true");
    if (playPauseMini) playPauseMini.textContent = "⏸";
  }); }

})();

(function(){ 
  const rating = document.getElementById('rating'); 
  if(!rating) return; 
  let current=0; 
  function render(n){ 
    [...rating.querySelectorAll('span')].forEach((el,i)=>{ 
      el.style.opacity = i < n ? '1' : '0.35';
      if (i < n) {
        el.style.transform = 'scale(1.1)';
      } else {
        el.style.transform = 'scale(1)';
      }
    }); 
  } 
  rating.addEventListener('click',(e)=>{ 
    const star = e.target.getAttribute('data-star'); 
    if(star){ 
      current = parseInt(star,10); 
      render(current);
    } 
  }); 
  render(0);
})();