/* Grafik SVG sederhana (tanpa library) */
const bars=(d,max,h=130,fmt=v=>v)=>`<div class="bars">${d.map(([k,v])=>`<div><b>${fmt(v)}</b><i style="height:${v/max*h}px"></i>${k}</div>`).join('')}</div>`;
function line(A,B,L,na,nb){const M=Math.max(50,Math.ceil(Math.max(...A,...B)/50)*50),n=Math.max(1,L.length-1),x=i=>40+i*530/n,y=v=>190-v/M*180,P=a=>a.map((v,i)=>`${i?'L':'M'}${x(i)},${y(v)}`).join('');
 const grid=[0,1,2,3,4,5].map(i=>{const v=M/5*i;return `<line x1="40" x2="570" y1="${y(v)}" y2="${y(v)}" stroke="#eceaf8"/><text x="32" y="${y(v)+3}" text-anchor="end" class="ax">${v}</text>`}).join('');
 const lab=L.map((t,i)=>`<text x="${x(i)}" y="208" text-anchor="middle" class="ax">${t}</text>`).join('');
 return `<div class="leg"><span><i class="dot" style="background:#6d3df2"></i>${na}</span><span><i class="dot" style="background:#8b9cf6"></i>${nb}</span></div><svg viewBox="0 0 600 215" class="w">${grid}${lab}<path d="${P(A)}L${x(A.length-1)},190L40,190Z" fill="#6d3df2" opacity=".08"/><path d="${P(A)}" fill="none" stroke="#6d3df2" stroke-width="2.5"/><path d="${P(B)}" fill="none" stroke="#8b9cf6" stroke-width="2.5"/>${A.map((v,i)=>`<circle cx="${x(i)}" cy="${y(v)}" r="3.5" fill="#6d3df2"/>`).join('')}${B.map((v,i)=>`<circle cx="${x(i)}" cy="${y(v)}" r="3.5" fill="#8b9cf6"/>`).join('')}</svg>`}
function donut(a,d,f){const T=a+d+f||1,s=[[a,'#22b573','Published'],[d,'#fb923c','Draft'],[f,'#8b5cf6','Selesai']];let o=0;
 const arcs=s.map(([v,c])=>{const p=v/T*100,r=p?`<circle cx="21" cy="21" r="15.9" fill="none" stroke="${c}" stroke-width="6" stroke-dasharray="${p} ${100-p}" stroke-dashoffset="${-o}"/>`:'';o+=p;return r}).join('');
 return `<div class="don"><svg width="150" height="150" viewBox="0 0 42 42"><circle cx="21" cy="21" r="15.9" fill="none" stroke="#f0eefb" stroke-width="6"/><g transform="rotate(-90 21 21)">${arcs}</g><text x="21" y="22" text-anchor="middle" font-size="8" font-weight="700" fill="#1e1b4b">${a+d+f}</text><text x="21" y="27" text-anchor="middle" font-size="3" fill="#6b6a8a">Total Webinar</text></svg>
 <ul>${s.map(([v,c,n])=>`<li><i class="dot" style="background:${c}"></i>${n}<span>${v} (${(v/T*100).toFixed(1).replace('.',',')}%)</span></li>`).join('')}</ul></div>`}

/* ---------- CRUD dialog: tambah / lihat / ubah ---------- */
function crudOpen(mode, row, keep) {
  const f = document.getElementById('crudForm'), d = document.getElementById('crudDlg'), id = row && row.id;
  [...f.elements].forEach(e => {
    if (!e.name || e.name[0] == '_') return;
    if (!keep) e.value = e.tagName == 'SELECT' ? (e.options[0] ? e.options[0].value : '') : '';
    e.disabled = mode == 'view';
  });
  if (!keep) f.querySelectorAll('.err').forEach(e => e.remove());
  if (row) Object.entries(row).forEach(([k, v]) => { const e = f.elements[k]; if (e && k != 'id') e.value = v ?? ''; });
  f.elements._id.value = id || '';
  f.elements._method.value = id ? 'PUT' : 'POST';
  f.action = id ? f.dataset.update.replace('__ID__', id) : f.dataset.store;
  document.getElementById('crudTitle').textContent = {new: 'Tambah', edit: 'Ubah', view: 'Detail'}[mode] + ' ' + f.dataset.label;
  document.getElementById('crudSave').hidden = mode == 'view';
  d.showModal();
}
document.querySelectorAll('.toast').forEach(t => setTimeout(() => t.remove(), 3500));