<!DOCTYPE html>
<html lang="it">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Aurora Immobiliare – Vendi il tuo immobile</title>
  <meta name="description" content="Trasformiamo il potenziale del tuo immobile in un'opportunità concreta. Valutazione gratuita, esperienza dal 1970." />
  <link rel="icon" href="/favicon.ico" />

  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400;700;900&display=swap" rel="stylesheet" />

  <!-- Leaflet CSS -->
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

  <!-- Tailwind CDN -->
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            'aurora-red': '#d32f2f',
            'aurora-red-dark': '#b71c1c',
          },
          fontFamily: {
            sans: ['Lato', 'sans-serif'],
            heading: ['Georgia', 'serif'],
          },
        }
      }
    }
  </script>

  <style>
    body { font-family: 'Lato', sans-serif; }

    .container { max-width: 1856px; margin: 0 auto; padding: 32px; width: 100%; }

    /* Form fields */
    .form-field {
      width: 100%;
      font-size: 0.8125rem;
      outline: none;
      transition: border-color 0.15s;
    }
    .field-hero {
      background: rgba(255,255,255,0.08);
      border: 1px solid transparent;
      color: #fff;
      padding: 8px 12px;
      border-radius: 2px;
    }
    .field-hero::placeholder { color: rgba(255,255,255,0.45); }
    .field-hero:focus { border-bottom-color: rgba(255,255,255,1); }

    .field-dark {
      border: none;
      border-bottom: 1px solid rgba(255,255,255,0.4);
      color: #fff;
      padding: 6px 4px;
      background: rgba(47,47,47,0.1);
      border-radius: 0;
    }
    .field-dark::placeholder { color: rgba(255,255,255,0.5); }
    .field-dark:focus { border-bottom-color: rgba(255,255,255,0.8); }

    .field-error-border,
    .field-error-border.field-hero,
    .field-error-border.field-dark {
      border-color: rgba(252,165,165,0.8) !important;
    }
    .field-error {
      font-size: 0.7rem;
      color: rgba(252,165,165,0.9);
      line-height: 1;
      display: block;
      margin-top: 2px;
    }

    /* Custom dropdown */
    .custom-select-wrap { position: relative; cursor: pointer; }
    .custom-select-trigger {
      width: 100%;
      display: flex;
      align-items: center;
      justify-content: space-between;
      background: transparent;
      border: none;
      color: #fff;
      font-size: 0.8125rem;
      font-family: inherit;
      padding: 0;
      cursor: pointer;
      outline: none;
    }
    .custom-select-trigger.placeholder { color: rgba(255,255,255,0.5); }
    .chevron {
      width: 10px;
      height: 6px;
      flex-shrink: 0;
      transition: transform 0.15s;
      opacity: 0.7;
    }
    .chevron.open { transform: rotate(180deg); }
    .custom-select-dropdown {
      position: absolute;
      top: calc(100% + 6px);
      left: 0;
      right: 0;
      background: rgba(47,47,47,1);
      border: 1px solid rgba(255,255,255,0.15);
      border-radius: 4px;
      z-index: 50;
      overflow: hidden;
      list-style: none;
      margin: 0;
      padding: 0;
      display: none;
    }
    .custom-select-dropdown.open { display: block; }
    .custom-select-option {
      padding: 8px 12px;
      font-size: 0.8125rem;
      color: rgba(255,255,255,0.85);
      cursor: pointer;
      transition: background 0.1s;
    }
    .custom-select-option:hover { background: rgba(255,255,255,0.1); }
    .custom-select-option.selected { color: #fff; font-weight: 600; }

    /* Custom radio/checkbox */
    .custom-radio {
      appearance: none;
      -webkit-appearance: none;
      width: 15px;
      height: 15px;
      border: 2px solid rgba(255,255,255,0.55);
      border-radius: 50%;
      flex-shrink: 0;
      cursor: pointer;
      position: relative;
    }
    .custom-radio::after {
      content: '';
      position: absolute;
      inset: 2px;
      border-radius: 50%;
      background: transparent;
      transition: background 0.15s;
    }
    .custom-radio:checked::after { background: #fff; }

    /* Submit button */
    .submit-btn {
      display: flex;
      align-items: center;
      gap: 8px;
      background: #d32f2f;
      color: #fff;
      font-size: 0.8125rem;
      font-weight: 700;
      padding: 7px 16px 7px 20px;
      border-radius: 999px;
      border: none;
      cursor: pointer;
      white-space: nowrap;
      transition: background 0.15s;
    }
    .submit-btn:hover:not(:disabled) { background: #b71c1c; }
    .submit-btn:disabled {
      cursor: not-allowed;
      background: rgba(255,255,255,0.12);
      color: rgba(255,255,255,0.4);
    }
    .submit-btn:disabled .submit-icon { background: rgba(255,255,255,0.1); }
    .submit-btn:disabled .submit-icon svg path { fill: rgba(255,255,255,0.4); }

    .submit-icon {
      display: flex;
      align-items: center;
      justify-content: center;
      width: 22px;
      height: 22px;
      border-radius: 50%;
      background: rgba(0,0,0,0.25);
      flex-shrink: 0;
    }

    /* Spinner */
    .spinner { animation: spin 0.8s linear infinite; }
    @keyframes spin { to { transform: rotate(360deg); } }

    /* Image hover zoom */
    .img-zoom { transition: transform 0.5s; }
    .img-zoom-wrap:hover .img-zoom { transform: scale(1.05); }
  </style>
</head>
<body class="bg-white">

<!-- ═══ HEADER ═══ -->
<header class="bg-[#d32f2f] py-3 px-6 flex items-center justify-center">
  <a href="/">
    <img src="/img/logo.svg" alt="Aurora Immobiliare" class="h-10" />
  </a>
</header>

<!-- ═══ HERO ═══ -->
<section class="relative flex items-center justify-center min-h-screen overflow-hidden">
  <!-- Background image -->
  <div class="absolute inset-0 bg-gray-600">
    <img src="/img/hero.jpg" alt="Immobile" class="object-cover w-full h-full" />
  </div>

  <!-- Dark overlay -->
  <div class="absolute inset-0 bg-black/35"></div>

  <!-- Watermark logo -->
  <div class="absolute inset-0 flex items-center justify-center overflow-hidden pointer-events-none select-none">
    <img src="/img/logo.svg" alt="" class="opacity-[0.06] w-[90%] max-w-[900px]" style="filter: brightness(10)" />
  </div>

  <!-- Content -->
  <div class="relative z-10 flex flex-col items-center w-full max-w-5xl px-6 py-16 mx-auto text-center">
    <h2 class="w-full mb-4 text-4xl font-black leading-tight text-white lg:text-5xl">
      Hai un immobile o un terreno da vendere?
    </h2>
    <p class="w-full mb-6 text-base text-white/80">
      Trasformiamo il potenziale del tuo immobile in un'opportunità concreta. Contattaci per una valutazione.
    </p>

    <!-- Dark panel -->
    <div class="w-full max-w-3xl p-5 rounded-sm" style="background: rgba(47,47,47,0.8)">
      <!-- CTA row -->
      <div class="grid grid-cols-2 gap-2.5 mb-2.5">
        <a href="#contattaci" class="bg-[#d32f2f] hover:bg-[#b71c1c] text-white font-bold px-6 py-2.5 rounded transition-colors text-sm">
          Richiedi una valutazione gratuita
        </a>
        <!-- Phone -->
        <a href="tel:0422411596" class="flex items-center justify-center text-sm font-semibold gap-2 text-white py-2" style="background: rgba(0,0,0,0.1)">
          <span class="flex items-center justify-center w-8 h-8 border rounded-full border-white/50 shrink-0">
            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
              <path d="M6.6 10.8c1.4 2.8 3.8 5.1 6.6 6.6l2.2-2.2c.3-.3.7-.4 1-.2 1.1.4 2.3.6 3.6.6.6 0 1 .4 1 1V20c0 .6-.4 1-1 1-9.4 0-17-7.6-17-17 0-.6.4-1 1-1h3.5c.6 0 1 .4 1 1 0 1.3.2 2.5.6 3.6.1.3 0 .7-.2 1L6.6 10.8z"/>
            </svg>
          </span>
          0422 411596
        </a>
      </div>

      <!-- Hero form -->
      <form id="hero-form" class="space-y-2.5" data-form-type="hero">
        <!-- Nome + Cognome -->
        <div class="grid grid-cols-2 gap-2.5">
          <div class="flex flex-col gap-0.5">
            <input class="form-field field-hero" type="text" name="nome" placeholder="Nome" />
            <span class="field-error" data-field="nome"></span>
          </div>
          <div class="flex flex-col gap-0.5">
            <input class="form-field field-hero" type="text" name="cognome" placeholder="Cognome" />
            <span class="field-error" data-field="cognome"></span>
          </div>
        </div>

        <!-- Email + Telefono -->
        <div class="grid grid-cols-2 gap-2.5">
          <div class="flex flex-col gap-0.5">
            <input class="form-field field-hero" type="email" name="email" placeholder="Email" />
            <span class="field-error" data-field="email"></span>
          </div>
          <div class="flex flex-col gap-0.5">
            <input class="form-field field-hero" type="text" name="telefono" inputmode="tel" placeholder="Telefono" />
            <span class="field-error" data-field="telefono"></span>
          </div>
        </div>

        <!-- Messaggio -->
        <div class="flex flex-col gap-0.5">
          <textarea class="form-field field-hero resize-none" name="messaggio" rows="3" placeholder="Descrivi brevemente il tuo immobile (metratura, numero locali, stato, ecc.)"></textarea>
          <span class="field-error" data-field="messaggio"></span>
        </div>

        <!-- Privacy + Submit -->
        <div class="flex flex-wrap items-center justify-between pt-1 gap-3">
          <div class="flex flex-col gap-0.5">
            <label class="flex items-center gap-2.5 cursor-pointer">
              <input type="checkbox" name="privacy" class="custom-radio" />
              <span class="text-xs leading-tight text-white/60">
                Cliccando su invia dichiari di aver preso visione e di accettare la nostra
                <a href="/privacy" class="underline hover:text-white">privacy policy</a>
              </span>
            </label>
            <span class="field-error" data-field="privacy"></span>
          </div>
          <button type="submit" class="submit-btn" disabled>
            <span class="btn-text">Invia</span>
            <span class="submit-icon">
              <svg class="icon-arrow" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
                <path d="M9 0C7.21997 0 5.47991 0.527841 3.99987 1.51677C2.51983 2.50571 1.36628 3.91131 0.685088 5.55585C0.00389956 7.20038 -0.17433 9.00998 0.172936 10.7558C0.520203 12.5016 1.37737 14.1053 2.63604 15.364C3.89471 16.6226 5.49836 17.4798 7.24419 17.8271C8.99002 18.1743 10.7996 17.9961 12.4442 17.3149C14.0887 16.6337 15.4943 15.4802 16.4832 14.0001C17.4722 12.5201 18 10.78 18 9C17.9975 6.61382 17.0485 4.3261 15.3612 2.63882C13.6739 0.95154 11.3862 0.00251984 9 0ZM12.9513 9.48981L10.1821 12.259C10.0522 12.3889 9.87602 12.4619 9.69231 12.4619C9.5086 12.4619 9.33241 12.3889 9.2025 12.259C9.0726 12.1291 8.99962 11.9529 8.99962 11.7692C8.99962 11.5855 9.0726 11.4093 9.2025 11.2794L10.7905 9.69231H5.53846C5.35485 9.69231 5.17876 9.61937 5.04893 9.48953C4.9191 9.3597 4.84616 9.18361 4.84616 9C4.84616 8.81639 4.9191 8.6403 5.04893 8.51046C5.17876 8.38063 5.35485 8.30769 5.53846 8.30769H10.7905L9.2025 6.72058C9.0726 6.59067 8.99962 6.41448 8.99962 6.23077C8.99962 6.04705 9.0726 5.87086 9.2025 5.74096C9.33241 5.61105 9.5086 5.53808 9.69231 5.53808C9.87602 5.53808 10.0522 5.61105 10.1821 5.74096L12.9513 8.51019C13.0157 8.57449 13.0668 8.65084 13.1016 8.73489C13.1365 8.81893 13.1544 8.90902 13.1544 9C13.1544 9.09098 13.1365 9.18107 13.1016 9.26511C13.0668 9.34916 13.0157 9.42551 12.9513 9.48981Z" fill="white"/>
              </svg>
              <svg class="icon-spinner spinner hidden" viewBox="0 0 18 18" xmlns="http://www.w3.org/2000/svg" width="18" height="18">
                <circle cx="9" cy="9" r="7" stroke="rgba(255,255,255,0.3)" stroke-width="2" fill="none"/>
                <path d="M9 2a7 7 0 0 1 7 7" stroke="white" stroke-width="2" fill="none" stroke-linecap="round"/>
              </svg>
            </span>
          </button>
        </div>

        <p class="submit-error text-xs text-red-300 hidden"></p>
        <p class="submit-success text-sm font-semibold text-green-300 hidden">Messaggio inviato con successo!</p>
      </form>
    </div>
  </div>
</section>

<!-- ═══ PERCHÉ SCEGLIERCI ═══ -->
<div class="bg-[#d32f2f] text-white pt-16">
  <section>
    <h2 class="text-white text-center font-bold text-2xl tracking-wide">Perché Sceglierci</h2>
  </section>
  <section class="py-8 px-6">
    <div class="container mx-auto max-w-6xl">
      <div class="grid grid-cols-1 md:grid-cols-3 divide-y md:divide-y-0 md:divide-x divide-gray-200 border border-gray-200 rounded">
        <!-- Card 1 -->
        <div class="p-8 flex flex-col gap-4 bg-white h-52 justify-between">
          <div class="w-12 h-12 text-[#d32f2f]">
            <svg viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-width="2.5" xmlns="http://www.w3.org/2000/svg">
              <rect x="10" y="8" width="28" height="34" rx="3"/>
              <path d="M18 8v-2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v2"/>
              <path d="M16 22h16M16 30h10"/>
              <circle cx="33" cy="33" r="7" fill="white" stroke-width="2"/>
              <path d="M30 33l2 2 4-4"/>
            </svg>
          </div>
          <p class="text-gray-800">Valutazione Gratuita</p>
        </div>
        <!-- Card 2 -->
        <div class="p-8 flex flex-col gap-4 bg-white h-52 justify-between">
          <div class="w-12 h-12 text-[#d32f2f]">
            <svg viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-width="2.5" xmlns="http://www.w3.org/2000/svg">
              <circle cx="24" cy="20" r="10"/>
              <path d="M24 10 C20 10 16 14 16 20"/>
              <path d="M14 32 C14 38 34 38 34 32" stroke-linecap="round"/>
              <circle cx="24" cy="20" r="3" fill="currentColor"/>
            </svg>
          </div>
          <p class="text-gray-800">Esperienza dal 1970</p>
        </div>
        <!-- Card 3 -->
        <div class="p-8 flex flex-col gap-4 bg-white h-52 justify-between">
          <div class="w-12 h-12 text-[#d32f2f]">
            <svg viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-width="2.5" xmlns="http://www.w3.org/2000/svg">
              <path d="M8 24 C8 14 14 8 24 8" stroke-linecap="round"/>
              <path d="M40 24 C40 34 34 40 24 40" stroke-linecap="round"/>
              <path d="M4 20 L8 24 L12 20" stroke-linecap="round" stroke-linejoin="round"/>
              <path d="M44 28 L40 24 L36 28" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
          </div>
          <p class="text-gray-800">Consulenza a 360°</p>
        </div>
      </div>
    </div>
  </section>
</div>

<!-- ═══ COSA TRATTIAMO ═══ -->
<section class="py-12 px-6">
  <div class="container mx-auto max-w-6xl">
    <h2 class="text-[#d32f2f] text-center font-bold text-2xl mb-8">Cosa trattiamo</h2>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-0">
      <!-- Card 1 -->
      <div class="relative flex justify-center items-center h-64 overflow-hidden img-zoom-wrap cursor-pointer">
        <div class="absolute inset-0 bg-gray-500">
          <img src="/img/residenziale.jpg" alt="Immobili residenziali" class="w-full h-full object-cover img-zoom opacity-80" />
        </div>
        <span class="relative z-10 text-white font-semibold text-lg drop-shadow">Immobili residenziali</span>
      </div>
      <!-- Card 2 -->
      <div class="relative flex justify-center items-center h-64 overflow-hidden img-zoom-wrap cursor-pointer">
        <div class="absolute inset-0 bg-gray-600">
          <img src="/img/commerciale.jpg" alt="Immobili ad uso commerciale" class="w-full h-full object-cover img-zoom opacity-80" />
        </div>
        <span class="relative z-10 text-white font-semibold text-lg drop-shadow">Immobili ad uso commerciale</span>
      </div>
      <!-- Card 3 -->
      <div class="relative flex justify-center items-center h-64 overflow-hidden img-zoom-wrap cursor-pointer">
        <div class="absolute inset-0 bg-gray-700">
          <img src="/img/terreni.jpg" alt="Terreni di varia tipologia" class="w-full h-full object-cover img-zoom opacity-80" />
        </div>
        <span class="relative z-10 text-white font-semibold text-lg drop-shadow">Terreni di varia tipologia</span>
      </div>
    </div>
  </div>
</section>

<!-- ═══ CONTATTACI ═══ -->
<section id="contattaci" class="grid grid-cols-1 lg:grid-cols-2">
  <!-- Mappa -->
  <div class="h-[500px] lg:h-auto min-h-[400px] bg-gray-200">
    <div id="map" class="w-full h-full"></div>
  </div>

  <!-- Form -->
  <form id="contact-form" class="bg-[#d32f2f] p-8 lg:p-12 flex flex-col justify-center" data-form-type="contact">
    <h2 class="mb-2 text-3xl font-bold text-white">Contattaci</h2>
    <p class="mb-8 text-sm text-white/80">Compila il modulo per chiedere maggiori informazioni</p>

    <div class="space-y-2.5 mb-8">
      <!-- Nome + Cognome -->
      <div class="grid grid-cols-2 gap-2.5">
        <div class="flex flex-col gap-0.5">
          <input class="form-field field-dark" type="text" name="nome" placeholder="Nome" />
          <span class="field-error" data-field="nome"></span>
        </div>
        <div class="flex flex-col gap-0.5">
          <input class="form-field field-dark" type="text" name="cognome" placeholder="Cognome" />
          <span class="field-error" data-field="cognome"></span>
        </div>
      </div>

      <!-- Email + Telefono -->
      <div class="grid grid-cols-2 gap-2.5">
        <div class="flex flex-col gap-0.5">
          <input class="form-field field-dark" type="email" name="email" placeholder="Email" />
          <span class="field-error" data-field="email"></span>
        </div>
        <div class="flex flex-col gap-0.5">
          <input class="form-field field-dark" type="text" name="telefono" inputmode="tel" placeholder="Telefono" />
          <span class="field-error" data-field="telefono"></span>
        </div>
      </div>

      <!-- Tipologia + Indirizzo -->
      <div class="grid grid-cols-2 gap-2.5 relative z-20">
        <div class="flex flex-col gap-0.5">
          <div class="custom-select-wrap field-dark" id="tipologia-wrap">
            <button type="button" class="custom-select-trigger placeholder" id="tipologia-trigger">
              <span id="tipologia-label">Tipologia di Immobile</span>
              <svg class="chevron" id="tipologia-chevron" viewBox="0 0 10 6" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M1 1l4 4 4-4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
            </button>
            <ul class="custom-select-dropdown" id="tipologia-dropdown">
              <li class="custom-select-option" data-value="Residenziale">Residenziale</li>
              <li class="custom-select-option" data-value="Commerciale">Commerciale</li>
              <li class="custom-select-option" data-value="Terreno">Terreno</li>
            </ul>
            <input type="hidden" name="tipologia" id="tipologia-value" />
          </div>
          <span class="field-error" data-field="tipologia"></span>
        </div>
        <div class="flex flex-col gap-0.5">
          <input class="form-field field-dark" type="text" name="indirizzo" placeholder="Indirizzo dell'Immobile" />
          <span class="field-error" data-field="indirizzo"></span>
        </div>
      </div>

      <!-- Messaggio -->
      <div class="flex flex-col gap-0.5">
        <textarea class="form-field field-dark resize-none" name="messaggio" rows="3" placeholder="Descrivi brevemente il tuo immobile (metratura, numero locali, stato, ecc.)"></textarea>
        <span class="field-error" data-field="messaggio"></span>
      </div>

      <!-- Privacy + Submit -->
      <div class="flex flex-wrap items-center justify-between pt-1 gap-3">
        <div class="flex flex-col gap-0.5">
          <label class="flex items-center gap-2.5 cursor-pointer">
            <input type="checkbox" name="privacy" class="custom-radio" />
            <span class="text-xs leading-tight text-white/70">
              Cliccando su invia dichiari di aver preso visione e di accettare la nostra
              <a href="/privacy" class="underline hover:text-white">privacy policy</a>
            </span>
          </label>
          <span class="field-error" data-field="privacy"></span>
        </div>
        <button type="submit" class="submit-btn" disabled>
          <span class="btn-text">Invia</span>
          <span class="submit-icon">
            <svg class="icon-arrow" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
              <path d="M9 0C7.21997 0 5.47991 0.527841 3.99987 1.51677C2.51983 2.50571 1.36628 3.91131 0.685088 5.55585C0.00389956 7.20038 -0.17433 9.00998 0.172936 10.7558C0.520203 12.5016 1.37737 14.1053 2.63604 15.364C3.89471 16.6226 5.49836 17.4798 7.24419 17.8271C8.99002 18.1743 10.7996 17.9961 12.4442 17.3149C14.0887 16.6337 15.4943 15.4802 16.4832 14.0001C17.4722 12.5201 18 10.78 18 9C17.9975 6.61382 17.0485 4.3261 15.3612 2.63882C13.6739 0.95154 11.3862 0.00251984 9 0ZM12.9513 9.48981L10.1821 12.259C10.0522 12.3889 9.87602 12.4619 9.69231 12.4619C9.5086 12.4619 9.33241 12.3889 9.2025 12.259C9.0726 12.1291 8.99962 11.9529 8.99962 11.7692C8.99962 11.5855 9.0726 11.4093 9.2025 11.2794L10.7905 9.69231H5.53846C5.35485 9.69231 5.17876 9.61937 5.04893 9.48953C4.9191 9.3597 4.84616 9.18361 4.84616 9C4.84616 8.81639 4.9191 8.6403 5.04893 8.51046C5.17876 8.38063 5.35485 8.30769 5.53846 8.30769H10.7905L9.2025 6.72058C9.0726 6.59067 8.99962 6.41448 8.99962 6.23077C8.99962 6.04705 9.0726 5.87086 9.2025 5.74096C9.33241 5.61105 9.5086 5.53808 9.69231 5.53808C9.87602 5.53808 10.0522 5.61105 10.1821 5.74096L12.9513 8.51019C13.0157 8.57449 13.0668 8.65084 13.1016 8.73489C13.1365 8.81893 13.1544 8.90902 13.1544 9C13.1544 9.09098 13.1365 9.18107 13.1016 9.26511C13.0668 9.34916 13.0157 9.42551 12.9513 9.48981Z" fill="white"/>
            </svg>
            <svg class="icon-spinner spinner hidden" viewBox="0 0 18 18" xmlns="http://www.w3.org/2000/svg" width="18" height="18">
              <circle cx="9" cy="9" r="7" stroke="rgba(255,255,255,0.3)" stroke-width="2" fill="none"/>
              <path d="M9 2a7 7 0 0 1 7 7" stroke="white" stroke-width="2" fill="none" stroke-linecap="round"/>
            </svg>
          </span>
        </button>
      </div>

      <p class="submit-error text-xs text-red-300 hidden"></p>
      <p class="submit-success text-sm font-semibold text-green-300 hidden">Messaggio inviato con successo!</p>
    </div>

    <!-- Phone -->
    <a href="tel:0422411596" class="flex items-center justify-center text-sm font-semibold gap-2 text-white py-2" style="background: rgba(47,47,47,0.1)">
      <span class="flex items-center justify-center w-8 h-8 border rounded-full border-white/50 shrink-0">
        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
          <path d="M6.6 10.8c1.4 2.8 3.8 5.1 6.6 6.6l2.2-2.2c.3-.3.7-.4 1-.2 1.1.4 2.3.6 3.6.6.6 0 1 .4 1 1V20c0 .6-.4 1-1 1-9.4 0-17-7.6-17-17 0-.6.4-1 1-1h3.5c.6 0 1 .4 1 1 0 1.3.2 2.5.6 3.6.1.3 0 .7-.2 1L6.6 10.8z"/>
        </svg>
      </span>
      0422 411596
    </a>
  </form>
</section>

<!-- ═══ FOOTER ═══ -->
<footer class="text-white border-t border-gray-200 bg-[#d32f2f]">
  <div class="container flex flex-col items-center justify-between max-w-6xl mx-auto text-sm sm:flex-row gap-3">
    <span>P.IVA 01118530268</span>
  </div>
</footer>

<!-- Leaflet JS -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
// ─── Leaflet Map ───────────────────────────────────────────────
(function () {
  var LAT = 45.6669, LNG = 12.2430;
  var map = L.map('map', { scrollWheelZoom: false }).setView([LAT, LNG], 16);

  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '© <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>',
    maxZoom: 19,
  }).addTo(map);

  // Fix default icon paths
  delete L.Icon.Default.prototype._getIconUrl;
  L.Icon.Default.mergeOptions({
    iconUrl: 'https://unpkg.com/leaflet@1.9.4/dist/images/marker-icon.png',
    iconRetinaUrl: 'https://unpkg.com/leaflet@1.9.4/dist/images/marker-icon-2x.png',
    shadowUrl: 'https://unpkg.com/leaflet@1.9.4/dist/images/marker-shadow.png',
  });

  L.marker([LAT, LNG])
    .addTo(map)
    .bindPopup('Aurora Immobiliare, Via Roma, Treviso')
    .openPopup();
})();

// ─── Form logic ────────────────────────────────────────────────
(function () {
  var phoneRe = /^[+\d\s\-().]{6,20}$/;
  var emailRe = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

  function validate(data, formType) {
    var errors = {};
    if (!data.nome)      errors.nome      = 'Il nome è obbligatorio';
    if (!data.cognome)   errors.cognome   = 'Il cognome è obbligatorio';
    if (!data.email)     errors.email     = "L'email è obbligatoria";
    else if (!emailRe.test(data.email)) errors.email = 'Email non valida';
    if (!data.telefono)  errors.telefono  = 'Il telefono è obbligatorio';
    else if (!phoneRe.test(data.telefono)) errors.telefono = 'Numero non valido';
    if (!data.messaggio) errors.messaggio = 'Il messaggio è obbligatorio';
    if (!data.privacy)   errors.privacy   = 'Devi accettare la privacy policy';
    if (formType === 'contact') {
      if (!data.tipologia) errors.tipologia = 'La tipologia è obbligatoria';
      if (!data.indirizzo)  errors.indirizzo  = "L'indirizzo è obbligatorio";
    }
    return errors;
  }

  function showErrors(form, errors) {
    form.querySelectorAll('.field-error').forEach(function (el) { el.textContent = ''; });
    form.querySelectorAll('.form-field, .custom-select-wrap').forEach(function (el) {
      el.classList.remove('field-error-border');
    });
    Object.keys(errors).forEach(function (field) {
      var errEl = form.querySelector('[data-field="' + field + '"]');
      if (errEl) errEl.textContent = errors[field];
      var input = form.querySelector('[name="' + field + '"]');
      if (input) input.classList.add('field-error-border');
      if (field === 'tipologia') {
        var wrap = form.querySelector('#tipologia-wrap');
        if (wrap) wrap.classList.add('field-error-border');
      }
    });
  }

  function clearErrors(form) {
    form.querySelectorAll('.field-error').forEach(function (el) { el.textContent = ''; });
    form.querySelectorAll('.field-error-border').forEach(function (el) {
      el.classList.remove('field-error-border');
    });
  }

  function setLoading(form, loading) {
    var btn = form.querySelector('button[type="submit"]');
    var btnText = btn.querySelector('.btn-text');
    var arrow = btn.querySelector('.icon-arrow');
    var spinner = btn.querySelector('.icon-spinner');
    btn.disabled = loading;
    btnText.textContent = loading ? 'Invio...' : 'Invia';
    if (arrow)   arrow.classList.toggle('hidden', loading);
    if (spinner) spinner.classList.toggle('hidden', !loading);
  }

  function resetForm(form) {
    form.reset();
    // Reset tipologia dropdown
    var label = form.querySelector('#tipologia-label');
    var trigger = form.querySelector('#tipologia-trigger');
    var hidden = form.querySelector('#tipologia-value');
    if (label)   label.textContent = 'Tipologia di Immobile';
    if (trigger) trigger.classList.add('placeholder');
    if (hidden)  hidden.value = '';
    form.querySelectorAll('.custom-select-option').forEach(function (o) {
      o.classList.remove('selected');
    });
    var submitBtn = form.querySelector('button[type="submit"]');
    if (submitBtn) submitBtn.disabled = true;
  }

  function setupForm(formEl) {
    var formType = formEl.dataset.formType;
    var privacyBox = formEl.querySelector('[name="privacy"]');
    var submitBtn = formEl.querySelector('button[type="submit"]');
    var errMsg = formEl.querySelector('.submit-error');
    var sucMsg = formEl.querySelector('.submit-success');

    // Enable/disable submit based on privacy
    if (privacyBox) {
      privacyBox.addEventListener('change', function () {
        submitBtn.disabled = !privacyBox.checked;
      });
    }

    // Real-time validation on touched fields
    var touched = new Set();
    formEl.querySelectorAll('.form-field').forEach(function (input) {
      input.addEventListener('input', function () {
        touched.add(input.name);
        validateSingleField(formEl, input.name, input.value, formType, touched);
      });
    });

    formEl.addEventListener('submit', function (e) {
      e.preventDefault();
      errMsg.classList.add('hidden');
      sucMsg.classList.add('hidden');

      var data = {
        nome:      (formEl.querySelector('[name="nome"]')?.value || '').trim(),
        cognome:   (formEl.querySelector('[name="cognome"]')?.value || '').trim(),
        email:     (formEl.querySelector('[name="email"]')?.value || '').trim(),
        telefono:  (formEl.querySelector('[name="telefono"]')?.value || '').trim(),
        tipologia: (formEl.querySelector('[name="tipologia"]')?.value || '').trim(),
        indirizzo: (formEl.querySelector('[name="indirizzo"]')?.value || '').trim(),
        messaggio: (formEl.querySelector('[name="messaggio"]')?.value || '').trim(),
        privacy:   privacyBox ? privacyBox.checked : false,
        formType:  formType,
      };

      var errors = validate(data, formType);
      if (Object.keys(errors).length > 0) {
        showErrors(formEl, errors);
        return;
      }

      clearErrors(formEl);
      setLoading(formEl, true);

      fetch('send.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(data),
      })
      .then(function (res) { return res.json(); })
      .then(function (json) {
        setLoading(formEl, false);
        if (json.success) {
          sucMsg.classList.remove('hidden');
          resetForm(formEl);
          setTimeout(function () { sucMsg.classList.add('hidden'); }, 4000);
        } else {
          errMsg.textContent = json.error || "Errore durante l'invio. Riprova più tardi.";
          errMsg.classList.remove('hidden');
        }
      })
      .catch(function () {
        setLoading(formEl, false);
        errMsg.textContent = "Errore durante l'invio. Riprova più tardi.";
        errMsg.classList.remove('hidden');
      });
    });
  }

  function validateSingleField(form, name, value, formType, touched) {
    var data = {};
    data[name] = value.trim ? value.trim() : value;
    // Use full data for privacy field
    if (name === 'privacy') {
      var privacyBox = form.querySelector('[name="privacy"]');
      data.privacy = privacyBox ? privacyBox.checked : false;
    }
    // Fake-fill others so validate() doesn't flag them
    var allFields = ['nome','cognome','email','telefono','messaggio','tipologia','indirizzo'];
    allFields.forEach(function (f) {
      if (!(f in data)) data[f] = f === 'privacy' ? true : 'placeholder_ok';
    });
    data.privacy = data.privacy !== undefined ? data.privacy : true;

    // Only validate touched field
    var tmpErrors = validate(data, formType);
    var errEl = form.querySelector('[data-field="' + name + '"]');
    var inputEl = form.querySelector('[name="' + name + '"]');
    if (tmpErrors[name]) {
      if (errEl) errEl.textContent = tmpErrors[name];
      if (inputEl) inputEl.classList.add('field-error-border');
    } else {
      if (errEl) errEl.textContent = '';
      if (inputEl) inputEl.classList.remove('field-error-border');
    }
  }

  // ─── Tipologia Dropdown ───
  function setupDropdown() {
    var wrap     = document.getElementById('tipologia-wrap');
    var trigger  = document.getElementById('tipologia-trigger');
    var dropdown = document.getElementById('tipologia-dropdown');
    var chevron  = document.getElementById('tipologia-chevron');
    var label    = document.getElementById('tipologia-label');
    var hidden   = document.getElementById('tipologia-value');
    if (!wrap) return;

    trigger.addEventListener('click', function (e) {
      e.stopPropagation();
      var open = dropdown.classList.contains('open');
      dropdown.classList.toggle('open', !open);
      chevron.classList.toggle('open', !open);
    });

    dropdown.querySelectorAll('.custom-select-option').forEach(function (opt) {
      opt.addEventListener('click', function () {
        var val = opt.dataset.value;
        hidden.value = val;
        label.textContent = val;
        trigger.classList.remove('placeholder');
        dropdown.querySelectorAll('.custom-select-option').forEach(function (o) { o.classList.remove('selected'); });
        opt.classList.add('selected');
        dropdown.classList.remove('open');
        chevron.classList.remove('open');
        // Clear tipologia error
        var errEl = wrap.closest('form')?.querySelector('[data-field="tipologia"]');
        if (errEl) errEl.textContent = '';
        wrap.classList.remove('field-error-border');
      });
    });

    document.addEventListener('click', function (e) {
      if (!wrap.contains(e.target)) {
        dropdown.classList.remove('open');
        chevron.classList.remove('open');
      }
    });
  }

  // Init
  document.querySelectorAll('#hero-form, #contact-form').forEach(setupForm);
  setupDropdown();
})();
</script>

</body>
</html>
