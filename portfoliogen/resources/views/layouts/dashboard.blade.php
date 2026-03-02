<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>@yield('title', 'Dashboard - PortfolioGen')</title>
  <link rel="icon" type="image/png" href="{{ asset('images/icon.png') }}">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/portfolio-step.css') }}">
<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}?v={{ time() }}">
<link rel="stylesheet" href="{{ asset('css/dashboard-published.css') }}">
</head>
<body style="margin:0;">
  @yield('content')

 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
function pgRenderAiList(containerEl, suggestions, onPick){
  if(!containerEl) return;

  const items = Array.isArray(suggestions) ? suggestions : [];
  if(!items.length){
    containerEl.innerHTML = "";
    return;
  }

  containerEl.innerHTML = `
    <div style="display:flex; flex-direction:column; gap:10px; margin-top:10px;">
      ${items.map((s, i) => `
        <button type="button"
          style="text-align:left; padding:12px 14px; border-radius:14px; background:rgba(255,255,255,.06); border:1px solid rgba(255,255,255,.14); color:rgba(255,255,255,.92); line-height:1.5;"
          data-i="${i}">
          ${String(s).replace(/</g,"&lt;")}
        </button>
      `).join("")}
    </div>
  `;

  containerEl.querySelectorAll("button[data-i]").forEach(btn => {
    btn.addEventListener("click", () => {
      const i = Number(btn.getAttribute("data-i"));
      const val = items[i];
      if(onPick) onPick(val);
    });
  });
}

async function pgAiSuggest(type, text, context){
  const res = await fetch("/ai/suggest", {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
      "Accept": "application/json",
      "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]')?.content || ""
    },
    body: JSON.stringify({ type, text, context })
  });
  const data = await res.json();
if(!data.ok) throw new Error((data.error || "AI failed"));
  return data.suggestions || [];
}

function pgBindAiAutocomplete({ inputId, type, contextBuilder, onPick, minChars=2 }){
  const input = document.getElementById(inputId);
  if(!input) return;

  const wrap = document.createElement("div");
  wrap.style.position = "relative";
  input.parentNode.insertBefore(wrap, input);
  wrap.appendChild(input);

  const drop = document.createElement("div");
  drop.style.display = "none";
  drop.style.position = "absolute";
  drop.style.left = "0";
  drop.style.right = "0";
  drop.style.top = "calc(100% + 8px)";
  drop.style.zIndex = "80";
  drop.style.background = "rgba(10,10,10,.96)";
  drop.style.border = "1px solid rgba(255,255,255,.14)";
  drop.style.borderRadius = "14px";
  drop.style.overflow = "hidden";
  drop.style.boxShadow = "0 20px 60px rgba(0,0,0,.35)";
  wrap.appendChild(drop);

  let t = null, last = "";

  async function run(){
    const q = (input.value || "").trim();
    if(q.length < minChars){ drop.style.display="none"; drop.innerHTML=""; return; }
    if(q === last) return;
    last = q;

    drop.style.display="block";
    drop.innerHTML = `<div style="padding:10px 12px; opacity:.75;">Thinking...</div>`;

    try{
      const ctx = (typeof contextBuilder === "function") ? contextBuilder() : (contextBuilder || {});
      const items = await pgAiSuggest(type, q, ctx);

      if(!items.length){ drop.style.display="none"; drop.innerHTML=""; return; }

      drop.innerHTML = items.slice(0,8).map((x) => `
        <button type="button"
          style="width:100%; text-align:left; padding:10px 12px; background:transparent; border:0; color:rgba(255,255,255,.92);"
          class="pg-ai-item">${String(x).replace(/</g,"&lt;")}</button>
      `).join("");

      drop.querySelectorAll(".pg-ai-item").forEach(btn => {
        btn.addEventListener("click", () => {
          const val = btn.textContent;
          if(onPick) onPick(val);
          else input.value = val;
          drop.style.display="none";
          drop.innerHTML="";
        });
      });

    }catch(e){
      drop.innerHTML = `<div style="padding:10px 12px; color:#ff6b6b;">AI failed: ${e.message}</div>`;
    }
  }

  input.addEventListener("input", () => {
    clearTimeout(t);
    t = setTimeout(run, 350);
  });

  document.addEventListener("click", (e) => {
    if(!wrap.contains(e.target)){
      drop.style.display="none";
    }
  });
}
</script>
</body>
</html>