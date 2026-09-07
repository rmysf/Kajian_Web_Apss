<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="view-transition" content="same-origin" />
<meta name="layout" content="landing" data-turbo-track="reload">
<title>{{ config('app.name', 'Laravel') }} - Cari Kajian Terdekat</title>
@vite(['resources/css/app.css', 'resources/js/app.js'])
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,400;0,9..144,600;0,9..144,700;1,9..144,500;1,9..144,600&family=Amiri:wght@400;700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<script src="https://unpkg.com/swup@4"></script>
<style>
  :root{
    --parchment:#F4EEDC;
    --parchment-deep:#E9DFC2;
    --paper:#FBF7EC;
    --ink:#152A20;
    --ink-soft:#4B5D52;
    --jade-950:#0A2B20;
    --jade-900:#0C3B2A;
    --jade-800:#0F5137;
    --jade-700:#166B48;
    --jade-glow:#3E9E76;
    --gold:#B8863B;
    --gold-soft:#E7C77E;
    --gold-pale:#F3E3B8;
    --terracotta:#A6472B;
    --line:rgba(21,42,32,.14);
    --line-on-dark:rgba(231,199,126,.22);
    --shadow:0 20px 50px rgba(10,43,32,.14);
    --radius:26px;
  }
  *{box-sizing:border-box}
  html, body{
    margin:0;
    padding:0;
    width:100%;
    max-width:100vw;
    overflow-x:hidden;
  }
  body{
    font-family:"Plus Jakarta Sans",ui-sans-serif,system-ui,sans-serif;
    font-family:"Plus Jakarta Sans",ui-sans-serif,system-ui,sans-serif;
    color:var(--ink);
    background:var(--parchment);
    line-height:1.6;
    -webkit-font-smoothing:antialiased;
  }
  a{color:inherit;text-decoration:none}
  img{max-width:100%;display:block}
  .serif{font-family:"Fraunces",serif}
  .arabic{font-family:"Amiri",serif}
  .container{max-width:1180px;margin:0 auto;padding:0 28px}
  .eyebrow{
    font-size:11.5px;
    font-weight:700;
    letter-spacing:.16em;
    text-transform:uppercase;
    color:var(--gold);
    display:inline-flex;
    align-items:center;
    gap:9px;
  }
  .eyebrow::before{
    content:"";
    width:20px;height:1px;
    background:var(--gold);
  }
  .btn{
    display:inline-flex;
    align-items:center;
    gap:8px;
    padding:14px 26px;
    border-radius:999px;
    font-weight:700;
    font-size:14px;
    border:1px solid transparent;
    cursor:pointer;
    transition:transform .25s ease, box-shadow .25s ease, background .25s ease;
  }
  .btn:hover{transform:translateY(-2px)}
  .btn-solid{
    background:var(--jade-900);
    color:var(--parchment);
    box-shadow:0 14px 30px rgba(10,43,32,.28);
  }
  .btn-solid:hover{background:var(--jade-800)}
  .btn-outline{
    border-color:var(--gold);
    color:var(--ink);
    background:transparent;
  }
  .btn-outline:hover{background:var(--gold-pale)}
  .btn-ghost-light{
    border-color:var(--line-on-dark);
    color:var(--parchment);
  }
  .btn-ghost-light:hover{background:rgba(255,255,255,.06)}

  /* ============ TOPBAR ============ */
  .topbar{
    background:var(--jade-950);
    color:var(--gold-soft);
    font-size:12px;
    padding:8px 0;
    border-bottom:1px solid var(--line-on-dark);
  }
  .topbar .container{display:flex;justify-content:space-between;align-items:center}
  .topbar .contact{display:flex;gap:22px}
  .topbar .contact span{display:flex;align-items:center;gap:6px;color:#CFE0D6}
  .topbar .social{display:flex;gap:14px;opacity:.8}

  /* ============ NAV ============ */
  nav.mainnav{
    position:sticky;top:0;z-index:999;
    background:rgba(244,238,220,.86);
    backdrop-filter:blur(14px);
    border-bottom:1px solid var(--line);
  }
  .nav-inner{
    display:flex;align-items:center;justify-content:space-between;
    padding:16px 0;
  }
  .brand{display:flex;align-items:center;gap:10px; z-index:51;}
  .brand-mark{
    width:38px;height:38px;
    display:grid;place-items:center;
    color:var(--jade-900);
  }
  .brand h1{
    margin:0;font-size:19px;font-weight:700;
    font-family:"Fraunces",serif;
    color:var(--ink);
  }
  .brand h1 em{color:var(--gold);font-style:normal}
  .mobile-menu-btn {
    display: none; background: none; border: none; padding: 5px;
    color: var(--ink); cursor: pointer; z-index: 51;
  }
  .nav-content {
    display: flex; align-items: center; justify-content: space-between;
    flex: 1; margin-left: 40px;
  }
  .navlinks{display:flex;gap:34px;font-size:13.5px;font-weight:600;color:var(--ink-soft)}
  .navlinks a{position:relative;padding:4px 0}
  .navlinks a.active{color:var(--jade-900)}
  .navlinks a.active::after{
    content:"";position:absolute;left:0;right:0;bottom:-6px;height:2px;
    background:var(--gold);
  }
  .nav-cta{display:flex;align-items:center;gap:20px;font-size:13px}
  .nav-admin{color:var(--ink-soft)}
  .nav-admin b{color:var(--ink)}
  
  .user-menu {
    position: relative;
    display: inline-block;
  }
  .user-dropdown {
    position: absolute;
    top: 100%;
    right: 0;
    background: var(--paper);
    min-width: 180px;
    border-radius: 12px;
    box-shadow: 0 10px 25px rgba(10,43,32,0.15);
    border: 1px solid var(--line);
    padding: 8px 0;
    margin-top: 10px;
    opacity: 0;
    visibility: hidden;
    transform: translateY(-10px);
    transition: all 0.2s ease;
    z-index: 100;
  }
  .user-menu:hover .user-dropdown,
  .user-menu.active .user-dropdown {
    opacity: 1;
    visibility: visible;
    transform: translateY(0);
  }
  .user-dropdown a, .user-dropdown button {
    display: block;
    width: 100%;
    text-align: left;
    padding: 10px 16px;
    color: var(--ink);
    text-decoration: none;
    font-size: 13.5px;
    font-weight: 500;
    font-family: inherit;
    border: none;
    background: transparent;
    cursor: pointer;
    transition: background 0.2s, color 0.2s;
  }
  .user-dropdown a:hover, .user-dropdown button:hover {
    background: var(--parchment);
    color: var(--jade-900);
  }
  .user-dropdown hr {
    border: none;
    border-top: 1px solid var(--line);
    margin: 4px 0;
  }

  /* ============ HERO ============ */
  .hero{
    position:relative;
    background:
      radial-gradient(ellipse 900px 500px at 82% -10%, rgba(184,134,59,.20), transparent 60%),
      linear-gradient(180deg,var(--jade-950) 0%, var(--jade-900) 55%, var(--jade-800) 100%);
    padding: 20px 0 96px;
    min-height: calc(100vh - 75px + 96px); /* Memastikan kotak putih persis di bawah lipatan layar */
    display: flex;
    align-items: center;
  }
  .hero-lattice{
    position:absolute;inset:0;
    opacity:.16;
    pointer-events:none;
    width: 100%;
    height: 100%;
  }
  .hero-grid{
    position:relative;
    display:grid;
    grid-template-columns:1.05fr .95fr;
    gap:40px;
    align-items:center;
    width: 100%;
  }
  .ayat{
    font-family:"Amiri",serif;
    font-size:26px;
    color:var(--gold-soft);
    margin-bottom:22px;
    letter-spacing:.02em;
  }
  .hero h2{
    font-family:"Fraunces",serif;
    font-weight:600;
    font-size:clamp(34px,4.6vw,54px);
    line-height:1.08;
    color:var(--parchment);
    margin:0 0 6px;
  }
  .hero h2 .accent{
    font-style:italic;
    font-weight:500;
    color:var(--gold-soft);
    display:block;
  }
  .hero p.lede{
    max-width:480px;
    color:#C9D9CE;
    font-size:15px;
    margin:20px 0 30px;
  }
  .hero-actions{display:flex;gap:14px;flex-wrap:wrap}

  .hero-visual-wrap{
    position:relative;
    display:flex;
    justify-content:center;
    align-items:flex-end;
    min-height:480px;
  }
  .hero-visual-bg{
    position:absolute;
    inset:-60px; /* stretch slightly outside */
    background-size: cover;
    background-position: center;
    
    mask-image: radial-gradient(ellipse at center, rgba(0,0,0,1) 30%, rgba(0,0,0,0) 70%);
    z-index: 1;
    opacity: 0.85;
  }
  .hero-visual-content{
    position:relative;
    z-index:2;
    width: 100%;
    max-width:360px;
    margin-bottom: 40px;
  }
  .arch-card-inner{
    background:rgba(10,43,32,.7);
    backdrop-filter:blur(12px);
    border:1px solid rgba(231,199,126,.3);
    border-radius:24px;
    padding:24px;
    box-shadow:0 30px 60px rgba(6,26,19,.4);
  }
  .arch-card-inner .label{font-size:10.5px;text-transform:uppercase;letter-spacing:.12em;color:var(--gold-soft);font-weight:700}
  .arch-card-inner .value{font-family:"Fraunces",serif;font-size:26px;color:var(--parchment);margin:5px 0 2px}
  .arch-card-inner .sub{font-size:11.5px;color:#B7C9BE}

  .floaty-badge{
    position:absolute;
    background:var(--paper);
    color:var(--ink);
    border-radius:16px;
    padding:12px 14px;
    box-shadow:0 20px 40px rgba(6,26,19,.4);
    font-size:12px;
    display:flex;align-items:center;gap:9px;
    font-weight:700;
    z-index: 3;
  }
  .floaty-badge .dot{width:8px;height:8px;border-radius:50%;background:var(--jade-glow)}
  .badge-1{top:10%;left:0}
  .badge-2{bottom:25%;right:-10%}

  /* ============ ABOUT ============ */
  .about-grid{
    display:grid;
    grid-template-columns:.85fr 1.15fr;
    gap:64px;
    align-items:center;
  }
  /* removed */ .old-about-frame{
    position:relative;
    aspect-ratio:4/5;
    border-radius:220px 220px 24px 24px;
    background:var(--jade-900);
    padding:24px;
    background-size: cover;
    background-position: center;
    box-shadow:0 30px 60px rgba(6,26,19,.15);
  }
  .about-frame::before {
    content:"";
    position:absolute;inset:0;
    border-radius:220px 220px 24px 24px;
    background: linear-gradient(to top, rgba(10,43,32,0.9) 0%, transparent 70%);
    pointer-events: none;
  }
  .about-frame .lattice-inner{
    position:absolute;inset:20px;
    border:1px solid rgba(231,199,126,.5);
    border-radius:200px 200px 14px 14px;
    display:flex;align-items:flex-end;
    justify-content:center;
    padding:26px;
    z-index: 2;
    pointer-events: none;
  }
  .about-frame .cap{
    color:var(--gold-pale);
    font-size:12px;
    font-weight:700;
    letter-spacing:.08em;
    text-transform:uppercase;
  }
  .about-checks{
    display:grid;grid-template-columns:1fr 1fr;gap:16px 22px;
    margin:28px 0 34px;
  }
  .about-checks div{
    display:flex;gap:10px;align-items:flex-start;
    font-size:13.5px;font-weight:600;color:var(--ink);
  }
  .about-checks svg{flex:0 0 auto;margin-top:1px;color:var(--jade-800)}
  .about-grid p{color:var(--ink-soft);font-size:14.5px;max-width:520px}

  /* ============ WHY (feature cards) ============ */
  .why-band{background:var(--parchment-deep)}
  .why-grid{
    display:grid;grid-template-columns:repeat(3,1fr);gap:0;
    border-top:1px solid var(--line);
    border-left:1px solid var(--line);
  }
  .why-card{
    border-right:1px solid var(--line);
    border-bottom:1px solid var(--line);
    padding:36px 28px;
    background:transparent;
    transition:background .25s ease;
  }
  .why-card:hover{background:rgba(184,134,59,.08)}
  .why-num{
    font-family:"Fraunces",serif;font-style:italic;
    color:var(--gold);font-size:14px;margin-bottom:20px;display:block;
  }
  .why-card svg{color:var(--jade-800);margin-bottom:16px}
  .why-card h4{margin:0 0 8px;font-family:"Fraunces",serif;font-size:16px;font-weight:600}
  .why-card p{margin:0;font-size:12.5px;color:var(--ink-soft)}

  /* ============ STATS ============ */
  .stats{
    background:
      radial-gradient(ellipse 700px 400px at 15% 0%, rgba(231,199,126,.10), transparent 60%),
    linear-gradient(180deg,var(--jade-950),var(--jade-900));
    color:var(--parchment);
    padding:40px 0;
  }
  .stats-grid{
    display:grid;grid-template-columns:repeat(4,1fr);
    text-align:center;
  }
  .stats-grid > div{border-right:1px solid var(--line-on-dark);padding:0 20px}
  .stats-grid > div:last-child{border-right:none}
  .stat-value{
    font-family:"Fraunces",serif;font-weight:600;
    font-size:clamp(30px,3.6vw,42px);
    color:var(--gold-soft);
  }
  .stat-label{font-size:11.5px;color:#B7C9BE;margin-top:6px;letter-spacing:.04em}

  /* ============ SCHEDULE ============ */
  .schedule-head{display:flex;justify-content:space-between;align-items:flex-end;margin-bottom:44px; flex-wrap:wrap; gap:20px;}
  .kajian-grid{display:grid; grid-template-columns:repeat(auto-fit, minmax(320px, 1fr)); gap:30px;}
  .kcard{
    background:var(--paper);
    border:none;
    border-radius:24px;
    box-shadow: 0 15px 40px rgba(6,26,19,0.06);
    overflow:hidden;
    transition:transform .3s ease, box-shadow .3s ease;
    display: block; /* If link */
    color: inherit;
  }
  .kcard:hover{transform:translateY(-6px);box-shadow:0 25px 50px rgba(6,26,19,0.15)}
  .kcard-media{
    position:relative;height:150px;
    background:linear-gradient(140deg,var(--jade-800),var(--jade-950));
    
  }
  .kcard-media svg{position:absolute;inset:0;width:100%;height:100%}
  .ribbon{
    position:absolute;top:14px;left:14px;
    background:var(--gold-pale);color:var(--terracotta);
    font-size:10px;font-weight:800;letter-spacing:.05em;
    padding:6px 11px;border-radius:999px;text-transform:uppercase;
  }
  .kcard-save{
    position:absolute;top:12px;right:12px;
    width:32px;height:32px;border-radius:50%;
    background:rgba(10,43,32,.5);backdrop-filter:blur(4px);
    display:grid;place-items:center;color:var(--parchment);
  }
  .kcard-body{padding:20px}
  .kcard-body h4{margin:0 0 8px; font-family:"Amiri",serif; font-size:24px; color:var(--jade-950); line-height:1.3}
  .kcard-body .ustadz{font-family:"Amiri",serif; font-size:17px; color:var(--jade-800); font-weight:700; margin-bottom:16px}
  .kcard-meta{display:flex; gap:16px; font-size:13.5px; font-weight:600; color:var(--ink-soft); border-top:1px dashed var(--line); padding-top:16px}
  .kcard-meta span{display:flex;align-items:center;gap:6px}

  /* ============ TESTIMONI ============ */
  .testi-grid{display:grid; grid-template-columns:repeat(auto-fit, minmax(320px, 1fr)); gap:30px;}
  .tcard{
    background:var(--paper);
    border:none;
    border-radius:24px;
    box-shadow: 0 15px 40px rgba(6,26,19,0.06);
    padding:30px 26px;
    position:relative;
  }
  .tcard .mark{
    font-family:"Fraunces",serif;font-style:italic;font-size:52px;
    color:var(--gold-pale);position:absolute;top:14px;right:22px;line-height:1;
  }
  .stars{color:var(--gold);font-size:13px;letter-spacing:2px;margin-bottom:14px}
  .tcard p{font-family:"Amiri",serif; font-size:18px; line-height:1.7; color:var(--jade-950); margin:0 0 24px; position:relative; z-index:1}
  .tperson{display:flex;align-items:center;gap:12px}
  .tavatar{
    width:38px;height:38px;border-radius:50%;
    background:linear-gradient(140deg,var(--jade-700),var(--jade-950));
    color:var(--gold-soft);display:grid;place-items:center;
    font-family:"Fraunces",serif;font-weight:600;font-size:14px;
  }
  .tperson .name{font-family:"Amiri",serif; font-size:18px; font-weight:700; color:var(--jade-950);}
  .tperson .loc{font-size:13px; color:var(--ink-soft)}

  /* ============ CTA BAND ============ */
  .cta-band{
    background:linear-gradient(120deg,var(--gold-soft),var(--gold) 90%);
    border-radius:30px;
    padding:44px 46px;
    margin-top: 40px;
    margin-bottom: 40px;
    display:flex;align-items:center;justify-content:space-between;gap:24px;
    flex-wrap:wrap;
  }
  .cta-band h4{
    font-family:"Fraunces",serif;font-size:23px;margin:0 0 6px;color:var(--jade-950);
  }
  .cta-band p{margin:0;color:#5B4420;font-size:13px}
  .cta-band .btn-solid{background:var(--jade-950)}
  .cta-band .btn-outline{border-color:var(--jade-950);color:var(--jade-950)}

  /* ============ FOOTER ============ */
  footer{background:var(--jade-950);color:#B7C9BE;padding:50px 0 28px;margin-top:50px}
  .footer-grid{display:grid;grid-template-columns:1.4fr 1fr 1fr 1fr;gap:40px}
  .footer-brand h1{color:var(--parchment); font-family:"Fraunces",serif; font-size:19px; margin-top:0;}
  .footer-brand p{font-size:13px;max-width:280px;margin-top:14px}
  .footer-grid h5{color:var(--parchment);font-size:12.5px;text-transform:uppercase;letter-spacing:.1em;margin:0 0 16px}
  .footer-grid ul{list-style:none;padding:0;margin:0;display:grid;gap:10px;font-size:13px}
  .footer-bottom{display:flex;justify-content:space-between;padding-top:22px;font-size:12px;color:#7E9689;flex-wrap:wrap;gap:10px}

  @media (max-width:980px){
    .nav-content {
      display: none;
      flex-direction: column;
      position: absolute;
      top: 100%; left: 0; right: 0;
      background: var(--paper);
      padding: 24px;
      border-bottom: 1px solid var(--line);
      box-shadow: 0 10px 20px rgba(10,43,32,0.08);
      gap: 24px;
      align-items: flex-start;
    }
    .nav-content.active { display: flex; }
    .mobile-menu-btn { display: block; }
    .navlinks { display: flex; flex-direction: column; align-items: flex-start; gap: 16px; width: 100%; font-size: 15px; }
    .nav-cta { width: 100%; flex-direction: column; align-items: stretch; gap: 12px; }
    .nav-cta .btn { justify-content: center; }

    .hero{ min-height: 100vh; min-height: 100dvh; padding: 40px 0 0; align-items: stretch; display: flex; flex-direction: column; }
    .hero-grid{display:flex; flex-direction:column; flex:1; gap:20px;}
    .about-grid{grid-template-columns:1fr; gap:30px;}
    .hero-visual-wrap{ flex: 1; min-height: 350px; margin-top: 0; width: 100%; position: relative; }

    .hero-visual-bg {
        inset: -20px -20px 0 -20px;
        -webkit-mask-image: radial-gradient(ellipse at bottom, rgba(0,0,0,1) 40%, rgba(0,0,0,0) 80%);
        mask-image: radial-gradient(ellipse at bottom, rgba(0,0,0,1) 40%, rgba(0,0,0,0) 80%);
    }

    .badge-1{top:5%;left:-5%}
    .badge-2{bottom:10%;right:-5%}
    .why-grid{grid-template-columns:repeat(2,1fr)}
    .stats-grid{grid-template-columns:repeat(2,1fr);gap:24px 0}
    .stats-grid > div:nth-child(2){border-right:none}
    .kajian-grid,.testi-grid{grid-template-columns:1fr}
    .footer-grid{grid-template-columns:1fr 1fr}
  }

  @media (max-width:640px){
    .container { padding: 0 20px; }
    .hero h2 { font-size: 34px; line-height: 1.15; }
    .nav-cta { gap: 10px; }
    .btn { padding: 10px 16px; font-size: 13px; }
    .quick-grid{grid-template-columns:1fr}
    .why-grid{grid-template-columns:1fr; border-left:none;}
    .why-card { border-left:1px solid var(--line); }
    .stats-grid{grid-template-columns:1fr; gap:30px 0}
    .stats-grid > div{border-right:none; border-bottom:1px solid var(--line-on-dark); padding-bottom: 30px;}
    .stats-grid > div:last-child{border-bottom:none; padding-bottom:0;}
    .footer-grid{grid-template-columns:1fr}
    .about-frame { border-radius: 120px 120px 24px 24px; }
    .about-frame::before { border-radius: 120px 120px 24px 24px; }
  }

  /* Swup Transition Styles (No Animation) */
  html.is-animating .transition-fade {
      opacity: 1;
      transform: none;
  }
  .transition-fade {
      transition: none;
      opacity: 1;
      transform: none;
  }
</style>
</head>
<body>

<main id="swup" class="transition-fade">
<nav class="mainnav">
  <div class="container nav-inner">
    <a href="{{ url('/') }}" class="brand">
      <div class="brand-mark">
        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
          <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/>
          <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/>
        </svg>
      </div>
      <h1>Kajian<em>Ku</em></h1>
    </a>
    
    <button class="mobile-menu-btn" id="mobileMenuBtn">
      <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M3 12h18M3 6h18M3 18h18"/></svg>
    </button>

    <div class="nav-content" id="navContent">
      <div class="navlinks">
        <a href="{{ url('/') }}" data-path="/">Beranda</a>
        <a href="{{ url('/#about') }}" data-path="/#about">Tentang Kami</a>
        <a href="{{ url('/kajian') }}" data-path="/kajian">Jadwal Kajian</a>
        <a href="{{ url('/#cara-kerja') }}" data-path="/#cara-kerja">Cara Kerja</a>
      </div>
      <div class="nav-cta">
          @auth
              <div class="user-menu" id="userMenu">
                  <button type="button" class="nav-admin" style="background:none;border:none;font-family:inherit;font-size:14px;display:inline-flex;align-items:center;gap:6px;cursor:pointer;padding:0;color:var(--ink);">
                      <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color:var(--jade-900);">
                          <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                          <circle cx="12" cy="7" r="4"></circle>
                      </svg>
                      <b style="font-weight:600;">{{ auth()->user()->name }}</b>
                      <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color:var(--ink-soft); margin-left:-2px;"><polyline points="6 9 12 15 18 9"></polyline></svg>
                  </button>
                  <div class="user-dropdown">
                      @if(auth()->user()->role === 'user')
                          <a href="{{ url('/kajian-saya') }}">Kajian Saya</a>
                          <a href="{{ url('/tersimpan') }}">Favorit Kajian</a>
                      @elseif(auth()->user()->role === 'organizer')
                          <a href="{{ url('/organizer') }}">Dashboard Penyelenggara</a>
                      @elseif(auth()->user()->role === 'admin')
                          <a href="{{ url('/admin') }}">Dashboard Admin</a>
                      @endif
                      
                      <a href="{{ route('profile.edit') }}">Pengaturan Akun</a>
                      <hr>
                      <form method="POST" action="{{ route('logout') }}" style="margin:0;padding:0;">
                          @csrf
                          <button type="submit">Keluar</button>
                      </form>
                  </div>
              </div>
          @else
              <a href="{{ route('login') }}" class="btn btn-outline" style="padding:10px 20px">Masuk</a>
              <a href="{{ route('register') }}" class="btn btn-solid" style="padding:10px 20px">Daftar Sekarang</a>
          @endauth
      </div>
    </div>
  </div>
</nav>

@yield('content')

<footer>
  <div class="container">
    <div class="footer-grid">
      <div class="footer-brand">
        <h1 class="serif">Kajian<em style="color:var(--gold-soft);font-style:normal">Ku</em></h1>
        <p>Menghubungkan jamaah dengan kajian Islami terdekat dan ilmu yang bermanfaat untuk keseharian Anda.</p>
      </div>
      <div>
        <h5>Jelajah</h5>
        <ul><li><a href="{{ url('/') }}">Beranda</a></li><li><a href="#about">Tentang Kami</a></li><li><a href="{{ url('/kajian') }}">Jadwal Kajian</a></li><li><a href="#cara-kerja">Cara Kerja</a></li></ul>
      </div>
      <div>
        <h5>Untuk Penyelenggara</h5>
        <ul><li><a href="{{ route('register') }}">Daftarkan Masjid</a></li><li><a href="{{ route('login') }}">Dashboard Organizer</a></li><li><a href="#">Panduan</a></li></ul>
      </div>
      <div>
        <h5>Hubungi Kami</h5>
        <ul><li>+62 800 1234 567</li><li>info@kajiansystem.com</li><li>Yogyakarta, Indonesia</li></ul>
      </div>
    </div>
  </div>
</footer>

<script>
(function() {
    // Handle active link state based on URL
    function updateActiveState() {
        const currentPath = window.location.pathname;
        const currentHash = window.location.hash;
        const navLinks = document.querySelectorAll('.navlinks a');
        
        navLinks.forEach(link => {
            link.classList.remove('active');
            const targetPath = link.getAttribute('data-path');
            
            if (currentPath.includes('kajian') && targetPath === '/kajian') {
                link.classList.add('active');
            } else if (currentPath === '/') {
                if (currentHash) {
                    if (targetPath === '/' + currentHash) link.classList.add('active');
                } else {
                    if (targetPath === '/') link.classList.add('active');
                }
            }
        });
    }

    // Run on script execution (initial load and every HTMX swap)
    updateActiveState();

    // Prevent binding document listeners multiple times across HTMX swaps
    if (window.navEventsBound) return;
    window.navEventsBound = true;

    // Use event delegation on document so it survives HTMX DOM swaps
    document.addEventListener('click', function(e) {
        // 1. Mobile Menu Toggle
        const mobileBtn = e.target.closest('#mobileMenuBtn');
        if (mobileBtn) {
            const navContent = document.getElementById('navContent');
            if (navContent) navContent.classList.toggle('active');
            return;
        }
        
        // 2. Nav Link Click (Close menu & set active)
        const navLink = e.target.closest('.navlinks a');
        if (navLink) {
            const navContent = document.getElementById('navContent');
            if (navContent) navContent.classList.remove('active');
            
            const allLinks = document.querySelectorAll('.navlinks a');
            allLinks.forEach(l => l.classList.remove('active'));
            navLink.classList.add('active');
        }
        
        // 3. User Menu Toggle
        const userMenuBtn = e.target.closest('#userMenu > button');
        if (userMenuBtn) {
            e.preventDefault();
            const userMenu = document.getElementById('userMenu');
            if (userMenu) userMenu.classList.toggle('active');
            return;
        }
        
        // Close user dropdown if clicked outside
        if (!e.target.closest('#userMenu')) {
            const userMenu = document.getElementById('userMenu');
            if (userMenu) userMenu.classList.remove('active');
        }
    });

    window.addEventListener('hashchange', updateActiveState);
    document.addEventListener('turbo:render', updateActiveState);
})();
</script>
</main>
<script>
    const swup = new Swup();

    // Fix for Swup: run homepage geolocation check when visiting the homepage
    function runHomepageGeolocation() {
        if (window.location.pathname === '/') {
            const urlParams = new URLSearchParams(window.location.search);
            if (!urlParams.has('lat') && !urlParams.has('lng') && !sessionStorage.getItem('location_declined')) {
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(function(position) {
                        const lat = position.coords.latitude;
                        const lng = position.coords.longitude;
                        window.location.href = `/?lat=${lat}&lng=${lng}`;
                    }, function(error) {
                        sessionStorage.setItem('location_declined', 'true');
                    });
                }
            }
        }
    }

    // Run on initial load
    runHomepageGeolocation();
    
    // Run after every Swup page transition
    swup.hooks.on('page:view', () => {
        runHomepageGeolocation();
        
        // Perbarui event listener untuk navigasi aktif karena DOM ditukar oleh Swup
        if(typeof updateActiveState === 'function') updateActiveState();
    });

    // Global function for "Terdekat" button (since inline scripts inside <main> are ignored by Swup)
    window.requestLocation = function(btn) {
        let originalContent = btn.innerHTML;
        btn.innerHTML = '<svg style="width:16px; height:16px; animation: spin 1s linear infinite;" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Memuat...';
        btn.disabled = true;

        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                function(position) {
                    let lat = position.coords.latitude;
                    let lng = position.coords.longitude;
                    let currentUrl = new URL(window.location.href);
                    currentUrl.searchParams.set('nearby', '1');
                    currentUrl.searchParams.set('lat', lat);
                    currentUrl.searchParams.set('lng', lng);
                    // Reload strictly to bypass Swup and force standard load with parameters
                    window.location.href = currentUrl.toString();
                }, 
                function(error) {
                    let errMsg = 'Gagal mendapatkan lokasi.';
                    if(error.code === 1) errMsg = 'Akses lokasi ditolak oleh Anda.';
                    if(error.code === 2) errMsg = 'Posisi lokasi tidak tersedia.';
                    if(error.code === 3) errMsg = 'Waktu permintaan lokasi habis (timeout).';
                    alert(errMsg + ' Pastikan izin lokasi aktif pada browser Anda.');
                    btn.innerHTML = originalContent;
                    btn.disabled = false;
                }, 
                {
                    enableHighAccuracy: false,
                    timeout: 10000,
                    maximumAge: 60000
                }
            );
        } else {
            alert('Browser Anda tidak mendukung Geolocation.');
            btn.innerHTML = originalContent;
            btn.disabled = false;
        }
    };
</script>
</body>
</html>
