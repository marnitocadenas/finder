import './bootstrap';
import '../css/app.css';
setTimeout(()=>document.querySelectorAll('.auto-dismiss').forEach((el)=>el.remove()),4000);
async function refreshNotificationCount(){const badge=document.querySelector('[data-notification-count]');if(!badge)return;try{const response=await fetch('/notifications/count',{headers:{'X-Requested-With':'XMLHttpRequest'}});const data=await response.json();badge.textContent=data.count;badge.classList.toggle('d-none',data.count<1);}catch(e){}}
setInterval(refreshNotificationCount,30000);refreshNotificationCount();
