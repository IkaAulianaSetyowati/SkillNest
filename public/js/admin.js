// ================= CHART HELPERS =================

function line(a, b, labels, labelA, labelB){
  const w = 560, h = 160, pad = 20;
  const max = Math.max(1, ...a, ...b);
  const pt = (arr) => arr.map((v,i) => {
    const x = pad + (i * (w - pad*2) / Math.max(1, arr.length - 1));
    const y = h - pad - (v / max) * (h - pad*2);
    return `${x},${y}`;
  }).join(' ');
  return `
  <svg viewBox="0 0 ${w} ${h}" style="width:100%;height:${h}px">
    <polyline points="${pt(b)}" fill="none" stroke="#c9bdfb" stroke-width="2"/>
    <polyline points="${pt(a)}" fill="none" stroke="#6d3df2" stroke-width="2.5"/>
  </svg>
  <div style="display:flex;justify-content:space-between;font-size:10.5px;color:#7a7f95;margin-top:4px">
    ${labels.map(l => `<span>${l}</span>`).join('')}
  </div>
  <div style="display:flex;gap:16px;margin-top:8px;font-size:11.5px;color:#7a7f95">
    <span><span style="display:inline-block;width:8px;height:8px;border-radius:50%;background:#6d3df2;margin-right:5px"></span>${labelA}</span>
    <span><span style="display:inline-block;width:8px;height:8px;border-radius:50%;background:#c9bdfb;margin-right:5px"></span>${labelB}</span>
  </div>`;
}

function donut(a, d, f){
  const total = a + d + f || 1;
  const seg = [
    { v: a, c: '#16a34a', l: 'Published' },
    { v: d, c: '#f59e0b', l: 'Draft' },
    { v: f, c: '#6d3df2', l: 'Selesai' },
  ];
  let acc = 0;
  const circles = seg.map(s => {
    const pct = s.v / total;
    const dash = `${pct * 251} 251`;
    const offset = 251 - (acc * 251);
    acc += pct;
    return `<circle r="40" cx="50" cy="50" fill="none" stroke="${s.c}" stroke-width="16" stroke-dasharray="${dash}" stroke-dashoffset="${offset}" transform="rotate(-90 50 50)"/>`;
  }).join('');
  return `
  <div style="display:flex;align-items:center;gap:18px">
    <svg viewBox="0 0 100 100" style="width:120px;height:120px">${circles}
      <text x="50" y="47" text-anchor="middle" font-size="15" font-weight="700" fill="#1f2333">${total}</text>
      <text x="50" y="61" text-anchor="middle" font-size="8" fill="#7a7f95">Total</text>
    </svg>
    <div style="display:flex;flex-direction:column;gap:8px;font-size:12px">
      ${seg.map(s => `<span><span style="display:inline-block;width:8px;height:8px;border-radius:50%;background:${s.c};margin-right:6px"></span>${s.l} (${s.v})</span>`).join('')}
    </div>
  </div>`;
}

function bars(data, max, h, fmt){
  fmt = fmt || (v => v);
  return `<div class="barw" style="--h:${h}px">
    ${data.map(([label, val]) => `
      <div class="barc">
        <span class="barv">${fmt(val)}</span>
        <div class="barb" style="height:${Math.max(2,(val/max)*(h-30))}px"></div>
        <span class="barl">${label}</span>
      </div>`).join('')}
  </div>`;
}

// ================= CRUD MODAL =================

function crudOpen(mode, row, silent){
  const dlg = document.getElementById('crudDlg');
  const form = document.getElementById('crudForm');
  if (!dlg || !form) return;

  const label = form.dataset.label;
  const titleEl = document.getElementById('crudTitle');
  const idField = form.querySelector('[name="_id"]');
  const methodField = form.querySelector('[name="_method"]');

  form.reset();
  idField.value = row?.id ?? '';

  if (mode === 'new'){
    titleEl.textContent = 'Tambah ' + label;
    form.action = form.dataset.store;
    methodField.value = 'POST';
    setDisabled(form, false);
  } else {
    form.action = form.dataset.update.replace('__ID__', row.id);
    methodField.value = 'PUT';
    Object.entries(row).forEach(([k, v]) => {
      const el = form.querySelector(`[name="${k}"]`);
      if (el && v !== null && v !== undefined) el.value = v;
    });
    if (mode === 'view'){
      titleEl.textContent = 'Detail ' + label;
      setDisabled(form, true);
    } else {
      titleEl.textContent = 'Ubah ' + label;
      setDisabled(form, false);
    }
  }

  const saveBtn = document.getElementById('crudSave');
  if (saveBtn) saveBtn.style.display = mode === 'view' ? 'none' : '';

  if (!dlg.open) dlg.showModal();
}

function setDisabled(form, val){
  form.querySelectorAll('input, select').forEach(el => {
    if (el.name !== '_id' && el.name !== '_method' && el.name !== '_token') el.disabled = val;
  });
}

// ================= TOAST AUTO CLOSE =================

document.addEventListener('DOMContentLoaded', () => {
  document.querySelectorAll('.toast').forEach(t => {
    setTimeout(() => t.remove(), 4000);
  });
});