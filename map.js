// Map
let map = L.map('map',{center:[20,0],zoom:3,minZoom:3,maxZoom:19});
const worldBounds=[[-90,-180],[90,180]];

L.tileLayer('https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png',{
    attribution:'&copy; OpenStreetMap &copy; CARTO', subdomains:'abcd', maxZoom:19, noWrap:true
}).addTo(map);

map.setMaxBounds(worldBounds);
map.on('drag',()=>map.panInsideBounds(worldBounds,{animate:false}));
window.addEventListener('resize',()=>map.invalidateSize());

// Random Color
function getRandomColor(){ const colors=['yellow','blue','red','green','purple','orange']; return colors[Math.floor(Math.random()*colors.length)]; }

// Pins
function loadPins(){
    fetch('fetch_pins.php')
    .then(res=>res.json())
    .then(data=>{
        if(data.error){ console.error(data.error); return; }
        data.forEach(pin=>{
            const color=pin.color||getRandomColor();
            const icon=L.divIcon({html:`<div class="city-light ${color}"></div>`,className:'',iconSize:[12,12],iconAnchor:[6,6]});
            L.marker([pin.latitude,pin.longitude],{icon}).addTo(map).bindPopup(`${pin.message}<br><small>${pin.created_at}</small>`);
        });
    })
    .catch(err=>console.error(err));
}
loadPins();

// Modal
let selectedLat, selectedLng, selectedColor=null;
map.on('click',e=>{
    selectedLat=e.latlng.lat; selectedLng=e.latlng.lng;
    document.getElementById('modal').style.display='flex';
    document.getElementById('message').focus();
});

function closeModal(){
    document.getElementById('modal').style.display='none';
    document.getElementById('message').value='';
    selectedColor=null;
    document.querySelectorAll('.color-circle').forEach(c=>c.style.borderColor='#fff');
}

function selectColor(color){
    selectedColor=color;
    document.querySelectorAll('.color-circle').forEach(c=>c.style.borderColor='#fff');
    const circle=document.querySelector(`.color-circle.${color}`);
    if(circle) circle.style.borderColor='#00c6ff';
}

function savePin(){
    const message=document.getElementById('message').value.trim();
    if(!message){ alert("Write something!"); return; }
    if(selectedLat===undefined||selectedLng===undefined){ alert("Click map first!"); return; }

    const color=selectedColor||getRandomColor();
    fetch('save_pin.php',{
        method:'POST',
        headers:{'Content-Type':'application/x-www-form-urlencoded'},
        body:`lat=${selectedLat}&lng=${selectedLng}&message=${encodeURIComponent(message)}&color=${color}`
    })
    .then(async res=>{
        const data=JSON.parse(await res.text());
        if(data.error){ alert(data.error); return; }
        const icon=L.divIcon({html:`<div class="city-light ${data.color}"></div>`,className:'',iconSize:[12,12],iconAnchor:[6,6]});
        L.marker([data.latitude,data.longitude],{icon}).addTo(map).bindPopup(`${data.message}<br><small>${data.created_at}</small>`);
        closeModal();
    })
    .catch(err=>{ console.error(err); alert("Failed to save pin"); });
}